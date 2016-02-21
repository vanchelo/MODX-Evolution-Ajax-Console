<?php

require_once __DIR__ . '/view.class.php';
require_once __DIR__ . '/accesscheck.class.php';

class Console
{
    /**
     * Array with error code => string pairs.
     *
     * Used to convert error codes into human readable strings.
     *
     * @var array
     */
    public $error_map = array(
        E_ERROR => 'E_ERROR',
        E_WARNING => 'E_WARNING',
        E_PARSE => 'E_PARSE',
        E_NOTICE => 'E_NOTICE',
        E_CORE_ERROR => 'E_CORE_ERROR',
        E_CORE_WARNING => 'E_CORE_WARNING',
        E_COMPILE_ERROR => 'E_COMPILE_ERROR',
        E_COMPILE_WARNING => 'E_COMPILE_WARNING',
        E_USER_ERROR => 'E_USER_ERROR',
        E_USER_WARNING => 'E_USER_WARNING',
        E_USER_NOTICE => 'E_USER_NOTICE',
        E_STRICT => 'E_STRICT',
        E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
        E_DEPRECATED => 'E_DEPRECATED',
        E_USER_DEPRECATED => 'E_USER_DEPRECATED',
        E_ALL => 'E_ALL',
    );

    /**
     * Execution profile.
     *
     * @var array
     */
    public $profile = array(
        'memory' => 0,
        'memory_peak' => 0,
        'time' => 0,
        'time_total' => 0,
        'output' => '',
        'output_size' => 0,
        'error' => false,
    );
    /**
     * @var array Config
     */
    public $config;
    /**
     * @var View
     */
    public $view;
    /**
     * The application instance.
     *
     * @var DocumentParser
     */
    protected $modx;
    /**
     * @var AccessCheck
     */
    protected $access;
    /**
     * @var string
     */
    protected $path;

    /**
     * Create a new service provider instance
     *
     * @param DocumentParser $modx
     */
    public function __construct(DocumentParser & $modx)
    {
        $this->modx =& $modx;

        $this->registerConfig();
        $this->registerConsoleAccessService();

        if (!$this->access->check()) {
            die('Access denied');
        }

        $this->path = str_replace(MODX_BASE_PATH, '/', str_replace('\\', '/', __DIR__)) . '/';

        $this->registerViewService();
        $this->registerShutdownHandler();
    }

    /**
     *
     */
    protected function registerShutdownHandler()
    {
        register_shutdown_function(array($this, 'handleShutdown'));
    }

    /**
     *
     */
    protected function registerViewService()
    {
        $this->view = new View($this->config['viewsDir']);
        $this->view->share('path', $this->path);
    }

    /**
     *
     */
    protected function registerConfig()
    {
        $this->config = require __DIR__ . '/config/config.php';
    }

    /**
     *
     */
    protected function registerConsoleAccessService()
    {
        $this->access = new $this->config['check_access_class']($this);
    }

    /**
     * Adds one or multiple fields into profile.
     *
     * @param mixed $property Property name, or an array of name => value pairs.
     * @param mixed $value    Property value.
     */
    public function addProfile($property, $value = null)
    {
        if (is_array($property)) {
            foreach ($property as $key => $value) {
                $this->addProfile($key, $value);
            }

            return;
        }

        // Normalize properties
        $normalizer_name = 'normalize' . ucfirst($property);
        if (method_exists(__CLASS__, $normalizer_name)) {
            $value = call_user_func(array(__CLASS__, $normalizer_name), $value);
        }

        $this->profile[$property] = $value;
    }

    /**
     * Returns current profile.
     *
     * @return array
     */
    public function getProfile()
    {
        // Extend the profile with current data
        $this->addProfile(array(
            'memory' => memory_get_usage(true),
            'memory_peak' => memory_get_peak_usage(true),
            'time_total' => round((microtime(true) - MODX_START_TIME) * 1000),
        ));

        return $this->profile;
    }

    /**
     * @return null
     */
    public function handleShutdown()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->addProfile('error', error_get_last());

            echo json_encode($this->getProfile());
        }

        return null;
    }

    /**
     * Executes a code and returns current profile.
     *
     * @param string $code
     *
     * @return array
     */
    public function execute($code)
    {
        ini_set('display_errors', 0);

        // Execute the code
        ob_start();
        $modx =& $this->modx;
        $console_execute_start = microtime(true);
        eval($code);
        $console_execute_end = microtime(true);
        $output = ob_get_contents();
        ob_end_clean();

        $this->addProfile(array(
            'time' => round(($console_execute_end - $console_execute_start) * 1000),
            'output' => $output,
            'output_size' => strlen($output),
        ));
    }

    /**
     * Normalizes error profile.
     *
     * @param mixed $error Error object or array.
     * @param int   $type
     *
     * @return array|bool Normalized error array.
     */
    public function normalizeError($error, $type = 0)
    {
        // Set human readable error type
        if (isset($error['type'], $this->error_map[$error['type']])) {
            $error['type'] = $this->error_map[$error['type']];
        }

        if ($error['type'] === 'E_DEPRECATED') {
            return false;
        }

        // Validate and return the error
        if (isset($error['type'], $error['message'], $error['file'], $error['line'])) {
            return $error;
        } else {
            return $this->profile['error'];
        }
    }

    /**
     * Render console
     *
     * @return string
     */
    public function render()
    {
        return $this->view->render('console');
    }
}
