<?php // generated with ADL vs. 0.8.10-557
  
  /********* on line 218, file "comp/PWO_gmi/425.adl"
    SERVICE Rule : I[Rule]
   = [ source {"DISPLAY=Concept.display"} : type;source
     , target {"DISPLAY=Concept.display"} : type;target
     , violations : violates~;display
     , explanation : explanation;display
     , pattern {"DISPLAY=Pattern.display"} : pattern
     ]
   *********/
  
  class Rule {
    protected $id=false;
    protected $_new=true;
    private $_source;
    private $_target;
    private $_violations;
    private $_explanation;
    private $_pattern;
    function Rule($id=null, $_source=null, $_target=null, $_violations=null, $_explanation=null, $_pattern=null){
      $this->id=$id;
      $this->_source=$_source;
      $this->_target=$_target;
      $this->_violations=$_violations;
      $this->_explanation=$_explanation;
      $this->_pattern=$_pattern;
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
                                       , `rule`.`pattern`
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
          $this->set_pattern($me['pattern']);
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
      $me=array("id"=>$this->getId(), "source" => $this->_source, "target" => $this->_target, "violations" => $this->_violations, "explanation" => $this->_explanation, "pattern" => $this->_pattern);
      if(isset($me['id']))
        DB_doquer("UPDATE `rule` SET `pattern`='".addslashes($me['pattern'])."' WHERE `i`='".addslashes($me['id'])."'", 5);
      // no code for pattern,i in pattern
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
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "source" => $this->_source, "target" => $this->_target, "violations" => $this->_violations, "explanation" => $this->_explanation, "pattern" => $this->_pattern);
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