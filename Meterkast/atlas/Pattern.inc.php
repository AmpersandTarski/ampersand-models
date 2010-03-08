<?php // generated with ADL vs. 1.0-632
  
  /********* on line 203, file "src/atlas/atlas.adl"
    SERVICE Pattern : I[Pattern]
   = [ regels {"DISPLAY=UserRule.display"} : pattern~
     , relaties {"DISPLAY=Relation.display"} : pattern~
     , isa-relaties : pattern~;display
     , Conceptueel diagram {PICTURE} : picture;display
     ]
   *********/
  
  class Pattern {
    protected $id=false;
    protected $_new=true;
    private $_regels;
    private $_relaties;
    private $_isarelaties;
    private $_Conceptueeldiagram;
    function Pattern($id=null, $_regels=null, $_relaties=null, $_isarelaties=null, $_Conceptueeldiagram=null){
      $this->id=$id;
      $this->_regels=$_regels;
      $this->_relaties=$_relaties;
      $this->_isarelaties=$_isarelaties;
      $this->_Conceptueeldiagram=$_Conceptueeldiagram;
      if(!isset($_regels) && isset($id)){
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
                                       , `f1`.`display` AS `Conceptueel diagram`
                                    FROM `pattern`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `pattern` AS F0, `picture` AS F1
                                                  WHERE F0.`picture`=F1.`i`
                                               ) AS f1
                                      ON `f1`.`i`='".addslashes($id)."'
                                   WHERE `pattern`.`i`='".addslashes($id)."'"));
          $me['regels']=firstCol(DB_doquer("SELECT DISTINCT `userrule`.`i` AS `regels`
                                              FROM `userrule`
                                             WHERE `userrule`.`pattern`='".addslashes($id)."'"));
          $me['relaties']=firstCol(DB_doquer("SELECT DISTINCT `relation`.`i` AS `relaties`
                                                FROM `relation`
                                               WHERE `relation`.`pattern`='".addslashes($id)."'"));
          $me['isa-relaties']=firstCol(DB_doquer("SELECT DISTINCT `isarelation`.`display` AS `isa-relaties`
                                                    FROM `isarelation`
                                                   WHERE `isarelation`.`pattern`='".addslashes($id)."'"));
          $this->set_regels($me['regels']);
          $this->set_relaties($me['relaties']);
          $this->set_isarelaties($me['isa-relaties']);
          $this->set_Conceptueeldiagram($me['Conceptueel diagram']);
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
      $me=array("id"=>$this->getId(), "regels" => $this->_regels, "relaties" => $this->_relaties, "isa-relaties" => $this->_isarelaties, "Conceptueel diagram" => $this->_Conceptueeldiagram);
      // no code for regels,i in userrule
      foreach  ($me['regels'] as $regels){
        if(isset($me['id']))
          DB_doquer("UPDATE `userrule` SET `pattern`='".addslashes($me['id'])."' WHERE `i`='".addslashes($regels)."'", 5);
      }
      // no code for relaties,i in relation
      foreach  ($me['relaties'] as $relaties){
        if(isset($me['id']))
          DB_doquer("UPDATE `relation` SET `pattern`='".addslashes($me['id'])."' WHERE `i`='".addslashes($relaties)."'", 5);
      }
      // no code for Pattern,pattern in isarelation
      foreach($me['isa-relaties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['Conceptueel diagram'])."'",5);
      foreach($me['isa-relaties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($me['Conceptueel diagram'])."')", 5);
      foreach($me['relaties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `relvar` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['relaties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `contains` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['regels'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `morphisms` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "regels" => $this->_regels, "relaties" => $this->_relaties, "isa-relaties" => $this->_isarelaties, "Conceptueel diagram" => $this->_Conceptueeldiagram);
      foreach($me['isa-relaties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['Conceptueel diagram'])."'",5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_regels($val){
      $this->_regels=$val;
    }
    function get_regels(){
      if(!isset($this->_regels)) return array();
      return $this->_regels;
    }
    function set_relaties($val){
      $this->_relaties=$val;
    }
    function get_relaties(){
      if(!isset($this->_relaties)) return array();
      return $this->_relaties;
    }
    function set_isarelaties($val){
      $this->_isarelaties=$val;
    }
    function get_isarelaties(){
      if(!isset($this->_isarelaties)) return array();
      return $this->_isarelaties;
    }
    function set_Conceptueeldiagram($val){
      $this->_Conceptueeldiagram=$val;
    }
    function get_Conceptueeldiagram(){
      return $this->_Conceptueeldiagram;
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