<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $categorie = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message: 'mail manquant')]
    #[Assert\Email(message: 'mail manquant')]
    private ?string $mail = null;

    #[ORM\Column(length: 250)]
    #[Assert\NotBlank(message: 'description à prévoir')]
    #[Assert\Length(
        min: 20,
        max: 250,
        minMessage: '20 à 250 caractères maximum',
        maxMessage: '20 à 250 caractères maximum'
    )]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateCreation = null;

    public function __construct()
    {
        // Date ouverture
        $this->dateCreation = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeImmutable
    {
        return $this->dateCreation;
    }
}
