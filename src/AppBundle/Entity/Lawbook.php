<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Lawbook
 *
 * @ORM\Table(name="lawbook")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LawbookRepository")
 * @Vich\Uploadable
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
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="articles", type="text")
     */
    private $articles;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @Vich\UploadableField(mapping="lawbook_files", fileNameProperty="file")
     * @var File
     */
    private $fileObject;

    /**
     * @var string
     *
     * @ORM\Column(name="file", type="string", length=255)
     */
    private $file;

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
     * @var bool
     *
     * @ORM\Column(name="isImportant", type="boolean", options={"default" : false})
     */
    private $isImportant;

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
     * Set name
     *
     * @param string $name
     *
     * @return Lawbook
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set articles
     *
     * @param string $articles
     *
     * @return Lawbook
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;

        return $this;
    }

    /**
     * Get articles
     *
     * @return string
     */
    public function getArticles()
    {
        return $this->articles;
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

    public function setFileObject(File $fileObject = null)
    {
        $this->fileObject = $fileObject;

        if ($fileObject instanceof UploadedFile) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getFileObject()
    {
        return $this->fileObject;
    }

    /**
     * Set file
     *
     * @param string $file
     *
     * @return Lawbook
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
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
     * Set isImportant
     *
     * @param boolean $isImportant
     *
     * @return Lawbook
     */
    public function setIsImportant($isImportant)
    {
        $this->isImportant = $isImportant;

        return $this;
    }

    /**
     * Get isImportant
     *
     * @return bool
     */
    public function getIsImportant()
    {
        return $this->isImportant;
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

