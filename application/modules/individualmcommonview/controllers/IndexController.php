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
//commonview for all individual micro modules
class Individualmcommonview_IndexController extends Zend_Controller_Action
{
    public function init() 
    {
  	$this->view->pageTitle='Individual';
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
	$this->view->createdby = $this->view->globalvalue[0]['id'];
// 	$this->view->username = $this->view->globalvalue[0]['username'];
//         if (($this->view->globalvalue[0]['id'] == 0)) {
//              $this->_redirect('index/logout');
//         }
	$this->view->adm = new App_Model_Adm();    
    }

    public function indexAction() 
    {
    }

//view and edit for member details, address, contact, family details
    public function commonviewAction()
    {
        //Acl
        //$access = new App_Model_Access();
        //$checkaccess = $access->accessRights('Individual',$this->view->globalvalue[0]['name'],'commonviewAction');
        //if (($checkaccess != NULL)) {

        $id=$this->_request->getParam('id');
        $this->view->memberid=$id;
        $individualcommon=new Individualmcommonview_Model_individualmcommonview();
        $member_name=$individualcommon->getmember($id);
        //getting module id and submodule id
        $module=$individualcommon->getmodule('Individualm');
        foreach($module as $module_id){ }
        $this->view->mod_id=$module_id['parent'];
        $this->view->sub_id=$module_id['module_id'];
        //geting family details, family details, health, economic, education details
        $this->view->membername=$member_name;
        $this->view->address = $this->view->adm->getModule("address",$id,"Individualm");
        $this->view->familydetails=$edit_family =$individualcommon->getfamilydetails($id);
        $this->view->healthdetails=$edit_family =$individualcommon->gethealthdetails($id);
        $this->view->economicdetails=$edit_economic =$individualcommon->geteconomicdetails($id);
        $this->view->educationdetails=$edit_education =$individualcommon->geteducationdetails($id);
        $this->view->contact = $this->view->adm->getModule("contact",$id,"Individualm");
        //}
        //else {
        //$this->_redirect('index/index');
        //}
    }
}
