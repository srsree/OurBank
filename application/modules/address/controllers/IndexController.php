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
//address is a common module its is used in different module.
class Address_IndexController extends Zend_Controller_Action 
{
    public function init() 
    {
        $this->view->pageTitle=$this->view->translate("New Office");
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
            $this->_redirect('index/login');
        }
        $sessionName = new Zend_Session_Namespace('ourbank');
// get the module name and it used to change the side bar dynamically 
        $this->view->createdby = $sessionName->primaryuserid;
        $this->view->subId=$subId=$this->_getParam('subId');
        $this->view->modId=$modId=$this->_getParam('modId');
        $addressmodel=new Address_Model_addressInformation();
        $module_name=$addressmodel->getmodule($subId);
        foreach($module_name as $module_view)
        {
                $address=$module_view['module_description'];
        }
        $this->view->pageTitle=$address.' address details';
//         $globalsession = new App_Model_Users();
//         $this->view->globalvalue = $globalsession->getSession();
//         $this->view->createdby = $this->view->globalvalue[0]['id'];
//         $this->view->username = $this->view->globalvalue[0]['username'];
//         if (($this->view->globalvalue[0]['id'] == 0)) {
//                 $this->_redirect('index/logout');
//         }
        $this->view->adm = new App_Model_Adm();
    }
    public function indexAction() 
    {}

//add the address details with respective submodule id and record id 
    public function addAction() 
    {
        $this->view->title = $this->view->translate("Add address");
        $this->view->id=$id=$this->_getParam('id');
//load address form with two arguments record id and module id
        $addForm = new Address_Form_Address($this->_getParam('id'),$this->_getParam('subId'));
        $this->view->form=$addForm;
//geting module names and make dynamically redirect action...
        $addressmodel=new Address_Model_addressInformation();
        $module_name=$addressmodel->getmodule($this->view->subId);
        foreach($module_name as $module_view)
        {$path1=$module_view['module_description'].'commonview';}
        $path1= $this->view->path1=strtolower($path1);	
//adding address details
        if ($this->_request->isPost() && $this->_request->getPost('Submit')) 
        {
                $formData = $this->_request->getPost();
                if($addForm->isValid($formData))
                {
                $this->view->adm->addRecord("address",$addForm->getValues());
                $this->_redirect('/'.$path1.'/index/commonview/id/'.$id);
                }
        }
    }

    public function editAction()
    {
        $this->view->title = $this->view->translate("Edit address");
        $this->view->id=$id=$this->_getParam('id');
        $sub_id=$this->_getParam('subId');

//load address form with two arguments record id and module id
        $addForm = new Address_Form_Address($this->_getParam('id'),$this->_getParam('subId'));
        $this->view->form=$addForm;

//geting module names and make dynamically redirect action...
        $addressmodel=new Address_Model_addressInformation();
        $module_name=$addressmodel->getmodule($this->view->subId);
        foreach($module_name as $module_view)
        {$path1=$module_view['module_description'].'commonview';}
        $path1= $this->view->path1=strtolower($path1);	

//set the address details value in the address form
        $edit_address=$addressmodel->getaddress($id,$sub_id);
        $addForm->populate($edit_address[0]);

//update the address details...
        if ($this->_request->isPost() && $this->_request->getPost('Update')) 
        {
        $formData = $this->_request->getPost();
                if($addForm->isValid($formData))
                {
                $olddate = $this->view->adm->editRecord("address",$id); 
                $this->view->adm->updateLog("address_log",$olddate[0],$this->view->createdby);
                $addressmodel->updateRecord("address",$id,$addForm->getValues(),$sub_id);
                $this->_redirect('/'.$path1.'/index/commonview/id/'.$id);
                }
        }
    }
}

