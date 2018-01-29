<?php

namespace Mapal\GEPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Mapal\GEPBundle\Repository\UserRepository")
 * @UniqueEntity("email")
 * @UniqueEntity("user")
 */
class User{
	
	public static $TABLE_NAME     	    = "User";
	
	public static $COLUMN_NAME_ID      	= "id";
	public static $COLUMN_NAME_USER		= "user";
	public static $COLUMN_NAME_PASS		= "pass";
	public static $COLUMN_NAME_NAME		= "name";
	public static $COLUMN_NAME_EMAIL	= "email";
	public static $COLUMN_NAME_ISADMIN	= "isadmin";
	
	public static $ENTITY_NAME          = "User";
	
	public static $FIELD_NAME_ID    	= "id";
	public static $FIELD_NAME_USER  	= "user";
	public static $FIELD_NAME_PASS  	= "pass";
	public static $FIELD_NAME_NAME		= "name";
	public static $FIELD_NAME_EMAIL		= "email";
	public static $FIELD_NAME_ISADMIN	= "isadmin";
	
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="user", type="string", length=100, unique=true)
     */
    private $user;
    
    /**
     * @var String
     *
     * @ORM\Column(name="pass", type="string", length=100)
     */
    private $pass;

    /**
     * @var String
     *
     * @ORM\Column(name="name", type="string", length=200)
     */
    private $name;
    
    /**
     * @var String
     *
     * @ORM\Column(name="email", type="string", length=250, unique=true)
     */
    private $email;
    
    /**
     * @var Integer
     *
     * @ORM\Column(name="isadmin", type="integer")
     */
    private $isAdmin;
    
    /** 
     * @ORM\OneToMany(targetEntity="Mapal\GEPBundle\Entity\UserWeek", mappedBy="User") 
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
    public function setId($id) {
    	$this->id = $id;
    	return $this;
    }
    
	public function getUser() {
		return $this->user;
	}
	
	public function setUser( $user) {
		$this->user = $user;
		return $this;
	}
	
	public function getPass() {
		return $this->pass;
	}
	
	public function setPass($pass) {
		$this->pass = $pass;
		return $this;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	
	public function getEmail() {
		return $this->email;
	}
	
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}
	
	public function getUserWeek() {
		return $this->userWeek;
	}
	
	public function setUserWeek($userWeek) {
		$this->userWeek = $userWeek;
		return $this;
	}
	
	public function getIsAdmin() {
		return $this->isAdmin;
	}
	
	public function setIsAdmin($isAdmin) {
		$this->isAdmin = $isAdmin;
		return $this;
	}
	
	public function __toString(){
		return $this->name;
	}
	

}
