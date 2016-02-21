<?php

class View
{
    /**
     * @var string
     */
    protected $viewsPath;
    /**
     * @var array
     */
    protected $data = array();

    /**
     * View constructor.
     *
     * @param string $path
     */
    public function __construct($path = null)
    {
        $this->viewsPath = $path ?: __DIR__ . '/views/';
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function share($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Получить отренедеренный шаблон с параметрами $data
     *
     * @param  string $template
     * @param  array  $data
     *
     * @return string
     */
    public function render($template, array $data = array())
    {
        try {
            $template = $this->preparePath($template);
            extract($data);
            count($this->data) === 0 or extract($this->data);
            ob_start();
            include $template;

            return ob_get_clean();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param string $template
     *
     * @return mixed|string
     */
    protected function preparePath($template = '')
    {
        $template = preg_replace('/[^a-z0-9._]+/is', '', (string) $template);
        $template = $this->viewsPath . str_replace('.', '/', $template) . '.php';

        return $template;
    }

    /**
     * @param string $path
     */
    public function setViewsPath($path = '')
    {
        $this->viewsPath = $path;
    }

    /**
     * @return string
     */
    public function getViewsPath()
    {
        return $this->viewsPath;
    }
}
