<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3644, file "VIRO.adl"
    SERVICE Procedures : I[ONE]
   = [ Procedures : [ONE*Procedur]
        = [ nr : [Procedur]
          , zitting : zaak~;zitting
          , rechtsgebied : rechtsgebied
          , proceduresoort : proceduresoort
          , zorgdrager : zorgdrager
          , gerecht : zaak~;zitting;locatie
          ]
     ]
   *********/
  
  class Procedures {
    private $_Procedures;
    function Procedures($Procedures=null){
      $this->_Procedures=$Procedures;
      if(!isset($Procedures)){
        // get a Procedures based on its identifier
        // fill the attributes
        $me=array();
        $me['Procedures']=(DB_doquer("SELECT DISTINCT `f1`.`Procedur` AS `id`
                                        FROM  ( SELECT DISTINCT csnd.i AS `Procedur`
                                                  FROM `procedur` AS csnd
                                              ) AS f1"));
        foreach($me['Procedures'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `nr`
                                       , `f3`.`rechtsgebied`
                                       , `f4`.`proceduresoort`
                                       , `f5`.`zorgdrager`
                                    FROM `procedur`
                                    LEFT JOIN `procedur` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `procedur` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `procedur` AS f5 ON `f5`.`i`='".addslashes($v0['id'])."'
                                   WHERE `procedur`.`i`='".addslashes($v0['id'])."'"));
          $v0['zitting']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`zitting`
                                               FROM `procedur`
                                               JOIN  ( SELECT DISTINCT F0.`zaak`, F1.`zitting`
                                                              FROM `behandeling` AS F0, `behandeling` AS F1
                                                             WHERE F0.`i`=F1.`i`
                                                          ) AS f1
                                                 ON `f1`.`zaak`='".addslashes($v0['id'])."'
                                              WHERE `procedur`.`i`='".addslashes($v0['id'])."'"));
          $v0['gerecht']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`locatie` AS `gerecht`
                                               FROM `procedur`
                                               JOIN  ( SELECT DISTINCT F0.`zaak`, F2.`locatie`
                                                              FROM `behandeling` AS F0, `behandeling` AS F1, `zitting` AS F2
                                                             WHERE F0.`i`=F1.`i`
                                                               AND F1.`zitting`=F2.`i`
                                                          ) AS f1
                                                 ON `f1`.`zaak`='".addslashes($v0['id'])."'
                                              WHERE `procedur`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Procedures($me['Procedures']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Procedures" => $this->_Procedures);
      // no code for zitting,i in zitting
      foreach($me['Procedures'] as $i0=>$v0){
        DB_doquer("DELETE FROM `procedur` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Procedures'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `procedur` (`i`,`rechtsgebied`,`proceduresoort`,`zorgdrager`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['rechtsgebied'])."', '".addslashes($v0['proceduresoort'])."', '".addslashes($v0['zorgdrager'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for nr,i in procedur
      // no code for Procedures,zaak in behandeling
      // no code for gerecht,i in gerecht
      foreach($me['Procedures'] as $i0=>$v0){
        DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v0['zorgdrager'])."'",5);
      }
      foreach($me['Procedures'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `orgaan` (`i`) VALUES ('".addslashes($v0['zorgdrager'])."')", 5);
      }
      foreach($me['Procedures'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v0['rechtsgebied'])."'",5);
      }
      foreach($me['Procedures'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `rechtsgebied` (`i`) VALUES ('".addslashes($v0['rechtsgebied'])."')", 5);
      }
      foreach($me['Procedures'] as $i0=>$v0){
        DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v0['proceduresoort'])."'",5);
      }
      foreach($me['Procedures'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `proceduresoort` (`i`) VALUES ('".addslashes($v0['proceduresoort'])."')", 5);
      }
      // no code for Procedures,procedur in eiser
      // no code for nr,procedur in eiser
      // no code for zitting,zitting in rechter
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule2()){
        $DB_err='\"De griffier in een zaak moet benoemd zijn bij de rechtbank waar deze zaak dient.\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Elke zitting vindt plaats in de hoofdvestigingsplaats van een gerecht of een van de nevenvestigingsplaatsen (tekst checken, Artikel 47 lid 2 RO)\"';
      } else
      if (!checkRule5()){
        $DB_err='\"Een bestuurszaak dient bij de rechter die bij de zetel van de gemeente, provincie, waterschap of politieregio hoort, waar tegen bezwaar was ingesteld (voorafgaande aan de procedure bij de bestuursrechter) (art. 8:7 Awb.)\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule18()){
        $DB_err='\"\"';
      } else
      if (!checkRule19()){
        $DB_err='\"\"';
      } else
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
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
      if (!checkRule33()){
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
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule46()){
        $DB_err='\"\"';
      } else
      if (!checkRule48()){
        $DB_err='\"\"';
      } else
      if (!checkRule49()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Procedures($val){
      $this->_Procedures=$val;
    }
    function get_Procedures(){
      if(!isset($this->_Procedures)) return array();
      return $this->_Procedures;
    }
  }

?>