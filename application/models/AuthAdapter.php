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
class App_Model_AuthAdapter implements Zend_Auth_Adapter_Interface
{
	protected $username;
	protected $password;
	protected $user;
	
	public function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
		$this->user = new App_Model_Users();
	}
	
	public function authenticate()
	{
		$match = $this->user->findCredentials($this->username, $this->password);
		//var_dump($match);
		if(!$match) {
			$result = new Zend_Auth_Result(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, null);
		} else {
			$user = current($match);
			$result = new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $user);
		}
		return $result;
	}
	
}