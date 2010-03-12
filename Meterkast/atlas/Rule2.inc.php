<?php // generated with ADL vs. 1.1-632
  
  /********* on line 247, file "src/atlas/atlas.adl"
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
                                       , `multiplicityrule`.`on` AS `eigenschap van relatie`
                                       , `f1`.`display` AS `uitleg`
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
          $me['overtredingen']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `overtredingen`
                                                     FROM `multiplicityrule`
                                                     JOIN  ( SELECT DISTINCT F0.`multiplicityrule`, F1.`display`
                                                                    FROM `violatesmultiplicityrule` AS F0, `violation` AS F1
                                                                   WHERE F0.`violation`=F1.`i`
                                                                ) AS f1
                                                       ON `f1`.`multiplicityrule`='".addslashes($id)."'
                                                    WHERE `multiplicityrule`.`i`='".addslashes($id)."'"));
          $this->set_eigenschapvanrelatie($me['eigenschap van relatie']);
          $this->set_overtredingen($me['overtredingen']);
          $this->set_uitleg($me['uitleg']);
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
      $me=array("id"=>$this->getId(), "eigenschap van relatie" => $this->_eigenschapvanrelatie, "overtredingen" => $this->_overtredingen, "uitleg" => $this->_uitleg, "pattern" => $this->_pattern);
      if(isset($me['id']))
        DB_doquer("UPDATE `multiplicityrule` SET `on`='".addslashes($me['eigenschap van relatie'])."' WHERE `i`='".addslashes($me['id'])."'", 5);
      // no code for eigenschap van relatie,i in relation
      // no code for pattern,i in pattern
      foreach($me['overtredingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['uitleg'])."'",5);
      foreach($me['overtredingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($me['uitleg'])."')", 5);
      $res=DB_doquer("INSERT IGNORE INTO `relvar` (`i`) VALUES ('".addslashes($me['eigenschap van relatie'])."')", 5);
      $res=DB_doquer("INSERT IGNORE INTO `contains` (`i`) VALUES ('".addslashes($me['eigenschap van relatie'])."')", 5);
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