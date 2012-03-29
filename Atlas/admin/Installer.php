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
  if($DB_slct = @mysql_select_db('rap')){
    $existing=true;
  }else{
    $existing = false; // db does not exist, so try to create it
    @mysql_query("CREATE DATABASE `rap` DEFAULT CHARACTER SET UTF8");
    $DB_slct = @mysql_select_db('rap');
  }
  if(!$DB_slct){
    echo die("Install failed: cannot connect to MySQL or error selecting database 'rap'");
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
    
    //// Number of plugs: 46
    if($existing==true){
      if($columns = mysql_query("SHOW COLUMNS FROM `Conid`")){
        mysql_query("DROP TABLE `Conid`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `File`")){
        mysql_query("DROP TABLE `File`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `ADLid`")){
        mysql_query("DROP TABLE `ADLid`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Declaration`")){
        mysql_query("DROP TABLE `Declaration`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Relation`")){
        mysql_query("DROP TABLE `Relation`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `G`")){
        mysql_query("DROP TABLE `G`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Pair`")){
        mysql_query("DROP TABLE `Pair`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Sign`")){
        mysql_query("DROP TABLE `Sign`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Gen`")){
        mysql_query("DROP TABLE `Gen`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `PairID`")){
        mysql_query("DROP TABLE `PairID`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `AtomID`")){
        mysql_query("DROP TABLE `AtomID`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `ExpressionID`")){
        mysql_query("DROP TABLE `ExpressionID`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `User`")){
        mysql_query("DROP TABLE `User`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Expression`")){
        mysql_query("DROP TABLE `Expression`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Property`")){
        mysql_query("DROP TABLE `Property`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Varid`")){
        mysql_query("DROP TABLE `Varid`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Atom`")){
        mysql_query("DROP TABLE `Atom`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Blob`")){
        mysql_query("DROP TABLE `Blob`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Int`")){
        mysql_query("DROP TABLE `Int`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `String`")){
        mysql_query("DROP TABLE `String`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `FilePath`")){
        mysql_query("DROP TABLE `FilePath`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `FileName`")){
        mysql_query("DROP TABLE `FileName`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `URL`")){
        mysql_query("DROP TABLE `URL`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Image`")){
        mysql_query("DROP TABLE `Image`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `ErrorMessage`")){
        mysql_query("DROP TABLE `ErrorMessage`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `inios`")){
        mysql_query("DROP TABLE `inios`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `inipopu`")){
        mysql_query("DROP TABLE `inipopu`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `imageurl`")){
        mysql_query("DROP TABLE `imageurl`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `uploaded`")){
        mysql_query("DROP TABLE `uploaded`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `includes`")){
        mysql_query("DROP TABLE `includes`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `rrviols`")){
        mysql_query("DROP TABLE `rrviols`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `ctxpats`")){
        mysql_query("DROP TABLE `ctxpats`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `ctxcs`")){
        mysql_query("DROP TABLE `ctxcs`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `ptrls`")){
        mysql_query("DROP TABLE `ptrls`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `ptgns`")){
        mysql_query("DROP TABLE `ptgns`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `ptdcs`")){
        mysql_query("DROP TABLE `ptdcs`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `ptxps`")){
        mysql_query("DROP TABLE `ptxps`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `cptdf`")){
        mysql_query("DROP TABLE `cptdf`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `cptpurpose`")){
        mysql_query("DROP TABLE `cptpurpose`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `declaredthrough`")){
        mysql_query("DROP TABLE `declaredthrough`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `decmean`")){
        mysql_query("DROP TABLE `decmean`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `decpurpose`")){
        mysql_query("DROP TABLE `decpurpose`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `decpopu`")){
        mysql_query("DROP TABLE `decpopu`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `rels`")){
        mysql_query("DROP TABLE `rels`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `rrmean`")){
        mysql_query("DROP TABLE `rrmean`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `rrpurpose`")){
        mysql_query("DROP TABLE `rrpurpose`");
      }
    }
    /**************************************\
    * Plug Conid                           *
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
    mysql_query("CREATE TABLE `Conid`
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
    * Plug File                            *
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
    \**************************************/
    mysql_query("CREATE TABLE `File`
                     ( `File` VARCHAR(255) DEFAULT NULL
                     , `AdlFile` VARCHAR(255) DEFAULT NULL
                     , `SavePopFile` VARCHAR(255) DEFAULT NULL
                     , `NewAdlFile` VARCHAR(255) DEFAULT NULL
                     , `SaveAdlFile` VARCHAR(255) DEFAULT NULL
                     , `compilererror` BLOB DEFAULT NULL
                     , `filename` VARCHAR(255) DEFAULT NULL
                     , `filepath` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug ADLid                           *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * rrnm~  [UNI,INJ,SUR]                 *
    * PropertyRule~  [INJ,SUR,UNI]         *
    * rrpic  [UNI]                         *
    * rrexp  [UNI,TOT]                     *
    * decprps~  [UNI]                      *
    \**************************************/
    mysql_query("CREATE TABLE `ADLid`
                     ( `ADLid` VARCHAR(255) DEFAULT NULL
                     , `rrnm` VARCHAR(255) DEFAULT NULL
                     , `PropertyRule` VARCHAR(255) DEFAULT NULL
                     , `rrpic` VARCHAR(255) DEFAULT NULL
                     , `rrexp` VARCHAR(255) DEFAULT NULL
                     , `decprps` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Declaration                     *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * decnm  [UNI,TOT]                     *
    * decsgn  [UNI,TOT]                    *
    * decprL  [UNI]                        *
    * decprM  [UNI]                        *
    * decprR  [UNI]                        *
    \**************************************/
    mysql_query("CREATE TABLE `Declaration`
                     ( `Declaration` VARCHAR(255) DEFAULT NULL
                     , `decnm` VARCHAR(255) DEFAULT NULL
                     , `decsgn` VARCHAR(255) DEFAULT NULL
                     , `decprL` VARCHAR(255) DEFAULT NULL
                     , `decprM` VARCHAR(255) DEFAULT NULL
                     , `decprR` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Relation                        *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * relnm  [UNI,TOT]                     *
    * relsgn  [UNI,TOT]                    *
    * reldcl  [UNI,TOT]                    *
    \**************************************/
    mysql_query("CREATE TABLE `Relation`
                     ( `Relation` VARCHAR(255) DEFAULT NULL
                     , `relnm` VARCHAR(255) DEFAULT NULL
                     , `relsgn` VARCHAR(255) DEFAULT NULL
                     , `reldcl` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug G                               *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * applyto  [UNI,TOT]                   *
    * functionname  [UNI,TOT]              *
    * operation  [UNI,TOT]                 *
    \**************************************/
    mysql_query("CREATE TABLE `G`
                     ( `G` VARCHAR(255) DEFAULT NULL
                     , `applyto` VARCHAR(255) DEFAULT NULL
                     , `functionname` VARCHAR(255) DEFAULT NULL
                     , `operation` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Pair                            *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * left  [UNI,TOT]                      *
    * right  [UNI,TOT]                     *
    \**************************************/
    mysql_query("CREATE TABLE `Pair`
                     ( `Pair` VARCHAR(255) DEFAULT NULL
                     , `left` VARCHAR(255) DEFAULT NULL
                     , `right` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Sign                            *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * src  [UNI,TOT]                       *
    * trg  [UNI,TOT]                       *
    \**************************************/
    mysql_query("CREATE TABLE `Sign`
                     ( `Sign` VARCHAR(255) DEFAULT NULL
                     , `src` VARCHAR(255) DEFAULT NULL
                     , `trg` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Gen                             *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * gengen  [UNI,TOT]                    *
    * genspc  [UNI,TOT]                    *
    \**************************************/
    mysql_query("CREATE TABLE `Gen`
                     ( `Gen` VARCHAR(255) DEFAULT NULL
                     , `gengen` VARCHAR(255) DEFAULT NULL
                     , `genspc` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug PairID                          *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * Violation~  [INJ,SUR,UNI]            *
    * pairvalue  [UNI,TOT]                 *
    \**************************************/
    mysql_query("CREATE TABLE `PairID`
                     ( `PairID` VARCHAR(255) DEFAULT NULL
                     , `Violation` VARCHAR(255) DEFAULT NULL
                     , `pairvalue` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug AtomID                          *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * atomvalue  [UNI,TOT]                 *
    * cptos~  [UNI]                        *
    \**************************************/
    mysql_query("CREATE TABLE `AtomID`
                     ( `AtomID` VARCHAR(255) DEFAULT NULL
                     , `atomvalue` BLOB DEFAULT NULL
                     , `cptos` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug ExpressionID                    *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * exprvalue  [UNI,TOT]                 *
    \**************************************/
    mysql_query("CREATE TABLE `ExpressionID`
                     ( `ExpressionID` VARCHAR(255) DEFAULT NULL
                     , `exprvalue` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug User                            *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * newfile  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `User`
                     ( `User` VARCHAR(255) DEFAULT NULL
                     , `newfile` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Expression                      *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Expression`
                     ( `Expression` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Property                        *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Property`
                     ( `Property` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `Property` (`Property` )
                VALUES ('PROP')
                      , ('TRN')
                      , ('ASY')
                      , ('SYM')
                      , ('IRF')
                      , ('RFX')
                      , ('SUR')
                      , ('INJ')
                      , ('TOT')
                      , ('UNI')
                      , ('->')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Varid                           *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Varid`
                     ( `Varid` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Atom                            *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Atom`
                     ( `Atom` BLOB DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Blob                            *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Blob`
                     ( `Blob` BLOB DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Int                             *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Int`
                     ( `Int` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug String                          *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `String`
                     ( `String` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug FilePath                        *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `FilePath`
                     ( `FilePath` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug FileName                        *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `FileName`
                     ( `FileName` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug URL                             *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `URL`
                     ( `URL` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Image                           *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Image`
                     ( `Image` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug ErrorMessage                    *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `ErrorMessage`
                     ( `ErrorMessage` BLOB DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /************************\
    * Plug inios             *
    *                        *
    * fields:                *
    * I/\inios;inios~  [ASY] *
    * inios  []              *
    \************************/
    mysql_query("CREATE TABLE `inios`
                     ( `Concept` VARCHAR(255) DEFAULT NULL
                     , `AtomID` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /****************************\
    * Plug inipopu               *
    *                            *
    * fields:                    *
    * I/\inipopu;inipopu~  [ASY] *
    * inipopu  []                *
    \****************************/
    mysql_query("CREATE TABLE `inipopu`
                     ( `Declaration` VARCHAR(255) DEFAULT NULL
                     , `PairID` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /******************************\
    * Plug imageurl                *
    *                              *
    * fields:                      *
    * I/\imageurl;imageurl~  [ASY] *
    * imageurl  []                 *
    \******************************/
    mysql_query("CREATE TABLE `imageurl`
                     ( `Image` VARCHAR(255) DEFAULT NULL
                     , `URL` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /******************************\
    * Plug uploaded                *
    *                              *
    * fields:                      *
    * I/\uploaded;uploaded~  [ASY] *
    * uploaded  []                 *
    \******************************/
    mysql_query("CREATE TABLE `uploaded`
                     ( `User` VARCHAR(255) DEFAULT NULL
                     , `File` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /******************************\
    * Plug includes                *
    *                              *
    * fields:                      *
    * I/\includes;includes~  [ASY] *
    * includes  []                 *
    \******************************/
    mysql_query("CREATE TABLE `includes`
                     ( `Context` VARCHAR(255) DEFAULT NULL
                     , `File` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /****************************\
    * Plug rrviols               *
    *                            *
    * fields:                    *
    * I/\rrviols;rrviols~  [ASY] *
    * rrviols  []                *
    \****************************/
    mysql_query("CREATE TABLE `rrviols`
                     ( `Rule` VARCHAR(255) DEFAULT NULL
                     , `Violation` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /****************************\
    * Plug ctxpats               *
    *                            *
    * fields:                    *
    * I/\ctxpats;ctxpats~  [ASY] *
    * ctxpats  []                *
    \****************************/
    mysql_query("CREATE TABLE `ctxpats`
                     ( `Context` VARCHAR(255) DEFAULT NULL
                     , `Pattern` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /************************\
    * Plug ctxcs             *
    *                        *
    * fields:                *
    * I/\ctxcs;ctxcs~  [ASY] *
    * ctxcs  []              *
    \************************/
    mysql_query("CREATE TABLE `ctxcs`
                     ( `Context` VARCHAR(255) DEFAULT NULL
                     , `Concept` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /************************\
    * Plug ptrls             *
    *                        *
    * fields:                *
    * I/\ptrls;ptrls~  [ASY] *
    * ptrls  []              *
    \************************/
    mysql_query("CREATE TABLE `ptrls`
                     ( `Pattern` VARCHAR(255) DEFAULT NULL
                     , `Rule` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /************************\
    * Plug ptgns             *
    *                        *
    * fields:                *
    * I/\ptgns;ptgns~  [ASY] *
    * ptgns  []              *
    \************************/
    mysql_query("CREATE TABLE `ptgns`
                     ( `Pattern` VARCHAR(255) DEFAULT NULL
                     , `Gen` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /************************\
    * Plug ptdcs             *
    *                        *
    * fields:                *
    * I/\ptdcs;ptdcs~  [ASY] *
    * ptdcs  []              *
    \************************/
    mysql_query("CREATE TABLE `ptdcs`
                     ( `Pattern` VARCHAR(255) DEFAULT NULL
                     , `Declaration` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /************************\
    * Plug ptxps             *
    *                        *
    * fields:                *
    * I/\ptxps;ptxps~  [ASY] *
    * ptxps  []              *
    \************************/
    mysql_query("CREATE TABLE `ptxps`
                     ( `Pattern` VARCHAR(255) DEFAULT NULL
                     , `Blob` BLOB DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /************************\
    * Plug cptdf             *
    *                        *
    * fields:                *
    * I/\cptdf;cptdf~  [ASY] *
    * cptdf  []              *
    \************************/
    mysql_query("CREATE TABLE `cptdf`
                     ( `Concept` VARCHAR(255) DEFAULT NULL
                     , `Blob` BLOB DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**********************************\
    * Plug cptpurpose                  *
    *                                  *
    * fields:                          *
    * I/\cptpurpose;cptpurpose~  [ASY] *
    * cptpurpose  []                   *
    \**********************************/
    mysql_query("CREATE TABLE `cptpurpose`
                     ( `Concept` VARCHAR(255) DEFAULT NULL
                     , `Blob` BLOB DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug declaredthrough                 *
    *                                      *
    * fields:                              *
    * I  [UNI,TOT,INJ,SUR,SYM,ASY,TRN,RFX] *
    * declaredthrough  [TOT]               *
    \**************************************/
    mysql_query("CREATE TABLE `declaredthrough`
                     ( `PropertyRule` VARCHAR(255) DEFAULT NULL
                     , `Property` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /****************************\
    * Plug decmean               *
    *                            *
    * fields:                    *
    * I/\decmean;decmean~  [ASY] *
    * decmean  []                *
    \****************************/
    mysql_query("CREATE TABLE `decmean`
                     ( `Declaration` VARCHAR(255) DEFAULT NULL
                     , `Blob` BLOB DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**********************************\
    * Plug decpurpose                  *
    *                                  *
    * fields:                          *
    * I/\decpurpose;decpurpose~  [ASY] *
    * decpurpose  []                   *
    \**********************************/
    mysql_query("CREATE TABLE `decpurpose`
                     ( `Declaration` VARCHAR(255) DEFAULT NULL
                     , `Blob` BLOB DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /****************************\
    * Plug decpopu               *
    *                            *
    * fields:                    *
    * I/\decpopu;decpopu~  [ASY] *
    * decpopu  []                *
    \****************************/
    mysql_query("CREATE TABLE `decpopu`
                     ( `Declaration` VARCHAR(255) DEFAULT NULL
                     , `PairID` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**********************\
    * Plug rels            *
    *                      *
    * fields:              *
    * I/\rels;rels~  [ASY] *
    * rels  []             *
    \**********************/
    mysql_query("CREATE TABLE `rels`
                     ( `ExpressionID` VARCHAR(255) DEFAULT NULL
                     , `Relation` VARCHAR(255) DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************\
    * Plug rrmean              *
    *                          *
    * fields:                  *
    * I/\rrmean;rrmean~  [ASY] *
    * rrmean  []               *
    \**************************/
    mysql_query("CREATE TABLE `rrmean`
                     ( `Rule` VARCHAR(255) DEFAULT NULL
                     , `Blob` BLOB DEFAULT NULL
                     ) ENGINE=InnoDB DEFAULT CHARACTER SET UTF8");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /********************************\
    * Plug rrpurpose                 *
    *                                *
    * fields:                        *
    * I/\rrpurpose;rrpurpose~  [ASY] *
    * rrpurpose  []                  *
    \********************************/
    mysql_query("CREATE TABLE `rrpurpose`
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
      fwrite($dumpfile, "CONTEXT RAP\n");
      fwrite($dumpfile, dumprel("inios[Concept*AtomID]","SELECT DISTINCT `Concept`, `AtomID` FROM `inios` WHERE `Concept` IS NOT NULL AND `AtomID` IS NOT NULL"));
      fwrite($dumpfile, dumprel("inipopu[Declaration*PairID]","SELECT DISTINCT `Declaration`, `PairID` FROM `inipopu` WHERE `Declaration` IS NOT NULL AND `PairID` IS NOT NULL"));
      fwrite($dumpfile, dumprel("compilererror[File*ErrorMessage]","SELECT DISTINCT `File`, `compilererror` FROM `File` WHERE `File` IS NOT NULL AND `compilererror` IS NOT NULL"));
      fwrite($dumpfile, dumprel("imageurl[Image*URL]","SELECT DISTINCT `Image`, `URL` FROM `imageurl` WHERE `Image` IS NOT NULL AND `URL` IS NOT NULL"));
      fwrite($dumpfile, dumprel("filename[File*FileName]","SELECT DISTINCT `File`, `filename` FROM `File` WHERE `File` IS NOT NULL AND `filename` IS NOT NULL"));
      fwrite($dumpfile, dumprel("filepath[File*FilePath]","SELECT DISTINCT `File`, `filepath` FROM `File` WHERE `File` IS NOT NULL AND `filepath` IS NOT NULL"));
      fwrite($dumpfile, dumprel("uploaded[User*File]","SELECT DISTINCT `User`, `File` FROM `uploaded` WHERE `User` IS NOT NULL AND `File` IS NOT NULL"));
      fwrite($dumpfile, dumprel("sourcefile[Context*AdlFile]","SELECT DISTINCT `ctxnm`, `sourcefile` FROM `Conid` WHERE `ctxnm` IS NOT NULL AND `sourcefile` IS NOT NULL"));
      fwrite($dumpfile, dumprel("includes[Context*File]","SELECT DISTINCT `Context`, `File` FROM `includes` WHERE `Context` IS NOT NULL AND `File` IS NOT NULL"));
      fwrite($dumpfile, dumprel("applyto[G*AdlFile]","SELECT DISTINCT `G`, `applyto` FROM `G` WHERE `G` IS NOT NULL AND `applyto` IS NOT NULL"));
      fwrite($dumpfile, dumprel("functionname[G*String]","SELECT DISTINCT `G`, `functionname` FROM `G` WHERE `G` IS NOT NULL AND `functionname` IS NOT NULL"));
      fwrite($dumpfile, dumprel("operation[G*Int]","SELECT DISTINCT `G`, `operation` FROM `G` WHERE `G` IS NOT NULL AND `operation` IS NOT NULL"));
      fwrite($dumpfile, dumprel("newfile[User*NewAdlFile]","SELECT DISTINCT `User`, `newfile` FROM `User` WHERE `User` IS NOT NULL AND `newfile` IS NOT NULL"));
      fwrite($dumpfile, dumprel("savepopulation[Context*SavePopFile]","SELECT DISTINCT `ctxnm`, `savepopulation` FROM `Conid` WHERE `ctxnm` IS NOT NULL AND `savepopulation` IS NOT NULL"));
      fwrite($dumpfile, dumprel("savecontext[Context*SaveAdlFile]","SELECT DISTINCT `ctxnm`, `savecontext` FROM `Conid` WHERE `ctxnm` IS NOT NULL AND `savecontext` IS NOT NULL"));
      fwrite($dumpfile, dumprel("countrules[Context*Int]","SELECT DISTINCT `ctxnm`, `countrules` FROM `Conid` WHERE `ctxnm` IS NOT NULL AND `countrules` IS NOT NULL"));
      fwrite($dumpfile, dumprel("countdecls[Context*Int]","SELECT DISTINCT `ctxnm`, `countdecls` FROM `Conid` WHERE `ctxnm` IS NOT NULL AND `countdecls` IS NOT NULL"));
      fwrite($dumpfile, dumprel("countcpts[Context*Int]","SELECT DISTINCT `ctxnm`, `countcpts` FROM `Conid` WHERE `ctxnm` IS NOT NULL AND `countcpts` IS NOT NULL"));
      fwrite($dumpfile, dumprel("ptpic[Pattern*Image]","SELECT DISTINCT `ptnm`, `ptpic` FROM `Conid` WHERE `ptnm` IS NOT NULL AND `ptpic` IS NOT NULL"));
      fwrite($dumpfile, dumprel("cptpic[Concept*Image]","SELECT DISTINCT `cptnm`, `cptpic` FROM `Conid` WHERE `cptnm` IS NOT NULL AND `cptpic` IS NOT NULL"));
      fwrite($dumpfile, dumprel("rrpic[Rule*Image]","SELECT DISTINCT `rrnm`, `rrpic` FROM `ADLid` WHERE `rrnm` IS NOT NULL AND `rrpic` IS NOT NULL"));
      fwrite($dumpfile, dumprel("rrviols[Rule*Violation]","SELECT DISTINCT `Rule`, `Violation` FROM `rrviols` WHERE `Rule` IS NOT NULL AND `Violation` IS NOT NULL"));
      fwrite($dumpfile, dumprel("ctxnm[Context*Conid]","SELECT DISTINCT `ctxnm`, `Conid` FROM `Conid` WHERE `ctxnm` IS NOT NULL AND `Conid` IS NOT NULL"));
      fwrite($dumpfile, dumprel("ctxpats[Context*Pattern]","SELECT DISTINCT `Context`, `Pattern` FROM `ctxpats` WHERE `Context` IS NOT NULL AND `Pattern` IS NOT NULL"));
      fwrite($dumpfile, dumprel("ctxcs[Context*Concept]","SELECT DISTINCT `Context`, `Concept` FROM `ctxcs` WHERE `Context` IS NOT NULL AND `Concept` IS NOT NULL"));
      fwrite($dumpfile, dumprel("ptnm[Pattern*Conid]","SELECT DISTINCT `ptnm`, `Conid` FROM `Conid` WHERE `ptnm` IS NOT NULL AND `Conid` IS NOT NULL"));
      fwrite($dumpfile, dumprel("ptrls[Pattern*Rule]","SELECT DISTINCT `Pattern`, `Rule` FROM `ptrls` WHERE `Pattern` IS NOT NULL AND `Rule` IS NOT NULL"));
      fwrite($dumpfile, dumprel("ptgns[Pattern*Gen]","SELECT DISTINCT `Pattern`, `Gen` FROM `ptgns` WHERE `Pattern` IS NOT NULL AND `Gen` IS NOT NULL"));
      fwrite($dumpfile, dumprel("ptdcs[Pattern*Declaration]","SELECT DISTINCT `Pattern`, `Declaration` FROM `ptdcs` WHERE `Pattern` IS NOT NULL AND `Declaration` IS NOT NULL"));
      fwrite($dumpfile, dumprel("ptxps[Pattern*Blob]","SELECT DISTINCT `Pattern`, `Blob` FROM `ptxps` WHERE `Pattern` IS NOT NULL AND `Blob` IS NOT NULL"));
      fwrite($dumpfile, dumprel("gengen[Gen*Concept]","SELECT DISTINCT `Gen`, `gengen` FROM `Gen` WHERE `Gen` IS NOT NULL AND `gengen` IS NOT NULL"));
      fwrite($dumpfile, dumprel("genspc[Gen*Concept]","SELECT DISTINCT `Gen`, `genspc` FROM `Gen` WHERE `Gen` IS NOT NULL AND `genspc` IS NOT NULL"));
      fwrite($dumpfile, dumprel("cptnm[Concept*Conid]","SELECT DISTINCT `cptnm`, `Conid` FROM `Conid` WHERE `cptnm` IS NOT NULL AND `Conid` IS NOT NULL"));
      fwrite($dumpfile, dumprel("cptos[Concept*AtomID]","SELECT DISTINCT `cptos`, `AtomID` FROM `AtomID` WHERE `cptos` IS NOT NULL AND `AtomID` IS NOT NULL"));
      fwrite($dumpfile, dumprel("cptdf[Concept*Blob]","SELECT DISTINCT `Concept`, `Blob` FROM `cptdf` WHERE `Concept` IS NOT NULL AND `Blob` IS NOT NULL"));
      fwrite($dumpfile, dumprel("cptpurpose[Concept*Blob]","SELECT DISTINCT `Concept`, `Blob` FROM `cptpurpose` WHERE `Concept` IS NOT NULL AND `Blob` IS NOT NULL"));
      fwrite($dumpfile, dumprel("atomvalue[AtomID*Atom]","SELECT DISTINCT `AtomID`, `atomvalue` FROM `AtomID` WHERE `AtomID` IS NOT NULL AND `atomvalue` IS NOT NULL"));
      fwrite($dumpfile, dumprel("src[Sign*Concept]","SELECT DISTINCT `Sign`, `src` FROM `Sign` WHERE `Sign` IS NOT NULL AND `src` IS NOT NULL"));
      fwrite($dumpfile, dumprel("trg[Sign*Concept]","SELECT DISTINCT `Sign`, `trg` FROM `Sign` WHERE `Sign` IS NOT NULL AND `trg` IS NOT NULL"));
      fwrite($dumpfile, dumprel("pairvalue[PairID*Pair]","SELECT DISTINCT `PairID`, `pairvalue` FROM `PairID` WHERE `PairID` IS NOT NULL AND `pairvalue` IS NOT NULL"));
      fwrite($dumpfile, dumprel("left[Pair*AtomID]","SELECT DISTINCT `Pair`, `left` FROM `Pair` WHERE `Pair` IS NOT NULL AND `left` IS NOT NULL"));
      fwrite($dumpfile, dumprel("right[Pair*AtomID]","SELECT DISTINCT `Pair`, `right` FROM `Pair` WHERE `Pair` IS NOT NULL AND `right` IS NOT NULL"));
      fwrite($dumpfile, dumprel("decnm[Declaration*Varid]","SELECT DISTINCT `Declaration`, `decnm` FROM `Declaration` WHERE `Declaration` IS NOT NULL AND `decnm` IS NOT NULL"));
      fwrite($dumpfile, dumprel("decsgn[Declaration*Sign]","SELECT DISTINCT `Declaration`, `decsgn` FROM `Declaration` WHERE `Declaration` IS NOT NULL AND `decsgn` IS NOT NULL"));
      fwrite($dumpfile, dumprel("decprps[Declaration*PropertyRule]","SELECT DISTINCT `decprps`, `PropertyRule` FROM `ADLid` WHERE `decprps` IS NOT NULL AND `PropertyRule` IS NOT NULL"));
      fwrite($dumpfile, dumprel("declaredthrough[PropertyRule*Property]","SELECT DISTINCT `PropertyRule`, `Property` FROM `declaredthrough` WHERE `PropertyRule` IS NOT NULL AND `Property` IS NOT NULL"));
      fwrite($dumpfile, dumprel("decprL[Declaration*String]","SELECT DISTINCT `Declaration`, `decprL` FROM `Declaration` WHERE `Declaration` IS NOT NULL AND `decprL` IS NOT NULL"));
      fwrite($dumpfile, dumprel("decprM[Declaration*String]","SELECT DISTINCT `Declaration`, `decprM` FROM `Declaration` WHERE `Declaration` IS NOT NULL AND `decprM` IS NOT NULL"));
      fwrite($dumpfile, dumprel("decprR[Declaration*String]","SELECT DISTINCT `Declaration`, `decprR` FROM `Declaration` WHERE `Declaration` IS NOT NULL AND `decprR` IS NOT NULL"));
      fwrite($dumpfile, dumprel("decmean[Declaration*Blob]","SELECT DISTINCT `Declaration`, `Blob` FROM `decmean` WHERE `Declaration` IS NOT NULL AND `Blob` IS NOT NULL"));
      fwrite($dumpfile, dumprel("decpurpose[Declaration*Blob]","SELECT DISTINCT `Declaration`, `Blob` FROM `decpurpose` WHERE `Declaration` IS NOT NULL AND `Blob` IS NOT NULL"));
      fwrite($dumpfile, dumprel("decpopu[Declaration*PairID]","SELECT DISTINCT `Declaration`, `PairID` FROM `decpopu` WHERE `Declaration` IS NOT NULL AND `PairID` IS NOT NULL"));
      fwrite($dumpfile, dumprel("exprvalue[ExpressionID*Expression]","SELECT DISTINCT `ExpressionID`, `exprvalue` FROM `ExpressionID` WHERE `ExpressionID` IS NOT NULL AND `exprvalue` IS NOT NULL"));
      fwrite($dumpfile, dumprel("rels[ExpressionID*Relation]","SELECT DISTINCT `ExpressionID`, `Relation` FROM `rels` WHERE `ExpressionID` IS NOT NULL AND `Relation` IS NOT NULL"));
      fwrite($dumpfile, dumprel("relnm[Relation*Varid]","SELECT DISTINCT `Relation`, `relnm` FROM `Relation` WHERE `Relation` IS NOT NULL AND `relnm` IS NOT NULL"));
      fwrite($dumpfile, dumprel("relsgn[Relation*Sign]","SELECT DISTINCT `Relation`, `relsgn` FROM `Relation` WHERE `Relation` IS NOT NULL AND `relsgn` IS NOT NULL"));
      fwrite($dumpfile, dumprel("reldcl[Relation*Declaration]","SELECT DISTINCT `Relation`, `reldcl` FROM `Relation` WHERE `Relation` IS NOT NULL AND `reldcl` IS NOT NULL"));
      fwrite($dumpfile, dumprel("rrnm[Rule*ADLid]","SELECT DISTINCT `rrnm`, `ADLid` FROM `ADLid` WHERE `rrnm` IS NOT NULL AND `ADLid` IS NOT NULL"));
      fwrite($dumpfile, dumprel("rrexp[Rule*ExpressionID]","SELECT DISTINCT `rrnm`, `rrexp` FROM `ADLid` WHERE `rrnm` IS NOT NULL AND `rrexp` IS NOT NULL"));
      fwrite($dumpfile, dumprel("rrmean[Rule*Blob]","SELECT DISTINCT `Rule`, `Blob` FROM `rrmean` WHERE `Rule` IS NOT NULL AND `Blob` IS NOT NULL"));
      fwrite($dumpfile, dumprel("rrpurpose[Rule*Blob]","SELECT DISTINCT `Rule`, `Blob` FROM `rrpurpose` WHERE `Rule` IS NOT NULL AND `Blob` IS NOT NULL"));
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
