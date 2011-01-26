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
	class App_Form_Search extends Zend_Form {
		public function __construct() 
		{
	    	parent::__construct();
			//$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
			$formfield = new App_Form_Field ();
			//$vtype=array('Alpha');
			$activity = $formfield->field('Select','Activityname','','','','Activity name',true,'','','','','',0,'');
			$credit = $formfield->field('Select','Creditline','','','','Creditline details',false,'','','','','',0,'');
			$datefrom = $formfield->field('Text','datefrom','','','mand','From date',true,'','','','','',0,'');
			$dateto = $formfield->field('Text','dateto','','','mand','To date',true,'','','','','',0,'');
			//$sector = $formfield->field('Text','sector','','','mand','Sector',true,$vtype,'','','','',1,'');
// 			$staffname = array('PDF', 'Bar Graph');
// 			         $pdf = new Zend_Form_Element_Radio('pdf');
// 			         $pdf->setRequired(false) // field required
// 				     ->setValue('R') // first radio button selected
// 				     ->setMultiOptions($staffname); // add array of values / labels for radio group
			$this->addElements(array($activity,$credit,$datefrom,$dateto));
			return ;
	
		}
	}