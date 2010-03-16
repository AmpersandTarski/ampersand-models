<?php // generated with ADL vs. 1.1-640
  
  /********* on line 234, file "src/atlas/atlas.adl"
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
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttRule` AS `I`
                           FROM 
                              ( SELECT DISTINCT `I` AS `AttRule`, `I`
                                  FROM `Rule`
                              ) AS fst
                          WHERE fst.`AttRule` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `Rule`.`I` AS `id`
                                       , `Rule`.`pattern`
                                       , `f1`.`source`
                                       , `f2`.`target`
                                       , `f3`.`display` AS `uitleg`
                                    FROM `Rule`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`source`
                                                   FROM `Rule` AS F0, `Type` AS F1
                                                  WHERE F0.`type`=F1.`I`
                                               ) AS f1
                                      ON `f1`.`I`='".addslashes($id)."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`target`
                                                   FROM `Rule` AS F0, `Type` AS F1
                                                  WHERE F0.`type`=F1.`I`
                                               ) AS f2
                                      ON `f2`.`I`='".addslashes($id)."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`display`
                                                   FROM `Rule` AS F0, `Explanation` AS F1
                                                  WHERE F0.`explanation`=F1.`I`
                                               ) AS f3
                                      ON `f3`.`I`='".addslashes($id)."'
                                   WHERE `Rule`.`I`='".addslashes($id)."'"));
          $me['overtredingen']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `overtredingen`
                                                     FROM `Rule`
                                                     JOIN  ( SELECT DISTINCT F0.`Rule`, F1.`display`
                                                                    FROM `violates1` AS F0, `Violation` AS F1
                                                                   WHERE F0.`Violation`=F1.`I`
                                                                ) AS f1
                                                       ON `f1`.`Rule`='".addslashes($id)."'
                                                    WHERE `Rule`.`I`='".addslashes($id)."'"));
          $this->set_source($me['source']);
          $this->set_target($me['target']);
          $this->set_overtredingen($me['overtredingen']);
          $this->set_uitleg($me['uitleg']);
          $this->set_pattern($me['pattern']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttRule` AS `I`
                           FROM 
                              ( SELECT DISTINCT `I` AS `AttRule`, `I`
                                  FROM `Rule`
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
        DB_doquer("UPDATE `Rule` SET `pattern`='".addslashes($me['pattern'])."' WHERE `I`='".addslashes($me['id'])."'", 5);
      // no code for source,I in Concept
      // no code for target,I in Concept
      // no code for pattern,I in Pattern
      foreach($me['overtredingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($me['uitleg'])."'",5);
      foreach($me['overtredingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($v0)."')", 5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($me['uitleg'])."')", 5);
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
        DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($me['uitleg'])."'",5);
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
    return firstCol(DB_doquer('SELECT DISTINCT `I`
                                 FROM `Rule`'));
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