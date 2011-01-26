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

class DH_ClassInfo
{
    private $dir;

    public function __construct($dirPath)
    {
        if(is_dir($dirPath))
            $this->dir = $dirPath;
        else
            throw new Exception($dirPath . " is not Directory or its not Readable.");
    }
	
    public function getControllerClassFiles()
    {
		$files = scandir($this->dir);
		return array_filter($files, "filterClassFile");
    }
	
    public function getControllerClassNames()
    {
        $files = $this->getControllerClassFiles();
        $names = array();
        $classNames = array();
        foreach($files as $file) {
            $data = file($this->dir.DIRECTORY_SEPARATOR.$file, FILE_IGNORE_NEW_LINES);
            foreach(array_filter($data, "filterClassName") as $key) {
                array_push($names, $key);
            }
        }
        foreach($names as $name) {
            $nameArray = split('[ ]+', $name);
            array_push($classNames, $nameArray[1]);
        }
        return $classNames;
    }
    
    public function getActionNames()
    {
        $files = $this->getControllerClassFiles();
        $actionNames = array();
        foreach($files as $file) {
        	$names = array();
            $data = file($this->dir.DIRECTORY_SEPARATOR.$file, FILE_IGNORE_NEW_LINES);
            foreach(array_filter($data, "filterActionFunction") as $key) {
                array_push($names, $key);
            }
            $className = $this->getControllerClassName($this->dir.DIRECTORY_SEPARATOR.$file);
            $actionNames[$className] = array();
	        foreach($names as $name) {
	            $nameArray = split('[ ]+|\(', $name);
	            $data = array_filter($nameArray, "filterActionName");
	            array_push($actionNames[$className], current($data));
	        }
        }
        return $actionNames;
    }
    
    private function getControllerClassName($file)
    {
    	$names = array();
    	$classNames = array();
        $data = file($file, FILE_IGNORE_NEW_LINES);
        foreach(array_filter($data, "filterClassName") as $key) {
            array_push($names, $key);
        }
        foreach($names as $name) {
            $nameArray = split('[ ]+', $name);
            array_push($classNames, $nameArray[1]);
        }
        if(empty($classNames)) {
        	return;
        } else {
            return $classNames[0];
        }
    }
}

function filterClassFile($var)
{
    preg_match('/.*Controller.php$/', $var, $matches);
    return $matches;
}

function filterActionFunction($var)
{
    preg_match('/.*function.*Action[\s]*\(/', $var, $matches);
    return $matches;
}

function filterClassName($var)
{
    preg_match('/^[\s]*class[\s]+[A-Za-z_0-9]+/', $var, $matches);
    return $matches;
}

function filterActionName($var)
{
    preg_match('/.*Action$/', $var, $matches);
    return $matches;
}
