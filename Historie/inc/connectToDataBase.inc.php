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
    // Overtredingen horen niet voor te komen in (RULE opvolgend versienummer MAINTAINS pre~;post/\object;object~/\-I[Inhoud] |- versie;isOpvolgerVan~;versie~)
    //            rule':: pre~;post/\object;object~/\-I[Inhoud]/\-(versie;isOpvolgerVan~;versie~)
    
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
                                                    FROM `Inhoud` AS F0, `Versie` AS F1, `Inhoud` AS F2
                                                   WHERE F0.`versie`=F1.`I`
                                                   AND F1.`isOpvolgerVan`=F2.`versie`
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
    // Overtredingen horen niet voor te komen in (RULE isOpvolgerVan irreflexief MAINTAINS isOpvolgerVan |- -I[Versie])
    //            rule':: isOpvolgerVan/\I[Versie]
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`isOpvolgerVan`, isect0.`I`
                                 FROM `Versie` AS isect0, `Versie` AS isect1
                                WHERE isect0.`isOpvolgerVan` = isect0.`I` AND isect0.`isOpvolgerVan` IS NOT NULL AND isect0.`I` IS NOT NULL');
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
    // Overtredingen horen niet voor te komen in (RULE ouder dan MAINTAINS (I[Versie] \/ lt);isOpvolgerVan~ |- lt)
    //            rule':: (isOpvolgerVan~ \/ lt;isOpvolgerVan~)/\-lt
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`I`, isect0.`isOpvolgerVan`
                                 FROM 
                                    ( SELECT DISTINCT isect0.`I`, isect0.`isOpvolgerVan`
                                        FROM `Versie` AS isect0, 
                                           ( SELECT DISTINCT F0.`s_Versie`, F1.`isOpvolgerVan`
                                               FROM `lt` AS F0, `Versie` AS F1
                                              WHERE F0.`t_Versie`=F1.`I`
                                           ) AS isect1
                                       WHERE (isect0.`I` = isect1.`s_Versie` AND isect0.`isOpvolgerVan` = isect1.`isOpvolgerVan`) AND isect0.`I` IS NOT NULL AND isect0.`isOpvolgerVan` IS NOT NULL
                                    ) AS isect0
                                WHERE NOT EXISTS (SELECT *
                                             FROM `lt` AS cp
                                            WHERE isect0.`I`=cp.`s_Versie` AND isect0.`isOpvolgerVan`=cp.`t_Versie`) AND isect0.`I` IS NOT NULL AND isect0.`isOpvolgerVan` IS NOT NULL');
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
    // Overtredingen horen niet voor te komen in (RULE Rule4 MAINTAINS isVoorgangerVan |- -I[Inhoud])
    //            rule':: isVoorgangerVan/\I[Inhoud]
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`I`, isect0.`isVoorgangerVan`
                                 FROM `Inhoud` AS isect0, `Inhoud` AS isect1
                                WHERE isect0.`I` = isect0.`isVoorgangerVan` AND isect0.`I` IS NOT NULL AND isect0.`isVoorgangerVan` IS NOT NULL');
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
reden: \"de relatie \'isVoorgangerVan\' is irreflexief.
\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule5(){
    // Overtredingen horen niet voor te komen in (RULE voorganger MAINTAINS isVoorgangerVan = post~;pre/\versie;isOpvolgerVan;versie~/\object;object~)
    //            rule':: (-isVoorgangerVan \/ -(post~;pre) \/ -(versie;isOpvolgerVan;versie~) \/ -(object;object~))/\(post~;pre \/ isVoorgangerVan)/\(versie;isOpvolgerVan;versie~ \/ isVoorgangerVan)/\(object;object~ \/ isVoorgangerVan)
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`I`, isect0.`isVoorgangerVan`
                                 FROM 
                                    ( SELECT DISTINCT isect0.`I`, isect0.`isVoorgangerVan`
                                        FROM 
                                           ( SELECT DISTINCT cfst.`I`, csnd.`I1` AS `isVoorgangerVan`
                                               FROM `Inhoud` AS cfst, ( SELECT DISTINCT `I` AS `I1`
                                                 FROM `Inhoud` ) AS csnd
                                              WHERE NOT EXISTS (SELECT *
                                                           FROM `Inhoud` AS cp
                                                          WHERE cfst.`I`=cp.`I` AND csnd.`I1`=cp.`isVoorgangerVan`)
                                           ) AS isect0
                                       WHERE NOT EXISTS (SELECT *
                                                    FROM 
                                                       ( SELECT DISTINCT F0.`Inhoud`, F1.`Inhoud` AS `Inhoud1`
                                                           FROM `post` AS F0, `pre` AS F1
                                                          WHERE F0.`Gebeurtenis`=F1.`Gebeurtenis`
                                                       ) AS cp
                                                   WHERE isect0.`I`=cp.`Inhoud` AND isect0.`isVoorgangerVan`=cp.`Inhoud1`) AND NOT EXISTS (SELECT *
                                                    FROM 
                                                       ( SELECT DISTINCT F0.`I`, F2.`I` AS `I1`
                                                           FROM `Inhoud` AS F0, `Versie` AS F1, `Inhoud` AS F2
                                                          WHERE F0.`versie`=F1.`isOpvolgerVan`
                                                          AND F1.`I`=F2.`versie`
                                                       ) AS cp
                                                   WHERE isect0.`I`=cp.`I` AND isect0.`isVoorgangerVan`=cp.`I1`) AND NOT EXISTS (SELECT *
                                                    FROM 
                                                       ( SELECT DISTINCT F0.`I`, F1.`I` AS `I1`
                                                           FROM `Inhoud` AS F0, `Inhoud` AS F1
                                                          WHERE F0.`object`=F1.`object`
                                                       ) AS cp
                                                   WHERE isect0.`I`=cp.`I` AND isect0.`isVoorgangerVan`=cp.`I1`) AND isect0.`I` IS NOT NULL AND isect0.`isVoorgangerVan` IS NOT NULL
                                    ) AS isect0, 
                                    ( SELECT DISTINCT isect0.`Inhoud`, isect0.`Inhoud1`
                                        FROM 
                                           ( SELECT DISTINCT F0.`Inhoud`, F1.`Inhoud` AS `Inhoud1`
                                               FROM `post` AS F0, `pre` AS F1
                                              WHERE F0.`Gebeurtenis`=F1.`Gebeurtenis`
                                           ) AS isect0, `Inhoud` AS isect1
                                       WHERE (isect0.`Inhoud` = isect1.`I` AND isect0.`Inhoud1` = isect1.`isVoorgangerVan`) AND isect0.`Inhoud` IS NOT NULL AND isect0.`Inhoud1` IS NOT NULL
                                    ) AS isect1, 
                                    ( SELECT DISTINCT isect0.`I`, isect0.`I1`
                                        FROM 
                                           ( SELECT DISTINCT F0.`I`, F2.`I` AS `I1`
                                               FROM `Inhoud` AS F0, `Versie` AS F1, `Inhoud` AS F2
                                              WHERE F0.`versie`=F1.`isOpvolgerVan`
                                              AND F1.`I`=F2.`versie`
                                           ) AS isect0, `Inhoud` AS isect1
                                       WHERE (isect0.`I` = isect1.`I` AND isect0.`I1` = isect1.`isVoorgangerVan`) AND isect0.`I` IS NOT NULL AND isect0.`I1` IS NOT NULL
                                    ) AS isect2, 
                                    ( SELECT DISTINCT isect0.`I`, isect0.`I1`
                                        FROM 
                                           ( SELECT DISTINCT F0.`I`, F1.`I` AS `I1`
                                               FROM `Inhoud` AS F0, `Inhoud` AS F1
                                              WHERE F0.`object`=F1.`object`
                                           ) AS isect0, `Inhoud` AS isect1
                                       WHERE (isect0.`I` = isect1.`I` AND isect0.`I1` = isect1.`isVoorgangerVan`) AND isect0.`I` IS NOT NULL AND isect0.`I1` IS NOT NULL
                                    ) AS isect3
                                WHERE (isect0.`I` = isect1.`Inhoud` AND isect0.`isVoorgangerVan` = isect1.`Inhoud1`) AND (isect0.`I` = isect2.`I` AND isect0.`isVoorgangerVan` = isect2.`I1`) AND (isect0.`I` = isect3.`I` AND isect0.`isVoorgangerVan` = isect3.`I1`) AND isect0.`I` IS NOT NULL AND isect0.`isVoorgangerVan` IS NOT NULL');
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
reden: \"Van elke inhoud moet traceerbaar zijn volgens welk pad van
bewerkingen/veranderingen die inhoud tot stand is gekomen. Daartoe
moet van elke inhoud diens directe voorganger bekend zijn. Deze
directe voorganger is de inhoud die middels een enkele bewerking
werd getransformeerd in de inhoud waarvan het de voorganger is.
Echter, omdat bewerkingen meerdere inhouden kunnen transformeren,
moet de versie van de inhoud ook volgen op die van diens
voorganger, en moeten beide inhouden hetzelfde object betreffen.

Inhoud X is de voorganger van inhoud Y als er een gebeurtenis is
waarin X werd getransformeerd in Y en vice versa.
\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule6(){
    // Overtredingen horen niet voor te komen in (RULE Rule6 MAINTAINS isOpvolgerVan |- -I[Versie])
    //            rule':: isOpvolgerVan/\I[Versie]
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`isOpvolgerVan`, isect0.`I`
                                 FROM `Versie` AS isect0, `Versie` AS isect1
                                WHERE isect0.`isOpvolgerVan` = isect0.`I` AND isect0.`isOpvolgerVan` IS NOT NULL AND isect0.`I` IS NOT NULL');
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
reden: \"de relatie \'isOpvolgerVan\' is irreflexief.
\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule7(){
    // Overtredingen horen niet voor te komen in (RULE directe opvolgers MAINTAINS isDirecteOpvolgerVan = pre~;post/\versie;isOpvolgerVan~;versie~/\object;object~)
    //            rule':: (-isDirecteOpvolgerVan \/ -(pre~;post) \/ -(versie;isOpvolgerVan~;versie~) \/ -(object;object~))/\(pre~;post \/ isDirecteOpvolgerVan)/\(versie;isOpvolgerVan~;versie~ \/ isDirecteOpvolgerVan)/\(object;object~ \/ isDirecteOpvolgerVan)
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`s_Inhoud`, isect0.`t_Inhoud`
                                 FROM 
                                    ( SELECT DISTINCT isect0.`s_Inhoud`, isect0.`t_Inhoud`
                                        FROM 
                                           ( SELECT DISTINCT cfst.`I` AS `s_Inhoud`, csnd.`I1` AS `t_Inhoud`
                                               FROM `Inhoud` AS cfst, ( SELECT DISTINCT `I` AS `I1`
                                                 FROM `Inhoud` ) AS csnd
                                              WHERE NOT EXISTS (SELECT *
                                                           FROM `isDirecteOpvolgerVan` AS cp
                                                          WHERE cfst.`I`=cp.`s_Inhoud` AND csnd.`I1`=cp.`t_Inhoud`)
                                           ) AS isect0
                                       WHERE NOT EXISTS (SELECT *
                                                    FROM 
                                                       ( SELECT DISTINCT F0.`Inhoud`, F1.`Inhoud` AS `Inhoud1`
                                                           FROM `pre` AS F0, `post` AS F1
                                                          WHERE F0.`Gebeurtenis`=F1.`Gebeurtenis`
                                                       ) AS cp
                                                   WHERE isect0.`s_Inhoud`=cp.`Inhoud` AND isect0.`t_Inhoud`=cp.`Inhoud1`) AND NOT EXISTS (SELECT *
                                                    FROM 
                                                       ( SELECT DISTINCT F0.`I`, F2.`I` AS `I1`
                                                           FROM `Inhoud` AS F0, `Versie` AS F1, `Inhoud` AS F2
                                                          WHERE F0.`versie`=F1.`I`
                                                          AND F1.`isOpvolgerVan`=F2.`versie`
                                                       ) AS cp
                                                   WHERE isect0.`s_Inhoud`=cp.`I` AND isect0.`t_Inhoud`=cp.`I1`) AND NOT EXISTS (SELECT *
                                                    FROM 
                                                       ( SELECT DISTINCT F0.`I`, F1.`I` AS `I1`
                                                           FROM `Inhoud` AS F0, `Inhoud` AS F1
                                                          WHERE F0.`object`=F1.`object`
                                                       ) AS cp
                                                   WHERE isect0.`s_Inhoud`=cp.`I` AND isect0.`t_Inhoud`=cp.`I1`) AND isect0.`s_Inhoud` IS NOT NULL AND isect0.`t_Inhoud` IS NOT NULL
                                    ) AS isect0, 
                                    ( SELECT DISTINCT isect0.`Inhoud`, isect0.`Inhoud1`
                                        FROM 
                                           ( SELECT DISTINCT F0.`Inhoud`, F1.`Inhoud` AS `Inhoud1`
                                               FROM `pre` AS F0, `post` AS F1
                                              WHERE F0.`Gebeurtenis`=F1.`Gebeurtenis`
                                           ) AS isect0, `isDirecteOpvolgerVan` AS isect1
                                       WHERE (isect0.`Inhoud` = isect1.`s_Inhoud` AND isect0.`Inhoud1` = isect1.`t_Inhoud`) AND isect0.`Inhoud` IS NOT NULL AND isect0.`Inhoud1` IS NOT NULL
                                    ) AS isect1, 
                                    ( SELECT DISTINCT isect0.`I`, isect0.`I1`
                                        FROM 
                                           ( SELECT DISTINCT F0.`I`, F2.`I` AS `I1`
                                               FROM `Inhoud` AS F0, `Versie` AS F1, `Inhoud` AS F2
                                              WHERE F0.`versie`=F1.`I`
                                              AND F1.`isOpvolgerVan`=F2.`versie`
                                           ) AS isect0, `isDirecteOpvolgerVan` AS isect1
                                       WHERE (isect0.`I` = isect1.`s_Inhoud` AND isect0.`I1` = isect1.`t_Inhoud`) AND isect0.`I` IS NOT NULL AND isect0.`I1` IS NOT NULL
                                    ) AS isect2, 
                                    ( SELECT DISTINCT isect0.`I`, isect0.`I1`
                                        FROM 
                                           ( SELECT DISTINCT F0.`I`, F1.`I` AS `I1`
                                               FROM `Inhoud` AS F0, `Inhoud` AS F1
                                              WHERE F0.`object`=F1.`object`
                                           ) AS isect0, `isDirecteOpvolgerVan` AS isect1
                                       WHERE (isect0.`I` = isect1.`s_Inhoud` AND isect0.`I1` = isect1.`t_Inhoud`) AND isect0.`I` IS NOT NULL AND isect0.`I1` IS NOT NULL
                                    ) AS isect3
                                WHERE (isect0.`s_Inhoud` = isect1.`Inhoud` AND isect0.`t_Inhoud` = isect1.`Inhoud1`) AND (isect0.`s_Inhoud` = isect2.`I` AND isect0.`t_Inhoud` = isect2.`I1`) AND (isect0.`s_Inhoud` = isect3.`I` AND isect0.`t_Inhoud` = isect3.`I1`) AND isect0.`s_Inhoud` IS NOT NULL AND isect0.`t_Inhoud` IS NOT NULL');
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
reden: \"Vanuit elke inhoud willen we kunnen navigeren naar de verzameling
van verschillende inhouden die daaruit zijn ontstaan. De
verzameling van (directe) opvolgers van een zekere inhoud zijn die
inhouden die middels een enkele bewerking zijn ontstaan uit een
bewerking op die inhoud. Echter, omdat bewerkingen inhouden van
meerdere objecten kunnen transformeren, moet de versie van de
opvolger volgen op die van de bewerkte inhoud, en moeten beide
inhouden hetzelfde object betreffen.

Inhoud Y is een opvolger van inhoud X als er een gebeurtenis is
waarin X werd getransformeerd in Y en vice versa.
\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule8(){
    // Overtredingen horen niet voor te komen in (RULE Rule8 MAINTAINS isOpvolgerVan |- -I[Versie])
    //            rule':: isOpvolgerVan/\I[Versie]
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`isOpvolgerVan`, isect0.`I`
                                 FROM `Versie` AS isect0, `Versie` AS isect1
                                WHERE isect0.`isOpvolgerVan` = isect0.`I` AND isect0.`isOpvolgerVan` IS NOT NULL AND isect0.`I` IS NOT NULL');
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
reden: \"de relatie \'isOpvolgerVan\' is irreflexief.
\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule9(){
    // Overtredingen horen niet voor te komen in (RULE alle opvolgers MAINTAINS isDirecteOpvolgerVan;(I[Inhoud] \/ isIndirecteOpvolgerVan) |- isIndirecteOpvolgerVan)
    //            rule':: (isDirecteOpvolgerVan \/ isDirecteOpvolgerVan;isIndirecteOpvolgerVan)/\-isIndirecteOpvolgerVan
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`s_Inhoud`, isect0.`t_Inhoud`
                                 FROM 
                                    ( SELECT DISTINCT isect0.`s_Inhoud`, isect0.`t_Inhoud`
                                        FROM `isDirecteOpvolgerVan` AS isect0, 
                                           ( SELECT DISTINCT F0.`s_Inhoud`, F1.`t_Inhoud`
                                               FROM `isDirecteOpvolgerVan` AS F0, `isIndirecteOpvolgerVan` AS F1
                                              WHERE F0.`t_Inhoud`=F1.`s_Inhoud`
                                           ) AS isect1
                                       WHERE (isect0.`s_Inhoud` = isect1.`s_Inhoud` AND isect0.`t_Inhoud` = isect1.`t_Inhoud`) AND isect0.`s_Inhoud` IS NOT NULL AND isect0.`t_Inhoud` IS NOT NULL
                                    ) AS isect0
                                WHERE NOT EXISTS (SELECT *
                                             FROM `isIndirecteOpvolgerVan` AS cp
                                            WHERE isect0.`s_Inhoud`=cp.`s_Inhoud` AND isect0.`t_Inhoud`=cp.`t_Inhoud`) AND isect0.`s_Inhoud` IS NOT NULL AND isect0.`t_Inhoud` IS NOT NULL');
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
reden: \"Een historische database wordt geacht alleen die inhouden te
bevatten die deel uitmaken van de geschiedenis van de verzameling
inhouden van het actuele moment. Daarom moet van elke inhoud kunnen
worden vastgesteld dat tenminste 1 inhoud bestaat die actueel is
voor het huidige moment en die een (indirecte) opvolger is van deze
(eerste) inhoud.

Inhoud Y is een indirecte opvolger van inhoud X als er een of meer
gebeurtenissen zijn waarin X werd getransformeerd in Y en vice
versa.
\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule10(){
    // Overtredingen horen niet voor te komen in (RULE database schoon houden MAINTAINS object;inhoud |- I[Inhoud] \/ isIndirecteOpvolgerVan~)
    //            rule':: object;inhoud/\-I[Inhoud]/\-isIndirecteOpvolgerVan~
    
    $isct = DB_doquer_lookups('SELECT DISTINCT isect0.`I`, isect0.`inhoud`
                                 FROM 
                                    ( SELECT DISTINCT F0.`I`, F1.`inhoud`
                                        FROM `Inhoud` AS F0, `Object` AS F1
                                       WHERE F0.`object`=F1.`I`
                                    ) AS isect0
                                WHERE isect0.`I` <> isect0.`inhoud` AND NOT EXISTS (SELECT *
                                             FROM `isIndirecteOpvolgerVan` AS cp
                                            WHERE isect0.`I`=cp.`t_Inhoud` AND isect0.`inhoud`=cp.`s_Inhoud`) AND isect0.`I` IS NOT NULL AND isect0.`inhoud` IS NOT NULL');
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
reden: \"Een historische database wordt geacht alleen die inhouden te
bevatten die deel uitmaken van de geschiedenis van de verzameling
inhouden van het actuele moment.

\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule11(){
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
  
  function checkRule13(){
    // Overtredingen horen niet voor te komen in (RULE Rule13 MAINTAINS onderbouwt;betreft |- persoonsdossier)
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
    checkRule5();
    checkRule6();
    checkRule7();
    checkRule8();
    checkRule9();
    checkRule10();
    checkRule11();
    checkRule13();
  }
?>