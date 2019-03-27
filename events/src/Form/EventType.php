<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Form;

use App\Entity\Event;
use App\Entity\Category;
use App\Entity\Province;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;



/**
 * Description of EventType
 *
 * @author lucyna
 */
class EventType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
               
   
        $builder
                ->add("title", TextType::class, ["label"=>"Nazwa"])
                ->add("category", EntityType::class, [
                    'class'=>Category::class,
                    'choice_name'=>"name",
                    'choice_value'=>"name",
                    'label'=>"Kategoria",
                    'placeholder'=>"Wybierz z listy"
                ])
                ->add("description", TextareaType::class, ["label"=>"Opis"])
                ->add("pictureUrl", UrlType::class, ["label"=>"Adres URL zdjęcia"])
                ->add("eventUrl", UrlType::class, ["label"=>"Adres URL wydarzenia"])
                ->add("startsAt", DateTimeType::class, 
                        [
                            "label"=>"Data rozpoczęcia",
                            "data"=>new \DateTime("+ 1 day")
                        ])
                ->add("endsAt", DateTimeType::class, 
                        [
                            "label"=>"Data zakończenia",
                            "data"=>new \DateTime("+1 day")
                        ])
                ->add("province", EntityType::class, [
                    'class'=>Province::class,
                    'choice_name'=>"name",
                    'choice_value'=>"name",
                    'label'=>"Województwo",
                    'placeholder'=>"Wybierz z listy"
                ])
                ->add("city", TextType::class, ["label"=>"Miejscowość"])
                ->add("address", TextType::class, ["label"=>"Adres"])
                ->add("submit", SubmitType::class, ["label"=>"Zapisz"]);
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(["data_class" => Event::class]);
    }
}
