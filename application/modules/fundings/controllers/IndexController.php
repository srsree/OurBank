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
class Fundings_IndexController extends Zend_Controller_Action 
{
    public function init()
     {
        $this->view->pageTitle='Fundings';
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
		$this->view->createdby = $this->view->globalvalue[0]['id'];
		$this->view->username = $this->view->globalvalue[0]['username'];
//         if (($this->view->globalvalue[0]['id'] == 0)) {
//              $this->_redirect('index/logout');
//         }
		$this->view->adm = new App_Model_Adm();
		//$this->view->activity = new Funding_Model_Funding();
     }

    public function indexAction() 
    {   
        $this->view->title='Fundings';
		$searchForm = new Management_Form_Search();
		$this->view->form = $searchForm;
		if ($this->_request->isPost() && $this->_request->getPost('Search')) {
	    	$formData = $this->_request->getPost();
	    	if ($this->_request->isPost()) {
				$formData = $this->_request->getPost();
				if ($searchForm->isValid($formData)) {
                                $convertdate = new Creditline_Model_dateConvertor();
                                if($formData['field7']){
                                $formData['field7']=$convertdate->phpmysqlformat($formData['field7']);}
                                if($formData['field8']){
                                $formData['field8']=$convertdate->phpmysqlformat($formData['field8']);}
		    		$fundings = new Fundings_Model_Fundings();
		    		$page = $this->_getParam('page',1);
		    		$paginator = Zend_Paginator::factory($fundings->SearchFundings($formData));

				}
	    	}
		} else {
            $fundings = new Fundings_Model_Fundings();
            $page = $this->_getParam('page',1);
            $paginator = Zend_Paginator::factory($this->view->adm->viewRecord("ob_funding","id","DESC"));

		}
            $paginator->setItemCountPerPage($this->view->adm->paginator());
            $paginator->setCurrentPageNumber($page);
            $this->view->paginator = $paginator;
    }
    
    public function addfundingsAction() 
    {   
        $this->view->title='Add Fundings';
        //Acl
//         $access = new App_Model_Access();
//         $checkaccess = $access->accessRights('Fundings',$this->view->globalvalue[0]['name'],'addfundingsAction');
//        	if (($checkaccess != NULL)) {
	
			$form = new Fundings_Form_Fundings();
			$this->view->form = $form;
			$this->view->submitform = new Bank_Form_Submit();

			$funder = $this->view->adm->viewRecord("ob_funder","id","DESC");
			foreach($funder as $funder) {
				$form->funder_id->addMultiOption($funder['id'],$funder['name']);
			}
			
			$institution = $this->view->adm->viewRecord("ob_institution","id","DESC");

			foreach($institution as $institution) {
				$form->institution_id->addMultiOption($institution['id'],$institution['name']);
			}
			
			$currency = $this->view->adm->viewRecord("ob_currency","id","DESC");
			foreach($currency as $currency) {
				$form->currency_id->addMultiOption($currency['id'],$currency['name']);
			}
			$glcode = $this->view->adm->viewRecord("ourbank_glsubcode","id","DESC");
			foreach($glcode as $glcode){
				$form->glsubcode_id->addMultiOption($glcode['id'],$glcode['header']);
			}
			if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
				if ($this->_request->isPost()) {
					$formData = $this->_request->getPost();
					if ($form->isValid($formData)) { 

						$id = $this->view->adm->addRecord("ob_funding",$form->getValues());		
						$this->_redirect('/fundingscommonview/index/commonview/id/'.$id);
					}
				}
			}
// 		} else {
// 	    	$this->_redirect('index/index');
// 		}
    }

    public function editfundingsAction() 
    {
    
        $this->view->title='Edit Fundings';
		//Acl
//         $access = new App_Model_Access();
//         $checkaccess = $access->accessRights('Fundings',$this->view->globalvalue[0]['name'],'editfundingsAction');
//        	if (($checkaccess != NULL)) {
        $form = new Fundings_Form_Fundings();
        $this->view->form = $form;
        
        $fundings = new Fundings_Model_Fundings();
        
			$funder = $this->view->adm->viewRecord("ob_funder","id","DESC");
			foreach($funder as $funder) {
				$form->funder_id->addMultiOption($funder['id'],$funder['name']);
			}
			
			$institution = $this->view->adm->viewRecord("ob_institution","id","DESC");

			foreach($institution as $institution) {
				$form->institution_id->addMultiOption($institution['id'],$institution['name']);
			}
			
			$currency = $this->view->adm->viewRecord("ob_currency","id","DESC");
			foreach($currency as $currency) {
				$form->currency_id->addMultiOption($currency['id'],$currency['name']);
			}
                        $glcode = $this->view->adm->viewRecord("ourbank_glsubcode","id","DESC");
			foreach($glcode as $glcode){
				$form->glsubcode_id->addMultiOption($glcode['id'],$glcode['header']);
			}
        if ($this->_request->isPost() && $this->_request->getPost('Update')) {
	    if ($this->_request->isPost()) {
		$formData = $this->_request->getPost();
		if ($form->isValid($formData)) {
			$id=$this->_request->getParam("id");
 
		            $editfundings = $this->view->adm->editRecord("ob_funding",$id);

					$this->view->adm->updateLog("ob_funding_log",$editfundings[0],1);
					//update 					
					$this->view->adm->updateRecord("ob_funding",$id,$form->getValues());
					$this->_redirect("/fundings");

    	            //$this->_redirect('/fundingscommonview/index/commonview/id/'.$this->_request->getPost('funding_id'));
		}
	    }
	} else {
	        
	    $this->view->id=$this->_request->getParam("id");
	    $fundings = new Fundings_Model_Fundings();
        $editfundings = $fundings->viewfundings($this->view->id);
        $form->populate($editfundings[0]);
	}
// 	} else {
// 	     $this->_redirect('index/index');
// 
// 	}
    }
    public function viewfundingsAction () 
    {
    
    }
    public function deletefundingsAction() 
	{
    	//Acl
//         $access = new App_Model_Access();
//         $checkaccess = $access->accessRights('Fundings',$this->view->globalvalue[0]['name'],'deletefundingsAction');
//        	if (($checkaccess != NULL)) {    
		$this->view->title='Delete funding';
        

        
        $form = new Institution_Form_Delete();
        $this->view->form = $form;
        
        $this->view->id = $this->_request->getParam('id');
			if($this->_request->isPost() ) {

// 			
        		$this->view->id = $this->_request->getParam('id');
			$id=$this->_request->getParam("id");

				$this->view->adm->deleteAction("ob_funding","fundings",$id);//  				}
				$this->_redirect("/fundings");
			}
//     } else {
//                                    $this->_redirect('index/index');
// 
//     
//     }
    }

}

