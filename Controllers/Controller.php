<?php
namespace App\controllers;

abstract class Controller 
{
    public function render(string $fichier, array $donnees = [], string $template='default')
    {
        // On extrait le contenu de $donnees
        extract($donnees);

        //On démarre le buffer de sortie
        ob_start();
        //A partie de ce point toute sortie est consevée en mémoire

        //On crée le chemin vers la vue
        require_once ROOT.'/Views/'.$fichier.'.php';
        //Transfère le buffer dans contenu
        $contenu = ob_get_clean();
        //Template de la page
        require_once ROOT.'/Views/'.$template.'.php';
    }
}