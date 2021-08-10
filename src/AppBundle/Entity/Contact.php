<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Contact
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="person_id", type="integer")
     */
    private $personId;

    /**
     * @var string
     *
     * @ORM\Column(name="type_contact", type="string", length=255)
     */
    private $typeContact;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_value", type="string", length=255)
     */
    private $contactValue;

    /**
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="contact")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     * 
     */
    private $person;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set personId
     *
     * @param integer $personId
     * @return Contact
     */
    public function setPersonId($personId)
    {
        $this->personId = $personId;

        return $this;
    }

    /**
     * Get personId
     *
     * @return integer 
     */
    public function getPersonId()
    {
        return $this->personId;
    }

    /**
     * Set typeContact
     *
     * @param string $typeContact
     * @return Contact
     */
    public function setTypeContact($typeContact)
    {
        $this->typeContact = $typeContact;

        return $this;
    }

    /**
     * Get typeContact
     *
     * @return string 
     */
    public function getTypeContact()
    {
        return $this->typeContact;
    }

    /**
     * Set contactValue
     *
     * @param string $contactValue
     * @return Contact
     */
    public function setContactValue($contactValue)
    {
        $this->contactValue = $contactValue;

        return $this;
    }

    /**
     * Get contactValue
     *
     * @return string 
     */
    public function getContactValue()
    {
        return $this->contactValue;
    }
}
