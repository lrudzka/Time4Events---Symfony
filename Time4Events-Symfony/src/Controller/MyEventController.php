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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Event;
use App\Form\EventType;

/**
 * Description of MyEventController
 *
 * @author lucyna
 */
class MyEventController extends AbstractController {
    
    /**
     * @Route("/my", name="my_event_index")
     * 
     * @return Response
     */
    public function indexAction() 
    {
        if (!($this->isGranted("ROLE_USER")))
        {
            return $this->redirectToRoute("app_login");
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        
        $events = $entityManager->getRepository(Event::class)->findBy(['owner' => $this->getUser()]); 

        return $this->render("MyEvent/index.html.twig", ["events" => $events]);
    }
    
    /**
     * @Route("/my/event/add", name="my_event_add")
     * 
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request, ValidatorInterface $validator)
    {
        if (!($this->isGranted("ROLE_USER")))
        {
            return $this->redirectToRoute("app_login");
        }
                
        $event = new Event();
        
        $form = $this->createForm(EventType::class, $event);
        
        if ($request->isMethod("post"))
        {
            $form->handleRequest($request);
            
            $errors = $validator->validate($event);
            
            if (count($errors) == 0 )
            {
                 $event
                    ->setStatus(Event::STATUS_ACTIVE)
                    ->setOwner($this->getUser());
                       
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($event);
                $entityManager->flush();

                $this->addFlash("success", "Wydarzenie {$event->getTitle()} zostało dodane.");
                return $this->redirectToRoute("event_index");
            }
            
            $this->addFlash("error", "Nie udało się dodać wydarzenia");
            
        }
        
        
            
        return $this->render("MyEvent/add.html.twig", ["form"=>$form->createView()]);
    }
    
    /**
     * @Route("/my/event/edit/{id}", name="my_event_edit")
     * 
     * @param Request $request
     * @param Event $event
     * @return Response
     */
    public function editAction(Request $request, Event $event) {
        
        if (!($this->isGranted("ROLE_USER")))
        {
            return $this->redirectToRoute("app_login");
        }
        
        if ($event->getOwner() !== $this->getUser())
        {
            throw new AccessDeniedException();
        }
        
        $form = $this->createForm(EventType::class, $event);
        
         if ($request->isMethod("post")){
            $form->handleRequest($request);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();
            
            $this->addFlash("success", "Wydarzenie {$event->getTitle()} zostało zaktualizowane");
            return $this->redirectToRoute("event_index");
        }
        
        
        return $this->render("Event/edit.html.twig", ["form"=>$form->createView(), "event"=>$event]);
    }
    
    /**
     * @Route("/my/event/delete/{id}", name="my_event_delete", methods={"DELETE"})
     * 
     * @param Event $event
     * @return type
     */
    public function deleteAction(Event $event)
    {
        if (!($this->isGranted("ROLE_USER")))
        {
            return $this->redirectToRoute("app_login");
        }
        
        if ($event->getOwner() !== $this->getUser())
        {
            throw new AccessDeniedException();
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($event);
        $entityManager->flush();
        
        $this->addFlash("success", "Wydarzenie {$event->getTitle()} zostało usunięte");
        
        return $this->redirectToRoute("event_index");
    }
    
    /**
     * @Route("/my/event/details/{id}", name="my_event_details")
     * 
     * @param type $id
     * @return Response
     */
    public function detailsAction(Event $event) {

        
        $deleteForm = $this->createFormBuilder()
                ->setAction($this->generateUrl("my_event_delete", ["id"=>$event->getId()]))
                ->setMethod(Request::METHOD_DELETE)
                ->add("submit", SubmitType::class, ["label"=>"usuń"] )
                ->getForm();

        
        return $this->render(
                "MyEvent/details.html.twig", 
                [
                    "event"=>$event, 
                    "deleteForm"=>$deleteForm->createView(), 
                ]
                );
    }
}
