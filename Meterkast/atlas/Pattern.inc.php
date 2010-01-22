<?php // generated with ADL vs. 0.8.10-558
  
  /********* on line 190, file "comp/PWO_gmi/434.adl"
    SERVICE Pattern : I[Pattern]
   = [ signals {"DISPLAY=Signal.display"} : pattern~
     , rules {"DISPLAY=UserRule.display"} : pattern~
     , relations {"DISPLAY=Relation.display"} : pattern~
     , isa_relations : pattern~;display
     , Conceptual diagram {PICTURE} : picture;display
     ]
   *********/
  
  class Pattern {
    protected $id=false;
    protected $_new=true;
    private $_signals;
    private $_rules;
    private $_relations;
    private $_isarelations;
    private $_Conceptualdiagram;
    function Pattern($id=null, $_signals=null, $_rules=null, $_relations=null, $_isarelations=null, $_Conceptualdiagram=null){
      $this->id=$id;
      $this->_signals=$_signals;
      $this->_rules=$_rules;
      $this->_relations=$_relations;
      $this->_isarelations=$_isarelations;
      $this->_Conceptualdiagram=$_Conceptualdiagram;
      if(!isset($_signals) && isset($id)){
        // get a Pattern based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttPattern` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttPattern`, `i`
                                  FROM `pattern`
                              ) AS fst
                          WHERE fst.`AttPattern` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `pattern`.`i` AS `id`
                                       , `f1`.`display` AS `Conceptual diagram`
                                    FROM `pattern`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `pattern` AS F0, `picture` AS F1
                                                  WHERE F0.`picture`=F1.`i`
                                               ) AS f1
                                      ON `f1`.`i`='".addslashes($id)."'
                                   WHERE `pattern`.`i`='".addslashes($id)."'"));
          $me['signals']=firstCol(DB_doquer("SELECT DISTINCT `signal`.`i` AS `signals`
                                               FROM `signal`
                                              WHERE `signal`.`pattern`='".addslashes($id)."'"));
          $me['rules']=firstCol(DB_doquer("SELECT DISTINCT `userrule`.`i` AS `rules`
                                             FROM `userrule`
                                            WHERE `userrule`.`pattern`='".addslashes($id)."'"));
          $me['relations']=firstCol(DB_doquer("SELECT DISTINCT `relation`.`i` AS `relations`
                                                 FROM `relation`
                                                WHERE `relation`.`pattern`='".addslashes($id)."'"));
          $me['isa_relations']=firstCol(DB_doquer("SELECT DISTINCT `isarelation`.`display` AS `isa_relations`
                                                     FROM `isarelation`
                                                    WHERE `isarelation`.`pattern`='".addslashes($id)."'"));
          $this->set_signals($me['signals']);
          $this->set_rules($me['rules']);
          $this->set_relations($me['relations']);
          $this->set_isarelations($me['isa_relations']);
          $this->set_Conceptualdiagram($me['Conceptual diagram']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttPattern` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttPattern`, `i`
                                  FROM `pattern`
                              ) AS fst
                          WHERE fst.`AttPattern` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "signals" => $this->_signals, "rules" => $this->_rules, "relations" => $this->_relations, "isa_relations" => $this->_isarelations, "Conceptual diagram" => $this->_Conceptualdiagram);
      // no code for rules,i in userrule
      foreach  ($me['rules'] as $rules){
        if(isset($me['id']))
          DB_doquer("UPDATE `userrule` SET `pattern`='".addslashes($me['id'])."' WHERE `i`='".addslashes($rules)."'", 5);
      }
      // no code for signals,i in signal
      foreach  ($me['signals'] as $signals){
        if(isset($me['id']))
          DB_doquer("UPDATE `signal` SET `pattern`='".addslashes($me['id'])."' WHERE `i`='".addslashes($signals)."'", 5);
      }
      // no code for relations,i in relation
      foreach  ($me['relations'] as $relations){
        if(isset($me['id']))
          DB_doquer("UPDATE `relation` SET `pattern`='".addslashes($me['id'])."' WHERE `i`='".addslashes($relations)."'", 5);
      }
      // no code for Pattern,pattern in isarelation
      foreach($me['isa_relations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['Conceptual diagram'])."'",5);
      foreach($me['isa_relations'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($me['Conceptual diagram'])."')", 5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "signals" => $this->_signals, "rules" => $this->_rules, "relations" => $this->_relations, "isa_relations" => $this->_isarelations, "Conceptual diagram" => $this->_Conceptualdiagram);
      foreach($me['isa_relations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['Conceptual diagram'])."'",5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_signals($val){
      $this->_signals=$val;
    }
    function get_signals(){
      if(!isset($this->_signals)) return array();
      return $this->_signals;
    }
    function set_rules($val){
      $this->_rules=$val;
    }
    function get_rules(){
      if(!isset($this->_rules)) return array();
      return $this->_rules;
    }
    function set_relations($val){
      $this->_relations=$val;
    }
    function get_relations(){
      if(!isset($this->_relations)) return array();
      return $this->_relations;
    }
    function set_isarelations($val){
      $this->_isarelations=$val;
    }
    function get_isarelations(){
      if(!isset($this->_isarelations)) return array();
      return $this->_isarelations;
    }
    function set_Conceptualdiagram($val){
      $this->_Conceptualdiagram=$val;
    }
    function get_Conceptualdiagram(){
      return $this->_Conceptualdiagram;
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

  function getEachPattern(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `pattern`'));
  }

  function readPattern($id){
      // check existence of $id
      $obj = new Pattern($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delPattern($id){
    $tobeDeleted = new Pattern($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>