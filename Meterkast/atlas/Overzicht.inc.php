<?php // generated with ADL vs. 1.0-632
  
  /********* on line 181, file "src/atlas/atlas.adl"
    SERVICE Overzicht : I[S]
   = [ Patternlijst {"DISPLAY=Pattern.display"} : V;(user;s;user~/\script;s;script~)
        = [ Dit pattern heeft regelovertredingen op de regel(s) {"DISPLAY=UserRule.display"} : pattern~;violates~;violates
          , Dit pattern heeft overtredingen op eigenschap(pen) van relatie(s) {"DISPLAY=Relation.display"} : pattern~;on~;violates~;violates;on\/pattern~;on~;violates~;violates;on
          ]
     ]
   *********/
  
  class Overzicht {
    private $_Patternlijst;
    function Overzicht($_Patternlijst=null){
      $this->_Patternlijst=$_Patternlijst;
      if(!isset($_Patternlijst)){
        // get a Overzicht based on its identifier
        // fill the attributes
        $me=array();
        $me['Patternlijst']=(DB_doquer("SELECT DISTINCT `f1`.`i` AS `id`
                                          FROM  ( SELECT DISTINCT fst.`i`
                                                    FROM 
                                                       ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `pattern` AS TODO WHERE TODO.`user`='".$GLOBALS['ctxenv']['User']."'AND TODO.`script`='".$GLOBALS['ctxenv']['Script']."'
                                                       ) AS fst
                                                   WHERE fst.`i` IS NOT NULL
                                                ) AS f1"));
        foreach($me['Patternlijst'] as $i0=>&$v0){
          $v0['Dit pattern heeft regelovertredingen op de regel(s)']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`userrule` AS `Dit pattern heeft regelovertredingen op de regel(s)`
                                                                                           FROM `pattern`
                                                                                           JOIN  ( SELECT DISTINCT F0.`pattern`, F2.`userrule`
                                                                                                          FROM `userrule` AS F0, `violatesviolation` AS F1, `violatesviolation` AS F2
                                                                                                         WHERE F0.`i`=F1.`userrule`
                                                                                                           AND F1.`violation`=F2.`violation`
                                                                                                      ) AS f1
                                                                                             ON `f1`.`pattern`='".addslashes($v0['id'])."'
                                                                                          WHERE `pattern`.`i`='".addslashes($v0['id'])."'"));
          $v0['Dit pattern heeft overtredingen op eigenschap(pen) van relatie(s)']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`on` AS `Dit pattern heeft overtredingen op eigenschap(pen) van relatie(s)`
                                                                                                         FROM `pattern`
                                                                                                         JOIN  ( 
                                                                                                                      (SELECT DISTINCT F0.`pattern`, F4.`on`
                                                                                                                            FROM `relation` AS F0, `multiplicityrule` AS F1, `violatesmultiplicityrule` AS F2, `violatesmultiplicityrule` AS F3, `multiplicityrule` AS F4
                                                                                                                           WHERE F0.`i`=F1.`on`
                                                                                                                             AND F1.`i`=F2.`multiplicityrule`
                                                                                                                             AND F2.`violation`=F3.`violation`
                                                                                                                             AND F3.`multiplicityrule`=F4.`i`
                                                                                                                      ) UNION (SELECT DISTINCT F0.`pattern`, F4.`on`
                                                                                                                            FROM `relation` AS F0, `homogeneousrule` AS F1, `violateshomogeneousrule` AS F2, `violateshomogeneousrule` AS F3, `homogeneousrule` AS F4
                                                                                                                           WHERE F0.`i`=F1.`on`
                                                                                                                             AND F1.`i`=F2.`homogeneousrule`
                                                                                                                             AND F2.`violation`=F3.`violation`
                                                                                                                             AND F3.`homogeneousrule`=F4.`i`
                                                                                                                      
                                                                                                                      )
                                                                                                                    ) AS f1
                                                                                                           ON `f1`.`pattern`='".addslashes($v0['id'])."'
                                                                                                        WHERE `pattern`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Patternlijst($me['Patternlijst']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $me=array("id"=>1, "Patternlijst" => $this->_Patternlijst);
      // no code for Dit pattern heeft regelovertredingen op de regel(s),i in userrule
      // no code for Dit pattern heeft overtredingen op eigenschap(pen) van relatie(s),i in relation
      // no code for Patternlijst,i in pattern
      foreach($me['Patternlijst'] as $i0=>$v0){
        foreach($v0['Dit pattern heeft overtredingen op eigenschap(pen) van relatie(s)'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `relvar` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Patternlijst'] as $i0=>$v0){
        foreach($v0['Dit pattern heeft overtredingen op eigenschap(pen) van relatie(s)'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `contains` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Patternlijst'] as $i0=>$v0){
        foreach($v0['Dit pattern heeft regelovertredingen op de regel(s)'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `morphisms` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Patternlijst($val){
      $this->_Patternlijst=$val;
    }
    function get_Patternlijst(){
      if(!isset($this->_Patternlijst)) return array();
      return $this->_Patternlijst;
    }
  }

?>