<?php

namespace Cool;

class BaseController
{
    protected function render($view, $data = [])
    {
        global $twig;
        $template = $twig->load($view);
        $response = $template->render($data);

        return $response;
    }
    
    protected function redirect($url)
    {
        header('Location: '.$url);
        exit();
    }
    
    protected function redirectToRoute($route, $args = '')
    {
        $url = '?action='.$route;
        if ($args != '')
            $url .= '&'.$args;
        $this->redirect($url);
    }
}
