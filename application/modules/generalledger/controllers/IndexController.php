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
class Generalledger_IndexController extends Zend_Controller_Action
{
    function init()
    { 
        $this->view->pageTitle = "General Ledger";
        $this->view->title = "Reports";
        $this->view->type = "others";
        $this->view->adm = new App_Model_Adm();
	$this->view->dateconvertor = new App_Model_dateConvertor();
    }
    
    function indexAction()
    { 
        $this->view->pageTitle = "General Ledger";
        $searchForm = new Generalledger_Form_Search();
        $this->view->form = $searchForm;
        $products = $this->view->adm->viewRecord('ourbank_product','id','asc');

        foreach($products as $products) {
            $searchForm->prodname->addMultiOption($products['id'],$products['name']);
        }
        $subLedger = $this->view->adm->viewRecord('ourbank_glsubcode','id','asc');

        foreach($subLedger as $subLedger) {
            $searchForm->glcode->addMultiOption($subLedger['id'],$subLedger['glsubcode']." - ".$subLedger['header']);
        }
         
        if ($this->_request->isPost() && $this->_request->getPost('Search')) {
 
        $formData = $this->_request->getPost();
        if ($searchForm->isValid($formData)) {
	$fromDate = $this->view->dateconvertor->mysqlformat($this->_request->getParam('datefrom'));
	$toDate = $this->view->dateconvertor->mysqlformat($this->_request->getParam('dateto'));
	$glsubcode =$this->_request->getParam('glcode');

            $this->view->search = 10;             
            $generalLedger = new Generalledger_Model_Generalledger();
             
             //Lia
            $this->view->ledegerList = $generalLedger->generalLedger($fromDate,$toDate,$glsubcode);

            $this->view->openingCash = $generalLedger->openingBalance($fromDate,$glsubcode);
             
//             // Assets
            $this->view->ledegerListAssets = $generalLedger->generalLedgerAssets($fromDate,$toDate,$glsubcode);
            $this->view->openingCashAssets = $generalLedger->openingBalanceAssets($fromDate,$glsubcode);
            if((!$this->view->ledegerListAssets) && (!$this->view->openingCashAssets)){
                                echo "<font color='red'><b> Record not found</b> </font>";
                }
        } else {
            $this->view->search = 0;

        }
			
        }
    }
    public function reportdisplayAction() 
    {
        $this->_helper->layout->disableLayout();
        $file1 = $this->_request->getParam('file'); 
        $app = $this->view->baseUrl();
        $word=explode('/',$app);
        $projname = $word[1];
        $this->view->filename = "/".$projname."/reports/".$file1;    
    
    }
    public function pdfdisplayAction() 
    { 
        $fromDate = $this->_request->getParam('field2'); 
        $toDate = $this->_request->getParam('field2');
        $product = $this->_request->getParam('field3');

        $pdf = new Zend_Pdf();
        $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $page;

        $app = $this->view->baseUrl();
        $word=explode('/',$app);
        $projname = $word[1];
        //Image
        $image_name = "/var/www/".$projname."/public/images/logo.jpg";
        $image = Zend_Pdf_Image::imageWithPath($image_name);
        //$page->drawImage($image, 25, 770, 570, 820);
        $page->drawImage($image, 30, 770, 130, 820);
        $page->setLineWidth(1)->drawLine(25, 25, 570, 25); //bottom horizontal
        $page->setLineWidth(1)->drawLine(25, 25, 25, 820); //left vertical
        $page->setLineWidth(1)->drawLine(570, 25, 570, 820); //right vertical
        $page->setLineWidth(1)->drawLine(570, 820, 25, 820); //top horizontal
        //set the font
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 8);
    
        $text = array("Date",
                     "product name",
                     "credit",
                     "debit",
                     "balance");
        $x0 = 60; 
        $x1 = 120; 
        $x2 = 230; 
        $x3 = 350;
        $x4 = 460;
        $x5 = 360;

        $page->drawLine(50, 740, 550, 740);
        $page->drawLine(50, 720, 550, 720);
        $page->drawText($text[0], $x0, 725);

        $page->drawText($text[1], $x1, 725);
        $page->drawText($text[2], $x2, 725);
        $page->drawText($text[3], $x3, 725);
        $page->drawText($text[4], $x4, 725);


        $pdf->save('/var/www/'.$projname.'/reports/GL.pdf');
	$path = '/var/www/'.$projname.'/reports/GL.pdf';
       // $pdf->save('/var/www/ourbank/reports/GL.pdf');
       // $path = '/var/www/ourbank/reports/GL.pdf';
        chmod($path,0777);
}
}