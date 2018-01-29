<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Symfony\Component\HttpFoundation\Session\Session;
use Behat\Behat\Tester\Exception\PendingException;
use GuzzleHttp\Client;

use Behat\Mink\Exception\UnsupportedDriverActionException;

use Behat\MinkExtension\Context\MinkContext;

use Behat\Mink\Driver\BrowserKitDriver;
use Symfony\Component\BrowserKit\Cookie;

define('SCREENSHOT_PATH', '/Users/lmmartin/00-factoria.php/proyectos/gma/screenshots');
define('SCREENSHOT_URL', 'http://localhost/screenshots');
define('HTML_DUMP_PATH', '/Users/lmmartin/00-factoria.php/proyectos/gma/screenshots');
define('HTML_DUMP_URL', 'http://localhost/screenshots');

/**
 * Defines application features from the specific context.
 */
class LoginContext extends MinkContext {
	
	private $systeUsers = array();
	
	private $windowSize = array();
	
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct(Session $session){
    	
    	//$this->useContext('mink', new MinkContext());
    	$this->systeUsers= array(
    			"superadmin" => "toor00", // Superadministrador
    			"juan" => "jmendez00", // Administrador
    			"inmacerezo" => "inmacerezo00" // Usuarios normal
    	);
    	
    	$this->windowSize= array(
    			"small" => array( "height" => 400, "width" => 620 ),
    			"medium" => array( "height" => 900, "width" => 1440 ),
    			"large" => array( "height" => 900, "width" => 1440 ),
    			"whatever" => null
    	);
    	
    }
    
    //-------------------------------------------------------------------------
    // BEGIN: Utiles
    //-------------------------------------------------------------------------
    
    /**
     * @BeforeStep @javascript
     */
    public function beforeStep($event)
    {
    	$text = $event->getStep()->getText();
    	if (preg_match('/(follow|press|click|submit)/i', $text)) {
    		$this->ajaxClickHandler_before();
    	}
    }
    
    /**
     * @AfterStep @javascript
     */
    public function afterStep($event)
    {
    	
    	$text = $event->getStep()->getText();
    	if (preg_match('/(follow|press|click|submit)/i', $text)) {
    		$this->ajaxClickHandler_after();
    	}
    }
    
    /**
     * Hook into jQuery ajaxStart and ajaxComplete events.
     * Prepare __ajaxStatus() functions and attach them to these events.
     * Event handlers are removed after one run.
     */
    public function ajaxClickHandler_before()
    {
    	$javascript = <<<JS
window.jQuery(document).one('ajaxStart.ss.test', function(){
    window.__ajaxStatus = function() {
        return 'waiting';
    };
});
window.jQuery(document).one('ajaxComplete.ss.test', function(){
    window.__ajaxStatus = function() {
        return 'no ajax';
    };
});
JS;
    	$this->getSession()->executeScript($javascript);
    }
    
    /**
     * Wait for the __ajaxStatus()to return anything but 'waiting'.
     * Don't wait longer than 5 seconds.
     */
    public function ajaxClickHandler_after()
    {
    	$this->getSession()->wait(5000,
    			"(typeof window.__ajaxStatus !== 'undefined' ?
                window.__ajaxStatus() : 'no ajax') !== 'waiting'"
    	);
    }
    
    /**
     * @AfterStep
     */
    public function dumpInfoAfterFailedStep($event)
    {
    	
    	if (!$event->getTestResult()->isPassed())
    	{
    		$session = $this->getSession();
    		$page = $session->getPage();
    		$driver = $session->getDriver();
    		$message = '';
    
    		$fileName = date('YmdHis') . '_' . uniqid();
    
    		if (defined('HTML_DUMP_PATH'))
    		{
    			if (!file_exists(HTML_DUMP_PATH))
    			{
    				mkdir(HTML_DUMP_PATH);
    			}
    
    			$date = date('Y-m-d H:i:s');
    			$url = $session->getCurrentUrl();
    			$html = $page->getContent();
    
    			$html = "<!-- HTML dump from behat  \nDate: $date  \nUrl:  $url  -->\n " . $html;
    
    			$htmlCapturePath = HTML_DUMP_PATH . '/' . $fileName . '.html';
    			file_put_contents($htmlCapturePath, $html);
    
    			$message .= "\nHTML saved to: " . HTML_DUMP_PATH . "/". $fileName . ".html";
    			$message .= "\nHTML available at: " . HTML_DUMP_URL . "/". $fileName . ".html";
    		}
    
    		if ($driver instanceof \Behat\Mink\Driver\Selenium2Driver && defined('SCREENSHOT_PATH'))
    		{
    			if (!file_exists(SCREENSHOT_PATH))
    			{
    				mkdir(SCREENSHOT_PATH);
    			}
    
    			$screenshot = $driver->getScreenshot();
    			$screenshotFilePath = SCREENSHOT_PATH . '/' . $fileName . '.png';
    			file_put_contents($screenshotFilePath, $screenshot);
    
    			$message .= "\nScreenshot saved to: " . SCREENSHOT_PATH . "/". $fileName . ".png";
    			$message .= "\nScreenshot available at: " . SCREENSHOT_URL . "/". $fileName . ".png";
    		}
    
    		
    		print_r($message);
    	}
    }
    
    //-------------------------------------------------------------------------
    // END: Utiles
    //-------------------------------------------------------------------------
    

    /**
     * @Given /^I press "([^"]*)" button$/
     */
    public function stepIPressButton($button){
    	$page = $this->getSession()->getPage();
    
    	$button_selector = array('link_or_button', "'$button'");
    	$button_element = $page->find('named', $button_selector);
    
    	if (null === $button_element) {
    		throw new Exception("'$button' button not found");
    	}
    
    	$this->ajaxClickHandler_before();
    	$button_element->click();
    	$this->ajaxClickHandler_after();
    }
    
    /**
     * @Then /^I wait for the error box to appear$/
     */
    public function iWaitForTheErrorBoxToAppear()
    {
    	$this->getSession()->wait(1000,
    			"$('.idMensajeAlerta').children().length > 0"
    	);
    }
    
    /**
     * @When I wait go :arg1 for :arg2 seconds
     */
    public function iWaitGoForSeconds($arg1, $arg2)
    {
    	
    	if ($arg1=="/"){
    		$this->getSession()->wait($arg2+1000,
    				"$('.idLinkLogout').children().length > 0"
    		);
    	}else if ($arg1=="/admin/user/"){
    		$this->getSession()->wait($arg2+1000,
    				"$('.idLinkLogout').children().length > 0"
    		);
    	}else {
    		
    		// TOD Diferencia Login del resto!!!
    		$this->getSession()->wait($arg2+1000,
    				"$('.idLinkLogout').children().length > 0"
    		);
    	}

    }
    
   
    /**
     * @Given I am authenticated as :arg1
     */
    public function iAmAuthenticatedWitheUserAndPass($arg1)
    {
    	$this->visitPath('/login/authentication/'.$arg1.'/'.$this->systeUsers[$arg1]);
    }
    
    
    /**
     * @When I wait :arg1 seconds
     */
    public function iWaitSeconds($arg1)
    {
    	$this->getSession()->wait($arg1+1000);
    }
    
    /**
     * @Given /^I reset the session$/
     */
    public function iResetTheSession() {
    	$this->getSession()->reset();
    }
    
    /**
     * @When a :arg1 window size is being used
     */
    public function aWindowSizeIsBeingUsed($arg1){
    	$this->getSession()->resizeWindow($this->windowSize[$arg1]["width"], $this->windowSize[$arg1]["height"], 'current');
    }
    
}
