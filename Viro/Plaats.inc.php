<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3686, file "VIRO.adl"
    SERVICE Plaats : I[Plaats]
   = [ Rechtbank : neven
     , ressort : neven;ressort
     , plaats Zitting : plaats~
        = [ Zitting : [Zitting]
          , rechter : rechter
          , griffier : griffier
          , geagendeerd : geagendeerd
          , plaats : plaats
          , locatie : locatie
          , kamer : kamer
          ]
     , hoofdplaats : hoofdplaats~
     ]
   *********/
  
  class Plaats {
    protected $_id=false;
    protected $_new=true;
    private $_Rechtbank;
    private $_ressort;
    private $_plaatsZitting;
    private $_hoofdplaats;
    function Plaats($id=null, $Rechtbank=null, $ressort=null, $plaatsZitting=null, $hoofdplaats=null){
      $this->_id=$id;
      $this->_Rechtbank=$Rechtbank;
      $this->_ressort=$ressort;
      $this->_plaatsZitting=$plaatsZitting;
      $this->_hoofdplaats=$hoofdplaats;
      if(!isset($Rechtbank) && isset($id)){
        // get a Plaats based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttPlaats` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttPlaats`, `i`
                                  FROM `plaats`
                              ) AS fst
                          WHERE fst.`AttPlaats` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `plaats`.`i` AS `id`
                                       , `plaats`.`neven` AS `Rechtbank`
                                       , `f1`.`ressort`
                                    FROM `plaats`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`ressort`
                                                   FROM `plaats` AS F0, `gerecht` AS F1
                                                  WHERE F0.`neven`=F1.`i`
                                               ) AS f1
                                      ON `f1`.`i`='".addslashes($id)."'
                                   WHERE `plaats`.`i`='".addslashes($id)."'"));
          $me['plaats Zitting']=(DB_doquer("SELECT DISTINCT `zitting`.`i` AS `id`
                                              FROM `zitting`
                                             WHERE `zitting`.`plaats`='".addslashes($id)."'"));
          $me['hoofdplaats']=firstCol(DB_doquer("SELECT DISTINCT `gerecht`.`i` AS `hoofdplaats`
                                                   FROM `gerecht`
                                                  WHERE `gerecht`.`hoofdplaats`='".addslashes($id)."'"));
          foreach($me['plaats Zitting'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Zitting`
                                         , `f3`.`griffier`
                                         , `f4`.`geagendeerd`
                                         , `f5`.`plaats`
                                         , `f6`.`locatie`
                                         , `f7`.`kamer`
                                      FROM `zitting`
                                      LEFT JOIN `zitting` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `zitting` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `zitting` AS f5 ON `f5`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `zitting` AS f6 ON `f6`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `zitting` AS f7 ON `f7`.`i`='".addslashes($v0['id'])."'
                                     WHERE `zitting`.`i`='".addslashes($v0['id'])."'"));
            $v0['rechter']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `rechter`
                                                 FROM `zitting`
                                                 JOIN `rechter` AS f1 ON `f1`.`zitting`='".addslashes($v0['id'])."'
                                                WHERE `zitting`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_Rechtbank($me['Rechtbank']);
          $this->set_ressort($me['ressort']);
          $this->set_plaatsZitting($me['plaats Zitting']);
          $this->set_hoofdplaats($me['hoofdplaats']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttPlaats` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttPlaats`, `i`
                                  FROM `plaats`
                              ) AS fst
                          WHERE fst.`AttPlaats` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "Rechtbank" => $this->_Rechtbank, "ressort" => $this->_ressort, "plaats Zitting" => $this->_plaatsZitting, "hoofdplaats" => $this->_hoofdplaats);
      foreach($me['plaats Zitting'] as $i0=>$v0){
        DB_doquer("INSERT IGNORE INTO `zitting` (`i`,`griffier`,`geagendeerd`,`plaats`,`locatie`,`kamer`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['griffier'])."', '".addslashes($v0['geagendeerd'])."', '".addslashes($v0['plaats'])."', '".addslashes($v0['locatie'])."', '".addslashes($v0['kamer'])."')", 5);
        if(mysql_affected_rows()==0 && $v0['id']!=null){
          //nothing inserted, try updating:
          DB_doquer("UPDATE `zitting` SET `i`='".addslashes($v0['id'])."', `griffier`='".addslashes($v0['griffier'])."', `geagendeerd`='".addslashes($v0['geagendeerd'])."', `plaats`='".addslashes($v0['plaats'])."', `locatie`='".addslashes($v0['locatie'])."', `kamer`='".addslashes($v0['kamer'])."' WHERE `i`='".addslashes($v0['Zitting'])."'", 5);
        }
      }
      foreach  ($me['plaats Zitting'] as $plaatsZitting){
        if(isset($me['id']))
          DB_doquer("UPDATE `zitting` SET `plaats`='".addslashes($me['id'])."' WHERE `i`='".addslashes($plaatsZitting['id'])."'", 5);
      }
      // no code for Zitting,i in zitting
      // no code for Rechtbank,i in gerecht
      // no code for locatie,i in gerecht
      // no code for hoofdplaats,i in gerecht
      foreach  ($me['hoofdplaats'] as $hoofdplaats){
        if(isset($me['id']))
          DB_doquer("UPDATE `gerecht` SET `hoofdplaats`='".addslashes($me['id'])."' WHERE `i`='".addslashes($hoofdplaats)."'", 5);
      }
      // no code for kamer,i in kamer
      DB_doquer("DELETE FROM `plaats` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `plaats` (`neven`,`i`) VALUES (".((null!=$me['Rechtbank'])?"'".addslashes($me['Rechtbank'])."'":"NULL").", '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      foreach($me['plaats Zitting'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `plaats` (`i`) VALUES ('".addslashes($v0['plaats'])."')", 5);
      }
      foreach($me['plaats Zitting'] as $i0=>$v0){
        foreach($v0['rechter'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['plaats Zitting'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['griffier'])."'",5);
      }
      foreach($me['plaats Zitting'] as $i0=>$v0){
        foreach($v0['rechter'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['plaats Zitting'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['griffier'])."')", 5);
      }
      foreach($me['plaats Zitting'] as $i0=>$v0){
        DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($v0['geagendeerd'])."'",5);
      }
      foreach($me['plaats Zitting'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `datum` (`i`) VALUES ('".addslashes($v0['geagendeerd'])."')", 5);
      }
      DB_doquer("DELETE FROM `gerechtshof` WHERE `i`='".addslashes($me['ressort'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `gerechtshof` (`i`) VALUES ('".addslashes($me['ressort'])."')", 5);
      foreach($me['plaats Zitting'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechter` WHERE `zitting`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['plaats Zitting'] as $i0=>$v0){
        foreach  ($v0['rechter'] as $rechter){
          $res=DB_doquer("INSERT IGNORE INTO `rechter` (`zitting`,`persoon`) VALUES ('".addslashes($v0['id'])."', '".addslashes($rechter)."')", 5);
        }
      }
      // no code for Zitting,zitting in rechter
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
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
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
      if (!checkRule42()){
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
      if (!checkRule46()){
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
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule69()){
        $DB_err='\"\"';
      } else
      if (!checkRule73()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "Rechtbank" => $this->_Rechtbank, "ressort" => $this->_ressort, "plaats Zitting" => $this->_plaatsZitting, "hoofdplaats" => $this->_hoofdplaats);
      DB_doquer("DELETE FROM `plaats` WHERE `i`='".addslashes($me['id'])."'",5);
      foreach($me['plaats Zitting'] as $i0=>$v0){
        foreach($v0['rechter'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['plaats Zitting'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['griffier'])."'",5);
      }
      foreach($me['plaats Zitting'] as $i0=>$v0){
        DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($v0['geagendeerd'])."'",5);
      }
      DB_doquer("DELETE FROM `gerechtshof` WHERE `i`='".addslashes($me['ressort'])."'",5);
      foreach($me['plaats Zitting'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechter` WHERE `zitting`='".addslashes($v0['id'])."'",5);
      }
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
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
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
      if (!checkRule42()){
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
      if (!checkRule46()){
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
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule69()){
        $DB_err='\"\"';
      } else
      if (!checkRule73()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Rechtbank($val){
      $this->_Rechtbank=$val;
    }
    function get_Rechtbank(){
      return $this->_Rechtbank;
    }
    function set_ressort($val){
      $this->_ressort=$val;
    }
    function get_ressort(){
      return $this->_ressort;
    }
    function set_plaatsZitting($val){
      $this->_plaatsZitting=$val;
    }
    function get_plaatsZitting(){
      if(!isset($this->_plaatsZitting)) return array();
      return $this->_plaatsZitting;
    }
    function set_hoofdplaats($val){
      $this->_hoofdplaats=$val;
    }
    function get_hoofdplaats(){
      if(!isset($this->_hoofdplaats)) return array();
      return $this->_hoofdplaats;
    }
    function setId($id){
      $this->_id=$id;
      return $this->_id;
    }
    function getId(){
      if($this->_id===null) return false;
      return $this->_id;
    }
    function isNew(){
      return $this->_new;
    }
  }

  function getEachPlaats(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `plaats`'));
  }

  function readPlaats($id){
      // check existence of $id
      $obj = new Plaats($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delPlaats($id){
    $tobeDeleted = new Plaats($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>