<?php

namespace Mapal\GEPBundle\Service;

class CoreService{
	
	protected $logger;
	
	protected $controller;
	
	protected $systemParamService;
	
	public function initService( $controller ){
				
		$this->logger = $controller->get('logger');
		
		$this->controller = $controller;
		
		$this->systemParamService = $controller->systemParamService;
		
		return $this;
		
	}
	
	public function getMenu(){
		
		$menu = array();
		
		$idUsuarioActual = null;
		$user = null;
		$controller = $this->controller;
		$session = $controller->getRequest()->getSession();
		if ($session->has($controller::$sessionVarName)){
			$user = $session->get($controller::$sessionVarName);
			$idUsuarioActual = $user->getId();
		}
		
		if ($idUsuarioActual>0){
			$menu[] = array ("id"=>"idLinkHome","name"=>$this->controller->get('translator')->trans("gep.link.home"),"link"=>"/");
			if ($user->getIsAdmin()=="1"){
				$menu[] = array ("id"=>"idLinkUser","name"=>$this->controller->get('translator')->trans("gep.link.user"),"link"=>"/admin/user");
			}
			$idSystemParam = $this->systemParamService->get("adminid","999999999");
			if ($idUsuarioActual==$idSystemParam['value']){
				$menu[] = array ("id"=>"idLinkSystemParam","name"=>$this->controller->get('translator')->trans("gep.link.systemparam"),"link"=>"/admin/system/param");
			}
			$menu[] = array ("id"=>"idLinkLogout","name"=>$this->controller->get('translator')->trans("gep.link.logout"),"link"=>"/logout");
		}
		
		return $menu;
		
	}
	
	//------------------------------------------------------------------------------------------------------------------------------
	// BEGIN: Utiles
	//------------------------------------------------------------------------------------------------------------------------------
	
	// Generic methods
	
	/**
	 * Función para saber el numero de semanas que tiene un mes dado
	 * Tiene que recibir el año y mes
	 * Devuelve un array con el numero de la primera semana y la ultima
	 */
	protected function semanasMes($year,$month) {
		# Obtenemos el ultimo dia del mes
		$ultimoDiaMes=date("t",mktime(0,0,0,$month,1,$year));
		# Obtenemos la semana del primer dia del mes
		$primeraSemana=date("W",mktime(0,0,0,$month,1,$year));
		# Obtenemos la semana del ultimo dia del mes
		$ultimaSemana=date("W",mktime(0,0,0,$month,$ultimoDiaMes,$year));
		if ($ultimaSemana=='01'){
			$ultimaSemana = $this->NumeroSemanasTieneUnAno($year);
		}
		# Devolvemos en un array los dos valores
		return array($primeraSemana,$ultimaSemana);
	}
	
	protected function obtenerTodasLaSemanasMes($year,$month) {
		$semanas = array();
		list($primeraSemana,$ultimaSemana) = $this->semanasMes($year,$month);
		for($i = $primeraSemana; $i<=$ultimaSemana; $i++){
			$semanas[] = (integer)$i;
		}
		return array_values($semanas);
	}
	
	/**
	 * Función para saber el numero de semanas que tiene un año dado
	 */
	protected function numeroSemanasTieneUnAno($year) {
		$date = new \DateTime();
		# Establecemos la fecha segun el estandar ISO 8601 (numero de semana)
		$date->setISODate($year, 53);
		# Si estamos en la semana 53 devolvemos 53, sino, es que estamos en la 52
		if($date->format("W")=="53")
			return "53";
			else
				return "52";
	}
	
	
	
	
	//------------------------------------------------------------------------------------------------------------------------------
	// END: Utiles
	//------------------------------------------------------------------------------------------------------------------------------
    
}