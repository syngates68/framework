<?php

require_once('Model.php');

class Components extends Model
{
    public static $_table = "components";

    private $_id;
    private $_id_projet;
    private $_type;
    private $_nom;
    private $_classname;
    private $_html_component;
    private $_html_content;
    private $_component_parent;
    private $_main;
    private $_actif;

    public function __construct($id, $id_projet, $type, $nom, $classname, $html_component, $html_content, $component_parent, $main, $actif)
    {
        $this->set_id($id);
        $this->set_id_projet($id_projet);
        $this->set_type($type);
        $this->set_nom($nom);
        $this->set_classname($classname);
        $this->set_html_component($html_component);
        $this->set_html_content($html_content);
        $this->set_component_parent($component_parent);
        $this->set_main($main);
        $this->set_actif($actif);
    }

    public function id() { return $this->_id; }
    public function id_projet() { return $this->_id_projet; }
    public function type() { return $this->_type; }
    public function nom() { return $this->_nom; }
    public function classname() { return $this->_classname; }
    public function html_component() { return $this->_html_component; }
    public function html_content() { return $this->_html_content; }
    public function component_parent() { return $this->_component_parent; }
    public function main() { return $this->_main; }
    public function actif() { return $this->_actif; }
    
    public function set_id($id) { $this->_id = $id; }
    public function set_id_projet($id_projet) { $this->_id_projet = $id_projet; }
    public function set_type($type) { $this->_type = $type; }
    public function set_nom($nom) { $this->_nom = $nom; }
    public function set_classname($classname) { $this->_classname = $classname; }
    public function set_html_component($html_component) { $this->_html_component = $html_component; }
    public function set_html_content($html_content) { $this->_html_content = $html_content; }
    public function set_component_parent($component_parent) { $this->_component_parent = $component_parent; }
    public function set_main($main) { $this->_main = $main; }
    public function set_actif($actif) { $this->_actif = $actif; }

    public static function getByIdProjet($id_projet, $type)
    {
        $table = self::$_table;

        $s = self::$_db->prepare("SELECT c.id, c.id_projet, c.type, c.nom, c.classname, c.html_component, c.html_content, c.component_parent, c.main, c.actif, (SELECT COUNT(*) FROM components WHERE component_parent = c.id) as nbr_enfants FROM components c WHERE c.id_projet = :id_projet AND c.type = :typecomp AND c.actif = 1");
        //$s = self::$_db->prepare("SELECT * FROM $table WHERE id_projet = :id_projet AND type = :typecomp AND actif = 1");
        $s->bindValue(':id_projet', $id_projet, PDO::PARAM_INT);
        $s->bindValue(':typecomp', $type, PDO::PARAM_STR);
        $s->execute();
        $res = [];

        while ($row = $s->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT))
        {
            array_push($res, [$row['id'], $row['id_projet'], $row['type'], $row['nom'], $row['classname'], $row['html_component'], $row['html_content'], $row['component_parent'], $row['main'], $row['actif'], $row['nbr_enfants']]);
        }

        if (!empty($res))
            return $res;
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
            return new Components($data['id'], $data['id_projet'], $data['type'], $data['nom'], $data['classname'], $data['html_component'], $data['html_content'], $data['component_parent'], $data['main'], $data['actif']);
        else
            return null;
    }

    public static function getMainByType($id_projet, $type)
    {
        $table = self::$_table;

        $s = self::$_db->prepare("SELECT * FROM $table WHERE id_projet = :id_projet AND type = :type AND main = 1");
        $s->bindValue(':id_projet', $id_projet, PDO::PARAM_INT);
        $s->bindValue(':type', $type, PDO::PARAM_STR);
        $s->execute();
        $data = $s->fetch(PDO::FETCH_ASSOC);

        if ($data)
            return new Components($data['id'], $data['id_projet'], $data['type'], $data['nom'], $data['classname'], $data['html_component'], $data['html_content'], $data['component_parent'], $data['main'], $data['actif']);
        else
            return null;
    }

    public function changeClassName($classname)
    {
        $this->set_classname($classname);
    }

    public function save()
    {
        if ($this->id() != NULL)
        {
            $table = self::$_table;

            $sql = "UPDATE $table SET classname = :classname WHERE id = :id";

            $s = self::$_db->prepare($sql);
            $s->bindValue(':classname', $this->classname(), PDO::PARAM_STR);
            $s->bindValue(':id', $this->id(), PDO::PARAM_INT);
            $s->execute();
        }
    }

    public static function insertComponent($project_id, $type, $nom, $classname, $main = 0)
    {
        $table = self::$_table;
        
        $s = self::$_db->prepare("INSERT INTO $table (id_projet, type, nom, classname, main) VALUES (:id_projet, :type, :nom, :classname, :main)");
        $s->bindValue(':id_projet', $project_id);
        $s->bindValue(':type', $type);
        $s->bindValue(':nom', $nom);
        $s->bindValue(':classname', $classname);
        $s->bindValue(':main', $main);
        $s->execute();

        return Components::getById(parent::db()->lastInsertId());
    }
}