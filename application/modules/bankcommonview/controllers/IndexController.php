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
 *  create an bank common view controller to view values
 */
class Bankcommonview_IndexController extends Zend_Controller_Action
{
    public function init() 
    {
        $this->view->pageTitle=$this->view->translate('Bank');
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
	$this->view->username = $this->view->globalvalue[0]['username'];
//      if (($this->view->globalvalue[0]['id'] == 0)) 
//        {
//          $this->_redirect('index/logout');
//      }
	    //adm model instance
            $this->view->adm = new App_Model_Adm();
    }

    public function indexAction() 
    {
    }

//commonviewAction retrieve the all the bank information 
    public function commonviewAction()
    {
	//Acl
//      $access = new App_Model_Access();
//      $checkaccess = $access->accessRights('Bank',$this->view->globalvalue[0]['name'],'viewbankAction');
//      if (($checkaccess != NULL)) 
//      {
            $id = $this->_request->getParam("id");
            $this->view->id = $id;
            $individualcommon=new Individualcommonview_Model_individualcommon;
            $module=$individualcommon->getmodule('Bank');
	    //looping returned model bank details
            foreach($module as $module_id){ }
            $this->view->mod_id=$module_id['parent'];
            $this->view->sub_id=$module_id['module_id'];
            $this->view->institution = $this->view->adm->editRecord("ob_bank",$id);
            $this->view->address = $this->view->adm->getModule("address",$id,"Bank");
            $this->view->contact = $this->view->adm->getModule("contact",$id,"Bank");
//      } else {
//              $this->_redirect('index/error');
//         }
    }
}
