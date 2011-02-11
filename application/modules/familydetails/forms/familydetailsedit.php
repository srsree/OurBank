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
class Familydetails_Form_familydetailsedit extends Zend_Form {
    public function init()
    {} 
//edit family details form elements
    public function __construct($count,$number) 
    {
         parent::__construct($count,$number);
	$k=$count+1;
	$j=$count+$number;
        //$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
        $formfield = new App_Form_Field ();
        $vtype=array('Digits');
	 for($i=$k;$i<=$j;$i++) {
        $name = $formfield->field('Text','name'.$i,'','','','',true,'','','','','',0,0);
        $age = $formfield->field('Text','age'.$i,'','','','',true,'','','','','',0,0);
        $gender = $formfield->field('Select','gender'.$i,'','','mand','',true,'','','','','',0,0);
	$relation = $formfield->field('Select','relationship'.$i,'','','mand','',true,'','','','','',0,0);
        $physical = $formfield->field('Select','physicalstatus'.$i,'','','mand','',true,'','','','','',0,0);
        $marital = $formfield->field('Select','maritalstatus'.$i,'','','mand','',true,'','','','','',0,0);
        $this->addElements(array($name,$age,$gender,$relation,$physical,$marital));
	}
    }
}
