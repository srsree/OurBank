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
To create the Ledger Details
*/

class Ledger_IndexController extends Zend_Controller_Action 
{
    public function init()
    {
        $this->view->pageTitle='Ledger';
        $this->view->mainModule='Management';
        $this->view->adm = new App_Model_Adm();
        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();
        $this->view->username = $this->view->globalvalue[0]['username'];
        $this->view->created_by = $this->view->globalvalue[0]['id'];
        $date=date("y/m/d H:i:s");

        $ledger = new Ledger_Model_Ledger();
        $ledger1 = $ledger->fetchAllLedger1();
        $flag = 0;
        foreach($ledger1 as $ledger2) { if((($ledger2->id) == 1) OR (($ledger2->id) == 2)) $flag = 1;}
        if($flag == 0) {
            $glInsert = $ledger->insertGlcode(array('id' => '',
                        'glcode' => 'A01000', 'ledgertype_id' => 3,
                        'header' => 'Bank', 'description' => 'Bank in assets',
                        'created_date' =>$date, 'created_by'=>1));
            $glInsert = $ledger->insertGlcode(array('id' => '',
                        'glcode' => 'A02000', 'ledgertype_id' => 3,
                        'header' => 'Cash','description' => 'Cash in assets',
                        'created_date' =>$date,'created_by'=>1));
        }
    }

    public function indexAction()
    {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
                $this->_redirect('index/login');
        }

        $this->view->title = "Ledger";
        $this->view->searchLink=1;
        $ledger = new Ledger_Model_Ledger();
        $ledgerselect = $ledger->fetchAllLedger1();
        $this->view->ledger = $ledger->fetchAllLedger1(); //fetch all glcode details

        $subledger = new Ledger_Model_Ledger();
        $subledgerselect = $subledger->fetchAllSubLedger();

        $this->view->subledger = $subledger->fetchAllSubLedger(); //fetch all glsubcode details

        $paginator = Zend_Paginator::factory($this->view->ledger);
        $paginator->setCurrentPageNumber($this->_getParam("page"));
        $paginator->setItemCountPerPage(5);
        $paginator->setPageRange(6);
        $this->view->page=$this->_request->getParam('page');
        $this->view->paginator = $paginator;

        $form = new Management_Form_Search();
        $this->view->form1 = $form;
        if ($this->_request->isPost() && $this->_request->getPost('Search')) {	
            $glcode = $this->_request->getParam('field6'); 
            $glsubcode = $this->_request->getParam('field2');
            $accountHeader = $this->_request->getParam('field3');
            $subheader = $this->_request->getParam('field4');
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $first = new Ledger_Model_Ledger();
                $arrayledger = $first->ledgerSearch($glcode,$accountHeader);
                $arraysubledger = $first->subledgerSearch($glsubcode,$subheader);
                $this->view->subledger = $arraysubledger;

                $this->view->ledger1 = $arrayledger;
                $paginator = Zend_Paginator::factory($this->view->ledger1);
                $paginator->setCurrentPageNumber($this->_getParam("page")); 
                $paginator->setItemCountPerPage(5);
                $paginator->setPageRange(6);
                $this->view->paginator = $paginator;
            }
        }
    }

    public function addledgerAction()
    {
        $this->view->title = "New Ledger";
        $path = $this->view->baseUrl();

    // 	$loginDetails = Zend_Auth::getInstance()->getIdentity();
    // 	$this->view->username = $loginDetails->login_name;
    // 	$userId=$loginDetails->user_id;

        $form = new Ledger_Form_Ledger($path);
        $this->view->form = $form;

        $ledger = new Ledger_Model_Ledger();
        $ledgerselect = $ledger->fetchAllLedger();
        $this->view->ledger = $ledgerselect;

        $ledger = new Ledger_Model_Ledger();
        $categoryDetails = $ledger->getLedgerTypes();
        foreach($categoryDetails as $cName) {
        $form->product->addMultiOption($cName->id,$cName->description);
        }

        $products = $ledger->getproducts();
        foreach($products as $productsDetails) {
        $form->offerproduct->addMultiOption($productsDetails->id,$productsDetails->name);
        }

        if ($this->_request->isPost() && $this->_request->getPost('Submit')) {
            $formData = $this->_request->getPost();
            if ($this->_request->isPost()) {
                $formData = $this->_request->getPost();
                if ($form->isValid($formData)) {
                    $ledger = new Ledger_Model_Ledger();
                    $glcodeDescription = $this->_request->getParam('glcodeDescription');
                    $accountHeader = $this->_request->getParam('accountHeader');
                    $productname = $this->_request->getParam('product');
    
                    $genarateGl = $ledger->genarateGlCode($productname);
                    $glCode=$genarateGl->id;
    
                    $date=date("y/m/d H:i:s");
    
                    $ledger = new Ledger_Model_Ledger();
                    $result = $ledger->getLdegertype($productname);
                    foreach($result as $result1) {
                    $headerCon = substr($result1->description, 0, 1);
                    }
                    if ($glCode) {
                        $fetchGlcode=$ledger->fetchGlcode($glCode);//fetch glcode for id
                        $glCode=substr($fetchGlcode->glcode, 1, 2);
                        $glcodeId=str_pad($headerCon.(str_pad(($glCode + 1),2,0,STR_PAD_LEFT)),(8 - strlen($glCode) ),"0"); 
                        $glcode = $glcodeId;
                    } else {
                        $glcodeId=str_pad($headerCon."01",6,"0");
                        $glcode = $glcodeId;
                    }
                        $gInsert = $ledger->insertGlcode(
                                array('id' => '',
                                        'glcode' => $glcode,
                                        'ledgertype_id' => $productname,
                                        'header' => $accountHeader,
                                        'description' => $glcodeDescription,
                                        'created_date' =>$date,
                                        'created_by'=>1));
                    $this->_redirect('ledger/index');
                }
            }
        }
    }
    
    public function addsubledgerAction()
    {
        $path = $this->view->baseUrl();

        $date=date("y/m/d H:i:s");

        if ($this->_request->isPost() && $this->_request->getPost('submit')) {
            $glcode_id = $this->_request->getParam('glcode_id');echo "<br>";
            $subheader = $this->_request->getParam('subheader');echo "<br>";
            $glsubaccountdescription = $this->_request->getParam('glsubaccountdescription');echo "<br>";
            $productname = $this->_request->getParam('offerproduct');echo "<br>";

            $fetchglcodedetails=$this->view->adm->editRecord('ourbank_glcode',$glcode_id);
            $ledgertype_id = $fetchglcodedetails[0]['ledgertype_id'];
            $glcode = $fetchglcodedetails[0]['glcode'];
            $header = $fetchglcodedetails[0]['header'];

            $ledger = new Ledger_Model_Ledger();
            $genarateGlsub = $ledger->genarateGlsubCode1($glcode_id,$ledgertype_id);
            $glsubcode=$genarateGlsub->id;

            if($glsubcode) {
                $ini=substr($glsubcode,0,1);
                $last=substr($glsubcode,1,5);
                $last+=1;
                $last = str_pad($last,5,0,STR_PAD_LEFT);
                $glsubcode=$ini.$last;
                $glsubcode;
            } else {
                $glcode1=$ledger->fetchGlcode($glcode_id);
                $glcode=$glcode1->glcode;
                $ini=substr($glcode,0,1);
                $last=substr($glcode,1,5);
                $last+=1;
                $last = str_pad($last,5,0,STR_PAD_LEFT);
                $glsubcode=$ini.$last;
                $glsubcode;
            }
            $gInsert = $ledger->insertGlsubcode(array('id' => '',
                            'glsubcode' => $glsubcode,
                            'glcode_id' => $glcode_id,
                            'subledger_id' => $ledgertype_id,
                            'header' => $subheader,
                            'description' => $glsubaccountdescription,
                            'created_date' =>$date,
                            'created_by'=>1));
            $this->_redirect('ledger/index');
        }
    }
    
    public function viewledgerAction()
    {
        $this->view->title = "View Ledger";
        $this->view->id=$ledgerID=$this->_request->getParam('id');
        $ledger = new Ledger_Model_Ledger();
        $ledgerselect = $ledger->viewLedger($ledgerID);
        $this->view->ledger = $ledgerselect;
        foreach ($this->view->ledger as $ledger1) {
            $ledgerID = $ledger1->id;
            $this->view->header=$ledger1->header;
            $this->view->glcode=$ledger1->glcode;
            $this->view->description=$ledger1->description;
            $this->view->login_name=$ledger1->name;
            $this->view->created_date=$ledger1->created_date;
        }
    }
    
    public function viewsubledgerAction()
    {
        $this->view->title = "View Sub Ledger";
        $this->view->id = $subLedgerID = $this->_request->getParam('id');
        $ledger = new Ledger_Model_Ledger();
        $ledgerselect = $ledger->viewSubLedger($subLedgerID);
        $this->view->subledger = $ledgerselect;
        foreach ($this->view->subledger as $ledger1) {
            $this->view->glcode=$ledger1->glcode;
            $this->view->glsubcode=$ledger1->glsubcode;
            $this->view->subheader=$ledger1->header;
            $this->view->glsubaccountdescription=$ledger1->description;
            $this->view->login_name=$ledger1->name;
            $this->view->created_date=$ledger1->created_date;
        }
    }

    public function editledgerAction()
    {
    // 	$auth = Zend_Auth::getInstance();
    //         if (!$auth->hasIdentity()) {
    //             $this->_redirect('../../../index/login');
    //         }
    // 		$loginDetails = Zend_Auth::getInstance()->getIdentity();
    // 		$this->view->username = $loginDetails->login_name;
        $path = $this->view->baseUrl();
        $this->view->title = "Edit ledger";
        $form = new Ledger_Form_Ledger($path);
        $this->view->form1 = $form;

        if ($this->_request->getParam('id')) {
                $this->view->id = $glcodeId =$this->_request->getParam('id');
                $this->view->form1->hidden_glcodeid->setValue($glcodeId);
        }
        if ($this->_request->getParam('hidden_glcodeid')) {
            $this->view->id = $glcodeId =$this->_request->getParam('hidden_glcodeid');
            $this->view->form1->hidden_glcodeid->setValue($glcodeId);
        }

        $ledger = new Ledger_Model_Ledger();
        $ledgerselect=$this->view->adm->editRecord('ourbank_glcode',$glcodeId);

        foreach($ledgerselect as $ledgerassign) {
            $this->view->glcode = $ledgerassign['glcode'];
            $this->view->form1->accountHeader->setValue($ledgerassign['header']);
            $this->view->form1->glcodeDescription->setValue($ledgerassign['description']);
        }

        if ($this->_request->isPost() && $this->_request->getPost('Update')) {
            $id =$this->_request->getParam('hidden_glcodeid');
            $array=array('header'=>$this->_request->getParam('accountHeader'),
                            'description'=>$this->_request->getParam('glcodeDescription'));
            $gldetails=$this->view->adm->editRecord('ourbank_glcode',$id);
            $this->view->adm->addRecord('ourbank_glcode_log',$gldetails[0]);
            $this->view->adm->updateRecord('ourbank_glcode',$id,$array);
            $this->_redirect("ledger/index");
        }
        $this->view->form1->Submit->setName('Update');	
    }

    public function editsubledgerAction()
    {
        $path = $this->view->baseUrl();
        $this->view->title = "Edit Sub ledger";
        $form = new Ledger_Form_Ledger($path);
        $this->view->form1 = $form;
        if ($this->_request->getParam('id')) {
             $this->view->id = $glsubcodeId =$this->_request->getParam('id');
            $this->view->form1->hidden_glsubcodeid->setValue($glsubcodeId);
        }
        if ($this->_request->getParam('hidden_glsubcodeid')) {
             $this->view->id = $glsubcodeId =$this->_request->getParam('hidden_glsubcodeid');
            $this->view->form1->hidden_glsubcodeid->setValue($glsubcodeId);
        }
        $ledger = new Ledger_Model_Ledger();
        $subledgerselect=$ledger->viewSubLedger($glsubcodeId);
        foreach($subledgerselect as $subledgerassign) {
            $this->view->glcode = $subledgerassign->glcode;
            $this->view->glsubcode = $subledgerassign->glsubcode;
            $this->view->form1->subheader->setValue($subledgerassign->header);
            $this->view->form1->glsubaccountdescription->setValue($subledgerassign->description);
        }
        if ($this->_request->isPost() && $this->_request->getPost('Update')) {
            $id =$this->_request->getParam('hidden_glsubcodeid');
            $array=array('header'=>$this->_request->getParam('subheader'),
                        'description'=>$this->_request->getParam('glsubaccountdescription'));
            $glsubdetails=$this->view->adm->editRecord('ourbank_glsubcode',$id);
            $glsubdetails[0]['id']='';
            $this->view->adm->addRecord('ourbank_glsubcode_log',$glsubdetails[0]);
            $this->view->adm->updateRecord('ourbank_glsubcode',$id,$array);
            $this->_redirect("ledger/index");
        }
        $this->view->form1->Submit->setName('Update');	
    }

    public function deleteledgerAction()
    {
        $this->view->id=$ledgerID=$this->_request->getParam('id');
        $ledger = new Ledger_Model_Ledger();
        $ledgerselect = $ledger->viewLedger($ledgerID);
        $this->view->ledger = $ledgerselect;
        foreach ($ledgerselect as $ledger1) {
            $ledgerID = $ledger1->id;
            $this->view->header=$ledger1->header;
            $this->view->glcode=$ledger1->glcode;
            $this->view->description=$ledger1->description;
            $this->view->login_name=$ledger1->name;
            $this->view->created_date=$ledger1->created_date;
        }

        $form = new Management_Form_Delete();
        $this->view->form = $form;
        $id= $this->view->id = $this->_request->getParam('id');
        if ($this->_request->isPost() && $this->_request->getPost('Delete')) 
        {
            $formData=$this->_request->isPost();
            if ($this->_request->getParam('remarks'))
            {
                $gldetails=$this->view->adm->editRecord('ourbank_glcode',$id);
                $this->view->adm->addRecord('ourbank_glcode_log',$gldetails[0]);
                $this->view->adm->deleteRecord('ourbank_glcode',$id);
                $this->_redirect("ledger/index");
            } else {
                $this->view->errormsg="Value required";
            }
        }
    }

    public function deletesubledgerAction()
    {
        $this->view->id = $subLedgerID = $this->_request->getParam('id');
        $ledger = new Ledger_Model_Ledger();
        $ledgerselect = $ledger->viewSubLedger($subLedgerID);
        $this->view->subledger = $ledgerselect;
        foreach ($this->view->subledger as $ledger1) {
            $this->view->glcode=$ledger1->glcode;
            $this->view->glsubcode=$ledger1->glsubcode;
            $this->view->subheader=$ledger1->header;
            $this->view->glsubaccountdescription=$ledger1->description;
            $this->view->login_name=$ledger1->name;
            $this->view->created_date=$ledger1->created_date;
        }
        $form = new Management_Form_Delete();
        $this->view->form = $form;
        $id= $this->view->id = $this->_request->getParam('id');
        if ($this->_request->isPost() && $this->_request->getPost('Delete')) 
        {
            $formData=$this->_request->isPost();
            if ($this->_request->getParam('remarks')) 
            {
                $glsubdetails=$this->view->adm->editRecord('ourbank_glsubcode',$id);
                $this->view->adm->addRecord('ourbank_glsubcode_log',$glsubdetails[0]);
                $this->view->adm->deleteRecord('ourbank_glsubcode',$id);
                $this->_redirect("ledger/index");
            } else {
                $this->view->errormsg="Value required";
            }
        }
    }

    public function getsubproduct1Action() 
    {
        $this->_helper->layout->disableLayout();
        $product_id = $this->_request->getParam('product_id');
        $ledger = new Ledger_Model_Ledger();
        $product = $ledger->getLdegertype($product_id); 
        foreach($product as $product) 
        {
            $this->view->ledgername = $product->description;
        }
    }

    public function getsubledgerAction()
    {
        $this->_helper->layout->disableLayout();
        $glcode_id = $this->_request->getParam('glcode_id');
        $ledger = new Ledger_Model_Ledger();
        $this->view->product = $ledger->subLedger($glcode_id); 
    }

    public function getglcodeAction()
    {
        $this->_helper->layout->disableLayout();
        $ledger_id = $this->_request->getParam('ledger_id');
        $ledger = new Ledger_Model_Ledger();
        $this->view->gldetails = $ledger->fetchGlcodeforledgerid($ledger_id); 
    }
}
