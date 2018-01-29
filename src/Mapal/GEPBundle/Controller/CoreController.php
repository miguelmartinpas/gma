<?php

namespace Mapal\GEPBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller{
	
	public static $sessionVarName = "userSession";
	
	protected $logger;
	
	public $systemParamService;
	
	public function init(){
	
		$this->logger = $this->get('logger');
		
		$this->systemParamService = $this->get('mapalgep.systemparam')->initService($this);
	
	}
	
	// Verifica que exista la session
	public function existsSession(){
		
		// Verify the authentication
		$session = $this->getRequest()->getSession();
		if (!$session->has(self::$sessionVarName)){
			return false;
		}
		
		return true;
		
	}
	
	// Verifica que exista la session
	public function redirectToLoginPage(){
	
		return $this->redirect($this->generateUrl('_login'));
	
	}
	
	// Verifica que exista la session
	public function redirectToHomePage(){
	
		return $this->redirect($this->generateUrl('_home'));
	
	}
	
	// Establece en session el idioma español por defecto
	public function setLanguage($lang="es") {
    
        $this->getRequest()->setLocale($lang);

        $session = $this->getRequest()->getSession();
        $session->set('lang', $lang);
            
    }
    
    public function getResponseStructure($json=null){
    	
    	return array(
    			"error" => false,
    			"message" => "",
    			"json" => $json,
    	);
    	
    }
	
}