<?php // generated with ADL vs. 0.8.10-490
  
  /********* on line 203, file "atlas.adl"
    SERVICE Relations : I[ONE]
   = [ Relation_s : V;(user;s;user~/\script;s;script~)
        = [ name : display
          ]
     ]
   *********/
  
  class Relations {
    private $_Relations;
    function Relations($_Relations=null){
      $this->_Relations=$_Relations;
      if(!isset($_Relations)){
        // get a Relations based on its identifier
        // fill the attributes
        $me=array();
        $me['Relation_s']=(DB_doquer("SELECT DISTINCT `f1`.`i` AS `id`
                                        FROM  ( SELECT DISTINCT fst.`i`
                                                  FROM 
                                                     ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `Relation` AS TODO WHERE TODO.`User`='".$GLOBALS['ctxenv']['User']."'AND TODO.`Script`='".$GLOBALS['ctxenv']['Script']."'
                                                     ) AS fst
                                                 WHERE fst.`i` IS NOT NULL
                                              ) AS f1"));
        foreach($me['Relation_s'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , `f2`.`display` AS `name`
                                    FROM `relation`
                                    LEFT JOIN `relation` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                   WHERE `relation`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Relations($me['Relation_s']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $me=array("id"=>1, "Relation_s" => $this->_Relations);
      foreach($me['Relation_s'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `relation` SET `display`='".addslashes($v0['name'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
      }
      foreach($me['Relation_s'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['name'])."'",5);
      }
      foreach($me['Relation_s'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['name'])."')", 5);
      }
      if (!checkRule13()){
        $DB_err='\"on[MultiplicityRule*Relation] is univalent\"';
      } else
      if (!checkRule17()){
        $DB_err='\"on[HomogeneousRule*Relation] is univalent\"';
      } else
      if (!checkRule37()){
        $DB_err='\"user[Relation*User] is univalent\"';
      } else
      if (!checkRule38()){
        $DB_err='\"user[Relation*User] is total\"';
      } else
      if (!checkRule65()){
        $DB_err='\"script[Relation*Script] is univalent\"';
      } else
      if (!checkRule66()){
        $DB_err='\"script[Relation*Script] is total\"';
      } else
      if (!checkRule91()){
        $DB_err='\"display[Picture*String] is univalent\"';
      } else
      if (!checkRule93()){
        $DB_err='\"display[Relation*String] is univalent\"';
      } else
      if (!checkRule94()){
        $DB_err='\"display[Relation*String] is total\"';
      } else
      if (!checkRule95()){
        $DB_err='\"display[Type*String] is univalent\"';
      } else
      if (!checkRule97()){
        $DB_err='\"display[Pair*String] is univalent\"';
      } else
      if (!checkRule99()){
        $DB_err='\"display[Concept*String] is univalent\"';
      } else
      if (!checkRule101()){
        $DB_err='\"display[Atom*String] is univalent\"';
      } else
      if (!checkRule103()){
        $DB_err='\"display[IsaRelation*String] is univalent\"';
      } else
      if (!checkRule105()){
        $DB_err='\"display[MultiplicityRule*String] is univalent\"';
      } else
      if (!checkRule107()){
        $DB_err='\"display[HomogeneousRule*String] is univalent\"';
      } else
      if (!checkRule109()){
        $DB_err='\"display[Prop*String] is univalent\"';
      } else
      if (!checkRule111()){
        $DB_err='\"display[UserRule*String] is univalent\"';
      } else
      if (!checkRule113()){
        $DB_err='\"display[Rule*String] is univalent\"';
      } else
      if (!checkRule115()){
        $DB_err='\"display[Violation*String] is univalent\"';
      } else
      if (!checkRule117()){
        $DB_err='\"display[Explanation*String] is univalent\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Relations($val){
      $this->_Relations=$val;
    }
    function get_Relations(){
      if(!isset($this->_Relations)) return array();
      return $this->_Relations;
    }
  }

?>