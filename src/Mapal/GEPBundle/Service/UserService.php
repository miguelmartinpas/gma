<?php

namespace Mapal\GEPBundle\Service;

use Mapal\GEPBundle\Service\CoreService;
use Mapal\GEPBundle\Entity\User;
use Mapal\GEPBundle\Form\UserType;

class UserService extends CoreService{
	
	private $userRepository;
		
	public function initService( $controller ){
		
		// MySQL
		$this->userRepository = $controller->get('doctrine.orm.entity_manager')->getRepository('MapalGEPBundle:User');
		
		parent::initService( $controller );
		
		return $this;
		
	}
	
	public function findAll(){
		
		$lstUsers = array();
		
		$users = $this->userRepository->findAll();
		
		if (count($users)){
			foreach ( $users as $user ){
				$lstUsers[] = array(					
						"id" => $user->getId(),
						"user" => $user->getUser(),
						//"pass" => $user->getPass(),
						"name" => $user->getName(),
						"email" => $user->getEmail(),
						"isAdmin" => $user->getIsAdmin(),
				);
			}
			
		}
		
		return $lstUsers;
		
	}
	
	public function find($id){
	
		return $this->userRepository->find($id);
	
	}
	
	public function saveOrUpdate($id, $username, $pass, $name, $email, $isAdmin){
		
		$user = new User();
		if ($id>0){
			$user->setId($id);
		}
		$user->setUser($username);
		$user->setPass(md5($pass));
		$user->setName($name);
		$user->setEmail($email);
		$user->setIsAdmin($isAdmin);
		
		$id = $this->userRepository->saveOrUpdate($user);
		
		return array ("id"=>$id);
		
	}
	
	public function remove($id){
	
		$user = $this->userRepository->find($id);
		
		if ($user!=null){
		
			$this->userRepository->remove($user);
		
			$user = $this->userRepository->find($id);
		
			return ($user==null);
			
		}
		
		return false;
		
	}
	
	public function getUserByUserAndPass($user,$pass){
		
		$superAdmin = $this->getSuperAdmin($user,$pass);
		
		if ( $superAdmin != null ){
			return $superAdmin;
		}
		
		return $this->userRepository->getUserByUserAndPass($user,$pass);
		
	}
	
	public function isUniqueAction($field,$value){
		
		$json = array( "isUnique" => true );
		
		$users = $this->userRepository->findAll();
		
		if (count($users)){
			foreach ( $users as $user ){
				if ( $field=="email" && $user->getEmail() == $value ){
					$json["isUnique"] = false;
					break;
				}else if ( $field=="user" && $user->getUser() == $value ){
					$json["isUnique"] = false;
					break;
				}
			}
				
		}
		
		return $json;
		
	}
	
	private function getSuperAdmin($user,$pass){
		
		$userSystemParam = $this->systemParamService->get("adminname","superadmin");
		$passSystemParam = $this->systemParamService->get("adminpass","5a5bffd1b2ad0285463636f8527cfd15");
		$idSystemParam = $this->systemParamService->get("adminid","999999999");
				
		if ( ($user == $userSystemParam["value"]) &&  (md5($pass) == $passSystemParam["value"]) ){
			
			$user = new User();
			$user->setId( $idSystemParam["value"] );
			$user->setUser( $userSystemParam["value"] );
			$user->setIsAdmin(1);
			
			return $user;
			
		}
		
		return null;
		
	}
    
}