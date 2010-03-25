<?php // generated with ADL vs. 1.1-632
  
  /********* on line 292, file "src/atlas/atlas.adl"
    SERVICE ISArelaties : I[S]
   = [ IS-a relaties {"DISPLAY=IsaRelation.display"} : V;(user;s;user~/\script;s;script~)
        = [ het specifieke concept {"DISPLAY=Concept.display"} : specific
          , is een {"DISPLAY=Concept.display"} : general
          , pattern : pattern;display
          ]
     ]
   *********/
  
  class ISArelaties {
    private $_ISarelaties;
    function ISArelaties($_ISarelaties=null){
      $this->_ISarelaties=$_ISarelaties;
      if(!isset($_ISarelaties)){
        // get a ISArelaties based on its identifier
        // fill the attributes
        $me=array();
        $me['IS-a relaties']=(DB_doquer("SELECT DISTINCT `f1`.`i` AS `id`
                                           FROM  ( SELECT DISTINCT fst.`i`
                                                     FROM 
                                                        ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `isarelation` AS TODO WHERE TODO.`user`='".$GLOBALS['ctxenv']['User']."'AND TODO.`script`='".$GLOBALS['ctxenv']['Script']."'
                                                        ) AS fst
                                                    WHERE fst.`i` IS NOT NULL
                                                 ) AS f1"));
        foreach($me['IS-a relaties'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , `f2`.`specific` AS `het specifieke concept`
                                       , `f3`.`general` AS `is een`
                                       , `f4`.`display` AS `pattern`
                                    FROM `isarelation`
                                    LEFT JOIN `isarelation` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `isarelation` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `isarelation` AS F0, `pattern` AS F1
                                                  WHERE F0.`pattern`=F1.`i`
                                               ) AS f4
                                      ON `f4`.`i`='".addslashes($v0['id'])."'
                                   WHERE `isarelation`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_ISarelaties($me['IS-a relaties']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $me=array("id"=>1, "IS-a relaties" => $this->_ISarelaties);
      foreach($me['IS-a relaties'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `isarelation` SET `specific`='".addslashes($v0['het specifieke concept'])."', `general`='".addslashes($v0['is een'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
      }
      // no code for het specifieke concept,i in concept
      // no code for is een,i in concept
      foreach($me['IS-a relaties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['pattern'])."'",5);
      }
      foreach($me['IS-a relaties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['pattern'])."')", 5);
      }
      foreach($me['IS-a relaties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `containsconcept` (`i`) VALUES ('".addslashes($v0['het specifieke concept'])."')", 5);
      }
      foreach($me['IS-a relaties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `containsconcept` (`i`) VALUES ('".addslashes($v0['is een'])."')", 5);
      }
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_ISarelaties($val){
      $this->_ISarelaties=$val;
    }
    function get_ISarelaties(){
      if(!isset($this->_ISarelaties)) return array();
      return $this->_ISarelaties;
    }
  }

?>