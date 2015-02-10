<?php 

function logEvent($logtext) 
{ $date = date('Y-m-d H:i:s');
  Notifications::addLog("$date - $logtext");
}

function CloseFireDoor($FireDoorConcept,$FireDoorAtom)
{  // code (to simulate) closing a firedoor, given its ID
   logEvent("Firedoor $FireDoorAtom has been instructed to close.");
}


?>