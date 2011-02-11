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
 *  create form elements for new office
 */
class Officedefault_Form_officedefault extends Zend_Form{

 public function init() {

    }
        public function __construct($path,$createdid) {
        //Zend_Dojo::enableForm($this);
        //parent::__construct($options);

        //$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
        $formfield = new App_Form_Field ();

        $office_name = new Zend_Form_Element_Text('name');
        $office_name->setRequired(true)
                    ->addValidators(array(array('NotEmpty')));
        $office_name->setAttrib('class', 'txt_put');
        $office_name->addValidator(new Zend_Validate_Db_NoRecordExists('ourbank_office', 'name'));

        $officeshort_name = new Zend_Form_Element_Text('short_name');
        $officeshort_name->setAttrib('class', 'txt_put');
	$officeshort_name->setRequired(true)
		 	->addValidators(array(array('NotEmpty'),array('stringLength', false, array(3,3))));

        $officedescription=new Zend_Form_Element_Text('officedescription');
        $officedescription->setAttrib('class', 'txt_put');

        $officetype_id = new Zend_Form_Element_Select('officetype_id');
        $officetype_id->setRequired(true);
        $officetype_id->addMultiOption('','select'.'...');
        $officetype_id->setAttrib('class','selectbutton');
        $officetype_id->setRegisterInArrayValidator(false);
	//get url path from edit action
        $officetype_id->setAttrib('onchange', 'getInterests(this.value,"'.$path.'")');

        $parentoffice_id = new Zend_Form_Element_Select('parentoffice_id');
	$parentoffice_id->addMultiOption('','First select officetype'.'...');
	$parentoffice_id->setAttrib('class','selectbutton');
        $parentoffice_id->setRegisterInArrayValidator(false);

        $created_by = $formfield->field('Hidden','createdby','','','','','','','','','','',0,$createdid);
        $created_date = $formfield->field('Hidden','createddate','','','','','','','','','','',0,date("y/m/d H:i:s"));
	//add elements to form
         $this->addElements(array($office_name,$officeshort_name,$officetype_id,$parentoffice_id,$created_by,$created_date));
	}
}
/**class end*/
