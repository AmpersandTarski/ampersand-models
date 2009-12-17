<?php // generated with ADL vs. 0.8.10-490
  
  /********* on line 143, file "atlas.adl"
    SERVICE Rules : I[ONE]
   = [ Conceptual diagram {PICTURE} : V;(user;s;user~/\script;s;script~);display
     , User-defined rules : V;(user;s;user~/\script;s;script~)
        = [ rule : I;display
          , source : type;source;display
          , target : type;target;display
          , violations : violates~;display
          ]
     , Multiplicities : V;(user;s;user~/\script;s;script~)
        = [ property : property;display
          , source : type;source;display
          , on : on;display
          , rule : I;display
          , violations : violates~;display
          ]
     , Homogeneous properties : V;(user;s;user~/\script;s;script~)
        = [ property : property;display
          , on : on;display
          , rule : I;display
          , violations : violates~;display
          ]
     ]
   *********/
  
  class Rules {
    private $_Conceptualdiagram;
    private $_Userdefinedrules;
    private $_Multiplicities;
    private $_Homogeneousproperties;
    function Rules($_Conceptualdiagram=null, $_Userdefinedrules=null, $_Multiplicities=null, $_Homogeneousproperties=null){
      $this->_Conceptualdiagram=$_Conceptualdiagram;
      $this->_Userdefinedrules=$_Userdefinedrules;
      $this->_Multiplicities=$_Multiplicities;
      $this->_Homogeneousproperties=$_Homogeneousproperties;
      if(!isset($_Conceptualdiagram)){
        // get a Rules based on its identifier
        // fill the attributes
        $me=array();
        $me['Conceptual diagram']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `Conceptual diagram`
                                                        FROM  ( SELECT DISTINCT fst.`display`
                                                                  FROM 
                                                                     ( SELECT DISTINCT F0.`i`, F1.`display`
                                                                         FROM 
                                                                            ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `Picture` AS TODO WHERE TODO.`User`='".$GLOBALS['ctxenv']['User']."'AND TODO.`Script`='".$GLOBALS['ctxenv']['Script']."'
                                                                            ) AS F0, `picture` AS F1
                                                                        WHERE F0.`i1`=F1.`i`
                                                                     ) AS fst
                                                                 WHERE fst.`display` IS NOT NULL
                                                              ) AS f1"));
        $me['User-defined rules']=(DB_doquer("SELECT DISTINCT `f1`.`i` AS `id`
                                                FROM  ( SELECT DISTINCT fst.`i`
                                                          FROM 
                                                             ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `UserRule` AS TODO WHERE TODO.`User`='".$GLOBALS['ctxenv']['User']."'AND TODO.`Script`='".$GLOBALS['ctxenv']['Script']."'
                                                             ) AS fst
                                                         WHERE fst.`i` IS NOT NULL
                                                      ) AS f1"));
        $me['Multiplicities']=(DB_doquer("SELECT DISTINCT `f1`.`i` AS `id`
                                            FROM  ( SELECT DISTINCT fst.`i`
                                                      FROM 
                                                         ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `MultiplicityRule` AS TODO WHERE TODO.`User`='".$GLOBALS['ctxenv']['User']."'AND TODO.`Script`='".$GLOBALS['ctxenv']['Script']."'
                                                         ) AS fst
                                                     WHERE fst.`i` IS NOT NULL
                                                  ) AS f1"));
        $me['Homogeneous properties']=(DB_doquer("SELECT DISTINCT `f1`.`i` AS `id`
                                                    FROM  ( SELECT DISTINCT fst.`i`
                                                              FROM 
                                                                 ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `HomogeneousRule` AS TODO WHERE TODO.`User`='".$GLOBALS['ctxenv']['User']."'AND TODO.`Script`='".$GLOBALS['ctxenv']['Script']."'
                                                                 ) AS fst
                                                             WHERE fst.`i` IS NOT NULL
                                                          ) AS f1"));
        foreach($me['User-defined rules'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , `f2`.`display` AS `rule`
                                       , `f3`.`display` AS `source`
                                       , `f4`.`display` AS `target`
                                    FROM `userrule`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `userrule` AS F0, `userrule` AS F1
                                                  WHERE F0.`i`=F1.`i`
                                               ) AS f2
                                      ON `f2`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F2.`display`
                                                   FROM `userrule` AS F0, `type` AS F1, `concept` AS F2
                                                  WHERE F0.`type`=F1.`i`
                                                    AND F1.`source`=F2.`i`
                                               ) AS f3
                                      ON `f3`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F2.`display`
                                                   FROM `userrule` AS F0, `type` AS F1, `concept` AS F2
                                                  WHERE F0.`type`=F1.`i`
                                                    AND F1.`target`=F2.`i`
                                               ) AS f4
                                      ON `f4`.`i`='".addslashes($v0['id'])."'
                                   WHERE `userrule`.`i`='".addslashes($v0['id'])."'"));
          $v0['violations']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `violations`
                                                  FROM `userrule`
                                                  JOIN  ( SELECT DISTINCT F0.`UserRule`, F1.`display`
                                                                 FROM `violatesviolation` AS F0, `violation` AS F1
                                                                WHERE F0.`violation`=F1.`i`
                                                             ) AS f1
                                                    ON `f1`.`UserRule`='".addslashes($v0['id'])."'
                                                 WHERE `userrule`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        foreach($me['Multiplicities'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , `f2`.`display` AS `property`
                                       , `f3`.`display` AS `source`
                                       , `f4`.`display` AS `on`
                                       , `f5`.`display` AS `rule`
                                    FROM `multiplicityrule`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `multiplicityrule` AS F0, `prop` AS F1
                                                  WHERE F0.`property`=F1.`i`
                                               ) AS f2
                                      ON `f2`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F2.`display`
                                                   FROM `multiplicityrule` AS F0, `type` AS F1, `concept` AS F2
                                                  WHERE F0.`type`=F1.`i`
                                                    AND F1.`source`=F2.`i`
                                               ) AS f3
                                      ON `f3`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `multiplicityrule` AS F0, `relation` AS F1
                                                  WHERE F0.`on`=F1.`i`
                                               ) AS f4
                                      ON `f4`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `multiplicityrule` AS F0, `multiplicityrule` AS F1
                                                  WHERE F0.`i`=F1.`i`
                                               ) AS f5
                                      ON `f5`.`i`='".addslashes($v0['id'])."'
                                   WHERE `multiplicityrule`.`i`='".addslashes($v0['id'])."'"));
          $v0['violations']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `violations`
                                                  FROM `multiplicityrule`
                                                  JOIN  ( SELECT DISTINCT F0.`MultiplicityRule`, F1.`display`
                                                                 FROM `violatesmultiplicityrule` AS F0, `violation` AS F1
                                                                WHERE F0.`violation`=F1.`i`
                                                             ) AS f1
                                                    ON `f1`.`MultiplicityRule`='".addslashes($v0['id'])."'
                                                 WHERE `multiplicityrule`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        foreach($me['Homogeneous properties'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , `f2`.`display` AS `property`
                                       , `f3`.`display` AS `on`
                                       , `f4`.`display` AS `rule`
                                    FROM `homogeneousrule`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `homogeneousrule` AS F0, `prop` AS F1
                                                  WHERE F0.`property`=F1.`i`
                                               ) AS f2
                                      ON `f2`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `homogeneousrule` AS F0, `relation` AS F1
                                                  WHERE F0.`on`=F1.`i`
                                               ) AS f3
                                      ON `f3`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `homogeneousrule` AS F0, `homogeneousrule` AS F1
                                                  WHERE F0.`i`=F1.`i`
                                               ) AS f4
                                      ON `f4`.`i`='".addslashes($v0['id'])."'
                                   WHERE `homogeneousrule`.`i`='".addslashes($v0['id'])."'"));
          $v0['violations']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `violations`
                                                  FROM `homogeneousrule`
                                                  JOIN  ( SELECT DISTINCT F0.`HomogeneousRule`, F1.`display`
                                                                 FROM `violateshomogeneousrule` AS F0, `violation` AS F1
                                                                WHERE F0.`violation`=F1.`i`
                                                             ) AS f1
                                                    ON `f1`.`HomogeneousRule`='".addslashes($v0['id'])."'
                                                 WHERE `homogeneousrule`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Conceptualdiagram($me['Conceptual diagram']);
        $this->set_Userdefinedrules($me['User-defined rules']);
        $this->set_Multiplicities($me['Multiplicities']);
        $this->set_Homogeneousproperties($me['Homogeneous properties']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $me=array("id"=>1, "Conceptual diagram" => $this->_Conceptualdiagram, "User-defined rules" => $this->_Userdefinedrules, "Multiplicities" => $this->_Multiplicities, "Homogeneous properties" => $this->_Homogeneousproperties);
      foreach($me['Multiplicities'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `multiplicityrule` SET `display`='".addslashes($v0['rule'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
      }
      foreach($me['Homogeneous properties'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `homogeneousrule` SET `display`='".addslashes($v0['rule'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
      }
      foreach($me['User-defined rules'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `userrule` SET `display`='".addslashes($v0['rule'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
      }
      foreach($me['Conceptual diagram'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['User-defined rules'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['rule'])."'",5);
      }
      foreach($me['User-defined rules'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['source'])."'",5);
      }
      foreach($me['User-defined rules'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['target'])."'",5);
      }
      foreach($me['User-defined rules'] as $i0=>$v0){
        foreach($v0['violations'] as $i1=>$v1){
          DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Multiplicities'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['property'])."'",5);
      }
      foreach($me['Multiplicities'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['source'])."'",5);
      }
      foreach($me['Multiplicities'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['on'])."'",5);
      }
      foreach($me['Multiplicities'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['rule'])."'",5);
      }
      foreach($me['Multiplicities'] as $i0=>$v0){
        foreach($v0['violations'] as $i1=>$v1){
          DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Homogeneous properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['property'])."'",5);
      }
      foreach($me['Homogeneous properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['on'])."'",5);
      }
      foreach($me['Homogeneous properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['rule'])."'",5);
      }
      foreach($me['Homogeneous properties'] as $i0=>$v0){
        foreach($v0['violations'] as $i1=>$v1){
          DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Conceptual diagram'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['User-defined rules'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['rule'])."')", 5);
      }
      foreach($me['User-defined rules'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['source'])."')", 5);
      }
      foreach($me['User-defined rules'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['target'])."')", 5);
      }
      foreach($me['User-defined rules'] as $i0=>$v0){
        foreach($v0['violations'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Multiplicities'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['property'])."')", 5);
      }
      foreach($me['Multiplicities'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['source'])."')", 5);
      }
      foreach($me['Multiplicities'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['on'])."')", 5);
      }
      foreach($me['Multiplicities'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['rule'])."')", 5);
      }
      foreach($me['Multiplicities'] as $i0=>$v0){
        foreach($v0['violations'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Homogeneous properties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['property'])."')", 5);
      }
      foreach($me['Homogeneous properties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['on'])."')", 5);
      }
      foreach($me['Homogeneous properties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['rule'])."')", 5);
      }
      foreach($me['Homogeneous properties'] as $i0=>$v0){
        foreach($v0['violations'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      if (!checkRule3()){
        $DB_err='\"source[Type*Concept] is univalent\"';
      } else
      if (!checkRule4()){
        $DB_err='\"source[Type*Concept] is total\"';
      } else
      if (!checkRule5()){
        $DB_err='\"target[Type*Concept] is univalent\"';
      } else
      if (!checkRule6()){
        $DB_err='\"target[Type*Concept] is total\"';
      } else
      if (!checkRule11()){
        $DB_err='\"property[MultiplicityRule*Prop] is univalent\"';
      } else
      if (!checkRule12()){
        $DB_err='\"property[MultiplicityRule*Prop] is total\"';
      } else
      if (!checkRule13()){
        $DB_err='\"on[MultiplicityRule*Relation] is univalent\"';
      } else
      if (!checkRule14()){
        $DB_err='\"on[MultiplicityRule*Relation] is total\"';
      } else
      if (!checkRule15()){
        $DB_err='\"property[HomogeneousRule*Prop] is univalent\"';
      } else
      if (!checkRule16()){
        $DB_err='\"property[HomogeneousRule*Prop] is total\"';
      } else
      if (!checkRule17()){
        $DB_err='\"on[HomogeneousRule*Relation] is univalent\"';
      } else
      if (!checkRule18()){
        $DB_err='\"on[HomogeneousRule*Relation] is total\"';
      } else
      if (!checkRule21()){
        $DB_err='\"type[UserRule*Type] is univalent\"';
      } else
      if (!checkRule22()){
        $DB_err='\"type[UserRule*Type] is total\"';
      } else
      if (!checkRule23()){
        $DB_err='\"type[MultiplicityRule*Type] is univalent\"';
      } else
      if (!checkRule24()){
        $DB_err='\"type[MultiplicityRule*Type] is total\"';
      } else
      if (!checkRule26()){
        $DB_err='\"type[HomogeneousRule*Type] is total\"';
      } else
      if (!checkRule30()){
        $DB_err='\"explanation[UserRule*Explanation] is total\"';
      } else
      if (!checkRule32()){
        $DB_err='\"explanation[MultiplicityRule*Explanation] is total\"';
      } else
      if (!checkRule34()){
        $DB_err='\"explanation[HomogeneousRule*Explanation] is total\"';
      } else
      if (!checkRule35()){
        $DB_err='\"user[Picture*User] is univalent\"';
      } else
      if (!checkRule36()){
        $DB_err='\"user[Picture*User] is total\"';
      } else
      if (!checkRule49()){
        $DB_err='\"user[MultiplicityRule*User] is univalent\"';
      } else
      if (!checkRule50()){
        $DB_err='\"user[MultiplicityRule*User] is total\"';
      } else
      if (!checkRule51()){
        $DB_err='\"user[HomogeneousRule*User] is univalent\"';
      } else
      if (!checkRule52()){
        $DB_err='\"user[HomogeneousRule*User] is total\"';
      } else
      if (!checkRule55()){
        $DB_err='\"user[UserRule*User] is univalent\"';
      } else
      if (!checkRule56()){
        $DB_err='\"user[UserRule*User] is total\"';
      } else
      if (!checkRule63()){
        $DB_err='\"script[Picture*Script] is univalent\"';
      } else
      if (!checkRule64()){
        $DB_err='\"script[Picture*Script] is total\"';
      } else
      if (!checkRule77()){
        $DB_err='\"script[MultiplicityRule*Script] is univalent\"';
      } else
      if (!checkRule78()){
        $DB_err='\"script[MultiplicityRule*Script] is total\"';
      } else
      if (!checkRule79()){
        $DB_err='\"script[HomogeneousRule*Script] is univalent\"';
      } else
      if (!checkRule80()){
        $DB_err='\"script[HomogeneousRule*Script] is total\"';
      } else
      if (!checkRule83()){
        $DB_err='\"script[UserRule*Script] is univalent\"';
      } else
      if (!checkRule84()){
        $DB_err='\"script[UserRule*Script] is total\"';
      } else
      if (!checkRule91()){
        $DB_err='\"display[Picture*String] is univalent\"';
      } else
      if (!checkRule92()){
        $DB_err='\"display[Picture*String] is total\"';
      } else
      if (!checkRule93()){
        $DB_err='\"display[Relation*String] is univalent\"';
      } else
      if (!checkRule94()){
        $DB_err='\"display[Relation*String] is total\"';
      } else
      if (!checkRule95()){
        $DB_err='\"display[Type*String] is univalent\"';
      } else
      if (!checkRule97()){
        $DB_err='\"display[Pair*String] is univalent\"';
      } else
      if (!checkRule99()){
        $DB_err='\"display[Concept*String] is univalent\"';
      } else
      if (!checkRule100()){
        $DB_err='\"display[Concept*String] is total\"';
      } else
      if (!checkRule101()){
        $DB_err='\"display[Atom*String] is univalent\"';
      } else
      if (!checkRule103()){
        $DB_err='\"display[IsaRelation*String] is univalent\"';
      } else
      if (!checkRule105()){
        $DB_err='\"display[MultiplicityRule*String] is univalent\"';
      } else
      if (!checkRule106()){
        $DB_err='\"display[MultiplicityRule*String] is total\"';
      } else
      if (!checkRule107()){
        $DB_err='\"display[HomogeneousRule*String] is univalent\"';
      } else
      if (!checkRule108()){
        $DB_err='\"display[HomogeneousRule*String] is total\"';
      } else
      if (!checkRule109()){
        $DB_err='\"display[Prop*String] is univalent\"';
      } else
      if (!checkRule110()){
        $DB_err='\"display[Prop*String] is total\"';
      } else
      if (!checkRule111()){
        $DB_err='\"display[UserRule*String] is univalent\"';
      } else
      if (!checkRule112()){
        $DB_err='\"display[UserRule*String] is total\"';
      } else
      if (!checkRule113()){
        $DB_err='\"display[Rule*String] is univalent\"';
      } else
      if (!checkRule115()){
        $DB_err='\"display[Violation*String] is univalent\"';
      } else
      if (!checkRule116()){
        $DB_err='\"display[Violation*String] is total\"';
      } else
      if (!checkRule117()){
        $DB_err='\"display[Explanation*String] is univalent\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Conceptualdiagram($val){
      $this->_Conceptualdiagram=$val;
    }
    function get_Conceptualdiagram(){
      if(!isset($this->_Conceptualdiagram)) return array();
      return $this->_Conceptualdiagram;
    }
    function set_Userdefinedrules($val){
      $this->_Userdefinedrules=$val;
    }
    function get_Userdefinedrules(){
      if(!isset($this->_Userdefinedrules)) return array();
      return $this->_Userdefinedrules;
    }
    function set_Multiplicities($val){
      $this->_Multiplicities=$val;
    }
    function get_Multiplicities(){
      if(!isset($this->_Multiplicities)) return array();
      return $this->_Multiplicities;
    }
    function set_Homogeneousproperties($val){
      $this->_Homogeneousproperties=$val;
    }
    function get_Homogeneousproperties(){
      if(!isset($this->_Homogeneousproperties)) return array();
      return $this->_Homogeneousproperties;
    }
  }

?>