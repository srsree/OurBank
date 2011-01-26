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
class Familyinfo_IndexController extends Zend_Controller_Action 
{
    public function init() 
    {
        $this->view->pageTitle=$this->view->translate('Individual member');
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
        $this->view->createdby = $this->view->globalvalue[0]['id'];
        $this->view->username = $this->view->globalvalue[0]['username'];
//         if (($this->view->globalvalue[0]['id'] == 0)) {
//             $this->_redirect('index/logout');
//         }
        $this->view->adm = new App_Model_Adm();
    }
    
    public function indexAction() 
    {
    }
    
// adding family information with respective member id
    public function addAction() 
    {
        $this->view->title = $this->view->translate("Add family information");
        $member_id=$this->_getParam('id');
        $this->view->family_id=$member_id;
    
//loan family information form with respective to two arguments
        $addForm = new Familyinfo_Form_familyinfo($this->_getParam('id'),$this->view->createdby);
        $this->view->form=$addForm;
//insert the family information into the family table
        if ($this->_request->isPost() && $this->_request->getPost('Submit')) 
        {
            $formData = $this->_request->getPost();print_r($formData);
            if($addForm->isValid($formData))
            {
                $this->view->adm->addRecord("ob_member_family",$addForm->getValues());
                $this->_redirect('/individualcommonview/index/commonview/id/'.$member_id);
            }
        }
    }

//// editing family information with respective member id
    public function editAction() 
    {
        $this->view->title = $this->view->translate("Edit family information");
        $this->view->memberid=$member_id=$this->_getParam('id');
//loan family information form with respective to two arguments
        $addForm = new Familyinfo_Form_familyinfo($this->_getParam('id'),$this->view->createdby);
        $this->view->form=$addForm;
//set the family information in the edit form
        $edit_family = $this->view->adm->editRecord("ob_member_family",$member_id);
        $addForm->populate($edit_family[0]);
//update the family information with respective member id
        if ($this->_request->isPost() && $this->_request->getPost('Update')) 
        {
            $formData = $this->_request->getPost();
            if($addForm->isValid($formData))
            {
                $this->view->adm->updateRecord("ob_member_family",$member_id,$addForm->getValues());
                $this->_redirect('/individualcommonview/index/commonview/id/'.$member_id);
            }
        }
    }
}