<?php

namespace Controller;

use Cool\BaseController;
use Model\FileManager;

class MainController extends BaseController
{
    public function homeAction()
    {
        $fileManager = new FileManager();
        $files = $fileManager->findAll();
        return $this->render('home.html.twig', ['files' => $files]);
    }
}
