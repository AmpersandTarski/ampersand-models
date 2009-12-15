<?php // generated with ADL vs. 0.8.10-478
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
  $DB_slct = mysql_select_db('atlas',$DB_link);
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
    // Overtredingen behoren niet voor te komen in (thepicture~;thepicture |- I[Picture])
    //            rule':: thepicture~;thepicture/\-I[Picture]
    // sqlExprSrc fSpec rule':: thepicture
     $v=DB_doquer('SELECT DISTINCT isect0.`thepicture`, isect0.`thepicture1`
                     FROM 
                        ( SELECT DISTINCT F0.`thepicture`, F1.`thepicture` AS `thepicture1`
                            FROM `picture` AS F0, `picture` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`thepicture` <> isect0.`thepicture1` AND isect0.`thepicture` IS NOT NULL AND isect0.`thepicture1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Picture '.$v[0][0].',Picture '.$v[0][1].')
reden: \"thepicture[Picture*Picture] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule2(){
    // Overtredingen behoren niet voor te komen in (I[Picture] |- thepicture;thepicture~)
    //            rule':: I[Picture]/\-(thepicture;thepicture~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `picture` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `picture` AS F0, `picture` AS F1
                                       WHERE F0.`thepicture`=F1.`thepicture`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Picture '.$v[0][0].',Picture '.$v[0][1].')
reden: \"thepicture[Picture*Picture] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule3(){
    // Overtredingen behoren niet voor te komen in (source~;source |- I[Concept])
    //            rule':: source~;source/\-I[Concept]
    // sqlExprSrc fSpec rule':: source
     $v=DB_doquer('SELECT DISTINCT isect0.`source`, isect0.`source1`
                     FROM 
                        ( SELECT DISTINCT F0.`source`, F1.`source` AS `source1`
                            FROM `type` AS F0, `type` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`source` <> isect0.`source1` AND isect0.`source` IS NOT NULL AND isect0.`source1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Concept '.$v[0][0].',Concept '.$v[0][1].')
reden: \"source[Type*Concept] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule4(){
    // Overtredingen behoren niet voor te komen in (I[Type] |- source;source~)
    //            rule':: I[Type]/\-(source;source~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `type` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `type` AS F0, `type` AS F1
                                       WHERE F0.`source`=F1.`source`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Type '.$v[0][0].',Type '.$v[0][1].')
reden: \"source[Type*Concept] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule5(){
    // Overtredingen behoren niet voor te komen in (target~;target |- I[Concept])
    //            rule':: target~;target/\-I[Concept]
    // sqlExprSrc fSpec rule':: target
     $v=DB_doquer('SELECT DISTINCT isect0.`target`, isect0.`target1`
                     FROM 
                        ( SELECT DISTINCT F0.`target`, F1.`target` AS `target1`
                            FROM `type` AS F0, `type` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`target` <> isect0.`target1` AND isect0.`target` IS NOT NULL AND isect0.`target1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Concept '.$v[0][0].',Concept '.$v[0][1].')
reden: \"target[Type*Concept] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule6(){
    // Overtredingen behoren niet voor te komen in (I[Type] |- target;target~)
    //            rule':: I[Type]/\-(target;target~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `type` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `type` AS F0, `type` AS F1
                                       WHERE F0.`target`=F1.`target`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Type '.$v[0][0].',Type '.$v[0][1].')
reden: \"target[Type*Concept] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule7(){
    // Overtredingen behoren niet voor te komen in (specific~;specific |- I[Concept])
    //            rule':: specific~;specific/\-I[Concept]
    // sqlExprSrc fSpec rule':: specific
     $v=DB_doquer('SELECT DISTINCT isect0.`specific`, isect0.`specific1`
                     FROM 
                        ( SELECT DISTINCT F0.`specific`, F1.`specific` AS `specific1`
                            FROM `isarelation` AS F0, `isarelation` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`specific` <> isect0.`specific1` AND isect0.`specific` IS NOT NULL AND isect0.`specific1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Concept '.$v[0][0].',Concept '.$v[0][1].')
reden: \"specific[IsaRelation*Concept] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule8(){
    // Overtredingen behoren niet voor te komen in (I[IsaRelation] |- specific;specific~)
    //            rule':: I[IsaRelation]/\-(specific;specific~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `isarelation` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `isarelation` AS F0, `isarelation` AS F1
                                       WHERE F0.`specific`=F1.`specific`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (IsaRelation '.$v[0][0].',IsaRelation '.$v[0][1].')
reden: \"specific[IsaRelation*Concept] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule9(){
    // Overtredingen behoren niet voor te komen in (general~;general |- I[Concept])
    //            rule':: general~;general/\-I[Concept]
    // sqlExprSrc fSpec rule':: general
     $v=DB_doquer('SELECT DISTINCT isect0.`general`, isect0.`general1`
                     FROM 
                        ( SELECT DISTINCT F0.`general`, F1.`general` AS `general1`
                            FROM `isarelation` AS F0, `isarelation` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`general` <> isect0.`general1` AND isect0.`general` IS NOT NULL AND isect0.`general1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Concept '.$v[0][0].',Concept '.$v[0][1].')
reden: \"general[IsaRelation*Concept] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule10(){
    // Overtredingen behoren niet voor te komen in (I[IsaRelation] |- general;general~)
    //            rule':: I[IsaRelation]/\-(general;general~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `isarelation` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `isarelation` AS F0, `isarelation` AS F1
                                       WHERE F0.`general`=F1.`general`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (IsaRelation '.$v[0][0].',IsaRelation '.$v[0][1].')
reden: \"general[IsaRelation*Concept] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule11(){
    // Overtredingen behoren niet voor te komen in (property~;I[MultiplicityRule];property |- I[Prop])
    //            rule':: property~;I[MultiplicityRule];property/\-I[Prop]
    // sqlExprSrc fSpec rule':: property
     $v=DB_doquer('SELECT DISTINCT isect0.`property`, isect0.`property1`
                     FROM 
                        ( SELECT DISTINCT F0.`property`, F1.`property` AS `property1`
                            FROM `multiplicityrule` AS F0, `multiplicityrule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`property` <> isect0.`property1` AND isect0.`property` IS NOT NULL AND isect0.`property1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Prop '.$v[0][0].',Prop '.$v[0][1].')
reden: \"property[MultiplicityRule*Prop] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule12(){
    // Overtredingen behoren niet voor te komen in (I[MultiplicityRule] |- property;property~)
    //            rule':: I[MultiplicityRule]/\-(property;property~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `multiplicityrule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `multiplicityrule` AS F0, `multiplicityrule` AS F1
                                       WHERE F0.`property`=F1.`property`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (MultiplicityRule '.$v[0][0].',MultiplicityRule '.$v[0][1].')
reden: \"property[MultiplicityRule*Prop] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule13(){
    // Overtredingen behoren niet voor te komen in (on~;I[MultiplicityRule];on |- I[Relation])
    //            rule':: on~;I[MultiplicityRule];on/\-I[Relation]
    // sqlExprSrc fSpec rule':: on
     $v=DB_doquer('SELECT DISTINCT isect0.`on`, isect0.`on1`
                     FROM 
                        ( SELECT DISTINCT F0.`on`, F1.`on` AS `on1`
                            FROM `multiplicityrule` AS F0, `multiplicityrule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`on` <> isect0.`on1` AND isect0.`on` IS NOT NULL AND isect0.`on1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Relation '.$v[0][0].',Relation '.$v[0][1].')
reden: \"on[MultiplicityRule*Relation] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule14(){
    // Overtredingen behoren niet voor te komen in (I[MultiplicityRule] |- on;on~)
    //            rule':: I[MultiplicityRule]/\-(on;on~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `multiplicityrule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `multiplicityrule` AS F0, `multiplicityrule` AS F1
                                       WHERE F0.`on`=F1.`on`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (MultiplicityRule '.$v[0][0].',MultiplicityRule '.$v[0][1].')
reden: \"on[MultiplicityRule*Relation] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule15(){
    // Overtredingen behoren niet voor te komen in (property~;I[HomogeneousRule];property |- I[Prop])
    //            rule':: property~;I[HomogeneousRule];property/\-I[Prop]
    // sqlExprSrc fSpec rule':: property
     $v=DB_doquer('SELECT DISTINCT isect0.`property`, isect0.`property1`
                     FROM 
                        ( SELECT DISTINCT F0.`property`, F1.`property` AS `property1`
                            FROM `homogeneousrule` AS F0, `homogeneousrule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`property` <> isect0.`property1` AND isect0.`property` IS NOT NULL AND isect0.`property1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Prop '.$v[0][0].',Prop '.$v[0][1].')
reden: \"property[HomogeneousRule*Prop] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule16(){
    // Overtredingen behoren niet voor te komen in (I[HomogeneousRule] |- property;property~)
    //            rule':: I[HomogeneousRule]/\-(property;property~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `homogeneousrule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `homogeneousrule` AS F0, `homogeneousrule` AS F1
                                       WHERE F0.`property`=F1.`property`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (HomogeneousRule '.$v[0][0].',HomogeneousRule '.$v[0][1].')
reden: \"property[HomogeneousRule*Prop] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule17(){
    // Overtredingen behoren niet voor te komen in (on~;I[HomogeneousRule];on |- I[Relation])
    //            rule':: on~;I[HomogeneousRule];on/\-I[Relation]
    // sqlExprSrc fSpec rule':: on
     $v=DB_doquer('SELECT DISTINCT isect0.`on`, isect0.`on1`
                     FROM 
                        ( SELECT DISTINCT F0.`on`, F1.`on` AS `on1`
                            FROM `homogeneousrule` AS F0, `homogeneousrule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`on` <> isect0.`on1` AND isect0.`on` IS NOT NULL AND isect0.`on1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Relation '.$v[0][0].',Relation '.$v[0][1].')
reden: \"on[HomogeneousRule*Relation] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule18(){
    // Overtredingen behoren niet voor te komen in (I[HomogeneousRule] |- on;on~)
    //            rule':: I[HomogeneousRule]/\-(on;on~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `homogeneousrule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `homogeneousrule` AS F0, `homogeneousrule` AS F1
                                       WHERE F0.`on`=F1.`on`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (HomogeneousRule '.$v[0][0].',HomogeneousRule '.$v[0][1].')
reden: \"on[HomogeneousRule*Relation] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule19(){
    // Overtredingen behoren niet voor te komen in (type~;I[Rule];type |- I[Type])
    //            rule':: type~;I[Rule];type/\-I[Type]
    // sqlExprSrc fSpec rule':: type
     $v=DB_doquer('SELECT DISTINCT isect0.`type`, isect0.`type1`
                     FROM 
                        ( SELECT DISTINCT F0.`type`, F1.`type` AS `type1`
                            FROM `rule` AS F0, `rule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`type` <> isect0.`type1` AND isect0.`type` IS NOT NULL AND isect0.`type1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Type '.$v[0][0].',Type '.$v[0][1].')
reden: \"type[Rule*Type] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule20(){
    // Overtredingen behoren niet voor te komen in (I[Rule] |- type;type~)
    //            rule':: I[Rule]/\-(type;type~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `rule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `rule` AS F0, `rule` AS F1
                                       WHERE F0.`type`=F1.`type`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Rule '.$v[0][0].',Rule '.$v[0][1].')
reden: \"type[Rule*Type] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule21(){
    // Overtredingen behoren niet voor te komen in (type~;I[UserRule];type |- I[Type])
    //            rule':: type~;I[UserRule];type/\-I[Type]
    // sqlExprSrc fSpec rule':: type
     $v=DB_doquer('SELECT DISTINCT isect0.`type`, isect0.`type1`
                     FROM 
                        ( SELECT DISTINCT F0.`type`, F1.`type` AS `type1`
                            FROM `userrule` AS F0, `userrule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`type` <> isect0.`type1` AND isect0.`type` IS NOT NULL AND isect0.`type1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Type '.$v[0][0].',Type '.$v[0][1].')
reden: \"type[UserRule*Type] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule22(){
    // Overtredingen behoren niet voor te komen in (I[UserRule] |- type;type~)
    //            rule':: I[UserRule]/\-(type;type~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `userrule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `userrule` AS F0, `userrule` AS F1
                                       WHERE F0.`type`=F1.`type`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (UserRule '.$v[0][0].',UserRule '.$v[0][1].')
reden: \"type[UserRule*Type] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule23(){
    // Overtredingen behoren niet voor te komen in (type~;I[MultiplicityRule];type |- I[Type])
    //            rule':: type~;I[MultiplicityRule];type/\-I[Type]
    // sqlExprSrc fSpec rule':: type
     $v=DB_doquer('SELECT DISTINCT isect0.`type`, isect0.`type1`
                     FROM 
                        ( SELECT DISTINCT F0.`type`, F1.`type` AS `type1`
                            FROM `multiplicityrule` AS F0, `multiplicityrule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`type` <> isect0.`type1` AND isect0.`type` IS NOT NULL AND isect0.`type1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Type '.$v[0][0].',Type '.$v[0][1].')
reden: \"type[MultiplicityRule*Type] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule24(){
    // Overtredingen behoren niet voor te komen in (I[MultiplicityRule] |- type;type~)
    //            rule':: I[MultiplicityRule]/\-(type;type~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `multiplicityrule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `multiplicityrule` AS F0, `multiplicityrule` AS F1
                                       WHERE F0.`type`=F1.`type`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (MultiplicityRule '.$v[0][0].',MultiplicityRule '.$v[0][1].')
reden: \"type[MultiplicityRule*Type] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule25(){
    // Overtredingen behoren niet voor te komen in (type~;I[HomogeneousRule];type |- I[Type])
    //            rule':: type~;I[HomogeneousRule];type/\-I[Type]
    // sqlExprSrc fSpec rule':: type
     $v=DB_doquer('SELECT DISTINCT isect0.`type`, isect0.`type1`
                     FROM 
                        ( SELECT DISTINCT F0.`type`, F1.`type` AS `type1`
                            FROM `homogeneousrule` AS F0, `homogeneousrule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`type` <> isect0.`type1` AND isect0.`type` IS NOT NULL AND isect0.`type1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Type '.$v[0][0].',Type '.$v[0][1].')
reden: \"type[HomogeneousRule*Type] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule26(){
    // Overtredingen behoren niet voor te komen in (I[HomogeneousRule] |- type;type~)
    //            rule':: I[HomogeneousRule]/\-(type;type~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `homogeneousrule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `homogeneousrule` AS F0, `homogeneousrule` AS F1
                                       WHERE F0.`type`=F1.`type`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (HomogeneousRule '.$v[0][0].',HomogeneousRule '.$v[0][1].')
reden: \"type[HomogeneousRule*Type] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule27(){
    // Overtredingen behoren niet voor te komen in (explanation~;I[Rule];explanation |- I[Explanation])
    //            rule':: explanation~;I[Rule];explanation/\-I[Explanation]
    // sqlExprSrc fSpec rule':: explanation
     $v=DB_doquer('SELECT DISTINCT isect0.`explanation`, isect0.`explanation1`
                     FROM 
                        ( SELECT DISTINCT F0.`explanation`, F1.`explanation` AS `explanation1`
                            FROM `rule` AS F0, `rule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`explanation` <> isect0.`explanation1` AND isect0.`explanation` IS NOT NULL AND isect0.`explanation1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Explanation '.$v[0][0].',Explanation '.$v[0][1].')
reden: \"explanation[Rule*Explanation] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule28(){
    // Overtredingen behoren niet voor te komen in (I[Rule] |- explanation;explanation~)
    //            rule':: I[Rule]/\-(explanation;explanation~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `rule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `rule` AS F0, `rule` AS F1
                                       WHERE F0.`explanation`=F1.`explanation`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Rule '.$v[0][0].',Rule '.$v[0][1].')
reden: \"explanation[Rule*Explanation] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule29(){
    // Overtredingen behoren niet voor te komen in (explanation~;I[UserRule];explanation |- I[Explanation])
    //            rule':: explanation~;I[UserRule];explanation/\-I[Explanation]
    // sqlExprSrc fSpec rule':: explanation
     $v=DB_doquer('SELECT DISTINCT isect0.`explanation`, isect0.`explanation1`
                     FROM 
                        ( SELECT DISTINCT F0.`explanation`, F1.`explanation` AS `explanation1`
                            FROM `userrule` AS F0, `userrule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`explanation` <> isect0.`explanation1` AND isect0.`explanation` IS NOT NULL AND isect0.`explanation1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Explanation '.$v[0][0].',Explanation '.$v[0][1].')
reden: \"explanation[UserRule*Explanation] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule30(){
    // Overtredingen behoren niet voor te komen in (I[UserRule] |- explanation;explanation~)
    //            rule':: I[UserRule]/\-(explanation;explanation~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `userrule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `userrule` AS F0, `userrule` AS F1
                                       WHERE F0.`explanation`=F1.`explanation`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (UserRule '.$v[0][0].',UserRule '.$v[0][1].')
reden: \"explanation[UserRule*Explanation] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule31(){
    // Overtredingen behoren niet voor te komen in (explanation~;I[MultiplicityRule];explanation |- I[Explanation])
    //            rule':: explanation~;I[MultiplicityRule];explanation/\-I[Explanation]
    // sqlExprSrc fSpec rule':: explanation
     $v=DB_doquer('SELECT DISTINCT isect0.`explanation`, isect0.`explanation1`
                     FROM 
                        ( SELECT DISTINCT F0.`explanation`, F1.`explanation` AS `explanation1`
                            FROM `multiplicityrule` AS F0, `multiplicityrule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`explanation` <> isect0.`explanation1` AND isect0.`explanation` IS NOT NULL AND isect0.`explanation1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Explanation '.$v[0][0].',Explanation '.$v[0][1].')
reden: \"explanation[MultiplicityRule*Explanation] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule32(){
    // Overtredingen behoren niet voor te komen in (I[MultiplicityRule] |- explanation;explanation~)
    //            rule':: I[MultiplicityRule]/\-(explanation;explanation~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `multiplicityrule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `multiplicityrule` AS F0, `multiplicityrule` AS F1
                                       WHERE F0.`explanation`=F1.`explanation`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (MultiplicityRule '.$v[0][0].',MultiplicityRule '.$v[0][1].')
reden: \"explanation[MultiplicityRule*Explanation] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule33(){
    // Overtredingen behoren niet voor te komen in (explanation~;I[HomogeneousRule];explanation |- I[Explanation])
    //            rule':: explanation~;I[HomogeneousRule];explanation/\-I[Explanation]
    // sqlExprSrc fSpec rule':: explanation
     $v=DB_doquer('SELECT DISTINCT isect0.`explanation`, isect0.`explanation1`
                     FROM 
                        ( SELECT DISTINCT F0.`explanation`, F1.`explanation` AS `explanation1`
                            FROM `homogeneousrule` AS F0, `homogeneousrule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`explanation` <> isect0.`explanation1` AND isect0.`explanation` IS NOT NULL AND isect0.`explanation1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Explanation '.$v[0][0].',Explanation '.$v[0][1].')
reden: \"explanation[HomogeneousRule*Explanation] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule34(){
    // Overtredingen behoren niet voor te komen in (I[HomogeneousRule] |- explanation;explanation~)
    //            rule':: I[HomogeneousRule]/\-(explanation;explanation~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `homogeneousrule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `homogeneousrule` AS F0, `homogeneousrule` AS F1
                                       WHERE F0.`explanation`=F1.`explanation`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (HomogeneousRule '.$v[0][0].',HomogeneousRule '.$v[0][1].')
reden: \"explanation[HomogeneousRule*Explanation] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule35(){
    // Overtredingen behoren niet voor te komen in (user~;I[Picture];user |- I[UserName])
    //            rule':: user~;I[Picture];user/\-I[UserName]
    // sqlExprSrc fSpec rule':: user
     $v=DB_doquer('SELECT DISTINCT isect0.`user`, isect0.`user1`
                     FROM 
                        ( SELECT DISTINCT F0.`user`, F1.`user` AS `user1`
                            FROM `picture` AS F0, `picture` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`user` <> isect0.`user1` AND isect0.`user` IS NOT NULL AND isect0.`user1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (UserName '.$v[0][0].',UserName '.$v[0][1].')
reden: \"user[Picture*UserName] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule36(){
    // Overtredingen behoren niet voor te komen in (I[Picture] |- user;user~)
    //            rule':: I[Picture]/\-(user;user~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `picture` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `picture` AS F0, `picture` AS F1
                                       WHERE F0.`user`=F1.`user`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Picture '.$v[0][0].',Picture '.$v[0][1].')
reden: \"user[Picture*UserName] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule37(){
    // Overtredingen behoren niet voor te komen in (user~;I[Relation];user |- I[UserName])
    //            rule':: user~;I[Relation];user/\-I[UserName]
    // sqlExprSrc fSpec rule':: user
     $v=DB_doquer('SELECT DISTINCT isect0.`user`, isect0.`user1`
                     FROM 
                        ( SELECT DISTINCT F0.`user`, F1.`user` AS `user1`
                            FROM `relation` AS F0, `relation` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`user` <> isect0.`user1` AND isect0.`user` IS NOT NULL AND isect0.`user1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (UserName '.$v[0][0].',UserName '.$v[0][1].')
reden: \"user[Relation*UserName] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule38(){
    // Overtredingen behoren niet voor te komen in (I[Relation] |- user;user~)
    //            rule':: I[Relation]/\-(user;user~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `relation` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `relation` AS F0, `relation` AS F1
                                       WHERE F0.`user`=F1.`user`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Relation '.$v[0][0].',Relation '.$v[0][1].')
reden: \"user[Relation*UserName] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule39(){
    // Overtredingen behoren niet voor te komen in (user~;I[Type];user |- I[UserName])
    //            rule':: user~;I[Type];user/\-I[UserName]
    // sqlExprSrc fSpec rule':: user
     $v=DB_doquer('SELECT DISTINCT isect0.`user`, isect0.`user1`
                     FROM 
                        ( SELECT DISTINCT F0.`user`, F1.`user` AS `user1`
                            FROM `type` AS F0, `type` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`user` <> isect0.`user1` AND isect0.`user` IS NOT NULL AND isect0.`user1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (UserName '.$v[0][0].',UserName '.$v[0][1].')
reden: \"user[Type*UserName] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule40(){
    // Overtredingen behoren niet voor te komen in (I[Type] |- user;user~)
    //            rule':: I[Type]/\-(user;user~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `type` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `type` AS F0, `type` AS F1
                                       WHERE F0.`user`=F1.`user`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Type '.$v[0][0].',Type '.$v[0][1].')
reden: \"user[Type*UserName] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule41(){
    // Overtredingen behoren niet voor te komen in (user~;I[Pair];user |- I[UserName])
    //            rule':: user~;I[Pair];user/\-I[UserName]
    // sqlExprSrc fSpec rule':: user
     $v=DB_doquer('SELECT DISTINCT isect0.`user`, isect0.`user1`
                     FROM 
                        ( SELECT DISTINCT F0.`user`, F1.`user` AS `user1`
                            FROM `pair` AS F0, `pair` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`user` <> isect0.`user1` AND isect0.`user` IS NOT NULL AND isect0.`user1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (UserName '.$v[0][0].',UserName '.$v[0][1].')
reden: \"user[Pair*UserName] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule42(){
    // Overtredingen behoren niet voor te komen in (I[Pair] |- user;user~)
    //            rule':: I[Pair]/\-(user;user~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `pair` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `pair` AS F0, `pair` AS F1
                                       WHERE F0.`user`=F1.`user`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Pair '.$v[0][0].',Pair '.$v[0][1].')
reden: \"user[Pair*UserName] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule43(){
    // Overtredingen behoren niet voor te komen in (user~;I[Concept];user |- I[UserName])
    //            rule':: user~;I[Concept];user/\-I[UserName]
    // sqlExprSrc fSpec rule':: user
     $v=DB_doquer('SELECT DISTINCT isect0.`user`, isect0.`user1`
                     FROM 
                        ( SELECT DISTINCT F0.`user`, F1.`user` AS `user1`
                            FROM `concept` AS F0, `concept` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`user` <> isect0.`user1` AND isect0.`user` IS NOT NULL AND isect0.`user1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (UserName '.$v[0][0].',UserName '.$v[0][1].')
reden: \"user[Concept*UserName] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule44(){
    // Overtredingen behoren niet voor te komen in (I[Concept] |- user;user~)
    //            rule':: I[Concept]/\-(user;user~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `concept` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `concept` AS F0, `concept` AS F1
                                       WHERE F0.`user`=F1.`user`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Concept '.$v[0][0].',Concept '.$v[0][1].')
reden: \"user[Concept*UserName] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule45(){
    // Overtredingen behoren niet voor te komen in (user~;I[Atom];user |- I[UserName])
    //            rule':: user~;I[Atom];user/\-I[UserName]
    // sqlExprSrc fSpec rule':: user
     $v=DB_doquer('SELECT DISTINCT isect0.`user`, isect0.`user1`
                     FROM 
                        ( SELECT DISTINCT F0.`user`, F1.`user` AS `user1`
                            FROM `atom` AS F0, `atom` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`user` <> isect0.`user1` AND isect0.`user` IS NOT NULL AND isect0.`user1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (UserName '.$v[0][0].',UserName '.$v[0][1].')
reden: \"user[Atom*UserName] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule46(){
    // Overtredingen behoren niet voor te komen in (I[Atom] |- user;user~)
    //            rule':: I[Atom]/\-(user;user~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `atom` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `atom` AS F0, `atom` AS F1
                                       WHERE F0.`user`=F1.`user`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Atom '.$v[0][0].',Atom '.$v[0][1].')
reden: \"user[Atom*UserName] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule47(){
    // Overtredingen behoren niet voor te komen in (user~;I[IsaRelation];user |- I[UserName])
    //            rule':: user~;I[IsaRelation];user/\-I[UserName]
    // sqlExprSrc fSpec rule':: user
     $v=DB_doquer('SELECT DISTINCT isect0.`user`, isect0.`user1`
                     FROM 
                        ( SELECT DISTINCT F0.`user`, F1.`user` AS `user1`
                            FROM `isarelation` AS F0, `isarelation` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`user` <> isect0.`user1` AND isect0.`user` IS NOT NULL AND isect0.`user1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (UserName '.$v[0][0].',UserName '.$v[0][1].')
reden: \"user[IsaRelation*UserName] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule48(){
    // Overtredingen behoren niet voor te komen in (I[IsaRelation] |- user;user~)
    //            rule':: I[IsaRelation]/\-(user;user~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `isarelation` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `isarelation` AS F0, `isarelation` AS F1
                                       WHERE F0.`user`=F1.`user`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (IsaRelation '.$v[0][0].',IsaRelation '.$v[0][1].')
reden: \"user[IsaRelation*UserName] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule49(){
    // Overtredingen behoren niet voor te komen in (user~;I[MultiplicityRule];user |- I[UserName])
    //            rule':: user~;I[MultiplicityRule];user/\-I[UserName]
    // sqlExprSrc fSpec rule':: user
     $v=DB_doquer('SELECT DISTINCT isect0.`user`, isect0.`user1`
                     FROM 
                        ( SELECT DISTINCT F0.`user`, F1.`user` AS `user1`
                            FROM `multiplicityrule` AS F0, `multiplicityrule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`user` <> isect0.`user1` AND isect0.`user` IS NOT NULL AND isect0.`user1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (UserName '.$v[0][0].',UserName '.$v[0][1].')
reden: \"user[MultiplicityRule*UserName] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule50(){
    // Overtredingen behoren niet voor te komen in (I[MultiplicityRule] |- user;user~)
    //            rule':: I[MultiplicityRule]/\-(user;user~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `multiplicityrule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `multiplicityrule` AS F0, `multiplicityrule` AS F1
                                       WHERE F0.`user`=F1.`user`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (MultiplicityRule '.$v[0][0].',MultiplicityRule '.$v[0][1].')
reden: \"user[MultiplicityRule*UserName] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule51(){
    // Overtredingen behoren niet voor te komen in (user~;I[HomogeneousRule];user |- I[UserName])
    //            rule':: user~;I[HomogeneousRule];user/\-I[UserName]
    // sqlExprSrc fSpec rule':: user
     $v=DB_doquer('SELECT DISTINCT isect0.`user`, isect0.`user1`
                     FROM 
                        ( SELECT DISTINCT F0.`user`, F1.`user` AS `user1`
                            FROM `homogeneousrule` AS F0, `homogeneousrule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`user` <> isect0.`user1` AND isect0.`user` IS NOT NULL AND isect0.`user1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (UserName '.$v[0][0].',UserName '.$v[0][1].')
reden: \"user[HomogeneousRule*UserName] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule52(){
    // Overtredingen behoren niet voor te komen in (I[HomogeneousRule] |- user;user~)
    //            rule':: I[HomogeneousRule]/\-(user;user~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `homogeneousrule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `homogeneousrule` AS F0, `homogeneousrule` AS F1
                                       WHERE F0.`user`=F1.`user`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (HomogeneousRule '.$v[0][0].',HomogeneousRule '.$v[0][1].')
reden: \"user[HomogeneousRule*UserName] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule53(){
    // Overtredingen behoren niet voor te komen in (user~;I[Prop];user |- I[UserName])
    //            rule':: user~;I[Prop];user/\-I[UserName]
    // sqlExprSrc fSpec rule':: user
     $v=DB_doquer('SELECT DISTINCT isect0.`user`, isect0.`user1`
                     FROM 
                        ( SELECT DISTINCT F0.`user`, F1.`user` AS `user1`
                            FROM `prop` AS F0, `prop` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`user` <> isect0.`user1` AND isect0.`user` IS NOT NULL AND isect0.`user1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (UserName '.$v[0][0].',UserName '.$v[0][1].')
reden: \"user[Prop*UserName] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule54(){
    // Overtredingen behoren niet voor te komen in (I[Prop] |- user;user~)
    //            rule':: I[Prop]/\-(user;user~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `prop` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `prop` AS F0, `prop` AS F1
                                       WHERE F0.`user`=F1.`user`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Prop '.$v[0][0].',Prop '.$v[0][1].')
reden: \"user[Prop*UserName] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule55(){
    // Overtredingen behoren niet voor te komen in (user~;I[UserRule];user |- I[UserName])
    //            rule':: user~;I[UserRule];user/\-I[UserName]
    // sqlExprSrc fSpec rule':: user
     $v=DB_doquer('SELECT DISTINCT isect0.`user`, isect0.`user1`
                     FROM 
                        ( SELECT DISTINCT F0.`user`, F1.`user` AS `user1`
                            FROM `userrule` AS F0, `userrule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`user` <> isect0.`user1` AND isect0.`user` IS NOT NULL AND isect0.`user1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (UserName '.$v[0][0].',UserName '.$v[0][1].')
reden: \"user[UserRule*UserName] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule56(){
    // Overtredingen behoren niet voor te komen in (I[UserRule] |- user;user~)
    //            rule':: I[UserRule]/\-(user;user~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `userrule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `userrule` AS F0, `userrule` AS F1
                                       WHERE F0.`user`=F1.`user`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (UserRule '.$v[0][0].',UserRule '.$v[0][1].')
reden: \"user[UserRule*UserName] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule57(){
    // Overtredingen behoren niet voor te komen in (user~;I[Rule];user |- I[UserName])
    //            rule':: user~;I[Rule];user/\-I[UserName]
    // sqlExprSrc fSpec rule':: user
     $v=DB_doquer('SELECT DISTINCT isect0.`user`, isect0.`user1`
                     FROM 
                        ( SELECT DISTINCT F0.`user`, F1.`user` AS `user1`
                            FROM `rule` AS F0, `rule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`user` <> isect0.`user1` AND isect0.`user` IS NOT NULL AND isect0.`user1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (UserName '.$v[0][0].',UserName '.$v[0][1].')
reden: \"user[Rule*UserName] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule58(){
    // Overtredingen behoren niet voor te komen in (I[Rule] |- user;user~)
    //            rule':: I[Rule]/\-(user;user~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `rule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `rule` AS F0, `rule` AS F1
                                       WHERE F0.`user`=F1.`user`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Rule '.$v[0][0].',Rule '.$v[0][1].')
reden: \"user[Rule*UserName] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule59(){
    // Overtredingen behoren niet voor te komen in (user~;I[Violation];user |- I[UserName])
    //            rule':: user~;I[Violation];user/\-I[UserName]
    // sqlExprSrc fSpec rule':: user
     $v=DB_doquer('SELECT DISTINCT isect0.`user`, isect0.`user1`
                     FROM 
                        ( SELECT DISTINCT F0.`user`, F1.`user` AS `user1`
                            FROM `violation` AS F0, `violation` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`user` <> isect0.`user1` AND isect0.`user` IS NOT NULL AND isect0.`user1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (UserName '.$v[0][0].',UserName '.$v[0][1].')
reden: \"user[Violation*UserName] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule60(){
    // Overtredingen behoren niet voor te komen in (I[Violation] |- user;user~)
    //            rule':: I[Violation]/\-(user;user~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `violation` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `violation` AS F0, `violation` AS F1
                                       WHERE F0.`user`=F1.`user`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Violation '.$v[0][0].',Violation '.$v[0][1].')
reden: \"user[Violation*UserName] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule61(){
    // Overtredingen behoren niet voor te komen in (user~;I[Explanation];user |- I[UserName])
    //            rule':: user~;I[Explanation];user/\-I[UserName]
    // sqlExprSrc fSpec rule':: user
     $v=DB_doquer('SELECT DISTINCT isect0.`user`, isect0.`user1`
                     FROM 
                        ( SELECT DISTINCT F0.`user`, F1.`user` AS `user1`
                            FROM `explanation` AS F0, `explanation` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`user` <> isect0.`user1` AND isect0.`user` IS NOT NULL AND isect0.`user1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (UserName '.$v[0][0].',UserName '.$v[0][1].')
reden: \"user[Explanation*UserName] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule62(){
    // Overtredingen behoren niet voor te komen in (I[Explanation] |- user;user~)
    //            rule':: I[Explanation]/\-(user;user~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `explanation` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `explanation` AS F0, `explanation` AS F1
                                       WHERE F0.`user`=F1.`user`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Explanation '.$v[0][0].',Explanation '.$v[0][1].')
reden: \"user[Explanation*UserName] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule63(){
    // Overtredingen behoren niet voor te komen in (script~;I[Picture];script |- I[Script])
    //            rule':: script~;I[Picture];script/\-I[Script]
    // sqlExprSrc fSpec rule':: script
     $v=DB_doquer('SELECT DISTINCT isect0.`script`, isect0.`script1`
                     FROM 
                        ( SELECT DISTINCT F0.`script`, F1.`script` AS `script1`
                            FROM `picture` AS F0, `picture` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`script` <> isect0.`script1` AND isect0.`script` IS NOT NULL AND isect0.`script1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Script '.$v[0][0].',Script '.$v[0][1].')
reden: \"script[Picture*Script] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule64(){
    // Overtredingen behoren niet voor te komen in (I[Picture] |- script;script~)
    //            rule':: I[Picture]/\-(script;script~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `picture` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `picture` AS F0, `picture` AS F1
                                       WHERE F0.`script`=F1.`script`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Picture '.$v[0][0].',Picture '.$v[0][1].')
reden: \"script[Picture*Script] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule65(){
    // Overtredingen behoren niet voor te komen in (script~;I[Relation];script |- I[Script])
    //            rule':: script~;I[Relation];script/\-I[Script]
    // sqlExprSrc fSpec rule':: script
     $v=DB_doquer('SELECT DISTINCT isect0.`script`, isect0.`script1`
                     FROM 
                        ( SELECT DISTINCT F0.`script`, F1.`script` AS `script1`
                            FROM `relation` AS F0, `relation` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`script` <> isect0.`script1` AND isect0.`script` IS NOT NULL AND isect0.`script1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Script '.$v[0][0].',Script '.$v[0][1].')
reden: \"script[Relation*Script] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule66(){
    // Overtredingen behoren niet voor te komen in (I[Relation] |- script;script~)
    //            rule':: I[Relation]/\-(script;script~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `relation` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `relation` AS F0, `relation` AS F1
                                       WHERE F0.`script`=F1.`script`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Relation '.$v[0][0].',Relation '.$v[0][1].')
reden: \"script[Relation*Script] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule67(){
    // Overtredingen behoren niet voor te komen in (script~;I[Type];script |- I[Script])
    //            rule':: script~;I[Type];script/\-I[Script]
    // sqlExprSrc fSpec rule':: script
     $v=DB_doquer('SELECT DISTINCT isect0.`script`, isect0.`script1`
                     FROM 
                        ( SELECT DISTINCT F0.`script`, F1.`script` AS `script1`
                            FROM `type` AS F0, `type` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`script` <> isect0.`script1` AND isect0.`script` IS NOT NULL AND isect0.`script1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Script '.$v[0][0].',Script '.$v[0][1].')
reden: \"script[Type*Script] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule68(){
    // Overtredingen behoren niet voor te komen in (I[Type] |- script;script~)
    //            rule':: I[Type]/\-(script;script~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `type` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `type` AS F0, `type` AS F1
                                       WHERE F0.`script`=F1.`script`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Type '.$v[0][0].',Type '.$v[0][1].')
reden: \"script[Type*Script] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule69(){
    // Overtredingen behoren niet voor te komen in (script~;I[Pair];script |- I[Script])
    //            rule':: script~;I[Pair];script/\-I[Script]
    // sqlExprSrc fSpec rule':: script
     $v=DB_doquer('SELECT DISTINCT isect0.`script`, isect0.`script1`
                     FROM 
                        ( SELECT DISTINCT F0.`script`, F1.`script` AS `script1`
                            FROM `pair` AS F0, `pair` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`script` <> isect0.`script1` AND isect0.`script` IS NOT NULL AND isect0.`script1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Script '.$v[0][0].',Script '.$v[0][1].')
reden: \"script[Pair*Script] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule70(){
    // Overtredingen behoren niet voor te komen in (I[Pair] |- script;script~)
    //            rule':: I[Pair]/\-(script;script~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `pair` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `pair` AS F0, `pair` AS F1
                                       WHERE F0.`script`=F1.`script`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Pair '.$v[0][0].',Pair '.$v[0][1].')
reden: \"script[Pair*Script] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule71(){
    // Overtredingen behoren niet voor te komen in (script~;I[Concept];script |- I[Script])
    //            rule':: script~;I[Concept];script/\-I[Script]
    // sqlExprSrc fSpec rule':: script
     $v=DB_doquer('SELECT DISTINCT isect0.`script`, isect0.`script1`
                     FROM 
                        ( SELECT DISTINCT F0.`script`, F1.`script` AS `script1`
                            FROM `concept` AS F0, `concept` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`script` <> isect0.`script1` AND isect0.`script` IS NOT NULL AND isect0.`script1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Script '.$v[0][0].',Script '.$v[0][1].')
reden: \"script[Concept*Script] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule72(){
    // Overtredingen behoren niet voor te komen in (I[Concept] |- script;script~)
    //            rule':: I[Concept]/\-(script;script~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `concept` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `concept` AS F0, `concept` AS F1
                                       WHERE F0.`script`=F1.`script`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Concept '.$v[0][0].',Concept '.$v[0][1].')
reden: \"script[Concept*Script] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule73(){
    // Overtredingen behoren niet voor te komen in (script~;I[Atom];script |- I[Script])
    //            rule':: script~;I[Atom];script/\-I[Script]
    // sqlExprSrc fSpec rule':: script
     $v=DB_doquer('SELECT DISTINCT isect0.`script`, isect0.`script1`
                     FROM 
                        ( SELECT DISTINCT F0.`script`, F1.`script` AS `script1`
                            FROM `atom` AS F0, `atom` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`script` <> isect0.`script1` AND isect0.`script` IS NOT NULL AND isect0.`script1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Script '.$v[0][0].',Script '.$v[0][1].')
reden: \"script[Atom*Script] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule74(){
    // Overtredingen behoren niet voor te komen in (I[Atom] |- script;script~)
    //            rule':: I[Atom]/\-(script;script~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `atom` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `atom` AS F0, `atom` AS F1
                                       WHERE F0.`script`=F1.`script`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Atom '.$v[0][0].',Atom '.$v[0][1].')
reden: \"script[Atom*Script] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule75(){
    // Overtredingen behoren niet voor te komen in (script~;I[IsaRelation];script |- I[Script])
    //            rule':: script~;I[IsaRelation];script/\-I[Script]
    // sqlExprSrc fSpec rule':: script
     $v=DB_doquer('SELECT DISTINCT isect0.`script`, isect0.`script1`
                     FROM 
                        ( SELECT DISTINCT F0.`script`, F1.`script` AS `script1`
                            FROM `isarelation` AS F0, `isarelation` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`script` <> isect0.`script1` AND isect0.`script` IS NOT NULL AND isect0.`script1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Script '.$v[0][0].',Script '.$v[0][1].')
reden: \"script[IsaRelation*Script] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule76(){
    // Overtredingen behoren niet voor te komen in (I[IsaRelation] |- script;script~)
    //            rule':: I[IsaRelation]/\-(script;script~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `isarelation` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `isarelation` AS F0, `isarelation` AS F1
                                       WHERE F0.`script`=F1.`script`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (IsaRelation '.$v[0][0].',IsaRelation '.$v[0][1].')
reden: \"script[IsaRelation*Script] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule77(){
    // Overtredingen behoren niet voor te komen in (script~;I[MultiplicityRule];script |- I[Script])
    //            rule':: script~;I[MultiplicityRule];script/\-I[Script]
    // sqlExprSrc fSpec rule':: script
     $v=DB_doquer('SELECT DISTINCT isect0.`script`, isect0.`script1`
                     FROM 
                        ( SELECT DISTINCT F0.`script`, F1.`script` AS `script1`
                            FROM `multiplicityrule` AS F0, `multiplicityrule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`script` <> isect0.`script1` AND isect0.`script` IS NOT NULL AND isect0.`script1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Script '.$v[0][0].',Script '.$v[0][1].')
reden: \"script[MultiplicityRule*Script] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule78(){
    // Overtredingen behoren niet voor te komen in (I[MultiplicityRule] |- script;script~)
    //            rule':: I[MultiplicityRule]/\-(script;script~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `multiplicityrule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `multiplicityrule` AS F0, `multiplicityrule` AS F1
                                       WHERE F0.`script`=F1.`script`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (MultiplicityRule '.$v[0][0].',MultiplicityRule '.$v[0][1].')
reden: \"script[MultiplicityRule*Script] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule79(){
    // Overtredingen behoren niet voor te komen in (script~;I[HomogeneousRule];script |- I[Script])
    //            rule':: script~;I[HomogeneousRule];script/\-I[Script]
    // sqlExprSrc fSpec rule':: script
     $v=DB_doquer('SELECT DISTINCT isect0.`script`, isect0.`script1`
                     FROM 
                        ( SELECT DISTINCT F0.`script`, F1.`script` AS `script1`
                            FROM `homogeneousrule` AS F0, `homogeneousrule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`script` <> isect0.`script1` AND isect0.`script` IS NOT NULL AND isect0.`script1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Script '.$v[0][0].',Script '.$v[0][1].')
reden: \"script[HomogeneousRule*Script] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule80(){
    // Overtredingen behoren niet voor te komen in (I[HomogeneousRule] |- script;script~)
    //            rule':: I[HomogeneousRule]/\-(script;script~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `homogeneousrule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `homogeneousrule` AS F0, `homogeneousrule` AS F1
                                       WHERE F0.`script`=F1.`script`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (HomogeneousRule '.$v[0][0].',HomogeneousRule '.$v[0][1].')
reden: \"script[HomogeneousRule*Script] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule81(){
    // Overtredingen behoren niet voor te komen in (script~;I[Prop];script |- I[Script])
    //            rule':: script~;I[Prop];script/\-I[Script]
    // sqlExprSrc fSpec rule':: script
     $v=DB_doquer('SELECT DISTINCT isect0.`script`, isect0.`script1`
                     FROM 
                        ( SELECT DISTINCT F0.`script`, F1.`script` AS `script1`
                            FROM `prop` AS F0, `prop` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`script` <> isect0.`script1` AND isect0.`script` IS NOT NULL AND isect0.`script1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Script '.$v[0][0].',Script '.$v[0][1].')
reden: \"script[Prop*Script] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule82(){
    // Overtredingen behoren niet voor te komen in (I[Prop] |- script;script~)
    //            rule':: I[Prop]/\-(script;script~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `prop` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `prop` AS F0, `prop` AS F1
                                       WHERE F0.`script`=F1.`script`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Prop '.$v[0][0].',Prop '.$v[0][1].')
reden: \"script[Prop*Script] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule83(){
    // Overtredingen behoren niet voor te komen in (script~;I[UserRule];script |- I[Script])
    //            rule':: script~;I[UserRule];script/\-I[Script]
    // sqlExprSrc fSpec rule':: script
     $v=DB_doquer('SELECT DISTINCT isect0.`script`, isect0.`script1`
                     FROM 
                        ( SELECT DISTINCT F0.`script`, F1.`script` AS `script1`
                            FROM `userrule` AS F0, `userrule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`script` <> isect0.`script1` AND isect0.`script` IS NOT NULL AND isect0.`script1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Script '.$v[0][0].',Script '.$v[0][1].')
reden: \"script[UserRule*Script] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule84(){
    // Overtredingen behoren niet voor te komen in (I[UserRule] |- script;script~)
    //            rule':: I[UserRule]/\-(script;script~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `userrule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `userrule` AS F0, `userrule` AS F1
                                       WHERE F0.`script`=F1.`script`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (UserRule '.$v[0][0].',UserRule '.$v[0][1].')
reden: \"script[UserRule*Script] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule85(){
    // Overtredingen behoren niet voor te komen in (script~;I[Rule];script |- I[Script])
    //            rule':: script~;I[Rule];script/\-I[Script]
    // sqlExprSrc fSpec rule':: script
     $v=DB_doquer('SELECT DISTINCT isect0.`script`, isect0.`script1`
                     FROM 
                        ( SELECT DISTINCT F0.`script`, F1.`script` AS `script1`
                            FROM `rule` AS F0, `rule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`script` <> isect0.`script1` AND isect0.`script` IS NOT NULL AND isect0.`script1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Script '.$v[0][0].',Script '.$v[0][1].')
reden: \"script[Rule*Script] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule86(){
    // Overtredingen behoren niet voor te komen in (I[Rule] |- script;script~)
    //            rule':: I[Rule]/\-(script;script~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `rule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `rule` AS F0, `rule` AS F1
                                       WHERE F0.`script`=F1.`script`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Rule '.$v[0][0].',Rule '.$v[0][1].')
reden: \"script[Rule*Script] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule87(){
    // Overtredingen behoren niet voor te komen in (script~;I[Violation];script |- I[Script])
    //            rule':: script~;I[Violation];script/\-I[Script]
    // sqlExprSrc fSpec rule':: script
     $v=DB_doquer('SELECT DISTINCT isect0.`script`, isect0.`script1`
                     FROM 
                        ( SELECT DISTINCT F0.`script`, F1.`script` AS `script1`
                            FROM `violation` AS F0, `violation` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`script` <> isect0.`script1` AND isect0.`script` IS NOT NULL AND isect0.`script1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Script '.$v[0][0].',Script '.$v[0][1].')
reden: \"script[Violation*Script] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule88(){
    // Overtredingen behoren niet voor te komen in (I[Violation] |- script;script~)
    //            rule':: I[Violation]/\-(script;script~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `violation` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `violation` AS F0, `violation` AS F1
                                       WHERE F0.`script`=F1.`script`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Violation '.$v[0][0].',Violation '.$v[0][1].')
reden: \"script[Violation*Script] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule89(){
    // Overtredingen behoren niet voor te komen in (script~;I[Explanation];script |- I[Script])
    //            rule':: script~;I[Explanation];script/\-I[Script]
    // sqlExprSrc fSpec rule':: script
     $v=DB_doquer('SELECT DISTINCT isect0.`script`, isect0.`script1`
                     FROM 
                        ( SELECT DISTINCT F0.`script`, F1.`script` AS `script1`
                            FROM `explanation` AS F0, `explanation` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`script` <> isect0.`script1` AND isect0.`script` IS NOT NULL AND isect0.`script1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Script '.$v[0][0].',Script '.$v[0][1].')
reden: \"script[Explanation*Script] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule90(){
    // Overtredingen behoren niet voor te komen in (I[Explanation] |- script;script~)
    //            rule':: I[Explanation]/\-(script;script~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `explanation` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `explanation` AS F0, `explanation` AS F1
                                       WHERE F0.`script`=F1.`script`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Explanation '.$v[0][0].',Explanation '.$v[0][1].')
reden: \"script[Explanation*Script] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule91(){
    // Overtredingen behoren niet voor te komen in (display~;I[Picture];display |- I[String])
    //            rule':: display~;I[Picture];display/\-I[String]
    // sqlExprSrc fSpec rule':: display
     $v=DB_doquer('SELECT DISTINCT isect0.`display`, isect0.`display1`
                     FROM 
                        ( SELECT DISTINCT F0.`display`, F1.`display` AS `display1`
                            FROM `picture` AS F0, `picture` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`display` <> isect0.`display1` AND isect0.`display` IS NOT NULL AND isect0.`display1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (String '.$v[0][0].',String '.$v[0][1].')
reden: \"display[Picture*String] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule92(){
    // Overtredingen behoren niet voor te komen in (I[Picture] |- display;display~)
    //            rule':: I[Picture]/\-(display;display~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `picture` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `picture` AS F0, `picture` AS F1
                                       WHERE F0.`display`=F1.`display`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Picture '.$v[0][0].',Picture '.$v[0][1].')
reden: \"display[Picture*String] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule93(){
    // Overtredingen behoren niet voor te komen in (display~;I[Relation];display |- I[String])
    //            rule':: display~;I[Relation];display/\-I[String]
    // sqlExprSrc fSpec rule':: display
     $v=DB_doquer('SELECT DISTINCT isect0.`display`, isect0.`display1`
                     FROM 
                        ( SELECT DISTINCT F0.`display`, F1.`display` AS `display1`
                            FROM `relation` AS F0, `relation` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`display` <> isect0.`display1` AND isect0.`display` IS NOT NULL AND isect0.`display1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (String '.$v[0][0].',String '.$v[0][1].')
reden: \"display[Relation*String] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule94(){
    // Overtredingen behoren niet voor te komen in (I[Relation] |- display;display~)
    //            rule':: I[Relation]/\-(display;display~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `relation` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `relation` AS F0, `relation` AS F1
                                       WHERE F0.`display`=F1.`display`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Relation '.$v[0][0].',Relation '.$v[0][1].')
reden: \"display[Relation*String] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule95(){
    // Overtredingen behoren niet voor te komen in (display~;I[Type];display |- I[String])
    //            rule':: display~;I[Type];display/\-I[String]
    // sqlExprSrc fSpec rule':: display
     $v=DB_doquer('SELECT DISTINCT isect0.`display`, isect0.`display1`
                     FROM 
                        ( SELECT DISTINCT F0.`display`, F1.`display` AS `display1`
                            FROM `type` AS F0, `type` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`display` <> isect0.`display1` AND isect0.`display` IS NOT NULL AND isect0.`display1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (String '.$v[0][0].',String '.$v[0][1].')
reden: \"display[Type*String] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule96(){
    // Overtredingen behoren niet voor te komen in (I[Type] |- display;display~)
    //            rule':: I[Type]/\-(display;display~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `type` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `type` AS F0, `type` AS F1
                                       WHERE F0.`display`=F1.`display`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Type '.$v[0][0].',Type '.$v[0][1].')
reden: \"display[Type*String] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule97(){
    // Overtredingen behoren niet voor te komen in (display~;I[Pair];display |- I[String])
    //            rule':: display~;I[Pair];display/\-I[String]
    // sqlExprSrc fSpec rule':: display
     $v=DB_doquer('SELECT DISTINCT isect0.`display`, isect0.`display1`
                     FROM 
                        ( SELECT DISTINCT F0.`display`, F1.`display` AS `display1`
                            FROM `pair` AS F0, `pair` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`display` <> isect0.`display1` AND isect0.`display` IS NOT NULL AND isect0.`display1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (String '.$v[0][0].',String '.$v[0][1].')
reden: \"display[Pair*String] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule98(){
    // Overtredingen behoren niet voor te komen in (I[Pair] |- display;display~)
    //            rule':: I[Pair]/\-(display;display~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `pair` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `pair` AS F0, `pair` AS F1
                                       WHERE F0.`display`=F1.`display`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Pair '.$v[0][0].',Pair '.$v[0][1].')
reden: \"display[Pair*String] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule99(){
    // Overtredingen behoren niet voor te komen in (display~;I[Concept];display |- I[String])
    //            rule':: display~;I[Concept];display/\-I[String]
    // sqlExprSrc fSpec rule':: display
     $v=DB_doquer('SELECT DISTINCT isect0.`display`, isect0.`display1`
                     FROM 
                        ( SELECT DISTINCT F0.`display`, F1.`display` AS `display1`
                            FROM `concept` AS F0, `concept` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`display` <> isect0.`display1` AND isect0.`display` IS NOT NULL AND isect0.`display1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (String '.$v[0][0].',String '.$v[0][1].')
reden: \"display[Concept*String] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule100(){
    // Overtredingen behoren niet voor te komen in (I[Concept] |- display;display~)
    //            rule':: I[Concept]/\-(display;display~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `concept` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `concept` AS F0, `concept` AS F1
                                       WHERE F0.`display`=F1.`display`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Concept '.$v[0][0].',Concept '.$v[0][1].')
reden: \"display[Concept*String] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule101(){
    // Overtredingen behoren niet voor te komen in (display~;I[Atom];display |- I[String])
    //            rule':: display~;I[Atom];display/\-I[String]
    // sqlExprSrc fSpec rule':: display
     $v=DB_doquer('SELECT DISTINCT isect0.`display`, isect0.`display1`
                     FROM 
                        ( SELECT DISTINCT F0.`display`, F1.`display` AS `display1`
                            FROM `atom` AS F0, `atom` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`display` <> isect0.`display1` AND isect0.`display` IS NOT NULL AND isect0.`display1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (String '.$v[0][0].',String '.$v[0][1].')
reden: \"display[Atom*String] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule102(){
    // Overtredingen behoren niet voor te komen in (I[Atom] |- display;display~)
    //            rule':: I[Atom]/\-(display;display~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `atom` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `atom` AS F0, `atom` AS F1
                                       WHERE F0.`display`=F1.`display`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Atom '.$v[0][0].',Atom '.$v[0][1].')
reden: \"display[Atom*String] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule103(){
    // Overtredingen behoren niet voor te komen in (display~;I[IsaRelation];display |- I[String])
    //            rule':: display~;I[IsaRelation];display/\-I[String]
    // sqlExprSrc fSpec rule':: display
     $v=DB_doquer('SELECT DISTINCT isect0.`display`, isect0.`display1`
                     FROM 
                        ( SELECT DISTINCT F0.`display`, F1.`display` AS `display1`
                            FROM `isarelation` AS F0, `isarelation` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`display` <> isect0.`display1` AND isect0.`display` IS NOT NULL AND isect0.`display1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (String '.$v[0][0].',String '.$v[0][1].')
reden: \"display[IsaRelation*String] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule104(){
    // Overtredingen behoren niet voor te komen in (I[IsaRelation] |- display;display~)
    //            rule':: I[IsaRelation]/\-(display;display~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `isarelation` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `isarelation` AS F0, `isarelation` AS F1
                                       WHERE F0.`display`=F1.`display`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (IsaRelation '.$v[0][0].',IsaRelation '.$v[0][1].')
reden: \"display[IsaRelation*String] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule105(){
    // Overtredingen behoren niet voor te komen in (display~;I[MultiplicityRule];display |- I[String])
    //            rule':: display~;I[MultiplicityRule];display/\-I[String]
    // sqlExprSrc fSpec rule':: display
     $v=DB_doquer('SELECT DISTINCT isect0.`display`, isect0.`display1`
                     FROM 
                        ( SELECT DISTINCT F0.`display`, F1.`display` AS `display1`
                            FROM `multiplicityrule` AS F0, `multiplicityrule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`display` <> isect0.`display1` AND isect0.`display` IS NOT NULL AND isect0.`display1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (String '.$v[0][0].',String '.$v[0][1].')
reden: \"display[MultiplicityRule*String] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule106(){
    // Overtredingen behoren niet voor te komen in (I[MultiplicityRule] |- display;display~)
    //            rule':: I[MultiplicityRule]/\-(display;display~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `multiplicityrule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `multiplicityrule` AS F0, `multiplicityrule` AS F1
                                       WHERE F0.`display`=F1.`display`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (MultiplicityRule '.$v[0][0].',MultiplicityRule '.$v[0][1].')
reden: \"display[MultiplicityRule*String] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule107(){
    // Overtredingen behoren niet voor te komen in (display~;I[HomogeneousRule];display |- I[String])
    //            rule':: display~;I[HomogeneousRule];display/\-I[String]
    // sqlExprSrc fSpec rule':: display
     $v=DB_doquer('SELECT DISTINCT isect0.`display`, isect0.`display1`
                     FROM 
                        ( SELECT DISTINCT F0.`display`, F1.`display` AS `display1`
                            FROM `homogeneousrule` AS F0, `homogeneousrule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`display` <> isect0.`display1` AND isect0.`display` IS NOT NULL AND isect0.`display1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (String '.$v[0][0].',String '.$v[0][1].')
reden: \"display[HomogeneousRule*String] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule108(){
    // Overtredingen behoren niet voor te komen in (I[HomogeneousRule] |- display;display~)
    //            rule':: I[HomogeneousRule]/\-(display;display~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `homogeneousrule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `homogeneousrule` AS F0, `homogeneousrule` AS F1
                                       WHERE F0.`display`=F1.`display`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (HomogeneousRule '.$v[0][0].',HomogeneousRule '.$v[0][1].')
reden: \"display[HomogeneousRule*String] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule109(){
    // Overtredingen behoren niet voor te komen in (display~;I[Prop];display |- I[String])
    //            rule':: display~;I[Prop];display/\-I[String]
    // sqlExprSrc fSpec rule':: display
     $v=DB_doquer('SELECT DISTINCT isect0.`display`, isect0.`display1`
                     FROM 
                        ( SELECT DISTINCT F0.`display`, F1.`display` AS `display1`
                            FROM `prop` AS F0, `prop` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`display` <> isect0.`display1` AND isect0.`display` IS NOT NULL AND isect0.`display1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (String '.$v[0][0].',String '.$v[0][1].')
reden: \"display[Prop*String] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule110(){
    // Overtredingen behoren niet voor te komen in (I[Prop] |- display;display~)
    //            rule':: I[Prop]/\-(display;display~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `prop` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `prop` AS F0, `prop` AS F1
                                       WHERE F0.`display`=F1.`display`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Prop '.$v[0][0].',Prop '.$v[0][1].')
reden: \"display[Prop*String] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule111(){
    // Overtredingen behoren niet voor te komen in (display~;I[UserRule];display |- I[String])
    //            rule':: display~;I[UserRule];display/\-I[String]
    // sqlExprSrc fSpec rule':: display
     $v=DB_doquer('SELECT DISTINCT isect0.`display`, isect0.`display1`
                     FROM 
                        ( SELECT DISTINCT F0.`display`, F1.`display` AS `display1`
                            FROM `userrule` AS F0, `userrule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`display` <> isect0.`display1` AND isect0.`display` IS NOT NULL AND isect0.`display1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (String '.$v[0][0].',String '.$v[0][1].')
reden: \"display[UserRule*String] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule112(){
    // Overtredingen behoren niet voor te komen in (I[UserRule] |- display;display~)
    //            rule':: I[UserRule]/\-(display;display~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `userrule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `userrule` AS F0, `userrule` AS F1
                                       WHERE F0.`display`=F1.`display`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (UserRule '.$v[0][0].',UserRule '.$v[0][1].')
reden: \"display[UserRule*String] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule113(){
    // Overtredingen behoren niet voor te komen in (display~;I[Rule];display |- I[String])
    //            rule':: display~;I[Rule];display/\-I[String]
    // sqlExprSrc fSpec rule':: display
     $v=DB_doquer('SELECT DISTINCT isect0.`display`, isect0.`display1`
                     FROM 
                        ( SELECT DISTINCT F0.`display`, F1.`display` AS `display1`
                            FROM `rule` AS F0, `rule` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`display` <> isect0.`display1` AND isect0.`display` IS NOT NULL AND isect0.`display1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (String '.$v[0][0].',String '.$v[0][1].')
reden: \"display[Rule*String] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule114(){
    // Overtredingen behoren niet voor te komen in (I[Rule] |- display;display~)
    //            rule':: I[Rule]/\-(display;display~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `rule` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `rule` AS F0, `rule` AS F1
                                       WHERE F0.`display`=F1.`display`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Rule '.$v[0][0].',Rule '.$v[0][1].')
reden: \"display[Rule*String] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule115(){
    // Overtredingen behoren niet voor te komen in (display~;I[Violation];display |- I[String])
    //            rule':: display~;I[Violation];display/\-I[String]
    // sqlExprSrc fSpec rule':: display
     $v=DB_doquer('SELECT DISTINCT isect0.`display`, isect0.`display1`
                     FROM 
                        ( SELECT DISTINCT F0.`display`, F1.`display` AS `display1`
                            FROM `violation` AS F0, `violation` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`display` <> isect0.`display1` AND isect0.`display` IS NOT NULL AND isect0.`display1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (String '.$v[0][0].',String '.$v[0][1].')
reden: \"display[Violation*String] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule116(){
    // Overtredingen behoren niet voor te komen in (I[Violation] |- display;display~)
    //            rule':: I[Violation]/\-(display;display~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `violation` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `violation` AS F0, `violation` AS F1
                                       WHERE F0.`display`=F1.`display`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Violation '.$v[0][0].',Violation '.$v[0][1].')
reden: \"display[Violation*String] is total\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule117(){
    // Overtredingen behoren niet voor te komen in (display~;I[Explanation];display |- I[String])
    //            rule':: display~;I[Explanation];display/\-I[String]
    // sqlExprSrc fSpec rule':: display
     $v=DB_doquer('SELECT DISTINCT isect0.`display`, isect0.`display1`
                     FROM 
                        ( SELECT DISTINCT F0.`display`, F1.`display` AS `display1`
                            FROM `explanation` AS F0, `explanation` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`display` <> isect0.`display1` AND isect0.`display` IS NOT NULL AND isect0.`display1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (String '.$v[0][0].',String '.$v[0][1].')
reden: \"display[Explanation*String] is univalent\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule118(){
    // Overtredingen behoren niet voor te komen in (I[Explanation] |- display;display~)
    //            rule':: I[Explanation]/\-(display;display~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `explanation` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `explanation` AS F0, `explanation` AS F1
                                       WHERE F0.`display`=F1.`display`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Explanation '.$v[0][0].',Explanation '.$v[0][1].')
reden: \"display[Explanation*String] is total\"<BR>',3);
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
    checkRule21();
    checkRule22();
    checkRule23();
    checkRule24();
    checkRule25();
    checkRule26();
    checkRule27();
    checkRule28();
    checkRule29();
    checkRule30();
    checkRule31();
    checkRule32();
    checkRule33();
    checkRule34();
    checkRule35();
    checkRule36();
    checkRule37();
    checkRule38();
    checkRule39();
    checkRule40();
    checkRule41();
    checkRule42();
    checkRule43();
    checkRule44();
    checkRule45();
    checkRule46();
    checkRule47();
    checkRule48();
    checkRule49();
    checkRule50();
    checkRule51();
    checkRule52();
    checkRule53();
    checkRule54();
    checkRule55();
    checkRule56();
    checkRule57();
    checkRule58();
    checkRule59();
    checkRule60();
    checkRule61();
    checkRule62();
    checkRule63();
    checkRule64();
    checkRule65();
    checkRule66();
    checkRule67();
    checkRule68();
    checkRule69();
    checkRule70();
    checkRule71();
    checkRule72();
    checkRule73();
    checkRule74();
    checkRule75();
    checkRule76();
    checkRule77();
    checkRule78();
    checkRule79();
    checkRule80();
    checkRule81();
    checkRule82();
    checkRule83();
    checkRule84();
    checkRule85();
    checkRule86();
    checkRule87();
    checkRule88();
    checkRule89();
    checkRule90();
    checkRule91();
    checkRule92();
    checkRule93();
    checkRule94();
    checkRule95();
    checkRule96();
    checkRule97();
    checkRule98();
    checkRule99();
    checkRule100();
    checkRule101();
    checkRule102();
    checkRule103();
    checkRule104();
    checkRule105();
    checkRule106();
    checkRule107();
    checkRule108();
    checkRule109();
    checkRule110();
    checkRule111();
    checkRule112();
    checkRule113();
    checkRule114();
    checkRule115();
    checkRule116();
    checkRule117();
    checkRule118();
  }
?>