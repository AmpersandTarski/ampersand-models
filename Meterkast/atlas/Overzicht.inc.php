<?php // generated with ADL vs. 1.1-646
  
  /********* on line 182, file "src/atlas/atlas.adl"
    SERVICE Overzicht : I[S]
   = [ Patternlijst {"DISPLAY=Pattern.display"} : V;(user;s;user~/\script;s;script~)
        = [ regels die overtreden worden {"DISPLAY=UserRule.display"} : pattern~;violates~;violates
          , relaties waarvan een eigenschap overtreden wordt {"DISPLAY=Relation.display"} : pattern~;on~;violates~;violates;on\/pattern~;on~;violates~;violates;on
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
        $me['Patternlijst']=(DB_doquer("SELECT DISTINCT `f1`.`I` AS `id`
                                          FROM  ( SELECT DISTINCT fst.`I`
                                                    FROM 
                                                       ( SELECT DISTINCT TODO.`I`, TODO.`I` AS i1 FROM `Pattern` AS TODO WHERE TODO.`User`='".$GLOBALS['ctxenv']['User']."'AND TODO.`Script`='".$GLOBALS['ctxenv']['Script']."'
                                                       ) AS fst
                                                   WHERE fst.`I` IS NOT NULL
                                                ) AS f1"));
        foreach($me['Patternlijst'] as $i0=>&$v0){
          $v0['regels die overtreden worden']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`UserRule` AS `regels die overtreden worden`
                                                                    FROM `Pattern`
                                                                    JOIN  ( SELECT DISTINCT F0.`pattern`, F2.`UserRule`
                                                                                   FROM `UserRule` AS F0, `violates2` AS F1, `violates2` AS F2
                                                                                  WHERE F0.`I`=F1.`UserRule`
                                                                                    AND F1.`Violation`=F2.`Violation`
                                                                               ) AS f1
                                                                      ON `f1`.`pattern`='".addslashes($v0['id'])."'
                                                                   WHERE `Pattern`.`I`='".addslashes($v0['id'])."'"));
          $v0['relaties waarvan een eigenschap overtreden wordt']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`on` AS `relaties waarvan een eigenschap overtreden wordt`
                                                                                        FROM `Pattern`
                                                                                        JOIN  ( 
                                                                                                     (SELECT DISTINCT F0.`pattern`, F4.`on`
                                                                                                           FROM `Relation` AS F0, `MultiplicityRule` AS F1, `violates3` AS F2, `violates3` AS F3, `MultiplicityRule` AS F4
                                                                                                          WHERE F0.`I`=F1.`on`
                                                                                                            AND F1.`I`=F2.`MultiplicityRule`
                                                                                                            AND F2.`Violation`=F3.`Violation`
                                                                                                            AND F3.`MultiplicityRule`=F4.`I`
                                                                                                     ) UNION (SELECT DISTINCT F0.`pattern`, F4.`on`
                                                                                                           FROM `Relation` AS F0, `HomogeneousRule` AS F1, `violates4` AS F2, `violates4` AS F3, `HomogeneousRule` AS F4
                                                                                                          WHERE F0.`I`=F1.`on`
                                                                                                            AND F1.`I`=F2.`HomogeneousRule`
                                                                                                            AND F2.`Violation`=F3.`Violation`
                                                                                                            AND F3.`HomogeneousRule`=F4.`I`
                                                                                                     
                                                                                                     )
                                                                                                   ) AS f1
                                                                                          ON `f1`.`pattern`='".addslashes($v0['id'])."'
                                                                                       WHERE `Pattern`.`I`='".addslashes($v0['id'])."'"));
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
      // no code for regels die overtreden worden,I in UserRule
      // no code for relaties waarvan een eigenschap overtreden wordt,I in Relation
      // no code for Patternlijst,I in Pattern
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