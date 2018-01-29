<?php

namespace Mapal\GEPBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

use Mapal\GEPBundle\Entity\User;

/**
 * User controller.
 *
 * @Route("/admin/user")
 */
class UserController extends CoreController
{
	
	private $userService;
	
	public function init(){
		
		parent::init();
		
		$this->userService = $this->get('mapalgep.user')->initService($this);
		
	}
	
	/**
	 * @Route("/",name="admin_user")
	 * @Template("MapalGEPBundle:User:index.html.twig")
	 */
    public function indexAction(){
    	
    	// verifica que exista sesión
    	if (!$this->existsSession()){ return $this->redirectToLoginPage(); }
    	
    	// Establece lenguaje
    	$this->setLanguage();
    	
    	$this->init();
    	
    	$this->logger->info("BEGIN: User: loginAction()");
    	
    	// verifica que exista sesión
    	$this->existsSession();
    	
    	// Establece lenguaje
    	$this->setLanguage();
    	
    	$this->logger->info("END: User: loginAction()");
    	
    	return array(
    			'menu' => $this->userService->getMenu(),
    	);
  	
    }
    
    /**
     * @Route("/get/all",name="_admin_user_get_all")
     */
    public function getAllAction(){
    
    	// verifica que exista sesión
    	if (!$this->existsSession()){ return $this->redirectToLoginPage(); }
    	 
    	// Establece lenguaje
    	$this->setLanguage();
    	 
    	$this->init();
    
    	$this->logger->info("BEGIN: User: getAllAction()");
    	
    	$jsonResponse = $this->getResponseStructure();
    
    	$users = $this->userService->findAll();
    	
    	$jsonResponse = $this->getResponseStructure($users);
    
    	$response = new Response(json_encode($jsonResponse));
    
    	$response->headers->set('Content-Type', 'application/json');
    
    	$this->logger->info("END: User: getAllAction() return: ".json_encode($jsonResponse).".");
    
    	return $response;
    
    }
    
    /**
     * @Route("/get/{id}",name="_admin_user_get",requirements={"id"="\d+"})
     */
    public function getAction( $id ){
    	 
    	// verifica que exista sesión
    	if (!$this->existsSession()){ return $this->redirectToLoginPage(); }
    	
    	// Establece lenguaje
    	$this->setLanguage();
    	
    	$this->init();
    
    	$this->logger->info("BEGIN: User: getAction($id)");
    	 
    	$user = $this->userService->find($id);
    	 
    	$json = array (
    			"id"=>$user->getId(),
    			"name"=>$user->getName(),
    			"user"=>$user->getUser(),
    			"email"=>$user->getEmail(),
    			"isAdmin"=>$user->getIsAdmin(),
    			
    	);
    	
    	$jsonResponse = $this->getResponseStructure($json);
    	 
    	$response = new Response(json_encode($jsonResponse));
    	 
    	$response->headers->set('Content-Type', 'application/json');
    	 
    	$this->logger->info("END: User: getAction($id) return: ".json_encode($jsonResponse).".");
    	 
    	return $response;
    	 
    }
    
    /**
     * @Route("/saveorupdate/{id}/{username}/{pass}/{name}/{email}/{isadmin}",name="_admin_user_saveorupdate",requirements={"id"="\d+","username"="[a-z-A-Z-0-9-_]+","pass"="[a-z-A-Z-0-9-_]+","name"="[a-z-A-Z-0-9-\sñÑáÁéÉíÍóÓúÚü]+","mail"="[a-z-A-Z-0-9-@_.]+","isadmin"="\d+"})
     */
    public function saveOrUpdateAction( $id, $username, $pass, $name, $email, $isadmin ){
    	
    	// verifica que exista sesión
    	if (!$this->existsSession()){ return $this->redirectToLoginPage(); }
    	
    	// Establece lenguaje
    	$this->setLanguage();
    	
    	$this->init();
    	 
    	$this->logger->info("BEGIN: User: saveorupdateAction( $id, $username, $pass, $name, $email, $isadmin )");
    	
    	$json = $this->userService->saveOrUpdate($id, $username, $pass, $name, $email, $isadmin);   	
    	
    	$jsonResponse = $this->getResponseStructure($json);
    	
    	$response = new Response(json_encode($jsonResponse));
    	
    	$response->headers->set('Content-Type', 'application/json');
    	
    	$this->logger->info("END: User: saveorupdateAction( $id, $username, $pass, $name, $email, $isadmin ) retur: ".json_encode($jsonResponse).".");
    	
    	return $response;
    	
    }
    
    /**
     * Delete a User entity.
     *
     * @Route("/delete/{id}", name="admin_user_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id){
    	
    	// verifica que exista sesión
    	if (!$this->existsSession()){ return $this->redirectToLoginPage(); }
    	
    	// Establece lenguaje
    	$this->setLanguage();
    	
    	$this->init();
    	
    	$this->logger->info("BEGIN: User: deleteAction($id)");
    
    	$json = $this->userService->remove($id);
    	
    	$jsonResponse = $this->getResponseStructure($json);
    	 
    	$response = new Response(json_encode($jsonResponse));
    	
    	$response->headers->set('Content-Type', 'application/json');
    	
    	$this->logger->info("END: User: deleteAction($id)");
    
    	return $response;
    }
    
    
    /**
     * @Route("/isunique/{field}/{value}",name="_admin_user_field_unique",requirements={"field"="[a-z-A-Z-0-9-]+","value"="[a-z-A-Z-0-9-@_.]+"})
     */
    public function isMailUniqueAction( $field, $value ){
    
    	// verifica que exista sesión
    	if (!$this->existsSession()){ return $this->redirectToLoginPage(); }
    	 
    	// Establece lenguaje
    	$this->setLanguage();
    	 
    	$this->init();
    
    	$this->logger->info("BEGIN: User: isMailUniqueAction($field, $value)");
    
    	$json = $this->userService->isUniqueAction($field,$value);
   
    	$jsonResponse = $this->getResponseStructure($json);
    
    	$response = new Response(json_encode($jsonResponse));
    
    	$response->headers->set('Content-Type', 'application/json');
    
    	$this->logger->info("END: User: isMailUniqueAction($field, $value) return: ".json_encode($jsonResponse).".");
    
    	return $response;
    
    }
   
}
