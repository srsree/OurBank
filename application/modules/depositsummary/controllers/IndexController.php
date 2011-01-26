
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
/*
 *  create an Depositsummary controller for view and pdf
 */
class Depositsummary_IndexController extends Zend_Controller_Action
{

     function init()
     { 
         $this->view->pageTitle = $this->view->translate('Deposit summary');
         $this->view->tilte = $this->view->translate('Reports');
         $this->view->type = "others";
         $this->view->adm = new App_Model_Adm();

     }
      //view action
     function indexAction()
     {

	$searchForm = new Depositsummary_Form_Search();
        $this->view->form = $searchForm;
       
	 $savingsummary = new Depositsummary_Model_Depositsummary();
 
        $products = $this->view->adm->viewRecord('ourbank_office','id','asc');
        foreach($products as $subBranch1) {
                        $searchForm->branch->addMultiOption($subBranch1['id'],$subBranch1['name']);
                }
        $this->view->depositeAmount = 0;
        $this->view->withdrawlAmount = 0;
        $this->view->totalAmount = 0; 
        $this->view->deposit = 0;
        $this->view->withdrawl = 0;
        $this->view->sum = 0;


        if ($this->_request->isPost() && $this->_request->getPost('Search')) {
             $formData = $this->_request->getPost();
                 if ($searchForm->isValid($formData)) {
                    $office_id = $this->_request->getParam('branch'); 
                    $this->view->office_id=$office_id;
                    $this->view->result = $savingsummary->fetchSavingsDetails($office_id); 
                    $accountBalanc = $savingsummary->accountBalanceDetails($office_id);
        
                    $this->view->accountBalanc = $accountBalanc;
                    if ((!$this->view->result) && (!$accountBalanc)) {
                        echo "<font color='RED' size = '3'>No Savings Account</font>";	
                    } else {
                        foreach($this->view->result as $result1) {
                            $this->view->officeName = $result1["officename"];
                        }
                    }   
                    
            } 
    }
     }
 
     function pdftransactionAction()
     {
        $pdf = new Zend_Pdf();
        $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $page;
        // Image
        $app = $this->view->baseUrl();
		$word=explode('/',$app);
		$projname='';
		for($i=0; $i<count($word); $i++) {
			if($i>0 && $i<(count($word)-1)) { $projname.='/'.$word[$i]; }
		}
		// Image
        $image_name = "/var/www".$projname."/public/images/logo.jpg";
        $image = Zend_Pdf_Image::imageWithPath($image_name);

        $page->drawImage($image, 30, 770, 130, 820);
        $page->setLineWidth(1)->drawLine(25, 25, 570, 25); //bottom horizontal
        $page->setLineWidth(1)->drawLine(25, 25, 25, 820); //left vertical
        $page->setLineWidth(1)->drawLine(570, 25, 570, 820); //right vertical
        $page->setLineWidth(1)->drawLine(570, 820, 25, 820); //top horizontal
        //set the font
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10);

        $text = array($this->view->translate("Deposit Summary"),$this->view->translate("Product"),$this->view->translate('Deposit summary'),$this->view->translate("No. of Savings"),$this->view->translate("Total Savings Amount"));



function position($amt){
             $len=strlen($amt);
	     $pos=490-($len*4);
             return $pos;
 }
$xx=50;
$xy=550;
$x1=60;
$x2=190;
$x3=330;
$x4=420;
            $page->drawText($text[0],260,750);

$y1=725;
if ($this->_request->getParam('field1')) {
            $officename=new Depositsummary_Model_Depositsummary();
            $OffName=$officename->officeNamefetch($this->_request->getParam('field1'));
            foreach($OffName as $OffName){} 
                $this->view->officeName=$OffName['name'];
            $page->drawText($this->view->translate("Branch Name : "),$x1,$y1);    $page->drawText($OffName['name'],$x2,$y1); $y1-=20;
}

//point to draw Side line
$startlinepoint=$y1;

            $page->drawLine($xx, $y1, $xy, $y1); $y1-=15;
            $page->drawText($text[1],$x1,$y1);                   $page->drawText($text[2],$x2,$y1); 
            $page->drawText($text[3],$x3,$y1);                   $page->drawText($text[4],$x4,$y1); $y1-=10;
            $page->drawLine($xx, $y1, $xy, $y1); $y1-=15;

        $this->view->depositAmount = 0;
        $this->view->withdrawlAmount = 0;
        $this->view->totalAmount = 0; 
        $this->view->deposit = 0;
        $this->view->withdrawl = 0;
        $this->view->sum = 0;


        if ($this->_request->getParam('field1')) {

            $office_id = $this->_request->getParam('field1'); 
            $this->view->office_id=$office_id;
            $savingsummary = new Depositsummary_Model_Depositsummary();

            $result = $savingsummary->fetchSavingsDetails($office_id);
            $this->view->result = $result; 
            
            $depositAmount=0;
            $deposit=0;
            $withdrawlAmount=0;
            $withdrawl=0;
            $totalamount=0;
            $sum=0;
            foreach($result as $result){

                    $page->drawText($result['productname'],$x1,$y1);
                    $page->drawText($result['prodoffername'],$x2,$y1);
                    $page->drawText($result['countvalue'],$x3,$y1); 

                $accountBalanc = $savingsummary->accountBalanceDetails($office_id);
                $this->view->accountBalanc = $accountBalanc;
                      foreach($accountBalanc as $accountBalanc){
                                if($result['id']==$accountBalanc['offerprodid'])
                                {
                                    if($accountBalanc['transactiontype_id'] == 1)
                                        {
                                            $depositAmount = $depositAmount + $accountBalanc['amount_to_bank'];
                                            $deposit = $deposit + $accountBalanc['amount_to_bank'];
                                        }

                                    if($accountBalanc['transactiontype_id'] == 2) {
                                    
                                        $withdrawlAmount = $withdrawlAmount + $accountBalanc['amount_from_bank'];
                                        $withdrawl = $withdrawl + $accountBalanc['amount_from_bank'];
                                        }


                                    $totalamount = $depositAmount - $withdrawlAmount;
                                    $sum = $deposit - $withdrawl;
                                }
                        }

                                    if($totalamount) { 
                                                             $pos=position(sprintf("%4.2f",$totalamount));
                                                             $page->drawText(sprintf("%4.2f",$totalamount),$pos,$y1);$y1-=18;
                                                             $totalamount =0; 
                                                             $withdrawlAmount =0;  
                                                             $depositAmount =0;
                                                     }
                                    else { echo "***"; }
            }

                   
                   $page->drawLine($xx, $y1, $xy, $y1);$y1-=18;
                    $page->drawText("Total",$x3,$y1);
           $pos=position(sprintf("%4.2f",$sum));
                    $page->drawText(sprintf("%4.2f",$sum),$pos,$y1);$y1-=10;
                     $page->drawLine($xx, $y1, $xy, $y1);


$page->drawLine($xx, $y1, $xx, $startlinepoint);//1st vertical line
$page->drawLine($x2-8, $y1, $x2-8, $startlinepoint);//1st vertical line
$page->drawLine($x3-10, $y1, $x3-10, $startlinepoint);//1st vertical line
$page->drawLine($x4-10, $y1, $x4-10, $startlinepoint);//1st vertical line
$page->drawLine($xy, $y1, $xy, $startlinepoint);//1st vertical line


           
            //echo "<pre>";print_r($accountBalanc);echo "<pre>";
            
            if (!$result && !$accountBalanc) {
                 echo "<font color='RED' size = '3'>No Savings Account</font>";	
            } 

        } 


    else {
           // $office_id = $this->_request->getParam('field1'); 

            $savingsummary = new Depositsummary_Model_Depositsummary();

   
           $result = $savingsummary->SavingsDetails();
            $this->view->result = $result; 
                $accountBalanc = $savingsummary->accountBalance();
                $this->view->accountBalanc = $accountBalanc;
            $depositAmount=0;
            $deposit=0;
            $withdrawlAmount=0;
            $withdrawl=0;
            $totalamount=0;
            $sum=0;
            foreach($result as $result){

                    $page->drawText($result['productname'],$x1,$y1);
                    $page->drawText($result['prodoffername'],$x2,$y1);
                    $page->drawText($result['countvalue'],$x3,$y1); 

                $accountBalanc = $savingsummary->accountBalance();
                $this->view->accountBalanc = $accountBalanc;
                      foreach($accountBalanc as $accountBalanc){
                                if($result['id']==$accountBalanc['offerprodid'])
                                {
                                    if($accountBalanc['transactiontype_id'] == 1)
                                        {
                                            $depositAmount = $depositAmount + $accountBalanc['amount_to_bank'];
                                            $deposit = $deposit + $accountBalanc['amount_to_bank'];
                                        }

                                    if($accountBalanc['transactiontype_id'] == 2) {
                                    
                                        $withdrawlAmount = $withdrawlAmount + $accountBalanc['amount_from_bank'];
                                        $withdrawl = $withdrawl + $accountBalanc['amount_from_bank'];
                                        }


                                    $totalamount = $depositAmount - $withdrawlAmount;
                                    $sum = $deposit - $withdrawl;
                                }
                        }

                                    if($totalamount) { 
                                                            $pos=position(sprintf("%4.2f",$totalamount));
                                                             $page->drawText(sprintf("%4.2f",$totalamount),$pos,$y1);$y1-=18;
                                                             $totalamount =0; 
                                                             $withdrawlAmount =0;  
                                                             $depositAmount =0;
                                                     }
                                    else { echo "***"; }
            }
            
                   
                   $page->drawLine($xx, $y1, $xy, $y1);$y1=18;
                    $page->drawText("Total",$x3,$y1);
                     $pos=position(sprintf("%4.2f",$sum));
                    $page->drawText(sprintf("%4.2f",$sum),$pos,$y1);$y1=10;
                    $page->drawLine($xx, $y1, $xy, $y1);

$page->drawLine($xx, $y1, $xx, $startlinepoint);//1st vertical line
$page->drawLine($x2-8, $y1, $x2-8, $startlinepoint);//1st vertical line
$page->drawLine($x3-10, $y1, $x3-10, $startlinepoint);//1st vertical line
$page->drawLine($x4-10, $y1, $x4-10, $startlinepoint);//1st vertical line
$page->drawLine($xy, $y1, $xy, $startlinepoint);//1st vertical line
           if (!$result && !$accountBalanc) {
                 echo "<font color='RED' size = '3'>No Savings Account</font>";	
            } 

        }
//          $y1-=15;
        $pdfData = $pdf->render();
        $pdf->save('/var/www'.$projname.'/reports/depositsummaryreport.pdf');
        $path = '/var/www'.$projname.'/reports/depositsummaryreport.pdf';
        chmod($path,0777);
        $this->_redirect('depositsummary/index');
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

//     public function chartAction()
// 	{
// 	    $branch=$this->_request->getParam('field1');
//             $savingsummary = new Reports_Model_Savingsummary();
//             $result = $savingsummary->fetchSavingsDetails($branch);
//             $this->view->result = $result; 
//             $accountBalanc = $savingsummary->accountBalanceDetails($branch);
//             $this->view->accountBalanc = $accountBalanc;
// 	} 
}
