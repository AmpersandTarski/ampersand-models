<?php // generated with ADL vs. 1.1-632
  
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
        $me['Regellijst']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`i` AS `Regellijst`
                                                FROM  ( SELECT DISTINCT fst.`i`
                                                          FROM 
                                                             ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `userrule` AS TODO WHERE TODO.`user`='".$GLOBALS['ctxenv']['User']."'AND TODO.`script`='".$GLOBALS['ctxenv']['Script']."'
                                                             ) AS fst
                                                         WHERE fst.`i` IS NOT NULL
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
      // no code for Regellijst,i in userrule
      foreach($me['Regellijst'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `morphisms` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
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