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
class Selectlanguage_IndexController extends Zend_Controller_Action 
{
    public function init()
    {
		$this->view->pageTitle='Sectors';
			
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
		$this->view->username = $this->view->globalvalue[0]['username'];
        if (($this->view->globalvalue[0]['id'] == 0)) {
             $this->_redirect('index/logout');
        }
		$this->view->adm = new App_Model_Adm();

    }

    public function indexAction() 
    { 

		$form = new Selectlanguage_Form_Selectlanguage();
		$this->view->form = $form;

		if ($this->_request->isPost() && $this->_request->getPost('Submit')) { 
		 
			$language = new Selectlanguage_Model_Selectlanguages ();
			//$language->updatelanguage($form->getValues());
 		} else {
			$sector = $this->view->adm->viewRecord("ob_language","id","DESC");
	
			foreach($sector as $sector){
				$form->language->addMultiOption($sector['id'],$sector['name']);
			}
		}
		
    }
    
 	
}

