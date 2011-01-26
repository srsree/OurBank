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
class Meetingmain_IndexController extends Zend_Controller_Action {


	public function init() {
		$this->view->pageTitle='Community Meetings';
                $sessionName = new Zend_Session_Namespace('ourbank');
                $userid=$this->view->createdby = $sessionName->primaryuserid;
                $login=new App_Model_Users();
                $loginname=$login->username($userid);
                foreach($loginname as $loginname) {
                $this->view->username=$loginname['username'];
                }
	}

	public function indexAction(){
		$this->view->title='Meeting';
		$storage = new Zend_Auth_Storage_Session();
		$data = $storage->read();
		if(!$data){
			$this->_redirect('index/login');
		}

	}
}