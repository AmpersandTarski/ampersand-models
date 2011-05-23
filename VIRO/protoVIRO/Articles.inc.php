<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 783, file "VIRO453ENG.adl"
    SERVICE Articles : I[ONE]
   = [ Articles : [ONE*Article]
        = [ article : [Article]
          , act : act
          , organ : organ
          , verb : verb
          , object type : objectType
          ]
     ]
   *********/
  
  class Articles {
    private $_Articles;
    function Articles($Articles=null){
      $this->_Articles=$Articles;
      if(!isset($Articles)){
        // get a Articles based on its identifier
        // fill the attributes
        $me=array();
        $me['Articles']=(DB_doquer("SELECT DISTINCT `f1`.`Article` AS `id`
                                      FROM  ( SELECT DISTINCT csnd.i AS `Article`
                                                FROM `article` AS csnd
                                            ) AS f1"));
        foreach($me['Articles'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `article`
                                    FROM `article`
                                   WHERE `article`.`i`='".addslashes($v0['id'])."'"));
          $v0['act']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Act` AS `act`
                                           FROM `article`
                                           JOIN `actarticle` AS f1 ON `f1`.`article`='".addslashes($v0['id'])."'
                                          WHERE `article`.`i`='".addslashes($v0['id'])."'"));
          $v0['organ']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Organ` AS `organ`
                                             FROM `article`
                                             JOIN `organarticle` AS f1 ON `f1`.`article`='".addslashes($v0['id'])."'
                                            WHERE `article`.`i`='".addslashes($v0['id'])."'"));
          $v0['verb']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Verb` AS `verb`
                                            FROM `article`
                                            JOIN `verbarticle` AS f1 ON `f1`.`article`='".addslashes($v0['id'])."'
                                           WHERE `article`.`i`='".addslashes($v0['id'])."'"));
          $v0['object type']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`ObjectType` AS `object type`
                                                   FROM `article`
                                                   JOIN `objecttypearticle` AS f1 ON `f1`.`article`='".addslashes($v0['id'])."'
                                                  WHERE `article`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Articles($me['Articles']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Articles" => $this->_Articles);
      foreach($me['Articles'] as $i0=>$v0){
        foreach($v0['organ'] as $i1=>$v1){
          DB_doquer("DELETE FROM `organ` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Articles'] as $i0=>$v0){
        foreach($v0['organ'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `organ` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Articles'] as $i0=>$v0){
        DB_doquer("DELETE FROM `article` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Articles'] as $i0=>$v0){
        DB_doquer("DELETE FROM `article` WHERE `i`='".addslashes($v0['article'])."'",5);
      }
      foreach($me['Articles'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `article` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['Articles'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `article` (`i`) VALUES ('".addslashes($v0['article'])."')", 5);
      }
      foreach($me['Articles'] as $i0=>$v0){
        foreach($v0['act'] as $i1=>$v1){
          DB_doquer("DELETE FROM `act` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Articles'] as $i0=>$v0){
        foreach($v0['act'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `act` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Articles'] as $i0=>$v0){
        foreach($v0['object type'] as $i1=>$v1){
          DB_doquer("DELETE FROM `objecttype` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Articles'] as $i0=>$v0){
        foreach($v0['object type'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `objecttype` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Articles'] as $i0=>$v0){
        foreach($v0['verb'] as $i1=>$v1){
          DB_doquer("DELETE FROM `verb` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Articles'] as $i0=>$v0){
        foreach($v0['verb'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `verb` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Articles'] as $i0=>$v0){
        DB_doquer("DELETE FROM `actarticle` WHERE `article`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Articles'] as $i0=>$v0){
        foreach  ($v0['act'] as $act){
          $res=DB_doquer("INSERT IGNORE INTO `actarticle` (`act`,`article`) VALUES ('".addslashes($act)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      foreach($me['Articles'] as $i0=>$v0){
        DB_doquer("DELETE FROM `organarticle` WHERE `article`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Articles'] as $i0=>$v0){
        foreach  ($v0['organ'] as $organ){
          $res=DB_doquer("INSERT IGNORE INTO `organarticle` (`organ`,`article`) VALUES ('".addslashes($organ)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      foreach($me['Articles'] as $i0=>$v0){
        DB_doquer("DELETE FROM `verbarticle` WHERE `article`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Articles'] as $i0=>$v0){
        foreach  ($v0['verb'] as $verb){
          $res=DB_doquer("INSERT IGNORE INTO `verbarticle` (`verb`,`article`) VALUES ('".addslashes($verb)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      foreach($me['Articles'] as $i0=>$v0){
        DB_doquer("DELETE FROM `objecttypearticle` WHERE `article`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Articles'] as $i0=>$v0){
        foreach  ($v0['object type'] as $objecttype){
          $res=DB_doquer("INSERT IGNORE INTO `objecttypearticle` (`objecttype`,`article`) VALUES ('".addslashes($objecttype)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat as vertegenwoordiger from het organ dat de act uitvoert\"';
      } else
      if (!checkRule10()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Articles($val){
      $this->_Articles=$val;
    }
    function get_Articles(){
      if(!isset($this->_Articles)) return array();
      return $this->_Articles;
    }
  }

?>