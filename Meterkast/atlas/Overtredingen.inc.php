<?php // generated with ADL vs. 1.1-640
  
  /********* on line 189, file "src/atlas/atlas.adl"
    SERVICE Overtredingen : I[S]
   = [ de regel {"DISPLAY=UserRule.display"} : V;(user;s;user~/\script;s;script~);violates
        = [ wordt overtreden door : violates~;display
          ]
     , de cardinaliteitseigenschap : V;(user;s;user~/\script;s;script~);violates
        = [ eigenschap : property;display
          , van relatie {"DISPLAY=Relation.display"} : on
          , wordt overtreden door : violates~;display
          ]
     , de homogene eigenschap : V;(user;s;user~/\script;s;script~);violates
        = [ eigenschap : property;display
          , van relatie {"DISPLAY=Relation.display"} : on
          , wordt overtreden door : violates~;display
          ]
     ]
   *********/
  
  class Overtredingen {
    private $_deregel;
    private $_decardinaliteitseigenschap;
    private $_dehomogeneeigenschap;
    function Overtredingen($_deregel=null, $_decardinaliteitseigenschap=null, $_dehomogeneeigenschap=null){
      $this->_deregel=$_deregel;
      $this->_decardinaliteitseigenschap=$_decardinaliteitseigenschap;
      $this->_dehomogeneeigenschap=$_dehomogeneeigenschap;
      if(!isset($_deregel)){
        // get a Overtredingen based on its identifier
        // fill the attributes
        $me=array();
        $me['de regel']=(DB_doquer("SELECT DISTINCT `f1`.`UserRule` AS `id`
                                      FROM  ( SELECT DISTINCT fst.`UserRule`
                                                FROM 
                                                   ( SELECT DISTINCT F0.`I`, F1.`UserRule`
                                                       FROM 
                                                          ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `violation` AS TODO WHERE TODO.`user`='".$GLOBALS['ctxenv']['User']."'AND TODO.`script`='".$GLOBALS['ctxenv']['Script']."'
                                                          ) AS F0, `violates2` AS F1
                                                      WHERE F0.`I1`=F1.`Violation`
                                                   ) AS fst
                                               WHERE fst.`UserRule` IS NOT NULL
                                            ) AS f1"));
        $me['de cardinaliteitseigenschap']=(DB_doquer("SELECT DISTINCT `f1`.`MultiplicityRule` AS `id`
                                                         FROM  ( SELECT DISTINCT fst.`MultiplicityRule`
                                                                   FROM 
                                                                      ( SELECT DISTINCT F0.`I`, F1.`MultiplicityRule`
                                                                          FROM 
                                                                             ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `violation` AS TODO WHERE TODO.`user`='".$GLOBALS['ctxenv']['User']."'AND TODO.`script`='".$GLOBALS['ctxenv']['Script']."'
                                                                             ) AS F0, `violates3` AS F1
                                                                         WHERE F0.`I1`=F1.`Violation`
                                                                      ) AS fst
                                                                  WHERE fst.`MultiplicityRule` IS NOT NULL
                                                               ) AS f1"));
        $me['de homogene eigenschap']=(DB_doquer("SELECT DISTINCT `f1`.`HomogeneousRule` AS `id`
                                                    FROM  ( SELECT DISTINCT fst.`HomogeneousRule`
                                                              FROM 
                                                                 ( SELECT DISTINCT F0.`I`, F1.`HomogeneousRule`
                                                                     FROM 
                                                                        ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `violation` AS TODO WHERE TODO.`user`='".$GLOBALS['ctxenv']['User']."'AND TODO.`script`='".$GLOBALS['ctxenv']['Script']."'
                                                                        ) AS F0, `violates4` AS F1
                                                                    WHERE F0.`I1`=F1.`Violation`
                                                                 ) AS fst
                                                             WHERE fst.`HomogeneousRule` IS NOT NULL
                                                          ) AS f1"));
        foreach($me['de regel'] as $i0=>&$v0){
          $v0['wordt overtreden door']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `wordt overtreden door`
                                                             FROM `UserRule`
                                                             JOIN  ( SELECT DISTINCT F0.`UserRule`, F1.`display`
                                                                            FROM `violates2` AS F0, `Violation` AS F1
                                                                           WHERE F0.`Violation`=F1.`I`
                                                                        ) AS f1
                                                               ON `f1`.`UserRule`='".addslashes($v0['id'])."'
                                                            WHERE `UserRule`.`I`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        foreach($me['de cardinaliteitseigenschap'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , `f2`.`display` AS `eigenschap`
                                       , `f3`.`on` AS `van relatie`
                                    FROM `MultiplicityRule`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`display`
                                                   FROM `MultiplicityRule` AS F0, `Prop` AS F1
                                                  WHERE F0.`property`=F1.`I`
                                               ) AS f2
                                      ON `f2`.`I`='".addslashes($v0['id'])."'
                                    LEFT JOIN `MultiplicityRule` AS f3 ON `f3`.`I`='".addslashes($v0['id'])."'
                                   WHERE `MultiplicityRule`.`I`='".addslashes($v0['id'])."'"));
          $v0['wordt overtreden door']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `wordt overtreden door`
                                                             FROM `MultiplicityRule`
                                                             JOIN  ( SELECT DISTINCT F0.`MultiplicityRule`, F1.`display`
                                                                            FROM `violates3` AS F0, `Violation` AS F1
                                                                           WHERE F0.`Violation`=F1.`I`
                                                                        ) AS f1
                                                               ON `f1`.`MultiplicityRule`='".addslashes($v0['id'])."'
                                                            WHERE `MultiplicityRule`.`I`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        foreach($me['de homogene eigenschap'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , `f2`.`display` AS `eigenschap`
                                       , `f3`.`on` AS `van relatie`
                                    FROM `HomogeneousRule`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`display`
                                                   FROM `HomogeneousRule` AS F0, `Prop` AS F1
                                                  WHERE F0.`property`=F1.`I`
                                               ) AS f2
                                      ON `f2`.`I`='".addslashes($v0['id'])."'
                                    LEFT JOIN `HomogeneousRule` AS f3 ON `f3`.`I`='".addslashes($v0['id'])."'
                                   WHERE `HomogeneousRule`.`I`='".addslashes($v0['id'])."'"));
          $v0['wordt overtreden door']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `wordt overtreden door`
                                                             FROM `HomogeneousRule`
                                                             JOIN  ( SELECT DISTINCT F0.`HomogeneousRule`, F1.`display`
                                                                            FROM `violates4` AS F0, `Violation` AS F1
                                                                           WHERE F0.`Violation`=F1.`I`
                                                                        ) AS f1
                                                               ON `f1`.`HomogeneousRule`='".addslashes($v0['id'])."'
                                                            WHERE `HomogeneousRule`.`I`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_deregel($me['de regel']);
        $this->set_decardinaliteitseigenschap($me['de cardinaliteitseigenschap']);
        $this->set_dehomogeneeigenschap($me['de homogene eigenschap']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $me=array("id"=>1, "de regel" => $this->_deregel, "de cardinaliteitseigenschap" => $this->_decardinaliteitseigenschap, "de homogene eigenschap" => $this->_dehomogeneeigenschap);
      // no code for de regel,I in UserRule
      foreach($me['de homogene eigenschap'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `HomogeneousRule` SET `on`='".addslashes($v0['van relatie'])."' WHERE `I`='".addslashes($v0['id'])."'", 5);
      }
      foreach($me['de cardinaliteitseigenschap'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `MultiplicityRule` SET `on`='".addslashes($v0['van relatie'])."' WHERE `I`='".addslashes($v0['id'])."'", 5);
      }
      // no code for van relatie,I in Relation
      // no code for van relatie,I in Relation
      foreach($me['de regel'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['de cardinaliteitseigenschap'] as $i0=>$v0){
        DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v0['eigenschap'])."'",5);
      }
      foreach($me['de cardinaliteitseigenschap'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['de homogene eigenschap'] as $i0=>$v0){
        DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v0['eigenschap'])."'",5);
      }
      foreach($me['de homogene eigenschap'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['de regel'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['de cardinaliteitseigenschap'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($v0['eigenschap'])."')", 5);
      }
      foreach($me['de cardinaliteitseigenschap'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['de homogene eigenschap'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($v0['eigenschap'])."')", 5);
      }
      foreach($me['de homogene eigenschap'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_deregel($val){
      $this->_deregel=$val;
    }
    function get_deregel(){
      if(!isset($this->_deregel)) return array();
      return $this->_deregel;
    }
    function set_decardinaliteitseigenschap($val){
      $this->_decardinaliteitseigenschap=$val;
    }
    function get_decardinaliteitseigenschap(){
      if(!isset($this->_decardinaliteitseigenschap)) return array();
      return $this->_decardinaliteitseigenschap;
    }
    function set_dehomogeneeigenschap($val){
      $this->_dehomogeneeigenschap=$val;
    }
    function get_dehomogeneeigenschap(){
      if(!isset($this->_dehomogeneeigenschap)) return array();
      return $this->_dehomogeneeigenschap;
    }
  }

?>