<?php
/**
 * Created by PhpStorm.
 * User: toma4
 * Date: 28.03.2018
 * Time: 23:14
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
 * @ORM\Column(type="string", length=255)
 *
 * @Assert\NotBlank(message="Podaj swoje imie", groups={"Registration", "Profile"})
 * @Assert\Length(
 *     min=3,
 *     max=255,
 *     minMessage="Imie jest za krótkie",
 *     maxMessage="Imie jest za długie",
 *     groups={"Registration", "Profile"}
 * )
 */
    protected $name;

    /**
 * @ORM\Column(name="surname", type="string", length=255)
 *
 * @Assert\NotBlank(message="Podaj swoje nazwisko", groups={"Registration", "Profile"})
 * @Assert\Length(
 *     min=3,
 *     max=255,
 *     minMessage="nazwisko jest za krótkie",
 *     maxMessage="nazwisko jest za długie",
 *     groups={"Registration", "Profile"}
 * )
 */
    protected $surname;

    /**
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="nazwa miasta jest za krótka",
     *     maxMessage="nazwa miasta jest za długa",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $city;

    /**
     * @ORM\Column(name="zone", type="string", length=255)
     *
     * @Assert\NotBlank(message="Wybierz województwo", groups={"Registration", "Profile"})
     */
    protected $zone;

    /**
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *     min=9,
     *     max=15,
     *     minMessage="błędny format numeru telefonu",
     *     maxMessage="błędny format numeru telefonu",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $phone;

    /**
     * @ORM\Column(name="graduation", type="string", length=255, nullable=true)
     */
    protected $graduation;

    /**
     * @ORM\Column(name="degree", type="string", length=255)
     * @Assert\NotBlank(message="Wybierz tytuł zawodowy", groups={"Registration", "Profile"})
     */
    protected $degree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="vip_to", type="datetime", nullable=true)
     */
    protected $vipTo;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PaymentTransaction", mappedBy="user")
     */
    protected $paymentTransactions;

    public function __construct()
    {
        parent::__construct();
        $this->paymentTransactions = new ArrayCollection();
    }

    /**
     * get paymentTransactions
     *
     * @return Collection|PaymentTransaction[]
     */
    public function getPaymentTransaction()
    {
        return $this->paymentTransactions;
    }

    /**
     * set name
     * @param $name
     * @return User
     */
    public function setName($name){
        $this->name = $name;

        return $this;
    }

    /**
     * get name
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * set surname
     * @param $surname
     * @return User
     */
    public function setSurname($surname){
        $this->surname = $surname;

        return $this;
    }

    /**
     * get surname
     * @return string
     */
    public function getSurname(){
        return $this->surname;
    }

    /**
     * set city
     * @param $city
     * @return User
     */
    public function setCity($city){
        $this->city = $city;

        return $this;
    }

    /**
     * get city
     * @return string
     */
    public function getCity(){
        return $this->city;
    }

    /**
     * set zone
     * @param $zone
     * @return User
     */
    public function setZone($zone){
        $this->zone = $zone;

        return $this;
    }

    /**
     * get zone
     * @return string
     */
    public function getZone(){
        return $this->zone;
    }

    /**
     * set phone
     * @param $phone
     * @return User
     */
    public function setPhone($phone){
        $this->phone = $phone;

        return $this;
    }

    /**
     * get phone
     * @return string
     */
    public function getPhone(){
        return $this->phone;
    }

    /**
     * set graduation
     * @param $graduation
     * @return User
     */
    public function setGraduation($graduation){
        $this->graduation = $graduation;

        return $this;
    }

    /**
     * get graduation
     * @return mixed
     */
    public function getGraduation(){
        return $this->graduation;
    }

    /**
     * set degree
     * @param $degree
     * @return User
     */
    public function setDegree($degree){
        $this->degree = $degree;

        return $this;
    }

    /**
     * get degree
     * @return mixed
     */
    public function getDegree(){
        return $this->degree;
    }

    /**
     * Set vipTo
     *
     * @param \DateTime $vipTo
     *
     * @return User
     */
    public function setVipTo($vipTo)
    {
        $this->vipTo = $vipTo;

        return $this;
    }

    /**
     * Get vipTo
     *
     * @return \DateTime
     */
    public function getVipTo()
    {
        return $this->vipTo;
    }
}