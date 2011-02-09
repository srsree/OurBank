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
class Contactdetails_IndexController extends Zend_Controller_Action{

    public function init() 
	{
        $this->view->pageTitle=$this->view->translate('Contact Details');
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
		$this->view->createdby = $this->view->globalvalue[0]['id'];
// 
// 		$this->view->username = $this->view->globalvalue[0]['username'];
//         if (($this->view->globalvalue[0]['id'] == 0)) {
//              $this->_redirect('index/logout');
//         }
//getting module name and change the side bar dynamically 
        $this->view->id=$subId=$this->_getParam('id');
        $this->view->subId=$subId=$this->_getParam('subId');
        $this->view->modId=$modId=$this->_getParam('modId');
        $addressmodel=new Address_Model_addressInformation();
        $module_name=$addressmodel->getmodule($subId);
        foreach($module_name as $module_view)
        {
            $address=$module_view['module_description'];
        }
        $this->view->pageTitle=$address.' contact details';
            $this->view->adm = new App_Model_Adm();
    }

    public function indexAction() 
    {
    }

//adding contact details 
    public function addcontactAction() 
    {
        $this->view->title=$this->view->translate('Add Contact');
//load contact details form with two arguments ...
        $form = new Contactdetails_Form_contactdetails($this->_getParam('id'),$this->_getParam('subId'));
        $this->view->form=$form;
        $this->view->submitform = new Bank_Form_Submit();
//dynamically change the path name
        $addressmodel=new Address_Model_addressInformation();
        $module_name=$addressmodel->getmodule($this->view->subId);
        foreach($module_name as $module_view)
        {$path1=$module_view['module_description'].'commonview';}
        $path1= $this->view->path1=strtolower($path1);
//insert the contact details...
        if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
 	    	if ($this->_request->isPost()) {
 			$formData = $this->_request->getPost();
				if ($form->isValid($formData)) { 
                                $validator = new Zend_Validate_EmailAddress();
                                if ($validator->isValid($formData['email'])) {
                                $this->view->adm->addRecord("contact",$form->getValues());
			        $this->_redirect('/'.$path1.'/index/commonview/id/'.$this->_request->getParam("id"));
                                } 
                                else {
                                        echo "<font color='red'>Please enter valid email...</font>";
                                }
					
				}
	    	}
		}
    }
    
//editing contact details
    public function editcontactAction() 
    {
        $this->view->title=$this->view->translate('Edit Contact');

//load contact details form with two arguments ...
        $form = new Contactdetails_Form_contactdetails($this->_getParam('id'),$this->_getParam('subId'));
        $this->view->form = $form;
        $this->view->submitform = new Bank_Form_Submit();
//dynamically change the path name
        $addressmodel=new Address_Model_addressInformation();
        $module_name=$addressmodel->getmodule($this->view->subId);
        foreach($module_name as $module_view)
        {$path1=$module_view['module_description'].'commonview';}
        $path1= $this->view->path1=strtolower($path1);
//update contact details
        if ($this->_request->isPost() && $this->_request->getPost('Update')) {
	    	if ($this->_request->isPost()) {
 				$formData = $this->_request->getPost();
 				if ($form->isValid($formData)) { 
                                $validator = new Zend_Validate_EmailAddress();
                                if ($validator->isValid($formData['email'])) {
					$editContact = $this->view->adm->editSubmodule("contact",$this->_getParam('id'),$this->_getParam('submodule_id'));

					$this->view->adm->updateLog("contact_log",$editContact[0],$this->view->createdby);
                                        $addressmodel->updateRecord("contact",$this->_getParam('id'),$form->getValues(),$this->_getParam('submodule_id'));
					$this->_redirect('/'.$path1.'/index/commonview/id/'.$this->_getParam('id'));
                                } 
                                else {
                                        echo "<font color='red'>Please enter valid email...</font>";
                                }
  				}
        }
        } else {
//set the contact details in the contact form...
                $sub_id=$this->_getParam('subId');
                $id=$this->_getParam('id');
                $editContact = $addressmodel->getcontact($id,$sub_id);
                $form->populate($editContact[0]);
        }
	}
}
