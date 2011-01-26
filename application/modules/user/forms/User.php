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




<?php class User_Form_User extends Zend_Form {


		
	

	public function init() 
	{

		$vtype=array('Alpha','StringLength');
		$formfield = new App_Form_Field ();

// 	$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value

		
	
        $name = $formfield->field('Text','name','','','mand','Name',true,'','','','','',1,0);
        $officebranch = $formfield->field('Select','bank_id','','','mand','Bank type',true,'','','','','',1,0);
        $gender = $formfield->field('Select','gender','','','mand','Gender',true,'','','','','',1,0);
        $designation = $formfield->field('Select','designation','','','mand','Designation',true,'','','','','',1,0);
        $grant_id = $formfield->field('Select','grant_id','','','mand','Granted as',true,'','','','','',1,0);
        $username = $formfield->field('Text','username','','','mand','Username',true,'','','','','',1,0);
        $password = $formfield->field('Text','password','','','mand','Password',true,'','','','','',1,0);

					
	$this->addElements(array($name,$officebranch,$gender,$designation,$grant_id,$username,$password));
    }
}