<?php

namespace Mapal\GEPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Status
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Mapal\GEPBundle\Repository\SystemParamRepository")
 */
class SystemParam{
	
	public static $TABLE_NAME     	    = "SystemParam";
	
	public static $COLUMN_NAME_ID      	= "id";
	public static $COLUMN_NAME_KEY		= "key";
	public static $COLUMN_NAME_VALUE	= "value";

	public static $ENTITY_NAME          = "SystemParam";
	
	public static $FIELD_NAME_ID    	= "id";
	public static $FIELD_NAME_KEY  		= "key";
	public static $FIELD_NAME_VALUE		= "value";
	
	
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
     * @ORM\Column(name="key", type="string", length=200, unique=true)
     */
    private $key;
    
    /**
     * @var String
     * 
     * @ORM\Column(name="value", type="string", length=100)
     * 
     */
	private $value;


    /**
     * Get id
     *
     * @return integer 
     */
	
    public function getId() {
        return $this->id;
    }
	
	public function getKey() {
		return $this->key;
	}
	
	public function setKey($key) {
		$this->key = $key;
		return $this;
	}
	
	public function getValue() {
		return $this->value;
	}
	
	public function setValue($value) {
		$this->value = $value;
		return $this;
	}
	
	public function __toString(){
		return $this->name."=".$this->value;
	}
	
}
