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
class settings_Model_Customization extends Zend_Db_Table
{
    protected $_name = 'ourbank_usernamesupdates';

    public function insert($input,$tableName)
    {
        $db = $this->getAdapter();
        $db->insert($tableName,$input);
        return $db->lastInsertId($tableName);
    } 

    public function fetchcustomized($tableName,$id)
    {
	$db = $this->getAdapter();
	$sql = 'select * from '.$tableName.' where submodule_id = '.$id.'';
	return $db->fetchALL($sql,array());
    }

    public function getTableInfo($table)
    {
	$db = $this->getAdapter();
	$sql = 'select * from '.$table.'';
	return $db->fetchALL($sql,array());
    }


    public function getfieldNames($table)
    {
        $db = $this->getAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = 'SELECT * FROM information_schema.COLUMNS WHERE table_schema = "ourbank" AND table_name = "'.$table.'"';
        return $db->fetchAll($sql,array());
    }

    public function getSubmodule($sudmodule_id)
    {
        $db = $this->getAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = 'SELECT submodule_description FROM ourbank_submodule WHERE submodule_id = "'.$sudmodule_id.'"';
        return $db->fetchAll($sql,array());
    }
    public function gettableDetails($form_id)
    {
        $db = $this->getAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $sql = 'SELECT * FROM ourbank_customizingform WHERE form_id = "'.$form_id.'"';
        return $db->fetchAll($sql,array());
    }

    public function createTable($tNmae,$feild_name,$data_type,$t)
    {
        $db = $this->getAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $pk = $t."_id";
        $sql1 = 'CREATE TABLE IF NOT EXISTS '.$tNmae.' ( '.$pk.' int(11) NOT NULL auto_increment,PRIMARY KEY('.$pk.'),
                                                        '.$feild_name.' '.$data_type.'(30))';
        $db->query($sql1);
        $sql = 'ALTER TABLE '.$tNmae.' ADD ('.$feild_name.' '.$data_type.'(50))';
        $db->query($sql);
        return;
    }
}
