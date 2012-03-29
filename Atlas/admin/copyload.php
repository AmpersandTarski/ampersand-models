<?php
require "php/DatabaseUtils.php";

function copyload($user){
  $copytables
   = array(
     'INSERT IGNORE INTO conid SELECT * FROM ns'.$user.'conid WHERE ctxnm IS NOT NULL',
     'INSERT IGNORE INTO includes SELECT * FROM ns'.$user.'includes',
     //needed?   "errormessage"
     'INSERT IGNORE INTO file SELECT * FROM ns'.$user.'file WHERE SavePopFile IS NULL AND NewAdlFile IS NULL AND SaveAdlFile IS NULL',
     //needed?   "filename"
     //-needed?   "filepath"
     'INSERT IGNORE INTO uploaded SELECT * FROM ns'.$user.'uploaded',
     'INSERT IGNORE INTO user SELECT * FROM ns'.$user.'user'
     );
  foreach ($copytables as $copytable)
	  DB_doquer($copytable);
}
?>
