<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use App\Entity\Category;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Description of AdminController
 *
 * @author lucyna
 */
class AdminController extends AbstractController {
    
    /**
     * @Route("/admin", name="admin_index")
     * 
     * @return Response
     */
    public function indexAction() {
        
        if (!($this->isGranted("ROLE_ADMIN")))
        {
            return $this->redirectToRoute("event_index");
        }
        
        return $this->render("Admin/index.html.twig");
    }
    
    /**
     * @Route("/admin/users", name="admin_users")
     * 
     * @return Response
     */
    public function usersAction() {
        
        if (!($this->isGranted("ROLE_ADMIN")))
        {
            return $this->redirectToRoute("event_index");
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        
        $users = $entityManager->getRepository(User::class)->findAll(); 

        return $this->render("Admin/users.html.twig", ["users" => $users]);
    }
    
    /**
     * @Route("/admin/users/addRoleAdmin/{id}", name="admin_add_role_admin");
     * 
     * @param type $userId
     * @return Response
     */
    public function addRoleAdminAction(User $user) {
        
        if (!($this->isGranted("ROLE_ADMIN")))
        {
            return $this->redirectToRoute("event_index");
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $entityManager->persist($user);
        $entityManager->flush();
        
        
        return $this->redirectToRoute("admin_users");
    }
    
    /**
     * @Route("/admin/users/removeRoleAdmin/{id}", name="admin_remove_role_admin");
     * 
     * @param User $user
     * @return type
     */
    public function removeRoleAdminAction(User $user) {
        
        if (!($this->isGranted("ROLE_ADMIN")))
        {
            return $this->redirectToRoute("event_index");
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        $user->setRoles(['ROLE_USER']);
        $entityManager->persist($user);
        $entityManager->flush();
        
        
        return $this->redirectToRoute("admin_users");
    }
    
    /**
     * @Route("/admin/categories", name="admin_categories")
     * 
     * @return Response
     */
    public function categoryListAction(){
        if (!($this->isGranted("ROLE_ADMIN")))
        {
            return $this->redirectToRoute("event_index");
        }
        
        $addForm = $this->createFormBuilder()
                ->setAction($this->generateUrl("admin_categories"))
                ->add("name", TextType::class, ["label"=>"nazwa"])
                ->add("submit", SubmitType::class, ["label"=>"Dodaj"])
                ->getForm();
                
        
        $entityManager = $this->getDoctrine()->getManager();
        $categories = $entityManager->getRepository(Category::class)->findCategories(); 
        
        return $this->render("Admin/categories.html.twig", 
                [
                    "categories" => $categories,
                    "addForm"=>$addForm->createView()
                ]);
    }
    
    /**
     * @Route("/admin/categoryRemove/{id}", name="admin_remove_category")
     * 
     * @param Category $category
     * @return Response
     */
    public function removeCategoryAction(Category $category) {
        if (!($this->isGranted("ROLE_ADMIN")))
        {
            return $this->redirectToRoute("event_index");
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();
        
        return $this->redirectToRoute("admin_categories");
    }
    
   
}
