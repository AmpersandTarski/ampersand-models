<?php // generated with ADL vs. 1.0-632
  
  /********* on line 188, file "src/atlas/atlas.adl"
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
        $me['de regel']=(DB_doquer("SELECT DISTINCT `f1`.`userrule` AS `id`
                                      FROM  ( SELECT DISTINCT fst.`userrule`
                                                FROM 
                                                   ( SELECT DISTINCT F0.`i`, F1.`userrule`
                                                       FROM 
                                                          ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `violation` AS TODO WHERE TODO.`user`='".$GLOBALS['ctxenv']['User']."'AND TODO.`script`='".$GLOBALS['ctxenv']['Script']."'
                                                          ) AS F0, `violatesviolation` AS F1
                                                      WHERE F0.`i1`=F1.`violation`
                                                   ) AS fst
                                               WHERE fst.`userrule` IS NOT NULL
                                            ) AS f1"));
        $me['de cardinaliteitseigenschap']=(DB_doquer("SELECT DISTINCT `f1`.`multiplicityrule` AS `id`
                                                         FROM  ( SELECT DISTINCT fst.`multiplicityrule`
                                                                   FROM 
                                                                      ( SELECT DISTINCT F0.`i`, F1.`multiplicityrule`
                                                                          FROM 
                                                                             ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `violation` AS TODO WHERE TODO.`user`='".$GLOBALS['ctxenv']['User']."'AND TODO.`script`='".$GLOBALS['ctxenv']['Script']."'
                                                                             ) AS F0, `violatesmultiplicityrule` AS F1
                                                                         WHERE F0.`i1`=F1.`violation`
                                                                      ) AS fst
                                                                  WHERE fst.`multiplicityrule` IS NOT NULL
                                                               ) AS f1"));
        $me['de homogene eigenschap']=(DB_doquer("SELECT DISTINCT `f1`.`homogeneousrule` AS `id`
                                                    FROM  ( SELECT DISTINCT fst.`homogeneousrule`
                                                              FROM 
                                                                 ( SELECT DISTINCT F0.`i`, F1.`homogeneousrule`
                                                                     FROM 
                                                                        ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `violation` AS TODO WHERE TODO.`user`='".$GLOBALS['ctxenv']['User']."'AND TODO.`script`='".$GLOBALS['ctxenv']['Script']."'
                                                                        ) AS F0, `violateshomogeneousrule` AS F1
                                                                    WHERE F0.`i1`=F1.`violation`
                                                                 ) AS fst
                                                             WHERE fst.`homogeneousrule` IS NOT NULL
                                                          ) AS f1"));
        foreach($me['de regel'] as $i0=>&$v0){
          $v0['wordt overtreden door']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `wordt overtreden door`
                                                             FROM `userrule`
                                                             JOIN  ( SELECT DISTINCT F0.`userrule`, F1.`display`
                                                                            FROM `violatesviolation` AS F0, `violation` AS F1
                                                                           WHERE F0.`violation`=F1.`i`
                                                                        ) AS f1
                                                               ON `f1`.`userrule`='".addslashes($v0['id'])."'
                                                            WHERE `userrule`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        foreach($me['de cardinaliteitseigenschap'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , `f2`.`display` AS `eigenschap`
                                       , `f3`.`on` AS `van relatie`
                                    FROM `multiplicityrule`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `multiplicityrule` AS F0, `prop` AS F1
                                                  WHERE F0.`property`=F1.`i`
                                               ) AS f2
                                      ON `f2`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `multiplicityrule` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                   WHERE `multiplicityrule`.`i`='".addslashes($v0['id'])."'"));
          $v0['wordt overtreden door']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `wordt overtreden door`
                                                             FROM `multiplicityrule`
                                                             JOIN  ( SELECT DISTINCT F0.`multiplicityrule`, F1.`display`
                                                                            FROM `violatesmultiplicityrule` AS F0, `violation` AS F1
                                                                           WHERE F0.`violation`=F1.`i`
                                                                        ) AS f1
                                                               ON `f1`.`multiplicityrule`='".addslashes($v0['id'])."'
                                                            WHERE `multiplicityrule`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        foreach($me['de homogene eigenschap'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , `f2`.`display` AS `eigenschap`
                                       , `f3`.`on` AS `van relatie`
                                    FROM `homogeneousrule`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `homogeneousrule` AS F0, `prop` AS F1
                                                  WHERE F0.`property`=F1.`i`
                                               ) AS f2
                                      ON `f2`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `homogeneousrule` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                   WHERE `homogeneousrule`.`i`='".addslashes($v0['id'])."'"));
          $v0['wordt overtreden door']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `wordt overtreden door`
                                                             FROM `homogeneousrule`
                                                             JOIN  ( SELECT DISTINCT F0.`homogeneousrule`, F1.`display`
                                                                            FROM `violateshomogeneousrule` AS F0, `violation` AS F1
                                                                           WHERE F0.`violation`=F1.`i`
                                                                        ) AS f1
                                                               ON `f1`.`homogeneousrule`='".addslashes($v0['id'])."'
                                                            WHERE `homogeneousrule`.`i`='".addslashes($v0['id'])."'"));
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
      // no code for de regel,i in userrule
      foreach($me['de cardinaliteitseigenschap'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `multiplicityrule` SET `on`='".addslashes($v0['van relatie'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
      }
      foreach($me['de homogene eigenschap'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `homogeneousrule` SET `on`='".addslashes($v0['van relatie'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
      }
      // no code for van relatie,i in relation
      // no code for van relatie,i in relation
      foreach($me['de regel'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['de cardinaliteitseigenschap'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['eigenschap'])."'",5);
      }
      foreach($me['de cardinaliteitseigenschap'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['de homogene eigenschap'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['eigenschap'])."'",5);
      }
      foreach($me['de homogene eigenschap'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['de regel'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['de cardinaliteitseigenschap'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['eigenschap'])."')", 5);
      }
      foreach($me['de cardinaliteitseigenschap'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['de homogene eigenschap'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['eigenschap'])."')", 5);
      }
      foreach($me['de homogene eigenschap'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['de cardinaliteitseigenschap'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `relvar` (`i`) VALUES ('".addslashes($v0['van relatie'])."')", 5);
      }
      foreach($me['de homogene eigenschap'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `relvar` (`i`) VALUES ('".addslashes($v0['van relatie'])."')", 5);
      }
      foreach($me['de cardinaliteitseigenschap'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `contains` (`i`) VALUES ('".addslashes($v0['van relatie'])."')", 5);
      }
      foreach($me['de homogene eigenschap'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `contains` (`i`) VALUES ('".addslashes($v0['van relatie'])."')", 5);
      }
      foreach($me['de regel'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `morphisms` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
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