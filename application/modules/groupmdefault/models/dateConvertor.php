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
class Creditline_Model_dateConvertor  {

    public function mysqlformat($nformat) {
        $ndate = new Zend_Date($nformat, 'dd/mm/yyyy');
        $mdate = $ndate->toString('yyyy-mm-dd');
        return $mdate;
     }

    public function normalformat($mformat) {
        $mdate = new Zend_Date($mformat, 'yyyy-mm-dd');
        $ndate = $mdate->toString('dd/mm/yyyy');
        return $ndate;
    }


    public function phpmysqlformat($nformat){
        $ndate=explode("/",$nformat);
        $mdate=$ndate[2]."-".$ndate[1]."-".$ndate[0];
        return $mdate;
    }

    public function phpnormalformat($mformat){
        $mdate=explode("-",$mformat);
        $ndate=$mdate[2]."/".$mdate[1]."/".$mdate[0];
        return $ndate;
    }
}

