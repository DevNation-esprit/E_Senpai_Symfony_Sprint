<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Slide
 *
 * @ORM\Table(name="slide", indexes={@ORM\Index(name="fk_idformation_slide", columns={"id_formation"})})
 * @ORM\Entity
 */
class Slide
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
     * @ORM\Column(name="video_slide", type="string", length=255, nullable=false)
     */
    private $videoSlide;

    /**
     * @var string
     *
     * @ORM\Column(name="image_slide", type="string", length=255, nullable=false)
     */
    private $imageSlide;

    /**
     * @var string
     *
     * @ORM\Column(name="text_slide", type="string", length=255, nullable=false)
     */
    private $textSlide;

    /**
     * @var int
     *
     * @ORM\Column(name="ordre", type="integer", nullable=false)
     */
    private $ordre;

    /**
     * @var \Formation
     *
     * @ORM\ManyToOne(targetEntity="Formation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_formation", referencedColumnName="id")
     * })
     */
    private $idFormation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVideoSlide(): ?string
    {
        return $this->videoSlide;
    }

    public function setVideoSlide(string $videoSlide): self
    {
        $this->videoSlide = $videoSlide;

        return $this;
    }

    public function getImageSlide(): ?string
    {
        return $this->imageSlide;
    }

    public function setImageSlide(string $imageSlide): self
    {
        $this->imageSlide = $imageSlide;

        return $this;
    }

    public function getTextSlide(): ?string
    {
        return $this->textSlide;
    }

    public function setTextSlide(string $textSlide): self
    {
        $this->textSlide = $textSlide;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getIdFormation(): ?Formation
    {
        return $this->idFormation;
    }

    public function setIdFormation(?Formation $idFormation): self
    {
        $this->idFormation = $idFormation;

        return $this;
    }


}
