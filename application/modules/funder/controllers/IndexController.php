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
 *  create an funder controller to search filtered values
 */
class Funder_IndexController extends Zend_Controller_Action
{
    public function init()
    {
	//to change language
        $this->view->pageTitle = $this->view->translate("Funder");
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
                $this->view->username = $this->view->globalvalue[0]['username'];
//         if (($this->view->globalvalue[0]['id'] == 0)) {
//         $this->_redirect('index/logout');
//         }
            $this->view->adm = new App_Model_Adm();
    }

    public function indexAction()
    {
        $this->view->title = $this->view->translate("Funder");

	// create an instance for funder form
        $searchForm = new Funder_Form_funder();
        $this->view->form = $searchForm;
        $fundertype = $this->view->adm->viewRecord("ob_funder_types","id","DESC");
	// fetch funder type for dropdown list
        foreach($fundertype as $fundertype1){
        $searchForm->type->addMultiOption($fundertype1['id'],$fundertype1['fundertype']);
        }


        $funder = new Funder_Model_funder();

	// fetch details from model page
        $result = $funder->funderDetails();
        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($result);

	// search for the search criterias

        if($this->_request->isPost() && $this->_request->getPost('Search')) 
        {
	
        $formData = $this->_request->getPost();
		// form data validate
            if ($searchForm->isValid($formData)) 
            {
		//fetch the filtered values from funder model
                $result = $funder->searchDetails($searchForm->getValues());
                $page = $this->_getParam('page',1);
                $paginator = Zend_Paginator::factory($result);

		//assign to the view object
                $this->view->paginator = $paginator;
            } 
        }
	// for pagination
        $paginator->setItemCountPerPage($this->view->adm->paginator());
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }
}



