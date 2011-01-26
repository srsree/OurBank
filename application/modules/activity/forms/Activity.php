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
class Activity_Form_Activity extends Zend_Form {
        // @receive login id as constructor value
	public function __construct($createdById) 
	{
		parent::__construct();
		// 	$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
                // create instance for common form field
		$formfield = new App_Form_Field ();
                // send parameters to display respective form fields (first parameter is a needed form field)
		$name = $formfield->field('Text','name','','','mand','Name',true,'','','','','',1,'');
                $name->addValidator('Alpha', true, array('allowWhiteSpace' => true));
		$description = $formfield->field('Textarea','description','','','mand','Description',true,'','','',3,18,1,0);
		$sector_id = $formfield->field('Select','sector_id','','','mand','Sector',true,'','','','','',1,'');
		$status = $formfield->field('Checkbox','status','','','mand','Active',false,'','','','','',1,'');
                $createdBy = $formfield->field('Hidden','created_by','','','','',"","","","","",false,0,$createdById);
		$createdDate = $formfield->field('Hidden','created_date','','','','',"","","","","",false,0,date("y/m/d H:i:s"));
		$this->addElements(array($name,$description,$sector_id,$status,$createdBy,$createdDate));
		}
	}
