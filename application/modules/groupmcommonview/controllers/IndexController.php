<?php
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

class Groupmcommonview_IndexController extends Zend_Controller_Action{
    public function init() {
        $this->view->pageTitle='Group';

        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession(); // get session values
        $this->view->createdby = $this->view->globalvalue[0]['id'];
        $this->view->username = $this->view->globalvalue[0]['username'];
//         if (($this->view->globalvalue[0]['id'] == 0)) {
//                 $this->_redirect('index/logout');
//         }
        $this->view->adm = new App_Model_Adm();// create instance for common model page of adm
    }
    public function indexAction()
	{       
	}
    public function commonviewAction(){
        $id=$this->_request->getParam('id');
        $this->view->groupid=$id;
        // create instance for groupcommon model page

        $groupcommon=new Groupmcommonview_Model_groupcommon();
        $group_name=$groupcommon->getgroup($id); // get group details
        $this->view->groupname=$group_name;
        $group_members=$groupcommon->getgroupmembers($id); // get group members
        $this->view->groupmembers=$group_members;
        $dbobj= new Groupmdefault_Model_groupdefault();
        $groupheaddetails = $dbobj->Getgrouphead($id); //Get group head
            foreach($groupheaddetails as $grouphead){
                    $this->view->grouphead = $grouphead['head'];
            }
        $this->view->address = $this->view->adm->getmodule("address",$id,"Groupm");// get address for particular group
        $module=$groupcommon->getmodule('Groupm');
        foreach($module as $module_id){ }
        $this->view->mod_id=$module_id['parent'];
        $this->view->sub_id=$module_id['module_id'];
        }
}
