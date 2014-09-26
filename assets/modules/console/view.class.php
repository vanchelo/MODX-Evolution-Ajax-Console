<?php

class View
{
    protected $viewsPath;
    protected $data = [];

    function __construct($path = null)
    {
        $this->viewsPath = $path ?: __DIR__ . '/views/';
    }

    public function share($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Получить отренедеренный шаблон с параметрами $data
     *
     * @param  string $template
     * @param  array $data
     *
     * @return string
     */
    public function render($template, $data = [])
    {
        try {
            $template = $this->preparePath($template);
            extract($data);
            empty($this->data) or extract($this->data);
            ob_start();
            include $template;

            return ob_get_clean();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    protected function preparePath($template = '')
    {
        $template = preg_replace('/[^a-z0-9._]+/is', '', (string) $template);
        $template = $this->viewsPath . str_replace('.', '/', $template) . '.php';

        return $template;
    }

    public function setViewsPath($path = '')
    {
        $this->viewsPath = $path;
    }

    public function getViewsPath()
    {
        return $this->viewsPath;
    }
}
