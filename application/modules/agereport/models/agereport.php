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
 *  model page for calculation and return age wise details
 */
class Agereport_Model_agereport extends Zend_Db_Table {
    protected $_name = 'ob_member';

    public function getage_between($from_age,$to_age) {
                        $db = $this->getAdapter();
			//internel sql age calculation
                        $sql = "SELECT b.id,(YEAR(CURDATE())-YEAR(b.member_dateofbirth)) - (RIGHT(CURDATE(),5)<RIGHT(b.member_dateofbirth,5)) AS `age`, COUNT(b.id) as membercount FROM `ob_member` AS `b` WHERE ((YEAR(CURDATE())-YEAR(b.member_dateofbirth)) - (RIGHT(CURDATE(),5)<RIGHT(b.member_dateofbirth,5))>=$from_age) and ((YEAR(CURDATE())-YEAR(b.member_dateofbirth)) - (RIGHT(CURDATE(),5)<RIGHT(b.member_dateofbirth,5))<=$to_age)";
                        $result = $db->fetchAll($sql);
                        return $result;
    }

     public function getage_above($age) {
                        $db = $this->getAdapter();
                        $sql = "SELECT b.id,(YEAR(CURDATE())-YEAR(b.member_dateofbirth)) - (RIGHT(CURDATE(),5)<RIGHT(b.member_dateofbirth,5)) AS `age`,COUNT(b.id) as membercount FROM `ob_member` AS `b`  WHERE ((YEAR(CURDATE())-YEAR(b.member_dateofbirth)) - (RIGHT(CURDATE(),5)<RIGHT(b.member_dateofbirth,5))>=$age)";
                        $result = $db->fetchAll($sql);
                        return $result;
    }

 }
