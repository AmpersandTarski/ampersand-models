<?php // generated with ADL vs. 0.8.10-559
  
  /********* on line 248, file "comp/PWO_gmi/443.adl"
    SERVICE Relations : I[S]
   = [ Relation_s {"DISPLAY=Relation.display"} : V;(user;s;user~/\script;s;script~)
        = [ example : example;display
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
                                       , `f2`.`display` AS `example`
                                    FROM `relation`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `relation` AS F0, `pragmaexample` AS F1
                                                  WHERE F0.`example`=F1.`i`
                                               ) AS f2
                                      ON `f2`.`i`='".addslashes($v0['id'])."'
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
      // no code for Relation_s,i in relation
      foreach($me['Relation_s'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['example'])."'",5);
      }
      foreach($me['Relation_s'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['example'])."')", 5);
      }
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