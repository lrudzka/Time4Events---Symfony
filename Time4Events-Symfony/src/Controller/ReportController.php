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
use App\Entity\Event;
use App\Entity\Report;

/**
 * Description of ReportController
 *
 * @author lucyna
 */
class ReportController extends AbstractController {
    
    /**
     * @Route("/event/report/{id}", name="event_report")
     * 
     * @param Event $event
     * @return Response
     */
    public function reportAction(Event $event){
        
        if (!($this->isGranted("ROLE_USER")))
        {
            $this->addFlash("error", "Żeby wysłać zgłoszenie musisz się zalogować");
        
            return $this->redirectToRoute("event_details", ["id"=>$event->getId()]);
        }
        
        $report = new Report();
        
        $report -> setEvent($event)
                -> setUser($this->getUser());
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($report);
        $entityManager->flush();
        
        $this->addFlash("success", "Zgłoszenie nadużycia zostało wysłane");
        
        return $this->redirectToRoute("event_details", ["id"=>$event->getId()]);
        
    }
    
    /**
     * @Route("/event/unreport/{id}", name="event_unreport")
     * 
     * @param Event $event
     * @return Response
     */
    public function unreportAction(Event $event){
        
        if (!($this->isGranted("ROLE_USER"))) 
        {
            return $this->redirectToRoute("event_index");
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        $report = $entityManager
                ->getRepository(Report::class)
                ->findOneBy([
                    "user"=>$this->getUser(),
                    "event"=>$event
                ]);
        
        if ($report)
        {
            $entityManager->remove($report);
            $entityManager->flush();
            $this->addFlash("success", "Zgłoszenie nadużycia zostało wycofane");
        }
        
        return $this->redirectToRoute("event_details", ["id"=>$event->getId()]);
    }
    
}
