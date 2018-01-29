<?php

namespace Mapal\GEPBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserServiceTest extends WebTestCase{
 
    private $userService;
    
    public function setUp(){
    	
    	$client = static::createClient();
		$container = $client->getContainer();
		//$kernel    = $client->getKernel();
		
    	$this->userService = $container->get('mapalgep.user')->initService($container);
    		
    }
    
    public function testVerdadero(){
    	$this->assertTrue(true);
    }
    
    /*
    public function testReverseRequest() {
    	
    	$text = "This is a text";
    	
    	$xml = $this->voiceWorksService->reverseRequest("This is a text");
    	
    	$textToFind = "<body><string>".$text."</string></body>";
    	
		$this->assertTrue(strpos($xml,$textToFind)>0);
	}
	
	public function testPingRequest(){
	
		$text = "This is a text";
		 
		$xml = $this->voiceWorksService->pingRequest("This is a text");
		 
		$textToFind = "<body><echo>".$text."</echo></body>";
		 
		$this->assertTrue(strpos($xml,$textToFind)>0);
		
	}
	
	public function testPingResponse(){
	
		$text = "This is a text";
		
		$xml='<?xml version="1.0" encoding="UTF-8"?>
<ping_request><header><type>ping_request</type><sender>VOICEWORKS</sender><recipient>DEMO</recipient><reference>ping_request_12345</reference><timestamp>2014-12-06T15:50:18.950+01:00</timestamp></header><body><echo>'.$text.'</echo></body></ping_request>';
			
		$xml = $this->voiceWorksService->pingResponse($xml);
			
		$textToFind = "<body><echo>".$text."</echo></body>";
			
		$this->assertTrue(strpos($xml,$textToFind)>0);
	
	}

	
	public function testPingResponseWithBadXML(){
	
		$text = "This is a text";
		
		$xml='VOICEWORKS</sender><recipient>DEMO</recipient><reference>ping_request_12345</reference><timestamp>2014-12-06T15:50:18.950+01:00</timestamp></header><body><echo>'.$text.'</echo></body></ping_request>';
			
		$xml = $this->voiceWorksService->pingResponse($xml);
			
		$textToFind = "<code>404</code>";
			
		$this->assertTrue(strpos($xml,$textToFind)>0);
	
	}
	
	public function testPingResponseWithoutXML(){
		
		$xml = $this->voiceWorksService->pingResponse('');
			
		$textToFind = "<code>404</code>";
			
		$this->assertTrue(strpos($xml,$textToFind)>0);
	
	}

	 public function testReverseResponse(){
	
	 	$text = "This is a text";
	 	
	 	$xml='<?xml version="1.0" encoding="UTF-8"?>
<reverse_request><header><type>reverse_request</type><sender>VOICEWORKS</sender><recipient>DEMO</recipient><reference>reverse_request_12345</reference><timestamp>2014-12-06T15:50:18.950+01:00</timestamp></header><body><string>'.$text.'</string></body></reverse_request>';
			
	 	$xml = $this->voiceWorksService->reverseResponse($xml);

	 	$textToFind = "<reverse>txet a si sihT</reverse>";
	 		
	 	$this->assertTrue(strpos($xml,$textToFind)>0);
	
	 }
	
	
	
	public function testReverseResponseWithBadXML(){
	
		$text = "This is a text";
		 
		$xml='>reverse_request</type><sender>VOICEWORKS</sender><recipient>DEMO</recipient><reference>reverse_request_12345</reference><timestamp>2014-12-06T15:50:18.950+01:00</timestamp></header><body><string>'.$text.'</string></body></reverse_request>';
			
		$xml = $this->voiceWorksService->reverseResponse($xml);
		
		$textToFind = "<code>404</code>";
		
		$this->assertTrue(strpos($xml,$textToFind)>0);
	
	}
	
	public function testReverseResponseWithoutXML(){
	
		$xml = $this->voiceWorksService->reverseResponse('');
	
		$textToFind = "<code>404</code>";
	
		$this->assertTrue(strpos($xml,$textToFind)>0);
	
	}
    
    */
    
}
