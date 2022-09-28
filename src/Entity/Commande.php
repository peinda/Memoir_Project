<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $prixTotal = null;

    #[ORM\Column(length: 255)]
    private ?string $adresseLivraison = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCom = null;

    #[ORM\Column(length: 255)]
    private ?string $num_Commande = null;

    #[ORM\Column]
    private ?bool $etat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixTotal(): ?float
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(float $prixTotal): self
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function getAdresseLivraison(): ?string
    {
        return $this->adresseLivraison;
    }

    public function setAdresseLivraison(string $adresseLivraison): self
    {
        $this->adresseLivraison = $adresseLivraison;

        return $this;
    }

    public function getDateCom(): ?\DateTimeInterface
    {
        return $this->dateCom;
    }

    public function setDateCom(\DateTimeInterface $dateCom): self
    {
        $this->dateCom = $dateCom;

        return $this;
    }

    public function getNumCommande(): ?string
    {
        return $this->num_Commande;
    }

    public function setNumCommande(string $num_Commande): self
    {
        $this->num_Commande = $num_Commande;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
