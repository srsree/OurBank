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
/*
 *  create an view controller
 */
class Officecommonview_IndexController extends Zend_Controller_Action
{
    public function init() 
    {
  	 $this->view->pageTitle=$this->view->translate('New Office');
        $storage = new Zend_Auth_Storage_Session();
	$data = $storage->read();
	if(!$data){
            $this->_redirect('index/login');
	}
	//initialize session
        $sessionName = new Zend_Session_Namespace('ourbank');
        $this->view->createdby = $sessionName->primaryuserid;
	$this->view->adm = new App_Model_Adm();    
    }

    public function indexAction() 
    {
    }

    public function commonviewAction()
    {
        //Acl
        //$access = new App_Model_Access();
        //$checkaccess = $access->accessRights('Individual',$this->view->globalvalue[0]['name'],'commonviewAction');
        //if (($checkaccess != NULL)) {

	//get id to view
        $id=$this->_request->getParam('id');
        $this->view->memberid=$id;
	//instance for common view
        $officecommon=new Officecommonview_Model_officecommonview;
        $office=$officecommon->getoffice($id);
        $this->view->office=$office;
        $parent_id=$office[0]['parentoffice_id'];
        $parent_name = $this->view->adm->editRecord("ourbank_office",$parent_id);
        $this->view->parentname=$parent_name[0]['name'];
        $module=$officecommon->getmodule('Office');
	//get parent office and id
        foreach($module as $module_id){ }
        $this->view->mod_id=$module_id['parent'];
        $this->view->sub_id=$module_id['module_id'];

        
        $this->view->address = $this->view->adm->getModule("address",$id,"Office");
        $this->view->contact = $this->view->adm->getModule("contact",$id,"Office");
        //}
        //else {
        //$this->_redirect('index/index');
        //}
    }
}
