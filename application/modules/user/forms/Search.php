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

<?php class User_Form_Search extends Zend_Form {


		
	

	public function init() 
	{

		$vtype=array('Alpha','StringLength');
		$formfield = new App_Form_Field ();

// 	$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
        	$username = $formfield->field('Text','name','','','mand','',false,'','','','','',0,0);
        	$designation = $formfield->field('Select','designation','','','mand','',false,'','','','','',0,0);
        	$bankname = $formfield->field('Select','bank','','','mand','',false,'','','','','',0,0);
        	$grant_id = $formfield->field('Select','grant_id','','','mand','',false,'','','','','',0,0);
        // Hidden Feilds 
        	$user_id = $formfield->field('Hidden','user_id','','','','',false,'','','','','',0,1);
					
		$this->addElements(array($username,$bankname,$designation,$grant_id,$user_id));
    }
}