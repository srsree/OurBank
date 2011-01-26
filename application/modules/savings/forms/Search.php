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

class Savings_Form_Search extends Zend_Form 
{
	public function __construct() 
	{
		parent::__construct();
		// 	$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
                // create instance to call common field
		$formfield = new App_Form_Field ();
                // send parameters to get form fields (first parameter is a form field type)
		$prodname = $formfield->field('Text','prodname','','','','Product name',false,'','','','','',0,'');
		$shrtname = $formfield->field('Text','shname','','','','Short name',false,'','','','','',0,'');
                $fromdate = $formfield->field('Text','fromdate','','','','Begin date',false,'','','','','',0,'');
		$closedate = $formfield->field('Text','todate','','','','Close date',false,'','','','','',0,'');
		$this->addElements(array($prodname,$shrtname,$fromdate,$closedate));
	}
}
