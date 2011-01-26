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
class Loanactivitywise_IndexController extends Zend_Controller_Action {
	public function init() {
		$this->view->pageTitle='Loan Activitywise';
		$this->view->type='loanactivitywise';
                $sessionName = new Zend_Session_Namespace('ourbank');
		$userid=$this->view->createdby = $sessionName->primaryuserid;
		$login=new App_Model_Users();
		$loginname=$login->username($userid);
		foreach($loginname as $loginname) {
		$this->view->username=$loginname['login_name'];
		}

	}

	public function indexAction() 
	{

		$this->view->title = "loanactivitywise";
		$dbobj = new Loanactivitywise_Model_Loanactivitywise();
		$loanname = $dbobj->loanaccountname();

 echo "<pre>";
print_r($loanname);
$count=0;
	foreach($loanname as $loname1){ 
			foreach($loanname as $loname2){ 
					if($loname1['member_id']==$loname2['member_id'] && $loname1['activity_name']==$loname2['activity_name']){
					$count++;
					} 
			}echo "<br>Count :".$count;
		
	$count=0;
	}
		$page = $this->_getParam('page',1); 
		$paginator = Zend_Paginator::factory($loanname);
		$paginator->setItemCountPerPage(5);
		$paginator->setCurrentPageNumber($page);
		$this->view->paginator = $paginator;
	
	}

}
