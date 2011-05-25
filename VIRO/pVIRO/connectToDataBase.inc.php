<?php // generated with ADL vs. 0.8.10-452
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
  $DB_slct = mysql_select_db('VIROENG',$DB_link);
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
    // No violations should occur in (plaintiff;plaintiff~/\I |- person\/organization)
    //            rule':: plaintiff;plaintiff~/\I/\-person/\-organization
    // sqlExprSrc fSpec rule':: party
     $v=DB_doquer('SELECT DISTINCT isect0.`party`, isect0.`party1`
                     FROM 
                        ( SELECT DISTINCT F0.`party`, F1.`party` AS `party1`
                            FROM `plaintiff` AS F0, `plaintiff` AS F1
                           WHERE F0.`legalcase`=F1.`legalcase`
                        ) AS isect0, `party` AS isect1
                    WHERE isect0.`party` = isect0.`party1` AND NOT EXISTS (SELECT *
                                 FROM `person` AS cp
                                WHERE isect0.`party`=cp.`party` AND isect0.`party1`=cp.`party1`) AND NOT EXISTS (SELECT *
                                 FROM `organization` AS cp
                                WHERE isect0.`party`=cp.`party` AND isect0.`party1`=cp.`party1`) AND isect0.`party` IS NOT NULL AND isect0.`party1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Party '.$v[0][0].',Party '.$v[0][1].')
reden: \"The plaintiff in an administrative case is a juristic person\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule2(){
    // No violations should occur in (defendant;defendant~/\I |- administrativeAuthority)
    //            rule':: defendant;defendant~/\I/\-administrativeAuthority
    // sqlExprSrc fSpec rule':: party
     $v=DB_doquer('SELECT DISTINCT isect0.`party`, isect0.`party1`
                     FROM 
                        ( SELECT DISTINCT F0.`party`, F1.`party` AS `party1`
                            FROM `defendant` AS F0, `defendant` AS F1
                           WHERE F0.`LegalCase`=F1.`LegalCase`
                        ) AS isect0, `party` AS isect1
                    WHERE isect0.`party` = isect0.`party1` AND NOT EXISTS (SELECT *
                                 FROM `administrativeauthority` AS cp
                                WHERE isect0.`party`=cp.`party` AND isect0.`party1`=cp.`party1`) AND isect0.`party` IS NOT NULL AND isect0.`party1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Party '.$v[0][0].',Party '.$v[0][1].')
reden: \"The defendant in an administrative case is an administrative authority as referred to in art.1:1 Awb.\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule3(){
    // No violations should occur in (I |- (appeal\/appealToAdminCourt\/objection)/\-(appeal/\appealToAdminCourt/\objection))
    //            rule':: I/\(-appeal\/appealToAdminCourt)/\(-appeal\/objection)/\(-appealToAdminCourt\/appeal)/\(-appealToAdminCourt\/objection)/\(-objection\/appeal)/\(-objection\/appealToAdminCourt)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`legalcase` AS `i`, isect0.`legalcase1` AS `i1`
                     FROM 
                        ( 
                          (SELECT DISTINCT cfst.`i` AS `legalcase`, csnd.`i1` AS `legalcase1`
                                FROM `legalcase` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `legalcase`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `appeal` AS cp
                                           WHERE cfst.`i`=cp.`legalcase` AND csnd.`i1`=cp.`legalcase1`)
                          ) UNION (SELECT DISTINCT legalcase, legalcase1
                                FROM `appealtoadmincourt`
                          
                          )
                        ) AS isect0, 
                        ( 
                          (SELECT DISTINCT cfst.`i` AS `legalcase`, csnd.`i1` AS `legalcase1`
                                FROM `legalcase` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `legalcase`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `appeal` AS cp
                                           WHERE cfst.`i`=cp.`legalcase` AND csnd.`i1`=cp.`legalcase1`)
                          ) UNION (SELECT DISTINCT legalcase, legalcase1
                                FROM `objection`
                          
                          )
                        ) AS isect1, 
                        ( 
                          (SELECT DISTINCT cfst.`i` AS `legalcase`, csnd.`i1` AS `legalcase1`
                                FROM `legalcase` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `legalcase`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `appealtoadmincourt` AS cp
                                           WHERE cfst.`i`=cp.`legalcase` AND csnd.`i1`=cp.`legalcase1`)
                          ) UNION (SELECT DISTINCT legalcase, legalcase1
                                FROM `appeal`
                          
                          )
                        ) AS isect2, 
                        ( 
                          (SELECT DISTINCT cfst.`i` AS `legalcase`, csnd.`i1` AS `legalcase1`
                                FROM `legalcase` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `legalcase`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `appealtoadmincourt` AS cp
                                           WHERE cfst.`i`=cp.`legalcase` AND csnd.`i1`=cp.`legalcase1`)
                          ) UNION (SELECT DISTINCT legalcase, legalcase1
                                FROM `objection`
                          
                          )
                        ) AS isect3, 
                        ( 
                          (SELECT DISTINCT cfst.`i` AS `legalcase`, csnd.`i1` AS `legalcase1`
                                FROM `legalcase` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `legalcase`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `objection` AS cp
                                           WHERE cfst.`i`=cp.`legalcase` AND csnd.`i1`=cp.`legalcase1`)
                          ) UNION (SELECT DISTINCT legalcase, legalcase1
                                FROM `appeal`
                          
                          )
                        ) AS isect4, 
                        ( 
                          (SELECT DISTINCT cfst.`i` AS `legalcase`, csnd.`i1` AS `legalcase1`
                                FROM `legalcase` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `legalcase`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `objection` AS cp
                                           WHERE cfst.`i`=cp.`legalcase` AND csnd.`i1`=cp.`legalcase1`)
                          ) UNION (SELECT DISTINCT legalcase, legalcase1
                                FROM `appealtoadmincourt`
                          
                          )
                        ) AS isect5, `legalcase` AS isect6
                    WHERE (isect0.`legalcase` = isect1.`legalcase` AND isect0.`legalcase1` = isect1.`legalcase1`) AND (isect0.`legalcase` = isect2.`legalcase` AND isect0.`legalcase1` = isect2.`legalcase1`) AND (isect0.`legalcase` = isect3.`legalcase` AND isect0.`legalcase1` = isect3.`legalcase1`) AND (isect0.`legalcase` = isect4.`legalcase` AND isect0.`legalcase1` = isect4.`legalcase1`) AND (isect0.`legalcase` = isect5.`legalcase` AND isect0.`legalcase1` = isect5.`legalcase1`) AND isect0.`legalcase` = isect0.`legalcase1` AND isect0.`legalcase` IS NOT NULL AND isect0.`legalcase1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (LegalCase '.$v[0][0].',LegalCase '.$v[0][1].')
reden: \"Every administrative case is either an appeal or an objection or an appeal to an administrative court. (Art.6:4 Awb)\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule4(){
    // No violations should occur in (I |- (person\/organization\/administrativeAuthority)/\-(person/\organization/\administrativeAuthority))
    //            rule':: I/\(-person\/organization)/\(-person\/administrativeAuthority)/\(-organization\/person)/\(-organization\/administrativeAuthority)/\(-administrativeAuthority\/person)/\(-administrativeAuthority\/organization)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`party` AS `i`, isect0.`party1` AS `i1`
                     FROM 
                        ( 
                          (SELECT DISTINCT cfst.`i` AS `party`, csnd.`i1` AS `party1`
                                FROM `party` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `party`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `person` AS cp
                                           WHERE cfst.`i`=cp.`party` AND csnd.`i1`=cp.`party1`)
                          ) UNION (SELECT DISTINCT party, party1
                                FROM `organization`
                          
                          )
                        ) AS isect0, 
                        ( 
                          (SELECT DISTINCT cfst.`i` AS `party`, csnd.`i1` AS `party1`
                                FROM `party` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `party`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `person` AS cp
                                           WHERE cfst.`i`=cp.`party` AND csnd.`i1`=cp.`party1`)
                          ) UNION (SELECT DISTINCT party, party1
                                FROM `administrativeauthority`
                          
                          )
                        ) AS isect1, 
                        ( 
                          (SELECT DISTINCT cfst.`i` AS `party`, csnd.`i1` AS `party1`
                                FROM `party` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `party`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `organization` AS cp
                                           WHERE cfst.`i`=cp.`party` AND csnd.`i1`=cp.`party1`)
                          ) UNION (SELECT DISTINCT party, party1
                                FROM `person`
                          
                          )
                        ) AS isect2, 
                        ( 
                          (SELECT DISTINCT cfst.`i` AS `party`, csnd.`i1` AS `party1`
                                FROM `party` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `party`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `organization` AS cp
                                           WHERE cfst.`i`=cp.`party` AND csnd.`i1`=cp.`party1`)
                          ) UNION (SELECT DISTINCT party, party1
                                FROM `administrativeauthority`
                          
                          )
                        ) AS isect3, 
                        ( 
                          (SELECT DISTINCT cfst.`i` AS `party`, csnd.`i1` AS `party1`
                                FROM `party` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `party`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `administrativeauthority` AS cp
                                           WHERE cfst.`i`=cp.`party` AND csnd.`i1`=cp.`party1`)
                          ) UNION (SELECT DISTINCT party, party1
                                FROM `person`
                          
                          )
                        ) AS isect4, 
                        ( 
                          (SELECT DISTINCT cfst.`i` AS `party`, csnd.`i1` AS `party1`
                                FROM `party` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `party`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `administrativeauthority` AS cp
                                           WHERE cfst.`i`=cp.`party` AND csnd.`i1`=cp.`party1`)
                          ) UNION (SELECT DISTINCT party, party1
                                FROM `organization`
                          
                          )
                        ) AS isect5, `party` AS isect6
                    WHERE (isect0.`party` = isect1.`party` AND isect0.`party1` = isect1.`party1`) AND (isect0.`party` = isect2.`party` AND isect0.`party1` = isect2.`party1`) AND (isect0.`party` = isect3.`party` AND isect0.`party1` = isect3.`party1`) AND (isect0.`party` = isect4.`party` AND isect0.`party1` = isect4.`party1`) AND (isect0.`party` = isect5.`party` AND isect0.`party1` = isect5.`party1`) AND isect0.`party` = isect0.`party1` AND isect0.`party` IS NOT NULL AND isect0.`party1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Party '.$v[0][0].',Party '.$v[0][1].')
reden: \"Every party is either a person or an organization or an administrative authority.\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule5(){
    // No violations should occur in (memberOfGovernment |- administrativeAuthority)
    //            rule':: memberOfGovernment/\-administrativeAuthority
    // sqlExprSrc fSpec rule':: party
     $v=DB_doquer('SELECT DISTINCT isect0.`party`, isect0.`party1`
                     FROM `memberofgovernment` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM `administrativeauthority` AS cp
                                WHERE isect0.`party`=cp.`party` AND isect0.`party1`=cp.`party1`) AND isect0.`party` IS NOT NULL AND isect0.`party1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Party '.$v[0][0].',Party '.$v[0][1].')
reden: \"Members of the government, i.e., Ministers and Secretaries of State, are administrative authorities according to the constitution.\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule6(){
    // No violations should occur in (panel;panel~/\location;location~/\scheduled;scheduled~ |- I)
    //            rule':: panel;panel~/\location;location~/\scheduled;scheduled~/\-I
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i1`
                     FROM 
                        ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                            FROM `session` AS F0, `session` AS F1
                           WHERE F0.`panel`=F1.`panel`
                        ) AS isect0, 
                        ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                            FROM `session` AS F0, `session` AS F1
                           WHERE F0.`location`=F1.`location`
                        ) AS isect1, 
                        ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                            FROM `session` AS F0, `session` AS F1
                           WHERE F0.`scheduled`=F1.`scheduled`
                        ) AS isect2
                    WHERE (isect0.`i` = isect1.`i` AND isect0.`i1` = isect1.`i1`) AND (isect0.`i` = isect2.`i` AND isect0.`i1` = isect2.`i1`) AND isect0.`i` <> isect0.`i1` AND isect0.`i` IS NOT NULL AND isect0.`i1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Session '.$v[0][0].',Session '.$v[0][1].')
reden: \"a session can be identified by its panel, its city and its date.\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule7(){
    // No violations should occur in (judge |- panel;members~)
    //            rule':: judge/\-(panel;members~)
    // sqlExprSrc fSpec rule':: session
     $v=DB_doquer('SELECT DISTINCT isect0.`session`, isect0.`party`
                     FROM `judge` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`party`
                                        FROM `session` AS F0, `members` AS F1
                                       WHERE F0.`panel`=F1.`Panel`
                                    ) AS cp
                                WHERE isect0.`session`=cp.`i` AND isect0.`party`=cp.`party`) AND isect0.`session` IS NOT NULL AND isect0.`party` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Session '.$v[0][0].',Party '.$v[0][1].')
reden: \"A judge at a session is a member of the panel that runs the session.\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule8(){
    // No violations should occur in (clerk |- location;clerk)
    //            rule':: clerk/\-(location;clerk)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`clerk`
                     FROM `session` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`Party`
                                        FROM `session` AS F0, `clerk` AS F1
                                       WHERE F0.`location`=F1.`court`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`clerk`=cp.`Party`) AND isect0.`i` IS NOT NULL AND isect0.`clerk` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Session '.$v[0][0].',Party '.$v[0][1].')
reden: \"The clerk of a session must be the clerk of the court where the session is held.\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule9(){
    // No violations should occur in (occured |- scheduled)
    //            rule':: occured/\-scheduled
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`occured`
                     FROM `session` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM `session` AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`occured`=cp.`scheduled`) AND isect0.`i` IS NOT NULL AND isect0.`occured` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Session '.$v[0][0].',Date '.$v[0][1].')
reden: \"All sessions are scheduled\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule10(){
    // No violations should occur in (administrativeAuthorityAwb87 |- administrativeAuthority)
    //            rule':: administrativeAuthorityAwb87/\-administrativeAuthority
    // sqlExprSrc fSpec rule':: party
     $v=DB_doquer('SELECT DISTINCT isect0.`party`, isect0.`party1`
                     FROM `administrativeauthorityawb87` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM `administrativeauthority` AS cp
                                WHERE isect0.`party`=cp.`party` AND isect0.`party1`=cp.`party1`) AND isect0.`party` IS NOT NULL AND isect0.`party1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Party '.$v[0][0].',Party '.$v[0][1].')
reden: \"Administrative authorities as referred to in art.8:7 par.1 Awb are administrative authorities as referred to in art.1:1 Awb.\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule11(){
    // No violations should occur in (appeal;defendant~;administrativeAuthorityAwb87;domicile;jurisdiction |- broughtBefore)
    //            rule':: appeal;defendant~;administrativeAuthorityAwb87;domicile;jurisdiction/\-broughtBefore
    // sqlExprSrc fSpec rule':: legalcase
     $v=DB_doquer('SELECT DISTINCT isect0.`legalcase`, isect0.`jurisdiction`
                     FROM 
                        ( SELECT DISTINCT F0.`legalcase`, F4.`jurisdiction`
                            FROM `appeal` AS F0, `defendant` AS F1, `administrativeauthorityawb87` AS F2, `domicile` AS F3, `city` AS F4
                           WHERE F0.`legalcase1`=F1.`LegalCase`
                             AND F1.`party`=F2.`party`
                             AND F2.`party1`=F3.`party`
                             AND F3.`City`=F4.`i`
                        ) AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM `broughtbefore` AS cp
                                WHERE isect0.`legalcase`=cp.`legalcase` AND isect0.`jurisdiction`=cp.`Court`) AND isect0.`legalcase` IS NOT NULL AND isect0.`jurisdiction` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (LegalCase '.$v[0][0].',Court '.$v[0][1].')
reden: \"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule12(){
    // No violations should occur in (I |- plaintiff~;plaintiff)
    //            rule':: I/\-(plaintiff~;plaintiff)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `legalcase` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`legalcase`, F1.`legalcase` AS `legalcase1`
                                        FROM `plaintiff` AS F0, `plaintiff` AS F1
                                       WHERE F0.`party`=F1.`party`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`legalcase` AND isect0.`i`=cp.`legalcase1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (LegalCase '.$v[0][0].',LegalCase '.$v[0][1].')
reden: \"Artificial explanation: I |- plaintiff~;plaintiff\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule13(){
    // No violations should occur in (areaOfLaw~;areaOfLaw |- I)
    //            rule':: areaOfLaw~;areaOfLaw/\-I
    // sqlExprSrc fSpec rule':: areaoflaw
     $v=DB_doquer('SELECT DISTINCT isect0.`areaoflaw`, isect0.`areaoflaw1`
                     FROM 
                        ( SELECT DISTINCT F0.`areaoflaw`, F1.`areaoflaw` AS `areaoflaw1`
                            FROM `legalcase` AS F0, `legalcase` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`areaoflaw` <> isect0.`areaoflaw1` AND isect0.`areaoflaw` IS NOT NULL AND isect0.`areaoflaw1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (AreaOfLaw '.$v[0][0].',AreaOfLaw '.$v[0][1].')
reden: \"Artificial explanation: areaOfLaw~;areaOfLaw |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule14(){
    // No violations should occur in (I |- areaOfLaw;areaOfLaw~)
    //            rule':: I/\-(areaOfLaw;areaOfLaw~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `legalcase` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `legalcase` AS F0, `legalcase` AS F1
                                       WHERE F0.`areaoflaw`=F1.`areaoflaw`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (LegalCase '.$v[0][0].',LegalCase '.$v[0][1].')
reden: \"Artificial explanation: I |- areaOfLaw;areaOfLaw~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule15(){
    // No violations should occur in (documentType~;documentType |- I)
    //            rule':: documentType~;documentType/\-I
    // sqlExprSrc fSpec rule':: documenttype
     $v=DB_doquer('SELECT DISTINCT isect0.`documenttype`, isect0.`documenttype1`
                     FROM 
                        ( SELECT DISTINCT F0.`documenttype`, F1.`documenttype` AS `documenttype1`
                            FROM `document` AS F0, `document` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`documenttype` <> isect0.`documenttype1` AND isect0.`documenttype` IS NOT NULL AND isect0.`documenttype1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (DocumentType '.$v[0][0].',DocumentType '.$v[0][1].')
reden: \"Artificial explanation: documentType~;documentType |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule16(){
    // No violations should occur in (I |- documentType;documentType~)
    //            rule':: I/\-(documentType;documentType~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `document` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `document` AS F0, `document` AS F1
                                       WHERE F0.`documenttype`=F1.`documenttype`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Document '.$v[0][0].',Document '.$v[0][1].')
reden: \"Artificial explanation: I |- documentType;documentType~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule17(){
    // No violations should occur in (caseType~;caseType |- I)
    //            rule':: caseType~;caseType/\-I
    // sqlExprSrc fSpec rule':: casetype
     $v=DB_doquer('SELECT DISTINCT isect0.`casetype`, isect0.`casetype1`
                     FROM 
                        ( SELECT DISTINCT F0.`casetype`, F1.`casetype` AS `casetype1`
                            FROM `legalcase` AS F0, `legalcase` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`casetype` <> isect0.`casetype1` AND isect0.`casetype` IS NOT NULL AND isect0.`casetype1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (CaseType '.$v[0][0].',CaseType '.$v[0][1].')
reden: \"Artificial explanation: caseType~;caseType |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule18(){
    // No violations should occur in (I |- caseType;caseType~)
    //            rule':: I/\-(caseType;caseType~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `legalcase` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `legalcase` AS F0, `legalcase` AS F1
                                       WHERE F0.`casetype`=F1.`casetype`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (LegalCase '.$v[0][0].',LegalCase '.$v[0][1].')
reden: \"Artificial explanation: I |- caseType;caseType~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule19(){
    // No violations should occur in (appeal = appeal~)
    //            rule':: (-appeal\/-appeal~)/\(appeal~\/appeal)
    // sqlExprSrc fSpec rule':: legalcase
     $v=DB_doquer('SELECT DISTINCT isect0.`legalcase`, isect0.`legalcase1`
                     FROM 
                        ( 
                          (SELECT DISTINCT cfst.`i` AS `legalcase`, csnd.`i1` AS `legalcase1`
                                FROM `legalcase` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `legalcase`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `appeal` AS cp
                                           WHERE cfst.`i`=cp.`legalcase` AND csnd.`i1`=cp.`legalcase1`)
                          ) UNION (SELECT DISTINCT cfst.`i` AS `legalcase`, csnd.`i1` AS `legalcase1`
                                FROM `legalcase` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `legalcase`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `appeal` AS cp
                                           WHERE cfst.`i`=cp.`legalcase1` AND csnd.`i1`=cp.`legalcase`)
                          
                          )
                        ) AS isect0, 
                        ( 
                          (SELECT DISTINCT legalcase1, legalcase
                                FROM `appeal`
                          ) UNION (SELECT DISTINCT legalcase AS `legalcase1`, legalcase1 AS `legalcase`
                                FROM `appeal`
                          
                          )
                        ) AS isect1
                    WHERE (isect0.`legalcase` = isect1.`legalcase1` AND isect0.`legalcase1` = isect1.`legalcase`) AND isect0.`legalcase` IS NOT NULL AND isect0.`legalcase1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (LegalCase '.$v[0][0].',LegalCase '.$v[0][1].')
reden: \"Artificial explanation: appeal = appeal~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule20(){
    // No violations should occur in (appeal~/\appeal |- I)
    //            rule':: appeal~/\appeal/\-I
    // sqlExprSrc fSpec rule':: legalcase1
     $v=DB_doquer('SELECT DISTINCT isect0.`legalcase1`, isect0.`legalcase`
                     FROM `appeal` AS isect0, `appeal` AS isect1
                    WHERE (isect0.`legalcase1` = isect1.`legalcase` AND isect0.`legalcase` = isect1.`legalcase1`) AND isect0.`legalcase1` <> isect0.`legalcase` AND isect0.`legalcase1` IS NOT NULL AND isect0.`legalcase` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (LegalCase '.$v[0][0].',LegalCase '.$v[0][1].')
reden: \"Artificial explanation: appeal~/\\appeal |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule21(){
    // No violations should occur in (appealToAdminCourt = appealToAdminCourt~)
    //            rule':: (-appealToAdminCourt\/-appealToAdminCourt~)/\(appealToAdminCourt~\/appealToAdminCourt)
    // sqlExprSrc fSpec rule':: legalcase
     $v=DB_doquer('SELECT DISTINCT isect0.`legalcase`, isect0.`legalcase1`
                     FROM 
                        ( 
                          (SELECT DISTINCT cfst.`i` AS `legalcase`, csnd.`i1` AS `legalcase1`
                                FROM `legalcase` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `legalcase`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `appealtoadmincourt` AS cp
                                           WHERE cfst.`i`=cp.`legalcase` AND csnd.`i1`=cp.`legalcase1`)
                          ) UNION (SELECT DISTINCT cfst.`i` AS `legalcase`, csnd.`i1` AS `legalcase1`
                                FROM `legalcase` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `legalcase`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `appealtoadmincourt` AS cp
                                           WHERE cfst.`i`=cp.`legalcase1` AND csnd.`i1`=cp.`legalcase`)
                          
                          )
                        ) AS isect0, 
                        ( 
                          (SELECT DISTINCT legalcase1, legalcase
                                FROM `appealtoadmincourt`
                          ) UNION (SELECT DISTINCT legalcase AS `legalcase1`, legalcase1 AS `legalcase`
                                FROM `appealtoadmincourt`
                          
                          )
                        ) AS isect1
                    WHERE (isect0.`legalcase` = isect1.`legalcase1` AND isect0.`legalcase1` = isect1.`legalcase`) AND isect0.`legalcase` IS NOT NULL AND isect0.`legalcase1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (LegalCase '.$v[0][0].',LegalCase '.$v[0][1].')
reden: \"Artificial explanation: appealToAdminCourt = appealToAdminCourt~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule22(){
    // No violations should occur in (appealToAdminCourt~/\appealToAdminCourt |- I)
    //            rule':: appealToAdminCourt~/\appealToAdminCourt/\-I
    // sqlExprSrc fSpec rule':: legalcase1
     $v=DB_doquer('SELECT DISTINCT isect0.`legalcase1`, isect0.`legalcase`
                     FROM `appealtoadmincourt` AS isect0, `appealtoadmincourt` AS isect1
                    WHERE (isect0.`legalcase1` = isect1.`legalcase` AND isect0.`legalcase` = isect1.`legalcase1`) AND isect0.`legalcase1` <> isect0.`legalcase` AND isect0.`legalcase1` IS NOT NULL AND isect0.`legalcase` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (LegalCase '.$v[0][0].',LegalCase '.$v[0][1].')
reden: \"Artificial explanation: appealToAdminCourt~/\\appealToAdminCourt |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule23(){
    // No violations should occur in (objection = objection~)
    //            rule':: (-objection\/-objection~)/\(objection~\/objection)
    // sqlExprSrc fSpec rule':: legalcase
     $v=DB_doquer('SELECT DISTINCT isect0.`legalcase`, isect0.`legalcase1`
                     FROM 
                        ( 
                          (SELECT DISTINCT cfst.`i` AS `legalcase`, csnd.`i1` AS `legalcase1`
                                FROM `legalcase` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `legalcase`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `objection` AS cp
                                           WHERE cfst.`i`=cp.`legalcase` AND csnd.`i1`=cp.`legalcase1`)
                          ) UNION (SELECT DISTINCT cfst.`i` AS `legalcase`, csnd.`i1` AS `legalcase1`
                                FROM `legalcase` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `legalcase`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `objection` AS cp
                                           WHERE cfst.`i`=cp.`legalcase1` AND csnd.`i1`=cp.`legalcase`)
                          
                          )
                        ) AS isect0, 
                        ( 
                          (SELECT DISTINCT legalcase1, legalcase
                                FROM `objection`
                          ) UNION (SELECT DISTINCT legalcase AS `legalcase1`, legalcase1 AS `legalcase`
                                FROM `objection`
                          
                          )
                        ) AS isect1
                    WHERE (isect0.`legalcase` = isect1.`legalcase1` AND isect0.`legalcase1` = isect1.`legalcase`) AND isect0.`legalcase` IS NOT NULL AND isect0.`legalcase1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (LegalCase '.$v[0][0].',LegalCase '.$v[0][1].')
reden: \"Artificial explanation: objection = objection~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule24(){
    // No violations should occur in (objection~/\objection |- I)
    //            rule':: objection~/\objection/\-I
    // sqlExprSrc fSpec rule':: legalcase1
     $v=DB_doquer('SELECT DISTINCT isect0.`legalcase1`, isect0.`legalcase`
                     FROM `objection` AS isect0, `objection` AS isect1
                    WHERE (isect0.`legalcase1` = isect1.`legalcase` AND isect0.`legalcase` = isect1.`legalcase1`) AND isect0.`legalcase1` <> isect0.`legalcase` AND isect0.`legalcase1` IS NOT NULL AND isect0.`legalcase` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (LegalCase '.$v[0][0].',LegalCase '.$v[0][1].')
reden: \"Artificial explanation: objection~/\\objection |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule25(){
    // No violations should occur in (person = person~)
    //            rule':: (-person\/-person~)/\(person~\/person)
    // sqlExprSrc fSpec rule':: party
     $v=DB_doquer('SELECT DISTINCT isect0.`party`, isect0.`party1`
                     FROM 
                        ( 
                          (SELECT DISTINCT cfst.`i` AS `party`, csnd.`i1` AS `party1`
                                FROM `party` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `party`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `person` AS cp
                                           WHERE cfst.`i`=cp.`party` AND csnd.`i1`=cp.`party1`)
                          ) UNION (SELECT DISTINCT cfst.`i` AS `party`, csnd.`i1` AS `party1`
                                FROM `party` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `party`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `person` AS cp
                                           WHERE cfst.`i`=cp.`party1` AND csnd.`i1`=cp.`party`)
                          
                          )
                        ) AS isect0, 
                        ( 
                          (SELECT DISTINCT party1, party
                                FROM `person`
                          ) UNION (SELECT DISTINCT party AS `party1`, party1 AS `party`
                                FROM `person`
                          
                          )
                        ) AS isect1
                    WHERE (isect0.`party` = isect1.`party1` AND isect0.`party1` = isect1.`party`) AND isect0.`party` IS NOT NULL AND isect0.`party1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Party '.$v[0][0].',Party '.$v[0][1].')
reden: \"Artificial explanation: person = person~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule26(){
    // No violations should occur in (person~/\person |- I)
    //            rule':: person~/\person/\-I
    // sqlExprSrc fSpec rule':: party1
     $v=DB_doquer('SELECT DISTINCT isect0.`party1`, isect0.`party`
                     FROM `person` AS isect0, `person` AS isect1
                    WHERE (isect0.`party1` = isect1.`party` AND isect0.`party` = isect1.`party1`) AND isect0.`party1` <> isect0.`party` AND isect0.`party1` IS NOT NULL AND isect0.`party` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Party '.$v[0][0].',Party '.$v[0][1].')
reden: \"Artificial explanation: person~/\\person |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule27(){
    // No violations should occur in (organization = organization~)
    //            rule':: (-organization\/-organization~)/\(organization~\/organization)
    // sqlExprSrc fSpec rule':: party
     $v=DB_doquer('SELECT DISTINCT isect0.`party`, isect0.`party1`
                     FROM 
                        ( 
                          (SELECT DISTINCT cfst.`i` AS `party`, csnd.`i1` AS `party1`
                                FROM `party` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `party`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `organization` AS cp
                                           WHERE cfst.`i`=cp.`party` AND csnd.`i1`=cp.`party1`)
                          ) UNION (SELECT DISTINCT cfst.`i` AS `party`, csnd.`i1` AS `party1`
                                FROM `party` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `party`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `organization` AS cp
                                           WHERE cfst.`i`=cp.`party1` AND csnd.`i1`=cp.`party`)
                          
                          )
                        ) AS isect0, 
                        ( 
                          (SELECT DISTINCT party1, party
                                FROM `organization`
                          ) UNION (SELECT DISTINCT party AS `party1`, party1 AS `party`
                                FROM `organization`
                          
                          )
                        ) AS isect1
                    WHERE (isect0.`party` = isect1.`party1` AND isect0.`party1` = isect1.`party`) AND isect0.`party` IS NOT NULL AND isect0.`party1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Party '.$v[0][0].',Party '.$v[0][1].')
reden: \"Artificial explanation: organization = organization~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule28(){
    // No violations should occur in (organization~/\organization |- I)
    //            rule':: organization~/\organization/\-I
    // sqlExprSrc fSpec rule':: party1
     $v=DB_doquer('SELECT DISTINCT isect0.`party1`, isect0.`party`
                     FROM `organization` AS isect0, `organization` AS isect1
                    WHERE (isect0.`party1` = isect1.`party` AND isect0.`party` = isect1.`party1`) AND isect0.`party1` <> isect0.`party` AND isect0.`party1` IS NOT NULL AND isect0.`party` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Party '.$v[0][0].',Party '.$v[0][1].')
reden: \"Artificial explanation: organization~/\\organization |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule29(){
    // No violations should occur in (administrativeAuthority = administrativeAuthority~)
    //            rule':: (-administrativeAuthority\/-administrativeAuthority~)/\(administrativeAuthority~\/administrativeAuthority)
    // sqlExprSrc fSpec rule':: party
     $v=DB_doquer('SELECT DISTINCT isect0.`party`, isect0.`party1`
                     FROM 
                        ( 
                          (SELECT DISTINCT cfst.`i` AS `party`, csnd.`i1` AS `party1`
                                FROM `party` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `party`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `administrativeauthority` AS cp
                                           WHERE cfst.`i`=cp.`party` AND csnd.`i1`=cp.`party1`)
                          ) UNION (SELECT DISTINCT cfst.`i` AS `party`, csnd.`i1` AS `party1`
                                FROM `party` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `party`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `administrativeauthority` AS cp
                                           WHERE cfst.`i`=cp.`party1` AND csnd.`i1`=cp.`party`)
                          
                          )
                        ) AS isect0, 
                        ( 
                          (SELECT DISTINCT party1, party
                                FROM `administrativeauthority`
                          ) UNION (SELECT DISTINCT party AS `party1`, party1 AS `party`
                                FROM `administrativeauthority`
                          
                          )
                        ) AS isect1
                    WHERE (isect0.`party` = isect1.`party1` AND isect0.`party1` = isect1.`party`) AND isect0.`party` IS NOT NULL AND isect0.`party1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Party '.$v[0][0].',Party '.$v[0][1].')
reden: \"Artificial explanation: administrativeAuthority = administrativeAuthority~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule30(){
    // No violations should occur in (administrativeAuthority~/\administrativeAuthority |- I)
    //            rule':: administrativeAuthority~/\administrativeAuthority/\-I
    // sqlExprSrc fSpec rule':: party1
     $v=DB_doquer('SELECT DISTINCT isect0.`party1`, isect0.`party`
                     FROM `administrativeauthority` AS isect0, `administrativeauthority` AS isect1
                    WHERE (isect0.`party1` = isect1.`party` AND isect0.`party` = isect1.`party1`) AND isect0.`party1` <> isect0.`party` AND isect0.`party1` IS NOT NULL AND isect0.`party` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Party '.$v[0][0].',Party '.$v[0][1].')
reden: \"Artificial explanation: administrativeAuthority~/\\administrativeAuthority |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule31(){
    // No violations should occur in (memberOfGovernment = memberOfGovernment~)
    //            rule':: (-memberOfGovernment\/-memberOfGovernment~)/\(memberOfGovernment~\/memberOfGovernment)
    // sqlExprSrc fSpec rule':: party
     $v=DB_doquer('SELECT DISTINCT isect0.`party`, isect0.`party1`
                     FROM 
                        ( 
                          (SELECT DISTINCT cfst.`i` AS `party`, csnd.`i1` AS `party1`
                                FROM `party` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `party`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `memberofgovernment` AS cp
                                           WHERE cfst.`i`=cp.`party` AND csnd.`i1`=cp.`party1`)
                          ) UNION (SELECT DISTINCT cfst.`i` AS `party`, csnd.`i1` AS `party1`
                                FROM `party` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `party`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `memberofgovernment` AS cp
                                           WHERE cfst.`i`=cp.`party1` AND csnd.`i1`=cp.`party`)
                          
                          )
                        ) AS isect0, 
                        ( 
                          (SELECT DISTINCT party1, party
                                FROM `memberofgovernment`
                          ) UNION (SELECT DISTINCT party AS `party1`, party1 AS `party`
                                FROM `memberofgovernment`
                          
                          )
                        ) AS isect1
                    WHERE (isect0.`party` = isect1.`party1` AND isect0.`party1` = isect1.`party`) AND isect0.`party` IS NOT NULL AND isect0.`party1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Party '.$v[0][0].',Party '.$v[0][1].')
reden: \"Artificial explanation: memberOfGovernment = memberOfGovernment~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule32(){
    // No violations should occur in (memberOfGovernment~/\memberOfGovernment |- I)
    //            rule':: memberOfGovernment~/\memberOfGovernment/\-I
    // sqlExprSrc fSpec rule':: party1
     $v=DB_doquer('SELECT DISTINCT isect0.`party1`, isect0.`party`
                     FROM `memberofgovernment` AS isect0, `memberofgovernment` AS isect1
                    WHERE (isect0.`party1` = isect1.`party` AND isect0.`party` = isect1.`party1`) AND isect0.`party1` <> isect0.`party` AND isect0.`party1` IS NOT NULL AND isect0.`party` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Party '.$v[0][0].',Party '.$v[0][1].')
reden: \"Artificial explanation: memberOfGovernment~/\\memberOfGovernment |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule33(){
    // No violations should occur in (session~;session |- I)
    //            rule':: session~;session/\-I
    // sqlExprSrc fSpec rule':: session
     $v=DB_doquer('SELECT DISTINCT isect0.`session`, isect0.`session1`
                     FROM 
                        ( SELECT DISTINCT F0.`session`, F1.`session` AS `session1`
                            FROM `process` AS F0, `process` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`session` <> isect0.`session1` AND isect0.`session` IS NOT NULL AND isect0.`session1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Session '.$v[0][0].',Session '.$v[0][1].')
reden: \"Artificial explanation: session~;session |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule34(){
    // No violations should occur in (I |- session;session~)
    //            rule':: I/\-(session;session~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `process` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `process` AS F0, `process` AS F1
                                       WHERE F0.`session`=F1.`session`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Process '.$v[0][0].',Process '.$v[0][1].')
reden: \"Artificial explanation: I |- session;session~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule35(){
    // No violations should occur in (legalCase~;legalCase |- I)
    //            rule':: legalCase~;legalCase/\-I
    // sqlExprSrc fSpec rule':: legalcase
     $v=DB_doquer('SELECT DISTINCT isect0.`legalcase`, isect0.`legalcase1`
                     FROM 
                        ( SELECT DISTINCT F0.`legalcase`, F1.`legalcase` AS `legalcase1`
                            FROM `process` AS F0, `process` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`legalcase` <> isect0.`legalcase1` AND isect0.`legalcase` IS NOT NULL AND isect0.`legalcase1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (LegalCase '.$v[0][0].',LegalCase '.$v[0][1].')
reden: \"Artificial explanation: legalCase~;legalCase |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule36(){
    // No violations should occur in (I |- legalCase;legalCase~)
    //            rule':: I/\-(legalCase;legalCase~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `process` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `process` AS F0, `process` AS F1
                                       WHERE F0.`legalcase`=F1.`legalcase`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Process '.$v[0][0].',Process '.$v[0][1].')
reden: \"Artificial explanation: I |- legalCase;legalCase~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule37(){
    // No violations should occur in (panel~;panel |- I)
    //            rule':: panel~;panel/\-I
    // sqlExprSrc fSpec rule':: panel
     $v=DB_doquer('SELECT DISTINCT isect0.`panel`, isect0.`panel1`
                     FROM 
                        ( SELECT DISTINCT F0.`panel`, F1.`panel` AS `panel1`
                            FROM `session` AS F0, `session` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`panel` <> isect0.`panel1` AND isect0.`panel` IS NOT NULL AND isect0.`panel1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Panel '.$v[0][0].',Panel '.$v[0][1].')
reden: \"Artificial explanation: panel~;panel |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule38(){
    // No violations should occur in (I |- panel;panel~)
    //            rule':: I/\-(panel;panel~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `session` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `session` AS F0, `session` AS F1
                                       WHERE F0.`panel`=F1.`panel`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Session '.$v[0][0].',Session '.$v[0][1].')
reden: \"Artificial explanation: I |- panel;panel~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule39(){
    // No violations should occur in (court~;court |- I)
    //            rule':: court~;court/\-I
    // sqlExprSrc fSpec rule':: court
     $v=DB_doquer('SELECT DISTINCT isect0.`court`, isect0.`court1`
                     FROM 
                        ( SELECT DISTINCT F0.`court`, F1.`court` AS `court1`
                            FROM `panel` AS F0, `panel` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`court` <> isect0.`court1` AND isect0.`court` IS NOT NULL AND isect0.`court1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Court '.$v[0][0].',Court '.$v[0][1].')
reden: \"Artificial explanation: court~;court |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule40(){
    // No violations should occur in (I |- court;court~)
    //            rule':: I/\-(court;court~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `panel` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `panel` AS F0, `panel` AS F1
                                       WHERE F0.`court`=F1.`court`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Panel '.$v[0][0].',Panel '.$v[0][1].')
reden: \"Artificial explanation: I |- court;court~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule41(){
    // No violations should occur in (I |- judge;judge~)
    //            rule':: I/\-(judge;judge~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `session` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`session`, F1.`session` AS `session1`
                                        FROM `judge` AS F0, `judge` AS F1
                                       WHERE F0.`party`=F1.`party`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`session` AND isect0.`i`=cp.`session1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Session '.$v[0][0].',Session '.$v[0][1].')
reden: \"Artificial explanation: I |- judge;judge~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule42(){
    // No violations should occur in (clerk~;clerk |- I)
    //            rule':: clerk~;clerk/\-I
    // sqlExprSrc fSpec rule':: clerk
     $v=DB_doquer('SELECT DISTINCT isect0.`clerk`, isect0.`clerk1`
                     FROM 
                        ( SELECT DISTINCT F0.`clerk`, F1.`clerk` AS `clerk1`
                            FROM `session` AS F0, `session` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`clerk` <> isect0.`clerk1` AND isect0.`clerk` IS NOT NULL AND isect0.`clerk1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Party '.$v[0][0].',Party '.$v[0][1].')
reden: \"Artificial explanation: clerk~;clerk |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule43(){
    // No violations should occur in (I |- clerk;clerk~)
    //            rule':: I/\-(clerk;clerk~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `session` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `session` AS F0, `session` AS F1
                                       WHERE F0.`clerk`=F1.`clerk`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Session '.$v[0][0].',Session '.$v[0][1].')
reden: \"Artificial explanation: I |- clerk;clerk~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule44(){
    // No violations should occur in (actsas~;actsas |- I)
    //            rule':: actsas~;actsas/\-I
    // sqlExprSrc fSpec rule':: actsas
     $v=DB_doquer('SELECT DISTINCT isect0.`actsas`, isect0.`actsas1`
                     FROM 
                        ( SELECT DISTINCT F0.`actsas`, F1.`actsas` AS `actsas1`
                            FROM `party` AS F0, `party` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`actsas` <> isect0.`actsas1` AND isect0.`actsas` IS NOT NULL AND isect0.`actsas1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Role '.$v[0][0].',Role '.$v[0][1].')
reden: \"Artificial explanation: actsas~;actsas |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule45(){
    // No violations should occur in (I |- actsas;actsas~)
    //            rule':: I/\-(actsas;actsas~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `party` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `party` AS F0, `party` AS F1
                                       WHERE F0.`actsas`=F1.`actsas`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Party '.$v[0][0].',Party '.$v[0][1].')
reden: \"Artificial explanation: I |- actsas;actsas~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule46(){
    // No violations should occur in (scheduled~;scheduled |- I)
    //            rule':: scheduled~;scheduled/\-I
    // sqlExprSrc fSpec rule':: scheduled
     $v=DB_doquer('SELECT DISTINCT isect0.`scheduled`, isect0.`scheduled1`
                     FROM 
                        ( SELECT DISTINCT F0.`scheduled`, F1.`scheduled` AS `scheduled1`
                            FROM `session` AS F0, `session` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`scheduled` <> isect0.`scheduled1` AND isect0.`scheduled` IS NOT NULL AND isect0.`scheduled1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Date '.$v[0][0].',Date '.$v[0][1].')
reden: \"Artificial explanation: scheduled~;scheduled |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule47(){
    // No violations should occur in (I |- scheduled;scheduled~)
    //            rule':: I/\-(scheduled;scheduled~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `session` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `session` AS F0, `session` AS F1
                                       WHERE F0.`scheduled`=F1.`scheduled`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Session '.$v[0][0].',Session '.$v[0][1].')
reden: \"Artificial explanation: I |- scheduled;scheduled~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule48(){
    // No violations should occur in (occured~;occured |- I)
    //            rule':: occured~;occured/\-I
    // sqlExprSrc fSpec rule':: occured
     $v=DB_doquer('SELECT DISTINCT isect0.`occured`, isect0.`occured1`
                     FROM 
                        ( SELECT DISTINCT F0.`occured`, F1.`occured` AS `occured1`
                            FROM `session` AS F0, `session` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`occured` <> isect0.`occured1` AND isect0.`occured` IS NOT NULL AND isect0.`occured1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Date '.$v[0][0].',Date '.$v[0][1].')
reden: \"Artificial explanation: occured~;occured |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule49(){
    // No violations should occur in (administrativeAuthorityAwb87 = administrativeAuthorityAwb87~)
    //            rule':: (-administrativeAuthorityAwb87\/-administrativeAuthorityAwb87~)/\(administrativeAuthorityAwb87~\/administrativeAuthorityAwb87)
    // sqlExprSrc fSpec rule':: party
     $v=DB_doquer('SELECT DISTINCT isect0.`party`, isect0.`party1`
                     FROM 
                        ( 
                          (SELECT DISTINCT cfst.`i` AS `party`, csnd.`i1` AS `party1`
                                FROM `party` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `party`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `administrativeauthorityawb87` AS cp
                                           WHERE cfst.`i`=cp.`party` AND csnd.`i1`=cp.`party1`)
                          ) UNION (SELECT DISTINCT cfst.`i` AS `party`, csnd.`i1` AS `party1`
                                FROM `party` AS cfst, 
                                   ( SELECT DISTINCT `i` AS `i1`
                                       FROM `party`
                                   ) AS csnd
                               WHERE NOT EXISTS (SELECT *
                                            FROM `administrativeauthorityawb87` AS cp
                                           WHERE cfst.`i`=cp.`party1` AND csnd.`i1`=cp.`party`)
                          
                          )
                        ) AS isect0, 
                        ( 
                          (SELECT DISTINCT party1, party
                                FROM `administrativeauthorityawb87`
                          ) UNION (SELECT DISTINCT party AS `party1`, party1 AS `party`
                                FROM `administrativeauthorityawb87`
                          
                          )
                        ) AS isect1
                    WHERE (isect0.`party` = isect1.`party1` AND isect0.`party1` = isect1.`party`) AND isect0.`party` IS NOT NULL AND isect0.`party1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Party '.$v[0][0].',Party '.$v[0][1].')
reden: \"Artificial explanation: administrativeAuthorityAwb87 = administrativeAuthorityAwb87~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule50(){
    // No violations should occur in (administrativeAuthorityAwb87~/\administrativeAuthorityAwb87 |- I)
    //            rule':: administrativeAuthorityAwb87~/\administrativeAuthorityAwb87/\-I
    // sqlExprSrc fSpec rule':: party1
     $v=DB_doquer('SELECT DISTINCT isect0.`party1`, isect0.`party`
                     FROM `administrativeauthorityawb87` AS isect0, `administrativeauthorityawb87` AS isect1
                    WHERE (isect0.`party1` = isect1.`party` AND isect0.`party` = isect1.`party1`) AND isect0.`party1` <> isect0.`party` AND isect0.`party1` IS NOT NULL AND isect0.`party` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Party '.$v[0][0].',Party '.$v[0][1].')
reden: \"Artificial explanation: administrativeAuthorityAwb87~/\\administrativeAuthorityAwb87 |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule51(){
    // No violations should occur in (seatedIn~;seatedIn |- I)
    //            rule':: seatedIn~;seatedIn/\-I
    // sqlExprSrc fSpec rule':: seatedin
     $v=DB_doquer('SELECT DISTINCT isect0.`seatedin`, isect0.`seatedin1`
                     FROM 
                        ( SELECT DISTINCT F0.`seatedin`, F1.`seatedin` AS `seatedin1`
                            FROM `court` AS F0, `court` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`seatedin` <> isect0.`seatedin1` AND isect0.`seatedin` IS NOT NULL AND isect0.`seatedin1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (City '.$v[0][0].',City '.$v[0][1].')
reden: \"Artificial explanation: seatedIn~;seatedIn |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule52(){
    // No violations should occur in (I |- seatedIn;seatedIn~)
    //            rule':: I/\-(seatedIn;seatedIn~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `court` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `court` AS F0, `court` AS F1
                                       WHERE F0.`seatedin`=F1.`seatedin`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Court '.$v[0][0].',Court '.$v[0][1].')
reden: \"Artificial explanation: I |- seatedIn;seatedIn~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule53(){
    // No violations should occur in (seatedIn~;seatedIn |- I)
    //            rule':: seatedIn~;seatedIn/\-I
    // sqlExprSrc fSpec rule':: seatedin
     $v=DB_doquer('SELECT DISTINCT isect0.`seatedin`, isect0.`seatedin1`
                     FROM 
                        ( SELECT DISTINCT F0.`seatedin`, F1.`seatedin` AS `seatedin1`
                            FROM `courtofappeal` AS F0, `courtofappeal` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`seatedin` <> isect0.`seatedin1` AND isect0.`seatedin` IS NOT NULL AND isect0.`seatedin1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (City '.$v[0][0].',City '.$v[0][1].')
reden: \"Artificial explanation: seatedIn~;seatedIn |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule54(){
    // No violations should occur in (I |- seatedIn;seatedIn~)
    //            rule':: I/\-(seatedIn;seatedIn~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `courtofappeal` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `courtofappeal` AS F0, `courtofappeal` AS F1
                                       WHERE F0.`seatedin`=F1.`seatedin`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (CourtOfAppeal '.$v[0][0].',CourtOfAppeal '.$v[0][1].')
reden: \"Artificial explanation: I |- seatedIn;seatedIn~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule55(){
    // No violations should occur in (location~;location |- I)
    //            rule':: location~;location/\-I
    // sqlExprSrc fSpec rule':: location
     $v=DB_doquer('SELECT DISTINCT isect0.`location`, isect0.`location1`
                     FROM 
                        ( SELECT DISTINCT F0.`location`, F1.`location` AS `location1`
                            FROM `session` AS F0, `session` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`location` <> isect0.`location1` AND isect0.`location` IS NOT NULL AND isect0.`location1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Court '.$v[0][0].',Court '.$v[0][1].')
reden: \"Artificial explanation: location~;location |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule56(){
    // No violations should occur in (I |- location;location~)
    //            rule':: I/\-(location;location~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `session` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `session` AS F0, `session` AS F1
                                       WHERE F0.`location`=F1.`location`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Session '.$v[0][0].',Session '.$v[0][1].')
reden: \"Artificial explanation: I |- location;location~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule57(){
    // No violations should occur in (district~;district |- I)
    //            rule':: district~;district/\-I
    // sqlExprSrc fSpec rule':: district
     $v=DB_doquer('SELECT DISTINCT isect0.`district`, isect0.`district1`
                     FROM 
                        ( SELECT DISTINCT F0.`district`, F1.`district` AS `district1`
                            FROM `court` AS F0, `court` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`district` <> isect0.`district1` AND isect0.`district` IS NOT NULL AND isect0.`district1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (CourtOfAppeal '.$v[0][0].',CourtOfAppeal '.$v[0][1].')
reden: \"Artificial explanation: district~;district |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule58(){
    // No violations should occur in (I |- district;district~)
    //            rule':: I/\-(district;district~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `court` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `court` AS F0, `court` AS F1
                                       WHERE F0.`district`=F1.`district`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Court '.$v[0][0].',Court '.$v[0][1].')
reden: \"Artificial explanation: I |- district;district~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule59(){
    // No violations should occur in (localOffices~;localOffices |- I)
    //            rule':: localOffices~;localOffices/\-I
    // sqlExprSrc fSpec rule':: localoffices
     $v=DB_doquer('SELECT DISTINCT isect0.`localoffices`, isect0.`localoffices1`
                     FROM 
                        ( SELECT DISTINCT F0.`localoffices`, F1.`localoffices` AS `localoffices1`
                            FROM `city` AS F0, `city` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`localoffices` <> isect0.`localoffices1` AND isect0.`localoffices` IS NOT NULL AND isect0.`localoffices1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Court '.$v[0][0].',Court '.$v[0][1].')
reden: \"Artificial explanation: localOffices~;localOffices |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule60(){
    // No violations should occur in (jurisdiction~;jurisdiction |- I)
    //            rule':: jurisdiction~;jurisdiction/\-I
    // sqlExprSrc fSpec rule':: jurisdiction
     $v=DB_doquer('SELECT DISTINCT isect0.`jurisdiction`, isect0.`jurisdiction1`
                     FROM 
                        ( SELECT DISTINCT F0.`jurisdiction`, F1.`jurisdiction` AS `jurisdiction1`
                            FROM `city` AS F0, `city` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`jurisdiction` <> isect0.`jurisdiction1` AND isect0.`jurisdiction` IS NOT NULL AND isect0.`jurisdiction1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (Court '.$v[0][0].',Court '.$v[0][1].')
reden: \"Artificial explanation: jurisdiction~;jurisdiction |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule61(){
    // No violations should occur in (I |- jurisdiction;jurisdiction~)
    //            rule':: I/\-(jurisdiction;jurisdiction~)
    // sqlExprSrc fSpec rule':: i
     $v=DB_doquer('SELECT DISTINCT isect0.`i`, isect0.`i` AS `i1`
                     FROM `city` AS isect0
                    WHERE NOT EXISTS (SELECT *
                                 FROM 
                                    ( SELECT DISTINCT F0.`i`, F1.`i` AS `i1`
                                        FROM `city` AS F0, `city` AS F1
                                       WHERE F0.`jurisdiction`=F1.`jurisdiction`
                                    ) AS cp
                                WHERE isect0.`i`=cp.`i` AND isect0.`i`=cp.`i1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (City '.$v[0][0].',City '.$v[0][1].')
reden: \"Artificial explanation: I |- jurisdiction;jurisdiction~\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule62(){
    // No violations should occur in (sent~;sent |- I)
    //            rule':: sent~;sent/\-I
    // sqlExprSrc fSpec rule':: sent
     $v=DB_doquer('SELECT DISTINCT isect0.`sent`, isect0.`sent1`
                     FROM 
                        ( SELECT DISTINCT F0.`sent`, F1.`sent` AS `sent1`
                            FROM `document` AS F0, `document` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`sent` <> isect0.`sent1` AND isect0.`sent` IS NOT NULL AND isect0.`sent1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (TimeStamp '.$v[0][0].',TimeStamp '.$v[0][1].')
reden: \"Artificial explanation: sent~;sent |- I\"<BR>',3);
      return false;
    }return true;
  }
  
  function checkRule63(){
    // No violations should occur in (received~;received |- I)
    //            rule':: received~;received/\-I
    // sqlExprSrc fSpec rule':: received
     $v=DB_doquer('SELECT DISTINCT isect0.`received`, isect0.`received1`
                     FROM 
                        ( SELECT DISTINCT F0.`received`, F1.`received` AS `received1`
                            FROM `document` AS F0, `document` AS F1
                           WHERE F0.`i`=F1.`i`
                        ) AS isect0
                    WHERE isect0.`received` <> isect0.`received1` AND isect0.`received` IS NOT NULL AND isect0.`received1` IS NOT NULL');
     if(count($v)) {
      DB_debug('Overtreding (TimeStamp '.$v[0][0].',TimeStamp '.$v[0][1].')
reden: \"Artificial explanation: received~;received |- I\"<BR>',3);
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
  }
?>