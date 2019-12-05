<?php
/*
   This file is here to overwrite the corresponding file from the prototype generator.
   By doing this, we prevent a double definition of PHP-functions, 
   that would otherwise have resulted in a fatal error.
   
   The consequence is that the old 'SendMail' function does not work in combination with Messaging.
*/
?>