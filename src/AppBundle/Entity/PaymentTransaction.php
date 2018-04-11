<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * PaymentTransaction
 *
 * @ORM\Table(name="payment_transaction")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaymentTransactionRepository")
 */
class PaymentTransaction
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="paymentTransactions")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="control", type="text")
     */
    private $control;

    /**
     * @var string
     *
     * @ORM\Column(name="plan", type="text")
     */
    private $plan;

    /**
     * @var double
     *
     * @ORM\Column(name="price", type="decimal", precision=7, scale=2)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="operation_number", type="text")
     */
    private $operationNumber;

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
     * Set user
     *
     * @param $user
     *
     * @return PaymentTransaction
     */
    public function setUser($user){
        $this->user = $user;

        Return $this;
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
     * Set status
     *
     * @param integer $status
     *
     * @return PaymentTransaction
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set control
     *
     * @param string $control
     *
     * @return PaymentTransaction
     */
    public function setControl($control)
    {
        $this->control = $control;

        return $this;
    }

    /**
     * Get control
     *
     * @return string
     */
    public function getControl()
    {
        return $this->control;
    }

    /**
     * Set plan
     *
     * @param string $plan
     *
     * @return PaymentTransaction
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * Get plan
     *
     * @return string
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * Set price
     *
     * @param double $price
     *
     * @return PaymentTransaction
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return double
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set operationNumber
     *
     * @param string $operationNumber
     *
     * @return PaymentTransaction
     */
    public function setOperationNumber($operationNumber)
    {
        $this->operationNumber = $operationNumber;

        return $this;
    }

    /**
     * Get operationNumber
     *
     * @return string
     */
    public function getOperationNumber()
    {
        return $this->operationNumber;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return PaymentTransaction
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
     * @return PaymentTransaction
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

