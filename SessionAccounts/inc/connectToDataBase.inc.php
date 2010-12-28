<?php // generated with ADL vs. 1.1.0.801
  require "dbsettings.php";
  
  function display($tbl,$col,$id){
     return firstRow(firstCol(DB_doquer("SELECT DISTINCT `".$col."` FROM `".$tbl."` WHERE `i`='".addslashes($id)."'")));
  }
  
  function stripslashes_deep(&$value) 
  { $value = is_array($value) ? 
             array_map('stripslashes_deep', $value) : 
             stripslashes($value); 
      return $value; 
  } 
  if((function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()) 
      || (ini_get('magic_quotes_sybase') && (strtolower(ini_get('magic_quotes_sybase'))!="off")) ){ 
      stripslashes_deep($_GET); 
      stripslashes_deep($_POST); 
      stripslashes_deep($_REQUEST); 
      stripslashes_deep($_COOKIE); 
  } 
  $DB_slct = mysql_select_db('SessionAccounts',$DB_link);
  function firstRow($rows){ return $rows[0]; }
  function firstCol($rows){ foreach ($rows as $i=>&$v) $v=$v[0]; return $rows; }
  function DB_debug($txt,$lvl=0){
    global $DB_debug;
    if($lvl<=$DB_debug) {
      echo "<i title=\"debug level $lvl\">$txt</i>\n<P />\n";
      return true;
    }else return false;
  }
  
  $DB_errs = array();
  
  // wrapper function for MySQL
  function DB_doquer($quer,$debug=5)
  {
    global $DB_link,$DB_errs;
    DB_debug($quer,$debug);
    $result=mysql_query($quer,$DB_link);
    if(!$result){
      DB_debug('Error '.($ernr=mysql_errno($DB_link)).' in query "'.$quer.'": '.mysql_error(),2);
      $DB_errs[]='Error '.($ernr=mysql_errno($DB_link)).' in query "'.$quer.'"';
      return false;
    }
    if($result===true) return true; // succes.. but no contents..
    $rows=Array();
    while (($row = @mysql_fetch_array($result))!==false) {
      $rows[]=$row;
      unset($row);
    }
    return $rows;
  }
  function DB_plainquer($quer,&$errno,$debug=5)
  {
    global $DB_link,$DB_errs,$DB_lastquer;
    $DB_lastquer=$quer;
    DB_debug($quer,$debug);
    $result=mysql_query($quer,$DB_link);
    if(!$result){
      $errno=mysql_errno($DB_link);
      return false;
    }else{
      if(($p=stripos($quer,'INSERT'))!==false
         && (($q=stripos($quer,'UPDATE'))==false || $p<$q)
         && (($q=stripos($quer,'DELETE'))==false || $p<$q)
        )
      {
        return mysql_insert_id();
      } else return mysql_affected_rows();
    }
  }
  
  function DB_doquer_lookups($s){ $v=DB_doquer($s); $r=array(); foreach($v as $v2) addOneTo($r[$v2[0]],$v2[1]); return $r;}
  function addOneTo(&$var,$val){if(!isset($var))$var=array();if(isset($val)) $var[]=$val;return $var;}
  
  function checkRule0(){
    // Overtredingen horen niet voor te komen in (RULE anonymous people MAINTAINS anonymous = I[Person]/\-(iscalled;iscalled~))
    //            rule':: (-anonymous \/ -I[Person] \/ iscalled;iscalled~)/\(I[Person] \/ anonymous)/\(-(iscalled;iscalled~) \/ anonymous)
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`s_Person`, isect0.`t_Person`
                                 FROM 
                                    ( SELECT DISTINCT isect0.`Person` AS `s_Person`, isect0.`Person1` AS `t_Person`
                                        FROM 
                                           ( SELECT DISTINCT F0.`Person`, F1.`Person` AS `Person1`
                                               FROM `iscalled` AS F0, `iscalled` AS F1
                                              WHERE F0.`Text`=F1.`Text`
                                           ) AS isect0
                                       WHERE NOT EXISTS (SELECT *
                                                    FROM `anonymous` AS cp
                                                   WHERE isect0.`Person`=cp.`s_Person` AND isect0.`Person1`=cp.`t_Person`) AND isect0.`Person` <> isect0.`Person1` AND isect0.`Person` IS NOT NULL AND isect0.`Person1` IS NOT NULL
                                    ) AS isect0, 
                                    ( SELECT DISTINCT isect0.`s_Person` AS `I`, isect0.`t_Person` AS `I1`
                                        FROM `anonymous` AS isect0, `Person` AS isect1
                                       WHERE isect0.`s_Person` = isect0.`t_Person` AND isect0.`s_Person` IS NOT NULL AND isect0.`t_Person` IS NOT NULL
                                    ) AS isect1, 
                                    ( SELECT DISTINCT isect0.`s_Person` AS `Person`, isect0.`t_Person` AS `Person1`
                                        FROM `anonymous` AS isect0
                                       WHERE NOT EXISTS (SELECT *
                                                    FROM 
                                                       ( SELECT DISTINCT F0.`Person`, F1.`Person` AS `Person1`
                                                           FROM `iscalled` AS F0, `iscalled` AS F1
                                                          WHERE F0.`Text`=F1.`Text`
                                                       ) AS cp
                                                   WHERE isect0.`s_Person`=cp.`Person` AND isect0.`t_Person`=cp.`Person1`) AND isect0.`s_Person` IS NOT NULL AND isect0.`t_Person` IS NOT NULL
                                    ) AS isect2
                                WHERE (isect0.`s_Person` = isect1.`I` AND isect0.`t_Person` = isect1.`I1`) AND (isect0.`s_Person` = isect2.`Person` AND isect0.`t_Person` = isect2.`Person1`) AND isect0.`s_Person` IS NOT NULL AND isect0.`t_Person` IS NOT NULL');
    $v=array();
    if(is_array($isct))
    foreach($isct as $source=>$t){
      if(is_array($t))
      foreach($t as $i=>$target){
        $v[] = array( '0' => @$source
                    , '1' => @$target);
      }
    }if(count($v)) {
      DB_debug('Overtreding (Person '.$v[0][0].',Person '.$v[0][1].')
reden: \"Any person without a name has the property of being \'anonymous\'.
\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule1(){
    // Overtredingen horen niet voor te komen in (RULE unique emailaddrs MAINTAINS I[Person] = emailOf~;emailOf)
    //            rule':: (-I[Person] \/ -(emailOf~;emailOf))/\(emailOf~;emailOf \/ I[Person])
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`I`, isect0.`I1`
                                 FROM 
                                    ( SELECT DISTINCT isect0.`I`, isect0.`I1`
                                        FROM 
                                           ( SELECT DISTINCT cfst.`I`, csnd.`I1`
                                               FROM `Person` AS cfst, ( SELECT DISTINCT `I` AS `I1`
                                                 FROM `Person` ) AS csnd
                                              WHERE NOT EXISTS (SELECT *
                                                           FROM `Person` AS cp
                                                          WHERE cfst.`I`=cp.`I` AND csnd.`I1`=cp.`I`)
                                           ) AS isect0
                                       WHERE NOT EXISTS (SELECT *
                                                    FROM 
                                                       ( SELECT DISTINCT F0.`Person`, F1.`Person` AS `Person1`
                                                           FROM `emailOf` AS F0, `emailOf` AS F1
                                                          WHERE F0.`Emailaddr`=F1.`Emailaddr`
                                                       ) AS cp
                                                   WHERE isect0.`I`=cp.`Person` AND isect0.`I1`=cp.`Person1`) AND isect0.`I` IS NOT NULL AND isect0.`I1` IS NOT NULL
                                    ) AS isect0, 
                                    ( SELECT DISTINCT isect0.`Person`, isect0.`Person1`
                                        FROM 
                                           ( SELECT DISTINCT F0.`Person`, F1.`Person` AS `Person1`
                                               FROM `emailOf` AS F0, `emailOf` AS F1
                                              WHERE F0.`Emailaddr`=F1.`Emailaddr`
                                           ) AS isect0, `Person` AS isect1
                                       WHERE isect0.`Person` = isect0.`Person1` AND isect0.`Person` IS NOT NULL AND isect0.`Person1` IS NOT NULL
                                    ) AS isect1
                                WHERE (isect0.`I` = isect1.`Person` AND isect0.`I1` = isect1.`Person1`) AND isect0.`I` IS NOT NULL AND isect0.`I1` IS NOT NULL');
    $v=array();
    if(is_array($isct))
    foreach($isct as $source=>$t){
      if(is_array($t))
      foreach($t as $i=>$target){
        $v[] = array( '0' => @$source
                    , '1' => @$target);
      }
    }if(count($v)) {
      DB_debug('Overtreding (Person '.$v[0][0].',Person '.$v[0][1].')
reden: \"Within Personen zijn uniek gekarakteriseerd door hun email adres
\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule2(){
    // Overtredingen horen niet voor te komen in (RULE Rule2 MAINTAINS sUser |- sUsers)
    //            rule':: sUser/\-sUsers
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`I`, isect0.`sUser`
                                 FROM `Session` AS isect0
                                WHERE NOT EXISTS (SELECT *
                                             FROM `Session` AS cp
                                            WHERE isect0.`I`=cp.`I` AND isect0.`sUser`=cp.`sUsers`) AND isect0.`I` IS NOT NULL AND isect0.`sUser` IS NOT NULL');
    $v=array();
    if(is_array($isct))
    foreach($isct as $source=>$t){
      if(is_array($t))
      foreach($t as $i=>$target){
        $v[] = array( '0' => @$source
                    , '1' => @$target);
      }
    }if(count($v)) {
      DB_debug('Overtreding (Session '.$v[0][0].',UserAccount '.$v[0][1].')
reden: \"Als ooit in een sessie ingelogd is geweest, kan de sessie alleen
worden gecontinueerd met behulp van het oorspronkelijke sessie
account.
\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule3(){
    // Overtredingen horen niet voor te komen in (RULE Rule3 MAINTAINS sAccount = sUser)
    //            rule':: (-sAccount \/ -sUser)/\(sUser \/ sAccount)
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`I`, isect0.`sAccount`
                                 FROM 
                                    ( SELECT DISTINCT isect0.`I`, isect0.`sAccount`
                                        FROM 
                                           ( SELECT DISTINCT cfst.`I`, csnd.`I1` AS `sAccount`
                                               FROM `Session` AS cfst, ( SELECT DISTINCT `I` AS `I1`
                                                 FROM `UserAccount` ) AS csnd
                                              WHERE NOT EXISTS (SELECT *
                                                           FROM `Session` AS cp
                                                          WHERE cfst.`I`=cp.`I` AND csnd.`I1`=cp.`sAccount`)
                                           ) AS isect0
                                       WHERE NOT EXISTS (SELECT *
                                                    FROM `Session` AS cp
                                                   WHERE isect0.`I`=cp.`I` AND isect0.`sAccount`=cp.`sUser`) AND isect0.`I` IS NOT NULL AND isect0.`sAccount` IS NOT NULL
                                    ) AS isect0, 
                                    ( SELECT DISTINCT isect0.`I`, isect0.`sUser`
                                        FROM `Session` AS isect0, `Session` AS isect1
                                       WHERE (isect0.`I` = isect1.`I` AND isect0.`sUser` = isect1.`sAccount`) AND isect0.`I` IS NOT NULL AND isect0.`sUser` IS NOT NULL
                                    ) AS isect1
                                WHERE (isect0.`I` = isect1.`I` AND isect0.`sAccount` = isect1.`sUser`) AND isect0.`I` IS NOT NULL AND isect0.`sAccount` IS NOT NULL');
    $v=array();
    if(is_array($isct))
    foreach($isct as $source=>$t){
      if(is_array($t))
      foreach($t as $i=>$target){
        $v[] = array( '0' => @$source
                    , '1' => @$target);
      }
    }if(count($v)) {
      DB_debug('Overtreding (Session '.$v[0][0].',UserAccount '.$v[0][1].')
reden: \"De relatie-namen sAccount\' en \'sUser\' zijn aliassen van elkaar.
\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule4(){
    // Overtredingen horen niet voor te komen in (RULE Rule4 MAINTAINS sUser = loginSession~;(loginUsername/\loginPassword;userPassword~))
    //            rule':: (-sUser \/ -(loginSession~;(loginUsername/\loginPassword;userPassword~)))/\(loginSession~;(loginUsername/\loginPassword;userPassword~) \/ sUser)
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`I`, isect0.`sUser`
                                 FROM 
                                    ( SELECT DISTINCT isect0.`I`, isect0.`sUser`
                                        FROM 
                                           ( SELECT DISTINCT cfst.`I`, csnd.`I1` AS `sUser`
                                               FROM `Session` AS cfst, ( SELECT DISTINCT `I` AS `I1`
                                                 FROM `UserAccount` ) AS csnd
                                              WHERE NOT EXISTS (SELECT *
                                                           FROM `Session` AS cp
                                                          WHERE cfst.`I`=cp.`I` AND csnd.`I1`=cp.`sUser`)
                                           ) AS isect0
                                       WHERE NOT EXISTS (SELECT *
                                                    FROM 
                                                       ( SELECT DISTINCT F0.`I`, F1.`loginUsername`
                                                           FROM `Session` AS F0, 
                                                              ( SELECT DISTINCT isect0.`loginSession`, isect0.`loginUsername`
                                                                  FROM `Session` AS isect0, 
                                                                     ( SELECT DISTINCT F0.`loginSession`, F1.`I`
                                                                         FROM `Session` AS F0, `UserAccount` AS F1
                                                                        WHERE F0.`loginPassword`=F1.`userPassword`
                                                                     ) AS isect1
                                                                 WHERE (isect0.`loginSession` = isect1.`loginSession` AND isect0.`loginUsername` = isect1.`I`) AND isect0.`loginSession` IS NOT NULL AND isect0.`loginUsername` IS NOT NULL
                                                              ) AS F1
                                                          WHERE F0.`loginSession`=F1.`loginSession`
                                                       ) AS cp
                                                   WHERE isect0.`I`=cp.`I` AND isect0.`sUser`=cp.`loginUsername`) AND isect0.`I` IS NOT NULL AND isect0.`sUser` IS NOT NULL
                                    ) AS isect0, 
                                    ( SELECT DISTINCT isect0.`I`, isect0.`loginUsername`
                                        FROM 
                                           ( SELECT DISTINCT F0.`I`, F1.`loginUsername`
                                               FROM `Session` AS F0, 
                                                  ( SELECT DISTINCT isect0.`loginSession`, isect0.`loginUsername`
                                                      FROM `Session` AS isect0, 
                                                         ( SELECT DISTINCT F0.`loginSession`, F1.`I`
                                                             FROM `Session` AS F0, `UserAccount` AS F1
                                                            WHERE F0.`loginPassword`=F1.`userPassword`
                                                         ) AS isect1
                                                     WHERE (isect0.`loginSession` = isect1.`loginSession` AND isect0.`loginUsername` = isect1.`I`) AND isect0.`loginSession` IS NOT NULL AND isect0.`loginUsername` IS NOT NULL
                                                  ) AS F1
                                              WHERE F0.`loginSession`=F1.`loginSession`
                                           ) AS isect0, `Session` AS isect1
                                       WHERE (isect0.`I` = isect1.`I` AND isect0.`loginUsername` = isect1.`sUser`) AND isect0.`I` IS NOT NULL AND isect0.`loginUsername` IS NOT NULL
                                    ) AS isect1
                                WHERE (isect0.`I` = isect1.`I` AND isect0.`sUser` = isect1.`loginUsername`) AND isect0.`I` IS NOT NULL AND isect0.`sUser` IS NOT NULL');
    $v=array();
    if(is_array($isct))
    foreach($isct as $source=>$t){
      if(is_array($t))
      foreach($t as $i=>$target){
        $v[] = array( '0' => @$source
                    , '1' => @$target);
      }
    }if(count($v)) {
      DB_debug('Overtreding (Session '.$v[0][0].',UserAccount '.$v[0][1].')
reden: \"Inloggen leidt tot een sessionuser desda het wachtwoord is ingevuld
dat bij de username hoort.
\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule5(){
    // Overtredingen horen niet voor te komen in (RULE Rule5 MAINTAINS text |- I[Text])
    //            rule':: text/\-I[Text]
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`s_Text`, isect0.`t_Text`
                                 FROM `text2` AS isect0
                                WHERE isect0.`s_Text` <> isect0.`t_Text` AND isect0.`s_Text` IS NOT NULL AND isect0.`t_Text` IS NOT NULL');
    $v=array();
    if(is_array($isct))
    foreach($isct as $source=>$t){
      if(is_array($t))
      foreach($t as $i=>$target){
        $v[] = array( '0' => @$source
                    , '1' => @$target);
      }
    }if(count($v)) {
      DB_debug('Overtreding (Text '.$v[0][0].',Text '.$v[0][1].')
reden: \"\"<BR>',3);
      return false;
    }return true;
  }
  
  if($DB_debug>=3){
    checkRule0();
    checkRule1();
    checkRule2();
    checkRule3();
    checkRule4();
    checkRule5();
  }
?>