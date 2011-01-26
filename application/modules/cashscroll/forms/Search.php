<?php
/*
 *  create search form elements for cashscroll
 */
class Cashscroll_Form_Search extends ZendX_JQuery_Form {
	
    public function __construct() 
    {
        parent::__construct();
        //$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$decorator,$value
        $formfield = new App_Form_Field ();
        $datefrom = $formfield->field('Text','datefrom','','','mand','From date',true,'','','','','',0,'');
        //add element to form
        $this->addElements(array($datefrom));
    }
}
