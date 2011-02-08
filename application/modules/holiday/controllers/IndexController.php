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
class Holiday_IndexController extends Zend_Controller_Action
{
	public function init() 
	{
		$this->view->pageTitle='Holiday';
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
		$this->view->createdby = $this->view->globalvalue[0]['id'];
//		$this->view->username = $this->view->globalvalue[0]['username'];
//        if (($this->view->globalvalue[0]['id'] == 0)) {
//             $this->_redirect('index/logout');
 //       }
		$this->view->adm = new App_Model_Adm();
	}

	public function indexAction() 
	{
               
		$this->view->title = "Holiday";
//		$storage = new Zend_Auth_Storage_Session();
//		$data = $storage->read();
//		if(!$data){
//			$this->_redirect('index/login');
//		}
// 		$category = new Category_Model_Category();
// 		$categorydetails=$category->getCategoryinformation();
// 		$this->view->changelog=$category->getUpdatesinformation();
// calling search form
		$searchForm = new Holiday_Form_Search();
		$this->view->form = $searchForm;
//calling holiday model
		$holiday = new Holiday_Model_Holiday();
		$result = $holiday->getHolidayDetails();
//listing office names
$officename = $this->view->adm->viewRecord("ourbank_office","id","DESC");
			foreach($officename as $officename){
				$searchForm->office_id->addMultiOption($officename['id'],$officename['name']);
			}
//pagination
		$page = $this->_getParam('page',1);
		$paginator = Zend_Paginator::factory($result);
		$paginator->setItemCountPerPage(5);
		$paginator->setCurrentPageNumber($page);
		$this->view->paginator = $paginator;
//search function
		if ($this->_request->isPost() && $this->_request->getPost('Search')) {
			$formData = $this->_request->getPost();
                        $this->view->errormsg="Record not found....Try again...";
			if ($this->_request->isPost()) {
				$formData = $this->_request->getPost();
				if ($searchForm->isValid($formData)) {
//getting values from search form
					$result = $holiday->SearchHoliday($searchForm->getValues());
					$page = $this->_getParam('page',1);
					$paginator = Zend_Paginator::factory($result);
                                         if(!$paginator)
                                        {          $this->view->errormsg="Record not found....Try again...";
                                        }
					$paginator->setItemCountPerPage(5);
					$paginator->setCurrentPageNumber($page);
					$this->view->paginator = $paginator;
				}
			}
		}
	}
	public function holidayaddAction() 
	{
//calling holiday form		
		$holidayForm = new Holiday_Form_Holiday();
		$this->view->form = $holidayForm;
//listing office names
$officename = $this->view->adm->viewRecord("ourbank_office","id","DESC");
			foreach($officename as $officename){
				$holidayForm->office_id->addMultiOption($officename['id'],$officename['name']);
			}
//submit action
		if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
				$formData = $this->_request->getPost();
				if ($this->_request->isPost()) {
					if ($holidayForm->isValid($formData)) {
//getting the values from search form
					$id = $this->view->adm->addRecord("ourbank_holiday",$holidayForm->getValues());
						$this->_redirect('/holiday');
				}
			}
		}
		
	}
	
	public function holidayeditAction() 
	{
//calling the holiday form
			$holidayForm = new Holiday_Form_Holiday();
			$this->view->form = $holidayForm;
//getting id
			$id=$this->_getParam('id');
			$this->view->id = $id;
// calling holiday model
			$holiday = new Holiday_Model_Holiday;
//listing office names
			$officename = $this->view->adm->viewRecord("ourbank_office","id","DESC");
			foreach($officename as $officename){
				$holidayForm->office_id->addMultiOption($officename['id'],$officename['name']);
			}
//displaying the values to edit
			$holidaydetails = $holiday->getHoliday($id);
			$holidayForm->populate($holidaydetails[0]);
//update action					
        if ($this->_request->isPost() && $this->_request->getPost('Update')) {
	    if ($this->_request->isPost()) {
		$formData = $this->_request->getPost();
		if ($holidayForm->isValid($formData)) {
								$id=$this->_request->getParam("id");

//update and edit
  $previousdata = $this->view->adm->editRecord("ourbank_holiday",$id);
					$this->view->adm->updateLog("ourbank_holiday_log",$previousdata[0],$this->view->createdby);
					//update 					
					$this->view->adm->updateRecord("ourbank_holiday",$id,$holidayForm->getValues());
					$this->_redirect("/holiday");

}
				}
 			}
    }
	public function holidayviewAction() 
	{
		//Acl
        $id=$this->_request->getParam('id');
			$holiday = new Holiday_Model_Holiday;
			$this->view->holidaydetails=$holiday->getHoliday($id);
	}	
	public function holidaydeleteAction() 
	{
//calling the delete form
 		$delform = new Category_Form_Delete();
		$this->view->deleteform = $delform;
//getting the id
		$id = $this->_getParam('id');
		$this->view->id = $id;
//calling holiday model
		$holiday = new Holiday_Model_Holiday;
		$this->view->holidaydetails=$holiday->getHoliday($id);
//Delete action

		if($this->_request->isPost() && $this->_request->getPost('Delete')) {
			$formdata = $this->_request->getPost();
				if ($delform->isValid($formdata)) { 
       $redirect = $this->view->adm->deleteRecord("ourbank_holiday",$id);
					//update
            $this->_redirect('/holiday');
			
		}}
	}
}
