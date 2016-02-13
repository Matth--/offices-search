<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\OfficesRepository")
 * @ORM\Table(name="offices")
 * @ORM\HasLifecycleCallbacks
 */
class Office
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $street;

    /**
     * @ORM\Column(type="string")
     */
    protected $city;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $latitude;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $longitude;

    /**
     * @ORM\Column(type="string")
     */
    protected $is_open_in_weekends;

    /**
     * @ORM\Column(type="string")
     */
    protected $has_support_desk;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTest()
    {
        return 'test';
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     * @
     */
    public function getIsOpenInWeekends()
    {
        return $this->is_open_in_weekends;
    }

    /**
     * @param mixed $is_open_in_weekends
     */
    public function setIsOpenInWeekends($is_open_in_weekends)
    {
        $this->is_open_in_weekends = $is_open_in_weekends;
    }

    /**
     * @return mixed
     */
    public function getHasSupportDesk()
    {
        return $this->has_support_desk;
    }

    /**
     * @param mixed $has_support_desk
     */
    public function setHasSupportDesk($has_support_desk)
    {
        $this->has_support_desk = $has_support_desk;
    }

    /**
     * @ORM\PostLoad
     */
    public function postLoad()
    {
        $this->city = ucwords(strtolower($this->city));
        $this->street = implode('-', array_map('ucwords', explode('-', strtolower($this->street))));
    }
}
