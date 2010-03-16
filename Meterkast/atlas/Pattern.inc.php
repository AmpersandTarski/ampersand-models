<?php // generated with ADL vs. 1.1-640
  
  /********* on line 204, file "src/atlas/atlas.adl"
    SERVICE Pattern : I[Pattern]
   = [ regels {"DISPLAY=UserRule.display"} : pattern~
     , relaties {"DISPLAY=Relation.display"} : pattern~
     , Conceptueel diagram {PICTURE} : picture;display
     ]
   *********/
  
  class Pattern {
    protected $id=false;
    protected $_new=true;
    private $_regels;
    private $_relaties;
    private $_Conceptueeldiagram;
    function Pattern($id=null, $_regels=null, $_relaties=null, $_Conceptueeldiagram=null){
      $this->id=$id;
      $this->_regels=$_regels;
      $this->_relaties=$_relaties;
      $this->_Conceptueeldiagram=$_Conceptueeldiagram;
      if(!isset($_regels) && isset($id)){
        // get a Pattern based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttPattern` AS `I`
                           FROM 
                              ( SELECT DISTINCT `I` AS `AttPattern`, `I`
                                  FROM `Pattern`
                              ) AS fst
                          WHERE fst.`AttPattern` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `Pattern`.`I` AS `id`
                                       , `f1`.`display` AS `Conceptueel diagram`
                                    FROM `Pattern`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`display`
                                                   FROM `Pattern` AS F0, `Picture` AS F1
                                                  WHERE F0.`picture`=F1.`I`
                                               ) AS f1
                                      ON `f1`.`I`='".addslashes($id)."'
                                   WHERE `Pattern`.`I`='".addslashes($id)."'"));
          $me['regels']=firstCol(DB_doquer("SELECT DISTINCT `UserRule`.`I` AS `regels`
                                              FROM `UserRule`
                                             WHERE `UserRule`.`pattern`='".addslashes($id)."'"));
          $me['relaties']=firstCol(DB_doquer("SELECT DISTINCT `Relation`.`I` AS `relaties`
                                                FROM `Relation`
                                               WHERE `Relation`.`pattern`='".addslashes($id)."'"));
          $this->set_regels($me['regels']);
          $this->set_relaties($me['relaties']);
          $this->set_Conceptueeldiagram($me['Conceptueel diagram']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttPattern` AS `I`
                           FROM 
                              ( SELECT DISTINCT `I` AS `AttPattern`, `I`
                                  FROM `Pattern`
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
      $me=array("id"=>$this->getId(), "regels" => $this->_regels, "relaties" => $this->_relaties, "Conceptueel diagram" => $this->_Conceptueeldiagram);
      // no code for regels,I in UserRule
      foreach  ($me['regels'] as $regels){
        if(isset($me['id']))
          DB_doquer("UPDATE `UserRule` SET `pattern`='".addslashes($me['id'])."' WHERE `I`='".addslashes($regels)."'", 5);
      }
      // no code for relaties,I in Relation
      foreach  ($me['relaties'] as $relaties){
        if(isset($me['id']))
          DB_doquer("UPDATE `Relation` SET `pattern`='".addslashes($me['id'])."' WHERE `I`='".addslashes($relaties)."'", 5);
      }
      DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($me['Conceptueel diagram'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($me['Conceptueel diagram'])."')", 5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "regels" => $this->_regels, "relaties" => $this->_relaties, "Conceptueel diagram" => $this->_Conceptueeldiagram);
      DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($me['Conceptueel diagram'])."'",5);
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
    return firstCol(DB_doquer('SELECT DISTINCT `I`
                                 FROM `Pattern`'));
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