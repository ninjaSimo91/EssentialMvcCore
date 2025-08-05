<?php

namespace SWD\Core\Http;

use SWD\Core\App;
use SWD\Core\View;

class Response
{
    public App $app;

    private string $content = '';
    private int $statusCode = 200;
    public View $view;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function send(): void
    {
        http_response_code($this->statusCode);
        echo $this->content;
    }

    public function redirect($toUrl): void
    {
        header("location: $toUrl");
        exit;
    }

    // public function setContent($content): void
    // {
    //     $this->content = $content;
    // }

    public function setCode($code): void
    {
        $this->statusCode = $code;
    }

    public function set404($e): void
    {
        $this->setCode($e->getCode());
        $this->redirect('/');
        // $this->setContent(
        //     $this->view->render('error', [
        //         'code' => $e->getCode(),
        //         'errorMsg' => $e->getMessage()
        //     ])
        // );
    }
}
