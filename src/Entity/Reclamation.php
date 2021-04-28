<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="fk_user_rec", columns={"id_user_rec"})})
 * @ORM\Entity
 */
class Reclamation
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
     * @ORM\Column(name="statut", type="string", length=255, nullable=false)
     */
    private $statut;

    /**
     * @var string
     *
     * @ORM\Column(name="sujet_reclamation", type="string", length=255, nullable=false)
     */
    private $sujetReclamation;

    /**
     * @var int
     *
     * @ORM\Column(name="admin_trait", type="integer", nullable=false)
     */
    private $adminTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=255, nullable=false)
     */
    private $contenu;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user_rec", referencedColumnName="id")
     * })
     */
    private $idUserRec;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getSujetReclamation(): ?string
    {
        return $this->sujetReclamation;
    }

    public function setSujetReclamation(string $sujetReclamation): self
    {
        $this->sujetReclamation = $sujetReclamation;

        return $this;
    }

    public function getAdminTrait(): ?int
    {
        return $this->adminTrait;
    }

    public function setAdminTrait(int $adminTrait): self
    {
        $this->adminTrait = $adminTrait;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getIdUserRec(): ?User
    {
        return $this->idUserRec;
    }

    public function setIdUserRec(?User $idUserRec): self
    {
        $this->idUserRec = $idUserRec;

        return $this;
    }


}
