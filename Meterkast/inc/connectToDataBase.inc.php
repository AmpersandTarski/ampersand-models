<?php // generated with ADL vs. 0.8.10-408
  require "dbsettings.php";
  
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
  $DB_slct = mysql_select_db('ADL',$DB_link);
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
  
  
  function checkRule1(){
    // No violations should occur in (path~;path |- I)
    //            rule':: path~;path/\-I
    // sqlExprSrc fSpec rule':: path
     $v=DB_doquer('SELECT DISTINCT isect0.`path`, isect0.`path1`
                     FROM 
                        ( SELECT DISTINCT fst.`path`, snd.`path` AS `path1`
                            FROM `BestandTbl` AS fst, `BestandTbl` AS snd
                           WHERE fst.`Id` = snd.`Id`
                        ) AS isect0
                    WHERE isect0.`path` <> isect0.`path1` AND isect0.`path` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding van de regel: \"Artificial explanation: path~;path |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule2(){
    // No violations should occur in (I |- path;path~)
    //            rule':: I/\-(path;path~)
    // sqlExprSrc fSpec rule':: Id
     $v=DB_doquer('SELECT DISTINCT isect0.`Id`, isect0.`Id` AS `Id1`
                     FROM 
                        ( SELECT DISTINCT Id
                            FROM BestandTbl
                        ) AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT fst.`Id`, snd.`Id` AS `Id1`
                                        FROM `BestandTbl` AS fst, `BestandTbl` AS snd
                                       WHERE fst.`path` = snd.`path`
                                    ) AS cp
                                WHERE isect0.`Id`=cp.`Id` AND isect0.`Id`=cp.`Id1`) AND isect0.`Id` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding van de regel: \"Artificial explanation: I |- path;path~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule3(){
    // No violations should occur in (session;session~ |- I)
    //            rule':: session;session~/\-I
    // sqlExprSrc fSpec rule':: bestand
     $v=DB_doquer('SELECT DISTINCT isect0.`bestand`, isect0.`bestand1`
                     FROM 
                        ( SELECT DISTINCT fst.`bestand`, snd.`bestand` AS `bestand1`
                            FROM `SessieTbl` AS fst, `SessieTbl` AS snd
                           WHERE fst.`Id` = snd.`Id`
                        ) AS isect0
                    WHERE isect0.`bestand` <> isect0.`bestand1` AND isect0.`bestand` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding van de regel: \"Artificial explanation: session;session~ |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule4(){
    // No violations should occur in (session~;session |- I)
    //            rule':: session~;session/\-I
    // sqlExprSrc fSpec rule':: Id
     $v=DB_doquer('SELECT DISTINCT isect0.`Id`, isect0.`Id1`
                     FROM 
                        ( SELECT DISTINCT fst.`Id`, snd.`Id` AS `Id1`
                            FROM `SessieTbl` AS fst, `SessieTbl` AS snd
                           WHERE fst.`bestand` = snd.`bestand`
                        ) AS isect0
                    WHERE isect0.`Id` <> isect0.`Id1` AND isect0.`Id` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding van de regel: \"Artificial explanation: session~;session |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule5(){
    // No violations should occur in (I |- session;session~)
    //            rule':: I/\-(session;session~)
    // sqlExprSrc fSpec rule':: Id
     $v=DB_doquer('SELECT DISTINCT isect0.`Id`, isect0.`Id` AS `Id1`
                     FROM 
                        ( SELECT DISTINCT Id
                            FROM BestandTbl
                        ) AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT fst.`bestand`, snd.`bestand` AS `bestand1`
                                        FROM `SessieTbl` AS fst, `SessieTbl` AS snd
                                       WHERE fst.`Id` = snd.`Id`
                                    ) AS cp
                                WHERE isect0.`Id`=cp.`bestand` AND isect0.`Id`=cp.`bestand1`) AND isect0.`Id` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding van de regel: \"Artificial explanation: I |- session;session~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule6(){
    // No violations should occur in (ip~;ip |- I)
    //            rule':: ip~;ip/\-I
    // sqlExprSrc fSpec rule':: ip
     $v=DB_doquer('SELECT DISTINCT isect0.`ip`, isect0.`ip1`
                     FROM 
                        ( SELECT DISTINCT fst.`ip`, snd.`ip` AS `ip1`
                            FROM `SessieTbl` AS fst, `SessieTbl` AS snd
                           WHERE fst.`Id` = snd.`Id`
                        ) AS isect0
                    WHERE isect0.`ip` <> isect0.`ip1` AND isect0.`ip` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding van de regel: \"Artificial explanation: ip~;ip |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule7(){
    // No violations should occur in (I |- ip;ip~)
    //            rule':: I/\-(ip;ip~)
    // sqlExprSrc fSpec rule':: Id
     $v=DB_doquer('SELECT DISTINCT isect0.`Id`, isect0.`Id` AS `Id1`
                     FROM 
                        ( SELECT DISTINCT Id
                            FROM SessieTbl
                        ) AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT fst.`Id`, snd.`Id` AS `Id1`
                                        FROM `SessieTbl` AS fst, `SessieTbl` AS snd
                                       WHERE fst.`ip` = snd.`ip`
                                    ) AS cp
                                WHERE isect0.`Id`=cp.`Id` AND isect0.`Id`=cp.`Id1`) AND isect0.`Id` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding van de regel: \"Artificial explanation: I |- ip;ip~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule8(){
    // No violations should occur in (object~;object |- I)
    //            rule':: object~;object/\-I
    // sqlExprSrc fSpec rule':: object
     $v=DB_doquer('SELECT DISTINCT isect0.`object`, isect0.`object1`
                     FROM 
                        ( SELECT DISTINCT fst.`object`, snd.`object` AS `object1`
                            FROM `ActieTbl` AS fst, `ActieTbl` AS snd
                           WHERE fst.`Id` = snd.`Id`
                        ) AS isect0
                    WHERE isect0.`object` <> isect0.`object1` AND isect0.`object` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding van de regel: \"Artificial explanation: object~;object |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule9(){
    // No violations should occur in (I |- object;object~)
    //            rule':: I/\-(object;object~)
    // sqlExprSrc fSpec rule':: Id
     $v=DB_doquer('SELECT DISTINCT isect0.`Id`, isect0.`Id` AS `Id1`
                     FROM 
                        ( SELECT DISTINCT Id
                            FROM ActieTbl
                        ) AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT fst.`Id`, snd.`Id` AS `Id1`
                                        FROM `ActieTbl` AS fst, `ActieTbl` AS snd
                                       WHERE fst.`object` = snd.`object`
                                    ) AS cp
                                WHERE isect0.`Id`=cp.`Id` AND isect0.`Id`=cp.`Id1`) AND isect0.`Id` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding van de regel: \"Artificial explanation: I |- object;object~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule10(){
    // No violations should occur in (type~;type |- I)
    //            rule':: type~;type/\-I
    // sqlExprSrc fSpec rule':: type
     $v=DB_doquer('SELECT DISTINCT isect0.`type`, isect0.`type1`
                     FROM 
                        ( SELECT DISTINCT fst.`type`, snd.`type` AS `type1`
                            FROM `ActieTbl` AS fst, `ActieTbl` AS snd
                           WHERE fst.`Id` = snd.`Id`
                        ) AS isect0
                    WHERE isect0.`type` <> isect0.`type1` AND isect0.`type` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding van de regel: \"Artificial explanation: type~;type |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule11(){
    // No violations should occur in (I |- type;type~)
    //            rule':: I/\-(type;type~)
    // sqlExprSrc fSpec rule':: Id
     $v=DB_doquer('SELECT DISTINCT isect0.`Id`, isect0.`Id` AS `Id1`
                     FROM 
                        ( SELECT DISTINCT Id
                            FROM ActieTbl
                        ) AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT fst.`Id`, snd.`Id` AS `Id1`
                                        FROM `ActieTbl` AS fst, `ActieTbl` AS snd
                                       WHERE fst.`type` = snd.`type`
                                    ) AS cp
                                WHERE isect0.`Id`=cp.`Id` AND isect0.`Id`=cp.`Id1`) AND isect0.`Id` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding van de regel: \"Artificial explanation: I |- type;type~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule12(){
    // No violations should occur in (name;name~ |- I)
    //            rule':: name;name~/\-I
    // sqlExprSrc fSpec rule':: Id
     $v=DB_doquer('SELECT DISTINCT isect0.`Id`, isect0.`Id1`
                     FROM 
                        ( SELECT DISTINCT fst.`Id`, snd.`Id` AS `Id1`
                            FROM `OperationTbl` AS fst, `OperationTbl` AS snd
                           WHERE fst.`name` = snd.`name`
                        ) AS isect0
                    WHERE isect0.`Id` <> isect0.`Id1` AND isect0.`Id` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding van de regel: \"Artificial explanation: name;name~ |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule13(){
    // No violations should occur in (name~;name |- I)
    //            rule':: name~;name/\-I
    // sqlExprSrc fSpec rule':: name
     $v=DB_doquer('SELECT DISTINCT isect0.`name`, isect0.`name1`
                     FROM 
                        ( SELECT DISTINCT fst.`name`, snd.`name` AS `name1`
                            FROM `OperationTbl` AS fst, `OperationTbl` AS snd
                           WHERE fst.`Id` = snd.`Id`
                        ) AS isect0
                    WHERE isect0.`name` <> isect0.`name1` AND isect0.`name` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding van de regel: \"Artificial explanation: name~;name |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule14(){
    // No violations should occur in (I |- name;name~)
    //            rule':: I/\-(name;name~)
    // sqlExprSrc fSpec rule':: Id
     $v=DB_doquer('SELECT DISTINCT isect0.`Id`, isect0.`Id` AS `Id1`
                     FROM 
                        ( SELECT DISTINCT Id
                            FROM OperationTbl
                        ) AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT fst.`Id`, snd.`Id` AS `Id1`
                                        FROM `OperationTbl` AS fst, `OperationTbl` AS snd
                                       WHERE fst.`name` = snd.`name`
                                    ) AS cp
                                WHERE isect0.`Id`=cp.`Id` AND isect0.`Id`=cp.`Id1`) AND isect0.`Id` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding van de regel: \"Artificial explanation: I |- name;name~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule15(){
    // No violations should occur in (call~;call |- I)
    //            rule':: call~;call/\-I
    // sqlExprSrc fSpec rule':: call
     $v=DB_doquer('SELECT DISTINCT isect0.`call`, isect0.`call1`
                     FROM 
                        ( SELECT DISTINCT fst.`call`, snd.`call` AS `call1`
                            FROM `OperationTbl` AS fst, `OperationTbl` AS snd
                           WHERE fst.`Id` = snd.`Id`
                        ) AS isect0
                    WHERE isect0.`call` <> isect0.`call1` AND isect0.`call` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding van de regel: \"Artificial explanation: call~;call |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule16(){
    // No violations should occur in (I |- call;call~)
    //            rule':: I/\-(call;call~)
    // sqlExprSrc fSpec rule':: Id
     $v=DB_doquer('SELECT DISTINCT isect0.`Id`, isect0.`Id` AS `Id1`
                     FROM 
                        ( SELECT DISTINCT Id
                            FROM OperationTbl
                        ) AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT fst.`Id`, snd.`Id` AS `Id1`
                                        FROM `OperationTbl` AS fst, `OperationTbl` AS snd
                                       WHERE fst.`call` = snd.`call`
                                    ) AS cp
                                WHERE isect0.`Id`=cp.`Id` AND isect0.`Id`=cp.`Id1`) AND isect0.`Id` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding van de regel: \"Artificial explanation: I |- call;call~\"<BR>',3);
      return false;
    }return true;
  }
  
  if($DB_debug>=3){
    checkRule1();
    checkRule2();
    checkRule3();
    checkRule4();
    checkRule5();
    checkRule6();
    checkRule7();
    checkRule8();
    checkRule9();
    checkRule10();
    checkRule11();
    checkRule12();
    checkRule13();
    checkRule14();
    checkRule15();
    checkRule16();
  }
?>