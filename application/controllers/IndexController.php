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
class IndexController extends Zend_Controller_Action {
	public function init() {
            $this->view->title = "Management";

	}

	public function indexAction() {
		$storage = new Zend_Auth_Storage_Session();
		$data = $storage->read();
		if(!$data){
			$this->_redirect('index/login');
		}
                $sessionName = new Zend_Session_Namespace('ourbank');
                $userid=$this->view->createdby = $sessionName->primaryuserid;

                $login=new App_Model_Users();
                $loginname=$login->username($userid);
                foreach($loginname as $loginname) {
	           $this->view->primaryid=$loginname['user_id'];
			$this->view->id=$loginname['id'];
                   $this->view->username=$loginname['username'];
		   $this->view->primaryrole=$loginname['name'];
                }

		$dynamic = new App_Model_Dynamic ();
       		$dynamic->dynamicaction();


    }

	function loginAction() {
		$this->_helper->layout->disableLayout();
		Zend_Date_Cities::getCityList();
		$form = new App_Form_Login();
		$this->view->form = $form;
		$this->view->message = '';
		if ($this->_request->isPost()) {
			Zend_Loader::loadClass('Zend_Filter_StripTags');
			$filter = new Zend_Filter_StripTags();
			$username = $filter->filter($this->_request->getPost('username'));
			$password = $filter->filter($this->_request->getPost('password'));
			if (empty($username)) {
				$this->view->message = 'Please provide a username.';
			} else {                                             // setup Zend_Auth adapter for a database table
				Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');
				$db = Zend_Db_Table::getDefaultAdapter();
				$authAdapter = new Zend_Auth_Adapter_DbTable($db);
				$authAdapter->setTableName('ourbank_user');
				$authAdapter->setIdentityColumn('username');
				$authAdapter->setCredentialColumn('password');
				$authAdapter->setIdentity($username);
				$authAdapter->setCredential($password);
				$auth = Zend_Auth::getInstance();
				$result = $auth->authenticate($authAdapter);
				if ($result->isValid()) {
					$data = $authAdapter->getResultRowObject(null,'password');
					$auth->getStorage()->write($data);
					$userinfo = new App_Model_Users();
					$getresult= $userinfo->userinfo($username);
					foreach($getresult as $getdata) {
						$user_id = $getdata["id"];
					}
					$sessionName = new Zend_Session_Namespace('ourbank');
					$sessionName->__set('primaryuserid',$user_id);
					$globalsession = new App_Model_Users();
					$this->view->globalvalue = $globalsession->getSession();
					$sessionName->__set('language',$this->view->globalvalue[1]);

					$this->_redirect('/index/index');
				} else { 
					$this->view->message = 'Login failed.';
				}
			}
		}
		$this->view->title = "Log in";
		$this->render();
	}

	public function logoutAction() {
		Zend_Session::destroy();
		// $storage = new Zend_Auth_Storage_Session();
		// $storage->clear();
		$this->_redirect('index/login');
	}

	public function addressAction() 
	{

	}
	public function errorAction()
	{


	}
}
