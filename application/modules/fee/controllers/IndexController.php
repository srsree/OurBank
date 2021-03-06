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
class Fee_IndexController extends Zend_Controller_Action
{
	public function init() 
	{
		 $this->view->pageTitle=$this->view->translate('Fee');

        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
		$this->view->createdby = $this->view->globalvalue[0]['id'];
		$this->view->username = $this->view->globalvalue[0]['username'];
//         if (($this->view->globalvalue[0]['id'] == 0)) {
//              $this->_redirect('index/logout');
//         }
		$this->view->adm = new App_Model_Adm();   	
	}

	public function indexAction() 
	{
               
	$searchForm = new Fee_Form_Search();
		$this->view->form = $searchForm;
		$individual = new Fee_Model_Fee();

		$page = $this->_getParam('page',1);
		$paginator = Zend_Paginator::factory($this->view->adm->viewRecord("ob_fee","id","DESC"));

		if ($this->_request->isPost() && $this->_request->getPost('Search')) {
			if ($this->_request->isPost()) {
				if ($searchForm->isValid($this->_request->getPost())) {
					$result = $individual->feeSearch($searchForm->getValues());
					$page = $this->_getParam('page',1);
					$paginator = Zend_Paginator::factory($result);
				} 
				if (!$result){
					echo "<font color='RED'>Records Not Found Try Again...</font>";
				}
			}
		}
		$paginator->setItemCountPerPage($this->view->adm->paginator());
		$paginator->setCurrentPageNumber($page);
		$this->view->paginator = $paginator;
	}
public function viewAction() 
	{
		//Acl
//         $access = new App_Model_Access();
//         $checkaccess = $access->accessRights('Fee',$this->view->globalvalue[0]['name'],'viewAction');
// 		if (($checkaccess != NULL)) {
			$id=$this->_request->getParam('id');
			$form = new Commonviewfee_Form_Feedetails();
			$this->view->form=$form;
			$fee = new Fee_Model_Fee;
			$this->view->feedetails=$fee->getFee($id);

			$membertype = $this->view->adm->viewRecord("ourbank_master_membertypes","id","DESC");
			foreach($membertype as $membertype){
				$form->membertype->addMultiOption($membertype['id'],$membertype['name']);
			}
// 		} else {
//             $this->_redirect('index/error');
// 		}
	}	
	public function addAction() 
	{
//Acl
//         $access = new App_Model_Access();
//         $checkaccess = $access->accessRights('Fee',$this->view->globalvalue[0]['name'],'addAction');
//        	if (($checkaccess != NULL)) {
			$form = new Fee_Form_Fee();
			$this->view->form=$form;
			$appliesTo = new Feecommon_Model_Feecommon();
			$membertype = $this->view->adm->viewRecord("ourbank_master_membertypes","id","DESC");
			foreach($membertype as $membertype){
				$form->membertype_id->addMultiOption($membertype['id'],$membertype['name']);
			}
			$glcode = $this->view->adm->viewRecord("ourbank_glsubcode","id","DESC");
			foreach($glcode as $glcode){
				$form->glsubcode_id->addMultiOption($glcode['id'],$glcode['header']);
			}
			if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
				$formData = $this->_request->getPost();
				if ($this->_request->isPost()) {
					if ($form->isValid($formData)) {  
						$id = $this->view->adm->addRecord("ob_fee",$form->getValues());
						$this->_redirect('/fee/index/view/id/'.$id);
   					}
				}
			}
// 		} else {
// 				$this->_redirect('index/error');
// 		}	
	}
	
	public function editfeedetailAction() 
	{
//Acl
//         $access = new App_Model_Access();
//         $checkaccess = $access->accessRights('Fee',$this->view->globalvalue[0]['name'],'viewAction');
// 		if (($checkaccess != NULL)) {
			$form = new Fee_Form_Fee();
			$this->view->form=$form;
			$membertype = $this->view->adm->viewRecord("ourbank_master_membertypes","id","DESC");
			foreach($membertype as $membertype){
				$form->membertype_id->addMultiOption($membertype['id'],$membertype['name']);
			}
			$glcode = $this->view->adm->viewRecord("ourbank_glsubcode","id","DESC");
			foreach($glcode as $glcode){
				$form->glsubcode_id->addMultiOption($glcode['id'],$glcode['header']);
			}
			$id=$this->_getParam('id');
			$this->view->fee_id=$id;
			$fee = new Fee_Model_Fee;
			$feedetails = $fee->getFee($id);

			$form->populate($feedetails[0]);

			if ($this->_request->isPost() && $this->_request->getPost('Update')) { 
		            $editfee = $this->view->adm->editRecord("ob_fee",$id);

					$this->view->adm->updateLog("ob_fee_log",$editfee[0],$this->view->createdby);
					//update 					
					$this->view->adm->updateRecord("ob_fee",$id,$form->getValues());
			$this->_redirect("/fee");
	
			}
// 		} else {
//             $this->_redirect('index/error');
    }		

	public function deleteAction() 
	{
//  	$acl = new App_Model_Acl();
//     	$access = new App_Model_Access();
//      $role = $access->getRole($this->view->id);
// 
//      $accessid = $access->accessRights('Fee',$role,"deleteAction");
//      $checkaccess = $acl->isAllowed($role,'Fee',$accessid);
//      if(($role) && ($checkaccess != NULL)) {
 		$id=$this->_request->getParam('id');
		$modId=$this->_request->getParam('mod_id');
		$subId=$this->_request->getParam('sub_id');
		$this->view->user_id=$id;
		$this->view->mod_id=$modId;
		$this->view->sub_id=$subId;
		$individualcommon=new Feecommon_Model_Feecommon;
		$fee = new Fee_Model_Fee;
			$this->view->feedetails=$fee->getFee($id);
 		$delform=new Fee_Form_Delete();
		$this->view->delete=$delform;
		if ($this->_request->isPost() && $this->_request->getPost('Submit')){
			$formdata = $this->_request->getPost();
			if($delform->isValid($formdata)) { 
							$redirect = $this->view->adm->deleteRecord("ob_fee_log",$id);

 				$this->_redirect('/fee');
			}
		}
	}
}

