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
class Sectors_Form_Sectors extends Zend_Form 
{
	public function __construct($createdById) // receive created by value as a constructor
	{
	    parent::__construct();
                // 	$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
                $formfield = new App_Form_Field ();
                // send parameters to get form fields as a form field(first parameter is type of input field)
                $name = $formfield->field('Text','name','','','mand','Sector',true,'','','','','',1,'');
                $name->addValidators(array(array('stringLength', false, array(1,30))));
                $name->addValidator('Alpha',true,array('allowWhiteSpace'=>true));
                $id = $formfield->field('Hidden','id','','','','',false,'','','','','',0,'');
                $description = $formfield->field('Textarea','description','','','mand','Description',true,'','','',3,18,1,0);
                $status = $formfield->field('Checkbox','status','','','mand','Active',true,'','','','','',1,'');
                $createdBy = $formfield->field('Hidden','created_by','','','','',"","","","","",false,0,$createdById);
                $createdDate = $formfield->field('Hidden','created_date','','','','',"","","","","",false,0,date("y/m/d H:i:s"));
                $this->addElements(array($name,$description,$id,$status,$createdBy,$createdDate));
	}
}