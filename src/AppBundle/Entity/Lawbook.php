<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Lawbook
 *
 * @ORM\Table(name="lawbook")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LawbookRepository")
 */
class Lawbook
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\LawbookCategory", inversedBy="lawbooks")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var bool
     *
     * @ORM\Column(name="published", type="boolean", options={"default" : false})
     */
    private $published;

    /**
     * @var bool
     *
     * @ORM\Column(name="freeDownload", type="boolean", options={"default" : false})
     */
    private $freeDownload;

    /**
     * @var int
     *
     * @ORM\Column(name="views", type="integer", nullable=true, options={"default" : 0})
     */
    private $views;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set category
     *
     * @param $category
     *
     * @return Lawbook
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
     * Set title
     *
     * @param string $title
     *
     * @return Lawbook
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Lawbook
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Lawbook
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return bool
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set freeDownload
     *
     * @param boolean $freeDownload
     *
     * @return Lawbook
     */
    public function setFreeDownload($freeDownload)
    {
        $this->freeDownload = $freeDownload;

        return $this;
    }

    /**
     * Get freeDownload
     *
     * @return bool
     */
    public function getFreeDownload()
    {
        return $this->freeDownload;
    }

    /**
     * Set views
     *
     * @param integer $views
     *
     * @return Lawbook
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Lawbook
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
     * @return Lawbook
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

