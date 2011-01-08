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
  $DB_slct = mysql_select_db('Historie',$DB_link);
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
    // Overtredingen horen niet voor te komen in (RULE actuele inhoud MAINTAINS versie~;object;inhoud;versie |- lt \/ I[Versie])
    //            rule':: versie~;object;inhoud;versie/\-lt/\-I[Versie]
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`versie`, isect0.`versie1`
                                 FROM 
                                    ( SELECT DISTINCT F0.`versie`, F3.`versie` AS `versie1`
                                        FROM `Inhoud` AS F0, `Inhoud` AS F1, `Object` AS F2, `Inhoud` AS F3
                                       WHERE F0.`I`=F1.`I`
                                       AND F1.`object`=F2.`I`
                                       AND F2.`inhoud`=F3.`I`
                                    ) AS isect0
                                WHERE NOT EXISTS (SELECT *
                                             FROM `lt` AS cp
                                            WHERE isect0.`versie`=cp.`s_Versie` AND isect0.`versie1`=cp.`t_Versie`) AND isect0.`versie` <> isect0.`versie1` AND isect0.`versie` IS NOT NULL AND isect0.`versie1` IS NOT NULL');
    $v=array();
    if(is_array($isct))
    foreach($isct as $source=>$t){
      if(is_array($t))
      foreach($t as $i=>$target){
        $v[] = array( '0' => @$source
                    , '1' => @$target);
      }
    }if(count($v)) {
      DB_debug('Overtreding (Versie '.$v[0][0].',Versie '.$v[0][1].')
reden: \"Op elk moment moet een object verwijzen naar zijn actuele inhoud.
Daarom verwijst de relatie \'inhoud\' naar de meest recente inhoud
van een object.

\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule1(){
    // Overtredingen horen niet voor te komen in (RULE Opvolgend versienummer MAINTAINS pre~;post/\object;object~/\-I[Inhoud] |- versie;volgtOp~;versie~)
    //            rule':: pre~;post/\object;object~/\-I[Inhoud]/\-(versie;volgtOp~;versie~)
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`Inhoud`, isect0.`Inhoud1`
                                 FROM 
                                    ( SELECT DISTINCT F0.`Inhoud`, F1.`Inhoud` AS `Inhoud1`
                                        FROM `pre` AS F0, `post` AS F1
                                       WHERE F0.`Gebeurtenis`=F1.`Gebeurtenis`
                                    ) AS isect0, 
                                    ( SELECT DISTINCT F0.`I`, F1.`I` AS `I1`
                                        FROM `Inhoud` AS F0, `Inhoud` AS F1
                                       WHERE F0.`object`=F1.`object`
                                    ) AS isect1
                                WHERE (isect0.`Inhoud` = isect1.`I` AND isect0.`Inhoud1` = isect1.`I1`) AND isect0.`Inhoud` <> isect0.`Inhoud1` AND NOT EXISTS (SELECT *
                                             FROM 
                                                ( SELECT DISTINCT F0.`I`, F2.`I` AS `I1`
                                                    FROM `Inhoud` AS F0, `volgtOp` AS F1, `Inhoud` AS F2
                                                   WHERE F0.`versie`=F1.`t_Versie`
                                                   AND F1.`s_Versie`=F2.`versie`
                                                ) AS cp
                                            WHERE isect0.`Inhoud`=cp.`I` AND isect0.`Inhoud1`=cp.`I1`) AND isect0.`Inhoud` IS NOT NULL AND isect0.`Inhoud1` IS NOT NULL');
    $v=array();
    if(is_array($isct))
    foreach($isct as $source=>$t){
      if(is_array($t))
      foreach($t as $i=>$target){
        $v[] = array( '0' => @$source
                    , '1' => @$target);
      }
    }if(count($v)) {
      DB_debug('Overtreding (Inhoud '.$v[0][0].',Inhoud '.$v[0][1].')
reden: \"Van elke inhoud wordt een versie bijgehouden, om voor gebruikers de
leeftijd ten opzichte van andere inhouden zichtbaar te maken. Als
een inhoud verandert, krijgt die een opvolgende versie toegekend.

Als door het optreden van een gebeurtenis de inhoud van een object
is veranderd, dan is de versie van de nieuwe inhoud gelijk aan de
opvolger van de versie heeft de oude inhoud.
\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule2(){
    // Overtredingen horen niet voor te komen in (RULE volgtOp irreflexief MAINTAINS volgtOp |- -I[Versie])
    //            rule':: volgtOp/\I[Versie]
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`s_Versie`, isect0.`t_Versie`
                                 FROM `volgtOp` AS isect0, `Versie` AS isect1
                                WHERE isect0.`s_Versie` = isect0.`t_Versie` AND isect0.`s_Versie` IS NOT NULL AND isect0.`t_Versie` IS NOT NULL');
    $v=array();
    if(is_array($isct))
    foreach($isct as $source=>$t){
      if(is_array($t))
      foreach($t as $i=>$target){
        $v[] = array( '0' => @$source
                    , '1' => @$target);
      }
    }if(count($v)) {
      DB_debug('Overtreding (Versie '.$v[0][0].',Versie '.$v[0][1].')
reden: \"\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule3(){
    // Overtredingen horen niet voor te komen in (RULE kleiner dan MAINTAINS (I[Versie] \/ lt);volgtOp~ |- lt)
    //            rule':: (volgtOp~ \/ lt;volgtOp~)/\-lt
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`t_Versie`, isect0.`s_Versie`
                                 FROM 
                                    ( SELECT DISTINCT isect0.`t_Versie`, isect0.`s_Versie`
                                        FROM `volgtOp` AS isect0, 
                                           ( SELECT DISTINCT F0.`s_Versie`, F1.`s_Versie` AS `s_Versie1`
                                               FROM `lt` AS F0, `volgtOp` AS F1
                                              WHERE F0.`t_Versie`=F1.`t_Versie`
                                           ) AS isect1
                                       WHERE (isect0.`t_Versie` = isect1.`s_Versie` AND isect0.`s_Versie` = isect1.`s_Versie1`) AND isect0.`t_Versie` IS NOT NULL AND isect0.`s_Versie` IS NOT NULL
                                    ) AS isect0
                                WHERE NOT EXISTS (SELECT *
                                             FROM `lt` AS cp
                                            WHERE isect0.`t_Versie`=cp.`s_Versie` AND isect0.`s_Versie`=cp.`t_Versie`) AND isect0.`t_Versie` IS NOT NULL AND isect0.`s_Versie` IS NOT NULL');
    $v=array();
    if(is_array($isct))
    foreach($isct as $source=>$t){
      if(is_array($t))
      foreach($t as $i=>$target){
        $v[] = array( '0' => @$source
                    , '1' => @$target);
      }
    }if(count($v)) {
      DB_debug('Overtreding (Versie '.$v[0][0].',Versie '.$v[0][1].')
reden: \"\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule4(){
    // Overtredingen horen niet voor te komen in (RULE changelog MAINTAINS changed = (pre/\post;-I[Inhoud]);object/\(post/\pre;-I[Inhoud]);object)
    //            rule':: (-changed \/ -((pre/\post;-I[Inhoud]);object) \/ -((post/\pre;-I[Inhoud]);object))/\((pre/\post;-I[Inhoud]);object \/ changed)/\((post/\pre;-I[Inhoud]);object \/ changed)
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`Gebeurtenis`, isect0.`Object`
                                 FROM 
                                    ( SELECT DISTINCT isect0.`Gebeurtenis`, isect0.`Object`
                                        FROM 
                                           ( SELECT DISTINCT cfst.`I` AS `Gebeurtenis`, csnd.`I1` AS `Object`
                                               FROM `Gebeurtenis` AS cfst, ( SELECT DISTINCT `I` AS `I1`
                                                 FROM `Object` ) AS csnd
                                              WHERE NOT EXISTS (SELECT *
                                                           FROM `changed` AS cp
                                                          WHERE cfst.`I`=cp.`Gebeurtenis` AND csnd.`I1`=cp.`Object`)
                                           ) AS isect0
                                       WHERE NOT EXISTS (SELECT *
                                                    FROM 
                                                       ( SELECT DISTINCT F0.`Gebeurtenis`, F1.`object`
                                                           FROM 
                                                              ( SELECT DISTINCT isect0.`Gebeurtenis`, isect0.`Inhoud`
                                                                  FROM `pre` AS isect0, 
                                                                     ( SELECT DISTINCT F0.`Gebeurtenis`, c2.`I`
                                                                         FROM `Inhoud` AS c2, `post` AS F0
                                                                        WHERE NOT EXISTS (SELECT *
                                                                                     FROM ( SELECT DISTINCT `I`, `I` AS `I1`
                                                                           FROM `Inhoud` ) AS F1
                                                                                    WHERE F0.`Inhoud`=F1.`I` AND F1.`I1`=c2.`I`)
                                                                        AND c2.`I` IS NOT NULL
                                                                     ) AS isect1
                                                                 WHERE (isect0.`Gebeurtenis` = isect1.`Gebeurtenis` AND isect0.`Inhoud` = isect1.`I`) AND isect0.`Gebeurtenis` IS NOT NULL AND isect0.`Inhoud` IS NOT NULL
                                                              ) AS F0, `Inhoud` AS F1
                                                          WHERE F0.`Inhoud`=F1.`I`
                                                       ) AS cp
                                                   WHERE isect0.`Gebeurtenis`=cp.`Gebeurtenis` AND isect0.`Object`=cp.`object`) AND NOT EXISTS (SELECT *
                                                    FROM 
                                                       ( SELECT DISTINCT F0.`Gebeurtenis`, F1.`object`
                                                           FROM 
                                                              ( SELECT DISTINCT isect0.`Gebeurtenis`, isect0.`Inhoud`
                                                                  FROM `post` AS isect0, 
                                                                     ( SELECT DISTINCT F0.`Gebeurtenis`, c2.`I`
                                                                         FROM `Inhoud` AS c2, `pre` AS F0
                                                                        WHERE NOT EXISTS (SELECT *
                                                                                     FROM ( SELECT DISTINCT `I`, `I` AS `I1`
                                                                           FROM `Inhoud` ) AS F1
                                                                                    WHERE F0.`Inhoud`=F1.`I` AND F1.`I1`=c2.`I`)
                                                                        AND c2.`I` IS NOT NULL
                                                                     ) AS isect1
                                                                 WHERE (isect0.`Gebeurtenis` = isect1.`Gebeurtenis` AND isect0.`Inhoud` = isect1.`I`) AND isect0.`Gebeurtenis` IS NOT NULL AND isect0.`Inhoud` IS NOT NULL
                                                              ) AS F0, `Inhoud` AS F1
                                                          WHERE F0.`Inhoud`=F1.`I`
                                                       ) AS cp
                                                   WHERE isect0.`Gebeurtenis`=cp.`Gebeurtenis` AND isect0.`Object`=cp.`object`) AND isect0.`Gebeurtenis` IS NOT NULL AND isect0.`Object` IS NOT NULL
                                    ) AS isect0, 
                                    ( SELECT DISTINCT isect0.`Gebeurtenis`, isect0.`object`
                                        FROM 
                                           ( SELECT DISTINCT F0.`Gebeurtenis`, F1.`object`
                                               FROM 
                                                  ( SELECT DISTINCT isect0.`Gebeurtenis`, isect0.`Inhoud`
                                                      FROM `pre` AS isect0, 
                                                         ( SELECT DISTINCT F0.`Gebeurtenis`, c2.`I`
                                                             FROM `Inhoud` AS c2, `post` AS F0
                                                            WHERE NOT EXISTS (SELECT *
                                                                         FROM ( SELECT DISTINCT `I`, `I` AS `I1`
                                                               FROM `Inhoud` ) AS F1
                                                                        WHERE F0.`Inhoud`=F1.`I` AND F1.`I1`=c2.`I`)
                                                            AND c2.`I` IS NOT NULL
                                                         ) AS isect1
                                                     WHERE (isect0.`Gebeurtenis` = isect1.`Gebeurtenis` AND isect0.`Inhoud` = isect1.`I`) AND isect0.`Gebeurtenis` IS NOT NULL AND isect0.`Inhoud` IS NOT NULL
                                                  ) AS F0, `Inhoud` AS F1
                                              WHERE F0.`Inhoud`=F1.`I`
                                           ) AS isect0, `changed` AS isect1
                                       WHERE (isect0.`Gebeurtenis` = isect1.`Gebeurtenis` AND isect0.`object` = isect1.`Object`) AND isect0.`Gebeurtenis` IS NOT NULL AND isect0.`object` IS NOT NULL
                                    ) AS isect1, 
                                    ( SELECT DISTINCT isect0.`Gebeurtenis`, isect0.`object`
                                        FROM 
                                           ( SELECT DISTINCT F0.`Gebeurtenis`, F1.`object`
                                               FROM 
                                                  ( SELECT DISTINCT isect0.`Gebeurtenis`, isect0.`Inhoud`
                                                      FROM `post` AS isect0, 
                                                         ( SELECT DISTINCT F0.`Gebeurtenis`, c2.`I`
                                                             FROM `Inhoud` AS c2, `pre` AS F0
                                                            WHERE NOT EXISTS (SELECT *
                                                                         FROM ( SELECT DISTINCT `I`, `I` AS `I1`
                                                               FROM `Inhoud` ) AS F1
                                                                        WHERE F0.`Inhoud`=F1.`I` AND F1.`I1`=c2.`I`)
                                                            AND c2.`I` IS NOT NULL
                                                         ) AS isect1
                                                     WHERE (isect0.`Gebeurtenis` = isect1.`Gebeurtenis` AND isect0.`Inhoud` = isect1.`I`) AND isect0.`Gebeurtenis` IS NOT NULL AND isect0.`Inhoud` IS NOT NULL
                                                  ) AS F0, `Inhoud` AS F1
                                              WHERE F0.`Inhoud`=F1.`I`
                                           ) AS isect0, `changed` AS isect1
                                       WHERE (isect0.`Gebeurtenis` = isect1.`Gebeurtenis` AND isect0.`object` = isect1.`Object`) AND isect0.`Gebeurtenis` IS NOT NULL AND isect0.`object` IS NOT NULL
                                    ) AS isect2
                                WHERE (isect0.`Gebeurtenis` = isect1.`Gebeurtenis` AND isect0.`Object` = isect1.`object`) AND (isect0.`Gebeurtenis` = isect2.`Gebeurtenis` AND isect0.`Object` = isect2.`object`) AND isect0.`Gebeurtenis` IS NOT NULL AND isect0.`Object` IS NOT NULL');
    $v=array();
    if(is_array($isct))
    foreach($isct as $source=>$t){
      if(is_array($t))
      foreach($t as $i=>$target){
        $v[] = array( '0' => @$source
                    , '1' => @$target);
      }
    }if(count($v)) {
      DB_debug('Overtreding (Gebeurtenis '.$v[0][0].',Object '.$v[0][1].')
reden: \"In de \'changelog\' kan van elke gebeurtenis die geleid heeft tot
inhoudelijke veranderingen worden vastgesteld welke objecten dat
betrof. Ook omgekeerd kan van elk object worden teruggevonden welke
gebeurtenissen hebben geleid tot inhoudelijke veranderingen in het
object.

\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule6(){
    // Overtredingen horen niet voor te komen in (RULE Rule6 MAINTAINS onderbouwt;betreft |- persoonsdossier)
    //            rule':: onderbouwt;betreft/\-persoonsdossier
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`Document`, isect0.`Persoon`
                                 FROM 
                                    ( SELECT DISTINCT F0.`Document`, F1.`Persoon`
                                        FROM `onderbouwt` AS F0, `betreft` AS F1
                                       WHERE F0.`Feit`=F1.`Feit`
                                    ) AS isect0
                                WHERE NOT EXISTS (SELECT *
                                             FROM `persoonsdossier` AS cp
                                            WHERE isect0.`Document`=cp.`Document` AND isect0.`Persoon`=cp.`Persoon`) AND isect0.`Document` IS NOT NULL AND isect0.`Persoon` IS NOT NULL');
    $v=array();
    if(is_array($isct))
    foreach($isct as $source=>$t){
      if(is_array($t))
      foreach($t as $i=>$target){
        $v[] = array( '0' => @$source
                    , '1' => @$target);
      }
    }if(count($v)) {
      DB_debug('Overtreding (Document '.$v[0][0].',Persoon '.$v[0][1].')
reden: \"Alle onderbouwing van feiten betreffende een persoon moeten in
diens persoonsdossier voorkomen.
\"<BR>',3);
      return false;
    }return true;
  }
  
  if($DB_debug>=3){
    checkRule0();
    checkRule1();
    checkRule2();
    checkRule3();
    checkRule4();
    checkRule6();
  }
?>