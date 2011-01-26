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
class Graceperiod_Form_Graceperiod extends Zend_Form
{
	public function init()
	{
		$formfield = new App_Form_Field ();
		$vtype=array('NotEmpty','Digits','stringLength');
		$table='ob_graceperiod';
		$fieldname='name';

// 	$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value

		$graceperiod_name = $formfield->field('Text','name',$table,$fieldname,'mand','Name',true,'','','','','',1,0);
		$graceperiod_days = $formfield->field('Text','days','','','mand','Days',true,$vtype,1,2,'','',1,0);
		$creditlinename = $formfield->field('Select','creditline_id','','','mand','Creditline',true,'','','','','',1,0);
		$graceperiod_status = $formfield->field('Checkbox','status','','','mand','Active','','','','','','',1,0);


		$this->addElements( array($graceperiod_name,$graceperiod_days,$creditlinename,$graceperiod_status));
	}
}
/** end of class */
