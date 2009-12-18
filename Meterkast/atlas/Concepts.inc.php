<?php // generated with ADL vs. 0.8.10-493
  
  /********* on line 207, file "atlas.adl"
    SERVICE Concepts : I[ONE]
   = [ Concept_s {"DISPLAY=Concept.display"} : V;(user;s;user~/\script;s;script~)
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
        $me['Concept_s']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`i` AS `Concept_s`
                                               FROM  ( SELECT DISTINCT fst.`i`
                                                         FROM 
                                                            ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `Concept` AS TODO WHERE TODO.`User`='".$GLOBALS['ctxenv']['User']."'AND TODO.`Script`='".$GLOBALS['ctxenv']['Script']."'
                                                            ) AS fst
                                                        WHERE fst.`i` IS NOT NULL
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
      // no code for Concept_s,i in concept
      if (!checkRule3()){
        $DB_err='\"source[Type*Concept] is univalent\"';
      } else
      if (!checkRule5()){
        $DB_err='\"target[Type*Concept] is univalent\"';
      } else
      if (!checkRule7()){
        $DB_err='\"specific[IsaRelation*Concept] is univalent\"';
      } else
      if (!checkRule9()){
        $DB_err='\"general[IsaRelation*Concept] is univalent\"';
      } else
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
      if (!checkRule100()){
        $DB_err='\"display[Concept*String] is total\"';
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