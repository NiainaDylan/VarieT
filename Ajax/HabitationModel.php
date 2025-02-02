<?php

namespace app\models;

use Exception;
use Flight;

class HabitationModel {

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllHabitation() {
        $sql="select*from agence_immobiliere_v_habitation_type";
        $stmt=$this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getHabitationById($id) {
        $sql="select*from agence_immobiliere_v_habitation_type where id_habitation=?";
        $stmt=$this->db->prepare($sql);
        $stmt->execute([$id]);

        $result=$stmt->fetchAll();
        foreach($result as $r) {
            return $r;
        }
    }

    function insertHabitation($type,$chambre,$loyer,$quartier,$description) {
        try {
            $sql="insert into agence_immobiliere_habitation (id_type,nb_chambre,loyer,quartier,descriptions) values (?,?,?,?,?)";
            $stmt=$this->db->prepare($sql);
            $stmt->execute([$type,$chambre,$loyer,$quartier,$description]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function fileName($file)
    {
        $fichier=explode(".",$file['name']);
        $date=time();
        $rep=$fichier[0].$date.".".$fichier[1];
        echo $rep;
        return $rep;
    }
    

    public function upload($file)
    {
        $dossier="assets/img/habitation/";
        $fichier = $dossier.$this->fileName($file);
        $taille = filesize($file['tmp_name']);
        $extensions = array('.png', '.gif', '.jpg', '.jpeg','.PNG','.GIF','.JPG','.JPEG');
        $extension = strrchr($file['name'], '.');
        //Début des vérifications de sécurité...
        if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
        {
            $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc';
            throw new $erreur;
        }

        //On formate le nom du fichier ici...
            $fichier = strtr($fichier,
            'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
            //$fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
            if(move_uploaded_file($file['tmp_name'], $fichier)) //Si
            {
            }
            
    }

    function uploadMultiple($files) {
        try {

            foreach($files['name'] as $index => $name) {
                $file = [
                    'name' =>$files['name'][$index],
                    'type' =>$files['type'][$index],
                    'tmp_name' =>$files['tmp_name'][$index],
                    'error' =>$files['error'][$index],
                    'size' =>$files['size'][$index],
                    
                ];
                $this->upload($file);
            }
        } catch(\Throwable $th) {
            throw $th;
        }
    }

    function getLastId() {
        $sql="select max(id_habitation) as id_habitation from agence_immobiliere_habitation";
        $stmt=$this->db->prepare($sql);
        $stmt->execute();
        $result=$stmt->fetchAll();
        foreach ($result as $r) {
            return $r['id_habitation'];
        }
    }

    function insertPhoto($id,$files) {
        try {

            $sql="insert into agence_immobiliere_photo (id_habitation,photo) values (?,?)";
            $stmt=$this->db->prepare($sql);
            foreach($files['name'] as $index => $name) {
                $file = [
                    'name' =>$files['name'][$index],
                    'type' =>$files['type'][$index],
                    'tmp_name' =>$files['tmp_name'][$index],
                    'error' =>$files['error'][$index],
                    'size' =>$files['size'][$index],
                    
                ];
                $stmt->execute([$id,$this->fileName($file)]);
            }
        } catch(\Throwable $th) {
            throw $th;
        }
    }

    public function insert($type,$chambre,$loyer,$quartier,$description,$files) {
        try {
            $this->uploadMultiple($files);
            $this->insertHabitation($type,$chambre,$loyer,$quartier,$description);
            $this->insertPhoto($this->getLastId(),$files);
            $this->db->commit();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function addPhoto($id,$files) {
        try {
            $this->uploadMultiple($files);
            $this->insertPhoto($id,$files);
        } catch (\Throwable $th) {

            throw $th;
        }

    }

    public function update($id,$type,$chambre,$loyer,$quartier,$description) {
        try {
            $sql="update agence_immobiliere_habitation set id_type=?,nb_chambre=?,loyer=?,quartier=?,descriptions=? where id_habitation=?";
            $stmt=$this->db->prepare($sql);
            $stmt->execute([$type,$chambre,$loyer,$quartier,$description,$id]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function deletePhotos($id) {
        try {
            $sql="delete from agence_immobiliere_photo where id_habitation=?";
            $stmt=$this->db->prepare($sql);
            $stmt->execute([$id]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id) {
        try {
            $this->deletePhotos($id);
            $sql="delete from agence_immobiliere_habitation where id_habitation=?";
            $stmt=$this->db->prepare($sql);
            $stmt->execute([$id]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}