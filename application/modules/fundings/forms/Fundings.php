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

<?php class Fundings_Form_Fundings extends ZendX_JQuery_Form {
	public function init() 
	{
		$formfield = new App_Form_Field ();
        $name = $formfield->field('Text','name','','','mand','Funding name',true,'','','','','',1,0);

        $institutionId = $formfield->field('Select','institution_id','','','mand','Institution name',true,'','','','','',1,0);
        $funderId = $formfield->field('Select','funder_id','','','mand','Funder name',true,'','','','','',1,0);
        $intrest = $formfield->field('Text','intrest','','','mand','Intrest %',true,'','','','','',1,0);
        $currencyId = $formfield->field('Select','currency_id','','','mand','Funding currency',true,'','','','','',1,0);
        $amount = $formfield->field('Text','amount','','','mand','Funding amount R$',true,'','','','','',1,0);
        $exchangerate = $formfield->field('Text','exchangerate','','','mand','Funding exchange rate',true,'','','','','',1,0);
        $glsubcode = $formfield->field('Select','glsubcode_id','','','mand','GL code',true,'','','','','',1,0);

        $beginingDate = $formfield->field('Text','beginingdate','','','mand','Funding period from',true,'','','','','',1,0);
        $closingDate = $formfield->field('Text','closingdate','','','mand','Funding period to',true,'','','','','',1,0);

		// Hidden Feilds 
		$id = $formfield->field('Hidden','id','','','','',false,'','','','','',0,0);
		$createdBy = $formfield->field('Hidden','created_by','','','','',false,'','','','','',0,1);
        $createdDate = $formfield->field('Hidden','created_date','','','','',false,'','','','','',0,date("y/m/d H:i:s"));

					
            $this->addElements(array($funderId,$institutionId,$name,
									 $amount,$intrest,
                                     $currencyId,$exchangerate,$glsubcode,
									 $beginingDate,$closingDate,
                                     $id,$createdBy,
									 $createdDate));
    }
}