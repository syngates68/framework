<?php

require_once('Model.php');

class Projets extends Model
{
    public static $_table = "projets";

    private $_id;
    private $_nom;
    private $_uniqid;
    private $_date_creation;

    public function __construct($id, $nom, $uniqid, $date_creation)
    {
        $this->set_id($id);
        $this->set_nom($nom);
        $this->set_uniqid($uniqid);
        $this->set_date_creation($date_creation);
    }

    public function id() { return $this->_id; }
    public function nom() { return $this->_nom; }
    public function uniqid() { return $this->_uniqid; }
    public function date_creation() { return $this->_date_creation; }
    
    public function set_id($id) { $this->_id = $id; }
    public function set_nom($nom) { $this->_nom = $nom; }
    public function set_uniqid($uniqid) { $this->_uniqid = $uniqid; }
    public function set_date_creation($date_creation) { $this->_date_creation = $date_creation; }

    public static function getByUniqid($uniqid)
    {
        $table = self::$_table;

        $s = self::$_db->prepare("SELECT * FROM $table WHERE uniqid = :uniqid");
        $s->bindValue(':uniqid', $uniqid, PDO::PARAM_STR);
        $s->execute();
        $data = $s->fetch(PDO::FETCH_ASSOC);

        if ($data)
            return new Projets($data['id'], $data['nom'], $data['uniqid'], $data['date_creation']);
        else
            return null;
    }

    public static function getById($id)
    {
        $table = self::$_table;

        $s = self::$_db->prepare("SELECT * FROM $table WHERE id = :id");
        $s->bindValue(':id', $id, PDO::PARAM_INT);
        $s->execute();
        $data = $s->fetch(PDO::FETCH_ASSOC);

        if ($data)
            return new Projets($data['id'], $data['nom'], $data['uniqid'], $data['date_creation']);
        else
            return null;
    }

    public static function insertProject($project_name)
    {
        $table = self::$_table;
        
        $s = self::$_db->prepare("INSERT INTO $table (nom, uniqid) VALUES (:nom, :uniqid)");
        $s->bindValue(':nom', $project_name);
        $s->bindValue(':uniqid', uniqid());
        $s->execute();

        return Projets::getById(parent::db()->lastInsertId());
    }
}