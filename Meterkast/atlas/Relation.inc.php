<?php // generated with ADL vs. 0.8.10-493
  
  /********* on line 196, file "atlas.adl"
    SERVICE Relation : I[Relation]
   = [ type : relvar;display
     , source(s) {"DISPLAY=Concept.display"} : relvar;source
     , target(s) {"DISPLAY=Concept.display"} : relvar;target
     , multiplicity properties : on~
        = [ property : property;display
          , derived rule : display
          , violations : violates~;display
          ]
     , homogeneous properties : on~
        = [ property : property;display
          , derived rule : display
          , violations : violates~;display
          ]
     , population : contains;display
     , used in rules {"DISPLAY=UserRule.display"} : morphisms~
     ]
   *********/
  
  class Relation {
    protected $id=false;
    protected $_new=true;
    private $_type;
    private $_sources;
    private $_targets;
    private $_multiplicityproperties;
    private $_homogeneousproperties;
    private $_population;
    private $_usedinrules;
    function Relation($id=null, $_type=null, $_sources=null, $_targets=null, $_multiplicityproperties=null, $_homogeneousproperties=null, $_population=null, $_usedinrules=null){
      $this->id=$id;
      $this->_type=$_type;
      $this->_sources=$_sources;
      $this->_targets=$_targets;
      $this->_multiplicityproperties=$_multiplicityproperties;
      $this->_homogeneousproperties=$_homogeneousproperties;
      $this->_population=$_population;
      $this->_usedinrules=$_usedinrules;
      if(!isset($_type) && isset($id)){
        // get a Relation based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttRelation` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttRelation`, `i`
                                  FROM `relation`
                              ) AS fst
                          WHERE fst.`AttRelation` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['type']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `type`
                                            FROM `relation`
                                            JOIN  ( SELECT DISTINCT F0.`relation`, F1.`display`
                                                           FROM `relvar` AS F0, `type` AS F1
                                                          WHERE F0.`Type`=F1.`i`
                                                       ) AS f1
                                              ON `f1`.`relation`='".addslashes($id)."'
                                           WHERE `relation`.`i`='".addslashes($id)."'"));
          $me['source(s)']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`source` AS `source(s)`
                                                 FROM `relation`
                                                 JOIN  ( SELECT DISTINCT F0.`relation`, F1.`source`
                                                                FROM `relvar` AS F0, `type` AS F1
                                                               WHERE F0.`Type`=F1.`i`
                                                            ) AS f1
                                                   ON `f1`.`relation`='".addslashes($id)."'
                                                WHERE `relation`.`i`='".addslashes($id)."'"));
          $me['target(s)']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`target` AS `target(s)`
                                                 FROM `relation`
                                                 JOIN  ( SELECT DISTINCT F0.`relation`, F1.`target`
                                                                FROM `relvar` AS F0, `type` AS F1
                                                               WHERE F0.`Type`=F1.`i`
                                                            ) AS f1
                                                   ON `f1`.`relation`='".addslashes($id)."'
                                                WHERE `relation`.`i`='".addslashes($id)."'"));
          $me['multiplicity properties']=(DB_doquer("SELECT DISTINCT `multiplicityrule`.`i` AS `id`
                                                       FROM `multiplicityrule`
                                                      WHERE `multiplicityrule`.`on`='".addslashes($id)."'"));
          $me['homogeneous properties']=(DB_doquer("SELECT DISTINCT `homogeneousrule`.`i` AS `id`
                                                      FROM `homogeneousrule`
                                                     WHERE `homogeneousrule`.`on`='".addslashes($id)."'"));
          $me['population']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `population`
                                                  FROM `relation`
                                                  JOIN  ( SELECT DISTINCT F0.`relation`, F1.`display`
                                                                 FROM `contains` AS F0, `pair` AS F1
                                                                WHERE F0.`Pair`=F1.`i`
                                                             ) AS f1
                                                    ON `f1`.`relation`='".addslashes($id)."'
                                                 WHERE `relation`.`i`='".addslashes($id)."'"));
          $me['used in rules']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`userrule` AS `used in rules`
                                                     FROM `relation`
                                                     JOIN `morphisms` AS f1 ON `f1`.`Relation`='".addslashes($id)."'
                                                    WHERE `relation`.`i`='".addslashes($id)."'"));
          foreach($me['multiplicity properties'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`display` AS `property`
                                         , `f3`.`display` AS `derived rule`
                                      FROM `multiplicityrule`
                                      LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                     FROM `multiplicityrule` AS F0, `prop` AS F1
                                                    WHERE F0.`property`=F1.`i`
                                                 ) AS f2
                                        ON `f2`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `multiplicityrule` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
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
          foreach($me['homogeneous properties'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`display` AS `property`
                                         , `f3`.`display` AS `derived rule`
                                      FROM `homogeneousrule`
                                      LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                     FROM `homogeneousrule` AS F0, `prop` AS F1
                                                    WHERE F0.`property`=F1.`i`
                                                 ) AS f2
                                        ON `f2`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `homogeneousrule` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
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
          $this->set_type($me['type']);
          $this->set_sources($me['source(s)']);
          $this->set_targets($me['target(s)']);
          $this->set_multiplicityproperties($me['multiplicity properties']);
          $this->set_homogeneousproperties($me['homogeneous properties']);
          $this->set_population($me['population']);
          $this->set_usedinrules($me['used in rules']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttRelation` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttRelation`, `i`
                                  FROM `relation`
                              ) AS fst
                          WHERE fst.`AttRelation` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "type" => $this->_type, "source(s)" => $this->_sources, "target(s)" => $this->_targets, "multiplicity properties" => $this->_multiplicityproperties, "homogeneous properties" => $this->_homogeneousproperties, "population" => $this->_population, "used in rules" => $this->_usedinrules);
      foreach($me['multiplicity properties'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `multiplicityrule` SET `display`='".addslashes($v0['derived rule'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
      }
      foreach  ($me['multiplicity properties'] as $multiplicityproperties){
        if(isset($me['id']))
          DB_doquer("UPDATE `multiplicityrule` SET `on`='".addslashes($me['id'])."' WHERE `i`='".addslashes($multiplicityproperties['id'])."'", 5);
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `homogeneousrule` SET `display`='".addslashes($v0['derived rule'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
      }
      foreach  ($me['homogeneous properties'] as $homogeneousproperties){
        if(isset($me['id']))
          DB_doquer("UPDATE `homogeneousrule` SET `on`='".addslashes($me['id'])."' WHERE `i`='".addslashes($homogeneousproperties['id'])."'", 5);
      }
      // no code for used in rules,i in userrule
      // no code for source(s),i in concept
      // no code for target(s),i in concept
      foreach($me['type'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['multiplicity properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['property'])."'",5);
      }
      foreach($me['multiplicity properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['derived rule'])."'",5);
      }
      foreach($me['multiplicity properties'] as $i0=>$v0){
        foreach($v0['violations'] as $i1=>$v1){
          DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['property'])."'",5);
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['derived rule'])."'",5);
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        foreach($v0['violations'] as $i1=>$v1){
          DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['population'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['type'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['multiplicity properties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['property'])."')", 5);
      }
      foreach($me['multiplicity properties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['derived rule'])."')", 5);
      }
      foreach($me['multiplicity properties'] as $i0=>$v0){
        foreach($v0['violations'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['property'])."')", 5);
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['derived rule'])."')", 5);
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        foreach($v0['violations'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['population'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
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
      if (!checkRule7()){
        $DB_err='\"specific[IsaRelation*Concept] is univalent\"';
      } else
      if (!checkRule9()){
        $DB_err='\"general[IsaRelation*Concept] is univalent\"';
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
      if (!checkRule22()){
        $DB_err='\"type[UserRule*Type] is total\"';
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
      if (!checkRule38()){
        $DB_err='\"user[Relation*User] is total\"';
      } else
      if (!checkRule44()){
        $DB_err='\"user[Concept*User] is total\"';
      } else
      if (!checkRule50()){
        $DB_err='\"user[MultiplicityRule*User] is total\"';
      } else
      if (!checkRule52()){
        $DB_err='\"user[HomogeneousRule*User] is total\"';
      } else
      if (!checkRule56()){
        $DB_err='\"user[UserRule*User] is total\"';
      } else
      if (!checkRule66()){
        $DB_err='\"script[Relation*Script] is total\"';
      } else
      if (!checkRule72()){
        $DB_err='\"script[Concept*Script] is total\"';
      } else
      if (!checkRule78()){
        $DB_err='\"script[MultiplicityRule*Script] is total\"';
      } else
      if (!checkRule80()){
        $DB_err='\"script[HomogeneousRule*Script] is total\"';
      } else
      if (!checkRule84()){
        $DB_err='\"script[UserRule*Script] is total\"';
      } else
      if (!checkRule91()){
        $DB_err='\"display[Picture*String] is univalent\"';
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
      if (!checkRule96()){
        $DB_err='\"display[Type*String] is total\"';
      } else
      if (!checkRule97()){
        $DB_err='\"display[Pair*String] is univalent\"';
      } else
      if (!checkRule98()){
        $DB_err='\"display[Pair*String] is total\"';
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
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "type" => $this->_type, "source(s)" => $this->_sources, "target(s)" => $this->_targets, "multiplicity properties" => $this->_multiplicityproperties, "homogeneous properties" => $this->_homogeneousproperties, "population" => $this->_population, "used in rules" => $this->_usedinrules);
      foreach($me['type'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['multiplicity properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['property'])."'",5);
      }
      foreach($me['multiplicity properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['derived rule'])."'",5);
      }
      foreach($me['multiplicity properties'] as $i0=>$v0){
        foreach($v0['violations'] as $i1=>$v1){
          DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['property'])."'",5);
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['derived rule'])."'",5);
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        foreach($v0['violations'] as $i1=>$v1){
          DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['population'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
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
      if (!checkRule7()){
        $DB_err='\"specific[IsaRelation*Concept] is univalent\"';
      } else
      if (!checkRule9()){
        $DB_err='\"general[IsaRelation*Concept] is univalent\"';
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
      if (!checkRule22()){
        $DB_err='\"type[UserRule*Type] is total\"';
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
      if (!checkRule38()){
        $DB_err='\"user[Relation*User] is total\"';
      } else
      if (!checkRule44()){
        $DB_err='\"user[Concept*User] is total\"';
      } else
      if (!checkRule50()){
        $DB_err='\"user[MultiplicityRule*User] is total\"';
      } else
      if (!checkRule52()){
        $DB_err='\"user[HomogeneousRule*User] is total\"';
      } else
      if (!checkRule56()){
        $DB_err='\"user[UserRule*User] is total\"';
      } else
      if (!checkRule66()){
        $DB_err='\"script[Relation*Script] is total\"';
      } else
      if (!checkRule72()){
        $DB_err='\"script[Concept*Script] is total\"';
      } else
      if (!checkRule78()){
        $DB_err='\"script[MultiplicityRule*Script] is total\"';
      } else
      if (!checkRule80()){
        $DB_err='\"script[HomogeneousRule*Script] is total\"';
      } else
      if (!checkRule84()){
        $DB_err='\"script[UserRule*Script] is total\"';
      } else
      if (!checkRule91()){
        $DB_err='\"display[Picture*String] is univalent\"';
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
      if (!checkRule96()){
        $DB_err='\"display[Type*String] is total\"';
      } else
      if (!checkRule97()){
        $DB_err='\"display[Pair*String] is univalent\"';
      } else
      if (!checkRule98()){
        $DB_err='\"display[Pair*String] is total\"';
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
    function set_type($val){
      $this->_type=$val;
    }
    function get_type(){
      if(!isset($this->_type)) return array();
      return $this->_type;
    }
    function set_sources($val){
      $this->_sources=$val;
    }
    function get_sources(){
      if(!isset($this->_sources)) return array();
      return $this->_sources;
    }
    function set_targets($val){
      $this->_targets=$val;
    }
    function get_targets(){
      if(!isset($this->_targets)) return array();
      return $this->_targets;
    }
    function set_multiplicityproperties($val){
      $this->_multiplicityproperties=$val;
    }
    function get_multiplicityproperties(){
      if(!isset($this->_multiplicityproperties)) return array();
      return $this->_multiplicityproperties;
    }
    function set_homogeneousproperties($val){
      $this->_homogeneousproperties=$val;
    }
    function get_homogeneousproperties(){
      if(!isset($this->_homogeneousproperties)) return array();
      return $this->_homogeneousproperties;
    }
    function set_population($val){
      $this->_population=$val;
    }
    function get_population(){
      if(!isset($this->_population)) return array();
      return $this->_population;
    }
    function set_usedinrules($val){
      $this->_usedinrules=$val;
    }
    function get_usedinrules(){
      if(!isset($this->_usedinrules)) return array();
      return $this->_usedinrules;
    }
    function setId($id){
      $this->id=$id;
      return $this->id;
    }
    function getId(){
      if($this->id===null) return false;
      return $this->id;
    }
    function isNew(){
      return $this->_new;
    }
  }

  function getEachRelation(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `relation`'));
  }

  function readRelation($id){
      // check existence of $id
      $obj = new Relation($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delRelation($id){
    $tobeDeleted = new Relation($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>