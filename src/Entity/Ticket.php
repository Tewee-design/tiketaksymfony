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

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message: 'Votre adresse e-mail est obligatoire.')]
    #[Assert\Email(message: 'Veuillez saisir une adresse e-mail valide.')]
    private ?string $auteur = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateOuverture = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateCloture = null;

    #[ORM\Column(length: 250)]
    #[Assert\NotBlank(message: 'La description est obligatoire.')]
    #[Assert\Length(min: 20, max: 250, minMessage: 'La description doit contenir au moins {{ limit }} caractères.', maxMessage: 'La description ne peut pas dépasser {{ limit }} caractères.')]
    private ?string $description = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'La catégorie est obligatoire.')]
    private ?Categorie $categorie = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etat $etat = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Responsable $responsable = null;

    public function __construct()
    {
        // Date ouverture
        $this->dateOuverture = new \DateTimeImmutable();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getAuteur(): ?string
    {
        return $this->auteur;
    }
    public function setAuteur(string $auteur): static
    {
        $this->auteur = $auteur;
        return $this;
    }
    public function getDateOuverture(): ?\DateTimeImmutable
    {
        return $this->dateOuverture;
    }
    public function setDateOuverture(\DateTimeImmutable $dateOuverture): static
    {
        $this->dateOuverture = $dateOuverture;
        return $this;
    }
    public function getDateCloture(): ?\DateTimeImmutable
    {
        return $this->dateCloture;
    }
    public function setDateCloture(?\DateTimeImmutable $dateCloture): static
    {
        $this->dateCloture = $dateCloture;
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
    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }
    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;
        return $this;
    }
    public function getEtat(): ?Etat
    {
        return $this->etat;
    }
    public function setEtat(?Etat $etat): static
    {
        $this->etat = $etat;
        return $this;
    }
    public function getResponsable(): ?Responsable
    {
        return $this->responsable;
    }
    public function setResponsable(?Responsable $responsable): static
    {
        $this->responsable = $responsable;
        return $this;
    }
}
