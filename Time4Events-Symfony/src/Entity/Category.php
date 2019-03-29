<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Event;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     * message = "Pole nie może być puste"
     * )
     * @Assert\Length(
     * min=5,
     * max=255,
     * minMessage="Nazwa jest za krótka - min. 5 znaków",
     * maxMessage="Nazwa jest za długa - max. 255 znaków"
     * )
     */
    private $name;
    


    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }
    
    public function __toString(){
        return $this->name;
    }
    
    /**
     * @return Event[]|ArrayCollection
     */
    public function getEvents()
    {
        return $this->events;
    }
    

}
