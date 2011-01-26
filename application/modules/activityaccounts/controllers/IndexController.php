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
 *  create an activity controller for view, chart and search filtered values
 */
class Activityaccounts_IndexController extends Zend_Controller_Action
{
    public function init()
    {
        $this->view->pageTitle =  $this->view->translate("Activity wise accounts");
        $this->view->title =  $this->view->translate("Activity wise accounts");
	$this->view->type = "others";
	 $sessionName = new Zend_Session_Namespace('ourbank');
        $userid=$this->view->createdby = $sessionName->primaryuserid;
        $login=new App_Model_Users();
        $loginname=$login->username($userid);
        foreach($loginname as $loginname) 
	{
          $this->view->username=$loginname['username'];
        }
    }
	//view action
    public function indexAction()
    {
        $activityform=new Activityaccounts_Form_search();
        $this->view->form=$activityform;
	$activity=new Activityaccounts_Model_activityaccounts();
        $bank_name1=$activity->getBankname();
	//load bank name in drop down list
	foreach($bank_name1 as $bank_name) 
	{
	$activityform->bank->addMultiOption($bank_name['id'],$bank_name['name']);
	}
	//validate poster data
	if ($this->_request->isPost() && $this->_request->getPost('Search')) 
	{   $formData = $this->_request->getPost();
	    if($activityform->isValid($formData))
            { 
		$this->view->act_id=$activityid=$this->_request->getParam('bank');
		$res=$this->view->results=$activity->getactivity_accounts($activityid);
	   }
    	}
	}
	//chart action
	public function chartAction()
	{
		$activity_id=$this->_request->getParam('act_id');
		$activity=new Activityaccounts_Model_activityaccounts();
		$this->view->results=$activity->getactivity_accounts($activity_id);
	
	}
	//report display action
	function reportdisplayAction() {
		$app = $this->view->baseUrl();
		$word=explode('/',$app);
		$projname='';
		for($i=0; $i<count($word); $i++){
			if($i>0 && $i<(count($word)-1)) { $projname.='/'.$word[$i]; }
		}
		$this->_helper->layout->disableLayout();
		$file1 = $this->_request->getParam('file'); 
		$this->view->filename = $projname."/reports/".$file1;
	}

	function pdftransactionAction()
	{	
		$pdf = new Zend_Pdf();
		$page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
		$pdf->pages[] = $page;
		$baseURl=$this->view->baseUrl();
		$word=explode('/',$baseURl);
		$projname='';
		//word count 
		for($i=0; $i<count($word); $i++){
			if($i>0 && $i<(count($word)-1)) { $projname.='/'.$word[$i]; }
		}
		$image_name = "/var/www".$baseURl."/images/logo.jpg";
		$image = Zend_Pdf_Image::imageWithPath($image_name);
		//$page->drawImage($image, 25, 770, 570, 820);
	
		$page->drawImage($image, 30, 770, 130, 820);
		$page->setLineWidth(1)->drawLine(25, 25, 570, 25); //bottom horizontal
		$page->setLineWidth(1)->drawLine(25, 25, 25, 820); //left vertical
		$page->setLineWidth(1)->drawLine(570, 25, 570, 820); //right vertical
		$page->setLineWidth(1)->drawLine(570, 820, 25, 820); //top horizontal
		//set the font
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 8);
		//model activity
                $activity=new Activityaccounts_Model_activityaccounts();
                $bankid=$this->_request->getParam('bank');
                $bankname=$activity->getbank($bankid);
                foreach($bankname as $bankname){$banknameres=$bankname['name'];}
 		$text=array($this->view->translate("Activity wise accounts"),$this->view->translate("Activity"),$this->view->translate("Number of Account")); 
		$x2=150;
		$x3 = 250;
		$x4 = 380;
		$x6 = 450;
		$y1= 700;
		$page->drawLine(50, 740, 550, 740);
	        $page->drawLine(50, 720, 550, 720);
                $page->drawText($this->view->translate("Bank:    ").$banknameres, $x6, 750);
 		$page->drawText($text[0], $x3, 760);
         	$page->drawText($text[1], $x2, 725);
 		$page->drawText($text[2], $x4, 725);
		$this->view->results=$activity->getactivity_accounts($bankid);
                foreach($this->view->results as $activityresult){ 
                    $page->drawText($activityresult['name'], $x2, $y1);
                    $page->drawText($activityresult['COUNT(a.account_id)'], $x4, $y1);
                    $y1-=15;
                }	
		$page->drawLine(50, $y1, 550, $y1);
		$pdfData = $pdf->render();	
		$pdf->save('/var/www/'.$projname.'/reports/activityaccounts.pdf');
		$path = '/var/www/'.$projname.'/reports/activityaccounts.pdf';
		chmod($path,0777);
		//redirect
 		$this->_redirect('/activityaccounts/index/reportdisplay/file/activityaccounts.pdf');	
	}
}
