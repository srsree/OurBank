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
class Management_Model_Interestperiods extends Zend_Db_Table {
	protected $_name = 'ourbank_interest_periods';

	public function deleteinterestperiods($offerproduct_id) {
		$data = array('intereststatus_id'=> 5);
		$where = 'offerproduct_id = '.$offerproduct_id;
		$this->update($data,$where);
	}

	public function UpDateinterestperiods($offerproduct_id) {
		$data = array('intereststatus_id'=> 2);
		$where = 'offerproduct_id = '.$offerproduct_id;
		$this->update($data,$where);
	}

	public function insertinterestperiods($data) {
		$this->insert($data);
	}
}
