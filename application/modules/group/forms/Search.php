<?php

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

class Group_Form_Search extends Zend_Dojo_Form {
   
	public function __construct() 
		{
			parent::__construct();
			//$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$decorator,$value
			$formfield = new App_Form_Field ();
                        // send parameters to get input fields 
			$groupcode = $formfield->field('Text','groupcode','','','','Group code',false,'','','','','',1,'');
			$groupname = $formfield->field('Text','groupname','','','','Group name',false,'','','','','',1,'');
			$this->addElements(array($groupcode,$groupname));
		}
}
