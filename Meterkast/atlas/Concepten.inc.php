<?php // generated with ADL vs. 1.1-640
  
  /********* on line 288, file "src/atlas/atlas.adl"
    SERVICE Concepten : I[S]
   = [ Conceptenlijst {"DISPLAY=Concept.display"} : V;(user;s;user~/\script;s;script~)
     ]
   *********/
  
  class Concepten {
    private $_Conceptenlijst;
    function Concepten($_Conceptenlijst=null){
      $this->_Conceptenlijst=$_Conceptenlijst;
      if(!isset($_Conceptenlijst)){
        // get a Concepten based on its identifier
        // fill the attributes
        $me=array();
        $me['Conceptenlijst']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`I` AS `Conceptenlijst`
                                                    FROM  ( SELECT DISTINCT fst.`I`
                                                              FROM 
                                                                 ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `concept` AS TODO WHERE TODO.`user`='".$GLOBALS['ctxenv']['User']."'AND TODO.`script`='".$GLOBALS['ctxenv']['Script']."'
                                                                 ) AS fst
                                                             WHERE fst.`I` IS NOT NULL
                                                          ) AS f1"));
        $this->set_Conceptenlijst($me['Conceptenlijst']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $me=array("id"=>1, "Conceptenlijst" => $this->_Conceptenlijst);
      // no code for Conceptenlijst,I in Concept
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Conceptenlijst($val){
      $this->_Conceptenlijst=$val;
    }
    function get_Conceptenlijst(){
      if(!isset($this->_Conceptenlijst)) return array();
      return $this->_Conceptenlijst;
    }
  }

?>