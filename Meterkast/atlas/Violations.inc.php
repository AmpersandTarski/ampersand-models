<?php // generated with ADL vs. 0.8.10-557
  
  /********* on line 185, file "comp/PWO_gmi/425.adl"
    SERVICE Violations : I[S]
   = [ violated_rules {"DISPLAY=UserRule.display"} : V;(user;s;user~/\script;s;script~);violates
        = [ is violated by : violates~;display
          ]
     , property_violations_on {"DISPLAY=Relation.display"} : V;(user;s;user~/\script;s;script~);violates;on\/V;(user;s;user~/\script;s;script~);violates;on
        = [ is violated by : on~;violates~;display
          ]
     ]
   *********/
  
  class Violations {
    private $_violatedrules;
    private $_propertyviolationson;
    function Violations($_violatedrules=null, $_propertyviolationson=null){
      $this->_violatedrules=$_violatedrules;
      $this->_propertyviolationson=$_propertyviolationson;
      if(!isset($_violatedrules)){
        // get a Violations based on its identifier
        // fill the attributes
        $me=array();
        $me['violated_rules']=(DB_doquer("SELECT DISTINCT `f1`.`UserRule` AS `id`
                                            FROM  ( SELECT DISTINCT fst.`UserRule`
                                                      FROM 
                                                         ( SELECT DISTINCT F0.`i`, F1.`UserRule`
                                                             FROM 
                                                                ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `Violation` AS TODO WHERE TODO.`User`='".$GLOBALS['ctxenv']['User']."'AND TODO.`Script`='".$GLOBALS['ctxenv']['Script']."'
                                                                ) AS F0, `violatesviolation` AS F1
                                                            WHERE F0.`i1`=F1.`violation`
                                                         ) AS fst
                                                     WHERE fst.`UserRule` IS NOT NULL
                                                  ) AS f1"));
        $me['property_violations_on']=(DB_doquer("SELECT DISTINCT `f1`.`on` AS `id`
                                                    FROM  ( 
                                                            (SELECT DISTINCT fst.`on`
                                                                  FROM 
                                                                     ( SELECT DISTINCT F0.`i`, F2.`on`
                                                                         FROM 
                                                                            ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `Violation` AS TODO WHERE TODO.`User`='".$GLOBALS['ctxenv']['User']."'AND TODO.`Script`='".$GLOBALS['ctxenv']['Script']."'
                                                                            ) AS F0, `violatesmultiplicityrule` AS F1, `multiplicityrule` AS F2
                                                                        WHERE F0.`i1`=F1.`violation`
                                                                          AND F1.`MultiplicityRule`=F2.`i`
                                                                     ) AS fst
                                                                 WHERE fst.`on` IS NOT NULL
                                                            ) UNION (SELECT DISTINCT fst.`on`
                                                                  FROM 
                                                                     ( SELECT DISTINCT F0.`i`, F2.`on`
                                                                         FROM 
                                                                            ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `Violation` AS TODO WHERE TODO.`User`='".$GLOBALS['ctxenv']['User']."'AND TODO.`Script`='".$GLOBALS['ctxenv']['Script']."'
                                                                            ) AS F0, `violateshomogeneousrule` AS F1, `homogeneousrule` AS F2
                                                                        WHERE F0.`i1`=F1.`violation`
                                                                          AND F1.`HomogeneousRule`=F2.`i`
                                                                     ) AS fst
                                                                 WHERE fst.`on` IS NOT NULL
                                                            
                                                            )
                                                          ) AS f1"));
        foreach($me['violated_rules'] as $i0=>&$v0){
          $v0['is violated by']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `is violated by`
                                                      FROM `userrule`
                                                      JOIN  ( SELECT DISTINCT F0.`UserRule`, F1.`display`
                                                                     FROM `violatesviolation` AS F0, `violation` AS F1
                                                                    WHERE F0.`violation`=F1.`i`
                                                                 ) AS f1
                                                        ON `f1`.`UserRule`='".addslashes($v0['id'])."'
                                                     WHERE `userrule`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        foreach($me['property_violations_on'] as $i0=>&$v0){
          $v0['is violated by']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `is violated by`
                                                      FROM `relation`
                                                      JOIN  ( SELECT DISTINCT F0.`on`, F2.`display`
                                                                     FROM `multiplicityrule` AS F0, `violatesmultiplicityrule` AS F1, `violation` AS F2
                                                                    WHERE F0.`i`=F1.`MultiplicityRule`
                                                                      AND F1.`violation`=F2.`i`
                                                                 ) AS f1
                                                        ON `f1`.`on`='".addslashes($v0['id'])."'
                                                     WHERE `relation`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_violatedrules($me['violated_rules']);
        $this->set_propertyviolationson($me['property_violations_on']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $me=array("id"=>1, "violated_rules" => $this->_violatedrules, "property_violations_on" => $this->_propertyviolationson);
      // no code for violated_rules,i in userrule
      // no code for property_violations_on,i in relation
      foreach($me['violated_rules'] as $i0=>$v0){
        foreach($v0['is violated by'] as $i1=>$v1){
          DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['property_violations_on'] as $i0=>$v0){
        foreach($v0['is violated by'] as $i1=>$v1){
          DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['violated_rules'] as $i0=>$v0){
        foreach($v0['is violated by'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['property_violations_on'] as $i0=>$v0){
        foreach($v0['is violated by'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_violatedrules($val){
      $this->_violatedrules=$val;
    }
    function get_violatedrules(){
      if(!isset($this->_violatedrules)) return array();
      return $this->_violatedrules;
    }
    function set_propertyviolationson($val){
      $this->_propertyviolationson=$val;
    }
    function get_propertyviolationson(){
      if(!isset($this->_propertyviolationson)) return array();
      return $this->_propertyviolationson;
    }
  }

?>