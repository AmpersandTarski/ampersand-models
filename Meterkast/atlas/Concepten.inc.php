<?php // generated with ADL vs. 1.1-632
  
  /********* on line 284, file "src/atlas/atlas.adl"
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
        $me['Conceptenlijst']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`i` AS `Conceptenlijst`
                                                    FROM  ( SELECT DISTINCT fst.`i`
                                                              FROM 
                                                                 ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `concept` AS TODO WHERE TODO.`user`='".$GLOBALS['ctxenv']['User']."'AND TODO.`script`='".$GLOBALS['ctxenv']['Script']."'
                                                                 ) AS fst
                                                             WHERE fst.`i` IS NOT NULL
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
      // no code for Conceptenlijst,i in concept
      foreach($me['Conceptenlijst'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `containsconcept` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
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