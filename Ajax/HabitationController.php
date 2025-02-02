<?php

namespace app\controllers;


use Flight;

class HabitationController {

	public function __construct() {

	}

    public function getAllHabitation() {
        $data['habitations']=Flight::habitationModel()->getAllHabitation();
        //Flight::render('crud-habitation',$data);
        $habitations=Flight::habitationModel()->getAllHabitation();
        Flight::json($habitations);
    }

    public function formInsertHabitation() {
        $data['types']=Flight::typeModel()->getAllType();
        Flight::render('add-habitation',$data);
    }

    public function insertHabitation() {
        $data['error']="Insertion reussie";
        $data['types']=Flight::typeModel()->getAllType();
        try {
            $id_type=Flight::request()->data->type;
            $nb_chambre=Flight::request()->data->chambre;
            $loyer=Flight::request()->data->loyer;
            $quartier=Flight::request()->data->quartier;
            $description=Flight::request()->data->description;
            $file=$_FILES['images'];
            Flight::habitationModel()->insert($id_type,$nb_chambre,$loyer,$quartier,$description,$file);
        } catch(\Throwable $th) {
            $data['error']="Insertion echouee ".$th->getMessage();
        } finally {
            Flight::render("add-habitation",$data);
        }

    }

    public function deleteHabitation() {
        $data['error']="Suppression reussie";
        try {
            $id=Flight::request()->query['id'];
            Flight::habitationModel()->delete($id);
        } catch(\Throwable $th) {
            $data['error']="Suppression echouee ".$th->getMessage();
        }
        $data['habitations']=Flight::habitationModel()->getAllHabitation();
        Flight::render("crud-habitation",$data);
    }

    public function formUpdateHabitation() {
        $id=Flight::request()->query['id'];
        $habitation=Flight::habitationModel()->getHabitationById($id);
        $data['habitation']=$habitation;
        $data['types']=Flight::typeModel()->getAllType();
        Flight::render('update-habitation',$data);
    }

    public function updateHabitation() {
        $data['error']="Modification reussie";
        try {
            $id=Flight::request()->data->id;
            $id_type=Flight::request()->data->type;
            $nb_chambre=Flight::request()->data->chambre;
            $loyer=Flight::request()->data->loyer;
            $quartier=Flight::request()->data->quartier;
            $description=Flight::request()->data->description;
            Flight::habitationModel()->update($id,$id_type,$nb_chambre,$loyer,$quartier,$description);
        } catch(\Throwable $th) {
            $data['error']="Modification echouee ".$th->getMessage();
        } finally {
            $data['habitations']=Flight::habitationModel()->getAllHabitation();
            Flight::render("crud-habitation",$data);
        }
    }

    public function insertPhoto() {
        $data['error']="Ajout photo reussie";
        try {
            $id=Flight::request()->data->id;
            $file=$_FILES['images'];
            Flight::habitationModel()->addPhoto($id,$file);
        } catch(\Throwable $th) {
            $data['error']="Ajout photo echoue ".$th->getMessage();
        }
        $data['habitations']=Flight::habitationModel()->getAllHabitation();
        Flight::render("crud-habitation",$data);
    }

    public function listPhoto() {
        $id=Flight::request()->query['id'];
        $data['photos']=Flight::photoModel()->getAllPhotoByHabitation($id);
        $data['id']=$id;
        Flight::render('list-photos',$data);
    }

    public function deletePhoto() {
        $data['error']="Suppression image reussie";
        try {
            $habitation=Flight::request()->query['habitation'];
            $id=Flight::request()->query['id'];
            Flight::photoModel()->delete($id);
        } catch(\Throwable $th) {
            $data['error']="Suppression image echouee ".$th->getMessage();
        }
        $data['habitations']=Flight::habitationModel()->getAllHabitation();
        Flight::render("crud-habitation",$data);
    }

}