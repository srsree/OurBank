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
 *  create an activity controller to view, chart action and pdf action
 */
class Activityreport_IndexController extends Zend_Controller_Action
{
    public function init()
    {
        $this->view->pageTitle = $this->view->translate("Gender and age wise number of accounts");
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
        $activityform=new Activityreport_Form_activityreport();
        $this->view->form=$activityform;
        $activity_ratio=new Activityreport_Model_activityreport();
        $activity_name=$activity_ratio->getActivity();
	//load activity name dropdown
        foreach($activity_name as $activity_name1)
        {
            $activityform->activity->addMultiOption($activity_name1['id'],$activity_name1['name']);
        }
	
	$gender= $activity_ratio->getGender();
	//load gender dropdown
	foreach($gender as $gender1) { 
		$activityform->gender->addMultiOption($gender1['id'],$gender1['sex']);
	}
	   //filter details
	   if ($this->_request->isPost() && $this->_request->getPost('Search')) 
	{   $formData = $this->_request->getPost();
	    if($activityform->isValid($formData))
            {
		$this->view->no=1;
		$this->view->activityname=$activityid=$this->_request->getParam('activity');
		$this->view->gendername=$gender=$this->_request->getParam('gender');
		$activityname=$activity_ratio->getactivityname($activityid);
		foreach($activityname as $result){
		$this->view->activity=$result['name'];
		}
		$gendername=$activity_ratio->getGendername($gender);
		foreach($gendername as $gendername){
		$this->view->gender=$gendername['sex'];
		}
		//age limit 
		$this->view->from1=$from_age=16;
		$this->view->to1=$to_age=25;
		$activity_result1=$activity_ratio->getactivity_between($from_age,$to_age,$activityid,$gender);
		foreach($activity_result1 as $age1){}
		$this->view->age1=$age1['accountcount'];
		$this->view->from2=$from_age=26;
		$this->view->to2=$to_age=35;
		$activity_result2=$activity_ratio->getactivity_between($from_age,$to_age,$activityid,$gender);
		foreach($activity_result2 as $age2){}
		$this->view->age2=$age2['accountcount'];
	
		$this->view->from3=$from_age=36;
		$this->view->to3=$to_age=45;
		$activity_result3=$activity_ratio->getactivity_between($from_age,$to_age,$activityid,$gender);
		foreach($activity_result3 as $age3){}
		$this->view->age3=$age3['accountcount'];
	
		$this->view->from4=$from_age=46;
		$this->view->to4=$to_age=60;
		$activity_result4=$activity_ratio->getactivity_between($from_age,$to_age,$activityid,$gender);
		foreach($activity_result4 as $age4){}
		$this->view->age4=$age4['accountcount'];	
		$this->view->age=$age=61;
		$activity_result5=$activity_ratio->getactivity_above($age,$activityid,$gender);
		foreach($activity_result5 as $age5){}
		$this->view->age5=$age5['accountcount'];
		
	   }
    	}
	}
	//chart action
	public function chartAction()
	{
		$this->view->pageTitle = $this->view->translate("Gender and age wise number of accounts chart");
		$activityid = $this->_request->getParam('act_id');
        	$this->view->genderid=$gender= $this->_request->getParam('gen_id');
		$activity_ratio=new Activityreport_Model_activityreport();
		//age limit
		$this->view->from1=$from_age=16;
		$this->view->to1=$to_age=25;
		$activity_result1=$activity_ratio->getactivity_between($from_age,$to_age,$activityid,$gender);
		foreach($activity_result1 as $age1){}
		$this->view->age1=$age1['accountcount'];
		$this->view->from2=$from_age=26;
		$this->view->to2=$to_age=35;
		$activity_result2=$activity_ratio->getactivity_between($from_age,$to_age,$activityid,$gender);
		foreach($activity_result2 as $age2){}
		$this->view->age2=$age2['accountcount'];
	
		$this->view->from3=$from_age=36;
		$this->view->to3=$to_age=45;
		$activity_result3=$activity_ratio->getactivity_between($from_age,$to_age,$activityid,$gender);
		foreach($activity_result3 as $age3){}
		$this->view->age3=$age3['accountcount'];
	
		$this->view->from4=$from_age=46;
		$this->view->to4=$to_age=60;
		$activity_result4=$activity_ratio->getactivity_between($from_age,$to_age,$activityid,$gender);
		foreach($activity_result4 as $age4){}
		$this->view->age4=$age4['accountcount'];	
		$this->view->age=$age=61;
		$activity_result5=$activity_ratio->getactivity_above($age,$activityid,$gender);
		foreach($activity_result5 as $age5){}
		$this->view->age5=$age5['accountcount'];
	}
	//pdf report display action
	function reportdisplayAction() {
		$app = $this->view->baseUrl();
		$word=explode('/',$app);
		$projname='';
		for($i=0; $i<count($word); $i++){
			if($i>0 && $i<(count($word)-1)) { $projname.='/'.$word[$i]; }
		}
		//disable layout
		$this->_helper->layout->disableLayout();
		$file1 = $this->_request->getParam('file'); 
		$this->view->filename = $projname."/reports/".$file1;
	}

	//pdf creation
	function pdftransactionAction()
	{	
		$pdf = new Zend_Pdf();
		$page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
		$pdf->pages[] = $page;
		$baseURl=$this->view->baseUrl();
		$word=explode('/',$baseURl);
		$projname='';
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
		//language set
 		$text=array($this->view->translate("Gender and age wise number of accounts"),$this->view->translate("Age Limits"),$this->view->translate("Number of Account"));
		$x1 = 80; 
		$x2=150;
		$x3 = 200;
		$x4 = 380;
		$x6 = 450;
		$y1= 700;
		$page->drawLine(50, 740, 550, 740);
	        $page->drawLine(50, 720, 550, 720);

 		$page->drawText($text[0], $x3, 760);
         	$page->drawText($text[1], $x2, 725);
 		$page->drawText($text[2], $x4, 725);
		$activityid = $this->_request->getParam('activity');
        	$gender = $this->_request->getParam('gender');
		$activity_ratio=new Activityreport_Model_activityreport();
		$this->view->from1=$from_age=16;
		$this->view->to1=$to_age=25;
		$ageradio1="Age between ".$this->view->from1." - ".$this->view->to1;
		$activity_result1=$activity_ratio->getactivity_between($from_age,$to_age,$activityid,$gender);
		foreach($activity_result1 as $age1){}
		$this->view->age1=$age1['accountcount'];
		$page->drawText($age1['accountcount'], $x4, $y1);
		$page->drawText($ageradio1, $x2, $y1);
		$y1 -= 15;
		$this->view->from2=$from_age=26;
		$this->view->to2=$to_age=35;
		$ageradio2="Age between ".$this->view->from2." - ".$this->view->to2;
		$activity_result2=$activity_ratio->getactivity_between($from_age,$to_age,$activityid,$gender);
		foreach($activity_result2 as $age2){}
		$this->view->age2=$age2['accountcount'];
		$page->drawText($age2['accountcount'], $x4, $y1);
		$page->drawText($ageradio2, $x2, $y1);
		$y1 -= 15;
		$this->view->from3=$from_age=36;
		$this->view->to3=$to_age=45;
		$ageradio3="Age between ".$this->view->from3." - ".$this->view->to3;
		$activity_result3=$activity_ratio->getactivity_between($from_age,$to_age,$activityid,$gender);
		foreach($activity_result3 as $age3){}
		$this->view->age3=$age3['accountcount'];
		$page->drawText($age3['accountcount'], $x4, $y1);
		$page->drawText($ageradio3, $x2, $y1);
		$y1 -= 15;
		$this->view->from4=$from_age=46;
		$this->view->to4=$to_age=60;
		$ageradio4="Age between ".$this->view->from4." - ".$this->view->to4;
		$activity_result4=$activity_ratio->getactivity_between($from_age,$to_age,$activityid,$gender);
		foreach($activity_result4 as $age4){}
		$this->view->age4=$age4['accountcount'];
		$page->drawText($age4['accountcount'], $x4, $y1);
		$page->drawText($ageradio4, $x2, $y1);
		$y1 -= 15;	
		$this->view->age=$age=61;
		$ageradio5="Age above ".$this->view->age;
		$activity_result5=$activity_ratio->getactivity_above($age,$activityid,$gender);
		foreach($activity_result5 as $age5){}
		$this->view->age5=$age5['accountcount'];
		$page->drawText($age5['accountcount'], $x4, $y1);
		$page->drawText($ageradio5, $x2, $y1);
		$y1 -= 15;
		$page->drawLine(50, $y1, 550, $y1);
		$pdfData = $pdf->render();	
		//save path
		$pdf->save('/var/www/'.$projname.'/reports/activity.pdf');
		$path = '/var/www/'.$projname.'/reports/activity.pdf';
		chmod($path,0777);
		//redirect path
		$this->_redirect('/activityreport/index/reportdisplay/file/activity.pdf');	
	}
}
