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
class DefaultController extends CoreController
{

	private $userWeekService;
	
	private $userService;
	
	private $weekService;
	
	public function init(){
		
		parent::init();
	
		$this->userWeekService = $this->get('mapalgep.userweek')->initService($this);
		$this->userService = $this->get('mapalgep.user')->initService($this);
		$this->weekService = $this->get('mapalgep.week')->initService($this);
	
	}
	
	/**
	 * @Route("/",name="_home")
	 * @Template("MapalGEPBundle:Default:index.html.twig")
	 */
    public function indexAction(){
    
    	// verifica que exista sesión
    	if (!$this->existsSession()){ return $this->redirectToLoginPage(); }
    	
    	// Establece lenguaje
    	$this->setLanguage();
    	
    	$this->init();
    	
        return array( 'menu' => $this->userWeekService->getMenu(),);
        
    }
    
    /**
     * @Route("/rest/timetable",name="_get_timetable")
     */
    public function getAllAction(){
    	return $this->getAllYearMonthAction(date("Y"),date("m"));
    }
    
    /**
     * @Route("/rest/timetable/{month}",name="_get_timetable_month",requirements={"year"="\d+"})
     */
    public function getAllMonthAction($month){
    	return $this->getAllYearMonthAction(date("Y"),$month);
    }
    
    /**
     * @Route("/rest/timetable/{year}/{month}",name="_get_timetable_year_month",requirements={"year"="\d+","month"="\d+"})
     */
    public function getAllYearMonthAction($year,$month){
    	 
    	// verifica que exista sesión
    	if (!$this->existsSession()){ return $this->redirectToLoginPage(); }
    	
    	// Establece lenguaje
    	$this->setLanguage();
    	
    	$this->init();
    
    	$this->logger->info("BEGIN: getAllAction()");
    	 
    	$jsonResponse = $this->getResponseStructure($this->userWeekService->getTimeTable($year,$month));
    	 
    	$response = new Response(json_encode($jsonResponse));
    	 
    	$response->headers->set('Content-Type', 'application/json');
    	 
    	$this->logger->info("END: getAllAction() return: ".json_encode($jsonResponse).".");
    	 
    	return $response;
    	 
    }
   
    
    /**
     * @Route("/rest/timetable/header/{year}/{month}",name="_get_header_timetable_year_month",requirements={"year"="\d+","month"="\d+"})
     */
    public function getHeaderTimetableAction($year,$month){
    
    	// verifica que exista sesión
    	if (!$this->existsSession()){ return $this->redirectToLoginPage(); }
    	 
    	// Establece lenguaje
    	$this->setLanguage();
    	 
    	$this->init();
    	
    	$this->logger->info("BEGIN: getHeaderTimetableAction()");
    	
    	$jsonResponse = $this->getResponseStructure($this->userWeekService->getHeaderTimeTable($year,$month));
    	
    	$response = new Response(json_encode($jsonResponse));
    	
    	$response->headers->set('Content-Type', 'application/json');
    	
    	$this->logger->info("END: getHeaderTimetableAction() return: ".json_encode($jsonResponse).".");
    	
    	return $response;
    	
    }
    
    
    /**
     * ChangeStatus
     *
     * @Route("/rest/change/status/{idUser}/{idWeek}/{idStatus}", name="_change_status",requirements={"idUser"="\d+","idWeek"="\d+","idStatus"="\d+"})
     */
    public function changeStatusAction($idUser,$idWeek,$idStatus){
    		
    	// verifica que exista sesión
    	if (!$this->existsSession()){ return $this->redirectToLoginPage(); }
    	 
    	// Establece lenguaje
    	$this->setLanguage();
    	 
    	$this->init();
    	
    	$this->logger->info("BEGIN: changeStatusAction($idUser,$idWeek,$idStatus)");
    	
    	$jsonResponse = $this->getResponseStructure($this->userWeekService->changeStatus($idUser,$idWeek,$idStatus));

    	$response = new Response(json_encode($jsonResponse));
    	
    	$response->headers->set('Content-Type', 'application/json');
    	
    	$this->logger->info("END: changeStatusAction($idUser,$idWeek,$idStatus) return: ".json_encode($jsonResponse).".");
    	
    	return $response;
    }
    
    /**
     * ChangeStatus of all mothn's week
     *
     * @Route("/rest/change/all/status/{idUser}/{year}/{month}", name="_change_all_status",requirements={"idUser"="\d+","year"="\d+","month"="\d+"})
     */
    public function changeAllStatusAction($idUser,$year,$month){
    
    	// verifica que exista sesión
    	if (!$this->existsSession()){ return $this->redirectToLoginPage(); }
    
    	// Establece lenguaje
    	$this->setLanguage();
    
    	$this->init();
    	 
    	$this->logger->info("BEGIN: changeAllStatusAction($idUser,$year,$month)");
    	 
    	$jsonResponse = $this->getResponseStructure($this->userWeekService->changeAllStatusOfMonth($idUser,$year,$month));
    
    	$response = new Response(json_encode($jsonResponse));
    	 
    	$response->headers->set('Content-Type', 'application/json');
    	 
    	$this->logger->info("END: changeAllStatusAction($idUser,$year,$month) return: ".json_encode($jsonResponse).".");
    	 
    	return $response;
    }
    
}
