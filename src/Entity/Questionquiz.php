<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Questionquiz
 *
 * @ORM\Table(name="questionquiz", indexes={@ORM\Index(name="fk_idquiz_questionquiz", columns={"id_quiz"})})
 * @ORM\Entity
 */
class Questionquiz
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
     * @ORM\Column(name="designation", type="string", length=255, nullable=false)
     */
    private $designation;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse_correcte", type="string", length=255, nullable=false)
     */
    private $reponseCorrecte;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse_fausse1", type="string", length=255, nullable=false)
     */
    private $reponseFausse1;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse_fausse2", type="string", length=255, nullable=false)
     */
    private $reponseFausse2;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse_fausse3", type="string", length=255, nullable=false)
     */
    private $reponseFausse3;

    /**
     * @var int
     *
     * @ORM\Column(name="note", type="integer", nullable=false)
     */
    private $note;

    /**
     * @var \Quiz
     *
     * @ORM\ManyToOne(targetEntity="Quiz")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_quiz", referencedColumnName="id")
     * })
     */
    private $idQuiz;


}
