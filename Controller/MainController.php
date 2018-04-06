<?php

namespace Controller;

use Cool\BaseController;
use Model\FileManager;
use Model\FolderManager;

class MainController extends BaseController
{
    public function homeAction()
    {
        $folder_id = 0;
        
        if (!empty($_GET['location']))
            $folder_id = intval($_GET['location']);
        
        $fileManager = new FileManager();
        if ($folder_id != 0)
        {
            $folder = $fileManager->findById($folder_id);
            
            if ($folder === false || $folder['type'] !== 'folder')
            {
                header("HTTP/1.0 404 Not Found");
                exit();
            }
            
            $folder_name = $folder['name'];
        }
        else
            $folder_name = 'Home';

        $files = $fileManager->findByFolder($folder_id);
        
        $folderManager = new FolderManager();
        $breadcrumbs = $folderManager->getBreadcrumbs($folder_id);
        // var_dump('<pre>', $breadcrumbs);
        // die();
        return $this->render('home.html.twig', [
            'files'       => $files,
            'location'    => $folder_id,
            'folder_name' => $folder_name,
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}
