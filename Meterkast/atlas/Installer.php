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
  if($DB_slct = @mysql_select_db('atlas')){
    $existing=true;
  }else{
    $existing = false; // db does not exist, so try to create it
    @mysql_query("CREATE DATABASE `atlas` DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    $DB_slct = @mysql_select_db('atlas');
  }
  if(!$DB_slct){
    echo die("Install failed: cannot connect to MySQL or error selecting database 'atlas'");
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
      if($columns = mysql_query("SHOW COLUMNS FROM `UserRule`")){
        mysql_query("DROP TABLE `UserRule`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `HomogeneousRule`")){
        mysql_query("DROP TABLE `HomogeneousRule`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `MultiplicityRule`")){
        mysql_query("DROP TABLE `MultiplicityRule`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Signal`")){
        mysql_query("DROP TABLE `Signal`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Rule`")){
        mysql_query("DROP TABLE `Rule`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `IsaRelation`")){
        mysql_query("DROP TABLE `IsaRelation`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Relation`")){
        mysql_query("DROP TABLE `Relation`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Concept`")){
        mysql_query("DROP TABLE `Concept`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Type`")){
        mysql_query("DROP TABLE `Type`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `SubExpression`")){
        mysql_query("DROP TABLE `SubExpression`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Pattern`")){
        mysql_query("DROP TABLE `Pattern`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Service`")){
        mysql_query("DROP TABLE `Service`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Violation`")){
        mysql_query("DROP TABLE `Violation`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Prop`")){
        mysql_query("DROP TABLE `Prop`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `PragmaExample`")){
        mysql_query("DROP TABLE `PragmaExample`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Explanation`")){
        mysql_query("DROP TABLE `Explanation`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Atom`")){
        mysql_query("DROP TABLE `Atom`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Pair`")){
        mysql_query("DROP TABLE `Pair`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Picture`")){
        mysql_query("DROP TABLE `Picture`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `String`")){
        mysql_query("DROP TABLE `String`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Script`")){
        mysql_query("DROP TABLE `Script`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `User`")){
        mysql_query("DROP TABLE `User`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `relvar`")){
        mysql_query("DROP TABLE `relvar`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `contains1`")){
        mysql_query("DROP TABLE `contains1`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `contains2`")){
        mysql_query("DROP TABLE `contains2`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `contains3`")){
        mysql_query("DROP TABLE `contains3`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `contains4`")){
        mysql_query("DROP TABLE `contains4`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `morphisms1`")){
        mysql_query("DROP TABLE `morphisms1`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `morphisms2`")){
        mysql_query("DROP TABLE `morphisms2`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `violates1`")){
        mysql_query("DROP TABLE `violates1`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `violates2`")){
        mysql_query("DROP TABLE `violates2`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `violates3`")){
        mysql_query("DROP TABLE `violates3`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `violates4`")){
        mysql_query("DROP TABLE `violates4`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `s1`")){
        mysql_query("DROP TABLE `s1`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `s2`")){
        mysql_query("DROP TABLE `s2`");
      }
    }
    /**************************************\
    * Plug UserRule                        *
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
    mysql_query("CREATE TABLE `UserRule`
                     ( `I` VARCHAR(255) NOT NULL
                     , `type` VARCHAR(255) NOT NULL
                     , `explanation` VARCHAR(255) NOT NULL
                     , `picture` VARCHAR(255) NOT NULL
                     , `pattern` VARCHAR(255) NOT NULL
                     , `next` VARCHAR(255) NOT NULL
                     , `previous` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug HomogeneousRule                 *
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
    mysql_query("CREATE TABLE `HomogeneousRule`
                     ( `I` VARCHAR(255) NOT NULL
                     , `property` VARCHAR(255) NOT NULL
                     , `on` VARCHAR(255) NOT NULL
                     , `type` VARCHAR(255) NOT NULL
                     , `explanation` VARCHAR(255) NOT NULL
                     , `pattern` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug MultiplicityRule                *
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
    mysql_query("CREATE TABLE `MultiplicityRule`
                     ( `I` VARCHAR(255) NOT NULL
                     , `property` VARCHAR(255) NOT NULL
                     , `on` VARCHAR(255) NOT NULL
                     , `type` VARCHAR(255) NOT NULL
                     , `explanation` VARCHAR(255) NOT NULL
                     , `pattern` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Signal                          *
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
    mysql_query("CREATE TABLE `Signal`
                     ( `I` VARCHAR(255) NOT NULL
                     , `type` VARCHAR(255) NOT NULL
                     , `explanation` VARCHAR(255) NOT NULL
                     , `pattern` VARCHAR(255) NOT NULL
                     , `next` VARCHAR(255) NOT NULL
                     , `previous` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Rule                            *
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
    mysql_query("CREATE TABLE `Rule`
                     ( `I` VARCHAR(255) NOT NULL
                     , `type` VARCHAR(255) NOT NULL
                     , `explanation` VARCHAR(255) NOT NULL
                     , `pattern` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug IsaRelation                     *
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
    mysql_query("CREATE TABLE `IsaRelation`
                     ( `I` VARCHAR(255) NOT NULL
                     , `specific` VARCHAR(255) NOT NULL
                     , `general` VARCHAR(255) NOT NULL
                     , `pattern` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Relation                        *
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
    mysql_query("CREATE TABLE `Relation`
                     ( `I` VARCHAR(255) NOT NULL
                     , `description` VARCHAR(255)
                     , `example` VARCHAR(255) NOT NULL
                     , `pattern` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Concept                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * description  [UNI]                   *
    * picture  [UNI,TOT]                   *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `Concept`
                     ( `I` VARCHAR(255) NOT NULL
                     , `description` VARCHAR(255)
                     , `picture` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Type                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * source  [UNI,TOT]                    *
    * target  [UNI,TOT]                    *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `Type`
                     ( `I` VARCHAR(255) NOT NULL
                     , `source` VARCHAR(255) NOT NULL
                     , `target` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug SubExpression                   *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * subexpressionOf  [UNI,TOT]           *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `SubExpression`
                     ( `I` VARCHAR(255) NOT NULL
                     , `subexpressionOf` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Pattern                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * picture  [UNI,TOT]                   *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `Pattern`
                     ( `I` VARCHAR(255) NOT NULL
                     , `picture` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Service                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * picture  [UNI,TOT]                   *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `Service`
                     ( `I` VARCHAR(255) NOT NULL
                     , `picture` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Violation                       *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `Violation`
                     ( `I` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Prop                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `Prop`
                     ( `I` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug PragmaExample                   *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `PragmaExample`
                     ( `I` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Explanation                     *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `Explanation`
                     ( `I` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Atom                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `Atom`
                     ( `I` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Pair                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `Pair`
                     ( `I` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Picture                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * user  [UNI,TOT]                      *
    * script  [UNI,TOT]                    *
    * display  [UNI,TOT]                   *
    \**************************************/
    mysql_query("CREATE TABLE `Picture`
                     ( `I` VARCHAR(255) NOT NULL
                     , `user` VARCHAR(255) NOT NULL
                     , `script` VARCHAR(255) NOT NULL
                     , `display` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug String                          *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `String`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Script                          *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Script`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug User                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `User`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
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
                     ( `Relation` VARCHAR(255)
                     , `Type` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug contains1            *
    *                           *
    * fields:                   *
    * I/\contains;contains~  [] *
    * contains  []              *
    \***************************/
    mysql_query("CREATE TABLE `contains1`
                     ( `Relation` VARCHAR(255)
                     , `Pair` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug contains2            *
    *                           *
    * fields:                   *
    * I/\contains;contains~  [] *
    * contains  []              *
    \***************************/
    mysql_query("CREATE TABLE `contains2`
                     ( `Concept` VARCHAR(255)
                     , `Atom` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug contains3            *
    *                           *
    * fields:                   *
    * I/\contains;contains~  [] *
    * contains  []              *
    \***************************/
    mysql_query("CREATE TABLE `contains3`
                     ( `Signal` VARCHAR(255)
                     , `Pair` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug contains4            *
    *                           *
    * fields:                   *
    * I/\contains;contains~  [] *
    * contains  []              *
    \***************************/
    mysql_query("CREATE TABLE `contains4`
                     ( `SubExpression` VARCHAR(255)
                     , `Pair` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************************\
    * Plug morphisms1             *
    *                             *
    * fields:                     *
    * I/\morphisms;morphisms~  [] *
    * morphisms  []               *
    \*****************************/
    mysql_query("CREATE TABLE `morphisms1`
                     ( `UserRule` VARCHAR(255)
                     , `Relation` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************************\
    * Plug morphisms2             *
    *                             *
    * fields:                     *
    * I/\morphisms;morphisms~  [] *
    * morphisms  []               *
    \*****************************/
    mysql_query("CREATE TABLE `morphisms2`
                     ( `Signal` VARCHAR(255)
                     , `Relation` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug violates1            *
    *                           *
    * fields:                   *
    * I/\violates;violates~  [] *
    * violates  []              *
    \***************************/
    mysql_query("CREATE TABLE `violates1`
                     ( `Violation` VARCHAR(255)
                     , `Rule` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug violates2            *
    *                           *
    * fields:                   *
    * I/\violates;violates~  [] *
    * violates  []              *
    \***************************/
    mysql_query("CREATE TABLE `violates2`
                     ( `Violation` VARCHAR(255)
                     , `UserRule` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug violates3            *
    *                           *
    * fields:                   *
    * I/\violates;violates~  [] *
    * violates  []              *
    \***************************/
    mysql_query("CREATE TABLE `violates3`
                     ( `Violation` VARCHAR(255)
                     , `MultiplicityRule` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug violates4            *
    *                           *
    * fields:                   *
    * I/\violates;violates~  [] *
    * violates  []              *
    \***************************/
    mysql_query("CREATE TABLE `violates4`
                     ( `Violation` VARCHAR(255)
                     , `HomogeneousRule` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*************\
    * Plug s1     *
    *             *
    * fields:     *
    * I/\s;s~  [] *
    * s  []       *
    \*************/
    mysql_query("CREATE TABLE `s1`
                     ( `s_User` VARCHAR(255)
                     , `t_User` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*************\
    * Plug s2     *
    *             *
    * fields:     *
    * I/\s;s~  [] *
    * s  []       *
    \*************/
    mysql_query("CREATE TABLE `s2`
                     ( `s_Script` VARCHAR(255)
                     , `t_Script` VARCHAR(255)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    mysql_query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
  }
?>
