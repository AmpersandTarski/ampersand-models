<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3803, file "VIRO.adl"
    SERVICE Artikelen : I[ONE]
   = [ Artikelen : [ONE*Artikel]
        = [ artikel : [Artikel]
          , handeling : handeling
          , orgaan : orgaan
          , werkwoord : werkwoord
          , objecttype : objecttype
          ]
     ]
   *********/
  
  class Artikelen {
    private $_Artikelen;
    function Artikelen($Artikelen=null){
      $this->_Artikelen=$Artikelen;
      if(!isset($Artikelen)){
        // get a Artikelen based on its identifier
        // fill the attributes
        $me=array();
        $me['Artikelen']=(DB_doquer("SELECT DISTINCT `f1`.`Artikel` AS `id`
                                       FROM  ( SELECT DISTINCT csnd.i AS `Artikel`
                                                 FROM `artikel` AS csnd
                                             ) AS f1"));
        foreach($me['Artikelen'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `artikel`
                                    FROM `artikel`
                                   WHERE `artikel`.`i`='".addslashes($v0['id'])."'"));
          $v0['handeling']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Handeling` AS `handeling`
                                                 FROM `artikel`
                                                 JOIN `handelingartikel` AS f1 ON `f1`.`artikel`='".addslashes($v0['id'])."'
                                                WHERE `artikel`.`i`='".addslashes($v0['id'])."'"));
          $v0['orgaan']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Orgaan` AS `orgaan`
                                              FROM `artikel`
                                              JOIN `orgaanartikel` AS f1 ON `f1`.`artikel`='".addslashes($v0['id'])."'
                                             WHERE `artikel`.`i`='".addslashes($v0['id'])."'"));
          $v0['werkwoord']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Werkwoord` AS `werkwoord`
                                                 FROM `artikel`
                                                 JOIN `werkwoordartikel` AS f1 ON `f1`.`artikel`='".addslashes($v0['id'])."'
                                                WHERE `artikel`.`i`='".addslashes($v0['id'])."'"));
          $v0['objecttype']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Objecttype` AS `objecttype`
                                                  FROM `artikel`
                                                  JOIN `objecttypeartikel` AS f1 ON `f1`.`artikel`='".addslashes($v0['id'])."'
                                                 WHERE `artikel`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Artikelen($me['Artikelen']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Artikelen" => $this->_Artikelen);
      foreach($me['Artikelen'] as $i0=>$v0){
        foreach($v0['orgaan'] as $i1=>$v1){
          DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Artikelen'] as $i0=>$v0){
        foreach($v0['orgaan'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `orgaan` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Artikelen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `artikel` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Artikelen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `artikel` WHERE `i`='".addslashes($v0['artikel'])."'",5);
      }
      foreach($me['Artikelen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `artikel` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['Artikelen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `artikel` (`i`) VALUES ('".addslashes($v0['artikel'])."')", 5);
      }
      foreach($me['Artikelen'] as $i0=>$v0){
        foreach($v0['handeling'] as $i1=>$v1){
          DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Artikelen'] as $i0=>$v0){
        foreach($v0['handeling'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `handeling` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Artikelen'] as $i0=>$v0){
        foreach($v0['objecttype'] as $i1=>$v1){
          DB_doquer("DELETE FROM `objecttype` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Artikelen'] as $i0=>$v0){
        foreach($v0['objecttype'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `objecttype` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Artikelen'] as $i0=>$v0){
        foreach($v0['werkwoord'] as $i1=>$v1){
          DB_doquer("DELETE FROM `werkwoord` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Artikelen'] as $i0=>$v0){
        foreach($v0['werkwoord'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `werkwoord` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Artikelen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handelingartikel` WHERE `artikel`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Artikelen'] as $i0=>$v0){
        foreach  ($v0['handeling'] as $handeling){
          $res=DB_doquer("INSERT IGNORE INTO `handelingartikel` (`handeling`,`artikel`) VALUES ('".addslashes($handeling)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      foreach($me['Artikelen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `orgaanartikel` WHERE `artikel`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Artikelen'] as $i0=>$v0){
        foreach  ($v0['orgaan'] as $orgaan){
          $res=DB_doquer("INSERT IGNORE INTO `orgaanartikel` (`orgaan`,`artikel`) VALUES ('".addslashes($orgaan)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      foreach($me['Artikelen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `werkwoordartikel` WHERE `artikel`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Artikelen'] as $i0=>$v0){
        foreach  ($v0['werkwoord'] as $werkwoord){
          $res=DB_doquer("INSERT IGNORE INTO `werkwoordartikel` (`werkwoord`,`artikel`) VALUES ('".addslashes($werkwoord)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      foreach($me['Artikelen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `objecttypeartikel` WHERE `artikel`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Artikelen'] as $i0=>$v0){
        foreach  ($v0['objecttype'] as $objecttype){
          $res=DB_doquer("INSERT IGNORE INTO `objecttypeartikel` (`objecttype`,`artikel`) VALUES ('".addslashes($objecttype)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat als vertegenwoordiger van het orgaan dat de handeling uitvoert\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Artikelen($val){
      $this->_Artikelen=$val;
    }
    function get_Artikelen(){
      if(!isset($this->_Artikelen)) return array();
      return $this->_Artikelen;
    }
  }

?>