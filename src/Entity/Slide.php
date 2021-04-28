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


}
