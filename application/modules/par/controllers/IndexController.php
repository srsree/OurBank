<?php
class Par_IndexController extends Zend_Controller_Action 
{
 function init()
     { 
      	$this->view->pageTitle = "Portfolio at risk";
        $this->view->tilte = "Reports";
        $this->view->type='loans';
//         $this->view->type=$this->_request->getParam('type');
        $sessionName = new Zend_Session_Namespace('ourbank');
        $userid=$this->view->createdby = $sessionName->primaryuserid;
        $login=new App_Model_Users();
        $loginname=$login->username($userid);
        foreach($loginname as $loginname) {
          $this->view->username=$loginname['username'];
       }

     }
     function indexAction() {

        $par = new Par_Model_Par();
        $this->view->due30 = $par->getDue30();
        $this->view->getDueabove30less60 = $par->getDueabove30less60();
        $this->view->getDueabove60less90 = $par->getDueabove60less90();
        $this->view->getDueabove90less180 = $par->getDueabove90less180();
        $this->view->getDueabove180less360 = $par->getDueabove180less360();
        $this->view->getDueabove360 = $par->getDueabove360();
    }

    public function reportdisplayAction() 
    {
        $app = $this->view->baseUrl();
        $word=explode('/',$app);
        $projname = $word[1];

        $this->_helper->layout->disableLayout();
        $file1 = $this->_request->getParam('file'); 
        $this->view->filename = "/".$projname."/reports/".$file1;
    }


    public function pdftransactionAction() 
    { 

        $pdf = new Zend_Pdf();
        $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $page;
        //Path
        $app = $this->view->baseUrl();
        $word=explode('/',$app);
        $projname = $word[1];
        // Image
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
    
        $text = array("PAR: Portfolio at risk",
                    "Month",
                    "Loan A/C",
                    "On Time",
                    "1-30 Days",
                    "31-60 Days",
                    "61-90 Days",
                    "91-180 Days",
                    "181-360 Days",
                    "361 Days above",
                    "O/S Loan",
                    "Total");
        $this->view->savings = 10;
        $page->drawText("Date : ".date('d-m-Y'),500, 800); //date('Y-m-d')
        $page->drawText("Date : ".date('d-m-Y'),500, 800); 
        $page->drawText($text[0],240, 780);$page->drawText($text[0],240, 780);

        $x1 = 35; 
        $x2 = 60; 
        $x3 = 130;
        $x4 = 170;
        $x5 = 220;
        $x6 = 270;
        $x7 = 350;
        $x8 = 410;
        $x9 = 460;
        $x10 = 520;
    
        $page->drawLine(30, 740, 565, 740);
        $page->drawLine(30, 720, 565, 720);

        $page->drawText($text[1], $x1, 725);
        $page->drawText($text[2], $x2, 725);
        $page->drawText($text[3], $x3, 725);
        $page->drawText($text[4], $x4, 725);
        $page->drawText($text[5], $x5, 725);
        $page->drawText($text[6], $x6, 725);
        $page->drawText($text[7], $x7, 725);
        $page->drawText($text[8], $x8, 725);
        $page->drawText($text[9], $x9, 725);
        $page->drawText($text[10],$x10, 725);
    
        $y1 = 710;
        $y2 = 710;



        $par = new Par_Model_Par();
        $this->view->due30 = $par->getDue30();
        $this->view->getDueabove30less60 = $par->getDueabove30less60();
        $this->view->getDueabove60less90 = $par->getDueabove60less90();
        $this->view->getDueabove90less180 = $par->getDueabove90less180();
        $this->view->getDueabove180less360 = $par->getDueabove180less360();
        $this->view->getDueabove360 = $par->getDueabove360();

        $total30 = "0";
        $total60 = "0";
        $total90 = "0";
        $total180 = "0";
        $total360 = "0";
        $total360days = "0";
        $total180days = "0";
        $total60days = "0";
        $total = "0";

        foreach($this->view->due30 as $due30) {
            $page->drawText($due30->account_number,$x2, $y1);
            $page->drawText($due30->accountinstallment_amount,$x4, $y1);
            $total30 = $total30 + $due30->accountinstallment_amount;
            $page->drawLine(30, $y1, 565, $y1);
            $y1 = $y1 - 15;
        }

        foreach($this->view->getDueabove30less60 as $getDueabove30less60) {
            $page->drawText($getDueabove30less60->account_number,$x2, $y1);
            $page->drawText($getDueabove30less60->accountinstallment_amount,$x5, $y1);
            $total60 = $total60 + $getDueabove30less60->accountinstallment_amount;
            $page->drawLine(30, $y1, 565, $y1);
            $y1 = $y1 - 15;
        }

        foreach($this->view->getDueabove60less90 as $getDueabove60less90) {
            $page->drawText($getDueabove60less90->account_number,$x2, $y1);
            $page->drawText($getDueabove60less90->sum,$x6, $y1);
            $total90 = $total90 + $getDueabove60less90->sum;
            $page->drawLine(30, $y1, 565, $y1);
            $y1 = $y1 - 15;
        }

        foreach($this->view->getDueabove90less180 as $getDueabove90less180) {
            $page->drawText($getDueabove90less180->account_number,$x2, $y1);
            $page->drawText($getDueabove90less180->sum,$x7, $y1);
            $total180 = $total180 + $getDueabove90less180->sum;
            $page->drawLine(30, $y1, 565, $y1);
            $y1 = $y1 - 15;
        }

        foreach($this->view->getDueabove180less360 as $getDueabove180less360) {
            $page->drawText($getDueabove180less360->account_number,$x2, $y1);
            $page->drawText($getDueabove180less360->sum,$x8, $y1);
            $total360 = $total360 + $getDueabove180less360->sum;
            $page->drawLine(30, $y1, 565, $y1);
            $y1 = $y1 - 15;
        }

        foreach($this->view->getDueabove360 as $getDueabove360) {
            $page->drawText($getDueabove360->account_number,$x2, $y1);
            $page->drawText($getDueabove360->sum,$x9, $y1);
            $total360days = $total360days + $getDueabove360->sum;
            $page->drawLine(30, $y1, 565, $y1);
            $y1 = $y1 - 15;
        }

        $page->drawText($total30,$x4, $y1);
        $page->drawText($total60,$x5, $y1);
        $page->drawText($total90,$x6, $y1);
        $page->drawText($total180,$x7, $y1);
        $page->drawText($total360,$x8, $y1);
        $page->drawText($total360days,$x9, $y1);
        $page->drawText($text[11],$x2, $y1);
        $page->drawText($total30+$total60days+
                        $total90+$total180days+
                        $total360+$total360days,$x10, $y1);
    
        // Virtual table
        $page->setLineWidth(1)->drawLine(30, $y1, 30, 740); //Table left vertical
        $page->setLineWidth(1)->drawLine($x2, $y1, $x2, 740); //Table left vertical
        $page->setLineWidth(1)->drawLine($x3, $y1, $x3, 740); //Table left vertical
        $page->setLineWidth(1)->drawLine($x4, $y1, $x4, 740); //Table left vertical
        $page->setLineWidth(1)->drawLine($x5, $y1, $x5, 740); //Table left vertical
        $page->setLineWidth(1)->drawLine($x6, $y1, $x6, 740); //Table left vertical
        $page->setLineWidth(1)->drawLine($x7, $y1, $x7, 740); //Table left vertical
        $page->setLineWidth(1)->drawLine($x8, $y1, $x8, 740); //Table left vertical
        $page->setLineWidth(1)->drawLine($x9, $y1, $x9, 740); //Table left vertical
        $page->setLineWidth(1)->drawLine($x10,$y1, $x10, 740); //Table left vertical
        $page->setLineWidth(1)->drawLine(565, $y1, 565, 740); //table rigth vertical
        $page->drawLine(30, $y1, 565, $y1);


        $pdfData = $pdf->render();

        $pdf->save('/var/www/'.$projname.'/reports/par.pdf');
	$path = '/var/www/'.$projname.'/reports/par.pdf';
        chmod($path,0777);

    }
    }

