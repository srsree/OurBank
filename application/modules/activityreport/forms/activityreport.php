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
 *  search form elements for activity
 */
class Activityreport_Form_activityreport extends Zend_Form
{
    public function init()
    {
	 //$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
	$formfield = new App_Form_Field ();
	$activity = $formfield->field('Select','activity','','','','Activity name','','','','','','',0,0);
	$gender = $formfield->field('Select','gender','','','','Gender','','','','','','',0,0);
	$report = $formfield->field('Radio','report','','','','','','','','','','',0,0);
        $submit = new Zend_Form_Element_Submit('Search');
	//sdd pdf button
	$pdf = new Zend_Form_Element_Submit('PDF');
	//add chart button
	$chart = new Zend_Form_Element_Submit('CHART');
	//add element to form
        $this->addElements(array($activity,$gender,$report,$submit,$pdf,$chart));
    }
}
