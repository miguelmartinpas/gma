<?php

namespace Mapal\GEPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dictionary
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Mapal\GEPBundle\Repository\UserWeekRepository")
 */
class UserWeek{
		
	public static $TABLE_NAME     	    	= "UserWeek";
	
	public static $COLUMN_NAME_USER			= "idUser";
	public static $COLUMN_NAME_WEEK			= "idWeek";
	public static $COLUMN_NAME_STATUS		= "idStatus";
	
	public static $ENTITY_NAME          	= "UserWeek";
	
	public static $FIELD_NAME_USER  		= "idUser";
	public static $FIELD_NAME_WEEK		  	= "idWeek";
	public static $FIELD_NAME_STATUS		= "idStatus";
	
    
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Mapal\GEPBundle\Entity\User", inversedBy="userWeek")
     * @ORM\JoinColumn(name="idUser", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $idUser;
    
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Mapal\GEPBundle\Entity\Week", inversedBy="userWeek")
     * @ORM\JoinColumn(name="idWeek", referencedColumnName="id", nullable=false)
     */
    private $idWeek;
    
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Mapal\GEPBundle\Entity\Status", inversedBy="userWeek")
     * @ORM\JoinColumn(name="idStatus", referencedColumnName="id", nullable=false)
     */
    private $idStatus;
	
	public function getIdUser() {
		return $this->idUser;
	}
	
	public function setIdUser($idUser) {
		$this->idUser = $idUser;
		return $this;
	}
	
	public function getIdWeek() {
		return $this->idWeek;
	}
	
	public function setIdWeek($idWeek) {
		$this->idWeek = $idWeek;
		return $this;
	}
	
	public function getIdStatus() {
		return $this->idStatus;
	}
	
	public function setIdStatus($idStatus) {
		$this->idStatus = $idStatus;
		return $this;
	}
     
}
