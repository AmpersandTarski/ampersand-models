<?php // generated with ADL vs. 0.8.10-556
  
  /********* on line 269, file "comp/PWO_gmi/414.adl"
    SERVICE Concepts : I[S]
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