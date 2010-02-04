<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3751, file "VIRO.adl"
    SERVICE Rolplanning : I[ONE]
   = [ Rol : [ONE*Behandeling]
        = [ rolnr : [Behandeling]
          , zaak : zaak
             = [ zaaknr : [Procedur]
               , gedaagde : gedaagde~
               , eiser : eiser~
               , gevoegde : gevoegde~
               ]
          , zitting : zitting
             = [ kamer : kamer
               , rechter : rechter
               , griffier : griffier
               , geagendeerd : geagendeerd
               ]
          ]
     , Gepland : [ONE*Behandeling]
        = [ rolnr : [Behandeling]
          , zitting : zitting
          , zaak : zaak
          ]
     ]
   *********/
  
  class Rolplanning {
    private $_Rol;
    private $_Gepland;
    function Rolplanning($Rol=null, $Gepland=null){
      $this->_Rol=$Rol;
      $this->_Gepland=$Gepland;
      if(!isset($Rol)){
        // get a Rolplanning based on its identifier
        // fill the attributes
        $me=array();
        $me['Rol']=(DB_doquer("SELECT DISTINCT `f1`.`Behandeling` AS `id`
                                 FROM  ( SELECT DISTINCT csnd.i AS `Behandeling`
                                           FROM `behandeling` AS csnd
                                       ) AS f1"));
        $me['Gepland']=(DB_doquer("SELECT DISTINCT `f1`.`Behandeling` AS `id`
                                     FROM  ( SELECT DISTINCT csnd.i AS `Behandeling`
                                               FROM `behandeling` AS csnd
                                           ) AS f1"));
        foreach($me['Rol'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `rolnr`
                                       , `f3`.`zaak`
                                       , `f4`.`zitting`
                                    FROM `behandeling`
                                    LEFT JOIN `behandeling` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `behandeling` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                   WHERE `behandeling`.`i`='".addslashes($v0['id'])."'"));
          $v1 = $v0['zaak'];
          $v0['zaak']=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v1)."' AS `id`
                                               , '".addslashes($v1)."' AS `zaaknr`
                                            FROM `procedur`
                                           WHERE `procedur`.`i`='".addslashes($v1)."'"));
          $v0['zaak']['gedaagde']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `gedaagde`
                                                        FROM `procedur`
                                                        JOIN `gedaagde` AS f1 ON `f1`.`Procedur`='".addslashes($v1)."'
                                                       WHERE `procedur`.`i`='".addslashes($v1)."'"));
          $v0['zaak']['eiser']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `eiser`
                                                     FROM `procedur`
                                                     JOIN `eiser` AS f1 ON `f1`.`procedur`='".addslashes($v1)."'
                                                    WHERE `procedur`.`i`='".addslashes($v1)."'"));
          $v0['zaak']['gevoegde']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `gevoegde`
                                                        FROM `procedur`
                                                        JOIN `gevoegde` AS f1 ON `f1`.`Procedur`='".addslashes($v1)."'
                                                       WHERE `procedur`.`i`='".addslashes($v1)."'"));
          $v1 = $v0['zitting'];
          $v0['zitting']=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v1)."' AS `id`
                                                  , `f2`.`kamer`
                                                  , `f3`.`griffier`
                                                  , `f4`.`geagendeerd`
                                               FROM `zitting`
                                               LEFT JOIN `zitting` AS f2 ON `f2`.`i`='".addslashes($v1)."'
                                               LEFT JOIN `zitting` AS f3 ON `f3`.`i`='".addslashes($v1)."'
                                               LEFT JOIN `zitting` AS f4 ON `f4`.`i`='".addslashes($v1)."'
                                              WHERE `zitting`.`i`='".addslashes($v1)."'"));
          $v0['zitting']['rechter']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `rechter`
                                                          FROM `zitting`
                                                          JOIN `rechter` AS f1 ON `f1`.`zitting`='".addslashes($v1)."'
                                                         WHERE `zitting`.`i`='".addslashes($v1)."'"));
        }
        unset($v0);
        foreach($me['Gepland'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `rolnr`
                                       , `f3`.`zitting`
                                       , `f4`.`zaak`
                                    FROM `behandeling`
                                    LEFT JOIN `behandeling` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `behandeling` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                   WHERE `behandeling`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Rol($me['Rol']);
        $this->set_Gepland($me['Gepland']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Rol" => $this->_Rol, "Gepland" => $this->_Gepland);
      foreach($me['Rol'] as $i0=>$v0){
        if(isset($v0['zitting']['id']))
          DB_doquer("UPDATE `zitting` SET `kamer`='".addslashes($v0['zitting']['kamer'])."', `griffier`='".addslashes($v0['zitting']['griffier'])."', `geagendeerd`='".addslashes($v0['zitting']['geagendeerd'])."' WHERE `i`='".addslashes($v0['zitting']['id'])."'", 5);
      }
      // no code for zitting,i in zitting
      foreach($me['Rol'] as $i0=>$v0){
        if(isset($v0['zaak']['id']))
          DB_doquer("UPDATE `procedur` SET `i`='".addslashes($v0['zaak']['id'])."' WHERE `i`='".addslashes($v0['zaak']['zaaknr'])."'", 5);
      }
      // no code for zaaknr,i in procedur
      // no code for zaak,i in procedur
      foreach($me['Rol'] as $i0=>$v0){
        DB_doquer("DELETE FROM `behandeling` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Gepland'] as $i0=>$v0){
        DB_doquer("DELETE FROM `behandeling` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Rol'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `behandeling` (`i`,`zaak`,`zitting`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['zaak']['id'])."', '".addslashes($v0['zitting']['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for rolnr,i in behandeling
      foreach($me['Gepland'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `behandeling` (`i`,`zitting`,`zaak`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['zitting'])."', '".addslashes($v0['zaak'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for rolnr,i in behandeling
      // no code for kamer,i in kamer
      foreach($me['Rol'] as $i0=>$v0){
        foreach($v0['zaak']['gedaagde'] as $i2=>$v2){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v2)."'",5);
        }
      }
      foreach($me['Rol'] as $i0=>$v0){
        foreach($v0['zaak']['eiser'] as $i2=>$v2){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v2)."'",5);
        }
      }
      foreach($me['Rol'] as $i0=>$v0){
        foreach($v0['zaak']['gevoegde'] as $i2=>$v2){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v2)."'",5);
        }
      }
      foreach($me['Rol'] as $i0=>$v0){
        foreach($v0['zitting']['rechter'] as $i2=>$v2){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v2)."'",5);
        }
      }
      foreach($me['Rol'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['zitting']['griffier'])."'",5);
      }
      foreach($me['Rol'] as $i0=>$v0){
        foreach($v0['zaak']['gedaagde'] as $i2=>$v2){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v2)."')", 5);
        }
      }
      foreach($me['Rol'] as $i0=>$v0){
        foreach($v0['zaak']['eiser'] as $i2=>$v2){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v2)."')", 5);
        }
      }
      foreach($me['Rol'] as $i0=>$v0){
        foreach($v0['zaak']['gevoegde'] as $i2=>$v2){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v2)."')", 5);
        }
      }
      foreach($me['Rol'] as $i0=>$v0){
        foreach($v0['zitting']['rechter'] as $i2=>$v2){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v2)."')", 5);
        }
      }
      foreach($me['Rol'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['zitting']['griffier'])."')", 5);
      }
      foreach($me['Rol'] as $i0=>$v0){
        DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($v0['zitting']['geagendeerd'])."'",5);
      }
      foreach($me['Rol'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `datum` (`i`) VALUES ('".addslashes($v0['zitting']['geagendeerd'])."')", 5);
      }
      foreach($me['Rol'] as $i0=>$v0){
        DB_doquer("DELETE FROM `eiser` WHERE `procedur`='".addslashes($v0['zaak']['id'])."'",5);
      }
      foreach($me['Rol'] as $i0=>$v0){
        foreach  ($v0['zaak']['eiser'] as $eiser){
          $res=DB_doquer("INSERT IGNORE INTO `eiser` (`procedur`,`persoon`) VALUES ('".addslashes($v0['zaak']['id'])."', '".addslashes($eiser)."')", 5);
        }
      }
      // no code for zaaknr,procedur in eiser
      // no code for zaak,procedur in eiser
      foreach($me['Rol'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechter` WHERE `zitting`='".addslashes($v0['zitting']['id'])."'",5);
      }
      foreach($me['Rol'] as $i0=>$v0){
        foreach  ($v0['zitting']['rechter'] as $rechter){
          $res=DB_doquer("INSERT IGNORE INTO `rechter` (`zitting`,`persoon`) VALUES ('".addslashes($v0['zitting']['id'])."', '".addslashes($rechter)."')", 5);
        }
      }
      // no code for zitting,zitting in rechter
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule2()){
        $DB_err='\"De griffier in een zaak moet benoemd zijn bij de rechtbank waar deze zaak dient.\"';
      } else
      if (!checkRule3()){
        $DB_err='\"Alle zittingen worden geagendeerd\"';
      } else
      if (!checkRule5()){
        $DB_err='\"Een bestuurszaak dient bij de rechter die bij de zetel van de gemeente, provincie, waterschap of politieregio hoort, waar tegen bezwaar was ingesteld (voorafgaande aan de procedure bij de bestuursrechter) (art. 8:7 Awb.)\"';
      } else
      if (!checkRule6()){
        $DB_err='\"De rechter ter zitting maakt deel uit van de bezetting van de kamer die de zitting houdt\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule15()){
        $DB_err='\"\"';
      } else
      if (!checkRule17()){
        $DB_err='\"\"';
      } else
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule26()){
        $DB_err='\"\"';
      } else
      if (!checkRule27()){
        $DB_err='\"\"';
      } else
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
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
      if (!checkRule37()){
        $DB_err='\"\"';
      } else
      if (!checkRule39()){
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
    function set_Rol($val){
      $this->_Rol=$val;
    }
    function get_Rol(){
      if(!isset($this->_Rol)) return array();
      return $this->_Rol;
    }
    function set_Gepland($val){
      $this->_Gepland=$val;
    }
    function get_Gepland(){
      if(!isset($this->_Gepland)) return array();
      return $this->_Gepland;
    }
  }

?>