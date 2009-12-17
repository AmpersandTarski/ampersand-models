<?php // generated with ADL vs. 0.8.10-490
  
  /********* on line 218, file "atlas.adl"
    SERVICE Concepts : I[ONE]
   = [ Concept_s : V;(user;s;user~/\script;s;script~);display
     ]
   *********/
  
  class Concepts {
    private $_Concepts;
    function Concepts($_Concepts=null){
      $this->_Concepts=$_Concepts;
      if(!isset($_Concepts)){
        // get a Concepts based on its identifier
        // fill the attributes
        $me=array();
        $me['Concept_s']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `Concept_s`
                                               FROM  ( SELECT DISTINCT fst.`display`
                                                         FROM 
                                                            ( SELECT DISTINCT F0.`i`, F1.`display`
                                                                FROM 
                                                                   ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `Concept` AS TODO WHERE TODO.`User`='".$GLOBALS['ctxenv']['User']."'AND TODO.`Script`='".$GLOBALS['ctxenv']['Script']."'
                                                                   ) AS F0, `concept` AS F1
                                                               WHERE F0.`i1`=F1.`i`
                                                            ) AS fst
                                                        WHERE fst.`display` IS NOT NULL
                                                     ) AS f1"));
        $this->set_Concepts($me['Concept_s']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $me=array("id"=>1, "Concept_s" => $this->_Concepts);
      foreach($me['Concept_s'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['Concept_s'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      if (!checkRule43()){
        $DB_err='\"user[Concept*User] is univalent\"';
      } else
      if (!checkRule44()){
        $DB_err='\"user[Concept*User] is total\"';
      } else
      if (!checkRule71()){
        $DB_err='\"script[Concept*Script] is univalent\"';
      } else
      if (!checkRule72()){
        $DB_err='\"script[Concept*Script] is total\"';
      } else
      if (!checkRule91()){
        $DB_err='\"display[Picture*String] is univalent\"';
      } else
      if (!checkRule93()){
        $DB_err='\"display[Relation*String] is univalent\"';
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
      if (!checkRule100()){
        $DB_err='\"display[Concept*String] is total\"';
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
    function set_Concepts($val){
      $this->_Concepts=$val;
    }
    function get_Concepts(){
      if(!isset($this->_Concepts)) return array();
      return $this->_Concepts;
    }
  }

?>