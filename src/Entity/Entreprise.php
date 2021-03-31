<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idEntreprise;

    /**
     * @ORM\Column(type="string", length=150)
     *@Assert\NotBlank
     * @Assert\Length(
     *      min = 4,
     *      max =150,
     *      minMessage = "Le nom doit faire au minimum {{ limit }} caractères",
     *      maxMessage = "Le nom ne doit pas depasser {{ limit }} caractères"
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     *@Assert\NotBlank
     * @Assert\Regex(
     *     pattern="#^[0-9]{1,3} #",
     *     match=true,
     *     message="Le numéro de la rue n'est pas correct"
     * )
     * @Assert\Regex(
     *     pattern="# rue|impasse|voie|chemin|boulevard|allée|route|avenue #",
     *     match=true,
     *     message="Le type de voie n'est pas correct"
     * )
     * @Assert\Regex(
     *     pattern="# [0-9]{5} #",
     *     match=true,
     *     message="Le code postal n'est pas correct"
     * )
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     *@Assert\NotBlank
     */
    private $milieu;

    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="entreprise")
     *@Assert\NotBlank
     */
    private $stages;

    /**
     * @ORM\Column(type="string", length=255)
     *@Assert\NotBlank
     *@Assert\Url(
     *    message = "l'url '{{ value }}' n'est pas une url valide",
     * )
     */
    private $logo;

    public function __construct()
    {
        $this->stages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEntreprise(): ?int
    {
        return $this->idEntreprise;
    }

    public function setIdEntreprise(int $idEntreprise): self
    {
        $this->idEntreprise = $idEntreprise;

        return $this;
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getMilieu(): ?string
    {
        return $this->milieu;
    }

    public function setMilieu(?string $milieu): self
    {
        $this->milieu = $milieu;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setEntreprise($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getEntreprise() === $this) {
                $stage->setEntreprise(null);
            }
        }

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function __toString()
      {
        return $this->getNom();
      }
}
