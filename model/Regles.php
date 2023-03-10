<?php

require_once('Model.php');

class Regles extends Model
{
    public static $_table = "regles";

    private $_id;
    private $_id_component;
    private $_regle;
    private $_valeur;
    private $_unite;
    private $_actif;

    public function __construct($id, $id_component, $regle, $valeur, $unite, $actif)
    {
        $this->set_id($id);
        $this->set_id_component($id_component);
        $this->set_regle($regle);
        $this->set_valeur($valeur);
        $this->set_unite($unite);
        $this->set_actif($actif);
    }

    public function id() { return $this->_id; }
    public function id_component() { return $this->_id_component; }
    public function regle() { return $this->_regle; }
    public function valeur() { return $this->_valeur; }
    public function unite() { return $this->_unite; }
    public function actif() { return $this->_actif; }
    
    public function set_id($id) { $this->_id = $id; }
    public function set_id_component($id_component) { $this->_id_component = $id_component; }
    public function set_regle($regle) { $this->_regle = $regle; }
    public function set_valeur($valeur) { $this->_valeur = $valeur; }
    public function set_unite($unite) { $this->_unite = $unite; }
    public function set_actif($actif) { $this->_actif = $actif; }

    public static function getByIdComponent($id_component)
    {
        $table = self::$_table;

        $s = self::$_db->prepare("SELECT * FROM $table WHERE id_component = :id_component AND actif = 1");
        $s->bindValue(':id_component', $id_component, PDO::PARAM_INT);
        $s->execute();
        $res = [];

        while ($row = $s->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT))
        {
            array_push($res, new Regles($row['id'], $row['id_component'], $row['regle'], $row['valeur'], $row['unite'], $row['actif']));
        }

        if (!empty($res))
            return $res;
        else
            return null;
    }

    public static function getByIdComponentAndRule($id_component, $regle)
    {
        $table = self::$_table;

        $s = self::$_db->prepare("SELECT * FROM $table WHERE id_component = :id_component AND regle = :regle AND actif = 1");
        $s->bindValue(':id_component', $id_component, PDO::PARAM_INT);
        $s->bindValue(':regle', $regle, PDO::PARAM_STR);
        $s->execute();
        $data = $s->fetch(PDO::FETCH_ASSOC);


        if ($data)
            return new Regles($data['id'], $data['id_component'], $data['regle'], $data['valeur'], $data['unite'], $data['actif']);
        else
            return null;
    }

    public static function insertRegle($id_component, $regle, $valeur, $unite)
    {
        $table = self::$_table;
        
        $s = self::$_db->prepare("INSERT INTO $table (id_component, regle, valeur, unite) VALUES (:id_component, :regle, :valeur, :unite)");
        $s->bindValue(':id_component', $id_component);
        $s->bindValue(':regle', $regle);
        $s->bindValue(':valeur', $valeur);
        $s->bindValue(':unite', $unite);
        $s->execute();
    }

    public function changeValeur($valeur)
    {
        $this->set_valeur($valeur);
    }

    public function save()
    {
        if ($this->id() != NULL)
        {
            $table = self::$_table;

            $sql = "UPDATE $table SET valeur = :valeur WHERE id = :id";

            $s = self::$_db->prepare($sql);
            $s->bindValue(':valeur', $this->valeur(), PDO::PARAM_STR);
            $s->bindValue(':id', $this->id(), PDO::PARAM_INT);
            $s->execute();
        }
    }
}