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
class Loandetails_IndexController extends Zend_Controller_Action {
	public function init() {
		$this->view->title = "Loan transactions";
                $sessionName = new Zend_Session_Namespace('ourbank');
                $userid=$this->view->createdby = $sessionName->primaryuserid;
                $login=new App_Model_Users();
                $loginname=$login->username($userid);
                foreach($loginname as $loginname) {
                $this->view->username=$loginname['username'];
                }
	}

	public function indexAction() {
                $storage = new Zend_Auth_Storage_Session();
                $data = $storage->read();
                if(!$data){
                    $this->_redirect('index/login');
                }
		$this->view->pageTitle='Loan details';
		$loansearch = new Loandisbursment_Form_Membersearch();
		$this->view->form = $loansearch;
		$this->view->transactiontype='Loan transaction';

		$loantransactions = new Loandisbursment_Model_loan();

		if ($this->_request->isPost() && $this->_request->getPost('Search')) {
			$formData = $this->_request->getPost();
			if ($this->_request->isPost()) {
				$formData = $this->_request->getPost();
				$accountNumber= $this->_request->getParam('member_id');
				if ($loansearch->isValid($formData)) {
					$search = $loantransactions->searchaccounts($accountNumber);
					if(!$search) {
                                            echo "Enter a valid Number";
				        } else {
                                            if(COUNT($search)=='1') {
                                                foreach($search as $account) {
                                                   $accountnumber=$account['account_number'];
                                                }
                                                $this->_redirect("/loandetails/index/loandetails/accountNumber/$accountnumber");
                                            } else {
                                                $this->view->accounts = $loantransactions->searchaccounts($accountNumber);
                                            }
					}
				}
			}
		}
	}

	public function loandetailsAction() {
           $storage = new Zend_Auth_Storage_Session();
           $data = $storage->read();
           if(!$data){
               $this->_redirect('index/login');
           }
	   $this->view->pageTitle='Loan details';
	   $accountNumber= $this->_request->getParam('accountNumber');
           $this->view->accNo=$accountNumber;
           $this->view->accountnumber=$accountNumber;
	   $loantransactions = new Loandisbursment_Model_loan();
	   $search = $loantransactions->searchaccounts($accountNumber);
           $date = new Zend_Date();


            foreach($search as $arrayroles1) {
                $account_id=$this->view->account_id=$arrayroles1['account_id'];
                $this->view->type=$arrayroles1['membertype_id'];
                $this->view->membertype=$arrayroles1['membertype'];
                $loansanctionedamount=$this->view->loansanctionedamount=$arrayroles1['loan_amount'];
                $loansanctioneddate=$this->view->loansanctioneddate=$arrayroles1['loansanctioned_date'];
                $loanintereste=$this->view->loaninterest=$arrayroles1['loan_interest'];
                $totalloanInstallments=$this->view->totalloanInstallments=$arrayroles1['loan_installments'];
                $accountstatusId=$arrayroles1['accountstatus_id'];
                $ballet=$this->view->ballet=$arrayroles1['billet'];
                $fee=$this->view->fee=$arrayroles1['fee'];
                $amountdelivered=$this->view->amountdelivered=$loansanctionedamount-$fee;
            }

            if($this->view->type==3) {
                $arrayroles = $loantransactions->search($accountNumber,$this->view->type);
                $this->view->member = $arrayroles;
                foreach($arrayroles as $arrayroles1) {
                    $this->view->code=$arrayroles1['groupcode'];
                    $this->view->name=$arrayroles1['group_name'];
                    $this->view->type=$arrayroles1['membertype_id'];
                    $this->view->creditlineid=$arrayroles1['creditline_id'];
                    $mobileno=$this->view->mobile=$arrayroles1['mobile'];
	       }
               $groupmembers= $this->view->groupmembers = $loantransactions->groupmembers($account_id);
               $noOfGroupmembersinaccount=COUNT($groupmembers);
	   } 


            if($this->view->type==4) {
                /**fetch all details if member type is 	Individual*/
                $arrayroles = $loantransactions->search($accountNumber,$this->view->type);
                $this->view->member = $arrayroles;
                foreach($arrayroles as $arrayroles1) {
                    $this->view->code=$arrayroles1['membercode'];
                    $this->view->name=$arrayroles1['member_name'];
                    $this->view->type=$arrayroles1['membertype_id'];
                    $this->view->creditlineid=$arrayroles1['creditline_id'];
                    $mobileno=$this->view->mobile=$arrayroles1['mobile'];
	       }
	   }
	   $loanrepayment = new Loanrepayment_Model_loanrepayment();
           $loanDetails1 = $loanrepayment->fetchLoanDisbursementDetails($account_id);
           $totladisburseAmount=0;
           foreach($loanDetails1 as $arrayroles1) {
              $totladisburseAmount=$totladisburseAmount+$arrayroles1['amount_disbursed'];
              $disburseddate=$arrayroles1['disbursement_date'];
           }
           $this->view->totladisburseAmount=$totladisburseAmount;

           if($totladisburseAmount) {
                $overDueInstalment=$loanrepayment->overDueInstalment($account_id);
                $this->view->noOfOverDueInstalment=count($overDueInstalment);
                if($this->view->noOfOverDueInstalment>="0") {
                    $due = $this->view->dueAmount="0";	
                    $next = $loanrepayment->loanNextInstalmentDetails($account_id);
                    foreach($next as $nextInstallment){
                        $this->view->nextInstallment = $nextInstallment['accountinstallment_amount'];
                        $this->view->installment_status = $nextInstallment['installment_status'];
                    }
                    foreach($overDueInstalment as $overDueInstalment1) {
                        $this->view->dueAmount=$this->view->dueAmount+$overDueInstalment1['accountinstallment_amount'];
                        $due = $this->view->dueAmount;
                        $this->view->installment_status = $overDueInstalment1['installment_status'];
                    }
                } else {
                    $due = "0";
                }

                $InstalmentPaid=$loanrepayment->noOfInstalmentPaied($account_id);
                $noOfInstalmentPaid=count($InstalmentPaid);
                $this->view->noOfInstalmentPaid=$noOfInstalmentPaid;
                $this->view->paidAmount=0;
                foreach($InstalmentPaid as $InstalmentPaid) {
                    $this->view->paidAmount=$this->view->paidAmount+$InstalmentPaid['accountinstallment_amount'];
                }

                $this->view->balanceInstallment=$totalloanInstallments-$noOfInstalmentPaid;

                $loanstillHaveToPay = $loanrepayment->loanstilltopay($account_id);
                foreach($loanstillHaveToPay as $loanstilltopayamount) {
                    $this->view->stillHaveToPay=$loanstilltopayamount['stilltopayamount'];
                }

                if($noOfInstalmentPaid==$totalloanInstallments) {
                    $data = array('accountstatus_id' =>'5');
                    $loanrepayment->updatemainaccountstatus($account_id,$data);
                    $data1 = array('loanstatus_id' =>'5','recordstatus_id' =>'5');
                    $loanrepayment->updateloanaccountstatus($account_id,$data1);
    
                    if($this->view->type==3) {
                        $data3 = array('groupmember_account_status' =>'5');
                        $loanrepayment->updategroupmemberloanaccountstatus($account_id,$data3);
                    }
                    $this->_redirect('loanrepayment');
                }

                $loanInstalmentDetails = $loanrepayment->loanInstalmentDetails($account_id);
                foreach($loanInstalmentDetails as $loanInstalmentDetails1) {
                    $rateOfIntrest=$loanInstalmentDetails1['loan_interest'];
                    $noInstalment=$loanInstalmentDetails1['loan_installments'];
                    $this->view->loanAmount=$loanInstalmentDetails1['loan_amount'];
                    $this->view->loanAmountSanctioned = $loanInstalmentDetails1['loan_amount'];
                    $disbursedDate=$loanInstalmentDetails1['disbursement_date'];
                }
                $this->view->rateOfIntrest=$rateOfIntrest;
                $this->view->noInstalment=$noInstalment;

                $InstalmentNumber=$noOfInstalmentPaid+1;
                $currinstalmentNumber=$InstalmentNumber;

                $loanInstalmentDetailsOfInstalmentNo = $loanrepayment->loanInstalmentDetailsOfInstalmentNo($account_id,$InstalmentNumber);
                foreach($loanInstalmentDetailsOfInstalmentNo as $loanInstalmentDetailsOfInstalmentNo1) {
                    $nextInstalmentDate=$loanInstalmentDetailsOfInstalmentNo1['accountinstallment_date'];
                    $haveToPay=$loanInstalmentDetailsOfInstalmentNo1['accountinstallment_amount'];
                    $loanInterestAmount=$loanInstalmentDetailsOfInstalmentNo1['accountinstallment_interest_amount'];
                    $accountinstallment_date=$loanInstalmentDetailsOfInstalmentNo1['accountinstallment_date'];
                    $accountinstallment_date1=$accountinstallment_date;
                    $systemDate= $date->get(Zend_Date::DATES);/**system date*/
                    $currentdate=$date->toString('YYYY-MM-dd');

                    $loanInstalmentPayied=$loanrepayment->loanInstalmentPaid($account_id,$InstalmentNumber-1);
                    if($loanInstalmentPayied) {
                        foreach($loanInstalmentPayied as $loanInstalmentDetailsOfInstalmentNo1) {
                            $lastPaidDate=$loanInstalmentDetailsOfInstalmentNo1['loaninstallmentpaid_date'];
                        }
                    } else { 
                        $lastPaidDate=$disbursedDate;
                    }
                }

	        $loandetails = new Loandetails_Model_loandetails();
                $this->view->loanInstalments=$loandetails->loanInstalments($this->view->account_id);
            }
       }

	public function pdftransactionAction() {
		$pdf = new Zend_Pdf();
		$page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
		$pdf->pages[] = $page;
		// Image
		$baseURl=$this->view->baseUrl();
		$word=explode('/',$baseURl);
		$projname='';
		for($i=0; $i<count($word); $i++) {
			if($i>0 && $i<(count($word)-1)) { $projname.='/'.$word[$i]; }
		}

		$image_name = "/var/www".$baseURl."/images/logo.jpg";
		$image = Zend_Pdf_Image::imageWithPath($image_name);
	
		$page->drawImage($image, 30, 770, 130, 820);
		$page->setLineWidth(1)->drawLine(25, 25, 570, 25); //bottom horizontal
		$page->setLineWidth(1)->drawLine(25, 25, 25, 820); //left vertical
		$page->setLineWidth(1)->drawLine(570, 25, 570, 820); //right vertical
		$page->setLineWidth(1)->drawLine(570, 820, 25, 820); //top horizontal
		//set the font
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10);

		
		$this->view->accNo=$accountNumber= $this->_request->getParam('accountNumber');
		$convertdate = new Creditline_Model_dateConvertor();

		$text = array("Loan Details");

		$hx=250;
		$y1=760;
		$page->drawText($text[0],$hx,$y1);//For Top Header

		//part one
		$loantransactions = new Loandisbursment_Model_loan();
		$search = $loantransactions->searchaccounts($accountNumber);
		foreach($search as $arrayroles1) {
			$account_id=$this->view->account_id=$arrayroles1['account_id'];
			$this->view->type=$arrayroles1['membertype_id'];
			$totalloanInstallments=$this->view->totalloanInstallments=$arrayroles1['loan_installments'];
			$loansanctionedamount=$this->view->loansanctionedamount=$arrayroles1['loan_amount'];
			$fee=$this->view->fee=$arrayroles1['fee'];
			$amountdelivered=$this->view->amountdelivered=$loansanctionedamount-$fee;
 		}
		
		$arrayroles = $loantransactions->search($accountNumber,$this->view->type);
		$this->view->member = $arrayroles;
		$xa =array(60,170);
		$ya=730;

		$xa1=array(55,160,340); $ya1=745; //box for user details
		$page->drawLine($xa1[0],$ya1,$xa1[2],$ya1);

		foreach($arrayroles as $arrayroles2){
$goodDogCoolFont = Zend_Pdf_Font::fontWithPath('/usr/share/fonts/truetype/ttf-kannada-fonts/lohit_kn.ttf');
$page->setFont($goodDogCoolFont, 10);
			$page->drawText('ಭಾವನಾ', $xa[0], $ya,'UTF-8');
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10);

 $page->drawText($arrayroles2['member_name'], $xa[1], $ya); 		$ya-=15;
// 			$page->drawText('Name', $xa[0], $ya); $page->drawText($arrayroles2['member_name'], $xa[1], $ya); 		$ya-=15;

			$page->drawText('Branch', $xa[0], $ya); $page->drawText($arrayroles2['Institute_bank_name'], $xa[1], $ya); 	$ya-=15;
			$page->drawText('Member code', $xa[0], $ya); $page->drawText($arrayroles2['member_code'], $xa[1], $ya); 	$ya-=15;
			$page->drawText('Account code', $xa[0], $ya); $page->drawText($arrayroles2['account_number'], $xa[1], $ya); 	$ya-=15;
			$page->drawText('Sector name', $xa[0], $ya); $page->drawText($arrayroles2['sector_name'], $xa[1], $ya);		 $ya-=15;
			$page->drawText('Activity name', $xa[0], $ya); $page->drawText($arrayroles2['activity_name'], $xa[1], $ya);	 $ya-=15;
			$page->drawText('Loan amount R$', $xa[0], $ya); $page->drawText($arrayroles2['loan_amount'], $xa[1], $ya); 	$ya-=15;
			$page->drawText('Fee amount R$', $xa[0], $ya); $page->drawText($arrayroles2['fee'], $xa[1], $ya); 		$ya-=15;
			$page->drawText('Amount delivered R$', $xa[0], $ya); $page->drawText($amountdelivered, $xa[1], $ya); 		$ya-=15;
			$page->drawText('Interest rate %', $xa[0], $ya); $page->drawText($arrayroles2['loan_interest'], $xa[1], $ya); 	$ya-=15;
			$page->drawText('Billet R$', $xa[0], $ya); $page->drawText($arrayroles2['billet'], $xa[1], $ya); 		$ya-=15;
			$page->drawText('Installments', $xa[0], $ya); $page->drawText($arrayroles2['loan_installments'], $xa[1], $ya); 	$ya-=15;
				$loansanctioned_date=$convertdate->phpnormalformat($arrayroles2['loansanctioned_date']);
			$page->drawText('Sanctioned date', $xa[0], $ya); $page->drawText($loansanctioned_date, $xa[1], $ya); $ya-=15;
		}
		$page->drawLine($xa1[0],$ya,$xa1[2],$ya); //bottom line Part two

		$page->drawLine($xa1[0],$ya,$xa1[0],$ya1); //left vertical Part two
		$page->drawLine($xa1[1],$ya,$xa1[1],$ya1); //left Center Part two
		$page->drawLine($xa1[2],$ya,$xa1[2],$ya1); //left Center Part two

		$ya-=15;
		//part two
		$xc =array(380,430,500);
		$yc=730;

		$xc1=array(370,420,490,540); $yc1=745; //box for user details

		$text1 = array("Type","Installment","Amount");
		$loanrepayment = new Loanrepayment_Model_loanrepayment();
		$loanDetails1 = $loanrepayment->fetchLoanDisbursementDetails($account_id);
		$totladisburseAmount=0;
		foreach($loanDetails1 as $arrayroles1) {
		$totladisburseAmount=$totladisburseAmount+$arrayroles1['amount_disbursed'];
		$disburseddate=$arrayroles1['disbursement_date'];
		}
		$this->view->totladisburseAmount=$totladisburseAmount;
	
		if($totladisburseAmount) {
			$page->drawLine($xc1[0],$yc1,$xc1[3],$yc1);

			$page->drawText($text1[0], $xc[0], $yc); $page->drawText($text1[1], $xc[1], $yc); $page->drawText($text1[2], $xc[2], $yc);
			$yc-=10; 
			$page->drawLine($xc1[0],$yc,$xc1[3],$yc);

			$yc-=15;
			$InstalmentPaid=$loanrepayment->noOfInstalmentPaied($account_id);
			$noOfInstalmentPaid=count($InstalmentPaid);

			$page->drawText('Paid', $xc[0], $yc); $page->drawText($noOfInstalmentPaid, $xc[1], $yc);
			$this->view->paidAmount=0;
			foreach($InstalmentPaid as $InstalmentPaid) {
                    		$this->view->paidAmount=$this->view->paidAmount+$InstalmentPaid['accountinstallment_amount'];
                	}
			$page->drawText($this->view->paidAmount, $xc[2], $yc);

			$this->view->balanceInstallment=$totalloanInstallments-$noOfInstalmentPaid;
			$yc-=15;
			$page->drawText('Due', $xc[0], $yc); $page->drawText($this->view->balanceInstallment, $xc[1], $yc);

			$loanstillHaveToPay = $loanrepayment->loanstilltopay($account_id);
			foreach($loanstillHaveToPay as $loanstilltopayamount) {
				$this->view->stillHaveToPay=$loanstilltopayamount['stilltopayamount'];
			}
			$page->drawText($this->view->stillHaveToPay, $xc[2], $yc);$yc-=10;
			$page->drawLine($xc1[0],$yc,$xc1[3],$yc);

			$page->drawLine($xc1[0],$yc,$xc1[0],$yc1);//left
			$page->drawLine($xc1[1],$yc,$xc1[1],$yc1);//center 1
			$page->drawLine($xc1[2],$yc,$xc1[2],$yc1);//center 2
			$page->drawLine($xc1[3],$yc,$xc1[3],$yc1);//right

			//part three
			$xd =array(60,120,190,260,310,390,460,510);
			$xd1 = array(55,115,185,255,305,385,455,505,565); 

			$new_y_value=min($ya,$yc);
			$yd1=$new_y_value-20;
			$page->drawLine($xd1[0],$yd1,$xd1[8],$yd1);

			$yd=$yd1-15;

			$text2 = array("Installment","Principal (R$)","Interest (R$)","Billet (R$)","Installment (R$)","Due date","Status","Current due");
			
			$page->drawText($text2[0], $xd[0], $yd); $page->drawText($text2[1], $xd[1], $yd); $page->drawText($text2[2], $xd[2], $yd); $page->drawText($text2[3], $xd[3], $yd); $page->drawText($text2[4], $xd[4], $yd); $page->drawText($text2[5], $xd[5], $yd); $page->drawText($text2[6], $xd[6], $yd);/*$page->drawText($text2[7], $xd[7], $yd);*/
			$yd-=10;
			$page->drawLine($xd1[0],$yd,$xd1[8],$yd);
			$yd-=15;
			$loandetails = new Loandetails_Model_loandetails();
			$loanInstalments=$this->view->loanInstalments=$loandetails->loanInstalments($this->view->account_id);
			$total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0;
			foreach($loanInstalments as $loanInstalments1) {
			if($yd1>20) {
				$page->drawText($loanInstalments1['accountinstallment_id'], $xd[0], $yd); $page->drawText($loanInstalments1['installment_principal_amount'], $xd[1], $yd);
					$total1+=$loanInstalments1['installment_principal_amount'];
				$page->drawText($loanInstalments1['accountinstallment_interest_amount'], $xd[2], $yd);
					$total2 = $total2 + $loanInstalments1['accountinstallment_interest_amount'];
				$page->drawText($loanInstalments1['billet'], $xd[3], $yd);
					$total3 = $total3 + $loanInstalments1['billet'];
				$page->drawText($loanInstalments1['accountinstallment_amount'], $xd[4], $yd);
					$total4 = $total4 + $loanInstalments1['accountinstallment_amount'];

				$accountinstallment_date=$convertdate->phpnormalformat($loanInstalments1['accountinstallment_date']);

				$page->drawText($accountinstallment_date, $xd[5], $yd); 
				$page->drawText($loanInstalments1['statusdescription'], $xd[6], $yd); 
/*				$page->drawText($loanInstalments1['current_due'], $xd[7], $yd); */
			$yd-=15;
			} else {
				$page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
				$pdf->pages[] = $page;
				// Image
				$baseURl=$this->view->baseUrl();
				$word=explode('/',$baseURl);
				$projname='';
				for($i=0; $i<count($word); $i++){ 
					if($i>0 && $i<(count($word)-1)) { $projname.='/'.$word[$i]; } 
				}
				$image_name = "/var/www".$baseURl."/images/logo.jpg";
				$image = Zend_Pdf_Image::imageWithPath($image_name);
			
				$page->drawImage($image, 30, 770, 130, 820);
				$page->setLineWidth(1)->drawLine(25, 25, 570, 25); //bottom horizontal
				$page->setLineWidth(1)->drawLine(25, 25, 25, 820); //left vertical
				$page->setLineWidth(1)->drawLine(570, 25, 570, 820); //right vertical
				$page->setLineWidth(1)->drawLine(570, 820, 25, 820); //top horizontal
				//set the font
				$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10);

				$yd=$yd1-15;
				$page->drawText($loanInstalments1['accountinstallment_id'], $xd[0], $yd); $page->drawText($loanInstalments1['installment_principal_amount'], $xd[1], $yd);
					$total1+=$loanInstalments1['installment_principal_amount'];
				$page->drawText($loanInstalments1['accountinstallment_interest_amount'], $xd[2], $yd);
					$total2 = $total2 + $loanInstalments1['accountinstallment_interest_amount'];
				$page->drawText($loanInstalments1['billet'], $xd[3], $yd);
					$total3 = $total3 + $loanInstalments1['billet'];
				$page->drawText($loanInstalments1['accountinstallment_amount'], $xd[4], $yd);
					$total4 = $total4 + $loanInstalments1['accountinstallment_amount'];

				$accountinstallment_date=$convertdate->phpnormalformat($loanInstalments1['accountinstallment_date']);
				$page->drawText($accountinstallment_date, $xd[5], $yd); 
				$page->drawText($loanInstalments1['statusdescription'], $xd[6], $yd); 
/*				$page->drawText($loanInstalments1['current_due'], $xd[7], $yd); */
				$yd-=15;
			}
			}
			$page->drawLine($xd1[0],$yd,$xd1[8],$yd); $yd-=15;
			$page->drawText('Total', $xd[0], $yd);
			$page->drawText($total1, $xd[1], $yd);
			$page->drawText($total2, $xd[2], $yd);
			$page->drawText($total3, $xd[3], $yd);
			$page->drawText($total4, $xd[4], $yd);$yd-=10;
			$page->drawLine($xd1[0],$yd,$xd1[8],$yd);

			for($i=0; $i<count($xd1); $i++) {
				if($i!=7){
					$page->drawLine($xd1[$i], $yd, $xd1[$i], $yd1);
				}
			}//All vertical line
		}
		$pdfData = $pdf->render();
		$pdf->save('/var/www'.$projname.'/reports/loandetails_'.$accountNumber.'.pdf');
		$path = '/var/www'.$projname.'/reports/loandetails_'.$accountNumber.'.pdf';
		chmod($path,0777);
		$this->_redirect("/loandetails/index/loandetails/accountNumber/$accountNumber");
	}

	function reportdisplayAction() {
		$this->_helper->layout->disableLayout();
		$file1 = $this->_request->getParam('file');
		$app = $this->view->baseUrl();
		$word=explode('/',$app);
		$projname='';
		for($i=0; $i<count($word); $i++) {
			if($i>0 && $i<(count($word)-1)) { $projname.='/'.$word[$i]; }
		}
                $this->view->filename = $projname."/reports/".$file1;
	}
}