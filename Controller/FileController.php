<?php

namespace Controller;

use Cool\BaseController;
use Model\FileManager;
use Model\FolderManager;

class FileController extends BaseController
{
    public function createFolderAction()
    {
        if (isset($_POST['folder_name']) && isset($_POST['location']))
        {
            $folderManager = new FolderManager();
            $folderManager->createFolder($_POST['folder_name'],
                                         $_POST['location']);
            
            if (intval($_POST['location']) != 0)                       
                $this->redirectToRoute('home', 'location='.$_POST['location']);
        }

        $this->redirectToRoute('home');
    }
    
    public function editAction()
    {
        if (isset($_GET['id']) && $id = intval($_GET['id']))
        {
            $fileManager = new FileManager();
            $file = $fileManager->findById($id);
            $path = './uploads/'.$file['id'].'_'.$file['name'];
            file_put_contents($path, json_decode($_POST['content']));
        }
        
        return json_decode($_POST['content']);
    }

    public function viewAction()
    {
        if (isset($_GET['id']) && $id = intval($_GET['id']))
        {
            $fileManager = new FileManager();
            $file = $fileManager->findById($id);
            $path = './uploads/'.$file['id'].'_'.$file['name'];
            $info = new \SplFileInfo($path);
            $ext = $info->getExtension();
            $url = '?action=download&id='.$file['id'];
            if (in_array($ext, ['txt', 'php']))
                $content = file_get_contents($path);
            else
                $content = '';
            if ($file)
                return $this->render('view.html.twig', [
                    'file'    => $file,
                    'path'    => $url,
                    'ext'     => $ext,
                    'content' => $content
                ]);
        }
        
        $this->redirectToRoute('home');
    }
    
    public function uploadAction()
    {
        if (isset($_FILES['file'])
            && isset($_POST['filename'])
            && isset($_POST['location']))
        {
            $fileManager = new FileManager();
            $fileManager->uploadFile($_FILES['file'],
                                     $_POST['filename'],
                                     $_POST['location']);
            
            if (intval($_POST['location']) != 0)                       
                $this->redirectToRoute('home', 'location='.$_POST['location']);
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
                if (isset($_GET['iframe']))
                {
                    $type = mime_content_type($filename);
                    header('Content-Type: '.$type);
                }
                else
                {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="'.basename($file['name']).'"');
                }
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
