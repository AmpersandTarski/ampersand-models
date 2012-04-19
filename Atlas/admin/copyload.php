<?php
require "php/DatabaseUtils.php";

function copyload($user){
  $copytables
   = array(
     'INSERT IGNORE INTO nssharedConid SELECT * FROM ns'.$user.'Conid WHERE ctxnm IS NOT NULL',
     'INSERT IGNORE INTO nssharedincludes SELECT * FROM ns'.$user.'includes',
     //needed?   "errormessage"
     'INSERT IGNORE INTO nssharedFile SELECT * FROM ns'.$user.'File WHERE SavePopFile IS NULL AND NewAdlFile IS NULL AND SaveAdlFile IS NULL',
     //needed?   "filename"
     //-needed?   "filepath"
     'INSERT IGNORE INTO nsshareduploaded SELECT * FROM ns'.$user.'uploaded',
     'INSERT IGNORE INTO nssharedUser SELECT * FROM ns'.$user.'User',
     'INSERT IGNORE INTO nssharedParseError SELECT * FROM ns'.$user.'ParseError',
     'INSERT IGNORE INTO nssharedTypeError1 SELECT * FROM ns'.$user.'TypeError1',
     'INSERT IGNORE INTO nssharedtypeerror2 SELECT * FROM ns'.$user.'typeerror2'
     );
  foreach ($copytables as $copytable)
	  DB_doquer($copytable);
}
?>
