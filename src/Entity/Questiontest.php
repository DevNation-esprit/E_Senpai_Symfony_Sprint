<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Questiontest
 *
 * @ORM\Table(name="questiontest", indexes={@ORM\Index(name="fk_idtest_questiontest", columns={"id_test"})})
 * @ORM\Entity
 */
class Questiontest
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
     * @var \Test
     *
     * @ORM\ManyToOne(targetEntity="Test")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_test", referencedColumnName="id")
     * })
     */
    private $idTest;


}
