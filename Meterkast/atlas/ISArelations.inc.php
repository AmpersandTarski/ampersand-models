<?php // generated with ADL vs. 0.8.10-515
  
  /********* on line 183, file "comp/PWO_gmi/171.adl"
    SERVICE ISArelations : I[ONE]
   = [ IS-a relations : V;(user;s;user~/\script;s;script~)
        = [ IS-a relation : display
          , specific {"DISPLAY=Concept.display"} : specific
          , isa {"DISPLAY=Concept.display"} : general
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
                                    FROM `isarelation`
                                    LEFT JOIN `isarelation` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `isarelation` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `isarelation` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
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
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['IS-a relation'])."')", 5);
      }
      if (!checkRule3()){
        $DB_err='\"source[Type*Concept] is univalent\"';
      } else
      if (!checkRule5()){
        $DB_err='\"target[Type*Concept] is univalent\"';
      } else
      if (!checkRule7()){
        $DB_err='\"specific[IsaRelation*Concept] is univalent\"';
      } else
      if (!checkRule8()){
        $DB_err='\"specific[IsaRelation*Concept] is total\"';
      } else
      if (!checkRule9()){
        $DB_err='\"general[IsaRelation*Concept] is univalent\"';
      } else
      if (!checkRule10()){
        $DB_err='\"general[IsaRelation*Concept] is total\"';
      } else
      if (!checkRule44()){
        $DB_err='\"user[Concept*User] is total\"';
      } else
      if (!checkRule47()){
        $DB_err='\"user[IsaRelation*User] is univalent\"';
      } else
      if (!checkRule48()){
        $DB_err='\"user[IsaRelation*User] is total\"';
      } else
      if (!checkRule72()){
        $DB_err='\"script[Concept*Script] is total\"';
      } else
      if (!checkRule75()){
        $DB_err='\"script[IsaRelation*Script] is univalent\"';
      } else
      if (!checkRule76()){
        $DB_err='\"script[IsaRelation*Script] is total\"';
      } else
      if (!checkRule91()){
        $DB_err='\"display[Picture*String] is univalent\"';
      } else
      if (!checkRule93()){
        $DB_err='\"display[Relation*String] is univalent\"';
      } else
      if (!checkRule95()){
        $DB_err='\"display[Type*String] is univalent\"';
      } else
      if (!checkRule97()){
        $DB_err='\"display[Pair*String] is univalent\"';
      } else
      if (!checkRule99()){
        $DB_err='\"display[Concept*String] is univalent\"';
      } else
      if (!checkRule100()){
        $DB_err='\"display[Concept*String] is total\"';
      } else
      if (!checkRule101()){
        $DB_err='\"display[Atom*String] is univalent\"';
      } else
      if (!checkRule103()){
        $DB_err='\"display[IsaRelation*String] is univalent\"';
      } else
      if (!checkRule104()){
        $DB_err='\"display[IsaRelation*String] is total\"';
      } else
      if (!checkRule105()){
        $DB_err='\"display[MultiplicityRule*String] is univalent\"';
      } else
      if (!checkRule107()){
        $DB_err='\"display[HomogeneousRule*String] is univalent\"';
      } else
      if (!checkRule109()){
        $DB_err='\"display[Prop*String] is univalent\"';
      } else
      if (!checkRule111()){
        $DB_err='\"display[UserRule*String] is univalent\"';
      } else
      if (!checkRule113()){
        $DB_err='\"display[Rule*String] is univalent\"';
      } else
      if (!checkRule115()){
        $DB_err='\"display[Violation*String] is univalent\"';
      } else
      if (!checkRule117()){
        $DB_err='\"display[Explanation*String] is univalent\"';
      } else
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