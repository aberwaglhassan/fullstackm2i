<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller{

    /**
    *@Route("/", name="home_route")
    */
    public function display(){
        return $this->render("home.html.twig", array());
    }

}
