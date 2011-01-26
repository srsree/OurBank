<?php

class IndexControllerTest extends ControllerTestCase  
{
   
	public function testIndexWithMessageAction()
	{
        $this->getRequest()
        	 ->setParams(array("m" => "test message"))
        	 ->setMethod('GET');
        $this->dispatch('/');
        $this->assertAction("index");
		$this->assertController("index");
		$this->assertXpathContentContains("id('message')", "test message");
		
	}
	public function testIndexNoMessageAction()
	{
        $this->dispatch('/');
        $this->assertAction("index");
		$this->assertController("index");
        $this->assertResponseCode(200);
		$this->assertXpathContentContains("id('message')", "no message");	
	}
	public function testAboutAction()
	{
        $this->dispatch("/index/about");
        $this->assertController("index");
        $this->assertAction("about");	
		$this->assertResponseCode(200);
	}
}
