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

<?php class Product_Form_Product extends Zend_Form {



	public function init() 
	{

		$vtype=array('Alpha','StringLength');
		$formfield = new App_Form_Field ();
// 	$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value
	        $category_id = $formfield->field('Select','category_id','','','mand','Category name *',true,'','','','','',1,0);
		$producttype = $formfield->field('Text','name','','','mand','Product type *',true,'','','','','',1,0);
		$shortname = $formfield->field('Text','shortname','','','mand','short name *',true,'','','','','',1,0);

        	$productdescription = $formfield->field('Text','description','','','mand','Description *',true,'','','','','',1,0);
		// Hidden Feilds 
		$id = $formfield->field('Hidden','id','','','','',false,'','','','','',0,0);
		$createdBy = $formfield->field('Hidden','created_by','','','','',false,'','','','','',0,1);
		$createdDate = $formfield->field('Hidden','created_date','','','','',false,'','','','','',1,0);

					
            $this->addElements(array($category_id,$id,$producttype,$shortname,$productdescription,
            $createdBy,$createdDate));
    }
}