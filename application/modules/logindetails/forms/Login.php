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

<?php class Logindetails_Form_Login extends Zend_Form {


		
	

	public function init() 
	{

		$vtype=array('Alpha','StringLength');
		$formfield = new App_Form_Field ();

// 	$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value

		
	
        	$username = $formfield->field('Text','username','','','mand','Email',true,'','','','','',1,0);
               	$password = $formfield->field('Text','password','','','mand','password',true,'','','','','',1,0);

        // Hidden Feilds 
        $user_id = $formfield->field('Hidden','user_id','','','','',false,'','','','','',0,1);
	$recordstatusId = $formfield->field('Hidden','recordstatus_id','','','','',false,'','','','','',0,3);

					
	$this->addElements(array($username,$password,$user_id,
            $recordstatusId));
    }
}