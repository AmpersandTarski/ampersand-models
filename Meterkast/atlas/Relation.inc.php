<?php // generated with ADL vs. 0.8.10-478
  
  /********* on line 202, file "atlas.adl"
    SERVICE Relation : I[Relation]
   = [ name : display
     , type : relvar;display
     , source(s) : relvar;source;display
     , target(s) : relvar;target;display
     , multiplicity properties : on~;property;display
     , homogeneous properties : on~;property;display
     , population : contains;display
     ]
   *********/
  
  class Relation {
    protected $id=false;
    protected $_new=true;
    private $_name;
    private $_type;
    private $_sources;
    private $_targets;
    private $_multiplicityproperties;
    private $_homogeneousproperties;
    private $_population;
    function Relation($id=null, $_name=null, $_type=null, $_sources=null, $_targets=null, $_multiplicityproperties=null, $_homogeneousproperties=null, $_population=null){
      $this->id=$id;
      $this->_name=$_name;
      $this->_type=$_type;
      $this->_sources=$_sources;
      $this->_targets=$_targets;
      $this->_multiplicityproperties=$_multiplicityproperties;
      $this->_homogeneousproperties=$_homogeneousproperties;
      $this->_population=$_population;
      if(!isset($_name) && isset($id)){
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
          $me=firstRow(DB_doquer("SELECT DISTINCT `relation`.`i` AS `id`
                                       , `relation`.`display` AS `name`
                                    FROM `relation`
                                   WHERE `relation`.`i`='".addslashes($id)."'"));
          $me['type']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `type`
                                            FROM `relation`
                                            JOIN  ( SELECT DISTINCT F0.`relation`, F1.`display`
                                                           FROM `relvar` AS F0, `type` AS F1
                                                          WHERE F0.`Type`=F1.`i`
                                                       ) AS f1
                                              ON `f1`.`relation`='".addslashes($id)."'
                                           WHERE `relation`.`i`='".addslashes($id)."'"));
          $me['source(s)']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `source(s)`
                                                 FROM `relation`
                                                 JOIN  ( SELECT DISTINCT F0.`relation`, F2.`display`
                                                                FROM `relvar` AS F0, `type` AS F1, `concept` AS F2
                                                               WHERE F0.`Type`=F1.`i`
                                                                 AND F1.`source`=F2.`i`
                                                            ) AS f1
                                                   ON `f1`.`relation`='".addslashes($id)."'
                                                WHERE `relation`.`i`='".addslashes($id)."'"));
          $me['target(s)']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `target(s)`
                                                 FROM `relation`
                                                 JOIN  ( SELECT DISTINCT F0.`relation`, F2.`display`
                                                                FROM `relvar` AS F0, `type` AS F1, `concept` AS F2
                                                               WHERE F0.`Type`=F1.`i`
                                                                 AND F1.`target`=F2.`i`
                                                            ) AS f1
                                                   ON `f1`.`relation`='".addslashes($id)."'
                                                WHERE `relation`.`i`='".addslashes($id)."'"));
          $me['multiplicity properties']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `multiplicity properties`
                                                               FROM `relation`
                                                               JOIN  ( SELECT DISTINCT F0.`on`, F2.`display`
                                                                              FROM `multiplicityrule` AS F0, `multiplicityrule` AS F1, `prop` AS F2
                                                                             WHERE F0.`i`=F1.`i`
                                                                               AND F1.`property`=F2.`i`
                                                                          ) AS f1
                                                                 ON `f1`.`on`='".addslashes($id)."'
                                                              WHERE `relation`.`i`='".addslashes($id)."'"));
          $me['homogeneous properties']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `homogeneous properties`
                                                              FROM `relation`
                                                              JOIN  ( SELECT DISTINCT F0.`on`, F2.`display`
                                                                             FROM `homogeneousrule` AS F0, `homogeneousrule` AS F1, `prop` AS F2
                                                                            WHERE F0.`i`=F1.`i`
                                                                              AND F1.`property`=F2.`i`
                                                                         ) AS f1
                                                                ON `f1`.`on`='".addslashes($id)."'
                                                             WHERE `relation`.`i`='".addslashes($id)."'"));
          $me['population']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `population`
                                                  FROM `relation`
                                                  JOIN  ( SELECT DISTINCT F0.`relation`, F1.`display`
                                                                 FROM `contains` AS F0, `pair` AS F1
                                                                WHERE F0.`Pair`=F1.`i`
                                                             ) AS f1
                                                    ON `f1`.`relation`='".addslashes($id)."'
                                                 WHERE `relation`.`i`='".addslashes($id)."'"));
          $this->set_name($me['name']);
          $this->set_type($me['type']);
          $this->set_sources($me['source(s)']);
          $this->set_targets($me['target(s)']);
          $this->set_multiplicityproperties($me['multiplicity properties']);
          $this->set_homogeneousproperties($me['homogeneous properties']);
          $this->set_population($me['population']);
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
      $me=array("id"=>$this->getId(), "name" => $this->_name, "type" => $this->_type, "source(s)" => $this->_sources, "target(s)" => $this->_targets, "multiplicity properties" => $this->_multiplicityproperties, "homogeneous properties" => $this->_homogeneousproperties, "population" => $this->_population);
      if(isset($me['id']))
        DB_doquer("UPDATE `relation` SET `display`='".addslashes($me['name'])."' WHERE `i`='".addslashes($me['id'])."'", 5);
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['name'])."'",5);
      foreach($me['type'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['source(s)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['target(s)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['multiplicity properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['population'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($me['name'])."')", 5);
      foreach($me['type'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['source(s)'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['target(s)'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['multiplicity properties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
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
      if (!checkRule38()){
        $DB_err='\"user[Relation*UserName] is total\"';
      } else
      if (!checkRule66()){
        $DB_err='\"script[Relation*Script] is total\"';
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
      if (!checkRule107()){
        $DB_err='\"display[HomogeneousRule*String] is univalent\"';
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
      if (!checkRule113()){
        $DB_err='\"display[Rule*String] is univalent\"';
      } else
      if (!checkRule115()){
        $DB_err='\"display[Violation*String] is univalent\"';
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
      $me=array("id"=>$this->getId(), "name" => $this->_name, "type" => $this->_type, "source(s)" => $this->_sources, "target(s)" => $this->_targets, "multiplicity properties" => $this->_multiplicityproperties, "homogeneous properties" => $this->_homogeneousproperties, "population" => $this->_population);
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['name'])."'",5);
      foreach($me['type'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['source(s)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['target(s)'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['multiplicity properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
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
      if (!checkRule38()){
        $DB_err='\"user[Relation*UserName] is total\"';
      } else
      if (!checkRule66()){
        $DB_err='\"script[Relation*Script] is total\"';
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
      if (!checkRule107()){
        $DB_err='\"display[HomogeneousRule*String] is univalent\"';
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
      if (!checkRule113()){
        $DB_err='\"display[Rule*String] is univalent\"';
      } else
      if (!checkRule115()){
        $DB_err='\"display[Violation*String] is univalent\"';
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
    function set_name($val){
      $this->_name=$val;
    }
    function get_name(){
      return $this->_name;
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