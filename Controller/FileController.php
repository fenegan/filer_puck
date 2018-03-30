<?php

namespace Controller;

use Cool\BaseController;
use Model\FileManager;

class FileController extends BaseController
{
    public function uploadAction()
    {
        if (isset($_FILES['file']) and isset($_POST['filename']))
        {
            $fileManager = new FileManager();
            $fileManager->uploadFile($_FILES['file'],
                                     $_POST['filename']);
        }
        
        $this->redirectToRoute('home');
    }
    
    public function downloadAction()
    {
        if (isset($_GET['id']) && $id = intval($_GET['id']))
        {
            $fileManager = new FileManager();
            $file = $fileManager->findById($id);
            $filename = './uploads/'.$file['id'].'_'.$file['name'];
            if (file_exists($filename)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($file).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filename));
                readfile($filename);
                exit;
            }
        }
        $this->redirectToRoute('home');
    }
    
    public function deleteAction()
    {
        if (isset($_GET['id']) && $id = intval($_GET['id']))
        {
            $fileManager = new FileManager();
            $file = $fileManager->deleteById($id);
        }
        $this->redirectToRoute('home');
    }
}
