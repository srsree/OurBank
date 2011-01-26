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
class Penaltycommonview_IndexController extends Zend_Controller_Action{

	public function init() {
		$this->view->pageTitle = "Penalty";

		$globalsession = new App_Model_Users();
		$this->view->globalvalue = $globalsession->getSession();
			$this->view->username = $this->view->globalvalue[0]['username'];
			$this->view->createdby = $this->view->globalvalue[0]['id'];
		
// 		if (($this->view->globalvalue[0]['id'] == 0)) {
// 			$this->_redirect('index/logout');
// 		}
		$this->view->adm = new App_Model_Adm();
		$this->view->dateconvert = new Creditline_Model_dateConvertor();
	}

	public function indexAction() {
		//Acl
// 		$access = new App_Model_Access();
// 		$checkaccess = $access->accessRights('Institution',$this->view->globalvalue[0]['name'],'addinstitutionAction');
// 		if (($checkaccess != NULL)) {
		//index
		$this->view->title = "Penalty";

		$penaltyform=new Penalty_Form_Penalty();
		$this->view->penaltyform=$penaltyform;

		$this->view->id=$penalty_id=$this->_request->getParam('penalty_id');
		$fetchpenalty=new Penalty_Model_Penalty();
		$this->view->fetchpenalty=$fetchpenalty1=$fetchpenalty->fetchpenaltydetailsforID($penalty_id);
		foreach($fetchpenalty1 as $fetchpenalty1){$this->view->count1=10; }

// 		} else {
// 		$this->_redirect('index/index');
// 		}
	}
}

