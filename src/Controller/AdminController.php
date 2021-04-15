<?php

namespace App\Controller;

use App\Entity\Auto;
use App\Entity\Search;
use App\Form\AutoType;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdminController extends AbstractController
{
    /**
     * @Route("/add", name="app_add")
     */
    public function add(Request $request){

        $car = new Auto();
        $form = $this->createForm(AutoType::class, $car);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $file = $form->get('image')->getData();
            //dd($file);
            if($file){
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('images_directory'), $fileName);
            }
            $car->setImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush();

            $this->addFlash('success', 'Voiture enrégistrée');
            return $this->redirectToRoute("app_list");
        }

       return $this->render('admin/add.html.twig', [
            'form'=> $form->createView() ]);
    }

    /**
     * @Route("/list", name="app_list")
     */
    public function getAutos(Request $request){
        $search = new Search();
        $form = $this->createFormBuilder($search)
                ->add('mcle', TextType::class, ['label'=>'Rechercher', 'attr'=>['placeholder'=>'Rechercher...']])
                ->getForm();
        $form->handleRequest($request);
        //dd($request);
        $repo = $this->getDoctrine()->getRepository(Auto::class);
        $cars = $repo->findAll();
        //dd($cars);
        return $this->render("admin/list.html.twig", ["tabCars" => $cars, "form_search"=>$form->createView()]);
    }

    /**
     * @Route("/edit/{id}", name="app_edit")
     */
    public function editAuto(Auto $car, Request $request, EntityManagerInterface $em){
        // $car = $this->getDoctrine()
        //             ->getRepository(Auto::class)
        //             ->find($id);
        //$car = $autoRepo->find($id);
        $form = $this->createFormBuilder($car)
                ->add('marque')
                ->add('modele')
                ->add('pays')
                ->add('prix', NumberType::class)
                ->add('category', EntityType::class,['label'=>'Catégorie', 'class'=>Category::class,'choice_label'=>'name'])
                ->add('description', TextareaType::class)
                //->add('Modifier', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //$updateCar = $form->getData();
            //$em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("app_list");
        }
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
