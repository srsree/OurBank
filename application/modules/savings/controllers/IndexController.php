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
class Savings_IndexController extends Zend_Controller_Action{
	public function init() {
		$this->view->pageTitle='Savings';
		$this->view->Action= $this->getRequest()->getActionName();
		if($this->_request->getParam('savingtypeId')) {
			$this->view->producttype= $this->_request->getParam('savingtypeId');
		} else {
			$this->view->producttype= $this->_request->getParam('productType');
		}
                $this->view->adm = new App_Model_Adm();

	}
	public function indexAction() {
                //  when delete particular saving product offer we should check that particular saving product offer is used by other one or not according to result we should delete that record if that saving product offer is used by some one then we should display message
                if($this->_helper->flashMessenger->getMessages()){
                    $messages = $this->_helper->flashMessenger->getMessages();
                        foreach($messages as $error){
                    echo "<script> alert('$error');</script>";
                    }
                }
		$this->view->title = "Savings";
		$searchForm = new Savings_Form_Search();
		$this->view->form = $searchForm;
		$offerproduct = new Savings_Model_Savings();
		$result = $offerproduct->fetchAllofferProductDetails();
		$page = $this->_getParam('page',1);
		if ($this->_request->isPost() && $this->_request->getPost('Search')) {
                    $formData = $this->_request->getPost();
                    if ($searchForm->isValid($formData)) {
                        $result = $offerproduct->SearchofferProduct($searchForm->getValues()); // get savings details
                        $paginator = Zend_Paginator::factory($result); // set pagination 
                        $this->view->search = true;
                    }
                } else {
                            $result = $offerproduct->fetchAllofferProductDetails(); // get default savings offer values
                            $paginator = Zend_Paginator::factory($result); // set pagination 
                }
                $paginator->setItemCountPerPage($this->view->adm->paginator());
                $paginator->setCurrentPageNumber($page);
                $this->view->paginator = $paginator;
			
		
	}

	public function savingsaddAction() { 
		$this->view->title = "Add Savings";
		$savingsForm = new Savings_Form_Savings();
		$this->view->form = $savingsForm;

		$offerproduct = new Savings_Model_Savings();
		$productDetails = $offerproduct->getProductDetails();
		foreach($productDetails as $product) {
			$savingsForm->productType->addMultiOption($product['shortname'],$product['name']);
		}
		$this->view->producttype= $this->_request->getParam('productType');
		if($this->view->producttype=='ps') { // if it is personal saving type navigate page to personal savings
			$this->persnolsavingsAction();
		}

		if($this->view->producttype=='fd') { // if it is fixed saving type navigate page to personal savings
			$this->fixedsavingsAction();
		}

		if($this->view->producttype=='rd') {// if it is recurring saving type navigate page to personal savings
			$this->recurringsavingsAction();
		}
	}
 
	public function persnolsavingsAction() {  
            // disable the layout to load new action page in common page
            $this->_helper->layout->disableLayout();
            $savingsForm = new Savings_Form_Savings();
            $this->view->producttype = 'ps';
            $this->view->form = $savingsForm;
		$savings = new Savings_Model_Savings();
		$interestperiods = new Management_Model_Interestperiods();
		$select = $savings->fetchAllTimeFrequencyType();
                // load frequency type 
		foreach($select as $timefrequencytype) {
			$savingsForm->frequencyofdeposit->addMultiOption($timefrequencytype['id'],$timefrequencytype['type']);
                $savingsForm->Int_timefrequency_id->addMultiOption($timefrequencytype['id'],$timefrequencytype['type']);
		}
                // load applicable to  

		$applicableto = $savings->fetchAllMemberType();
		foreach($applicableto as $applicableto) {
			$savingsForm->applicableto->addMultiOption($applicableto['id'],$applicableto['type']);
		}

		$glsubcode = $savings->fetchAllglsubcode();
                // load glsubcode ids
		foreach($glsubcode as $glsubcode) {
			$savingsForm->glsubcode_id->addMultiOption($glsubcode['id'],$glsubcode['header']." -[".$glsubcode['glsubcode']."]");
		}
               $feeglcode = $this->view->adm->getRecord('ourbank_glsubcode','subledger_id',2);
               foreach($feeglcode as $feeglcodes) {
                                        $savingsForm->feeglcode->addMultiOption($feeglcodes['id'],$feeglcodes['header']);
                                }
		if ($this->_request->isPost() && $this->_request->getPost('Submit')) { 
			$formData = $this->_request->getPost();
			if ($this->_request->isPost()) {
				$savingsForm->closedate->setRequired(false);
				$savingsForm->minimum_deposit_amount->setRequired(false);
				$savingsForm->maximum_deposit_amount->setRequired(false);
				$savingsForm->frequency_of_deposit->setRequired(false);
				$savingsForm->penal_Interest->setRequired(false);
                                // get all given input values
                                $closeddate = $this->_request->getParam('closedate');
                                $productType = $this->_request->getParam('productType');
                                $interestfrom = $this->_request->getParam('interestfrom'); 
                                $interestto = $this->_request->getParam('interestto');
                                $interestrate = $this->_request->getParam('interestrate');
                                $currentdate = $this->_request->getParam('currentdates');
                                $begindate = $this->_request->getParam('begindate');
                                $month='months';
                                $period_ofrange_description1 = $interestfrom.-$interestto.$month;
                                $memberCount = $this->_request->getParam('memberCount');
            // get product id 
            $product_id = $this->view->adm->getsingleRecord('ourbank_product','id','shortname',$productType);
            $this->view->product_id = $product_id;

              $result=$savings->addofferproduct($formData,$product_id,$closeddate);  //Insert Products offer 
              $offerproductupdate_id =$this->view->adm->lastinsertedID('ourbank_productsoffer');
              foreach($offerproductupdate_id as $offerprodctid){
                    $offerproductupdate_id = $offerprodctid['max(id)'];
                }
                $result = $savings->addofferproductsavings($formData,$offerproductupdate_id);//Insert Products saving
                // insert interest period values
                $interestperiod1 = $interestperiods->insertinterestperiods(array('id' =>'',
															'period_ofrange_monthfrom' => $interestfrom,
															'period_ofrange_monthto'=> $interestto,
															'period_ofrange_description'=> $period_ofrange_description1,
															'offerproduct_id' => $offerproductupdate_id,
															'Interest' => $interestrate,
															'intereststatus_id'=>3));

					for ($i = 1;$i<=$memberCount; $i++) {
						$From = $this->_request->getParam('memberName'.$i); 
						$To = $this->_request->getParam('To'.$i); 
						$Rate = $this->_request->getParam('Rate'.$i); 
						$month='months';
						$period_ofrange_description = $From.-$To.$month;
						if($From) {
							$interestperiod = $interestperiods->insertinterestperiods(array('id' =>'',
																				'period_ofrange_monthfrom' => $From,
																				'period_ofrange_monthto'=> $To,
																				'period_ofrange_description'=> $period_ofrange_description,
																				'offerproduct_id' => $offerproductupdate_id,
																				'Interest' => $Rate,
																				'intereststatus_id'=>3));
						}
					}
					$this->_redirect('savings/index');
				}
			}
		}

	public function fixedsavingsAction() { 
            // disable the layout to load new action page in common page
            $this->_helper->layout->disableLayout();
		$savingsForm = new Savings_Form_Savings();
                $this->view->producttype = 'fd';
		$this->view->form = $savingsForm;
		$savings = new Savings_Model_Savings();
                $convertdate = new App_Model_dateConvertor();

		$interestperiods = new Management_Model_Interestperiods();
                $applicableto = $savings->fetchAllMemberType();
                // load applicable to values
		foreach($applicableto as $applicableto) {
			$savingsForm->applicableto->addMultiOption($applicableto['id'],$applicableto['type']);
		}
		$glsubcode = $savings->fetchAllglsubcode();
                // load glsubcode ids
		foreach($glsubcode as $glsubcode) {
			$savingsForm->glsubcode_id->addMultiOption($glsubcode['id'],$glsubcode['header']." -[".$glsubcode['glsubcode']."]");
		}

		$freequencyofdeposit = $savings->fetchAllTimeFrequencyType();
                //  load frequency type
		foreach($freequencyofdeposit as $freequency) {
                $savingsForm->frequency_of_deposit->addMultiOption($freequency['id'],$freequency['type']);
		}
               $feeglcode = $this->view->adm->getRecord('ourbank_glsubcode','subledger_id',2);
                // load feeglcode
               foreach($feeglcode as $feeglcodes) {
                                        $savingsForm->feeglcode->addMultiOption($feeglcodes['id'],$feeglcodes['header']);
                                }

		if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
			$formData = $this->_request->getPost();

			if ($this->_request->isPost()) {
				$savingsForm->minmumdeposit->setRequired(false);
				$savingsForm->frequencyofdeposit->setRequired(false);
				$savingsForm->Int_timefrequency_id->setRequired(false);
				$savingsForm->frequencyofinterestupdating->setRequired(false);
				$savingsForm->minimumbalanceforinterest->setRequired(false);
                                // receive all given input values 
                                $closeddate = $this->_request->getParam('closedate');
				$productType = $this->_request->getParam('productType');
					$interestfrom = $this->_request->getParam('interestfrom'); 
					$interestto = $this->_request->getParam('interestto');
					$interestrate = $this->_request->getParam('interestrate');
					$currentdate = $this->_request->getParam('currentdates');
					$begindate = $this->_request->getParam('begindate');
					$minimumamount = $this->_request->getParam('minimum_deposit_amount');
					$maximumamount = $this->_request->getParam('maximum_deposit_amount');
					$month='months';
					$period_ofrange_description1 = $interestfrom.-$interestto.$month;
					$memberCount = $this->_request->getParam('memberCount');
            $product_id = $this->view->adm->getsingleRecord('ourbank_product','id','shortname',$productType);
            $this->view->product_id = $product_id;
            // check with close date and begindate
            if($convertdate->phpmysqlformat($closeddate) <= $convertdate->phpmysqlformat($begindate)) {
                $this->view->closedate= "<B style='color:red'>'closed date must be greater than begin date'$begindate</b>";
            } 
            // check with maximum and minimum amount
            else if($minimumamount >= $maximumamount) {
                $this->view->maximumamount= "<B style='color:red'>'maximum amount must be greater than minimum'$minimumamount</b>";
           }else {
                $result = $savings->addofferproduct($formData,$product_id,$closeddate); //Insert Products offer 
                $offerproductupdate_id =$this->view->adm->lastinsertedID('ourbank_productsoffer');
                foreach($offerproductupdate_id as $offerprodctid){
                        $offerproductupdate_id = $offerprodctid['max(id)'];
                }
                // Insert fixed product details
                $result = $savings->addofferproductfixedrecurring($formData,$offerproductupdate_id);
                $interestperiod1 = $interestperiods->insertinterestperiods(array('id' =>'',
															'period_ofrange_monthfrom' => $interestfrom,
															'period_ofrange_monthto'=> $interestto,
															'period_ofrange_description'=> $period_ofrange_description1,
															'offerproduct_id' => $offerproductupdate_id,
															'Interest' => $interestrate,
															'intereststatus_id'=>3));
        // Insert interest periods values
    for ($i = 1;$i<=$memberCount; $i++) {
            $From = $this->_request->getParam('memberName'.$i); 
            $To = $this->_request->getParam('To'.$i); 
            $Rate = $this->_request->getParam('Rate'.$i); 
            $month='months';
            $period_ofrange_description = $From.-$To.$month;
            if($From) {
                    $interestperiod = $interestperiods->insertinterestperiods(array('id' =>'',
																'period_ofrange_monthfrom' => $From,
																'period_ofrange_monthto'=> $To,
																'period_ofrange_description'=> $period_ofrange_description,
																'offerproduct_id' => $offerproductupdate_id,
																'Interest' => $Rate,
																'intereststatus_id'=>3));
							}
						}
						$this->_redirect('savings/index');
				}
			}
		}

}

	public function recurringsavingsAction() {   
            // disable the layout to load new action page in common page
                $this->_helper->layout->disableLayout();
		$savingsForm = new Savings_Form_Savings();
		$this->view->form = $savingsForm;
                $convertdate = new App_Model_dateConvertor();

		$savings = new Savings_Model_Savings();
		$interestperiods = new Management_Model_Interestperiods();
                // load applicable to values
                $applicableto = $savings->fetchAllMemberType();
		foreach($applicableto as $applicableto) {
			$savingsForm->applicableto->addMultiOption($applicableto['id'],$applicableto['type']);
		}
                // load glsubcode ids
		$glsubcode = $savings->fetchAllglsubcode();
		foreach($glsubcode as $glsubcode) {
			$savingsForm->glsubcode_id->addMultiOption($glsubcode['id'],$glsubcode['header']." -[".$glsubcode['glsubcode']."]");
		}
                // load frequency of deposit values
		$freequencyofdeposit = $savings->fetchAllTimeFrequencyType();
		foreach($freequencyofdeposit as $freequency) {
			$savingsForm->frequency_of_deposit->addMultiOption($freequency['id'],$freequency['type']);
		}
               $feeglcode = $this->view->adm->getRecord('ourbank_glsubcode','subledger_id',2);
               // load feeglcode values
                foreach($feeglcode as $feeglcodes) {
                        $savingsForm->feeglcode->addMultiOption($feeglcodes['id'],$feeglcodes['header']);
                }
		if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
			$formData = $this->_request->getPost();
			if ($this->_request->isPost()) {
				$savingsForm->minmumdeposit->setRequired(false);
				$savingsForm->frequencyofdeposit->setRequired(false);
				$savingsForm->Int_timefrequency_id->setRequired(false);
				$savingsForm->frequencyofinterestupdating->setRequired(false);
				$savingsForm->minimumbalanceforinterest->setRequired(false);
                                // receive all given input values 
				$closeddate = $this->_request->getParam('closedate');
                                $productType = $this->_request->getParam('productType');
                                $interestfrom = $this->_request->getParam('interestfrom'); 
                                $interestto = $this->_request->getParam('interestto');
                                $interestrate = $this->_request->getParam('interestrate');
                                $currentdate = $this->_request->getParam('currentdates');
                                $begindate = $this->_request->getParam('begindate');
                                $minimumamount = $this->_request->getParam('minimum_deposit_amount');
                                $maximumamount = $this->_request->getParam('maximum_deposit_amount');
                                $month='months';
                                $period_ofrange_description1 = $interestfrom.-$interestto.$month;
                                $memberCount = $this->_request->getParam('memberCount');
            $product_id = $this->view->adm->getsingleRecord('ourbank_product','id','shortname',$productType);
            $this->view->product_id = $product_id;
 	     // check with maximum and minimum date
             if($convertdate->phpmysqlformat($closeddate) <= $convertdate->phpmysqlformat($begindate)) {

                $this->view->closedate= "<B style='color:red'>'closed date must be grater than begin date'.'$begindate'</b>";
            // check with maximum and minimum amount
        } elseif($minimumamount >= $maximumamount) {
                $this->view->maximumamount= "<B style='color:red'>'maximum amount must be grater than minimum'.'$minimumamount'</b>";
        } else {
                $result = $savings->addofferproduct($formData,$product_id,$closeddate); //Insert Products offer 
                $offerproductupdate_id =$this->view->adm->lastinsertedID('ourbank_productsoffer');
                foreach($offerproductupdate_id as $offerprodctid){
                        $offerproductupdate_id = $offerprodctid['max(id)'];
                }
                // Insert fixed product values 
               $result = $savings->addofferproductfixedrecurring($formData,$offerproductupdate_id);
                // Insert interest values
                $interestperiod1 = $interestperiods->insertinterestperiods(array('id' => '',
															'period_ofrange_monthfrom' => $interestfrom,
															'period_ofrange_monthto'=> $interestto,
															'period_ofrange_description'=> $period_ofrange_description1,
															'offerproduct_id' => $offerproductupdate_id,
															'Interest' => $interestrate,
															'intereststatus_id'=>3));

    for ($i = 1;$i<=$memberCount; $i++) {
            $From = $this->_request->getParam('memberName'.$i); 
            $To = $this->_request->getParam('To'.$i); 
            $Rate = $this->_request->getParam('Rate'.$i); 
            $month='months';
            $period_ofrange_description = $From.-$To.$month;
            if($From) {
                    $interestperiod = $interestperiods->insertinterestperiods(array('id' =>'',
																'period_ofrange_monthfrom' => $From,
																'period_ofrange_monthto'=> $To,
																'period_ofrange_description'=> $period_ofrange_description,
																'offerproduct_id' => $offerproductupdate_id,
																'Interest' => $Rate,
																'intereststatus_id'=>3));
							}
						}
						$this->_redirect('savings/index');
					}
				}
			}
		}
	public function savingsviewAction() {
		$this->view->title = "view Savings";
                // decode the input value
		$offerproduct_id =base64_decode($this->_getParam('offerproduct_id'));
                $this->view->id = $offerproduct_id;
		$offerproduct = new Savings_Model_Savings();
		$offerProductshortname = $offerproduct->offerProductshortname($offerproduct_id);
		foreach($offerProductshortname as $shortname) {
			$offerproductshortname=$shortname['shortname'];
		}
                // get product offer details for particular id
		$result = $offerproduct->viewofferProduct($offerproduct_id,$offerproductshortname);
		$this->view->offerproduct = $result;
                // get interest details for particular id
		$interestperiods = $offerproduct->viewinterest($offerproduct_id);
		$this->view->viewinterest = $interestperiods;
	}
// 
	public function savingseditAction() {
            $this->view->title = "Edit Savings";
            $offerproduct_id =base64_decode($this->_getParam('id'));
            $this->view->offerid = $offerproduct_id;
            $systemDate = date('Y-m-d');
            $savingsForm = new Savings_Form_Savings();
            $this->view->form = $savingsForm;
            $offerproduct = new Savings_Model_Savings();
            $convertdate = new App_Model_dateConvertor();

            $this->view->offerproduct_id = $offerproduct_id;
            $this->view->currentdates = $systemDate;
            $savingsForm->Submit->setName('Update');
            $savingsForm->offerproductname->removeValidator('Db_NoRecordExists');

            $offerProductshortname = $offerproduct->offerProductshortname($offerproduct_id);
            foreach($offerProductshortname as $shortname) {
                $offerproduct_shortname = $shortname['shortname'];
                $this->view->shortname = $offerproduct_shortname;
                $this->view->productshortname = $offerproduct_shortname;
                $savingsForm->offerproductname->setValue($shortname['name']);
            }
            // load applicable to values
            $applicableto = $offerproduct->fetchAllMemberType();
            foreach($applicableto as $applicableto) {
                    $savingsForm->applicableto->addMultiOption($applicableto['id'],$applicableto['type']);
            }
            // load glsubcode id values
            $glsubcode = $offerproduct->fetchAllglsubcode();
            foreach($glsubcode as $glsubcode) {
                    $savingsForm->glsubcode_id->addMultiOption($glsubcode['id'],$glsubcode['header']." -[".$glsubcode['glsubcode']."]");
            }
            // load frequency of deposit values
            $select = $offerproduct->fetchAllTimeFrequencyType();
            foreach($select as $timefrequencytype) {
                    $savingsForm->frequencyofdeposit->addMultiOption($timefrequencytype['id'],$timefrequencytype['type']);
             $savingsForm->Int_timefrequency_id->addMultiOption($timefrequencytype['id'],$timefrequencytype['type']);
                }
                // set all form field values
		$result = $offerproduct->viewofferProduct($offerproduct_id,$this->view->shortname);
            foreach($result as $saving) {  
                $this->view->form->savingproductname->setValue($saving['productname']);
                $this->view->form->offerproductname->setValue($saving['pname']);
                $this->view->form->offerproductshortname->setValue($saving['psname']);
                $this->view->form->offerproduct_description->setValue($saving['description']);
                $bdate = $convertdate->phpnormalformat($saving['begindate']);
                $this->view->form->begindate->setValue($bdate);
                $cdate = $convertdate->phpnormalformat($saving['closedate']);
                $this->view->form->closedate->setValue($cdate);
                $this->view->form->applicableto->setValue($saving['applicableto']);
                $this->view->form->glsubcode_id->setValue($saving['glsubcode_id']);
            } 
            if($this->view->shortname == 'ps') {
                $this->view->form->minmumdeposit->setValue($saving['minmumdeposit']);
                $this->view->form->frequencyofdeposit->setValue($saving['frequencyofdeposit']);
                $this->view->form->Int_timefrequency_id->setValue($saving['Int_timefrequency_id']);
                $this->view->form->frequencyofinterestupdating->setValue($saving['frequencyofinterestupdating']);
                $this->view->form->minimumbalanceforinterest->setValue($saving['minimumbalanceforinterest']);
            }
            if($this->view->shortname == 'fd' || $this->view->shortname == 'rd') {
                    $this->view->form->minimum_deposit_amount->setValue($saving['minimum_deposit_amount']);
                    $this->view->form->maximum_deposit_amount->setValue($saving['maximum_deposit_amount']);
                    $this->view->form->frequency_of_deposit->setValue($saving['frequency_of_deposit']);
                    $this->view->form->penal_Interest->setValue($saving['penal_Interest']);
		$frequency_of_deposit = $offerproduct->fetchAllTimeFrequencyType();
		foreach($frequency_of_deposit as $frequencyofdeposit) {
			$savingsForm->frequency_of_deposit->addMultiOption($frequencyofdeposit['id'],$frequencyofdeposit['type']);
		}
            }
            $interestperiods = $offerproduct->viewinterest($this->view->offerproduct_id);
            $this->view->viewinterest = $interestperiods;

        if ($this->_request->isPost() && $this->_request->getPost('Update')) { 
            $formData = $this->_request->getPost();
            $interestperiods = new Management_Model_Interestperiods();
                if ($this->_request->isPost()) {
               $productshortname = $this->_request->getParam('shortname'); 
               $offerproductid = $this->_request->getParam('offerproduct_id');
               $Count = $this->_request->getParam('count');
               $memberCount = $this->_request->getParam('memberCount');
               $month='months';
               $closeddate = $this->_request->getParam('closedate');  

            if($productshortname == 'ps') { //make it as non mandatory fields
                $savingsForm->closedate->setRequired(false);
                $savingsForm->minimum_deposit_amount->setRequired(false);
                $savingsForm->maximum_deposit_amount->setRequired(false);
                $savingsForm->frequency_of_deposit->setRequired(false);
                $savingsForm->penal_Interest->setRequired(false);
            } else { //make it as non mandatory fields
                $savingsForm->minmumdeposit->setRequired(false);
                $savingsForm->frequencyofdeposit->setRequired(false);
                $savingsForm->Int_timefrequency_id->setRequired(false);
                $savingsForm->frequencyofinterestupdating->setRequired(false);
                $savingsForm->minimumbalanceforinterest->setRequired(false);
            }
               $previousdata = $this->view->adm->editRecord("ourbank_productsoffer",$offerproductid); // get products offer details
               $result=$offerproduct->addofferproduct1($previousdata[0],$offerproductid); // insert into products offer details to log table
                $offerproduct->updateRecordpoffer($offerproductid,$formData,$this->view->shortname);
                // //if the record is belongs to personal savings
            if($productshortname == 'ps') {
                $previousdataps = $this->view->adm->getRecord("ourbank_productssaving",'productsoffer_id',$offerproductid); // get products saving details
                $result = $offerproduct->addofferproductsavingslog($previousdataps[0],$offerproductid);//Insert Products saving details to log table
            $offerproduct->updateRecordps($offerproductid,$formData);
            
            }else {
            $previousdatafd = $this->view->adm->getRecord("ourbank_product_fixedrecurring",'productsoffer_id',$offerproductid); // get products saving details
                $result = $offerproduct->fixedrecurringlog($previousdatafd[0],$offerproductid);//Insert Products saving details to log table
            $offerproduct->updateRecordfd($offerproductid,$formData);
            }
            $interestrecord = $offerproduct->getRecord($offerproductid); //get interest details
                foreach($interestrecord as $intrecord){
                    $interestdata = (array('record_id' => '',
                                    'period_id' => $intrecord['id'],
                                    'period_ofrange_monthfrom'=> $intrecord['period_ofrange_monthfrom'],
                                    'period_ofrange_monthto'=> $intrecord['period_ofrange_monthto'],                 'period_ofrange_description' => $intrecord['period_ofrange_description'],      'offerproduct_id' => $intrecord['offerproduct_id'],
                                    'Interest' => $intrecord['Interest'],                                                'intereststatus_id'=>3));
                    $result = $offerproduct->addinterestlog('ourbank_interest_periods_log',$interestdata);
                }
            $offerproduct->deleteinterestRecord($offerproductid); //delete that particular record
            // insert interest values
            if($Count!=0)
            {
                for ($i = 1;$i<=$Count; $i++) {
                    $From = $this->_request->getParam('ifrom'.$i); 
                    $To = $this->_request->getParam('iTo'.$i); 
                    $Rate = $this->_request->getParam('iRate'.$i); 
                    $month='months';
                    $period_ofrange_description = $From.-$To.$month;
                    if($From) {
                    $interestperiod = $interestperiods->insertinterestperiods(array('id' =>'',
                                                                            'period_ofrange_monthfrom' => $From,
                                                                            'period_ofrange_monthto'=> $To,
                                                                                'period_ofrange_description'=> $period_ofrange_description,
                                                                                'offerproduct_id' => $offerproductid,
                                                                                'Interest' => $Rate,
                                                                                'intereststatus_id'=>3));
                        }
                }
            }          
            if($memberCount!=0)
            {
            for ($i = 1;$i<=$memberCount; $i++) {
                $From = $this->_request->getParam('memberName'.$i); 
                $To = $this->_request->getParam('To'.$i); 
                $Rate = $this->_request->getParam('Rate'.$i); 
                $month='months';
                $period_ofrange_description = $From.-$To.$month;
                if($From) {
                $interestperiod = $interestperiods->insertinterestperiods(array('id' =>'',
                                                                        'period_ofrange_monthfrom' => $From,
                                                                        'period_ofrange_monthto'=> $To,
                                                                            'period_ofrange_description'=> $period_ofrange_description,
                                                                            'offerproduct_id' => $offerproductid,
                                                                            'Interest' => $Rate,
                                                                            'intereststatus_id'=>3));
                    }

            }
          }
    }       
            
            $this->_redirect('savings/index');
    }
}

// 
	public function savingsdeleteAction() {
		$this->view->title = "Delete Savings";
                // decode given value 
		$offerproduct_id = base64_decode($this->_getParam('id'));
                $this->view->offerid = $offerproduct_id;
                 $this->view->form = $deleteform = new Savings_Form_Delete();
                $dbobj = new Savings_Model_Savings();
                // get the status of product 
                $status = $dbobj->getsavingstatus($offerproduct_id);
                $product = $dbobj->getproductname($offerproduct_id);
               foreach($product as $productd){
                    $this->view->productname = $productd['name'];
                    $productid = $productd['product_id'];
                }

                if(!$status)
                { 
                if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
// 
                    if ($this->view->form->isValid($this->_request->getPost())) {
                    $remarks = $this->_getParam('remarks');
                        // delete interest periods value for that product offer 
                            $deletefixedsaving = $this->view->adm->deleteRecordwithparam("ourbank_interest_periods",'offerproduct_id ',$offerproduct_id);
                        if($productid == 1){
                        $deletepersonalsaving = $this->view->adm->deleteRecordwithparam("ourbank_productssaving",'productsoffer_id ',$offerproduct_id);
                        }
                           // delete savings details if the offer is belongs to fixed or recurring saving product 
                         else {
                          $deletefixedsaving = $this->view->adm->deleteRecordwithparam("ourbank_product_fixedrecurring",'productsoffer_id ',$offerproduct_id);
                        }
                        // // delete product offer details 
                        $deleteofferdetails = $this->view->adm->deleteRecordwithparam("ourbank_productsoffer",'id',$offerproduct_id);
                        // // //delete savings details if the offer is belongs to personal saving product 

                             $this->_redirect('savings/index');

                        }
			}
		}else {

                    $this->_helper->flashMessenger->addMessage('You cannot delete this product offer, its in usage');
                    $this->_helper->redirector('index');
               }
	}
}
