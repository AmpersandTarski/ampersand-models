<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Strict//EN">
  <html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="no-cache">
  <meta http-equiv="Expires" content="-1">
  <meta http-equiv="cache-Control" content="no-cache">
  
  </html>
  <body>
  <?php
  // Try to connect to the database

  if(isset($DB_host)&&!isset($_REQUEST['DB_host'])){
    $included = true; // this means user/pass are probably correct
    $DB_link = @mysql_connect(@$DB_host,@$DB_user,@$DB_pass);
  }else{
    $included = false; // get user/pass elsewhere
    if(file_exists("dbSettings.php")) include "dbSettings.php";
    else { // no settings found.. try some default settings
      if(!( $DB_link=@mysql_connect($DB_host='localhost',$DB_user='root',$DB_pass='')))
      { // we still have no working settings.. ask the user!
        die("Install failed: cannot connect to MySQL"); // todo
      }
    } 
  }
  if($DB_slct = @mysql_select_db('atlas')){
    $existing=true;
  }else{
    $existing = false; // db does not exist, so try to create it
    @mysql_query("CREATE DATABASE `atlas` DEFAULT CHARACTER SET UTF8");
    $DB_slct = @mysql_select_db('atlas');
  }
  if(!$DB_slct){
    echo die("Install failed: cannot connect to MySQL or error selecting database 'atlas'");
  }else{
    if(!$included && !file_exists("dbSettings.php")){ // we have a link now; try to write the dbSettings.php file
       if($fh = @fopen("dbSettings.php", 'w')){
         fwrite($fh, '<'.'?php $DB_link=mysql_connect($DB_host="'.$DB_host.'", $DB_user="'.$DB_user.'", $DB_pass="'.$DB_pass.'"); $DB_debug = 3; ?'.'>');
         fclose($fh);
       }else die('<P>Error: could not write dbSettings.php, make sure that the directory of Installer.php is writable
                  or create dbSettings.php in the same directory as Installer.php
                  and paste the following code into it:</P><code>'.
                 '&lt;'.'?php $DB_link=mysql_connect($DB_host="'.$DB_host.'", $DB_user="'.$DB_user.'", $DB_pass="'.$DB_pass.'"); $DB_debug = 3; ?'.'&gt;</code>');
    }

    $error=false;
    /*** Create new SQL tables ***/
    
    // Session timeout table
    if($columns = mysql_query("SHOW COLUMNS FROM `__SessionTimeout__`")){
        mysql_query("DROP TABLE `__SessionTimeout__`");
    }
    mysql_query("CREATE TABLE `__SessionTimeout__`
                         ( `SESSION` VARCHAR(255) UNIQUE NOT NULL
                         , `lastAccess` BIGINT NOT NULL
                         ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) {
      $error=true; echo $err.'<br />';
    }
    
    // Timestamp table
    if($columns = mysql_query("SHOW COLUMNS FROM `__History__`")){
        mysql_query("DROP TABLE `__History__`");
    }
    mysql_query("CREATE TABLE `__History__`
                         ( `Seconds` VARCHAR(255) DEFAULT NULL
                         , `Date` VARCHAR(255) DEFAULT NULL
                         ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) {
      $error=true; echo $err.'<br />';
    }
    $time = explode(' ', microTime()); // copied from DatabaseUtils setTimestamp
    $microseconds = substr($time[0], 2,6);
    $seconds =$time[1].$microseconds;
    date_default_timezone_set("Europe/Amsterdam");
    $date = date("j-M-Y, H:i:s.").$microseconds;
    mysql_query("INSERT INTO `__History__` (`Seconds`,`Date`) VALUES ('$seconds','$date')");
    if($err=mysql_error()) {
      $error=true; echo $err.'<br />';
    }
    
    //// Number of plugs: 47
    if($existing==true){
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedConid`")){
        mysql_query("DROP TABLE `nssharedConid`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedFile`")){
        mysql_query("DROP TABLE `nssharedFile`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedADLid`")){
        mysql_query("DROP TABLE `nssharedADLid`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedDeclaration`")){
        mysql_query("DROP TABLE `nssharedDeclaration`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedRelation`")){
        mysql_query("DROP TABLE `nssharedRelation`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedG`")){
        mysql_query("DROP TABLE `nssharedG`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedPair`")){
        mysql_query("DROP TABLE `nssharedPair`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedSign`")){
        mysql_query("DROP TABLE `nssharedSign`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedGen`")){
        mysql_query("DROP TABLE `nssharedGen`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedPairID`")){
        mysql_query("DROP TABLE `nssharedPairID`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedAtomID`")){
        mysql_query("DROP TABLE `nssharedAtomID`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedExpressionID`")){
        mysql_query("DROP TABLE `nssharedExpressionID`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedUser`")){
        mysql_query("DROP TABLE `nssharedUser`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedExpression`")){
        mysql_query("DROP TABLE `nssharedExpression`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedProperty`")){
        mysql_query("DROP TABLE `nssharedProperty`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedVarid`")){
        mysql_query("DROP TABLE `nssharedVarid`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedAtom`")){
        mysql_query("DROP TABLE `nssharedAtom`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedBlob`")){
        mysql_query("DROP TABLE `nssharedBlob`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedInt`")){
        mysql_query("DROP TABLE `nssharedInt`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedString`")){
        mysql_query("DROP TABLE `nssharedString`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedCalendarTime`")){
        mysql_query("DROP TABLE `nssharedCalendarTime`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedFilePath`")){
        mysql_query("DROP TABLE `nssharedFilePath`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedFileName`")){
        mysql_query("DROP TABLE `nssharedFileName`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedURL`")){
        mysql_query("DROP TABLE `nssharedURL`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedImage`")){
        mysql_query("DROP TABLE `nssharedImage`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedErrorMessage`")){
        mysql_query("DROP TABLE `nssharedErrorMessage`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedinios`")){
        mysql_query("DROP TABLE `nssharedinios`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedinipopu`")){
        mysql_query("DROP TABLE `nssharedinipopu`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedimageurl`")){
        mysql_query("DROP TABLE `nssharedimageurl`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nsshareduploaded`")){
        mysql_query("DROP TABLE `nsshareduploaded`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedincludes`")){
        mysql_query("DROP TABLE `nssharedincludes`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedrrviols`")){
        mysql_query("DROP TABLE `nssharedrrviols`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedctxpats`")){
        mysql_query("DROP TABLE `nssharedctxpats`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedctxcs`")){
        mysql_query("DROP TABLE `nssharedctxcs`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedptrls`")){
        mysql_query("DROP TABLE `nssharedptrls`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedptgns`")){
        mysql_query("DROP TABLE `nssharedptgns`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedptdcs`")){
        mysql_query("DROP TABLE `nssharedptdcs`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedptxps`")){
        mysql_query("DROP TABLE `nssharedptxps`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedcptdf`")){
        mysql_query("DROP TABLE `nssharedcptdf`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedcptpurpose`")){
        mysql_query("DROP TABLE `nssharedcptpurpose`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nsshareddeclaredthrough`")){
        mysql_query("DROP TABLE `nsshareddeclaredthrough`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nsshareddecmean`")){
        mysql_query("DROP TABLE `nsshareddecmean`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nsshareddecpurpose`")){
        mysql_query("DROP TABLE `nsshareddecpurpose`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nsshareddecpopu`")){
        mysql_query("DROP TABLE `nsshareddecpopu`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedrels`")){
        mysql_query("DROP TABLE `nssharedrels`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedrrmean`")){
        mysql_query("DROP TABLE `nssharedrrmean`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `nssharedrrpurpose`")){
        mysql_query("DROP TABLE `nssharedrrpurpose`");
      }
    }
    /**************************************\
    * Plug nssharedConid                   *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * ctxnm~  [UNI,INJ,SUR]                *
    * ptnm~  [UNI,INJ,SUR]                 *
    * cptnm~  [UNI,INJ,SUR]                *
    * sourcefile  [UNI,TOT]                *
    * savepopulation  [UNI,TOT]            *
    * savecontext  [UNI,TOT]               *
    * countrules  [UNI]                    *
    * countdecls  [UNI]                    *
    * countcpts  [UNI]                     *
    * ptpic  [UNI]                         *
    * cptpic  [UNI]                        *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedConid`
                     ( `Conid` VARCHAR(255) DEFAULT NULL
                     , `ctxnm` VARCHAR(255) DEFAULT NULL
                     , `ptnm` VARCHAR(255) DEFAULT NULL
                     , `cptnm` VARCHAR(255) DEFAULT NULL
                     , `sourcefile` VARCHAR(255) DEFAULT NULL
                     , `savepopulation` VARCHAR(255) DEFAULT NULL
                     , `savecontext` VARCHAR(255) DEFAULT NULL
                     , `countrules` VARCHAR(255) DEFAULT NULL
                     , `countdecls` VARCHAR(255) DEFAULT NULL
                     , `countcpts` VARCHAR(255) DEFAULT NULL
                     , `ptpic` VARCHAR(255) DEFAULT NULL
                     , `cptpic` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedFile                    *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * AdlFile~  [INJ,SUR,UNI]              *
    * SavePopFile~  [INJ,SUR,UNI]          *
    * NewAdlFile~  [INJ,SUR,UNI]           *
    * SaveAdlFile~  [INJ,SUR,UNI]          *
    * compilererror  [UNI]                 *
    * filename  [UNI,TOT]                  *
    * filepath  [UNI]                      *
    * filetime  [UNI]                      *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedFile`
                     ( `File` VARCHAR(255) DEFAULT NULL
                     , `AdlFile` VARCHAR(255) DEFAULT NULL
                     , `SavePopFile` VARCHAR(255) DEFAULT NULL
                     , `NewAdlFile` VARCHAR(255) DEFAULT NULL
                     , `SaveAdlFile` VARCHAR(255) DEFAULT NULL
                     , `compilererror` BLOB DEFAULT NULL
                     , `filename` VARCHAR(255) DEFAULT NULL
                     , `filepath` VARCHAR(255) DEFAULT NULL
                     , `filetime` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedADLid                   *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * rrnm~  [UNI,INJ,SUR]                 *
    * PropertyRule~  [INJ,SUR,UNI]         *
    * rrpic  [UNI]                         *
    * rrexp  [UNI,TOT]                     *
    * decprps~  [UNI]                      *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedADLid`
                     ( `ADLid` VARCHAR(255) DEFAULT NULL
                     , `rrnm` VARCHAR(255) DEFAULT NULL
                     , `PropertyRule` VARCHAR(255) DEFAULT NULL
                     , `rrpic` VARCHAR(255) DEFAULT NULL
                     , `rrexp` VARCHAR(255) DEFAULT NULL
                     , `decprps` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedDeclaration             *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * decnm  [UNI,TOT]                     *
    * decsgn  [UNI,TOT]                    *
    * decprL  [UNI]                        *
    * decprM  [UNI]                        *
    * decprR  [UNI]                        *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedDeclaration`
                     ( `Declaration` VARCHAR(255) DEFAULT NULL
                     , `decnm` VARCHAR(255) DEFAULT NULL
                     , `decsgn` VARCHAR(255) DEFAULT NULL
                     , `decprL` VARCHAR(255) DEFAULT NULL
                     , `decprM` VARCHAR(255) DEFAULT NULL
                     , `decprR` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedRelation                *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * relnm  [UNI,TOT]                     *
    * relsgn  [UNI,TOT]                    *
    * reldcl  [UNI,TOT]                    *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedRelation`
                     ( `Relation` VARCHAR(255) DEFAULT NULL
                     , `relnm` VARCHAR(255) DEFAULT NULL
                     , `relsgn` VARCHAR(255) DEFAULT NULL
                     , `reldcl` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedG                       *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * applyto  [UNI,TOT]                   *
    * functionname  [UNI,TOT]              *
    * operation  [UNI,TOT]                 *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedG`
                     ( `G` VARCHAR(255) DEFAULT NULL
                     , `applyto` VARCHAR(255) DEFAULT NULL
                     , `functionname` VARCHAR(255) DEFAULT NULL
                     , `operation` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedPair                    *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * left  [UNI,TOT]                      *
    * right  [UNI,TOT]                     *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedPair`
                     ( `Pair` VARCHAR(255) DEFAULT NULL
                     , `left` VARCHAR(255) DEFAULT NULL
                     , `right` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedSign                    *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * src  [UNI,TOT]                       *
    * trg  [UNI,TOT]                       *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedSign`
                     ( `Sign` VARCHAR(255) DEFAULT NULL
                     , `src` VARCHAR(255) DEFAULT NULL
                     , `trg` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedGen                     *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * gengen  [UNI,TOT]                    *
    * genspc  [UNI,TOT]                    *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedGen`
                     ( `Gen` VARCHAR(255) DEFAULT NULL
                     , `gengen` VARCHAR(255) DEFAULT NULL
                     , `genspc` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedPairID                  *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * Violation~  [INJ,SUR,UNI]            *
    * pairvalue  [UNI,TOT]                 *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedPairID`
                     ( `PairID` VARCHAR(255) DEFAULT NULL
                     , `Violation` VARCHAR(255) DEFAULT NULL
                     , `pairvalue` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedAtomID                  *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * atomvalue  [UNI,TOT]                 *
    * cptos~  [UNI]                        *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedAtomID`
                     ( `AtomID` VARCHAR(255) DEFAULT NULL
                     , `atomvalue` BLOB DEFAULT NULL
                     , `cptos` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedExpressionID            *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * exprvalue  [UNI,TOT]                 *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedExpressionID`
                     ( `ExpressionID` VARCHAR(255) DEFAULT NULL
                     , `exprvalue` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedUser                    *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * newfile  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedUser`
                     ( `User` VARCHAR(255) DEFAULT NULL
                     , `newfile` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedExpression              *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedExpression`
                     ( `Expression` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedProperty                *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedProperty`
                     ( `Property` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedVarid                   *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedVarid`
                     ( `Varid` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedAtom                    *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedAtom`
                     ( `Atom` BLOB DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedBlob                    *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedBlob`
                     ( `Blob` BLOB DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedInt                     *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedInt`
                     ( `Int` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedString                  *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedString`
                     ( `String` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedCalendarTime            *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedCalendarTime`
                     ( `CalendarTime` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedFilePath                *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedFilePath`
                     ( `FilePath` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedFileName                *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedFileName`
                     ( `FileName` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedURL                     *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedURL`
                     ( `URL` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedImage                   *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedImage`
                     ( `Image` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nssharedErrorMessage            *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `nssharedErrorMessage`
                     ( `ErrorMessage` BLOB DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /************************\
    * Plug nssharedinios     *
    *                        *
    * fields:                *
    * I/\inios;inios~  [ASY] *
    * inios  []              *
    \************************/
    mysql_query("CREATE TABLE `nssharedinios`
                     ( `Concept` VARCHAR(255) DEFAULT NULL
                     , `AtomID` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /****************************\
    * Plug nssharedinipopu       *
    *                            *
    * fields:                    *
    * I/\inipopu;inipopu~  [ASY] *
    * inipopu  []                *
    \****************************/
    mysql_query("CREATE TABLE `nssharedinipopu`
                     ( `Declaration` VARCHAR(255) DEFAULT NULL
                     , `PairID` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /******************************\
    * Plug nssharedimageurl        *
    *                              *
    * fields:                      *
    * I/\imageurl;imageurl~  [ASY] *
    * imageurl  []                 *
    \******************************/
    mysql_query("CREATE TABLE `nssharedimageurl`
                     ( `Image` VARCHAR(255) DEFAULT NULL
                     , `URL` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /******************************\
    * Plug nsshareduploaded        *
    *                              *
    * fields:                      *
    * I/\uploaded;uploaded~  [ASY] *
    * uploaded  []                 *
    \******************************/
    mysql_query("CREATE TABLE `nsshareduploaded`
                     ( `User` VARCHAR(255) DEFAULT NULL
                     , `File` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /******************************\
    * Plug nssharedincludes        *
    *                              *
    * fields:                      *
    * I/\includes;includes~  [ASY] *
    * includes  []                 *
    \******************************/
    mysql_query("CREATE TABLE `nssharedincludes`
                     ( `Context` VARCHAR(255) DEFAULT NULL
                     , `File` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /****************************\
    * Plug nssharedrrviols       *
    *                            *
    * fields:                    *
    * I/\rrviols;rrviols~  [ASY] *
    * rrviols  []                *
    \****************************/
    mysql_query("CREATE TABLE `nssharedrrviols`
                     ( `Rule` VARCHAR(255) DEFAULT NULL
                     , `Violation` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /****************************\
    * Plug nssharedctxpats       *
    *                            *
    * fields:                    *
    * I/\ctxpats;ctxpats~  [ASY] *
    * ctxpats  []                *
    \****************************/
    mysql_query("CREATE TABLE `nssharedctxpats`
                     ( `Context` VARCHAR(255) DEFAULT NULL
                     , `Pattern` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /************************\
    * Plug nssharedctxcs     *
    *                        *
    * fields:                *
    * I/\ctxcs;ctxcs~  [ASY] *
    * ctxcs  []              *
    \************************/
    mysql_query("CREATE TABLE `nssharedctxcs`
                     ( `Context` VARCHAR(255) DEFAULT NULL
                     , `Concept` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /************************\
    * Plug nssharedptrls     *
    *                        *
    * fields:                *
    * I/\ptrls;ptrls~  [ASY] *
    * ptrls  []              *
    \************************/
    mysql_query("CREATE TABLE `nssharedptrls`
                     ( `Pattern` VARCHAR(255) DEFAULT NULL
                     , `Rule` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /************************\
    * Plug nssharedptgns     *
    *                        *
    * fields:                *
    * I/\ptgns;ptgns~  [ASY] *
    * ptgns  []              *
    \************************/
    mysql_query("CREATE TABLE `nssharedptgns`
                     ( `Pattern` VARCHAR(255) DEFAULT NULL
                     , `Gen` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /************************\
    * Plug nssharedptdcs     *
    *                        *
    * fields:                *
    * I/\ptdcs;ptdcs~  [ASY] *
    * ptdcs  []              *
    \************************/
    mysql_query("CREATE TABLE `nssharedptdcs`
                     ( `Pattern` VARCHAR(255) DEFAULT NULL
                     , `Declaration` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /************************\
    * Plug nssharedptxps     *
    *                        *
    * fields:                *
    * I/\ptxps;ptxps~  [ASY] *
    * ptxps  []              *
    \************************/
    mysql_query("CREATE TABLE `nssharedptxps`
                     ( `Pattern` VARCHAR(255) DEFAULT NULL
                     , `Blob` BLOB DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /************************\
    * Plug nssharedcptdf     *
    *                        *
    * fields:                *
    * I/\cptdf;cptdf~  [ASY] *
    * cptdf  []              *
    \************************/
    mysql_query("CREATE TABLE `nssharedcptdf`
                     ( `Concept` VARCHAR(255) DEFAULT NULL
                     , `Blob` BLOB DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**********************************\
    * Plug nssharedcptpurpose          *
    *                                  *
    * fields:                          *
    * I/\cptpurpose;cptpurpose~  [ASY] *
    * cptpurpose  []                   *
    \**********************************/
    mysql_query("CREATE TABLE `nssharedcptpurpose`
                     ( `Concept` VARCHAR(255) DEFAULT NULL
                     , `Blob` BLOB DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug nsshareddeclaredthrough         *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * declaredthrough  [TOT]               *
    \**************************************/
    mysql_query("CREATE TABLE `nsshareddeclaredthrough`
                     ( `PropertyRule` VARCHAR(255) DEFAULT NULL
                     , `Property` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /****************************\
    * Plug nsshareddecmean       *
    *                            *
    * fields:                    *
    * I/\decmean;decmean~  [ASY] *
    * decmean  []                *
    \****************************/
    mysql_query("CREATE TABLE `nsshareddecmean`
                     ( `Declaration` VARCHAR(255) DEFAULT NULL
                     , `Blob` BLOB DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**********************************\
    * Plug nsshareddecpurpose          *
    *                                  *
    * fields:                          *
    * I/\decpurpose;decpurpose~  [ASY] *
    * decpurpose  []                   *
    \**********************************/
    mysql_query("CREATE TABLE `nsshareddecpurpose`
                     ( `Declaration` VARCHAR(255) DEFAULT NULL
                     , `Blob` BLOB DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /****************************\
    * Plug nsshareddecpopu       *
    *                            *
    * fields:                    *
    * I/\decpopu;decpopu~  [ASY] *
    * decpopu  []                *
    \****************************/
    mysql_query("CREATE TABLE `nsshareddecpopu`
                     ( `Declaration` VARCHAR(255) DEFAULT NULL
                     , `PairID` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**********************\
    * Plug nssharedrels    *
    *                      *
    * fields:              *
    * I/\rels;rels~  [ASY] *
    * rels  []             *
    \**********************/
    mysql_query("CREATE TABLE `nssharedrels`
                     ( `ExpressionID` VARCHAR(255) DEFAULT NULL
                     , `Relation` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************\
    * Plug nssharedrrmean      *
    *                          *
    * fields:                  *
    * I/\rrmean;rrmean~  [ASY] *
    * rrmean  []               *
    \**************************/
    mysql_query("CREATE TABLE `nssharedrrmean`
                     ( `Rule` VARCHAR(255) DEFAULT NULL
                     , `Blob` BLOB DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /********************************\
    * Plug nssharedrrpurpose         *
    *                                *
    * fields:                        *
    * I/\rrpurpose;rrpurpose~  [ASY] *
    * rrpurpose  []                  *
    \********************************/
    mysql_query("CREATE TABLE `nssharedrrpurpose`
                     ( `Rule` VARCHAR(255) DEFAULT NULL
                     , `Blob` BLOB DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    mysql_query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
    if ($err=='') {
      echo '<div id="ResetSuccess"/>The database has been reset to its initial population.<br/><br/><button onclick="window.location.href = document.referrer;">Ok</button>';
      $content = '
      <?php
      require "Generics.php";
      require "php/DatabaseUtils.php";
      $dumpfile = fopen("dbdump.adl","w");
      fwrite($dumpfile, "CONTEXT Atlas\n");
      fwrite($dumpfile, dumprel("inios[Concept*AtomID]","SELECT DISTINCT `Concept`, `AtomID` FROM `nssharedinios` WHERE `Concept` IS NOT NULL AND `AtomID` IS NOT NULL"));
      fwrite($dumpfile, dumprel("inipopu[Declaration*PairID]","SELECT DISTINCT `Declaration`, `PairID` FROM `nssharedinipopu` WHERE `Declaration` IS NOT NULL AND `PairID` IS NOT NULL"));
      fwrite($dumpfile, dumprel("compilererror[File*ErrorMessage]","SELECT DISTINCT `File`, `compilererror` FROM `nssharedFile` WHERE `File` IS NOT NULL AND `compilererror` IS NOT NULL"));
      fwrite($dumpfile, dumprel("imageurl[Image*URL]","SELECT DISTINCT `Image`, `URL` FROM `nssharedimageurl` WHERE `Image` IS NOT NULL AND `URL` IS NOT NULL"));
      fwrite($dumpfile, dumprel("filename[File*FileName]","SELECT DISTINCT `File`, `filename` FROM `nssharedFile` WHERE `File` IS NOT NULL AND `filename` IS NOT NULL"));
      fwrite($dumpfile, dumprel("filepath[File*FilePath]","SELECT DISTINCT `File`, `filepath` FROM `nssharedFile` WHERE `File` IS NOT NULL AND `filepath` IS NOT NULL"));
      fwrite($dumpfile, dumprel("filetime[File*CalendarTime]","SELECT DISTINCT `File`, `filetime` FROM `nssharedFile` WHERE `File` IS NOT NULL AND `filetime` IS NOT NULL"));
      fwrite($dumpfile, dumprel("uploaded[User*File]","SELECT DISTINCT `User`, `File` FROM `nsshareduploaded` WHERE `User` IS NOT NULL AND `File` IS NOT NULL"));
      fwrite($dumpfile, dumprel("sourcefile[Context*AdlFile]","SELECT DISTINCT `ctxnm`, `sourcefile` FROM `nssharedConid` WHERE `ctxnm` IS NOT NULL AND `sourcefile` IS NOT NULL"));
      fwrite($dumpfile, dumprel("includes[Context*File]","SELECT DISTINCT `Context`, `File` FROM `nssharedincludes` WHERE `Context` IS NOT NULL AND `File` IS NOT NULL"));
      fwrite($dumpfile, dumprel("applyto[G*AdlFile]","SELECT DISTINCT `G`, `applyto` FROM `nssharedG` WHERE `G` IS NOT NULL AND `applyto` IS NOT NULL"));
      fwrite($dumpfile, dumprel("functionname[G*String]","SELECT DISTINCT `G`, `functionname` FROM `nssharedG` WHERE `G` IS NOT NULL AND `functionname` IS NOT NULL"));
      fwrite($dumpfile, dumprel("operation[G*Int]","SELECT DISTINCT `G`, `operation` FROM `nssharedG` WHERE `G` IS NOT NULL AND `operation` IS NOT NULL"));
      fwrite($dumpfile, dumprel("newfile[User*NewAdlFile]","SELECT DISTINCT `User`, `newfile` FROM `nssharedUser` WHERE `User` IS NOT NULL AND `newfile` IS NOT NULL"));
      fwrite($dumpfile, dumprel("savepopulation[Context*SavePopFile]","SELECT DISTINCT `ctxnm`, `savepopulation` FROM `nssharedConid` WHERE `ctxnm` IS NOT NULL AND `savepopulation` IS NOT NULL"));
      fwrite($dumpfile, dumprel("savecontext[Context*SaveAdlFile]","SELECT DISTINCT `ctxnm`, `savecontext` FROM `nssharedConid` WHERE `ctxnm` IS NOT NULL AND `savecontext` IS NOT NULL"));
      fwrite($dumpfile, dumprel("countrules[Context*Int]","SELECT DISTINCT `ctxnm`, `countrules` FROM `nssharedConid` WHERE `ctxnm` IS NOT NULL AND `countrules` IS NOT NULL"));
      fwrite($dumpfile, dumprel("countdecls[Context*Int]","SELECT DISTINCT `ctxnm`, `countdecls` FROM `nssharedConid` WHERE `ctxnm` IS NOT NULL AND `countdecls` IS NOT NULL"));
      fwrite($dumpfile, dumprel("countcpts[Context*Int]","SELECT DISTINCT `ctxnm`, `countcpts` FROM `nssharedConid` WHERE `ctxnm` IS NOT NULL AND `countcpts` IS NOT NULL"));
      fwrite($dumpfile, dumprel("ptpic[Pattern*Image]","SELECT DISTINCT `ptnm`, `ptpic` FROM `nssharedConid` WHERE `ptnm` IS NOT NULL AND `ptpic` IS NOT NULL"));
      fwrite($dumpfile, dumprel("cptpic[Concept*Image]","SELECT DISTINCT `cptnm`, `cptpic` FROM `nssharedConid` WHERE `cptnm` IS NOT NULL AND `cptpic` IS NOT NULL"));
      fwrite($dumpfile, dumprel("rrpic[Rule*Image]","SELECT DISTINCT `rrnm`, `rrpic` FROM `nssharedADLid` WHERE `rrnm` IS NOT NULL AND `rrpic` IS NOT NULL"));
      fwrite($dumpfile, dumprel("rrviols[Rule*Violation]","SELECT DISTINCT `Rule`, `Violation` FROM `nssharedrrviols` WHERE `Rule` IS NOT NULL AND `Violation` IS NOT NULL"));
      fwrite($dumpfile, dumprel("ctxnm[Context*Conid]","SELECT DISTINCT `ctxnm`, `Conid` FROM `nssharedConid` WHERE `ctxnm` IS NOT NULL AND `Conid` IS NOT NULL"));
      fwrite($dumpfile, dumprel("ctxpats[Context*Pattern]","SELECT DISTINCT `Context`, `Pattern` FROM `nssharedctxpats` WHERE `Context` IS NOT NULL AND `Pattern` IS NOT NULL"));
      fwrite($dumpfile, dumprel("ctxcs[Context*Concept]","SELECT DISTINCT `Context`, `Concept` FROM `nssharedctxcs` WHERE `Context` IS NOT NULL AND `Concept` IS NOT NULL"));
      fwrite($dumpfile, dumprel("ptnm[Pattern*Conid]","SELECT DISTINCT `ptnm`, `Conid` FROM `nssharedConid` WHERE `ptnm` IS NOT NULL AND `Conid` IS NOT NULL"));
      fwrite($dumpfile, dumprel("ptrls[Pattern*Rule]","SELECT DISTINCT `Pattern`, `Rule` FROM `nssharedptrls` WHERE `Pattern` IS NOT NULL AND `Rule` IS NOT NULL"));
      fwrite($dumpfile, dumprel("ptgns[Pattern*Gen]","SELECT DISTINCT `Pattern`, `Gen` FROM `nssharedptgns` WHERE `Pattern` IS NOT NULL AND `Gen` IS NOT NULL"));
      fwrite($dumpfile, dumprel("ptdcs[Pattern*Declaration]","SELECT DISTINCT `Pattern`, `Declaration` FROM `nssharedptdcs` WHERE `Pattern` IS NOT NULL AND `Declaration` IS NOT NULL"));
      fwrite($dumpfile, dumprel("ptxps[Pattern*Blob]","SELECT DISTINCT `Pattern`, `Blob` FROM `nssharedptxps` WHERE `Pattern` IS NOT NULL AND `Blob` IS NOT NULL"));
      fwrite($dumpfile, dumprel("gengen[Gen*Concept]","SELECT DISTINCT `Gen`, `gengen` FROM `nssharedGen` WHERE `Gen` IS NOT NULL AND `gengen` IS NOT NULL"));
      fwrite($dumpfile, dumprel("genspc[Gen*Concept]","SELECT DISTINCT `Gen`, `genspc` FROM `nssharedGen` WHERE `Gen` IS NOT NULL AND `genspc` IS NOT NULL"));
      fwrite($dumpfile, dumprel("cptnm[Concept*Conid]","SELECT DISTINCT `cptnm`, `Conid` FROM `nssharedConid` WHERE `cptnm` IS NOT NULL AND `Conid` IS NOT NULL"));
      fwrite($dumpfile, dumprel("cptos[Concept*AtomID]","SELECT DISTINCT `cptos`, `AtomID` FROM `nssharedAtomID` WHERE `cptos` IS NOT NULL AND `AtomID` IS NOT NULL"));
      fwrite($dumpfile, dumprel("cptdf[Concept*Blob]","SELECT DISTINCT `Concept`, `Blob` FROM `nssharedcptdf` WHERE `Concept` IS NOT NULL AND `Blob` IS NOT NULL"));
      fwrite($dumpfile, dumprel("cptpurpose[Concept*Blob]","SELECT DISTINCT `Concept`, `Blob` FROM `nssharedcptpurpose` WHERE `Concept` IS NOT NULL AND `Blob` IS NOT NULL"));
      fwrite($dumpfile, dumprel("atomvalue[AtomID*Atom]","SELECT DISTINCT `AtomID`, `atomvalue` FROM `nssharedAtomID` WHERE `AtomID` IS NOT NULL AND `atomvalue` IS NOT NULL"));
      fwrite($dumpfile, dumprel("src[Sign*Concept]","SELECT DISTINCT `Sign`, `src` FROM `nssharedSign` WHERE `Sign` IS NOT NULL AND `src` IS NOT NULL"));
      fwrite($dumpfile, dumprel("trg[Sign*Concept]","SELECT DISTINCT `Sign`, `trg` FROM `nssharedSign` WHERE `Sign` IS NOT NULL AND `trg` IS NOT NULL"));
      fwrite($dumpfile, dumprel("pairvalue[PairID*Pair]","SELECT DISTINCT `PairID`, `pairvalue` FROM `nssharedPairID` WHERE `PairID` IS NOT NULL AND `pairvalue` IS NOT NULL"));
      fwrite($dumpfile, dumprel("left[Pair*AtomID]","SELECT DISTINCT `Pair`, `left` FROM `nssharedPair` WHERE `Pair` IS NOT NULL AND `left` IS NOT NULL"));
      fwrite($dumpfile, dumprel("right[Pair*AtomID]","SELECT DISTINCT `Pair`, `right` FROM `nssharedPair` WHERE `Pair` IS NOT NULL AND `right` IS NOT NULL"));
      fwrite($dumpfile, dumprel("decnm[Declaration*Varid]","SELECT DISTINCT `Declaration`, `decnm` FROM `nssharedDeclaration` WHERE `Declaration` IS NOT NULL AND `decnm` IS NOT NULL"));
      fwrite($dumpfile, dumprel("decsgn[Declaration*Sign]","SELECT DISTINCT `Declaration`, `decsgn` FROM `nssharedDeclaration` WHERE `Declaration` IS NOT NULL AND `decsgn` IS NOT NULL"));
      fwrite($dumpfile, dumprel("decprps[Declaration*PropertyRule]","SELECT DISTINCT `decprps`, `PropertyRule` FROM `nssharedADLid` WHERE `decprps` IS NOT NULL AND `PropertyRule` IS NOT NULL"));
      fwrite($dumpfile, dumprel("declaredthrough[PropertyRule*Property]","SELECT DISTINCT `PropertyRule`, `Property` FROM `nsshareddeclaredthrough` WHERE `PropertyRule` IS NOT NULL AND `Property` IS NOT NULL"));
      fwrite($dumpfile, dumprel("decprL[Declaration*String]","SELECT DISTINCT `Declaration`, `decprL` FROM `nssharedDeclaration` WHERE `Declaration` IS NOT NULL AND `decprL` IS NOT NULL"));
      fwrite($dumpfile, dumprel("decprM[Declaration*String]","SELECT DISTINCT `Declaration`, `decprM` FROM `nssharedDeclaration` WHERE `Declaration` IS NOT NULL AND `decprM` IS NOT NULL"));
      fwrite($dumpfile, dumprel("decprR[Declaration*String]","SELECT DISTINCT `Declaration`, `decprR` FROM `nssharedDeclaration` WHERE `Declaration` IS NOT NULL AND `decprR` IS NOT NULL"));
      fwrite($dumpfile, dumprel("decmean[Declaration*Blob]","SELECT DISTINCT `Declaration`, `Blob` FROM `nsshareddecmean` WHERE `Declaration` IS NOT NULL AND `Blob` IS NOT NULL"));
      fwrite($dumpfile, dumprel("decpurpose[Declaration*Blob]","SELECT DISTINCT `Declaration`, `Blob` FROM `nsshareddecpurpose` WHERE `Declaration` IS NOT NULL AND `Blob` IS NOT NULL"));
      fwrite($dumpfile, dumprel("decpopu[Declaration*PairID]","SELECT DISTINCT `Declaration`, `PairID` FROM `nsshareddecpopu` WHERE `Declaration` IS NOT NULL AND `PairID` IS NOT NULL"));
      fwrite($dumpfile, dumprel("exprvalue[ExpressionID*Expression]","SELECT DISTINCT `ExpressionID`, `exprvalue` FROM `nssharedExpressionID` WHERE `ExpressionID` IS NOT NULL AND `exprvalue` IS NOT NULL"));
      fwrite($dumpfile, dumprel("rels[ExpressionID*Relation]","SELECT DISTINCT `ExpressionID`, `Relation` FROM `nssharedrels` WHERE `ExpressionID` IS NOT NULL AND `Relation` IS NOT NULL"));
      fwrite($dumpfile, dumprel("relnm[Relation*Varid]","SELECT DISTINCT `Relation`, `relnm` FROM `nssharedRelation` WHERE `Relation` IS NOT NULL AND `relnm` IS NOT NULL"));
      fwrite($dumpfile, dumprel("relsgn[Relation*Sign]","SELECT DISTINCT `Relation`, `relsgn` FROM `nssharedRelation` WHERE `Relation` IS NOT NULL AND `relsgn` IS NOT NULL"));
      fwrite($dumpfile, dumprel("reldcl[Relation*Declaration]","SELECT DISTINCT `Relation`, `reldcl` FROM `nssharedRelation` WHERE `Relation` IS NOT NULL AND `reldcl` IS NOT NULL"));
      fwrite($dumpfile, dumprel("rrnm[Rule*ADLid]","SELECT DISTINCT `rrnm`, `ADLid` FROM `nssharedADLid` WHERE `rrnm` IS NOT NULL AND `ADLid` IS NOT NULL"));
      fwrite($dumpfile, dumprel("rrexp[Rule*ExpressionID]","SELECT DISTINCT `rrnm`, `rrexp` FROM `nssharedADLid` WHERE `rrnm` IS NOT NULL AND `rrexp` IS NOT NULL"));
      fwrite($dumpfile, dumprel("rrmean[Rule*Blob]","SELECT DISTINCT `Rule`, `Blob` FROM `nssharedrrmean` WHERE `Rule` IS NOT NULL AND `Blob` IS NOT NULL"));
      fwrite($dumpfile, dumprel("rrpurpose[Rule*Blob]","SELECT DISTINCT `Rule`, `Blob` FROM `nssharedrrpurpose` WHERE `Rule` IS NOT NULL AND `Blob` IS NOT NULL"));
      fwrite($dumpfile, "ENDCONTEXT");
      fclose($dumpfile);
      
      function dumprel ($rel,$quer)
      {
        $rows = DB_doquer($quer);
        $pop = "";
        foreach ($rows as $row)
          $pop = $pop.";(\"".escapedoublequotes($row[0])."\",\"".escapedoublequotes($row[1])."\")\n  ";
        return "POPULATION ".$rel." CONTAINS\n  [".substr($pop,1)."]\n";
      }
      function escapedoublequotes($str) { return str_replace("\"","\\\\\\"",$str); }
      ?>';
      file_put_contents("dbdump.php.",$content);
    }
  }
  
?></body></html>
