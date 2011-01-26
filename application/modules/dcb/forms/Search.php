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
 *  create search form elements for cashscroll
 */
class Dcb_Form_Search extends Zend_Form {
	public function __construct() 
		{
                parent::__construct();
                //$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$decorator,$value
                $formfield = new App_Form_Field ();
                // send parameter to get input fields
                $datefrom = $formfield->field('Text','datefrom','','','mand','From date',true,'','','','','',0,'');
                $dateto = $formfield->field('Text','dateto','','','mand','To date',true,'','','','','',0,'');
                //add element to form
		$this->addElements(array($datefrom,$dateto));
		}
}
