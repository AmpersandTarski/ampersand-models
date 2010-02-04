<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3720, file "VIRO.adl"
    SERVICE Zittingen : I[ONE]
   = [ Zittingen : [ONE*Zitting]
        = [ nr : [Zitting]
          , kamer : kamer
          , gerecht : locatie
          , plaats : plaats
          , rechter : rechter
          , griffier : griffier
          , geagendeerd : geagendeerd
          , feitelijkedatum : plaatsgevonden
          ]
     ]
   *********/
  
  class Zittingen {
    private $_Zittingen;
    function Zittingen($Zittingen=null){
      $this->_Zittingen=$Zittingen;
      if(!isset($Zittingen)){
        // get a Zittingen based on its identifier
        // fill the attributes
        $me=array();
        $me['Zittingen']=(DB_doquer("SELECT DISTINCT `f1`.`Zitting` AS `id`
                                       FROM  ( SELECT DISTINCT csnd.i AS `Zitting`
                                                 FROM `zitting` AS csnd
                                             ) AS f1"));
        foreach($me['Zittingen'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `nr`
                                       , `f3`.`kamer`
                                       , `f4`.`locatie` AS `gerecht`
                                       , `f5`.`plaats`
                                       , `f6`.`griffier`
                                       , `f7`.`geagendeerd`
                                       , `f8`.`plaatsgevonden` AS `feitelijkedatum`
                                    FROM `zitting`
                                    LEFT JOIN `zitting` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `zitting` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `zitting` AS f5 ON `f5`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `zitting` AS f6 ON `f6`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `zitting` AS f7 ON `f7`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `zitting` AS f8 ON `f8`.`i`='".addslashes($v0['id'])."'
                                   WHERE `zitting`.`i`='".addslashes($v0['id'])."'"));
          $v0['rechter']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `rechter`
                                               FROM `zitting`
                                               JOIN `rechter` AS f1 ON `f1`.`zitting`='".addslashes($v0['id'])."'
                                              WHERE `zitting`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Zittingen($me['Zittingen']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Zittingen" => $this->_Zittingen);
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `zitting` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `zitting` (`i`,`kamer`,`locatie`,`plaats`,`griffier`,`geagendeerd`,`plaatsgevonden`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['kamer'])."', '".addslashes($v0['gerecht'])."', '".addslashes($v0['plaats'])."', '".addslashes($v0['griffier'])."', '".addslashes($v0['geagendeerd'])."', ".((null!=$v0['feitelijkedatum'])?"'".addslashes($v0['feitelijkedatum'])."'":"NULL").")", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for nr,i in zitting
      // no code for gerecht,i in gerecht
      // no code for kamer,i in kamer
      foreach($me['Zittingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `plaats` (`i`) VALUES ('".addslashes($v0['plaats'])."')", 5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        foreach($v0['rechter'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['griffier'])."'",5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        foreach($v0['rechter'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['griffier'])."')", 5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($v0['geagendeerd'])."'",5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($v0['feitelijkedatum'])."'",5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `datum` (`i`) VALUES ('".addslashes($v0['geagendeerd'])."')", 5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `datum` (`i`) VALUES ('".addslashes($v0['feitelijkedatum'])."')", 5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechter` WHERE `zitting`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Zittingen'] as $i0=>$v0){
        foreach  ($v0['rechter'] as $rechter){
          $res=DB_doquer("INSERT IGNORE INTO `rechter` (`zitting`,`persoon`) VALUES ('".addslashes($v0['id'])."', '".addslashes($rechter)."')", 5);
        }
      }
      // no code for nr,zitting in rechter
      if (!checkRule2()){
        $DB_err='\"De griffier in een zaak moet benoemd zijn bij de rechtbank waar deze zaak dient.\"';
      } else
      if (!checkRule3()){
        $DB_err='\"Alle zittingen worden geagendeerd\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Elke zitting vindt plaats in de hoofdvestigingsplaats van een gerecht of een van de nevenvestigingsplaatsen (tekst checken, Artikel 47 lid 2 RO)\"';
      } else
      if (!checkRule5()){
        $DB_err='\"Een bestuurszaak dient bij de rechter die bij de zetel van de gemeente, provincie, waterschap of politieregio hoort, waar tegen bezwaar was ingesteld (voorafgaande aan de procedure bij de bestuursrechter) (art. 8:7 Awb.)\"';
      } else
      if (!checkRule6()){
        $DB_err='\"De rechter ter zitting maakt deel uit van de bezetting van de kamer die de zitting houdt\"';
      } else
      if (!checkRule17()){
        $DB_err='\"\"';
      } else
      if (!checkRule26()){
        $DB_err='\"\"';
      } else
      if (!checkRule30()){
        $DB_err='\"\"';
      } else
      if (!checkRule31()){
        $DB_err='\"\"';
      } else
      if (!checkRule32()){
        $DB_err='\"\"';
      } else
      if (!checkRule33()){
        $DB_err='\"\"';
      } else
      if (!checkRule34()){
        $DB_err='\"\"';
      } else
      if (!checkRule35()){
        $DB_err='\"\"';
      } else
      if (!checkRule36()){
        $DB_err='\"\"';
      } else
      if (!checkRule37()){
        $DB_err='\"\"';
      } else
      if (!checkRule38()){
        $DB_err='\"\"';
      } else
      if (!checkRule39()){
        $DB_err='\"\"';
      } else
      if (!checkRule40()){
        $DB_err='\"\"';
      } else
      if (!checkRule41()){
        $DB_err='\"\"';
      } else
      if (!checkRule43()){
        $DB_err='\"\"';
      } else
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule45()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if (!checkRule48()){
        $DB_err='\"\"';
      } else
      if (!checkRule49()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule64()){
        $DB_err='\"\"';
      } else
      if (!checkRule67()){
        $DB_err='\"\"';
      } else
      if (!checkRule74()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Zittingen($val){
      $this->_Zittingen=$val;
    }
    function get_Zittingen(){
      if(!isset($this->_Zittingen)) return array();
      return $this->_Zittingen;
    }
  }

?>