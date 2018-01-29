<?php

namespace Mapal\GEPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Week
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Mapal\GEPBundle\Repository\WeekRepository")
 */
class Week{
		
	public static $TABLE_NAME     	    = "Week";
	
	public static $COLUMN_NAME_ID      	= "id";
	public static $COLUMN_NAME_WEEK		= "week";
	public static $COLUMN_NAME_YEAR		= "year";
	
	public static $ENTITY_NAME          = "Week";
	
	public static $FIELD_NAME_ID    	= "id";
	public static $FIELD_NAME_WEEK	 	= "week";
	public static $FIELD_NAME_YEAR  	= "year";
	
	//http://stackoverflow.com/questions/15616157/doctrine-2-and-many-to-many-link-table-with-an-extra-field
	
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
     * @ORM\Column(name="week", type="integer")
     */
    private $week;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;
    
    /**
     * @ORM\OneToMany(targetEntity="Mapal\GEPBundle\Entity\UserWeek", mappedBy="Week")
     */
    private $userWeek;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }
    
	public function getWeek() {
		return $this->week;
	}
	
	public function setWeek($week) {
		$this->week = $week;
		return $this;
	}
	
	public function getYear() {
		return $this->year;
	}
	
	public function setYear($year) {
		$this->year = $year;
		return $this;
	}
	
	public function getUserWeek() {
		return $this->userWeek;
	}
	
	public function setUserWeek($userWeek) {
		$this->userWeek = $userWeek;
		return $this;
	}
	
	public function __toString(){
		return $this->week."('".$this->year."')";
	}

}
