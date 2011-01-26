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
/**  
 * class is used to create a form for SavingInstance details along with the validation
*/
class Penalty_Form_Penalty extends Zend_Form
{
	public function init()
	{
		
		$formfield = new App_Form_Field ();
		$vtype=array('Float');
		$table='ob_penalty';
		$fieldname='name';

// 	$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value

		$penaltyname = $formfield->field('Text','penaltyname',$table,$fieldname,'','',true,'','','','','','','');
		$penalty_per_delay = $formfield->field('Text','penalty_per_delay','','','','',true,$vtype,'','','','','','');
		$interest_of_delay = $formfield->field('Text','interest_of_delay','','','','',true,$vtype,'','','','','',0);
		$creditlinename = $formfield->field('Select','creditlinename','','','','',true,'','','','','','','');
		$status = $formfield->field('Checkbox','status','','','','',true,'','','','','','','');

		$this->addElements( array($penaltyname,$penalty_per_delay,$interest_of_delay,$creditlinename,$status));
	}
}
/** end of class */
