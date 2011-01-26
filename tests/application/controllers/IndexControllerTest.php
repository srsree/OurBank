<?php
/*
############################################################################
#  This file is part of OurBank.
############################################################################
#  OurBank is free software: you can redistribute it and/or modify
#  it under the terms of the GNU Affero General Public License as
#  published by the Free Software Foundation, either version 3 of the
#  License, or (at your option) any later version.
############################################################################
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU Affero General Public License for more details.
############################################################################
#  You should have received a copy of the GNU Affero General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.
############################################################################
*/
?>

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
