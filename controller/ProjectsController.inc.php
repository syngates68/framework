<?php

require_once('Controller.inc.php');
require_once('model/Projets.php');
require_once('model/Components.php');
require_once('model/Regles.php');

class ProjectsController extends Controller
{
    public function get_viewer()
    {
        $uniqidprojet = (isset($_GET['idprojet'])) ? $_GET['idprojet'] : null;
        $projet = Projets::getByUniqid($uniqidprojet);
        $component = (isset($_GET['component'])) ? $_GET['component'] : 'alerts';
        $components = Components::getByIdProjet($projet->id(), $component);
        $main = Components::getMainByType($projet->id(), $component);
        include 'view/projects/viewer.inc.php';
    }

    public function post_editor()
    {
        $id_component = $_POST['component'];
        $component = Components::getById($id_component);
        $projet = Projets::getById($component->id_projet());
        $rules = Regles::getByIdComponent($id_component);
        $arr = [];
        if ($rules != null)
        {
            for ($i = 0; $i < sizeof($rules); $i++)
            {
                $arr[$rules[$i]->regle()] = $rules[$i]->valeur();
            }
        }
        include 'view/projects/editor.inc.php';
    }

    public function post_edit_component()
    {
        $regle = Regles::getByIdComponentAndRule($_POST['id_component'], $_POST['regle']);

        if ($regle != null)
        {
            $regle->changeValeur($_POST['valeur']);
            $regle->save();
        }
        else
            Regles::insertRegle($_POST['id_component'], $_POST['regle'], $_POST['valeur'], $_POST['unite']);
    }

    public function post_edit_classname()
    {
        $component = Components::getById($_POST['id_component']);

        if ($component != null)
        {
            $component->changeClassName($_POST['classname']);
            $component->save();
        }
    }
}