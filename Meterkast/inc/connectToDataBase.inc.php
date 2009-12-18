<?php // generated with ADL vs. 0.8.10-495
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
  $DB_slct = mysql_select_db('meterkast',$DB_link);
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
    // Overtredingen behoren niet voor te komen in (path~;path |- I[Text])
    //            rule':: path~;path/\-I[Text]
    // sqlExprSrc fSpec rule':: path
     $v=DB_doquer('SELECT DISTINCT isect0.`path`, isect0.`path1`
                     FROM 
                        ( SELECT DISTINCT F0.`path`, F1.`path` AS `path1`
                            FROM `bestandtbl` AS F0, `bestandtbl` AS F1
                           WHERE F0.`id`=F1.`id`
                        ) AS isect0
                    WHERE isect0.`path` <> isect0.`path1` AND isect0.`path` IS NOT NULL AND isect0.`path1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Text '.$v[0][0].',Text '.$v[0][1].')
reden: \"path[Bestand*Text] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule2(){
    // Overtredingen behoren niet voor te komen in (I[Bestand] |- path;path~)
    //            rule':: I[Bestand]/\-(path;path~)
    // sqlExprSrc fSpec rule':: id
     $v=DB_doquer('SELECT DISTINCT isect0.`id`, isect0.`id` AS `id1`
                     FROM `bestandtbl` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`id`, F1.`id` AS `id1`
                                        FROM `bestandtbl` AS F0, `bestandtbl` AS F1
                                       WHERE F0.`path`=F1.`path`
                                    ) AS cp
                                WHERE isect0.`id`=cp.`id` AND isect0.`id`=cp.`id1`) AND isect0.`id` IS NOT NULL AND isect0.`id` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Bestand '.$v[0][0].',Bestand '.$v[0][1].')
reden: \"path[Bestand*Text] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule3(){
    // Overtredingen behoren niet voor te komen in (session;session~ |- I[Bestand])
    //            rule':: session;session~/\-I[Bestand]
    // sqlExprSrc fSpec rule':: bestand
     $v=DB_doquer('SELECT DISTINCT isect0.`bestand`, isect0.`bestand1`
                     FROM 
                        ( SELECT DISTINCT F0.`bestand`, F1.`bestand` AS `bestand1`
                            FROM `sessietbl` AS F0, `sessietbl` AS F1
                           WHERE F0.`id`=F1.`id`
                        ) AS isect0
                    WHERE isect0.`bestand` <> isect0.`bestand1` AND isect0.`bestand` IS NOT NULL AND isect0.`bestand1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Bestand '.$v[0][0].',Bestand '.$v[0][1].')
reden: \"session[Bestand*Session] is injective\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule4(){
    // Overtredingen behoren niet voor te komen in (session~;session |- I[Session])
    //            rule':: session~;session/\-I[Session]
    // sqlExprSrc fSpec rule':: id
     $v=DB_doquer('SELECT DISTINCT isect0.`id`, isect0.`id1`
                     FROM 
                        ( SELECT DISTINCT F0.`id`, F1.`id` AS `id1`
                            FROM `sessietbl` AS F0, `sessietbl` AS F1
                           WHERE F0.`bestand`=F1.`bestand`
                        ) AS isect0
                    WHERE isect0.`id` <> isect0.`id1` AND isect0.`id` IS NOT NULL AND isect0.`id1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Session '.$v[0][0].',Session '.$v[0][1].')
reden: \"session[Bestand*Session] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule5(){
    // Overtredingen behoren niet voor te komen in (I[Bestand] |- session;session~)
    //            rule':: I[Bestand]/\-(session;session~)
    // sqlExprSrc fSpec rule':: id
     $v=DB_doquer('SELECT DISTINCT isect0.`id`, isect0.`id` AS `id1`
                     FROM `bestandtbl` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`bestand`, F1.`bestand` AS `bestand1`
                                        FROM `sessietbl` AS F0, `sessietbl` AS F1
                                       WHERE F0.`id`=F1.`id`
                                    ) AS cp
                                WHERE isect0.`id`=cp.`bestand` AND isect0.`id`=cp.`bestand1`) AND isect0.`id` IS NOT NULL AND isect0.`id` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Bestand '.$v[0][0].',Bestand '.$v[0][1].')
reden: \"session[Bestand*Session] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule6(){
    // Overtredingen behoren niet voor te komen in (ip~;ip |- I[Text])
    //            rule':: ip~;ip/\-I[Text]
    // sqlExprSrc fSpec rule':: ip
     $v=DB_doquer('SELECT DISTINCT isect0.`ip`, isect0.`ip1`
                     FROM 
                        ( SELECT DISTINCT F0.`ip`, F1.`ip` AS `ip1`
                            FROM `sessietbl` AS F0, `sessietbl` AS F1
                           WHERE F0.`id`=F1.`id`
                        ) AS isect0
                    WHERE isect0.`ip` <> isect0.`ip1` AND isect0.`ip` IS NOT NULL AND isect0.`ip1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Text '.$v[0][0].',Text '.$v[0][1].')
reden: \"ip[Session*Text] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule7(){
    // Overtredingen behoren niet voor te komen in (I[Session] |- ip;ip~)
    //            rule':: I[Session]/\-(ip;ip~)
    // sqlExprSrc fSpec rule':: id
     $v=DB_doquer('SELECT DISTINCT isect0.`id`, isect0.`id` AS `id1`
                     FROM `sessietbl` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`id`, F1.`id` AS `id1`
                                        FROM `sessietbl` AS F0, `sessietbl` AS F1
                                       WHERE F0.`ip`=F1.`ip`
                                    ) AS cp
                                WHERE isect0.`id`=cp.`id` AND isect0.`id`=cp.`id1`) AND isect0.`id` IS NOT NULL AND isect0.`id` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Session '.$v[0][0].',Session '.$v[0][1].')
reden: \"ip[Session*Text] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule8(){
    // Overtredingen behoren niet voor te komen in (object~;object |- I[Bestand])
    //            rule':: object~;object/\-I[Bestand]
    // sqlExprSrc fSpec rule':: object
     $v=DB_doquer('SELECT DISTINCT isect0.`object`, isect0.`object1`
                     FROM 
                        ( SELECT DISTINCT F0.`object`, F1.`object` AS `object1`
                            FROM `actietbl` AS F0, `actietbl` AS F1
                           WHERE F0.`id`=F1.`id`
                        ) AS isect0
                    WHERE isect0.`object` <> isect0.`object1` AND isect0.`object` IS NOT NULL AND isect0.`object1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Bestand '.$v[0][0].',Bestand '.$v[0][1].')
reden: \"object[Actie*Bestand] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule9(){
    // Overtredingen behoren niet voor te komen in (I[Actie] |- object;object~)
    //            rule':: I[Actie]/\-(object;object~)
    // sqlExprSrc fSpec rule':: id
     $v=DB_doquer('SELECT DISTINCT isect0.`id`, isect0.`id` AS `id1`
                     FROM `actietbl` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`id`, F1.`id` AS `id1`
                                        FROM `actietbl` AS F0, `actietbl` AS F1
                                       WHERE F0.`object`=F1.`object`
                                    ) AS cp
                                WHERE isect0.`id`=cp.`id` AND isect0.`id`=cp.`id1`) AND isect0.`id` IS NOT NULL AND isect0.`id` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Actie '.$v[0][0].',Actie '.$v[0][1].')
reden: \"object[Actie*Bestand] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule10(){
    // Overtredingen behoren niet voor te komen in (type~;type |- I[Operation])
    //            rule':: type~;type/\-I[Operation]
    // sqlExprSrc fSpec rule':: type
     $v=DB_doquer('SELECT DISTINCT isect0.`type`, isect0.`type1`
                     FROM 
                        ( SELECT DISTINCT F0.`type`, F1.`type` AS `type1`
                            FROM `actietbl` AS F0, `actietbl` AS F1
                           WHERE F0.`id`=F1.`id`
                        ) AS isect0
                    WHERE isect0.`type` <> isect0.`type1` AND isect0.`type` IS NOT NULL AND isect0.`type1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Operation '.$v[0][0].',Operation '.$v[0][1].')
reden: \"type[Actie*Operation] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule11(){
    // Overtredingen behoren niet voor te komen in (I[Actie] |- type;type~)
    //            rule':: I[Actie]/\-(type;type~)
    // sqlExprSrc fSpec rule':: id
     $v=DB_doquer('SELECT DISTINCT isect0.`id`, isect0.`id` AS `id1`
                     FROM `actietbl` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`id`, F1.`id` AS `id1`
                                        FROM `actietbl` AS F0, `actietbl` AS F1
                                       WHERE F0.`type`=F1.`type`
                                    ) AS cp
                                WHERE isect0.`id`=cp.`id` AND isect0.`id`=cp.`id1`) AND isect0.`id` IS NOT NULL AND isect0.`id` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Actie '.$v[0][0].',Actie '.$v[0][1].')
reden: \"type[Actie*Operation] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule12(){
    // Overtredingen behoren niet voor te komen in (done~;done |- I[Flag])
    //            rule':: done~;done/\-I[Flag]
    // sqlExprSrc fSpec rule':: done
     $v=DB_doquer('SELECT DISTINCT isect0.`done`, isect0.`done1`
                     FROM 
                        ( SELECT DISTINCT F0.`done`, F1.`done` AS `done1`
                            FROM `actietbl` AS F0, `actietbl` AS F1
                           WHERE F0.`id`=F1.`id`
                        ) AS isect0
                    WHERE isect0.`done` <> isect0.`done1` AND isect0.`done` IS NOT NULL AND isect0.`done1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Flag '.$v[0][0].',Flag '.$v[0][1].')
reden: \"done[Actie*Flag] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule13(){
    // Overtredingen behoren niet voor te komen in (I[Actie] |- done;done~)
    //            rule':: I[Actie]/\-(done;done~)
    // sqlExprSrc fSpec rule':: id
     $v=DB_doquer('SELECT DISTINCT isect0.`id`, isect0.`id` AS `id1`
                     FROM `actietbl` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`id`, F1.`id` AS `id1`
                                        FROM `actietbl` AS F0, `actietbl` AS F1
                                       WHERE F0.`done`=F1.`done`
                                    ) AS cp
                                WHERE isect0.`id`=cp.`id` AND isect0.`id`=cp.`id1`) AND isect0.`id` IS NOT NULL AND isect0.`id` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Actie '.$v[0][0].',Actie '.$v[0][1].')
reden: \"done[Actie*Flag] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule14(){
    // Overtredingen behoren niet voor te komen in (name;name~ |- I[Operation])
    //            rule':: name;name~/\-I[Operation]
    // sqlExprSrc fSpec rule':: id
     $v=DB_doquer('SELECT DISTINCT isect0.`id`, isect0.`id1`
                     FROM 
                        ( SELECT DISTINCT F0.`id`, F1.`id` AS `id1`
                            FROM `operationtbl` AS F0, `operationtbl` AS F1
                           WHERE F0.`name`=F1.`name`
                        ) AS isect0
                    WHERE isect0.`id` <> isect0.`id1` AND isect0.`id` IS NOT NULL AND isect0.`id1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Operation '.$v[0][0].',Operation '.$v[0][1].')
reden: \"name[Operation*Text] is injective\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule15(){
    // Overtredingen behoren niet voor te komen in (name~;name |- I[Text])
    //            rule':: name~;name/\-I[Text]
    // sqlExprSrc fSpec rule':: name
     $v=DB_doquer('SELECT DISTINCT isect0.`name`, isect0.`name1`
                     FROM 
                        ( SELECT DISTINCT F0.`name`, F1.`name` AS `name1`
                            FROM `operationtbl` AS F0, `operationtbl` AS F1
                           WHERE F0.`id`=F1.`id`
                        ) AS isect0
                    WHERE isect0.`name` <> isect0.`name1` AND isect0.`name` IS NOT NULL AND isect0.`name1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Text '.$v[0][0].',Text '.$v[0][1].')
reden: \"name[Operation*Text] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule16(){
    // Overtredingen behoren niet voor te komen in (I[Operation] |- name;name~)
    //            rule':: I[Operation]/\-(name;name~)
    // sqlExprSrc fSpec rule':: id
     $v=DB_doquer('SELECT DISTINCT isect0.`id`, isect0.`id` AS `id1`
                     FROM `operationtbl` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`id`, F1.`id` AS `id1`
                                        FROM `operationtbl` AS F0, `operationtbl` AS F1
                                       WHERE F0.`name`=F1.`name`
                                    ) AS cp
                                WHERE isect0.`id`=cp.`id` AND isect0.`id`=cp.`id1`) AND isect0.`id` IS NOT NULL AND isect0.`id` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Operation '.$v[0][0].',Operation '.$v[0][1].')
reden: \"name[Operation*Text] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule17(){
    // Overtredingen behoren niet voor te komen in (call~;call |- I[Text])
    //            rule':: call~;call/\-I[Text]
    // sqlExprSrc fSpec rule':: call
     $v=DB_doquer('SELECT DISTINCT isect0.`call`, isect0.`call1`
                     FROM 
                        ( SELECT DISTINCT F0.`call`, F1.`call` AS `call1`
                            FROM `operationtbl` AS F0, `operationtbl` AS F1
                           WHERE F0.`id`=F1.`id`
                        ) AS isect0
                    WHERE isect0.`call` <> isect0.`call1` AND isect0.`call` IS NOT NULL AND isect0.`call1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Text '.$v[0][0].',Text '.$v[0][1].')
reden: \"call[Operation*Text] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule18(){
    // Overtredingen behoren niet voor te komen in (I[Operation] |- call;call~)
    //            rule':: I[Operation]/\-(call;call~)
    // sqlExprSrc fSpec rule':: id
     $v=DB_doquer('SELECT DISTINCT isect0.`id`, isect0.`id` AS `id1`
                     FROM `operationtbl` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`id`, F1.`id` AS `id1`
                                        FROM `operationtbl` AS F0, `operationtbl` AS F1
                                       WHERE F0.`call`=F1.`call`
                                    ) AS cp
                                WHERE isect0.`id`=cp.`id` AND isect0.`id`=cp.`id1`) AND isect0.`id` IS NOT NULL AND isect0.`id` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Operation '.$v[0][0].',Operation '.$v[0][1].')
reden: \"call[Operation*Text] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule19(){
    // Overtredingen behoren niet voor te komen in (output~;output |- I[Compilation])
    //            rule':: output~;output/\-I[Compilation]
    // sqlExprSrc fSpec rule':: output
     $v=DB_doquer('SELECT DISTINCT isect0.`output`, isect0.`output1`
                     FROM 
                        ( SELECT DISTINCT F0.`output`, F1.`output` AS `output1`
                            FROM `operationtbl` AS F0, `operationtbl` AS F1
                           WHERE F0.`id`=F1.`id`
                        ) AS isect0
                    WHERE isect0.`output` <> isect0.`output1` AND isect0.`output` IS NOT NULL AND isect0.`output1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Compilation '.$v[0][0].',Compilation '.$v[0][1].')
reden: \"output[Operation*Compilation] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule20(){
    // Overtredingen behoren niet voor te komen in (I[Operation] |- output;output~)
    //            rule':: I[Operation]/\-(output;output~)
    // sqlExprSrc fSpec rule':: id
     $v=DB_doquer('SELECT DISTINCT isect0.`id`, isect0.`id` AS `id1`
                     FROM `operationtbl` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`id`, F1.`id` AS `id1`
                                        FROM `operationtbl` AS F0, `operationtbl` AS F1
                                       WHERE F0.`output`=F1.`output`
                                    ) AS cp
                                WHERE isect0.`id`=cp.`id` AND isect0.`id`=cp.`id1`) AND isect0.`id` IS NOT NULL AND isect0.`id` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Operation '.$v[0][0].',Operation '.$v[0][1].')
reden: \"output[Operation*Compilation] is total\"<BR>',3);
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
    checkRule17();
    checkRule18();
    checkRule19();
    checkRule20();
  }
?>