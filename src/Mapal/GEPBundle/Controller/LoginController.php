<?php

namespace Mapal\GEPBundle\Controller;

use Mapal\GEPBundle\Controller\CoreController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * Root controller.
 *
 * @Route("/")
 */
class LoginController extends CoreController
{

	private $userService;
	
	public function init(){
		
		parent::init();
	
		$this->userService = $this->get('mapalgep.user')->initService($this);
	
	}
	
	/**
	 * @Route("/login",name="_login")
	 * @Template("MapalGEPBundle:Login:index.html.twig")
	 */
    public function loginAction(){
    	
    	// verifica que exista sesión
    	if ($this->existsSession()){ return $this->redirectToHomePage(); }
    	
    	// Establece lenguaje
    	$this->setLanguage();
    	
    	$this->init();
    	
    	$this->logger->info("BEGIN: loginAction()");
    	
    	$this->logger->info("END: loginAction()");
    	
        return array('menu' => $this->userService->getMenu(),);
    	
    }
    
    /**
     * @Route("/login/authentication/{user}/{pass}",name="_login_authentication",requirements={"user"="[a-z-A-Z-0-9-]+","pass"="[a-z-A-Z-0-9-]+"})
     */
    public function loginAuthenticationAction( $user, $pass ){
    	
    	// Establece lenguaje
    	$this->setLanguage();
    	 
    	$this->init();
    	 
    	$this->logger->info("BEGIN: loginAuthenticationAction(user='".$user."', pass='".$pass."')");
    	
    	$userObject = $this->userService->getUserByUserAndPass($user,$pass);
    	
    	if ($userObject!=null){
    	
	    	$session = $this->getRequest()->getSession();
	    	$session->set(parent::$sessionVarName, $userObject);
	    	
	    	$jsonResponse = array (
					    		"status"=>1,    						
	    	);
	    	
    	}else{
    		
    		$jsonResponse = array (
    				"status"=>"0",
    				"message"=>"El usuario o contraseña no existen",			
    		);
    	
    	}
    	
    	$response = new Response(json_encode($jsonResponse));
    	
    	$response->headers->set('Content-Type', 'application/json');
    	
    	$this->logger->info("END: BEGIN: loginAuthenticationAction(user='".$user."', pass='".$pass."') retur: ".json_encode($jsonResponse).".");
    	
    	return $response;
    	
    }
    
    /**
     * @Route("/logout",name="_logout")
     * @Template("MapalGEPBundle:Login:index.html.twig")
     */
    public function logoutAction(){
    	
    	$logger = $this->get('logger');
    	 
    	$logger->info("BEGIN: logoutAction()");
    		
    	// remove the sessión
    	$session = $this->getRequest()->getSession();
    	$session->remove(parent::$sessionVarName);

    	// Redirect to login page
    	$logger->info("END: logoutAction()");
    	 
    	return $this->redirect($this->generateUrl('_login'));
    	 
    }
   
}
