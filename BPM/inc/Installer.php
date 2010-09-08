<?php
  // Try to connect to the database

  if(isset($DB_host)&&!isset($_REQUEST['DB_host'])){
    $included = true; // this means user/pass are probably correct
    $DB_link = @mysql_connect(@$DB_host,@$DB_user,@$DB_pass);
  }else{
    $included = false; // get user/pass elsewhere
    if(file_exists("dbsettings.php")) include "dbsettings.php";
    else { // no settings found.. try some default settings
      if(!( $DB_link=@mysql_connect($DB_host='localhost',$DB_user='root',$DB_pass='')))
      { // we still have no working settings.. ask the user!
        die("Install failed: cannot connect to MySQL"); // todo
      }
    } 
  }
  if($DB_slct = @mysql_select_db('BPM')){
    $existing=true;
  }else{
    $existing = false; // db does not exist, so try to create it
    @mysql_query("CREATE DATABASE `BPM` DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    $DB_slct = @mysql_select_db('BPM');
  }
  if(!$DB_slct){
    echo die("Install failed: cannot connect to MySQL or error selecting database 'BPM'");
  }else{
    if(!$included && !file_exists("dbsettings.php")){ // we have a link now; try to write the dbsettings.php file
       if($fh = @fopen("dbsettings.php", 'w')){
         fwrite($fh, '<'.'?php $DB_link=mysql_connect($DB_host="'.$DB_host.'", $DB_user="'.$DB_user.'", $DB_pass="'.$DB_pass.'"); $DB_debug = 3; ?'.'>');
         fclose($fh);
       }else die('<P>Error: could not write dbsettings.php, make sure that the directory of Installer.php is writable
                  or create dbsettings.php in the same directory as Installer.php
                  and paste the following code into it:</P><code>'.
                 '&lt;'.'?php $DB_link=mysql_connect($DB_host="'.$DB_host.'", $DB_user="'.$DB_user.'", $DB_pass="'.$DB_pass.'"); $DB_debug = 3; ?'.'&gt;</code>');
    }

    $error=false;
    /*** Create new SQL tables ***/
    //// Number of plugs: 27
    if($existing==true){
      if($columns = mysql_query("SHOW COLUMNS FROM `Process`")){
        mysql_query("DROP TABLE `Process`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `CaseAttr`")){
        mysql_query("DROP TABLE `CaseAttr`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `XXX`")){
        mysql_query("DROP TABLE `XXX`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `CaseAttrType`")){
        mysql_query("DROP TABLE `CaseAttrType`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Procedure`")){
        mysql_query("DROP TABLE `Procedure`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Postcondition`")){
        mysql_query("DROP TABLE `Postcondition`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Precondition`")){
        mysql_query("DROP TABLE `Precondition`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Value`")){
        mysql_query("DROP TABLE `Value`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Case`")){
        mysql_query("DROP TABLE `Case`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Rule`")){
        mysql_query("DROP TABLE `Rule`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Boolean`")){
        mysql_query("DROP TABLE `Boolean`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Datatype`")){
        mysql_query("DROP TABLE `Datatype`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `CaseType`")){
        mysql_query("DROP TABLE `CaseType`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `procedure`")){
        mysql_query("DROP TABLE `procedure`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `subProcOf`")){
        mysql_query("DROP TABLE `subProcOf`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `subRuleOf`")){
        mysql_query("DROP TABLE `subRuleOf`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `subCaseTypeOf`")){
        mysql_query("DROP TABLE `subCaseTypeOf`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `subCaseOf`")){
        mysql_query("DROP TABLE `subCaseOf`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `vak`")){
        mysql_query("DROP TABLE `vak`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `va`")){
        mysql_query("DROP TABLE `va`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `true`")){
        mysql_query("DROP TABLE `true`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `false`")){
        mysql_query("DROP TABLE `false`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `pmenu`")){
        mysql_query("DROP TABLE `pmenu`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `dmenu`")){
        mysql_query("DROP TABLE `dmenu`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `dselCase`")){
        mysql_query("DROP TABLE `dselCase`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `dselAttr`")){
        mysql_query("DROP TABLE `dselAttr`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `rulePredicate`")){
        mysql_query("DROP TABLE `rulePredicate`");
      }
    }
    /**************************************\
    * Plug Process                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * activity  [UNI,INJ,SUR]              *
    * preCdx  [UNI,TOT]                    *
    * postCdx  [UNI,TOT]                   *
    * effects  [SUR,UNI,TOT]               *
    * dsel  [UNI,TOT]                      *
    \**************************************/
    mysql_query("CREATE TABLE `Process`
                     ( `I` VARCHAR(255) NOT NULL
                     , `activity` VARCHAR(255)
                     , `preCdx` VARCHAR(255) NOT NULL
                     , `postCdx` VARCHAR(255) NOT NULL
                     , `effects` VARCHAR(255) NOT NULL
                     , `dsel` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug CaseAttr                        *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * belongsto  [UNI,TOT]                 *
    * caType  [UNI,TOT]                    *
    * caValue  [UNI]                       *
    * caAssVal  [UNI]                      *
    \**************************************/
    mysql_query("CREATE TABLE `CaseAttr`
                     ( `I` VARCHAR(255) NOT NULL
                     , `belongsto` VARCHAR(255) NOT NULL
                     , `caType` VARCHAR(255) NOT NULL
                     , `caValue` VARCHAR(255)
                     , `caAssVal` VARCHAR(255)
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug XXX                             *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * xxxCase  [UNI,TOT]                   *
    * xxxRule  [UNI,TOT]                   *
    * xxxReval  [UNI,TOT]                  *
    \**************************************/
    mysql_query("CREATE TABLE `XXX`
                     ( `I` VARCHAR(255) NOT NULL
                     , `xxxCase` VARCHAR(255) NOT NULL
                     , `xxxRule` VARCHAR(255) NOT NULL
                     , `xxxReval` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug CaseAttrType                    *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * belongsto  [UNI,TOT]                 *
    * catDatatype  [UNI,TOT]               *
    * catDefVal  [UNI]                     *
    \**************************************/
    mysql_query("CREATE TABLE `CaseAttrType`
                     ( `I` VARCHAR(255) NOT NULL
                     , `belongsto` VARCHAR(255) NOT NULL
                     , `catDatatype` VARCHAR(255) NOT NULL
                     , `catDefVal` VARCHAR(255)
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Procedure                       *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * procedureProcess  [UNI,TOT]          *
    * procedureRule  [UNI,TOT]             *
    \**************************************/
    mysql_query("CREATE TABLE `Procedure`
                     ( `I` VARCHAR(255) NOT NULL
                     , `procedureProcess` VARCHAR(255) NOT NULL
                     , `procedureRule` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Postcondition                   *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * postcdxProcess  [UNI,TOT]            *
    * postcdxRule  [UNI,TOT]               *
    \**************************************/
    mysql_query("CREATE TABLE `Postcondition`
                     ( `I` VARCHAR(255) NOT NULL
                     , `postcdxProcess` VARCHAR(255) NOT NULL
                     , `postcdxRule` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Precondition                    *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * precdxProcess  [UNI,TOT]             *
    * precdxRule  [UNI,TOT]                *
    \**************************************/
    mysql_query("CREATE TABLE `Precondition`
                     ( `I` VARCHAR(255) NOT NULL
                     , `precdxProcess` VARCHAR(255) NOT NULL
                     , `precdxRule` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Value                           *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * valType  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `Value`
                     ( `I` VARCHAR(255) NOT NULL
                     , `valType` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Case                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * caseType  [UNI,TOT]                  *
    \**************************************/
    mysql_query("CREATE TABLE `Case`
                     ( `I` VARCHAR(255) NOT NULL
                     , `caseType` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Rule                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * reval  [UNI]                         *
    \**************************************/
    mysql_query("CREATE TABLE `Rule`
                     ( `I` VARCHAR(255) NOT NULL
                     , `reval` VARCHAR(255)
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Boolean                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Boolean`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Datatype                        *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Datatype`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug CaseType                        *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `CaseType`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************************\
    * Plug procedure              *
    *                             *
    * fields:                     *
    * I/\procedure;procedure~  [] *
    * procedure  []               *
    \*****************************/
    mysql_query("CREATE TABLE `procedure`
                     ( `Process` VARCHAR(255)
                     , `Rule` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************************\
    * Plug subProcOf              *
    *                             *
    * fields:                     *
    * I/\subProcOf;subProcOf~  [] *
    * subProcOf  [ASY]            *
    \*****************************/
    mysql_query("CREATE TABLE `subProcOf`
                     ( `s_Process` VARCHAR(255)
                     , `t_Process` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************************\
    * Plug subRuleOf              *
    *                             *
    * fields:                     *
    * I/\subRuleOf;subRuleOf~  [] *
    * subRuleOf  [ASY]            *
    \*****************************/
    mysql_query("CREATE TABLE `subRuleOf`
                     ( `s_Rule` VARCHAR(255)
                     , `t_Rule` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*************************************\
    * Plug subCaseTypeOf                  *
    *                                     *
    * fields:                             *
    * I/\subCaseTypeOf;subCaseTypeOf~  [] *
    * subCaseTypeOf  []                   *
    \*************************************/
    mysql_query("CREATE TABLE `subCaseTypeOf`
                     ( `s_CaseType` VARCHAR(255)
                     , `t_CaseType` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************************\
    * Plug subCaseOf              *
    *                             *
    * fields:                     *
    * I/\subCaseOf;subCaseOf~  [] *
    * subCaseOf  [ASY]            *
    \*****************************/
    mysql_query("CREATE TABLE `subCaseOf`
                     ( `s_Case` VARCHAR(255)
                     , `t_Case` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************\
    * Plug vak        *
    *                 *
    * fields:         *
    * I/\vak;vak~  [] *
    * vak  [SYM,ASY]  *
    \*****************/
    mysql_query("CREATE TABLE `vak`
                     ( `s_Rule` VARCHAR(255)
                     , `t_Rule` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************\
    * Plug va       *
    *               *
    * fields:       *
    * I/\va;va~  [] *
    * va  []        *
    \***************/
    mysql_query("CREATE TABLE `va`
                     ( `Case` VARCHAR(255)
                     , `Rule` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*******************\
    * Plug true         *
    *                   *
    * fields:           *
    * I/\true;true~  [] *
    * true  [SYM,ASY]   *
    \*******************/
    mysql_query("CREATE TABLE `true`
                     ( `s_Boolean` VARCHAR(255)
                     , `t_Boolean` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `true` (`s_Boolean` ,`t_Boolean` )
                VALUES ('TRUE', 'TRUE')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*********************\
    * Plug false          *
    *                     *
    * fields:             *
    * I/\false;false~  [] *
    * false  [SYM,ASY]    *
    \*********************/
    mysql_query("CREATE TABLE `false`
                     ( `s_Boolean` VARCHAR(255)
                     , `t_Boolean` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `false` (`s_Boolean` ,`t_Boolean` )
                VALUES ('FALSE', 'FALSE')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*********************\
    * Plug pmenu          *
    *                     *
    * fields:             *
    * I/\pmenu;pmenu~  [] *
    * pmenu  []           *
    \*********************/
    mysql_query("CREATE TABLE `pmenu`
                     ( `s_Process` VARCHAR(255)
                     , `t_Process` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*********************\
    * Plug dmenu          *
    *                     *
    * fields:             *
    * I/\dmenu;dmenu~  [] *
    * dmenu  []           *
    \*********************/
    mysql_query("CREATE TABLE `dmenu`
                     ( `Process` VARCHAR(255)
                     , `Case` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug dselCase             *
    *                           *
    * fields:                   *
    * I/\dselCase;dselCase~  [] *
    * dselCase  []              *
    \***************************/
    mysql_query("CREATE TABLE `dselCase`
                     ( `s_Case` VARCHAR(255)
                     , `t_Case` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug dselAttr             *
    *                           *
    * fields:                   *
    * I/\dselAttr;dselAttr~  [] *
    * dselAttr  []              *
    \***************************/
    mysql_query("CREATE TABLE `dselAttr`
                     ( `Case` VARCHAR(255)
                     , `CaseAttr` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*************************************\
    * Plug rulePredicate                  *
    *                                     *
    * fields:                             *
    * I/\rulePredicate;rulePredicate~  [] *
    * rulePredicate  [SYM,ASY]            *
    \*************************************/
    mysql_query("CREATE TABLE `rulePredicate`
                     ( `s_Rule` VARCHAR(255)
                     , `t_Rule` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    mysql_query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
  }
?>
