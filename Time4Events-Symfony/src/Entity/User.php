<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Event;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
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
     *  message="Pole nie może być puste"
     * )
     * @Assert\Length(
     * min=5,
     * max=255,
     * minMessage="Tytuł jest za krótki - min. 5 znaków",
     * maxMessage="Tytuł jest za długi - max. 255 znaków"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(
     * message="Nieprawidłowy adres email"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Length(
     * min=5,
     * max=255,
     * minMessage="Hasło jest za krótkie - min. 5 znaki",
     * maxMessage="Hasło jest za długie - max. 255 znaków"
     * )
     */
    private $password;
    
    /**
     * @var Event[]|ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Event", mappedBy="owner")
     * $ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $events;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getName(): ?string
    {
        return $this->name;
    }
    
    public function setName(string $name): self
    {
        $this->name = $name;
        
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }
    
    

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    
    /**
     * Event constructor.
     */
    public function __construct() {
        $this->events = new ArrayCollection();
    }
    
    /**
     * @return Event[]|ArrayCollection
     */
    public function getEvents()
    {
        return $this->events;
    }
    
    /**
     * @param Event $event
     * @return $this
     */
    public function addEvent(Event $event)
    {
        $this->$events[] = $event;
        return $this;
    }
}
