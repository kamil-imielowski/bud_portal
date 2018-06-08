<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * IncorrectAnswer
 *
 * @ORM\Table(name="incorrect_answer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IncorrectAnswerRepository")
 */
class IncorrectAnswer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="incorrectAnswers")
     * @ORM\JoinColumn(name="fos_user_id", referencedColumnName="id")
     */
    private $user;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\WrittenQuestion")
     * @ORM\JoinColumn(name="written_question_id", referencedColumnName="id")
     */
    private $question;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param $user
     *
     * @return IncorrectAnswer
     */
    public function setUser($user){
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return mixed
     */
    public function getUser(){
        return $this->user;
    }

    /**
     * Set question
     *
     * @param $question
     *
     * @return IncorrectAnswer
     */
    public function setQuestion($question){
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return IncorrectAnswer
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}

