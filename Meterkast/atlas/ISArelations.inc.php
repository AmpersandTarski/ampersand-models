<?php // generated with ADL vs. 0.8.10-529
  
  /********* on line 221, file "comp/PWO_gmi/20.adl"
    SERVICE ISArelations : I[S]
   = [ IS-a relations : V;(user;s;user~/\script;s;script~)
        = [ IS-a relation : display
          , specific {"DISPLAY=Concept.display"} : specific
          , isa {"DISPLAY=Concept.display"} : general
          , pattern : pattern;display
          ]
     ]
   *********/
  
  class ISArelations {
    private $_ISarelations;
    function ISArelations($_ISarelations=null){
      $this->_ISarelations=$_ISarelations;
      if(!isset($_ISarelations)){
        // get a ISArelations based on its identifier
        // fill the attributes
        $me=array();
        $me['IS-a relations']=(DB_doquer("SELECT DISTINCT `f1`.`i` AS `id`
                                            FROM  ( SELECT DISTINCT fst.`i`
                                                      FROM 
                                                         ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `IsaRelation` AS TODO WHERE TODO.`User`='".$GLOBALS['ctxenv']['User']."'AND TODO.`Script`='".$GLOBALS['ctxenv']['Script']."'
                                                         ) AS fst
                                                     WHERE fst.`i` IS NOT NULL
                                                  ) AS f1"));
        foreach($me['IS-a relations'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , `f2`.`display` AS `IS-a relation`
                                       , `f3`.`specific`
                                       , `f4`.`general` AS `isa`
                                       , `f5`.`display` AS `pattern`
                                    FROM `isarelation`
                                    LEFT JOIN `isarelation` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `isarelation` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `isarelation` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `isarelation` AS F0, `pattern` AS F1
                                                  WHERE F0.`pattern`=F1.`i`
                                               ) AS f5
                                      ON `f5`.`i`='".addslashes($v0['id'])."'
                                   WHERE `isarelation`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_ISarelations($me['IS-a relations']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $me=array("id"=>1, "IS-a relations" => $this->_ISarelations);
      foreach($me['IS-a relations'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `isarelation` SET `display`='".addslashes($v0['IS-a relation'])."', `specific`='".addslashes($v0['specific'])."', `general`='".addslashes($v0['isa'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
      }
      // no code for specific,i in concept
      // no code for isa,i in concept
      foreach($me['IS-a relations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['IS-a relation'])."'",5);
      }
      foreach($me['IS-a relations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['pattern'])."'",5);
      }
      foreach($me['IS-a relations'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['IS-a relation'])."')", 5);
      }
      foreach($me['IS-a relations'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['pattern'])."')", 5);
      }
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_ISarelations($val){
      $this->_ISarelations=$val;
    }
    function get_ISarelations(){
      if(!isset($this->_ISarelations)) return array();
      return $this->_ISarelations;
    }
  }

?>