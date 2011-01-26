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
class fundingscommonview_IndexController extends Zend_Controller_Action{

    public function init() {
        $this->view->pageTitle='Fundings';
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();

		$this->view->username = $this->view->globalvalue[0]['username'];
//         if (($this->view->globalvalue[0]['id'] == 0)) {
//              $this->_redirect('index/logout');
//         }
		$this->view->adm = new App_Model_Adm();
    }

    public function indexAction() 
    {
    }

    public function commonviewAction()
    {   
		//Acl
/*        $access = new App_Model_Access();
        $checkaccess = $access->accessRights('Fundings',$this->view->globalvalue[0]['name'],'viewfundingsAction');
       	if (($checkaccess != NULL)) {*/ 
            $id=$this->_request->getParam("id");
            $this->view->id = $id;
    
            $fundings = new Fundings_Model_Fundings();
            $this->view->fundings = $fundings->viewfundings($id);
			$this->view->address = $this->view->adm->getSubmodule("address",$id,"Management","Fundings");
			$this->view->contact = $this->view->adm->getSubmodule("contact",$id,"Management","Fundings");
//         } else {
// 			$this->_redirect('index/error');
//         }
    }
}
