<?php // generated with ADL vs. 0.8.10-493
  
  /********* on line 174, file "atlas.adl"
    SERVICE Rule2 : I[MultiplicityRule]
   = [ property of relation {"DISPLAY=Relation.display"} : on
     , violations : violates~;display
     , explanation : explanation;display
     ]
   *********/
  
  class Rule2 {
    protected $id=false;
    protected $_new=true;
    private $_propertyofrelation;
    private $_violations;
    private $_explanation;
    function Rule2($id=null, $_propertyofrelation=null, $_violations=null, $_explanation=null){
      $this->id=$id;
      $this->_propertyofrelation=$_propertyofrelation;
      $this->_violations=$_violations;
      $this->_explanation=$_explanation;
      if(!isset($_propertyofrelation) && isset($id)){
        // get a Rule2 based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttMultiplicityRule` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttMultiplicityRule`, `i`
                                  FROM `multiplicityrule`
                              ) AS fst
                          WHERE fst.`AttMultiplicityRule` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `multiplicityrule`.`i` AS `id`
                                       , `multiplicityrule`.`on` AS `property of relation`
                                       , `f1`.`display` AS `explanation`
                                    FROM `multiplicityrule`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `multiplicityrule` AS F0, `explanation` AS F1
                                                  WHERE F0.`explanation`=F1.`i`
                                               ) AS f1
                                      ON `f1`.`i`='".addslashes($id)."'
                                   WHERE `multiplicityrule`.`i`='".addslashes($id)."'"));
          $me['violations']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `violations`
                                                  FROM `multiplicityrule`
                                                  JOIN  ( SELECT DISTINCT F0.`MultiplicityRule`, F1.`display`
                                                                 FROM `violatesmultiplicityrule` AS F0, `violation` AS F1
                                                                WHERE F0.`violation`=F1.`i`
                                                             ) AS f1
                                                    ON `f1`.`MultiplicityRule`='".addslashes($id)."'
                                                 WHERE `multiplicityrule`.`i`='".addslashes($id)."'"));
          $this->set_propertyofrelation($me['property of relation']);
          $this->set_violations($me['violations']);
          $this->set_explanation($me['explanation']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttMultiplicityRule` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttMultiplicityRule`, `i`
                                  FROM `multiplicityrule`
                              ) AS fst
                          WHERE fst.`AttMultiplicityRule` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "property of relation" => $this->_propertyofrelation, "violations" => $this->_violations, "explanation" => $this->_explanation);
      if(isset($me['id']))
        DB_doquer("UPDATE `multiplicityrule` SET `on`='".addslashes($me['property of relation'])."' WHERE `i`='".addslashes($me['id'])."'", 5);
      // no code for property of relation,i in relation
      foreach($me['violations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['explanation'])."'",5);
      foreach($me['violations'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($me['explanation'])."')", 5);
      if (!checkRule12()){
        $DB_err='\"property[MultiplicityRule*Prop] is total\"';
      } else
      if (!checkRule13()){
        $DB_err='\"on[MultiplicityRule*Relation] is univalent\"';
      } else
      if (!checkRule14()){
        $DB_err='\"on[MultiplicityRule*Relation] is total\"';
      } else
      if (!checkRule17()){
        $DB_err='\"on[HomogeneousRule*Relation] is univalent\"';
      } else
      if (!checkRule24()){
        $DB_err='\"type[MultiplicityRule*Type] is total\"';
      } else
      if (!checkRule31()){
        $DB_err='\"explanation[MultiplicityRule*Explanation] is univalent\"';
      } else
      if (!checkRule32()){
        $DB_err='\"explanation[MultiplicityRule*Explanation] is total\"';
      } else
      if (!checkRule38()){
        $DB_err='\"user[Relation*User] is total\"';
      } else
      if (!checkRule50()){
        $DB_err='\"user[MultiplicityRule*User] is total\"';
      } else
      if (!checkRule66()){
        $DB_err='\"script[Relation*Script] is total\"';
      } else
      if (!checkRule78()){
        $DB_err='\"script[MultiplicityRule*Script] is total\"';
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
      if (!checkRule97()){
        $DB_err='\"display[Pair*String] is univalent\"';
      } else
      if (!checkRule99()){
        $DB_err='\"display[Concept*String] is univalent\"';
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
      $me=array("id"=>$this->getId(), "property of relation" => $this->_propertyofrelation, "violations" => $this->_violations, "explanation" => $this->_explanation);
      foreach($me['violations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['explanation'])."'",5);
      if (!checkRule12()){
        $DB_err='\"property[MultiplicityRule*Prop] is total\"';
      } else
      if (!checkRule13()){
        $DB_err='\"on[MultiplicityRule*Relation] is univalent\"';
      } else
      if (!checkRule14()){
        $DB_err='\"on[MultiplicityRule*Relation] is total\"';
      } else
      if (!checkRule17()){
        $DB_err='\"on[HomogeneousRule*Relation] is univalent\"';
      } else
      if (!checkRule24()){
        $DB_err='\"type[MultiplicityRule*Type] is total\"';
      } else
      if (!checkRule31()){
        $DB_err='\"explanation[MultiplicityRule*Explanation] is univalent\"';
      } else
      if (!checkRule32()){
        $DB_err='\"explanation[MultiplicityRule*Explanation] is total\"';
      } else
      if (!checkRule38()){
        $DB_err='\"user[Relation*User] is total\"';
      } else
      if (!checkRule50()){
        $DB_err='\"user[MultiplicityRule*User] is total\"';
      } else
      if (!checkRule66()){
        $DB_err='\"script[Relation*Script] is total\"';
      } else
      if (!checkRule78()){
        $DB_err='\"script[MultiplicityRule*Script] is total\"';
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
      if (!checkRule97()){
        $DB_err='\"display[Pair*String] is univalent\"';
      } else
      if (!checkRule99()){
        $DB_err='\"display[Concept*String] is univalent\"';
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
    function set_propertyofrelation($val){
      $this->_propertyofrelation=$val;
    }
    function get_propertyofrelation(){
      return $this->_propertyofrelation;
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

  function getEachRule2(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `multiplicityrule`'));
  }

  function readRule2($id){
      // check existence of $id
      $obj = new Rule2($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delRule2($id){
    $tobeDeleted = new Rule2($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>