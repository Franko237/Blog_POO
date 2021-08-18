<?php

namespace App\controllers; 

class MainController extends Controller
{
    public function index()
    {
        $this->render('main/home'); 
    }
}