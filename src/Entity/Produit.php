<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ApiResource(operations: [
    new Get(),
    new Put(),
    new Patch(),
    new Delete(),
    new GetCollection(),
    new Post(),
],
    routePrefix: '/admin',
    normalizationContext: ['groups' => ['produit:read']],
    denormalizationContext: ['groups' => ['produit:write']])]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['produit:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['produit:read', 'produit:write'])]
    private ?string $nom = null;

    #[ORM\Column]
    #[Groups(['produit:read', 'produit:write'])]
    private ?float $prix = null;

    #[ORM\Column]
    #[Groups(['produit:read', 'produit:write'])]
    private ?bool $etat = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['produit:read', 'produit:write'])]
    private $photo = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    private ?Categorie $categorie = null;

    #[ORM\ManyToMany(targetEntity: DetailCommande::class, inversedBy: 'produits')]
    private Collection $detailCommande;

    public function __construct()
    {
        $this->detailCommande = new ArrayCollection();
        $this->etat = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

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

    public function getPhoto(): string
    {
        return $this->photo;

    }

    public function setPhoto(string $photo): self
    {
      $this->photo = $photo;
      return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, DetailCommande>
     */
    public function getDetailCommande(): Collection
    {
        return $this->detailCommande;
    }

    public function addDetailCommande(DetailCommande $detailCommande): self
    {
        if (!$this->detailCommande->contains($detailCommande)) {
            $this->detailCommande->add($detailCommande);
        }

        return $this;
    }

    public function removeDetailCommande(DetailCommande $detailCommande): self
    {
        $this->detailCommande->removeElement($detailCommande);

        return $this;
    }
}
