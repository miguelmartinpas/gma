<?php

namespace Mapal\GEPBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase{
	
	private $client = null;
	
	public function setUp(){
		 
		$this->client = static::createClient();
		//$container = $client->getContainer();
		//$kernel    = $client->getKernel();
	
	}
	
	public function testLoginOk(){
	
		$this->client->request('GET', '/login/authentication/superadmin/toor00');
	
		$response = $this->client->getResponse();
		
		$data = json_decode($response->getContent(),true);
	
		$this->assertTrue($data['status']==1);
	
	}
	
	public function testLoginKo(){
	
		$this->client->request('GET', '/login/authentication/superadmin/toor01');
	
		$response = $this->client->getResponse();
	
		$data = json_decode($response->getContent(),true);
	
		$this->assertTrue($data['status']==0);
	
	}
	
	public function testRestTimeTableWihtoutProblem(){
		
		$year = 2015;
		
		$month = 1;
		
		$this->client->request('GET', '/login/authentication/superadmin/toor00');
		
		$response = $this->client->getResponse();
		
		$data = json_decode($response->getContent(),true);
		
		if ($data['status']==1){
		
			$this->client->request('GET', '/rest/timetable/'.$year."/".$month);
			
			$response = $this->client->getResponse();
			
			$data = json_decode($response->getContent(), true);
	
			$this->assertTrue(!$data['error']);
			
		}
		
	}
	
	public function testRestTimeTableHeader(){
	
		$year = 2015;
	
		$month = 1;
		
		$weeks = 5;
	
		$this->client->request('GET', '/login/authentication/superadmin/toor00');
	
		$response = $this->client->getResponse();
	
		$data = json_decode($response->getContent(),true);
	
		if ($data['status']==1){
				
			$this->client->request('GET', '/rest/timetable/header/'.$year."/".$month);
				
			$response = $this->client->getResponse();
	
			$data = json_decode($response->getContent(),true);
			
			$this->assertTrue(count($data['json'])==$weeks);
	
		}
	
	}
	
	public function testRestTimeTableTestData(){
	
		$year = 2015;
	
		$month = 1;
	
		$this->client->request('GET', '/login/authentication/superadmin/toor00');
	
		$response = $this->client->getResponse();
	
		$data = json_decode($response->getContent(),true);
	
		if ($data['status']==1){
			
			$this->client->request('GET', '/rest/timetable/header/'.$year."/".$month);
				
			$response = $this->client->getResponse();
	
			$data = json_decode($response->getContent(),true);
			
			$weeks = count($data['json']);
	
			$this->client->request('GET', '/rest/timetable/'.$year."/".$month);
				
			$response = $this->client->getResponse();
				
			$data = json_decode($response->getContent(), true);
			
			$todosTienenMismasSemanas = true;
			
			foreach ($data['json'] as $user){
				
				if (count($user['weeks'])!=$weeks){
					$todosTienenMismasSemanas = false;
					break;
				}
				
			}

			$this->assertTrue($todosTienenMismasSemanas);
				
		}
	
	}
	
	public function testRestTimeTableTestData022015(){
	
		$year = 2015;
	
		$month = 2;
	
		$this->client->request('GET', '/login/authentication/superadmin/toor00');
	
		$response = $this->client->getResponse();
	
		$data = json_decode($response->getContent(),true);
	
		if ($data['status']==1){
				
			$this->client->request('GET', '/rest/timetable/header/'.$year."/".$month);
	
			$response = $this->client->getResponse();
	
			$data = json_decode($response->getContent(),true);
				
			$weeks = count($data['json']);
	
			$this->client->request('GET', '/rest/timetable/'.$year."/".$month);
	
			$response = $this->client->getResponse();
	
			$data = json_decode($response->getContent(), true);
				
			$todosTienenMismasSemanas = true;
				
			foreach ($data['json'] as $user){
	
				if (count($user['weeks'])!=$weeks){
					$todosTienenMismasSemanas = false;
					break;
				}
	
			}
	
			$this->assertTrue($todosTienenMismasSemanas);
	
		}
	
	}
	
	/*
	public function testPingRequest(){
		
		 $client = static::createClient();
		 
		 $text = "This is a text";
		 
		 $textToFind = $text;
	
		 $crawler = $client->request('GET', '/rest/ping/request/'.$text);
		 
		 $this->assertTrue($crawler->filter('html:contains("'.$textToFind.'")')->count() > 0);
		
	}
	
	public function testReverseRequest(){
	
		$client = static::createClient();
			
		$text = "This is a text";
			
		$textToFind = $text;
	
		$crawler = $client->request('GET', '/rest/reverse/request/'.$text);
			
		$this->assertTrue($crawler->filter('html:contains("'.$textToFind.'")')->count() > 0);
	
	}
	
	public function testPingResponse(){
	
		$client = static::createClient();
			
		$text = "This is a text";
		
		$xml='<?xml version="1.0" encoding="UTF-8"?>
<ping_request><header><type>ping_request</type><sender>VOICEWORKS</sender><recipient>DEMO</recipient><reference>ping_request_12345</reference><timestamp>2014-12-06T15:50:18.950+01:00</timestamp></header><body><echo>'.$text.'</echo></body></ping_request>';
			
		$textToFind = $text;
	
		$crawler = $client->request('POST', '/rest/ping',array("xml"=>$xml));

		$this->assertTrue(strpos($crawler->text(),$textToFind) > 0);
	
	}
	
	public function testPingResponseWithGetCall(){
	
		$client = static::createClient();
			
		$text = "This is a text";
	
		$xml='</sender><recipient>DEMO</recipient><reference>ping_request_12345</reference><timestamp>2014-12-06T15:50:18.950+01:00</timestamp></header><body><echo>'.$text.'</echo></body></ping_request>';
			
		$textToFind = 'Method Not Allowed';
	
		$crawler = $client->request('GET', '/rest/ping', array('xml' => $xml));
		
		$this->assertTrue($crawler->filter('html:contains("'.$textToFind.'")')->count() > 0);
	
	}

	public function testPingResponseWithBadXML(){
	
		$client = static::createClient();
			
		$text = "This is a text";
	
		$xml='</sender><recipient>DEMO</recipient><reference>ping_request_12345</reference><timestamp>2014-12-06T15:50:18.950+01:00</timestamp></header><body><echo>'.$text.'</echo></body></ping_request>';
	
		$crawler = $client->request('POST', '/rest/ping', array('xml' => $xml));
		
		$this->assertTrue($client->getResponse()->isNotFound());
	
	}
	
	public function testReverseResponse(){
	
		$client = static::createClient();
			
		$text = "This is a text";
	
		$xml='<?xml version="1.0" encoding="UTF-8"?>
<reverse_request><header><type>reverse_request</type><sender>VOICEWORKS</sender><recipient>DEMO</recipient><reference>reverse_request_12345</reference><timestamp>2014-12-06T15:50:18.950+01:00</timestamp></header><body><string>'.$text.'</string></body></reverse_request>';
			
		$textToFind = 'txet a si sihT';
	
		$crawler = $client->request('POST', '/rest/reverse', array('xml' => $xml));
		
		$this->assertTrue(strpos($crawler->text(),$textToFind) > 0);
	
	}
	
	public function testReverseResponseWithGetCall(){
	
		$client = static::createClient();
			
		$text = "This is a text";
	
		$xml='<?xml version="1.0" encoding="UTF-8"?>
<reverse_request><header><type>reverse_request</type><sender>VOICEWORKS</sender><recipient>DEMO</recipient><reference>reverse_request_12345</reference><timestamp>2014-12-06T15:50:18.950+01:00</timestamp></header><body><string>'.$text.'</string></body></reverse_request>
		';	
		$textToFind = 'Method Not Allowed';
	
		$crawler = $client->request('GET', '/rest/reverse', array('xml' => $xml));
	
		$this->assertTrue($crawler->filter('html:contains("'.$textToFind.'")')->count() > 0);
	
	}
	
	public function testReverseResponseWithBadXML(){
	
		$client = static::createClient();
			
		$text = "This is a text";
	
		$xml='<?xml version="1.0" encoding="UTF-8"?>
<reverse_request><header><type>reverse_request</type><sender>VOICEWORKS';
				
		$textToFind = "404";
	
		$crawler = $client->request('POST', '/rest/reverse', array('xml' => $xml));
			
		$this->assertTrue($client->getResponse()->isNotFound());
	
	}
	*/
	
	
}
