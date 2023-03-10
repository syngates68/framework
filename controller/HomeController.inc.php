<?php

require_once('Controller.inc.php');
require_once('model/Projets.php');
require_once('model/Components.php');
require_once('model/Regles.php');

class HomeController extends Controller
{
    public function get_index()
    {
        include 'view/home/home.inc.php';
    }

    public function post_new_project()
    {
        $project = Projets::insertProject('TEST');
        //On insère tous les composants de base du framework
        $c1 = Components::insertComponent($project->id(), 'buttons', 'Bouton par défaut', 'btn', 1);
        $c2 = Components::insertComponent($project->id(), 'buttons', 'Bouton principal', 'primary');
        $c3 = Components::insertComponent($project->id(), 'buttons', 'Bouton secondaire', 'secondary');
        $c4 = Components::insertComponent($project->id(), 'buttons', 'Bouton succès', 'success');
        $c5 = Components::insertComponent($project->id(), 'buttons', 'Bouton danger', 'danger');
        $c6 = Components::insertComponent($project->id(), 'buttons', 'Bouton alerte', 'warning');
        $c7 = Components::insertComponent($project->id(), 'buttons', 'Bouton information', 'info');
        $c8 = Components::insertComponent($project->id(), 'alerts', 'Message par défaut', 'alert', 1);
        $c9 = Components::insertComponent($project->id(), 'alerts', 'Message principal', 'primary');
        $c10 = Components::insertComponent($project->id(), 'alerts', 'Message secondaire', 'secondary');
        $c11 = Components::insertComponent($project->id(), 'alerts', 'Message succès', 'success');
        $c12 = Components::insertComponent($project->id(), 'alerts', 'Message danger', 'danger');
        $c13 = Components::insertComponent($project->id(), 'alerts', 'Message alerte', 'warning');
        $c14 = Components::insertComponent($project->id(), 'alerts', 'Message information', 'info');

        $components = [];
        array_push($components, $c1);
        array_push($components, $c2);
        array_push($components, $c3);
        array_push($components, $c4);
        array_push($components, $c5);
        array_push($components, $c6);
        array_push($components, $c7);
        array_push($components, $c8);
        array_push($components, $c9);
        array_push($components, $c10);
        array_push($components, $c11);
        array_push($components, $c12);
        array_push($components, $c13);
        array_push($components, $c14);

        for ($i = 0; $i < sizeof($components); $i++)
        {
            Regles::insertRegle($components[$i]->id(), 'color', '#000000', null);
            Regles::insertRegle($components[$i]->id(), 'background-color', '#FFFFFF', null);
            Regles::insertRegle($components[$i]->id(), 'font-size', 13, 'px');
        }
    }
}