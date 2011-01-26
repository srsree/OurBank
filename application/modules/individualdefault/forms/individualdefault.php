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

<!--
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
!-->
<?php
class  Individualdefault_Form_individualdefault extends Zend_Form {

    public function init() {
        //create a indiviudal form element 
        //$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
        $formfield = new App_Form_Field ();
        $vtype=array('Digits');				
        $office = $formfield->field('Select','office','','','mand','Office name',true,'','','','','',1,0);
        $memberfirstname = $formfield->field('Text','memberfirstname','','','mand','Member name',true,'','','','','',1,0);
        $gender_id = $formfield->field('Select','gender_id','','','mand','Gender',true,'','','','','',1,0);
        $dateofbirth = $formfield->field('Text','memberdateofbirth','','','mand','Date of Brith',true,'','','','','',1,0);
	$mobile = $formfield->field('Text','mobile','','','mand','mobile',true,$vtype,1,15,'','',1,0);

        $this->addElements(array($office,$memberfirstname,$gender_id,$dateofbirth,$mobile));

    }
}
