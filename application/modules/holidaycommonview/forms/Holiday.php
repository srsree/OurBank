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

<?php class Holiday_Form_Holiday extends Zend_Form {


		
	

	public function init() 
	{

		$vtype=array('Alpha','StringLength');
		$formfield = new App_Form_Field ();

// 	$fieldtype,$fieldname,$table,$columnname,$cssname,$labelname,$required,$validationtype,$min,$max,$rows,$cols,$decorator,$value

		
	
        $holidayname = $formfield->field('Text','name','','','mand','Holiday name',true,'','','','','',1,0);
        $office_id = $formfield->field('Text','description','','','mand','Office name',true,'','','','','',1,0);
        $holidayfrom = $formfield->field('Text','holiday_from','','','mand','Holiday from',true,'','','','','',1,0);
        $holidayto = $formfield->field('Text','holiday_upto','','','mand','Holiday upto',true,'','','','','',1,0);
        $repaymentdate = $formfield->field('Text','repayment_date','','','mand','Repayment date',true,'','','','','',1,0);
       

        

        // Hidden Feilds 
        $id = $formfield->field('Hidden','id','','','','',false,'','','','','',0,0);
        $createdBy = $formfield->field('Hidden','created_by','','','','',false,'','','','','',0,1);
        $createdDate = $formfield->field('Hidden','created_date','','','','',false,'','','','','',0,date("y/m/d H:i:s"));

					
            $this->addElements(array($id,$holidayname,$office_id,$holidayfrom,$holidayto,$repaymentdate,
            $createdBy,$createdDate));
    }
}