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
class Management_Model_Officeaddress extends Zend_Db_Table_Abstract {
    protected $_name = 'ourbank_officeaddress';
    public function addOfficeAddress($post,$office_id) {
        $data = array('officeaddress_id'=> '',
                      'office_id'=>$office_id,
                      'officedescription'=>$post['officedescription'],
                      'officeaddress1'=>$post['officeaddress1'],
                      'officeaddress2'=>$post['officeaddress2'],
                      'officeaddress3'=>$post['officeaddress3'],
                      'officecity'=>$post['officecity'],
                      'officestate'=>$post['officestate'],
                      'officecountry'=>$post['officecountry'],
                      'officepincode'=>$post['officepincode'],
                      'officephone'=>$post['officephone'],
                      'office_fax'=>$post['office_fax'],
                      'office_email_Id'=>$post['office_email_Id'],
                      'contactperson'=>$post['contactperson'],
                      'contactperson_phone1'=>$post['contactperson_phone1'],
                      'contactperson_phone2'=>$post['contactperson_phone2'],
                      'contactperson_email'=>$post['contactperson_email'],
                      'createdby'=>'1',
                      'recordstatus_id'=>'3',
                      'createddate'=>date("Y-m-d"));
     $this->insert($data);
    }

	public function officeInsert($input = array())
	{
		$this->db = Zend_Db_Table::getDefaultAdapter();
		$result = $this->db->insert('ourbank_office',$input);
		return $this->db->lastInsertId('ourbank_office');
    }
}
