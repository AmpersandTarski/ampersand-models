<?php // generated with ADL vs. 0.8.10-478
  
  /********* on line 181, file "atlas.adl"
    SERVICE Rule3 : I[HomogeneousRule]
   = [ source : type;source;display
     , target : type;target;display
     , violations : violates~;display
     , explanation : explanation;display
     ]
   *********/
  
  class Rule3 {
    protected $id=false;
    protected $_new=true;
    private $_source;
    private $_target;
    private $_violations;
    private $_explanation;
    function Rule3($id=null, $_source=null, $_target=null, $_violations=null, $_explanation=null){
      $this->id=$id;
      $this->_source=$_source;
      $this->_target=$_target;
      $this->_violations=$_violations;
      $this->_explanation=$_explanation;
      if(!isset($_source) && isset($id)){
        // get a Rule3 based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttHomogeneousRule` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttHomogeneousRule`, `i`
                                  FROM `homogeneousrule`
                              ) AS fst
                          WHERE fst.`AttHomogeneousRule` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `homogeneousrule`.`i` AS `id`
                                       , `f1`.`display` AS `source`
                                       , `f2`.`display` AS `target`
                                       , `f3`.`display` AS `explanation`
                                    FROM `homogeneousrule`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F2.`display`
                                                   FROM `homogeneousrule` AS F0, `type` AS F1, `concept` AS F2
                                                  WHERE F0.`type`=F1.`i`
                                                    AND F1.`source`=F2.`i`
                                               ) AS f1
                                      ON `f1`.`i`='".addslashes($id)."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F2.`display`
                                                   FROM `homogeneousrule` AS F0, `type` AS F1, `concept` AS F2
                                                  WHERE F0.`type`=F1.`i`
                                                    AND F1.`target`=F2.`i`
                                               ) AS f2
                                      ON `f2`.`i`='".addslashes($id)."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `homogeneousrule` AS F0, `explanation` AS F1
                                                  WHERE F0.`explanation`=F1.`i`
                                               ) AS f3
                                      ON `f3`.`i`='".addslashes($id)."'
                                   WHERE `homogeneousrule`.`i`='".addslashes($id)."'"));
          $me['violations']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `violations`
                                                  FROM `homogeneousrule`
                                                  JOIN  ( SELECT DISTINCT F0.`HomogeneousRule`, F1.`display`
                                                                 FROM `violateshomogeneousrule` AS F0, `violation` AS F1
                                                                WHERE F0.`violation`=F1.`i`
                                                             ) AS f1
                                                    ON `f1`.`HomogeneousRule`='".addslashes($id)."'
                                                 WHERE `homogeneousrule`.`i`='".addslashes($id)."'"));
          $this->set_source($me['source']);
          $this->set_target($me['target']);
          $this->set_violations($me['violations']);
          $this->set_explanation($me['explanation']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttHomogeneousRule` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttHomogeneousRule`, `i`
                                  FROM `homogeneousrule`
                              ) AS fst
                          WHERE fst.`AttHomogeneousRule` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "source" => $this->_source, "target" => $this->_target, "violations" => $this->_violations, "explanation" => $this->_explanation);
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['source'])."'",5);
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['target'])."'",5);
      foreach($me['violations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['explanation'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($me['source'])."')", 5);
      $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($me['target'])."')", 5);
      foreach($me['violations'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($me['explanation'])."')", 5);
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
      if (!checkRule16()){
        $DB_err='\"property[HomogeneousRule*Prop] is total\"';
      } else
      if (!checkRule18()){
        $DB_err='\"on[HomogeneousRule*Relation] is total\"';
      } else
      if (!checkRule25()){
        $DB_err='\"type[HomogeneousRule*Type] is univalent\"';
      } else
      if (!checkRule26()){
        $DB_err='\"type[HomogeneousRule*Type] is total\"';
      } else
      if (!checkRule33()){
        $DB_err='\"explanation[HomogeneousRule*Explanation] is univalent\"';
      } else
      if (!checkRule34()){
        $DB_err='\"explanation[HomogeneousRule*Explanation] is total\"';
      } else
      if (!checkRule52()){
        $DB_err='\"user[HomogeneousRule*UserName] is total\"';
      } else
      if (!checkRule80()){
        $DB_err='\"script[HomogeneousRule*Script] is total\"';
      } else
      if (!checkRule91()){
        $DB_err='\"display[Picture*String] is univalent\"';
      } else
      if (!checkRule93()){
        $DB_err='\"display[Relation*String] is univalent\"';
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
      if (!checkRule107()){
        $DB_err='\"display[HomogeneousRule*String] is univalent\"';
      } else
      if (!checkRule108()){
        $DB_err='\"display[HomogeneousRule*String] is total\"';
      } else
      if (!checkRule109()){
        $DB_err='\"display[Prop*String] is univalent\"';
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
      if (!checkRule116()){
        $DB_err='\"display[Violation*String] is total\"';
      } else
      if (!checkRule117()){
        $DB_err='\"display[Explanation*String] is univalent\"';
      } else
      if (!checkRule118()){
        $DB_err='\"display[Explanation*String] is total\"';
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
      $me=array("id"=>$this->getId(), "source" => $this->_source, "target" => $this->_target, "violations" => $this->_violations, "explanation" => $this->_explanation);
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['source'])."'",5);
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['target'])."'",5);
      foreach($me['violations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['explanation'])."'",5);
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
      if (!checkRule16()){
        $DB_err='\"property[HomogeneousRule*Prop] is total\"';
      } else
      if (!checkRule18()){
        $DB_err='\"on[HomogeneousRule*Relation] is total\"';
      } else
      if (!checkRule25()){
        $DB_err='\"type[HomogeneousRule*Type] is univalent\"';
      } else
      if (!checkRule26()){
        $DB_err='\"type[HomogeneousRule*Type] is total\"';
      } else
      if (!checkRule33()){
        $DB_err='\"explanation[HomogeneousRule*Explanation] is univalent\"';
      } else
      if (!checkRule34()){
        $DB_err='\"explanation[HomogeneousRule*Explanation] is total\"';
      } else
      if (!checkRule52()){
        $DB_err='\"user[HomogeneousRule*UserName] is total\"';
      } else
      if (!checkRule80()){
        $DB_err='\"script[HomogeneousRule*Script] is total\"';
      } else
      if (!checkRule91()){
        $DB_err='\"display[Picture*String] is univalent\"';
      } else
      if (!checkRule93()){
        $DB_err='\"display[Relation*String] is univalent\"';
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
      if (!checkRule107()){
        $DB_err='\"display[HomogeneousRule*String] is univalent\"';
      } else
      if (!checkRule108()){
        $DB_err='\"display[HomogeneousRule*String] is total\"';
      } else
      if (!checkRule109()){
        $DB_err='\"display[Prop*String] is univalent\"';
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
      if (!checkRule116()){
        $DB_err='\"display[Violation*String] is total\"';
      } else
      if (!checkRule117()){
        $DB_err='\"display[Explanation*String] is univalent\"';
      } else
      if (!checkRule118()){
        $DB_err='\"display[Explanation*String] is total\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_source($val){
      $this->_source=$val;
    }
    function get_source(){
      return $this->_source;
    }
    function set_target($val){
      $this->_target=$val;
    }
    function get_target(){
      return $this->_target;
    }
    function set_violations($val){
      $this->_violations=$val;
    }
    function get_violations(){
      if(!isset($this->_violations)) return array();
      return $this->_violations;
    }
    function set_explanation($val){
      $this->_explanation=$val;
    }
    function get_explanation(){
      return $this->_explanation;
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

  function getEachRule3(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `homogeneousrule`'));
  }

  function readRule3($id){
      // check existence of $id
      $obj = new Rule3($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delRule3($id){
    $tobeDeleted = new Rule3($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>