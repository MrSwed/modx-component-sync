<?php
/*
 * WARNING! Currently this code is naive. If you dump everything to the file 
 * system, modify something in the database and load it back - the code will 
 * overwrite your changes.
 * 
 */

define('MODX_API_MODE', true);
$shortopts = ""; // todo: add types and one item handle
$longopts = array(
 "dump",
 "load",
 "foldername:",
 "eol:",
);
$opt = getopt($shortopts, $longopts);
$command = "";
if (isset($opt["load"]) and !isset($opt["dump"])) $command = "load";
else if (!isset($opt["load"]) and isset($opt["dump"])) $command = "dump";

$foldername = isset($opt["foldername"])?$opt["foldername"]:'_db';
$eol = isset($opt["eol"])?$opt["eol"]:''; // normalize line ending. empty (do not convert - leave as is), lf - to unix, cr - to mac,  crl - to windows 

// getopt work only with named parameters  and  with php -n
// todo: own simple getopt switch based

print_r($argv);
print_r($opt);
exit;

$usage = <<<EOD

See Readme.md for help. Usage:

 $argv[0] [command] <options>
   command:
    --load      - From the File System TO the Database
    --dump      - From the Database TO the file system

   options: 
   --foldername - set dirname. default _db  
   --eol        - normalize line endings while dump file. 
                  lf   - unix style
                  cr   - mac style
                  crlf - windows style

EOD;

$tt = array('snippets', 'chunks', 'plugins', 'templates');

if ($command == 'dump') {
  $class = 'ComponentDump';
} else if ($command == 'load') {
  $class = 'ComponentLoad';
} else {
  die($usage);
}

//echo "Running $command with options: foldername: $foldername, Normalize: ".($eol?$eol:"no")." \n\n";

include '../../../index.php';
require_once dirname(__FILE__)."/classes/$class.php";
foreach($tt as $t) {
	/* @var $c ComponentLoad */
  try {
	$c = new $class($modx, $t, $foldername, $eol);
	$c->run();
	echo $c->getStats();
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}