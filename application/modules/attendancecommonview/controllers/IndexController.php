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
class Attendancecommonview_IndexController extends Zend_Controller_Action{

	public function init() {
		$this->view->pageTitle=$this->view->translate("Attendance");

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
// 		$checkaccess = $access->accessRights('Attendance',$this->view->globalvalue[0]['name'],'attendanceaddAction');
// 		if (($checkaccess != NULL)) {

		//view
		$this->view->title = $this->view->translate("Attendance");
		$path = $this->view->baseUrl();

		$this->view->attendance_id=$attendance_id=$this->_request->getParam('attendance_id');
		$fetchattendance=new Attendance_Model_Attendance();
		$this->view->fetchattendance=$fetchattendance1=$fetchattendance->fetchattendancedetailsforID($attendance_id);
		foreach($fetchattendance1 as $fetchattendance1){$this->view->count1=10; }
		
		$this->view->fetchMembers=$fetchMembers=$fetchattendance->fetchMembers_attendance_ID($attendance_id);
		
// 		} else {
// 		$this->_redirect('index/index');
// 		}
	}
}

