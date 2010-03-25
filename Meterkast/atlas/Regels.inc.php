<?php // generated with ADL vs. 1.1-646
  
  /********* on line 227, file "src/atlas/atlas.adl"
    SERVICE Regels : I[S]
   = [ Regellijst {"DISPLAY=UserRule.display"} : V;(user;s;user~/\script;s;script~)
     ]
   *********/
  
  class Regels {
    private $_Regellijst;
    function Regels($_Regellijst=null){
      $this->_Regellijst=$_Regellijst;
      if(!isset($_Regellijst)){
        // get a Regels based on its identifier
        // fill the attributes
        $me=array();
        $me['Regellijst']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`I` AS `Regellijst`
                                                FROM  ( SELECT DISTINCT fst.`I`
                                                          FROM 
                                                             ( SELECT DISTINCT TODO.`I`, TODO.`I` AS i1 FROM `UserRule` AS TODO WHERE TODO.`User`='".$GLOBALS['ctxenv']['User']."'AND TODO.`Script`='".$GLOBALS['ctxenv']['Script']."'
                                                             ) AS fst
                                                         WHERE fst.`I` IS NOT NULL
                                                      ) AS f1"));
        $this->set_Regellijst($me['Regellijst']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $me=array("id"=>1, "Regellijst" => $this->_Regellijst);
      // no code for Regellijst,I in UserRule
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Regellijst($val){
      $this->_Regellijst=$val;
    }
    function get_Regellijst(){
      if(!isset($this->_Regellijst)) return array();
      return $this->_Regellijst;
    }
  }

?>