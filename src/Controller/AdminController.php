<?php

namespace App\Controller;

use App\Entity\Auto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdminController extends AbstractController
{
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

    /**
     * @Route("/list", name="app_list")
     */
    public function getAutos(){

        $repo = $this->getDoctrine()->getRepository(Auto::class);
        $cars = $repo->findAll();
        //dd($cars);
        return $this->render("car/list.html.twig", ["tabCars" => $cars]);
    }

    /**
     * @Route("/edit/{id}", name="app_edit")
     */
    public function editAuto(Auto $car, Request $request){
        // $car = $this->getDoctrine()
        //             ->getRepository(Auto::class)
        //             ->find($id);
        //$car = $autoRepo->find($id);
        $form = $this->createFormBuilder($car)
                ->add('marque')
                ->add('modele')
                ->add('pays')
                ->add('prix', NumberType::class)
                ->add('description', TextareaType::class)
                //->add('Modifier', SubmitType::class)
                ->getForm();
        return $this->render('admin/edit.html.twig', [
            'form_car'=> $form->createView(),
            'car'=>$car
        ]);
        
    }

    /**
     * @Route("/delete/{id}", name="app_delete")
     */
    public function deleteAuto($id){
        $em = $this->getDoctrine()->getManager();
        $car = $em->getRepository(Auto::class)->find($id);

        if(!$car){
            throw $this->createNotFoundException(
                'Aucune voiture ne correspond à votre demande'
            );
        }
        $em->remove($car);
        $em->flush();

        return $this->redirectToRoute("app_list");  
      }
}
