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

<?php class Fee_Form_Fee extends Zend_Form {


		
	

	public function init() 
	{

		$vtype=array('Alpha','StringLength');
		$formfield = new App_Form_Field ();

// 	$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value

		
	
        $name = $formfield->field('Text','name','','','mand','Fee name',true,'','','','','',1,0);

        $membertype = $formfield->field('Select','membertype_id','','','mand','Member type',true,'','','','','',1,0);
        $description = $formfield->field('Text','description','','','mand','Fee description',true,'','','','','',1,0);
        $amount = $formfield->field('Text','value','','','mand','Fee amount',true,'','','','','',1,0);
		$feefor = $formfield->field('Select','glsubcode_id','','','mand','Fee for',true,'','','','','',1,0);
        // Hidden Feilds 
        $id = $formfield->field('Hidden','id','','','','',false,'','','','','',0,0);
        $createdBy = $formfield->field('Hidden','created_by','','','','',false,'','','','','',0,1);
        $createdDate = $formfield->field('Hidden','created_date','','','','',false,'','','','','',0,date("y/m/d H:i:s"));

					
            $this->addElements(array($id,$name,$description,$membertype,$amount,$feefor,
            $createdBy,$createdDate));
    }
}