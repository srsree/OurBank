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
 *  create form elements for funder
 */
class  Funderdetails_Form_funderdetails extends Zend_Form {

    public function init() {}
    public function __construct($create_id) 
    {
        parent::__construct($create_id);
	//description
        //$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
	//create instance of form fields
        $formfield = new App_Form_Field ();
        $name = $formfield->field('Text','name','','','mand','Funder name',true,'','','','','',1,0);
        $type = $formfield->field('Select','type','','','mand','Funder type',true,'','','','','',1,0);
        $status = $formfield->field('Checkbox','status','','','mand','Active','','','','','','',1,0);

        $code = $formfield->field('Hidden','code','','','','',false,'','','','','',0,0);
        $created_by = $formfield->field('Hidden','created_by','','','','',false,'','','','','',0,$create_id);
        $created_date = $formfield->field('Hidden','created_date','','','','',false,'','','','','',0,date("y/m/d H:i:s"));	
	//add elements to form
        $this->addElements(array($code,$type,$name,$status,$created_by,$created_date));

    }
}
