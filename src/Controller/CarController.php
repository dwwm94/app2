<?php

namespace App\Controller;

use App\Entity\Auto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Car;
use App\Model\Driver;

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

        // $cars = [
        //     ["id"=>001, "marque"=>"Peugeot", "modele"=>5008, "pays"=>"France"],
        //     ["id"=>002, "marque"=>"Renault", "modele"=>"Megane", "pays"=>"Suisse"],
        //     ["id"=>003, "marque"=>"Fiat", "modele"=>"500", "pays"=>"Italie"]
        // ];
        $driver = new Driver();
        $cars = $driver->getCars();
        
        return $this->render('car/accueil.html.twig', [
           "tabCars" => $cars
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

    /**
     * @Route("/add", name="app_add")
     */
    public function add(){

        $em = $this->getDoctrine()->getManager();

        $auto1 = new Auto();
        $auto1->setMarque("Peugeot");
        $auto1->setModele("5008");
        $auto1->setPays("France");
        $auto1->setPrix(2200);
        $auto1->setDescription("Peugeot 5008 est une voiture résistante");

        $auto2 = new Auto();
        $auto2->setMarque("Renault");
        $auto2->setModele("Megane");
        $auto2->setPays("Suisse");
        $auto2->setPrix(5400);
        $auto2->setDescription("Mégane est une belle voiture.");
       
        $em->persist($auto1);
        $em->persist($auto2);

        $em->flush();

        return new Response("Voitures ajoutées!!!");
    }
}
