<?php

namespace App\Entity;

//use App\Repository\ContactRepository;
//use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

///**
// * @var\Entity(repositoryClass=ContactRepository::class)
// */
class Contact
{
//    /**
//     * @ORM\Id
//     * @ORM\GeneratedValue
//     * @ORM\Column(type="integer")
//     */
//    private $id;

    /**
     * @var(type="string", length=255
     * @Assert\Length(min=3, max=100)
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @var(type="string", length=255)
     * @Assert\Length(min=3, max=100)
     * @Assert\NotBlank()
     *
     */
    private $lastname;

    /**
     * @var(type="string", length=255)
     *  @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $motif;

    /**
     * @var(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(min=8, max=100)
     */
    private $message;

//    public function getId(): ?int
//    {
//        return $this->id;
//    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
