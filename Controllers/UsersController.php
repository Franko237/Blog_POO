<?php 
namespace App\Controllers;

use App\Core\Form;
use App\Models\UsersModel;
use App\Models\Model;

class UsersController extends Controller
{

    /**
    * Connexion des utilisateurs
     */
    public function login(){

        //On vérifie si le formulaire est complet
        if(Form::validate($_POST, ['email','password'])){ 
            //le formulaire est complet
            //On va chercher dans la base de données l'utilisateur avec l'email entré
            $usersModel = new UsersModel;
            $userArray = $usersModel->findOneByEmail(strip_tags($_POST['email']));

            //Si l'utilisateur n'existe pas
            if(!$userArray){ 
                //On envoie un message de session
                $_SESSION['erreur'] = 'L\'addresse e-mail et/ou le mot de passe est incorrect';
                header('Location: /users/login');
                exit;
            }

            //l'utilisateur existe
            $user = $usersModel->hydrate($userArray);

            //On vérifie si le mot de passe est correct 
            if(password_verify($_POST['password'], $user->getPassword()))
            { 
                //le mot de passe est bon
                //On créé la session
                $user->setSession();
                header('Location: /');
                exit;

            }else{ 
                //le mot de passe est mauvais
                $_SESSION['erreur'] = 'L\'addresse e-mail et/ou le mot de passe est incorrect';
                header('Location: /users/login');
                exit;
            }

        }
        $form = new Form;
        
        $form ->debutForm() 
              ->ajoutLabelFor('email','E-mail :')   
              ->ajoutInput('email', 'email', ['class' => 'form-control', 'id' => 'email']) 
              ->ajoutLabelFor('pass','Mot de passe :')
              ->ajoutInput('password', 'password', ['id' => 'pass', 'class' => 'form-control']) 
              ->ajoutBouton('Me connecter', ['class' => 'btn btn-primary'])   
              -> finForm();  
              
        $this->render('users/login', ['loginForm' => $form->create()]);

    } 

    /**
    * Inscription des utilisateurs
     */
    public function register()
    {

        //On vérifie si le formulaire est valide
        if(Form::validate($_POST, ['email','password']))
        {
            //On nettoie l'adresse email
            $email = strip_tags($_POST['email']);

            //On chiffre le mot de passe
            $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);

            //On hydrate l'utilisateur 
            $user = new UsersModel;

            $user->setEmail($email)
                 -> setPassword($pass)
                 ; 

            //On stoke l'utilisateur
            $user->create();
        }
        
        $form = new Form;

        $form->debutForm()
             ->ajoutLabelFor('email', 'E-mail :') 
             ->ajoutInput('email','email', ['id'=>'email', 'class' => 'form-control'])   
             ->ajoutLabelFor('pass', 'Mot de passe :') 
             ->ajoutInput('password','password', ['id'=>'pass', 'class' => 'form-control'])  
             ->ajoutBouton('M\'inscrire', ['class' => 'btn btn-primary']) 
             ->finForm()
             ;

        $this->render('users/register', ['registerForm' => $form->create()]);
    }

    /**
     * Déconnexion de l'utilisateur
     *
     * @return void
     */
    public function logout(){ 
        unset($_SESSION['user']);
        header('Location: '. $_SERVER['HTTP_REFERER']);
        exit;
    }
} 