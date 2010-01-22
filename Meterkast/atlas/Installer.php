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
  if($DB_slct = @mysql_select_db('Atlas')){
    $existing=true;
  }else{
    $existing = false; // db does not exist, so try to create it
    @mysql_query("CREATE DATABASE `Atlas` DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    $DB_slct = @mysql_select_db('Atlas');
  }
  if(!$DB_slct){
    echo die("Install failed: cannot connect to MySQL or error selecting database");
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
    //// Number of plugs: 35
    if($existing==true){
      if($columns = mysql_query("SHOW COLUMNS FROM `userrule`")){
        mysql_query("DROP TABLE `userrule`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `signal`")){
        mysql_query("DROP TABLE `signal`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `multiplicityrule`")){
        mysql_query("DROP TABLE `multiplicityrule`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `homogeneousrule`")){
        mysql_query("DROP TABLE `homogeneousrule`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `relation`")){
        mysql_query("DROP TABLE `relation`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `isarelation`")){
        mysql_query("DROP TABLE `isarelation`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `rule`")){
        mysql_query("DROP TABLE `rule`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `type`")){
        mysql_query("DROP TABLE `type`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `service`")){
        mysql_query("DROP TABLE `service`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `concept`")){
        mysql_query("DROP TABLE `concept`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `pattern`")){
        mysql_query("DROP TABLE `pattern`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `subexpression`")){
        mysql_query("DROP TABLE `subexpression`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `picture`")){
        mysql_query("DROP TABLE `picture`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `pair`")){
        mysql_query("DROP TABLE `pair`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `atom`")){
        mysql_query("DROP TABLE `atom`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `explanation`")){
        mysql_query("DROP TABLE `explanation`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `pragmaexample`")){
        mysql_query("DROP TABLE `pragmaexample`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `prop`")){
        mysql_query("DROP TABLE `prop`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `violation`")){
        mysql_query("DROP TABLE `violation`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `user`")){
        mysql_query("DROP TABLE `user`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `script`")){
        mysql_query("DROP TABLE `script`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `string`")){
        mysql_query("DROP TABLE `string`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `relvar`")){
        mysql_query("DROP TABLE `relvar`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `contains`")){
        mysql_query("DROP TABLE `contains`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `containsconcept`")){
        mysql_query("DROP TABLE `containsconcept`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `morphisms`")){
        mysql_query("DROP TABLE `morphisms`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `morphismssignal`")){
        mysql_query("DROP TABLE `morphismssignal`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `containssignal`")){
        mysql_query("DROP TABLE `containssignal`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `violates`")){
        mysql_query("DROP TABLE `violates`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `violatesviolation`")){
        mysql_query("DROP TABLE `violatesviolation`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `violatesmultiplicityrule`")){
        mysql_query("DROP TABLE `violatesmultiplicityrule`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `violateshomogeneousrule`")){
        mysql_query("DROP TABLE `violateshomogeneousrule`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `containssubexpression`")){
        mysql_query("DROP TABLE `containssubexpression`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `s`")){
        mysql_query("DROP TABLE `s`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `sscript`")){
        mysql_query("DROP TABLE `sscript`");
      }
    }
    /**************************************\
    * Plug userrule                        *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * type  [UNI,TOT]                      *
    * explanation  [UNI,TOT]               *
    * picture  [UNI,TOT]                   *
    * pattern  [UNI,TOT]                   *
    * next  [UNI,TOT]                      *
    * previous  [UNI,TOT]                  *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `userrule`
                     ( `i` VARCHAR(255) NOT NULL
                     , `type` VARCHAR(255) NOT NULL
                     , `explanation` VARCHAR(255) NOT NULL
                     , `picture` VARCHAR(255) NOT NULL
                     , `pattern` VARCHAR(255) NOT NULL
                     , `next` VARCHAR(255) NOT NULL
                     , `previous` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug signal                          *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * type  [UNI,TOT]                      *
    * explanation  [UNI,TOT]               *
    * pattern  [UNI,TOT]                   *
    * next  [UNI,TOT]                      *
    * previous  [UNI,TOT]                  *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `signal`
                     ( `i` VARCHAR(255) NOT NULL
                     , `type` VARCHAR(255) NOT NULL
                     , `explanation` VARCHAR(255) NOT NULL
                     , `pattern` VARCHAR(255) NOT NULL
                     , `next` VARCHAR(255) NOT NULL
                     , `previous` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug multiplicityrule                *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * property  [UNI,TOT]                  *
    * on  [UNI,TOT]                        *
    * type  [UNI,TOT]                      *
    * explanation  [UNI,TOT]               *
    * pattern  [UNI,TOT]                   *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `multiplicityrule`
                     ( `i` VARCHAR(255) NOT NULL
                     , `property` VARCHAR(255) NOT NULL
                     , `on` VARCHAR(255) NOT NULL
                     , `type` VARCHAR(255) NOT NULL
                     , `explanation` VARCHAR(255) NOT NULL
                     , `pattern` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug homogeneousrule                 *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * property  [UNI,TOT]                  *
    * on  [UNI,TOT]                        *
    * type  [UNI,TOT]                      *
    * explanation  [UNI,TOT]               *
    * pattern  [UNI,TOT]                   *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `homogeneousrule`
                     ( `i` VARCHAR(255) NOT NULL
                     , `property` VARCHAR(255) NOT NULL
                     , `on` VARCHAR(255) NOT NULL
                     , `type` VARCHAR(255) NOT NULL
                     , `explanation` VARCHAR(255) NOT NULL
                     , `pattern` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug relation                        *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * description  [UNI]                   *
    * example  [UNI,TOT]                   *
    * pattern  [UNI,TOT]                   *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `relation`
                     ( `i` VARCHAR(255) NOT NULL
                     , `description` VARCHAR(255)
                     , `example` VARCHAR(255) NOT NULL
                     , `pattern` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug isarelation                     *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * specific  [UNI,TOT]                  *
    * general  [UNI,TOT]                   *
    * pattern  [UNI,TOT]                   *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `isarelation`
                     ( `i` VARCHAR(255) NOT NULL
                     , `specific` VARCHAR(255) NOT NULL
                     , `general` VARCHAR(255) NOT NULL
                     , `pattern` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug rule                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * type  [UNI,TOT]                      *
    * explanation  [UNI,TOT]               *
    * pattern  [UNI,TOT]                   *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `rule`
                     ( `i` VARCHAR(255) NOT NULL
                     , `type` VARCHAR(255) NOT NULL
                     , `explanation` VARCHAR(255) NOT NULL
                     , `pattern` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug type                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * source  [UNI,TOT]                    *
    * target  [UNI,TOT]                    *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `type`
                     ( `i` VARCHAR(255) NOT NULL
                     , `source` VARCHAR(255) NOT NULL
                     , `target` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug service                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * picture  [UNI,TOT]                   *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `service`
                     ( `i` VARCHAR(255) NOT NULL
                     , `picture` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug concept                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * description  [UNI]                   *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `concept`
                     ( `i` VARCHAR(255) NOT NULL
                     , `description` VARCHAR(255)
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug pattern                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * picture  [UNI,TOT]                   *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `pattern`
                     ( `i` VARCHAR(255) NOT NULL
                     , `picture` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug subexpression                   *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * subexpressionOf  [UNI,TOT]           *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `subexpression`
                     ( `i` VARCHAR(255) NOT NULL
                     , `subexpressionof` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug picture                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `picture`
                     ( `i` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug pair                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `pair`
                     ( `i` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug atom                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `atom`
                     ( `i` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug explanation                     *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `explanation`
                     ( `i` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug pragmaexample                   *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `pragmaexample`
                     ( `i` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug prop                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `prop`
                     ( `i` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug violation                       *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `violation`
                     ( `i` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug user                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `user`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug script                          *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `script`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug string                          *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `string`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***********************\
    * Plug relvar           *
    *                       *
    * fields:               *
    * I/\relvar;relvar~  [] *
    * relvar  []            *
    \***********************/
    mysql_query("CREATE TABLE `relvar`
                     ( `relation` VARCHAR(255)
                     , `type` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug contains             *
    *                           *
    * fields:                   *
    * I/\contains;contains~  [] *
    * contains  []              *
    \***************************/
    mysql_query("CREATE TABLE `contains`
                     ( `relation` VARCHAR(255)
                     , `pair` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug containsconcept      *
    *                           *
    * fields:                   *
    * I/\contains;contains~  [] *
    * contains  []              *
    \***************************/
    mysql_query("CREATE TABLE `containsconcept`
                     ( `concept` VARCHAR(255)
                     , `atom` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************************\
    * Plug morphisms              *
    *                             *
    * fields:                     *
    * I/\morphisms;morphisms~  [] *
    * morphisms  []               *
    \*****************************/
    mysql_query("CREATE TABLE `morphisms`
                     ( `userrule` VARCHAR(255)
                     , `relation` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************************\
    * Plug morphismssignal        *
    *                             *
    * fields:                     *
    * I/\morphisms;morphisms~  [] *
    * morphisms  []               *
    \*****************************/
    mysql_query("CREATE TABLE `morphismssignal`
                     ( `signal` VARCHAR(255)
                     , `relation` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug containssignal       *
    *                           *
    * fields:                   *
    * I/\contains;contains~  [] *
    * contains  []              *
    \***************************/
    mysql_query("CREATE TABLE `containssignal`
                     ( `signal` VARCHAR(255)
                     , `pair` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug violates             *
    *                           *
    * fields:                   *
    * I/\violates;violates~  [] *
    * violates  []              *
    \***************************/
    mysql_query("CREATE TABLE `violates`
                     ( `violation` VARCHAR(255)
                     , `rule` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug violatesviolation    *
    *                           *
    * fields:                   *
    * I/\violates;violates~  [] *
    * violates  []              *
    \***************************/
    mysql_query("CREATE TABLE `violatesviolation`
                     ( `violation` VARCHAR(255)
                     , `userrule` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*******************************\
    * Plug violatesmultiplicityrule *
    *                               *
    * fields:                       *
    * I/\violates;violates~  []     *
    * violates  []                  *
    \*******************************/
    mysql_query("CREATE TABLE `violatesmultiplicityrule`
                     ( `violation` VARCHAR(255)
                     , `multiplicityrule` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /******************************\
    * Plug violateshomogeneousrule *
    *                              *
    * fields:                      *
    * I/\violates;violates~  []    *
    * violates  []                 *
    \******************************/
    mysql_query("CREATE TABLE `violateshomogeneousrule`
                     ( `violation` VARCHAR(255)
                     , `homogeneousrule` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /****************************\
    * Plug containssubexpression *
    *                            *
    * fields:                    *
    * I/\contains;contains~  []  *
    * contains  []               *
    \****************************/
    mysql_query("CREATE TABLE `containssubexpression`
                     ( `subexpression` VARCHAR(255)
                     , `pair` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*************\
    * Plug s      *
    *             *
    * fields:     *
    * I/\s;s~  [] *
    * s  []       *
    \*************/
    mysql_query("CREATE TABLE `s`
                     ( `user` VARCHAR(255)
                     , `user1` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************\
    * Plug sscript *
    *              *
    * fields:      *
    * I/\s;s~  []  *
    * s  []        *
    \**************/
    mysql_query("CREATE TABLE `sscript`
                     ( `script` VARCHAR(255)
                     , `script1` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    mysql_query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
  }
?>
