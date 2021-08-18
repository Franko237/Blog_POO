<?php
namespace App\Core;


use App\controllers\MainController;

/**
 * Routeur principal
 */

class Main 
{
    public function start()
    {
                // http://mes-annonces.test/annonces/details/brouette
                //http://mes-annonces.test/index.php?p=annonces/details/brouette

                var_dump($_GET);
                //On démarre la session
                session_start();
        
                //On récupère l'url
                $uri = $_SERVER['REQUEST_URI'];
        

                //On vérifie que uri n'est pas vide et se termine par un /
                if(!empty($uri) && $uri != "/" && $uri[-1] === "/")
                {
                    // On enleve le /
                    $uri = substr($uri,0,-1);
                    
                    //On envoie le code de redirection permanente
                    http_response_code(301);

                    //on redirige vers l'url sans /
                    header('Location: '.$uri);
                }
            // On gère les paramètres d'URL
            // p=controleur/methode/paramètres
            //On sépare les paramètres dans un tableau
            $params = [];
            if(isset($_GET['p']))
               $params = explode('/',$_GET['p']);
                
                    if($params[0] != ''){
                        //On a au moins 1 paramètre
                        $controller = '\\App\\Controllers\\'.ucfirst(array_shift($params)).'Controller';

                        //On instancie le controleur
                        $controller = new $controller();

                        //On récupère le 2ème paramètre d'URL
                        $action = (isset($params[0])) ? array_shift($params) : 'index';

                        if(method_exists($controller,$action)){
                            //Si il reste des paramètres on les passe à la méthode
                            (isset($params[0])) ? call_user_func_array([$controller,$action], $params) :  $controller->$action();
                        }else{
                            http_response_code(404);
                            echo "La page recherchée n'existe pas";
                        }
                        
                    }else{
                        //On n'a pas de paramètres 
                        //On instancie le controleur par défaut
                        $controller = new MainController;
                        
                        //On appel la méthode index
                        $controller->index();
                    }
        
    }
    
}