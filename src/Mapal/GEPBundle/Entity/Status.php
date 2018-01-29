<?php

namespace Mapal\GEPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Status
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Mapal\GEPBundle\Repository\StatusRepository")
 */
class Status{
	
	public static $TABLE_NAME     	    = "Status";
	
	public static $COLUMN_NAME_ID      	= "id";
	public static $COLUMN_NAME_NAME		= "name";
	public static $COLUMN_NAME_ICON		= "icon";
	public static $COLUMN_NAME_COLOR	= "colour";
	public static $COLUMN_NAME_DETAULT	= "isDefaultStatus";
	public static $COLUMN_NAME_IDNEXT	= "idNextStatus";
	
	public static $ENTITY_NAME          = "Status";
	
	public static $FIELD_NAME_ID    	= "id";
	public static $FIELD_NAME_NAME  	= "name";
	public static $FIELD_NAME_ICON		= "icon";
	public static $FIELD_NAME_COLOR		= "colour";
	public static $FIELD_NAME_DETAULT	= "isDefaultStatus";
	public static $FIELD_NAME_IDNEXT	= "idNextStatus";
	
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var String
     *
     * @ORM\Column(name="name", type="string", length=200)
     */
    private $name;
    
    /** 
     * @ORM\OneToMany(targetEntity="Mapal\GEPBundle\Entity\UserWeek", mappedBy="Status") 
     */
    private $userWeek;
    
    /**
     * @var String
     * 
     * @ORM\Column(name="icon", type="string", length=100)
     * 
     */
	private $icon;
	
	/**
	 * @var String
	 *
	 * @ORM\Column(name="colour", type="string", length=100)
	 *
	 */
	private $colour;
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="isDefaultStatus", type="integer")
	 *
	 */
	private $isDefaultStatus;
	
	/**
     * @ORM\OneToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="idNextStatus", referencedColumnName="id")
     **/
    private $idNextStatus;
	

    /**
     * Get id
     *
     * @return integer 
     */
	
    public function getId() {
        return $this->id;
    }
	
	public function getName() {
		return $this->name;
	}
	
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	
	public function getUserWeek() {
		return $this->userWeek;
	}
	
	public function setUserWeek($userWeek) {
		$this->userWeek = $userWeek;
		return $this;
	}
	
	public function getIcon() {
		return $this->icon;
	}
	
	public function setIcon($icon) {
		$this->icon = $icon;
		return $this;
	}
	
	public function getColour() {
		return $this->colour;
	}
	
	public function setColour($colour) {
		$this->colour = $colour;
		return $this;
	}
	
	public function getIdNextStatus() {
		return $this->idNextStatus;
	}
	
	public function setIdNextStatus($idNextStatus) {
		$this->idNextStatus = $idNextStatus;
		return $this;
	}
	
	public function __toString(){
		return $this->name;
	}
	
	public function getIsDefaultStatus() {
		return $this->isDefaultStatus;
	}
	
	public function setIsDefaultStatus($isDefaultStatus) {
		$this->isDefaultStatus = $isDefaultStatus;
		return $this;
	}

}
