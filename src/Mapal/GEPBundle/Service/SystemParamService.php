<?php

namespace Mapal\GEPBundle\Service;

use Mapal\GEPBundle\Service\CoreService;
use Mapal\GEPBundle\Entity\SystemParam;

class SystemParamService extends CoreService{
	
	private $systemParamRepository;
	
	public function initService( $controller ){
		
		// MySQL
		$this->systemParamRepository = $controller->get('doctrine.orm.entity_manager')->getRepository('MapalGEPBundle:SystemParam');
		
		parent::initService( $controller );
		
		return $this;
		
	}
	
	public function getAll(){
		
		$lstSystemParams = array();
		
		$systemParams = $this->systemParamRepository->findAll();
		
		if (count($systemParams)){
			foreach ( $systemParams as $systemParam ){
				$lstSystemParams[] = array(					
						"id" => $systemParam->getId(),
						"key" => $systemParam->getKey(),
						"value" => $systemParam->getValue(),
				);
			}
			
		}
		
		return $lstSystemParams;
		
	}
	
	public function get($key,$value=null){
	
		$json = array(
				"id" => null,
				"key" => $key,
				"value" => $value,
		);
	
		try{
	
			$loadSystemParam = $this->systemParamRepository->findByKey($key);
				
			if ($loadSystemParam != null ){
				$json["id"] = $loadSystemParam->getId();
				$json["value"] = $loadSystemParam->getValue();
			}
				
		}catch( Exception $ex ){
				
		}
	
		return $json;
	
	}
	
	public function set($key,$value){
	
		$json = array(
					"id" => null,
					"key" => $key,
					"value" => $value,
				);
	
		try{
	
			$loadSystemParam = $this->systemParamRepository->findByKey($key);
	
			if ($loadSystemParam != null ){
				$loadSystemParam->setValue($value);
			}else{
				$loadSystemParam->setKey($key);
				$loadSystemParam->setValue($value);			
			}
			
			$json["id"] = $this->systemParamRepository->saveOrUpdate($loadSystemParam);
	
		}catch( Exception $ex ){
	
		}
	
		return $json;
	
	}
	
	public function remove($key){
	
		$json = array(
					"remove" => false,
				);
		
		try{
	
			$loadSystemParam = $this->systemParamRepository->findByKey($key);
				
			if ($loadSystemParam != null ){
				$this->systemParamRepository->remove($loadSystemParam);
				$loadSystemParam = $this->systemParamRepository->findByKey($key);
				$json["remove"] = ($loadSystemParam==null);
			}
				
		}catch( Exception $ex ){
				
		}
	
		return $json;
	
	}
    
}