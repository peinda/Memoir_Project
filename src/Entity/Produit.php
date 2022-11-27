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
    #[Groups(['produit:read', 'detail:write', 'detail:read', 'commentaire:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['produit:read', 'produit:write', 'detail:write', 'detail:read', 'commentaire:read'])]
    private ?string $nom = null;

    #[ORM\Column]
    #[Groups(['produit:read', 'produit:write', 'commentaire:read'])]
    private ?float $prix = null;

    #[ORM\Column]
    #[Groups(['produit:read', 'produit:write'])]
    private ?bool $etat = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['produit:read', 'produit:write'])]
    private $photo = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    private ?Categorie $categorie = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: DetailCommande::class)]
    private Collection $detailCommandes;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Commentaire::class)]
    private Collection $commentaires;


    public function __construct()
    {
        $this->etat = true;
        $this->detailCommandes = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
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
    public function getDetailCommandes(): Collection
    {
        return $this->detailCommandes;
    }

    public function addDetailCommande(DetailCommande $detailCommande): self
    {
        if (!$this->detailCommandes->contains($detailCommande)) {
            $this->detailCommandes->add($detailCommande);
            $detailCommande->setProduit($this);
        }

        return $this;
    }

    public function removeDetailCommande(DetailCommande $detailCommande): self
    {
        if ($this->detailCommandes->removeElement($detailCommande)) {
            // set the owning side to null (unless already changed)
            if ($detailCommande->getProduit() === $this) {
                $detailCommande->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setProduit($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getProduit() === $this) {
                $commentaire->setProduit(null);
            }
        }

        return $this;
    }

}
