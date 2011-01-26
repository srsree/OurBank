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
class Management_Model_productfixedrecurring extends Zend_Db_Table {
	protected $_name = 'ourbank_product_fixedrecurring';

	public function editproductfixedrecurring($post,$offerproductupdate_id) {
		$where = 'offerproductupdate_id = '.$offerproductupdate_id;
		$data = array('minimum_deposit_amount'=>$post['minimum_deposit_amount'],
					'maximum_deposit_amount'=>$post['maximum_deposit_amount'],
					'frequency_of_deposit'=>$post['frequency_of_deposit'],
					'penal_Interest'=>$post['penal_Interest']);
		$this->update($data,$where);
	}
}
