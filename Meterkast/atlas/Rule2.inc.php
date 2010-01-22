<?php // generated with ADL vs. 0.8.10-558
  
  /********* on line 233, file "comp/PWO_gmi/434.adl"
    SERVICE Rule2 : I[MultiplicityRule]
   = [ property of relation {"DISPLAY=Relation.display"} : on
     , violations : violates~;display
     , explanation : explanation;display
     , pattern {"DISPLAY=Pattern.display"} : on;pattern
     ]
   *********/
  
  class Rule2 {
    protected $id=false;
    protected $_new=true;
    private $_propertyofrelation;
    private $_violations;
    private $_explanation;
    private $_pattern;
    function Rule2($id=null, $_propertyofrelation=null, $_violations=null, $_explanation=null, $_pattern=null){
      $this->id=$id;
      $this->_propertyofrelation=$_propertyofrelation;
      $this->_violations=$_violations;
      $this->_explanation=$_explanation;
      $this->_pattern=$_pattern;
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
                                       , `f2`.`pattern`
                                    FROM `multiplicityrule`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `multiplicityrule` AS F0, `explanation` AS F1
                                                  WHERE F0.`explanation`=F1.`i`
                                               ) AS f1
                                      ON `f1`.`i`='".addslashes($id)."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`pattern`
                                                   FROM `multiplicityrule` AS F0, `relation` AS F1
                                                  WHERE F0.`on`=F1.`i`
                                               ) AS f2
                                      ON `f2`.`i`='".addslashes($id)."'
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
          $this->set_pattern($me['pattern']);
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
      $me=array("id"=>$this->getId(), "property of relation" => $this->_propertyofrelation, "violations" => $this->_violations, "explanation" => $this->_explanation, "pattern" => $this->_pattern);
      if(isset($me['id']))
        DB_doquer("UPDATE `multiplicityrule` SET `on`='".addslashes($me['property of relation'])."' WHERE `i`='".addslashes($me['id'])."'", 5);
      // no code for property of relation,i in relation
      // no code for pattern,i in pattern
      foreach($me['violations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['explanation'])."'",5);
      foreach($me['violations'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($me['explanation'])."')", 5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "property of relation" => $this->_propertyofrelation, "violations" => $this->_violations, "explanation" => $this->_explanation, "pattern" => $this->_pattern);
      foreach($me['violations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['explanation'])."'",5);
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
    function set_pattern($val){
      $this->_pattern=$val;
    }
    function get_pattern(){
      return $this->_pattern;
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