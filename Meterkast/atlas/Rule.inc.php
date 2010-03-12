<?php // generated with ADL vs. 1.1-632
  
  /********* on line 230, file "src/atlas/atlas.adl"
    SERVICE Rule : I[Rule]
   = [ source {"DISPLAY=Concept.display"} : type;source
     , target {"DISPLAY=Concept.display"} : type;target
     , overtredingen : violates~;display
     , uitleg : explanation;display
     , pattern {"DISPLAY=Pattern.display"} : pattern
     ]
   *********/
  
  class Rule {
    protected $id=false;
    protected $_new=true;
    private $_source;
    private $_target;
    private $_overtredingen;
    private $_uitleg;
    private $_pattern;
    function Rule($id=null, $_source=null, $_target=null, $_overtredingen=null, $_uitleg=null, $_pattern=null){
      $this->id=$id;
      $this->_source=$_source;
      $this->_target=$_target;
      $this->_overtredingen=$_overtredingen;
      $this->_uitleg=$_uitleg;
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
                                       , `f3`.`display` AS `uitleg`
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
          $me['overtredingen']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `overtredingen`
                                                     FROM `rule`
                                                     JOIN  ( SELECT DISTINCT F0.`rule`, F1.`display`
                                                                    FROM `violates` AS F0, `violation` AS F1
                                                                   WHERE F0.`violation`=F1.`i`
                                                                ) AS f1
                                                       ON `f1`.`rule`='".addslashes($id)."'
                                                    WHERE `rule`.`i`='".addslashes($id)."'"));
          $this->set_source($me['source']);
          $this->set_target($me['target']);
          $this->set_overtredingen($me['overtredingen']);
          $this->set_uitleg($me['uitleg']);
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
      $me=array("id"=>$this->getId(), "source" => $this->_source, "target" => $this->_target, "overtredingen" => $this->_overtredingen, "uitleg" => $this->_uitleg, "pattern" => $this->_pattern);
      if(isset($me['id']))
        DB_doquer("UPDATE `rule` SET `pattern`='".addslashes($me['pattern'])."' WHERE `i`='".addslashes($me['id'])."'", 5);
      // no code for source,i in concept
      // no code for target,i in concept
      // no code for pattern,i in pattern
      foreach($me['overtredingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['uitleg'])."'",5);
      foreach($me['overtredingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($me['uitleg'])."')", 5);
      $res=DB_doquer("INSERT IGNORE INTO `containsconcept` (`i`) VALUES ('".addslashes($me['source'])."')", 5);
      $res=DB_doquer("INSERT IGNORE INTO `containsconcept` (`i`) VALUES ('".addslashes($me['target'])."')", 5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "source" => $this->_source, "target" => $this->_target, "overtredingen" => $this->_overtredingen, "uitleg" => $this->_uitleg, "pattern" => $this->_pattern);
      foreach($me['overtredingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['uitleg'])."'",5);
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
    function set_overtredingen($val){
      $this->_overtredingen=$val;
    }
    function get_overtredingen(){
      if(!isset($this->_overtredingen)) return array();
      return $this->_overtredingen;
    }
    function set_uitleg($val){
      $this->_uitleg=$val;
    }
    function get_uitleg(){
      return $this->_uitleg;
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