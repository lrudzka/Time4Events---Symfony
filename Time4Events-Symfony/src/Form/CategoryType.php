<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Form;


use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;



/**
 * Description of EventType
 *
 * @author lucyna
 */
class CategoryType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add("name", TextType::class, ["label"=>"Podaj nazwę:"])
                ->add("submit", SubmitType::class, ["label"=>"Dodaj"]);
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(["data_class" => Category::class]);
    }
}
