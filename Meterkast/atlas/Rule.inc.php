<?php // generated with ADL vs. 0.8.10-492
  
  /********* on line 164, file "atlas.adl"
    SERVICE Rule : I[Rule]
   = [ source {"DISPLAY=Concept.display"} : type;source
     , target {"DISPLAY=Concept.display"} : type;target
     , violations : violates~;display
     , explanation : explanation;display
     ]
   *********/
  
  class Rule {
    protected $id=false;
    protected $_new=true;
    private $_source;
    private $_target;
    private $_violations;
    private $_explanation;
    function Rule($id=null, $_source=null, $_target=null, $_violations=null, $_explanation=null){
      $this->id=$id;
      $this->_source=$_source;
      $this->_target=$_target;
      $this->_violations=$_violations;
      $this->_explanation=$_explanation;
      if(!isset($_source) && isset($id)){
        // get a Rule based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttRule` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttRule`, `i`
                                  FROM `rule`
                              ) AS fst
                          WHERE fst.`AttRule` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `rule`.`i` AS `id`
                                       , `f1`.`source`
                                       , `f2`.`target`
                                       , `f3`.`display` AS `explanation`
                                    FROM `rule`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`source`
                                                   FROM `rule` AS F0, `type` AS F1
                                                  WHERE F0.`type`=F1.`i`
                                               ) AS f1
                                      ON `f1`.`i`='".addslashes($id)."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`target`
                                                   FROM `rule` AS F0, `type` AS F1
                                                  WHERE F0.`type`=F1.`i`
                                               ) AS f2
                                      ON `f2`.`i`='".addslashes($id)."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `rule` AS F0, `explanation` AS F1
                                                  WHERE F0.`explanation`=F1.`i`
                                               ) AS f3
                                      ON `f3`.`i`='".addslashes($id)."'
                                   WHERE `rule`.`i`='".addslashes($id)."'"));
          $me['violations']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `violations`
                                                  FROM `rule`
                                                  JOIN  ( SELECT DISTINCT F0.`Rule`, F1.`display`
                                                                 FROM `violates` AS F0, `violation` AS F1
                                                                WHERE F0.`violation`=F1.`i`
                                                             ) AS f1
                                                    ON `f1`.`Rule`='".addslashes($id)."'
                                                 WHERE `rule`.`i`='".addslashes($id)."'"));
          $this->set_source($me['source']);
          $this->set_target($me['target']);
          $this->set_violations($me['violations']);
          $this->set_explanation($me['explanation']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttRule` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttRule`, `i`
                                  FROM `rule`
                              ) AS fst
                          WHERE fst.`AttRule` = \''.addSlashes($id).'\'');
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
      // no code for source,i in concept
      // no code for target,i in concept
      foreach($me['violations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['explanation'])."'",5);
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
      if (!checkRule7()){
        $DB_err='\"specific[IsaRelation*Concept] is univalent\"';
      } else
      if (!checkRule9()){
        $DB_err='\"general[IsaRelation*Concept] is univalent\"';
      } else
      if (!checkRule19()){
        $DB_err='\"type[Rule*Type] is univalent\"';
      } else
      if (!checkRule20()){
        $DB_err='\"type[Rule*Type] is total\"';
      } else
      if (!checkRule27()){
        $DB_err='\"explanation[Rule*Explanation] is univalent\"';
      } else
      if (!checkRule28()){
        $DB_err='\"explanation[Rule*Explanation] is total\"';
      } else
      if (!checkRule44()){
        $DB_err='\"user[Concept*User] is total\"';
      } else
      if (!checkRule58()){
        $DB_err='\"user[Rule*User] is total\"';
      } else
      if (!checkRule72()){
        $DB_err='\"script[Concept*Script] is total\"';
      } else
      if (!checkRule86()){
        $DB_err='\"script[Rule*Script] is total\"';
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
      if (!checkRule109()){
        $DB_err='\"display[Prop*String] is univalent\"';
      } else
      if (!checkRule111()){
        $DB_err='\"display[UserRule*String] is univalent\"';
      } else
      if (!checkRule113()){
        $DB_err='\"display[Rule*String] is univalent\"';
      } else
      if (!checkRule114()){
        $DB_err='\"display[Rule*String] is total\"';
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
      if (!checkRule7()){
        $DB_err='\"specific[IsaRelation*Concept] is univalent\"';
      } else
      if (!checkRule9()){
        $DB_err='\"general[IsaRelation*Concept] is univalent\"';
      } else
      if (!checkRule19()){
        $DB_err='\"type[Rule*Type] is univalent\"';
      } else
      if (!checkRule20()){
        $DB_err='\"type[Rule*Type] is total\"';
      } else
      if (!checkRule27()){
        $DB_err='\"explanation[Rule*Explanation] is univalent\"';
      } else
      if (!checkRule28()){
        $DB_err='\"explanation[Rule*Explanation] is total\"';
      } else
      if (!checkRule44()){
        $DB_err='\"user[Concept*User] is total\"';
      } else
      if (!checkRule58()){
        $DB_err='\"user[Rule*User] is total\"';
      } else
      if (!checkRule72()){
        $DB_err='\"script[Concept*Script] is total\"';
      } else
      if (!checkRule86()){
        $DB_err='\"script[Rule*Script] is total\"';
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
      if (!checkRule109()){
        $DB_err='\"display[Prop*String] is univalent\"';
      } else
      if (!checkRule111()){
        $DB_err='\"display[UserRule*String] is univalent\"';
      } else
      if (!checkRule113()){
        $DB_err='\"display[Rule*String] is univalent\"';
      } else
      if (!checkRule114()){
        $DB_err='\"display[Rule*String] is total\"';
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

  function getEachRule(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `rule`'));
  }

  function readRule($id){
      // check existence of $id
      $obj = new Rule($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delRule($id){
    $tobeDeleted = new Rule($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>