<?php
namespace App;

class View
{
    public function __construct(protected string $view, protected array $params = [])
    {
    }

    public static function make(string $view, array $params = []): self
    {
        return new static($view, $params);
    }
    public function render(bool $withLayout = false): string
    {
        extract($this->params, EXTR_SKIP);
        //foreach ($this->params as $key => $value) {
        //   $$key = $value;
        // }
        $viewPath = VIEW_PATH . '/' . $this->view . '.php';
        if (!file_exists($viewPath)) {
            throw new \Exception("View file not found: " . $viewPath);
        }
        ob_start();
        include $viewPath;
        $content = ob_get_clean();

        if ($withLayout) {
            $layoutPath = VIEW_PATH . '/Layouts/MainLayout.php';
            if (!file_exists($layoutPath)) {
                throw new \Exception("Layout file not found: " . $layoutPath);
            }
            ob_start();
            include $layoutPath;
            return ob_get_clean();
        }

        return $content;
    }

    public function __toString(): string
    {
        return $this->render(true);
    }
}