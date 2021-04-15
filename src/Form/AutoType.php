<?php

namespace App\Form;

use App\Entity\Auto;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AutoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('marque')
            ->add('modele')
            ->add('pays', TextType::class, ['attr'=> ['placeholder'=>'Veuillez entrer le pays']])
            ->add('prix', NumberType::class, ['attr'=> ['placeholder'=>'Veuillez entrer le prix']])
            ->add('category', EntityType::class,['label'=>'Catégorie', 'class'=>Category::class,'choice_label'=>'name', 'attr'=>['class'=>'form-select']])
            ->add('image',FileType::class,['label'=>'image','attr'=>['class'=>'form-control']])
            ->add('description', TextareaType::class, ['attr'=> ['placeholder'=>'Veuillez entrer la description']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Auto::class,
        ]);
    }
}
