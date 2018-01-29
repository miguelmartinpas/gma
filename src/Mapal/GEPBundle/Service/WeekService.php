<?php

namespace Mapal\GEPBundle\Service;

use Mapal\GEPBundle\Service\CoreService;
use Mapal\GEPBundle\Entity\Week;

class WeekService extends CoreService{
	
	private $weekRepository;
	
	public function initService( $controller ){
		
		// MySQL
		$this->weekRepository = $controller->get('doctrine.orm.entity_manager')->getRepository('MapalGEPBundle:Week');
		
		parent::initService( $controller );
		
		return $this;
		
	}
	
	public function findAll(){
		
		return $this->weekRepository->findAll();
		
	}
	
	public function find($id){
	
		return $this->weekRepository->find($id);
	
	}
	
	public function saveOrUpdate(Week $week){
		
		$this->weekRepository->persist($week);
		$this->weekRepository->flush();
		return $week->getId();
		
	}
	
	public function remove(Week $week){
	
		$this->weekRepository->remove($week);
		$this->weekRepository->flush();
	
	}
	
	public function findAllWithYear( $year ){
		
		return $this->weekRepository->findAllWithYear($year);
		
	}
	
}