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
 *  create new form elements for bank
 */
class Bank_Form_Bank extends Zend_Form 
{
    public function __construct() 
    {
        parent::__construct();
	//adm form attribute instance
        $formfield = new App_Form_Field ();
        $name = $formfield->field('Text','name','','','mand','Name',true,'','','','','',1,0);
        $status = $formfield->field('Checkbox','status','','','','Active',false,'','','','','',1,0);
        $code = $formfield->field('Text','code','','','','Code',true,'','','','','',1,0);
        $description = $formfield->field('Text','description','','','','Description',true,'','','','','',1,0);
        //hidden feilds
        $id = $formfield->field('Hidden','id','','','','',false,'','','','','',0,0);
        $createdBy = $formfield->field('Hidden','created_by','','','','',false,'','','','','',0,1);
        $createdDate = $formfield->field('Hidden','created_date','','','','',false,'','','','','',0,date("y/m/d H:i:s"));
	//add element to form
        $this->addElements(array($name,$status,$code,$description,$id,$createdBy,$createdDate));
    }
}
