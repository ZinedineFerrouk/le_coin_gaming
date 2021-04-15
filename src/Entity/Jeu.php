<?php

namespace App\Entity;

use App\Repository\JeuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=JeuRepository::class)
 */
class Jeu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "Le titre doit avoir au moins {{ limit }} caractères",
     *      maxMessage = "Le titre ne doit pas excéder {{ limit }} caractères"
     * )
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 100,
     *      max = 600,
     *      minMessage = "La description doit avoir au moins {{ limit }} caractères",
     *      maxMessage = "La description ne doit pas excéder {{ limit }} caractères"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     */
    private $date_sortie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="jeu")
     */
    private $annonces;

    /**
     * @ORM\ManyToMany(targetEntity=Plateforme::class, inversedBy="jeux", fetch="EXTRA_LAZY")
     */
    private $plateforme;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
        $this->plateforme = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->date_sortie;
    }

    public function setDateSortie(\DateTimeInterface $date_sortie): self
    {
        $this->date_sortie = $date_sortie;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setJeu($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getJeu() === $this) {
                $annonce->setJeu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Plateforme[]
     */
    public function getPlateforme(): Collection
    {
        return $this->plateforme;
    }

    public function addPlateforme(Plateforme $plateforme): self
    {
        if (!$this->plateforme->contains($plateforme)) {
            $this->plateforme[] = $plateforme;
        }

        return $this;
    }

    public function removePlateforme(Plateforme $plateforme): self
    {
        $this->plateforme->removeElement($plateforme);

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
