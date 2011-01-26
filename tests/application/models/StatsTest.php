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
require_once ('../application/models/Stats.php');

class Model_StatsTest extends ControllerTestCase 
{
	
	/**
	 * @var Model_Stats
	 */
	protected $stats;
	
	public function setUp()
	{
		parent::setUp();		
		$this->stats = new Model_Stats();
	}
	
	public function testCanAddCountry()
	{
		$testCountry = "Canada";
		$this->stats->AddCountry($testCountry);
		$countries = $this->stats->GetCountries();
		foreach ($countries as $country)
		{
			if ($testCountry == $country)
			{
				$this->assertEquals($country , $testCountry);			
				break;
			}
				
		}
	}
	


}