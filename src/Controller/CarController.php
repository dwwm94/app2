<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
   /**
     * 
     *@Route("/car", name="car")
     */
    public function index(): Response
    {
        return $this->render('car/index.html.twig', [
             'controller_name' => 'CarController',
        ]);
    }

    /**
     * 
     *@Route("/", name="app_home")
     */
    public function accueil(): Response
    {
        return $this->render('car/accueil.html.twig', [
           
        ]);
    }

    /**
     * 
     *@Route("/about", name="app_about")
     */
    public function about(): Response
    {
        return $this->render('car/about.html.twig', [
            
        ]);
    }

    /**
     * 
     *@Route("/contact", name="app_contact")
     */
    public function contact(): Response
    {
        return $this->render('car/contact.html.twig', [
            
        ]);
    }
}