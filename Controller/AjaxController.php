<?php

namespace Controller;

use Cool\BaseController;
use Model\FileManager;

class AjaxController extends BaseController
{
    public function saveAction()
    {
        $fileManager = new FileManager();
        $jsonData = json_decode(file_get_contents('php://input'),true);
        $path = './uploads/'.$jsonData["id"].'_'.$jsonData["name"];
        return $fileManager->replaceContent($path,$jsonData['content']);
    }
}
