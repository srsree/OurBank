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
 *  create an Attendance controller for view, search 
 */
class Attendancereport_IndexController extends Zend_Controller_Action
{
	function init() { 
		$this->view->pageTitle = $this->view->translate("Attendance Report");
		$this->view->title = $this->view->translate("Attendance Report");
		$this->view->type=$this->view->translate("others");
		//session
		$sessionName = new Zend_Session_Namespace('ourbank');
		$userid=$this->view->createdby = $sessionName->primaryuserid;
		$login=new App_Model_Users();
		$loginname=$login->username($userid);
		foreach($loginname as $loginname) {
			$this->view->username=$loginname['username'];
		}
	
	}
	//view action
	function indexAction() {
		$path = $this->view->baseUrl();
		$searchForm = new Attendancereport_Form_Search($path);
		$this->view->form = $searchForm;

		$fetchBanknames = new Attendancereport_Model_Attendancereport();
		$this->view->bank_name=$office = $fetchBanknames->getOffice();
		foreach($office as $office) {
			$searchForm->field1->addMultiOption($office['id'],$office['name']); 		
		}

			$fetchMeetings=new Attendancereport_Model_Attendancereport();
			$this->view->result=$result=$fetchMeetings->getMeetingsall(); 

			$fetchMembers=$fetchMeetings->fetchMembers();

			$this->view->member_name=$fetchMembers;
				$fetchAllMembers=$fetchMeetings->fetchGroupMembers();

				$this->view->all_member_name=$fetchAllMembers;


		//search
		if ($this->_request->getParam('Search')) {
			$formData = $this->_request->getPost();
			$this->view->institute_bank_id=$institute_bank_id = $this->_request->getParam('field1'); 
			$this->view->group_id=$group_id = $this->_request->getParam('field2');

			
			if ($searchForm->isValid($formData)) {
				$this->view->check=10;
				$fetchMeetings=new Attendancereport_Model_Attendancereport();
				$this->view->result=$result=$fetchMeetings->getMeetings($formData);

				$fetchMembers=$fetchMeetings->fetchMembers();
				$this->view->member_name=$fetchMembers;

				$fetchAllMembers=$fetchMeetings->fetchGroupMembers();
				$this->view->all_member_name=$fetchAllMembers;
			}
		}
	}

/*	function pdfgenerationAction() {
		$pdf = new Zend_Pdf();
		$page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
// 		 $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4_LANDSCAPE);
		$pdf->pages[] = $page;
		// Image
		$app = $this->view->baseUrl();
		$word=explode('/',$app);
		$projname = $word[1];

		$image_name = "/var/www/".$projname."/public/images/logo.jpg";
		$image = Zend_Pdf_Image::imageWithPath($image_name);
		//$page->drawImage($image, 25, 770, 570, 820);
	
		$page->drawImage($image, 30, 770, 130, 820);
		$page->setLineWidth(1)->drawLine(25, 25, 570, 25); //bottom horizontal
		$page->setLineWidth(1)->drawLine(25, 25, 25, 820); //left vertical
		$page->setLineWidth(1)->drawLine(570, 25, 570, 820); //right vertical
		$page->setLineWidth(1)->drawLine(570, 820, 25, 820); //top horizontal
		//set the font
		$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 12);
	
		$text = array("Meeting Meeting Held","Bank Name","Group Name","Meeting Name","Date","Time","Place","Absentees");

		$fetchMeetings=new Attendancereport_Model_Attendancereport();
		$meetingDetails=$this->view->result=$result=$fetchMeetings->getMeetingsall(); 
		$this->view->member_name=$fetchMembers=$fetchMeetings->fetchMembers();

		$y1 = 740;
		$xx=50; $xy=550;

		$x =array(55,150,250,340,405,460,520);
		$page->drawLine($xx,$y1,$xy,$y1); $y1-=15;//first line
			$page->drawText($text[1], $x[0]+5, $y1);//Header
			$page->drawText($text[2], $x[1], $y1);
			$page->drawText($text[3], $x[2], $y1);
			$page->drawText($text[4], $x[3], $y1);
			$page->drawText($text[5], $x[4], $y1);
			$page->drawText($text[6], $x[5], $y1);
			$page->drawText($text[7], $x[6], $y1);
			
			$y1-=10;
	        $page->drawLine($xx,$y1,$xy,$y1); $y1-=15;//second line

		foreach($meetingDetails as $meetingDetails1){
			$st=16;
			$text = " ".$meetingDetails1['name'];
				$newtext = wordwrap($text, 15, "<br />\n");
				$pieces = explode("<br />", $newtext);

				$ommittedspace=0;
				foreach($pieces as $pieces0) {
					if($pieces0!="") {
						$page->drawText(substr($pieces0,0,$st),$x[0], $y1);
						$y1-=15;  $ommittedspace+=15;
					}
				} $y1+=$ommittedspace;

// 				$page->drawText($meetingDetails1['Institute_bank_name'], $x[0], $y1);

			$st1=30;
			$text1 = $meetingDetails1['name'];
				$newtext1 = wordwrap($text1, 23, "<br />\n");
				$pieces1 = explode("<br />", $newtext1);

				$ommittedspace1=0;
				foreach($pieces1 as $pieces2) {
					if($pieces2!="") {
						$page->drawText(substr($pieces2,0,$st1),$x[1], $y1);
						$y1-=15;  $ommittedspace1+=15;
					}
				} $y1+=$ommittedspace1;

				$page->drawText($meetingDetails1['name'], $x[2], $y1);
				$page->drawText($meetingDetails1['date'], $x[3], $y1);
				$page->drawText($meetingDetails1['time'], $x[4], $y1);
				$page->drawText($meetingDetails1['place'], $x[5], $y1);
				$y1-=15;
				$space=max($ommittedspace,$ommittedspace1);$y1-=$space;
		}

		$pdfData = $pdf->render();
		$pdf->save('/var/www/'.$projname.'/reports/attendance'.date('Y-m-d').'.pdf');
		$path = '/var/www/'.$projname.'/reports/attendance'.date('Y-m-d').'.pdf';
		chmod($path,0777);
	}
*/
	public function fetchgroupsAction() {
		$this->_helper->layout->disableLayout();

		$path = $this->view->baseUrl();
		
		$meetingreportForm = new Attendancereport_Form_Search($path);
		$this->view->meetingreportForm = $meetingreportForm;
		
		$bank_id=$this->_request->getParam('bank_id');
		$meeting = new Attendancereport_Model_Attendancereport();
		$office=$meeting->fetchGroupnames($bank_id);

		//groupname drop down
		foreach($office as $office) {
			$meetingreportForm->field2->addMultiOption($office['id'],$office['name']);
		}
	}

	
//
	public function fetchmeetingsAction() {
		$this->_helper->layout->disableLayout();
		$path = $this->view->baseUrl();

		$meetingreportForm = new Attendancereport_Form_Search($path);
		$this->view->meetingreportForm = $meetingreportForm;
		
		$group_id=$this->_request->getParam('group_id');
		$meeting = new Meeting_Model_Meeting();
		$meetingName=$meeting->getMeetingForGroupId($group_id);
		//meeting dropdown
		foreach($meetingName as $meetingName) {
			$meetingreportForm->field5->addMultiOption($meetingName['id'],$meetingName['name']);
		}
	}

	function viewtransactionAction() {
		
	}

	function reportdisplayAction() {
		$this->_helper->layout->disableLayout();
		$file1 = $this->_request->getParam('file');
		
		$app = $this->view->baseUrl();
		$word=explode('/',$app);
		$projname = $word[1];

                $this->view->filename = "/".$projname."/reports/".$file1;
	}

	function reportviewAction() {
	}

	
}
