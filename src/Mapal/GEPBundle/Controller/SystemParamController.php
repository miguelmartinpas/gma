<?php

namespace Mapal\GEPBundle\Controller;

use Mapal\GEPBundle\Controller\CoreController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/system/param")
 */
class SystemParamController extends CoreController
{
	
	public function init(){
		
		parent::init();
	
		// Es genértico lo carga el core
		$this->systemParamService = $this->get('mapalgep.systemparam')->initService($this);
	
	}
	
	/**
	 * @Route("/",name="_system_param")
	 * @Template("MapalGEPBundle:SystemParam:index.html.twig")
	 */
	public function indexAction(){
		 
		// verifica que exista sesión
		if (!$this->existsSession()){ return $this->redirectToLogin(); }
		 
		// Establece lenguaje
		$this->setLanguage();
		 
		$this->init();
		 
		$this->logger->info("BEGIN: indexAction()");
		 
		$this->logger->info("END: indexAction()");
		 
		return array('menu' => $this->systemParamService->getMenu(),);
		 
	}
	
	/**
	 * @Route("/get/all",name="_system_param_get_all")
	 *
	 */
	public function getAllAction(){
		 
		// verifica que exista sesión
		if (!$this->existsSession()){ return $this->redirectToLogin(); }
		 
		// Establece lenguaje
		$this->setLanguage();
	
		$this->init();
	
		$this->logger->info("BEGIN: getAllAction()");
		 
		$json = $this->systemParamService->getAll();
		 
		$jsonResponse = $this->getResponseStructure($json);
    	
    	$response = new Response(json_encode($jsonResponse));
		 
		$response->headers->set('Content-Type', 'application/json');
		 
		$this->logger->info("END: BEGIN: getAllAction() return: ".json_encode($json).".");
		 
		return $response;
		 
	}
	
	/**
	 * @Route("/get/{key}",name="_system_param_get_key",requirements={"key"="[a-z-A-Z-0-9-]+"})
	 * 
	 */
    public function getKeyAction($key){
    	
    // verifica que exista sesión
		if (!$this->existsSession()){ return $this->redirectToLogin(); }
    	
    	// Establece lenguaje
    	$this->setLanguage();
    	 
    	$this->init();
    	 
    	$this->logger->info("BEGIN: getKeyAction($key)");
    	
    	$json = $this->systemParamService->get($key);
    	
    	$jsonResponse = $this->getResponseStructure($json);
    	
    	$response = new Response(json_encode($jsonResponse));
    	
    	$response->headers->set('Content-Type', 'application/json');
    	
    	$this->logger->info("END: BEGIN: getKeyAction($key) return: ".json_encode($json).".");
    	
    	return $response;
    	
    }
    
    /**
     * @Route("/set/{key}/{value}",name="_system_param_set_key",requirements={"key"="[a-z-A-Z-0-9-]+"})
     * 
     */
    public function setKeyAction($key,$value){
    	 
    	// verifica que exista sesión
		if (!$this->existsSession()){ return $this->redirectToLogin(); }
    	 
    	// Establece lenguaje
    	$this->setLanguage();
    
    	$this->init();
    
    	$this->logger->info("BEGIN: setKeyAction($key,$value)");
    	 
    	$json = $this->systemParamService->set($key,$value);
    	 
    	$jsonResponse = $this->getResponseStructure($json);
    	
    	$response = new Response(json_encode($jsonResponse));
    	 
    	$response->headers->set('Content-Type', 'application/json');
    	 
    	$this->logger->info("END: BEGIN: setKeyAction($key,$value) return: ".json_encode($json).".");
    	 
    	return $response;
    	 
    }
    
    /**
     * @Route("/remove/{key}",name="_system_param_set_key",requirements={"key"="[a-z-A-Z-0-9-]+"})
     * 
     */
    public function removeKeyAction($key){
    
    	// verifica que exista sesión
		if (!$this->existsSession()){ return $this->redirectToLogin(); }
    
    	// Establece lenguaje
    	$this->setLanguage();
    
    	$this->init();
    
    	$this->logger->info("BEGIN: removeKeyAction($key)");
    
    	$json = $this->systemParamService->remove($key);
    	
    	$jsonResponse = $this->getResponseStructure($json);
    	
    	$response = new Response(json_encode($jsonResponse));

    	$response->headers->set('Content-Type', 'application/json');
    
    	$this->logger->info("END: BEGIN: removeKeyAction($key) return: ".json_encode($json).".");
    
    	return $response;
    
    }
   
}
