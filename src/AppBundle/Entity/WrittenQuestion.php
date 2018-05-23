<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * writtenQuestion
 *
 * @ORM\Table(name="written_question")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\writtenQuestionRepository")
 */
class WrittenQuestion
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\WrittenQuestionCategory", inversedBy="writtenQuestions")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="text")
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(name="answerA", type="text")
     */
    private $answerA;

    /**
     * @var string
     *
     * @ORM\Column(name="answerB", type="text")
     */
    private $answerB;

    /**
     * @var string
     *
     * @ORM\Column(name="answerC", type="text")
     */
    private $answerC;

    /**
     * @var string
     *
     * @ORM\Column(name="prompt", type="text")
     */
    private $prompt;

    /**
     * @var bool
     *
     * @ORM\Column(name="isFree", type="boolean", options={"default" : false})
     */
    private $isFree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * Set category
     *
     * @param $category
     *
     * @return WrittenQuestion
     */
    public function setCategory($category){
        $this->category = $category;

        Return $this;
    }

    /**
     * Get category
     *
     * @return mixed
     */
    public function getCategory(){
        return $this->category;
    }

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
     * Set question
     *
     * @param string $question
     *
     * @return writtenQuestion
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set answerA
     *
     * @param string $answerA
     *
     * @return writtenQuestion
     */
    public function setAnswerA($answerA)
    {
        $this->answerA = $answerA;

        return $this;
    }

    /**
     * Get answerA
     *
     * @return string
     */
    public function getAnswerA()
    {
        return $this->answerA;
    }

    /**
     * Set answerB
     *
     * @param string $answerB
     *
     * @return writtenQuestion
     */
    public function setAnswerB($answerB)
    {
        $this->answerB = $answerB;

        return $this;
    }

    /**
     * Get answerB
     *
     * @return string
     */
    public function getAnswerB()
    {
        return $this->answerB;
    }

    /**
     * Set answerC
     *
     * @param string $answerC
     *
     * @return writtenQuestion
     */
    public function setAnswerC($answerC)
    {
        $this->answerC = $answerC;

        return $this;
    }

    /**
     * Get answerC
     *
     * @return string
     */
    public function getAnswerC()
    {
        return $this->answerC;
    }

    /**
     * Set prompt
     *
     * @param string $prompt
     *
     * @return writtenQuestion
     */
    public function setPrompt($prompt)
    {
        $this->prompt = $prompt;

        return $this;
    }

    /**
     * Get prompt
     *
     * @return string
     */
    public function getPrompt()
    {
        return $this->prompt;
    }

    /**
     * Set isFree
     *
     * @param boolean $isFree
     *
     * @return WrittenQuestion
     */
    public function setIsFree($isFree)
    {
        $this->isFree = $isFree;

        return $this;
    }

    /**
     * Get isFree
     *
     * @return bool
     */
    public function getIsFree()
    {
        return $this->isFree;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return writtenQuestion
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

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return writtenQuestion
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}

