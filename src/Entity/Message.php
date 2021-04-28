<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message", indexes={@ORM\Index(name="fk_iduseremetteur_message", columns={"id_user_emetteur"}), @ORM\Index(name="fk_iddiscussion_message", columns={"id_discussion"})})
 * @ORM\Entity
 */
class Message
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
     * @ORM\Column(name="contenu", type="string", length=255, nullable=false)
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_msg", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateMsg = 'CURRENT_TIMESTAMP';

    /**
     * @var \Discussion
     *
     * @ORM\ManyToOne(targetEntity="Discussion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_discussion", referencedColumnName="id")
     * })
     */
    private $idDiscussion;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user_emetteur", referencedColumnName="id")
     * })
     */
    private $idUserEmetteur;


}
