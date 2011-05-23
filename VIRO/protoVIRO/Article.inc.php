<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 832, file "VIRO453ENG.adl"
    SERVICE Article : I[Article]
   = [ text : lawText
     , act : act
     , organ : organ
     , verb : verb
     , object type : objectType
     ]
   *********/
  
  class Article {
    protected $_id=false;
    protected $_new=true;
    private $_text;
    private $_act;
    private $_organ;
    private $_verb;
    private $_objecttype;
    function Article($id=null, $text=null, $act=null, $organ=null, $verb=null, $objecttype=null){
      $this->_id=$id;
      $this->_text=$text;
      $this->_act=$act;
      $this->_organ=$organ;
      $this->_verb=$verb;
      $this->_objecttype=$objecttype;
      if(!isset($text) && isset($id)){
        // get a Article based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttArticle` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttArticle`, `i`
                                  FROM `article`
                              ) AS fst
                          WHERE fst.`AttArticle` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['text']=firstCol(DB_doquer("SELECT DISTINCT `lawtext`.`text`
                                            FROM `lawtext`
                                           WHERE `lawtext`.`article`='".addslashes($id)."'"));
          $me['act']=firstCol(DB_doquer("SELECT DISTINCT `actarticle`.`act`
                                           FROM `actarticle`
                                          WHERE `actarticle`.`article`='".addslashes($id)."'"));
          $me['organ']=firstCol(DB_doquer("SELECT DISTINCT `organarticle`.`organ`
                                             FROM `organarticle`
                                            WHERE `organarticle`.`article`='".addslashes($id)."'"));
          $me['verb']=firstCol(DB_doquer("SELECT DISTINCT `verbarticle`.`verb`
                                            FROM `verbarticle`
                                           WHERE `verbarticle`.`article`='".addslashes($id)."'"));
          $me['object type']=firstCol(DB_doquer("SELECT DISTINCT `objecttypearticle`.`objecttype` AS `object type`
                                                   FROM `objecttypearticle`
                                                  WHERE `objecttypearticle`.`article`='".addslashes($id)."'"));
          $this->set_text($me['text']);
          $this->set_act($me['act']);
          $this->set_organ($me['organ']);
          $this->set_verb($me['verb']);
          $this->set_objecttype($me['object type']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttArticle` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttArticle`, `i`
                                  FROM `article`
                              ) AS fst
                          WHERE fst.`AttArticle` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "text" => $this->_text, "act" => $this->_act, "organ" => $this->_organ, "verb" => $this->_verb, "object type" => $this->_objecttype);
      foreach($me['organ'] as $i0=>$v0){
        DB_doquer("DELETE FROM `organ` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['organ'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `organ` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['text'] as $i0=>$v0){
        DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['text'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `text` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['act'] as $i0=>$v0){
        DB_doquer("DELETE FROM `act` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['act'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `act` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['object type'] as $i0=>$v0){
        DB_doquer("DELETE FROM `objecttype` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['object type'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `objecttype` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['verb'] as $i0=>$v0){
        DB_doquer("DELETE FROM `verb` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['verb'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `verb` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      DB_doquer("DELETE FROM `lawtext` WHERE `article`='".addslashes($me['id'])."'",5);
      foreach  ($me['text'] as $text){
        $res=DB_doquer("INSERT IGNORE INTO `lawtext` (`text`,`article`) VALUES ('".addslashes($text)."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `actarticle` WHERE `article`='".addslashes($me['id'])."'",5);
      foreach  ($me['act'] as $act){
        $res=DB_doquer("INSERT IGNORE INTO `actarticle` (`act`,`article`) VALUES ('".addslashes($act)."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `organarticle` WHERE `article`='".addslashes($me['id'])."'",5);
      foreach  ($me['organ'] as $organ){
        $res=DB_doquer("INSERT IGNORE INTO `organarticle` (`organ`,`article`) VALUES ('".addslashes($organ)."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `verbarticle` WHERE `article`='".addslashes($me['id'])."'",5);
      foreach  ($me['verb'] as $verb){
        $res=DB_doquer("INSERT IGNORE INTO `verbarticle` (`verb`,`article`) VALUES ('".addslashes($verb)."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `objecttypearticle` WHERE `article`='".addslashes($me['id'])."'",5);
      foreach  ($me['object type'] as $objecttype){
        $res=DB_doquer("INSERT IGNORE INTO `objecttypearticle` (`objecttype`,`article`) VALUES ('".addslashes($objecttype)."', '".addslashes($me['id'])."')", 5);
      }
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat as vertegenwoordiger from het organ dat de act uitvoert\"';
      } else
      if (!checkRule10()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule59()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "text" => $this->_text, "act" => $this->_act, "organ" => $this->_organ, "verb" => $this->_verb, "object type" => $this->_objecttype);
      foreach($me['organ'] as $i0=>$v0){
        DB_doquer("DELETE FROM `organ` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['text'] as $i0=>$v0){
        DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['act'] as $i0=>$v0){
        DB_doquer("DELETE FROM `act` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['object type'] as $i0=>$v0){
        DB_doquer("DELETE FROM `objecttype` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['verb'] as $i0=>$v0){
        DB_doquer("DELETE FROM `verb` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `lawtext` WHERE `article`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `actarticle` WHERE `article`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `organarticle` WHERE `article`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `verbarticle` WHERE `article`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `objecttypearticle` WHERE `article`='".addslashes($me['id'])."'",5);
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat as vertegenwoordiger from het organ dat de act uitvoert\"';
      } else
      if (!checkRule10()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule59()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_text($val){
      $this->_text=$val;
    }
    function get_text(){
      if(!isset($this->_text)) return array();
      return $this->_text;
    }
    function set_act($val){
      $this->_act=$val;
    }
    function get_act(){
      if(!isset($this->_act)) return array();
      return $this->_act;
    }
    function set_organ($val){
      $this->_organ=$val;
    }
    function get_organ(){
      if(!isset($this->_organ)) return array();
      return $this->_organ;
    }
    function set_verb($val){
      $this->_verb=$val;
    }
    function get_verb(){
      if(!isset($this->_verb)) return array();
      return $this->_verb;
    }
    function set_objecttype($val){
      $this->_objecttype=$val;
    }
    function get_objecttype(){
      if(!isset($this->_objecttype)) return array();
      return $this->_objecttype;
    }
    function setId($id){
      $this->_id=$id;
      return $this->_id;
    }
    function getId(){
      if($this->_id===null) return false;
      return $this->_id;
    }
    function isNew(){
      return $this->_new;
    }
  }

  function getEachArticle(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `article`'));
  }

  function readArticle($id){
      // check existence of $id
      $obj = new Article($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delArticle($id){
    $tobeDeleted = new Article($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>