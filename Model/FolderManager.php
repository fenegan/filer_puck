<?php

namespace Model;

use Cool\DBManager;
use Model\FileManager;

class FolderManager
{
    public function createFolder($name, $location_id)
    {
        $dbManager = DBManager::getInstance();
        $pdo = $dbManager->getPdo();
        $now = new \DateTime();
        $sth = $pdo->prepare('INSERT INTO `files` VALUES (NULL, ?, ?, ?, ?)');
        $sth->execute([$name, $now->format('Y-m-d H:i:s'), $location_id, 'folder']);
    }
    
    public function getBreadcrumbs($folder_id)
    {
        if (intval($folder_id) === 0)
            return [];
        else
        {
            $fileManager = new FileManager();
            $folder = $fileManager->findById($folder_id);
        
            return array_merge($this->getBreadcrumbs($folder['folder_id']), [$folder]);
        }
    }
}
