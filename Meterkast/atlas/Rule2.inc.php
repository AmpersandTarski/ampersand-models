<?php // generated with ADL vs. 1.1-640
  
  /********* on line 251, file "src/atlas/atlas.adl"
    SERVICE Rule2 : I[MultiplicityRule]
   = [ eigenschap van relatie {"DISPLAY=Relation.display"} : on
     , overtredingen : violates~;display
     , uitleg : explanation;display
     , pattern {"DISPLAY=Pattern.display"} : on;pattern
     ]
   *********/
  
  class Rule2 {
    protected $id=false;
    protected $_new=true;
    private $_eigenschapvanrelatie;
    private $_overtredingen;
    private $_uitleg;
    private $_pattern;
    function Rule2($id=null, $_eigenschapvanrelatie=null, $_overtredingen=null, $_uitleg=null, $_pattern=null){
      $this->id=$id;
      $this->_eigenschapvanrelatie=$_eigenschapvanrelatie;
      $this->_overtredingen=$_overtredingen;
      $this->_uitleg=$_uitleg;
      $this->_pattern=$_pattern;
      if(!isset($_eigenschapvanrelatie) && isset($id)){
        // get a Rule2 based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttMultiplicityRule` AS `I`
                           FROM 
                              ( SELECT DISTINCT `I` AS `AttMultiplicityRule`, `I`
                                  FROM `MultiplicityRule`
                              ) AS fst
                          WHERE fst.`AttMultiplicityRule` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `MultiplicityRule`.`I` AS `id`
                                       , `MultiplicityRule`.`on` AS `eigenschap van relatie`
                                       , `f1`.`display` AS `uitleg`
                                       , `f2`.`pattern`
                                    FROM `MultiplicityRule`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`display`
                                                   FROM `MultiplicityRule` AS F0, `Explanation` AS F1
                                                  WHERE F0.`explanation`=F1.`I`
                                               ) AS f1
                                      ON `f1`.`I`='".addslashes($id)."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`pattern`
                                                   FROM `MultiplicityRule` AS F0, `Relation` AS F1
                                                  WHERE F0.`on`=F1.`I`
                                               ) AS f2
                                      ON `f2`.`I`='".addslashes($id)."'
                                   WHERE `MultiplicityRule`.`I`='".addslashes($id)."'"));
          $me['overtredingen']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `overtredingen`
                                                     FROM `MultiplicityRule`
                                                     JOIN  ( SELECT DISTINCT F0.`MultiplicityRule`, F1.`display`
                                                                    FROM `violates3` AS F0, `Violation` AS F1
                                                                   WHERE F0.`Violation`=F1.`I`
                                                                ) AS f1
                                                       ON `f1`.`MultiplicityRule`='".addslashes($id)."'
                                                    WHERE `MultiplicityRule`.`I`='".addslashes($id)."'"));
          $this->set_eigenschapvanrelatie($me['eigenschap van relatie']);
          $this->set_overtredingen($me['overtredingen']);
          $this->set_uitleg($me['uitleg']);
          $this->set_pattern($me['pattern']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttMultiplicityRule` AS `I`
                           FROM 
                              ( SELECT DISTINCT `I` AS `AttMultiplicityRule`, `I`
                                  FROM `MultiplicityRule`
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
      $me=array("id"=>$this->getId(), "eigenschap van relatie" => $this->_eigenschapvanrelatie, "overtredingen" => $this->_overtredingen, "uitleg" => $this->_uitleg, "pattern" => $this->_pattern);
      if(isset($me['id']))
        DB_doquer("UPDATE `MultiplicityRule` SET `on`='".addslashes($me['eigenschap van relatie'])."' WHERE `I`='".addslashes($me['id'])."'", 5);
      // no code for eigenschap van relatie,I in Relation
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
      $me=array("id"=>$this->getId(), "eigenschap van relatie" => $this->_eigenschapvanrelatie, "overtredingen" => $this->_overtredingen, "uitleg" => $this->_uitleg, "pattern" => $this->_pattern);
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
    function set_eigenschapvanrelatie($val){
      $this->_eigenschapvanrelatie=$val;
    }
    function get_eigenschapvanrelatie(){
      return $this->_eigenschapvanrelatie;
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

  function getEachRule2(){
    return firstCol(DB_doquer('SELECT DISTINCT `I`
                                 FROM `MultiplicityRule`'));
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