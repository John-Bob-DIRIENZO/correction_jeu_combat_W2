<?php

namespace App\Fram\BaseClasses;

use App\Fram\HTTPFoundation\HTTPRequest;
use App\Fram\HTTPFoundation\HTTPResponse;

abstract class BaseController
{
    protected HTTPRequest $HTTPRequest;
    protected HTTPResponse $HTTPResponse;
    protected array $params;
    private string $template = __DIR__ . '/../../../views/template.php';
    private string $viewsDir = __DIR__ . '/../../../views/';

    public function __construct(string $action, array $params = [])
    {
        $this->HTTPRequest = new HTTPRequest();
        $this->HTTPResponse = new HTTPResponse();
        $this->params = $params;

        $method = 'execute' . ucfirst($action);
        if (!is_callable([$this, $method])) {
            throw new \RuntimeException('L\'action "' . $method . '" n\'est pas définie sur ce module');
        }
        $this->$method();
    }

    public function render(string $title, array $vars, string $view): void
    {
        $view = $this->viewsDir . $view . '.view.php';
        foreach ($vars as $key => $value) {
            ${$key} = $value;
        }
        ob_start();
        require $view;
        $content = ob_get_clean();
        require $this->template;
        exit;
    }

    public function renderJSON($content): void
    {
        $this->HTTPResponse->addHeader('Content-Type: application/json');
        echo json_encode($content, JSON_PRETTY_PRINT);
        exit;
    }
}