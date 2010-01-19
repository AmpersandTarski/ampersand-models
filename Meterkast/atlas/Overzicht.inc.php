<?php // generated with ADL vs. 0.8.10-547
  
  /********* on line 156, file "comp/PWO_gmi/281.adl"
    SERVICE Overzicht : I[S]
   = [ Patterns {"DISPLAY=Pattern.display"} : V;(user;s;user~/\script;s;script~)
        = [ violated_rules {"DISPLAY=UserRule.display"} : pattern~;violates~;violates
          , property_violations_on {"DISPLAY=Relation.display"} : pattern~;on~;violates~;violates;on\/pattern~;on~;violates~;violates;on
          ]
     , Conceptual diagram {PICTURE} : V;(user;s;user~/\script;s;script~);picture;display
     ]
   *********/
  
  class Overzicht {
    private $_Patterns;
    private $_Conceptualdiagram;
    function Overzicht($_Patterns=null, $_Conceptualdiagram=null){
      $this->_Patterns=$_Patterns;
      $this->_Conceptualdiagram=$_Conceptualdiagram;
      if(!isset($_Patterns)){
        // get a Overzicht based on its identifier
        // fill the attributes
        $me=array();
        $me['Patterns']=(DB_doquer("SELECT DISTINCT `f1`.`i` AS `id`
                                      FROM  ( SELECT DISTINCT fst.`i`
                                                FROM 
                                                   ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `Pattern` AS TODO WHERE TODO.`User`='".$GLOBALS['ctxenv']['User']."'AND TODO.`Script`='".$GLOBALS['ctxenv']['Script']."'
                                                   ) AS fst
                                               WHERE fst.`i` IS NOT NULL
                                            ) AS f1"));
        $me['Conceptual diagram']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `Conceptual diagram`
                                                        FROM  ( SELECT DISTINCT fst.`display`
                                                                  FROM 
                                                                     ( SELECT DISTINCT F0.`i`, F2.`display`
                                                                         FROM 
                                                                            ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `Service` AS TODO WHERE TODO.`User`='".$GLOBALS['ctxenv']['User']."'AND TODO.`Script`='".$GLOBALS['ctxenv']['Script']."'
                                                                            ) AS F0, `service` AS F1, `picture` AS F2
                                                                        WHERE F0.`i1`=F1.`i`
                                                                          AND F1.`picture`=F2.`i`
                                                                     ) AS fst
                                                                 WHERE fst.`display` IS NOT NULL
                                                              ) AS f1"));
        foreach($me['Patterns'] as $i0=>&$v0){
          $v0['violated_rules']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`UserRule` AS `violated_rules`
                                                      FROM `pattern`
                                                      JOIN  ( SELECT DISTINCT F0.`pattern`, F2.`UserRule`
                                                                     FROM `userrule` AS F0, `violatesviolation` AS F1, `violatesviolation` AS F2
                                                                    WHERE F0.`i`=F1.`UserRule`
                                                                      AND F1.`violation`=F2.`violation`
                                                                 ) AS f1
                                                        ON `f1`.`pattern`='".addslashes($v0['id'])."'
                                                     WHERE `pattern`.`i`='".addslashes($v0['id'])."'"));
          $v0['property_violations_on']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`on` AS `property_violations_on`
                                                              FROM `pattern`
                                                              JOIN  ( 
                                                                           (SELECT DISTINCT F0.`pattern`, F4.`on`
                                                                                 FROM `relation` AS F0, `multiplicityrule` AS F1, `violatesmultiplicityrule` AS F2, `violatesmultiplicityrule` AS F3, `multiplicityrule` AS F4
                                                                                WHERE F0.`i`=F1.`on`
                                                                                  AND F1.`i`=F2.`MultiplicityRule`
                                                                                  AND F2.`violation`=F3.`violation`
                                                                                  AND F3.`MultiplicityRule`=F4.`i`
                                                                           ) UNION (SELECT DISTINCT F0.`pattern`, F4.`on`
                                                                                 FROM `relation` AS F0, `homogeneousrule` AS F1, `violateshomogeneousrule` AS F2, `violateshomogeneousrule` AS F3, `homogeneousrule` AS F4
                                                                                WHERE F0.`i`=F1.`on`
                                                                                  AND F1.`i`=F2.`HomogeneousRule`
                                                                                  AND F2.`violation`=F3.`violation`
                                                                                  AND F3.`HomogeneousRule`=F4.`i`
                                                                           
                                                                           )
                                                                         ) AS f1
                                                                ON `f1`.`pattern`='".addslashes($v0['id'])."'
                                                             WHERE `pattern`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Patterns($me['Patterns']);
        $this->set_Conceptualdiagram($me['Conceptual diagram']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $me=array("id"=>1, "Patterns" => $this->_Patterns, "Conceptual diagram" => $this->_Conceptualdiagram);
      // no code for violated_rules,i in userrule
      // no code for property_violations_on,i in relation
      // no code for Patterns,i in pattern
      foreach($me['Conceptual diagram'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['Conceptual diagram'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Patterns($val){
      $this->_Patterns=$val;
    }
    function get_Patterns(){
      if(!isset($this->_Patterns)) return array();
      return $this->_Patterns;
    }
    function set_Conceptualdiagram($val){
      $this->_Conceptualdiagram=$val;
    }
    function get_Conceptualdiagram(){
      if(!isset($this->_Conceptualdiagram)) return array();
      return $this->_Conceptualdiagram;
    }
  }

?>