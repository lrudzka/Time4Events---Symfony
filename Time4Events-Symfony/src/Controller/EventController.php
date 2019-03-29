<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use App\Entity\Event;
use App\Form\EventType;
use App\Entity\User;
/**
 * Description of EventController
 *
 * @author lucyna
 */
class EventController extends AbstractController {
    
    /**
     * @Route("/", name="event_index")
     * 
     * @return Response
     */
    public function indexAction() {
        
        $entityManager = $this->getDoctrine()->getManager();
        
        $events = $entityManager->getRepository(Event::class)->findActiveEvents(); 

        return $this->render("Event/index.html.twig", ["events" => $events]);
    }
    
    /**
     * @Route("/event/details/{id}", name="event_details")
     * 
     * @param type $id
     * @return Response
     */
    public function detailsAction(Event $event) {
        
        if ( ($event->getStatus() == Event::STATUS_BLOCKED) and (!$this->isGranted("ROLE_ADMIN")) ){
            return $this->redirectToRoute("event_index");
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        $createdBy = $entityManager->getRepository(User::class)->findOneBy(["id"=>$event->getOwner()]);

        return $this->render("Event/details.html.twig", ["event"=>$event, "createdBy"=>$createdBy ]);
    }
    
    
    
    
    
    
}