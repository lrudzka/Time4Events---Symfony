<?php

namespace App\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\User;
use App\Entity\Report;


/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    
    const STATUS_ACTIVE = "active";
    const STATUS_BLOCKED = "blocked";
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
     * minMessage="Tytuł jest za krótki - min. 5 znaków",
     * maxMessage="Tytuł jest za długi - max. 255 znaków"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(
     * message = "Pole nie może być puste"
     * )
     * @Assert\Length(
     * min=5,
     * max=5000,
     * minMessage="Tytuł jest za krótki - min. 5 znaków",
     * maxMessage="Tytuł jest za długi - max. 5000 znaków"
     * )
     * 
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     * message = "Pole nie może być puste"
     * )
     * @Assert\Length(
     * min=3,
     * max=255,
     * minMessage="Nazwa miejscowości jest za krótka - min. 3 znaki",
     * maxMessage="Nazwa miejscowości jest za długa - max. 255 znaków"
     * )
     */
    private $city;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * 
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     * message = "Wybierz wartość z listy"
     * )
     */
    private $category;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(
     * message="Pole nie może być puste"
     * )
     */
    private $startsAt;

   

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThan(
     * value="+5 hours",
     * message="Wydarzenie powinno być aktualne - min. 5 godzin do zakończenia"
     * )
     * @Assert\GreaterThan(
     * propertyPath="startsAt",
     * message="Data zakończenia musi być większa od daty rozpoczęcia wydarzenia"
     * )
     * 
     */
    private $endsAt;

   

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     * message = "Wybierz wartość z listy"
     * )
     */
    private $province;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     * message = "Pole nie może być puste"
     * )
     * @Assert\Length(
     * min=5,
     * max=255,
     * minMessage="Adres jest za krótki - min. 5 znaki",
     * maxMessage="Adres jest za długi - max. 255 znaków"
     * )
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     * message="Pole nie może być puste"
     * )
     * @Assert\Url(
     * message="Nieprawidłowy adres URL"
     * )
     */
    private $pictureUrl;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     * message="Pole nie może być puste"
     * )
     * @Assert\Url(
     * message="Nieprawidłowy adres URL"
     * )
     */
    private $eventUrl;
    
    /**
     *
     * @var User
     * 
     * @ORM\ManyToOne(targetEntity="User", inversedBy="events")
     */
    private $owner;
    
    /**
     *
     * @var Report[]|ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Report", mappedBy="event")
     * @ORM\JoinColumn(name="reports", referencedColumnName="id")
     */
    private $reports;

    

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
     * Get title
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    
    /**
     * Set title
     *
     * @param string $title
     *
     * @return Event
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get description
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Event
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get city
     * 
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Event
     */
    public function setCity(string $city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get createdAt
     * 
     * @return \Datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param \Datetime $createdAt
     *
     * @return Event
     */
    public function setCreatedAt(\DateTimeInterface $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get status
     * 
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     * 
     * @param string $status
     * 
     * @return Event
     */
    public function setStatus(string $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get updatedAt
     * 
     * @return \Datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt
     * 
     * @param \Datetime $updatedAt
     * 
     * @return Event
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get category
     * 
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set category
     * 
     * @param string $category 
     * 
     * @return Event
     */
    public function setCategory(string $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get startsAt
     * 
     * @return \Datetime
     */
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    /**
     * Set startsAt
     * 
     * @param \Datetime $startsAt
     * 
     * @return Event
     */
    public function setStartsAt(\DateTimeInterface $startsAt)
    {
        $this->startsAt = $startsAt;

        return $this;
    }

   


    /**
     * Get endsAt
     * 
     * @return \Datetime
     */
    public function getEndsAt()
    {
        return $this->endsAt;
    }
    
    /**
     * Set endsAt
     * 
     * @param \Datetime $endsAt
     * 
     * @return Event
     */
    public function setEndsAt(\DateTimeInterface $endsAt)
    {
        $this->endsAt = $endsAt;

        return $this;
    }

  
    /**
     * Get province
     * 
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set province
     * 
     * @param string $province
     * 
     * @return Event
     */
    public function setProvince(string $province)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get address
     * 
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set address
     * 
     * @param string $address
     * 
     * @return Event
     */
    public function setAddress(string $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get pictureUrl
     * 
     * @return string
     */
    public function getPictureUrl()
    {
        return $this->pictureUrl;
    }

    
    /**
     * Set pictureUrl
     * 
     * @param string $pictureUrl
     * 
     * @return Event
     */
    public function setPictureUrl(string $pictureUrl)
    {
        $this->pictureUrl = $pictureUrl;

        return $this;
    }

    /**
     * Get eventUrl
     * 
     * @return string
     */
    public function getEventUrl()
    {
        return $this->eventUrl;
    }

    /**
     * Set eventUrl
     * 
     * @param string $eventUrl
     * 
     * @return Event
     */
    public function setEventUrl(string $eventUrl)
    {
        $this->eventUrl = $eventUrl;

        return $this;
    }
    
    /**
     * 
     * @param User $owner
     * @return $this
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;
        return $this;
    }
    
    /**
     * 
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }
    
    /**
     * 
     * @return Report[]|ArrayCollection
     */
    public function getReports()
    {
        return $this->reports;
    }
    
    /**
     * 
     * @param Report $report
     * @return $this
     */
    public function addReport(Report $report)
    {
        $this->reports[] = $report;
        
        return $this;
    }
}
