<?php

namespace Model;

use Cool\DBManager;

class FileManager
{
    public function findAll()
    {
        $dbManager = DBManager::getInstance();
        $pdo = $dbManager->getPdo();
        $result = $pdo->query('SELECT * FROM files');
        
        return $result->fetchAll();
    }

    public function findById($id)
    {
        $dbManager = DBManager::getInstance();
        $pdo = $dbManager->getPdo();
        $sth = $pdo->prepare('SELECT * FROM files WHERE id = ?');
        $sth->execute([$id]);

        return $sth->fetch();
    }
    
    public function deleteById($id)
    {
        $dbManager = DBManager::getInstance();
        $pdo = $dbManager->getPdo();
        $sth = $pdo->prepare('SELECT * FROM files WHERE id = ?');
        $sth->execute([$id]);
        $file = $sth->fetch();
        
        $filename = './uploads/'.$file['id'].'_'.$file['name'];
        if (file_exists($filename)) {
            unlink($filename);
        }

        $sth = $pdo->prepare('DELETE FROM files WHERE id = ?');
        $sth->execute([$id]);

        return $true;
    }
    
    
/*    public function findAllBadass()
    {
       return DBManager::getInstance()->getPdo()->query('SELECT * FROM files')->fetchAll();
    }*/

    public function uploadFile($file_info, $filename)
    {
        $filename = $filename ?: $file_info['name'];
        $info = new \SplFileInfo($file_info['name']);
        $ext = $info->getExtension();
        if (!preg_match('/\\.'.$ext.'$/', $filename))
            $filename .= '.'.$ext;
        
        $dbManager = DBManager::getInstance();
        $pdo = $dbManager->getPdo();
        $now = new \DateTime();
        $sth = $pdo->prepare('INSERT INTO `files` VALUES (NULL, ?, ?, ?, ?)');
        $sth->execute([$filename, $now->format('Y-m-d H:i:s'), 0, 'file']);
        $id = $pdo->lastInsertId();
        
        $uploaddir = './uploads/';
        $uploadfile = $uploaddir . $id . '_' . basename($filename);
        move_uploaded_file($file_info['tmp_name'], $uploadfile);
    }
        public function replaceContent($filePath,$content){
            if(file_put_contents($filePath, $content) === false){ 
                $arr['status'] = 'failed';
                $arr['result'] = 'Save failed';
            } else{
                $arr['status'] = 'ok';
                $arr['result'] = 'Save completed';
            }
            $arr = json_encode($arr);
            return $arr;
    }
}
