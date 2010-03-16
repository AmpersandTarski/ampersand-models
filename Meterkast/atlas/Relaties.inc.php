<?php // generated with ADL vs. 1.1-640
  
  /********* on line 266, file "src/atlas/atlas.adl"
    SERVICE Relaties : I[S]
   = [ Relatielijst {"DISPLAY=Relation.display"} : V;(user;s;user~/\script;s;script~)
        = [ voorbeeld : example;display
          ]
     ]
   *********/
  
  class Relaties {
    private $_Relatielijst;
    function Relaties($_Relatielijst=null){
      $this->_Relatielijst=$_Relatielijst;
      if(!isset($_Relatielijst)){
        // get a Relaties based on its identifier
        // fill the attributes
        $me=array();
        $me['Relatielijst']=(DB_doquer("SELECT DISTINCT `f1`.`I` AS `id`
                                          FROM  ( SELECT DISTINCT fst.`I`
                                                    FROM 
                                                       ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `relation` AS TODO WHERE TODO.`user`='".$GLOBALS['ctxenv']['User']."'AND TODO.`script`='".$GLOBALS['ctxenv']['Script']."'
                                                       ) AS fst
                                                   WHERE fst.`I` IS NOT NULL
                                                ) AS f1"));
        foreach($me['Relatielijst'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , `f2`.`display` AS `voorbeeld`
                                    FROM `Relation`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`display`
                                                   FROM `Relation` AS F0, `PragmaExample` AS F1
                                                  WHERE F0.`example`=F1.`I`
                                               ) AS f2
                                      ON `f2`.`I`='".addslashes($v0['id'])."'
                                   WHERE `Relation`.`I`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Relatielijst($me['Relatielijst']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $me=array("id"=>1, "Relatielijst" => $this->_Relatielijst);
      // no code for Relatielijst,I in Relation
      foreach($me['Relatielijst'] as $i0=>$v0){
        DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v0['voorbeeld'])."'",5);
      }
      foreach($me['Relatielijst'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($v0['voorbeeld'])."')", 5);
      }
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Relatielijst($val){
      $this->_Relatielijst=$val;
    }
    function get_Relatielijst(){
      if(!isset($this->_Relatielijst)) return array();
      return $this->_Relatielijst;
    }
  }

?>