<?php

abstract class Controller
{
    /**
     *
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    protected function render($view, $values)
    {
        $this->twig->render($view, $values);
    }
}

