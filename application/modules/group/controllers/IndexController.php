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

class Group_IndexController extends Zend_Controller_Action
{
    public function init()
    {
        $this->view->pageTitle = "Group";
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession(); // get session values
		$this->view->username = $this->view->globalvalue[0]['username'];
//         if (($this->view->globalvalue[0]['id'] == 0)) {
//              $this->_redirect('index/logout');
//         }
		$this->view->adm = new App_Model_Adm(); // create instance for common model page of adm
    }
    public function indexAction()
    { 
        $searchForm = new Group_Form_Search();
        $group = new Group_Model_Group();
        $this->view->form = $searchForm;
        if ($this->_request->isPost() && $this->_request->getPost('Search')){
                $result = $group->searchDetails($this->_request->getPost());	// get search criteria values
                $page = $this->_getParam('page',1);
                $paginator = Zend_Paginator::factory($result); // assign searched values for pagination
                $paginator->setItemCountPerPage($this->view->adm->paginator());
                $paginator->setCurrentPageNumber($page);
                        $this->view->paginator = $paginator;
                $this->view->search = true;
        } else {
                $this->view->title = "Group member"; 
                $storage = new Zend_Auth_Storage_Session();
                $data = $storage->read();
                if (!$data) {
                        $this->_redirect('index/login');
         }
        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($group->getGroupDetails()); // assign default values for pagination
            $this->view->paginator = $paginator;
            }
        $paginator->setItemCountPerPage($this->view->adm->paginator());
        $paginator->setCurrentPageNumber($page);
    }
}
