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
class settings_DropdownController extends Zend_Controller_Action 
{
    public function init() 
    {
        $this->view->pageTitle='Drop Down Settings';
    }

    public function indexAction() 
    {
        $addform=new settings_Form_Dropdown();
        $this->view->form=$addform;
// 	$this->view->title = "Drop Down";
// 	$tableName = $this->_request->getParam('tableName');
//         $this->view->form->table_name->setValue($tableName);
// 	//echo $tableName;
// 	if(isset($tableName)) 
//         {
// 	   $this->view->table = 10;
// 	   switch($tableName) 
//             {
// 	       case "ourbank_gender" :
// 	       $setting = new settings_Model_Dropdown();
// 	       $arrayTable = $setting->tableContent($tableName);
// 	       $this->view->tblcontent = $arrayTable;
// 	       foreach($this->view->tblcontent as $ledger) 
//                 {
// 	       $this->view->tableName = "ourbank_gender";
// 	       $this->view->sex=$ledger->sex; 
// 	       }
// 	       break;
// 
// 	       case "ourbank_membermaritalstatus" : 
// 	       $setting = new settings_Model_Dropdown();
// 	       $arrayTable = $setting->tableContent($tableName);
// 	       $this->view->tblcontent = $arrayTable;
// 	       foreach($this->view->tblcontent as $ledger) 
//                 {
// 	       $this->view->tableName = "ourbank_membermaritalstatus";
// 	       $this->view->membermaritalstatusdescription=$ledger->membermaritalstatusdescription;
// 	       }
// 	       break;
// 
// 	       case "ourbank_membertypes" : 
// 	       $setting = new settings_Model_Dropdown();
// 	       $arrayTable = $setting->tableContent($tableName);
// 	       $this->view->tblcontent = $arrayTable;
// 	       foreach($this->view->tblcontent as $ledger) 
//                 {
// 	       $this->view->tableName = "ourbank_membertypes";
// 	       $this->view->membertype=$ledger->membertype;
// 	       }
// 	       break;
// 
// 	       case "ourbank_currency" : 
// 	       $setting = new settings_Model_Dropdown();
// 	       $arrayTable = $setting->tableContent($tableName);
// 	       $this->view->tblcontent = $arrayTable;
// 	       foreach($this->view->tblcontent as $ledger) 
//                 {
// 	       $this->view->tableName = "ourbank_currency";
// 	       $this->view->currencyname=$ledger->currencyname;
// 	       }
// 	       break;
// 
// 	       case "ourbank_feefrequency" : 
// 	       $setting = new settings_Model_Dropdown();
// 	       $arrayTable = $setting->tableContent($tableName);
// 	       $this->view->tblcontent = $arrayTable;
// 	       foreach($this->view->tblcontent as $ledger) 
//                 {
// 	       $this->view->tableName = "ourbank_feefrequency";
// 	       $this->view->feefrequencytype =$ledger->feefrequencytype;
// 	       }
// 	       break;
// 
//         	case "ourbank_frequencyofpayment" : 
// 	       $setting = new settings_Model_Dropdown();
// 	       $arrayTable = $setting->tableContent($tableName);
// 	       $this->view->tblcontent = $arrayTable;
// 	       foreach($this->view->tblcontent as $ledger)     
//                 {
// 	       $this->view->tableName = "ourbank_frequencyofpayment";
// 	       $this->view->timefrequencytype =$ledger->timefrequencytype;
// 	       }
// 	       break;
// 
// 	       case "ourbank_interesttypes" : 
// 	       $setting = new settings_Model_Dropdown();
// 	       $arrayTable = $setting->tableContent($tableName);
// 	       $this->view->tblcontent = $arrayTable;
// 	       foreach($this->view->tblcontent as $ledger) 
//                 {  
// 	       $this->view->tableName = "ourbank_interesttypes";
// 	       $this->view->description =$ledger->description;
// 	       }
// 	       break;
// 
// 	       case "ourbank_graceperiods" :  
// 	       $setting = new settings_Model_Dropdown();
// 	       $arrayTable = $setting->tableContent($tableName);
// 	       $this->view->tblcontent = $arrayTable;
// 	       foreach($this->view->tblcontent as $ledger) 
//                 {
// 	       $this->view->tableName = "ourbank_graceperiods";
// 	       $this->view->graceperiodtype =$ledger->graceperiodtype;
// 	       }
// 	       break;
// 
// 	       case "ourbank_holidayrepayment" : 
// 	       $setting = new settings_Model_Dropdown();
// 	       $arrayTable = $setting->tableContent($tableName);
// 	       $this->view->tblcontent = $arrayTable;
// 	       foreach($this->view->tblcontent as $ledger) 
//                 {
// 	       $this->view->tableName = "ourbank_holidayrepayment";
// 	       $this->view->repaymentdescription =$ledger->repaymentdescription;
// 	       }
// 	       break;
// 
// 	       case "ourbank_paymenttypes" : 
// 	       $setting = new settings_Model_Dropdown();
// 	       $arrayTable = $setting->tableContent($tableName);
// 	       $this->view->tblcontent = $arrayTable;
// 	       foreach($this->view->tblcontent as $ledger) 
//                 {
// 	       $this->view->tableName = "ourbank_paymenttypes";
// 	       $this->view->repaymentdescription =$ledger->paymenttype_description;
// 	       }
// 	       break;
// 
// 	       case "ourbank_transaction_type" : 
// 	       $setting = new settings_Model_Dropdown();
// 	       $arrayTable = $setting->tableContent($tableName);
// 	       $this->view->tblcontent = $arrayTable;
// 	       foreach($this->view->tblcontent as $ledger) 
//                 {
// 	       $this->view->tableName = "ourbank_transaction_type";
// 	       $this->view->transaction_type =$ledger->transaction_type;
// 	       }
// 	       break;	
//             }
//         }
//        
//         if($this->_request->isPost() && $this->_request->getPost('Add'))
//         {
//                 $formdata=$this->_request->getPost();
//                 if($addform->isValid($formdata))
//                 {
//                 $tName=$this->_request->getParam('table_name');
//                 $tInsert=$this->_request->getParam('textvalue');
//                 $pK=$this->_request->getParam('pK');
//                 $attribute=$this->_request->getParam('attribute');
//                 $setting=new settings_Model_Dropdown();
//                 $arrayTable=$setting->insertContent($tName,array($pK=>'',$attribute=>$tInsert));
//                 echo "<font color='red'>This value is successfully added</font>";
//                 }
//         
//         } 
    }
}
