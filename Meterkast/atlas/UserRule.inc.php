<?php // generated with ADL vs. 1.1-640
  
  /********* on line 240, file "src/atlas/atlas.adl"
    SERVICE UserRule : I[UserRule]
   = [ uitleg : explanation;display
     , overtredingen : violates~;display
     , populatie van subexpressies {"DISPLAY=SubExpression.display"} : subexpressionOf~
     , relaties {"DISPLAY=Relation.display"} : morphisms
     , source {"DISPLAY=Concept.display"} : type;source
     , target {"DISPLAY=Concept.display"} : type;target
     , ga naar pattern {"DISPLAY=Pattern.display"} : pattern
     , ga naar vorige regel {"DISPLAY=UserRule.display"} : previous
     , ga naar volgende regel {"DISPLAY=UserRule.display"} : next
     , Conceptueel diagram {PICTURE} : picture;display
     ]
   *********/
  
  class UserRule {
    protected $id=false;
    protected $_new=true;
    private $_uitleg;
    private $_overtredingen;
    private $_populatievansubexpressies;
    private $_relaties;
    private $_source;
    private $_target;
    private $_ganaarpattern;
    private $_ganaarvorigeregel;
    private $_ganaarvolgenderegel;
    private $_Conceptueeldiagram;
    function UserRule($id=null, $_uitleg=null, $_overtredingen=null, $_populatievansubexpressies=null, $_relaties=null, $_source=null, $_target=null, $_ganaarpattern=null, $_ganaarvorigeregel=null, $_ganaarvolgenderegel=null, $_Conceptueeldiagram=null){
      $this->id=$id;
      $this->_uitleg=$_uitleg;
      $this->_overtredingen=$_overtredingen;
      $this->_populatievansubexpressies=$_populatievansubexpressies;
      $this->_relaties=$_relaties;
      $this->_source=$_source;
      $this->_target=$_target;
      $this->_ganaarpattern=$_ganaarpattern;
      $this->_ganaarvorigeregel=$_ganaarvorigeregel;
      $this->_ganaarvolgenderegel=$_ganaarvolgenderegel;
      $this->_Conceptueeldiagram=$_Conceptueeldiagram;
      if(!isset($_uitleg) && isset($id)){
        // get a UserRule based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttUserRule` AS `I`
                           FROM 
                              ( SELECT DISTINCT `I` AS `AttUserRule`, `I`
                                  FROM `UserRule`
                              ) AS fst
                          WHERE fst.`AttUserRule` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `UserRule`.`I` AS `id`
                                       , `UserRule`.`pattern` AS `ga naar pattern`
                                       , `UserRule`.`previous` AS `ga naar vorige regel`
                                       , `UserRule`.`next` AS `ga naar volgende regel`
                                       , `f1`.`display` AS `uitleg`
                                       , `f2`.`source`
                                       , `f3`.`target`
                                       , `f4`.`display` AS `Conceptueel diagram`
                                    FROM `UserRule`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`display`
                                                   FROM `UserRule` AS F0, `Explanation` AS F1
                                                  WHERE F0.`explanation`=F1.`I`
                                               ) AS f1
                                      ON `f1`.`I`='".addslashes($id)."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`source`
                                                   FROM `UserRule` AS F0, `Type` AS F1
                                                  WHERE F0.`type`=F1.`I`
                                               ) AS f2
                                      ON `f2`.`I`='".addslashes($id)."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`target`
                                                   FROM `UserRule` AS F0, `Type` AS F1
                                                  WHERE F0.`type`=F1.`I`
                                               ) AS f3
                                      ON `f3`.`I`='".addslashes($id)."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`display`
                                                   FROM `UserRule` AS F0, `Picture` AS F1
                                                  WHERE F0.`picture`=F1.`I`
                                               ) AS f4
                                      ON `f4`.`I`='".addslashes($id)."'
                                   WHERE `UserRule`.`I`='".addslashes($id)."'"));
          $me['overtredingen']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `overtredingen`
                                                     FROM `UserRule`
                                                     JOIN  ( SELECT DISTINCT F0.`UserRule`, F1.`display`
                                                                    FROM `violates2` AS F0, `Violation` AS F1
                                                                   WHERE F0.`Violation`=F1.`I`
                                                                ) AS f1
                                                       ON `f1`.`UserRule`='".addslashes($id)."'
                                                    WHERE `UserRule`.`I`='".addslashes($id)."'"));
          $me['populatie van subexpressies']=firstCol(DB_doquer("SELECT DISTINCT `SubExpression`.`I` AS `populatie van subexpressies`
                                                                   FROM `SubExpression`
                                                                  WHERE `SubExpression`.`subexpressionOf`='".addslashes($id)."'"));
          $me['relaties']=firstCol(DB_doquer("SELECT DISTINCT `morphisms1`.`Relation` AS `relaties`
                                                FROM `UserRule`
                                                JOIN `morphisms1` ON `morphisms1`.`UserRule`='".addslashes($id)."'
                                               WHERE `UserRule`.`I`='".addslashes($id)."'"));
          $this->set_uitleg($me['uitleg']);
          $this->set_overtredingen($me['overtredingen']);
          $this->set_populatievansubexpressies($me['populatie van subexpressies']);
          $this->set_relaties($me['relaties']);
          $this->set_source($me['source']);
          $this->set_target($me['target']);
          $this->set_ganaarpattern($me['ga naar pattern']);
          $this->set_ganaarvorigeregel($me['ga naar vorige regel']);
          $this->set_ganaarvolgenderegel($me['ga naar volgende regel']);
          $this->set_Conceptueeldiagram($me['Conceptueel diagram']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttUserRule` AS `I`
                           FROM 
                              ( SELECT DISTINCT `I` AS `AttUserRule`, `I`
                                  FROM `UserRule`
                              ) AS fst
                          WHERE fst.`AttUserRule` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "uitleg" => $this->_uitleg, "overtredingen" => $this->_overtredingen, "populatie van subexpressies" => $this->_populatievansubexpressies, "relaties" => $this->_relaties, "source" => $this->_source, "target" => $this->_target, "ga naar pattern" => $this->_ganaarpattern, "ga naar vorige regel" => $this->_ganaarvorigeregel, "ga naar volgende regel" => $this->_ganaarvolgenderegel, "Conceptueel diagram" => $this->_Conceptueeldiagram);
      if(isset($me['id']))
        DB_doquer("UPDATE `UserRule` SET `pattern`='".addslashes($me['ga naar pattern'])."', `previous`='".addslashes($me['ga naar vorige regel'])."', `next`='".addslashes($me['ga naar volgende regel'])."' WHERE `I`='".addslashes($me['id'])."'", 5);
      // no code for ga naar vorige regel,I in UserRule
      // no code for ga naar volgende regel,I in UserRule
      // no code for relaties,I in Relation
      // no code for source,I in Concept
      // no code for target,I in Concept
      // no code for populatie van subexpressies,I in SubExpression
      foreach  ($me['populatie van subexpressies'] as $populatievansubexpressies){
        if(isset($me['id']))
          DB_doquer("UPDATE `SubExpression` SET `subexpressionOf`='".addslashes($me['id'])."' WHERE `I`='".addslashes($populatievansubexpressies)."'", 5);
      }
      // no code for ga naar pattern,I in Pattern
      DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($me['uitleg'])."'",5);
      foreach($me['overtredingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($me['Conceptueel diagram'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($me['uitleg'])."')", 5);
      foreach($me['overtredingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($v0)."')", 5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($me['Conceptueel diagram'])."')", 5);
      DB_doquer("DELETE FROM `morphisms1` WHERE `UserRule`='".addslashes($me['id'])."'",5);
      if(count($me['relaties'])==0) $me['relaties'][] = null;
      foreach  ($me['relaties'] as $relaties){
        $res=DB_doquer("INSERT IGNORE INTO `morphisms1` (`Relation`,`UserRule`) VALUES (".((null!=$relaties)?"'".addslashes($relaties)."'":"NULL").", ".((null!=$me['id'])?"'".addslashes($me['id'])."'":"NULL").")", 5);
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
      $me=array("id"=>$this->getId(), "uitleg" => $this->_uitleg, "overtredingen" => $this->_overtredingen, "populatie van subexpressies" => $this->_populatievansubexpressies, "relaties" => $this->_relaties, "source" => $this->_source, "target" => $this->_target, "ga naar pattern" => $this->_ganaarpattern, "ga naar vorige regel" => $this->_ganaarvorigeregel, "ga naar volgende regel" => $this->_ganaarvolgenderegel, "Conceptueel diagram" => $this->_Conceptueeldiagram);
      DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($me['uitleg'])."'",5);
      foreach($me['overtredingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($me['Conceptueel diagram'])."'",5);
      DB_doquer("DELETE FROM `morphisms1` WHERE `UserRule`='".addslashes($me['id'])."'",5);
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_uitleg($val){
      $this->_uitleg=$val;
    }
    function get_uitleg(){
      return $this->_uitleg;
    }
    function set_overtredingen($val){
      $this->_overtredingen=$val;
    }
    function get_overtredingen(){
      if(!isset($this->_overtredingen)) return array();
      return $this->_overtredingen;
    }
    function set_populatievansubexpressies($val){
      $this->_populatievansubexpressies=$val;
    }
    function get_populatievansubexpressies(){
      if(!isset($this->_populatievansubexpressies)) return array();
      return $this->_populatievansubexpressies;
    }
    function set_relaties($val){
      $this->_relaties=$val;
    }
    function get_relaties(){
      if(!isset($this->_relaties)) return array();
      return $this->_relaties;
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
    function set_ganaarpattern($val){
      $this->_ganaarpattern=$val;
    }
    function get_ganaarpattern(){
      return $this->_ganaarpattern;
    }
    function set_ganaarvorigeregel($val){
      $this->_ganaarvorigeregel=$val;
    }
    function get_ganaarvorigeregel(){
      return $this->_ganaarvorigeregel;
    }
    function set_ganaarvolgenderegel($val){
      $this->_ganaarvolgenderegel=$val;
    }
    function get_ganaarvolgenderegel(){
      return $this->_ganaarvolgenderegel;
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

  function getEachUserRule(){
    return firstCol(DB_doquer('SELECT DISTINCT `I`
                                 FROM `UserRule`'));
  }

  function readUserRule($id){
      // check existence of $id
      $obj = new UserRule($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delUserRule($id){
    $tobeDeleted = new UserRule($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>