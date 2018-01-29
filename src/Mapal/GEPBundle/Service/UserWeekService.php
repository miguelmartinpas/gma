<?php

namespace Mapal\GEPBundle\Service;

use Mapal\GEPBundle\Service\CoreService;
use Mapal\GEPBundle\Entity\User;
use Mapal\GEPBundle\Entity\Week;
use Mapal\GEPBundle\Entity\Status;
use Mapal\GEPBundle\Entity\UserWeek;

class UserWeekService extends CoreService{
	
	private $userRepository;
	
	private $weekRepository;
	
	private $userWeekRepository;
	
	private $statusWeekRepository;

	
	public function initService( $controller ){
		
		// MySQL
		$this->userRepository = $controller->get('doctrine.orm.entity_manager')->getRepository('MapalGEPBundle:User');
		$this->weekRepository = $controller->get('doctrine.orm.entity_manager')->getRepository('MapalGEPBundle:Week');
		$this->statusRepository = $controller->get('doctrine.orm.entity_manager')->getRepository('MapalGEPBundle:Status');
		$this->userWeekRepository = $controller->get('doctrine.orm.entity_manager')->getRepository('MapalGEPBundle:UserWeek');
		
		parent::initService( $controller );
		
		return $this;
		
	}
	
	public function getHeaderTimeTable($year,$month){
	
		return $this->obtenerTodasLaSemanasMes($year,$month);
		
	}

	public function getTimeTable($year,$month){
	
		$timetable = array();
		
		$idUsuarioActual = null;
		$idUsuarioActualAdmin = false;
		$controller = $this->controller;
		$session = $controller->getRequest()->getSession();
		if ($session->has($controller::$sessionVarName)){
			$user = $session->get($controller::$sessionVarName);
			$idUsuarioActual = $user->getId();
			$idUsuarioActualAdmin = ($user->getIsAdmin()==1);
		}
		
		$weeksOfMonth = $this->obtenerTodasLaSemanasMes($year,$month);
	
		$weeks = $this->weekRepository->findAllWithYear($year);
		// Si no existen las crea
		if (!count($weeks)){
			$numWeeks = $this->numeroSemanasTieneUnAno($year);
			for ($weekToCreate=1;$weekToCreate<=$numWeeks;$weekToCreate++){
				$newWeek = new Week();
				$newWeek->setWeek($weekToCreate);
				$newWeek->setYear($year);
				$this->weekRepository->saveorupdate($newWeek);
			}
			$weeks = $this->weekRepository->findAllWithYear($year);
		}
		$users = $this->userRepository->findAll();
		
		if (count($users)){
			
			foreach ($users as $user){
				
				$lstUserWeeks = array();
				
				$userWeeks = $this->userWeekRepository->findWithUserAndWithYear($user,$year);
				
				// ordeno semanas normales de este año por id
				$lstWeeks = array();
				if (count($weeks)){
					foreach ($weeks as $week){
						if (in_array($week->getWeek(),$weeksOfMonth)){
							$lstWeeks[$week->getWeek()] = $week;
						}
					}
				}
				
				$array = array_values($userWeeks);
				$firstUserWeek = array_shift($array);
				
				$array = array_values($lstWeeks);
				$firstLstWeek = array_shift($array);
				
				if ( (count($userWeeks) != count($lstWeeks)) || ($firstUserWeek->getIdWeek()->getWeek()!=$firstLstWeek->getWeek()) ){
					
					// ordeno semananas del usuario del año por id
					$lstUserWeeks = array();
					if (count($userWeeks)){
						foreach ($userWeeks as $userWeek){
							if (in_array($userWeek->getIdWeek()->getWeek(),$weeksOfMonth)){
								$lstUserWeeks[$userWeek->getIdWeek()->getWeek()] = $userWeek;
							}
						}
					}	
					
					// creo las que faltan por defecto
					if (count($lstWeeks)){
						foreach ($lstWeeks as $week){
							if (in_array($week->getWeek(),$weeksOfMonth)){
								if (!isset($lstUserWeeks[$week->getWeek()])){
									$status = $this->statusRepository->findDefaultStatus();
									$userWeek = new UserWeek();
									$userWeek->setIdUser($user);
									$userWeek->setIdWeek($week);
									$userWeek->setIdStatus($status);
									$this->userWeekRepository->saveorupdate($userWeek);	
									$lstUserWeeks[$week->getWeek()] = $this->generateUserWeekStructure($userWeek);
								}else{
									$lstUserWeeks[$week->getWeek()] = $this->generateUserWeekStructure($lstUserWeeks[$week->getWeek()]);
								}
							}
						}
					}
					
				}else{
					if (count($userWeeks)){
						foreach ($userWeeks as $userWeek){
							if (in_array($userWeek->getIdWeek()->getWeek(),$weeksOfMonth)){
								$lstUserWeeks[$userWeek->getIdWeek()->getWeek()] = $this->generateUserWeekStructure($userWeek);
							}
						}
					}
				}
				
				$disableButton = "disabled";
				if ( ($idUsuarioActual == $user->getId()) || $idUsuarioActualAdmin ){
					$disableButton = "";
				}
				
				//$allName = split(" ",$user->getName());
				
				$timetable[] = array( "id"=> $user->getId(), "disablebutton"=> $disableButton, "name"=> $user->getName(), "shortname" => $user->getUser(), "email" => $user->getEmail(), "weeks" => array_values($lstUserWeeks) );
			
			}
			
		}
	
		return $timetable;
	
	}
	
	public function changeStatus($idUser,$idWeek,$idStatus){
		
		$idUsuarioActual = null;
		$idUsuarioActualAdmin = false;
		$controller = $this->controller;
		$session = $controller->getRequest()->getSession();
		if ($session->has($controller::$sessionVarName)){
			$user = $session->get($controller::$sessionVarName);
			$idUsuarioActual = $user->getId();
			$idUsuarioActualAdmin = ($user->getIsAdmin()==1);
		}
		
		if ( ($idUsuarioActual == $idUser) || $idUsuarioActualAdmin ){
		
			// Carga los objetos necesarios
			$user = $this->userRepository->find($idUser);
			$week = $this->weekRepository->find($idWeek);
			$status = $this->statusRepository->find($idStatus);
			
			// Verifica que exista el estado
			$userWeek = new UserWeek();
			$userWeek->setIdUser($user);
			$userWeek->setIdWeek($week);
			$userWeek->setIdStatus($status);
			$entityFind = $this->userWeekRepository->findComplex($userWeek);
			
			if ($entityFind!=null){
				// Si existe el estado lo elimina
				$this->userWeekRepository->remove($userWeek);
				
				// Añade nuevo estado
				$newStatus = $this->statusRepository->find($status->getIdNextStatus());	
				$userWeek->setIdStatus($newStatus);	
				$this->userWeekRepository->saveorupdate($userWeek);
			}
			
			return array( 
					"status" => "1",
					"id" => $userWeek->getIdStatus()->getId(),
					"name" => $userWeek->getIdStatus()->getName(),
					"icon" => $userWeek->getIdStatus()->getIcon(),
					"colour" => $userWeek->getIdStatus()->getColour(),
			);
			
		}else{
			return array(
					"status" => "0",
					);
		}
		
	}
	
	// Cambia de estado, al siguiente todas las semanas de un mes
	public function changeAllStatusOfMonth($idUser,$year,$month){
	
		$idUsuarioActual = null;
		$idUsuarioActualAdmin = false;
		$controller = $this->controller;
		$session = $controller->getRequest()->getSession();
		if ($session->has($controller::$sessionVarName)){
			$user = $session->get($controller::$sessionVarName);
			$idUsuarioActual = $user->getId();
			$idUsuarioActualAdmin = ($user->getIsAdmin()==1);
		}
	
		if ( ($idUsuarioActual == $idUser) || $idUsuarioActualAdmin ){
	
			// Carga los objetos necesarios
			$user = $this->userRepository->find($idUser);
			
			$userWeeks = $this->userWeekRepository->findWithUserAndWithYear($user,$year);
			
			$weeksOfMonth = $this->obtenerTodasLaSemanasMes($year,$month);
			
			// ordeno semananas del usuario del año por id
			$lstUserWeeks = array();
			if (count($userWeeks)){
				foreach ($userWeeks as $userWeek){
					if (in_array($userWeek->getIdWeek()->getWeek(),$weeksOfMonth)){
						$lstUserWeeks[$userWeek->getIdWeek()->getWeek()] = $userWeek;
					}
				}
			}
			
			$items = array();
			
			foreach ( $lstUserWeeks as $userWeek){
			
				$week = $this->weekRepository->find($userWeek->getIdWeek());
				$status = $this->statusRepository->find($userWeek->getIdStatus());
					
				// Verifica que exista el estado
				$userWeek = new UserWeek();
				$userWeek->setIdUser($user);
				$userWeek->setIdWeek($week);
				$userWeek->setIdStatus($status);
				$entityFind = $this->userWeekRepository->findComplex($userWeek);
					
				if ($entityFind!=null){
					// Si existe el estado lo elimina
					$this->userWeekRepository->remove($userWeek);
		
					// Añade nuevo estado
					$newStatus = $this->statusRepository->find($status->getIdNextStatus());
					$userWeek->setIdStatus($newStatus);
					$this->userWeekRepository->saveorupdate($userWeek);
				}
				
				$items[] = array(
						"status" => "1",
						"id" => $userWeek->getIdStatus()->getId(),
						"name" => $userWeek->getIdStatus()->getName(),
						"icon" => $userWeek->getIdStatus()->getIcon(),
						"colour" => $userWeek->getIdStatus()->getColour(),
				);
				
			}
				
			return $items;
				
		}else{
			return array(
					"status" => "0",
			);
		}
	
	}
	
	// UserWeek Methobs
	
	protected function generateUserWeekStructure($userWeek){
	
		$semanaActual = date("W");
		
		$idUsuarioActual = null;
		$controller = $this->controller;
		$session = $controller->getRequest()->getSession();
		if ($session->has($controller::$sessionVarName)){
			$user = $session->get($controller::$sessionVarName);
			$idUsuarioActual = $user->getId();
		}
		
		$colour = "";
		if ( ( ($semanaActual==$userWeek->getIdWeek()->getWeek()) && (date("Y")==$userWeek->getIdWeek()->getYear())  &&  $userWeek->getIdStatus()->getId() == 1 ) ){
			$colour = "btn-info";
		}else{
			if ( ($idUsuarioActual==$userWeek->getIdUser()->getId()) && $userWeek->getIdStatus()->getId() == 1){
				$colour = "btn-info";
			}else{
				$colour = $userWeek->getIdStatus()->getColour();
			}
		}
		
		return array(
				"status" => array(
						"id"=> $userWeek->getIdStatus()->getId(),
						"name"=> $userWeek->getIdStatus()->getName(),
						"icon"=> $userWeek->getIdStatus()->getIcon(),
						"colour"=> $colour,
				),
				"week" => array(
						"id"=> $userWeek->getIdWeek()->getId(),
						"week"=> $userWeek->getIdWeek()->getWeek(),
						"year"=> $userWeek->getIdWeek()->getYear(),
						"activo"=> (($userWeek->getIdWeek()->getYear()>=date("Y"))&&($userWeek->getIdWeek()->getYear()>=date("W")))?"true":"false",
				),
		);
	
	}
	
}