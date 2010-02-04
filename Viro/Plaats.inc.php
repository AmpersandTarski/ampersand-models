<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3733, file "VIRO.adl"
    SERVICE Plaats : I[Plaats]
   = [ Rechtbank : neven
     , ressort : neven;ressort
     , zittingen : plaats~
        = [ Zitting : [Zitting]
          , rechter : rechter
          , geagendeerd : geagendeerd
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
    private $_zittingen;
    private $_hoofdplaats;
    function Plaats($id=null, $Rechtbank=null, $ressort=null, $zittingen=null, $hoofdplaats=null){
      $this->_id=$id;
      $this->_Rechtbank=$Rechtbank;
      $this->_ressort=$ressort;
      $this->_zittingen=$zittingen;
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
          $me['zittingen']=(DB_doquer("SELECT DISTINCT `zitting`.`i` AS `id`
                                         FROM `zitting`
                                        WHERE `zitting`.`plaats`='".addslashes($id)."'"));
          $me['hoofdplaats']=firstCol(DB_doquer("SELECT DISTINCT `gerecht`.`i` AS `hoofdplaats`
                                                   FROM `gerecht`
                                                  WHERE `gerecht`.`hoofdplaats`='".addslashes($id)."'"));
          foreach($me['zittingen'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Zitting`
                                         , `f3`.`geagendeerd`
                                         , `f4`.`kamer`
                                      FROM `zitting`
                                      LEFT JOIN `zitting` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `zitting` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `zitting`.`i`='".addslashes($v0['id'])."'"));
            $v0['rechter']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `rechter`
                                                 FROM `zitting`
                                                 JOIN `rechter` AS f1 ON `f1`.`zitting`='".addslashes($v0['id'])."'
                                                WHERE `zitting`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_Rechtbank($me['Rechtbank']);
          $this->set_ressort($me['ressort']);
          $this->set_zittingen($me['zittingen']);
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
      $me=array("id"=>$this->getId(), "Rechtbank" => $this->_Rechtbank, "ressort" => $this->_ressort, "zittingen" => $this->_zittingen, "hoofdplaats" => $this->_hoofdplaats);
      foreach($me['zittingen'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `zitting` SET `i`='".addslashes($v0['id'])."', `geagendeerd`='".addslashes($v0['geagendeerd'])."', `kamer`='".addslashes($v0['kamer'])."' WHERE `i`='".addslashes($v0['Zitting'])."'", 5);
      }
      foreach  ($me['zittingen'] as $zittingen){
        if(isset($me['id']))
          DB_doquer("UPDATE `zitting` SET `plaats`='".addslashes($me['id'])."' WHERE `i`='".addslashes($zittingen['id'])."'", 5);
      }
      // no code for Zitting,i in zitting
      // no code for Rechtbank,i in gerecht
      // no code for hoofdplaats,i in gerecht
      foreach  ($me['hoofdplaats'] as $hoofdplaats){
        if(isset($me['id']))
          DB_doquer("UPDATE `gerecht` SET `hoofdplaats`='".addslashes($me['id'])."' WHERE `i`='".addslashes($hoofdplaats)."'", 5);
      }
      // no code for kamer,i in kamer
      DB_doquer("DELETE FROM `plaats` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `plaats` (`neven`,`i`) VALUES (".((null!=$me['Rechtbank'])?"'".addslashes($me['Rechtbank'])."'":"NULL").", '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      foreach($me['zittingen'] as $i0=>$v0){
        foreach($v0['rechter'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['zittingen'] as $i0=>$v0){
        foreach($v0['rechter'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($v0['geagendeerd'])."'",5);
      }
      foreach($me['zittingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `datum` (`i`) VALUES ('".addslashes($v0['geagendeerd'])."')", 5);
      }
      DB_doquer("DELETE FROM `gerechtshof` WHERE `i`='".addslashes($me['ressort'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `gerechtshof` (`i`) VALUES ('".addslashes($me['ressort'])."')", 5);
      foreach($me['zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechter` WHERE `zitting`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['zittingen'] as $i0=>$v0){
        foreach  ($v0['rechter'] as $rechter){
          $res=DB_doquer("INSERT IGNORE INTO `rechter` (`zitting`,`persoon`) VALUES ('".addslashes($v0['id'])."', '".addslashes($rechter)."')", 5);
        }
      }
      // no code for Zitting,zitting in rechter
      if (!checkRule3()){
        $DB_err='\"Alle zittingen worden geagendeerd\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Elke zitting vindt plaats in de hoofdvestigingsplaats van een gerecht of een van de nevenvestigingsplaatsen (tekst checken, Artikel 47 lid 2 RO)\"';
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
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "Rechtbank" => $this->_Rechtbank, "ressort" => $this->_ressort, "zittingen" => $this->_zittingen, "hoofdplaats" => $this->_hoofdplaats);
      DB_doquer("DELETE FROM `plaats` WHERE `i`='".addslashes($me['id'])."'",5);
      foreach($me['zittingen'] as $i0=>$v0){
        foreach($v0['rechter'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($v0['geagendeerd'])."'",5);
      }
      DB_doquer("DELETE FROM `gerechtshof` WHERE `i`='".addslashes($me['ressort'])."'",5);
      foreach($me['zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechter` WHERE `zitting`='".addslashes($v0['id'])."'",5);
      }
      if (!checkRule3()){
        $DB_err='\"Alle zittingen worden geagendeerd\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Elke zitting vindt plaats in de hoofdvestigingsplaats van een gerecht of een van de nevenvestigingsplaatsen (tekst checken, Artikel 47 lid 2 RO)\"';
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
    function set_zittingen($val){
      $this->_zittingen=$val;
    }
    function get_zittingen(){
      if(!isset($this->_zittingen)) return array();
      return $this->_zittingen;
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