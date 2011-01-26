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
class Interestrates_IndexController extends Zend_Controller_Action{
    public function init() {
        $this->view->pageTitle = "Interest rates";
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
        $this->view->username = $this->view->globalvalue[0]['username'];
        $this->view->createdby = $this->view->globalvalue[0]['id'];
//         if (($this->view->globalvalue[0]['id'] == 0)) {
//             $this->_redirect('index/logout');
//         }
        $this->view->adm = new App_Model_Adm();
        $this->view->dateconvert = new Creditline_Model_dateConvertor();
    }

    public function indexAction() {
    }

    public function interestratesaddAction() {
    //Acl
    // 		$access = new App_Model_Access();
    // 		$checkaccess = $access->accessRights('Institution',$this->view->globalvalue[0]['name'],'addinstitutionAction');
    // 		if (($checkaccess != NULL)) {
    
    //add
        $InterestratesForm=$this->view->InterestratesForm=new Interestrates_Form_Interestrates();
        $insertinterest=new Interestrates_Model_Interestrates();
        $creditline = $this->view->adm->viewRecord("ob_creditline","id","DESC");
    
        foreach($creditline as $creditline){
        $InterestratesForm->creditlinename->addMultiOption($creditline['id'],$creditline['name']);
        }

        if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
            $formData = $this->_request->getPost();
            if ($InterestratesForm->isValid($formData)) {
                $a=array();
                //fetch last inserted id - when the table is empty then id is 1 or else incremented by 1
                $lastid=$this->view->adm->lastinsertedID('ob_interest_rates');
                foreach($lastid as $lastid1) { $lastid2=$lastid1['max(id)'];}
                if($lastid2){
                    $lastid2++; 
                } else {
                    $lastid2=1;
                }
    
                $startRange=array();$endRange=array();$interestRates=array();$interestBillet=array();
                $startRange=$formData['start_range'];
                $endRange=$formData['end_range'];
                $interestRates=$formData['interest'];
                $fee_rate=$formData['fee'];
                $interestBillet=$formData['interest_ballet'];
    
                $maxCount=max(count($startRange),count($endRange),count($interestRates),count($fee_rate),count($interestBillet));
                for($i=0; $i<$maxCount; $i++) {
                    $insertinterest->addInterestDetails($formData,$lastid2,$startRange[$i],$endRange[$i],$interestRates[$i],$fee_rate[$i],$interestBillet[$i],$this->view->createdby,'ob_interest_rates');
                }
                $this->_redirect('interestratesindex/index');
            }
        }
    // 		} else {
    // 		$this->_redirect('index/index');
    // 		}
    }
    
    public function interestrateseditAction() {
    //Acl
    // 		$access = new App_Model_Access();
    // 		$checkaccess = $access->accessRights('Institution',$this->view->globalvalue[0]['name'],'addinstitutionAction');
    // 		if (($checkaccess != NULL)) {
    //edit
        $InterestratesForm=$this->view->InterestratesForm=new Interestrates_Form_Interestrates();
        $insertinterest=new Interestrates_Model_Interestrates();

        $creditline = $this->view->adm->viewRecord("ob_creditline","id","DESC");
        foreach($creditline as $creditline){
            $InterestratesForm->creditlinename->addMultiOption($creditline['id'],$creditline['name']);
        }

        $this->view->interest_id=$interest_id=$this->_request->getParam('interest_id');
        $fetchinterest=new Interestrates_Model_Interestrates();
        $fetchinterest2=$fetchinterest->fetchinterestdetailsforID($interest_id);
        foreach($fetchinterest2 as $fetchinterest1) {
            $this->view->InterestratesForm->interestname->setValue($fetchinterest1['name']);
            $this->view->InterestratesForm->creditlinename->setValue($fetchinterest1['creditline_id']);
            $this->view->InterestratesForm->status->setValue($fetchinterest1['status']);
        }
        $this->view->interest_details=$fetchinterest2; //for phtml page "Interest" rows

        if($this->_request->isPost() && $this->_request->getPost('Update')) {
            $interest_id = $this->_request->getParam('interest_id');
            $formData = $this->_request->getPost();
            $InterestratesForm->interestname->removeValidator('Db_NoRecordExists');
            $interest_details1=$this->view->adm->editrecord('ob_interest_rates',$interest_id);

            foreach($interest_details1 as $interest_details) {
                $this->view->adm->addRecord('ob_interest_rates_log',$interest_details);
            }//refer code#1
            $this->view->adm->deleteRecord('ob_interest_rates',$interest_id);

            if ($InterestratesForm->isValid($formData)) {
                $formData = $this->_request->getPost();
                $startRange=array(); $endRange=array();		$interestRates=array();
                $fee_rates=array();  $interestBillet=array();

                $startRange=$formData['start_range']; $endRange=$formData['end_range'];
                $interestRates=$formData['interest']; $fee_rates=$formData['fee'];
                $interestBillet=$formData['interest_ballet'];

                $maxCount=max(count($startRange),count($endRange),count($interestRates),count($interestBillet));
                $updateInterestrates=new Interestrates_Model_Interestrates();
                for($i=0; $i<$maxCount; $i++) {
                    $updateInterestrates->addInterestDetails($formData,$interest_id,$startRange[$i],$endRange[$i],$interestRates[$i],$fee_rates[$i],$interestBillet[$i],$this->view->createdby,'ob_interest_rates');
                }
                $this->_redirect('interestratesindex/index');
            }
        }
        // 		} else {
        // 		$this->_redirect('index/index');
        // 		}
    }
    
    public function interestratesviewAction() {
    }
    
    public function interestratesdeleteAction() {
    //Acl
    // 		$access = new App_Model_Access();
    // 		$checkaccess = $access->accessRights('Institution',$this->view->globalvalue[0]['name'],'addinstitutionAction');
    // 		if (($checkaccess != NULL)) {
    //delete
        $this->view->interest_id=$interest_id=$this->_request->getParam('interest_id');
        $deleteForm=new App_Form_Delete();
        $this->view->deleteForm=$deleteForm;

        if($this->_request->isPost() && $this->_request->getPost('Delete')) {
            $formdata = $this->_request->getPost();
            if ($deleteForm->isValid($formdata)) {
                $interest_details1=$this->view->adm->editrecord('ob_interest_rates',$interest_id);
                foreach($interest_details1 as $interest_details) {
                    $this->view->adm->addRecord('ob_interest_rates_log',$interest_details);
                }
                $this->view->adm->deleteRecord('ob_interest_rates',$interest_id);
                $this->_redirect('interestratesindex/index');
            }
        }
    }
    // 		} else {
    // 		$this->_redirect('index/index');
    // 		}
}
