<?php

namespace app\traits;

trait View {
    protected $twig;

    protected function twig() {
        $loader = new \Twig\Loader\FilesystemLoader('../app/views');

        $this->twig = new \Twig\Environment($loader, [
            // 'cache' => '',
            'debug' => true
        ]);
    }

    protected function functions() {}

    protected function load() {
        $this->twig();

        $this->functions();
    }

    protected function view($view, $data) {
        $this->load();

        $template = $this->twig->load($view.'.html');

        return $template->display($data);
    }
}