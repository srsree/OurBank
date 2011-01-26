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
class Recurringaccount_Form_Accounts extends Zend_Form 
{
    public function init() 
    {
        //$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
        $formfield = new App_Form_Field ();
        $membercode = $formfield->field('Text','membercode','','','mand','',true,'','','','','',0,0);
        //hidden feilds
	$Type = $formfield->field('Hidden','Type','','','','',false,'','','','','',0,0);
	$submit = $formfield->field('Submit','Search','','','','',false,'','','','','',0,0);
        $this->addElements(array($membercode,$Type,$submit));
    }
}