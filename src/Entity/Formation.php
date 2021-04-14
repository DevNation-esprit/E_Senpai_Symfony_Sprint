<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Formation
 *
 * @ORM\Table(name="formation", indexes={@ORM\Index(name="fk_idformateur", columns={"id_formateur"})})
 * @ORM\Entity
 */
class Formation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var int
     *
     * @ORM\Column(name="note", type="integer", nullable=false)
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_formateur", referencedColumnName="id")
     * })
     */
    private $idFormateur;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="User", inversedBy="idFormation")
     * @ORM\JoinTable(name="abonnement",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_formation", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_etudiant", referencedColumnName="id")
     *   }
     * )
     */
    private $idEtudiant;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idEtudiant = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitre(): ?string
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre(?string $titre): void
    {
        $this->titre = $titre;
    }

    /**
     * @return int
     */
    public function getNote(): ?int
    {
        return $this->note;
    }

    /**
     * @param int $note
     */
    public function setNote(?int $note): void
    {
        $this->note = $note;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getIdFormateur(): ?int
    {
        return $this->idFormateur;
    }

    /**
     * @param int $idFormateur
     */
    public function setIdFormateur(?int $idFormateur): void
    {
        $this->idFormateur = $idFormateur;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdEtudiant()
    {
        return $this->idEtudiant;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idEtudiant
     */
    public function setIdEtudiant($idEtudiant): void
    {
        $this->idEtudiant = $idEtudiant;
    }



}
