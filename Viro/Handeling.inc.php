<?php // generated with ADL vs. 0.8.10-451
  
  /********* on line 460, file "VIRO.adl"
    SERVICE Handeling : I[Handeling]
   = [ door : handeling~;orgaan
     , object Objecttype : object
     , werkwoord : werkwoord
     , usecase : use_case~
        = [ omschrijving : omschrijving
          , super : sub
          , sub : sub~
          , fase : fase
          , categorie : categorie
          , opmerkingen : opmerkingen
          , formuliercodes : form
          , bron : bron
          , MoSCoW : prio
          , Component : iS_component_objecttype
          ]
     , rol : mag
     , grondslag : handeling~
        = [ artikel : [Artikel]
          , tekst : wetstekst
          ]
     , geregistreerde acties : type~
        = [ Actie : [Actie]
          , door : subject
          , type : type
          ]
     ]
   *********/
  
  class Handeling {
    protected $_id=false;
    protected $_new=true;
    private $_door;
    private $_objectObjecttype;
    private $_werkwoord;
    private $_usecase;
    private $_rol;
    private $_grondslag;
    private $_geregistreerdeacties;
    function Handeling($id=null, $door=null, $objectObjecttype=null, $werkwoord=null, $usecase=null, $rol=null, $grondslag=null, $geregistreerdeacties=null){
      $this->_id=$id;
      $this->_door=$door;
      $this->_objectObjecttype=$objectObjecttype;
      $this->_werkwoord=$werkwoord;
      $this->_usecase=$usecase;
      $this->_rol=$rol;
      $this->_grondslag=$grondslag;
      $this->_geregistreerdeacties=$geregistreerdeacties;
      if(!isset($door) && isset($id)){
        // get a Handeling based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttHandeling` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttHandeling`, `i`
                                  FROM `handeling`
                              ) AS fst
                          WHERE fst.`AttHandeling` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['door']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Orgaan` AS `door`
                                            FROM `handeling`
                                            JOIN  ( SELECT DISTINCT F0.`Handeling`, F1.`Orgaan`
                                                           FROM `handelingartikel` AS F0, `orgaanartikel` AS F1
                                                          WHERE F0.`artikel`=F1.`artikel`
                                                       ) AS f1
                                              ON `f1`.`Handeling`='".addslashes($id)."'
                                           WHERE `handeling`.`i`='".addslashes($id)."'"));
          $me['object Objecttype']=firstCol(DB_doquer("SELECT DISTINCT `object`.`objecttype` AS `object Objecttype`
                                                         FROM `object`
                                                        WHERE `object`.`handeling`='".addslashes($id)."'"));
          $me['werkwoord']=firstCol(DB_doquer("SELECT DISTINCT `werkwoordhandeling`.`werkwoord`
                                                 FROM `werkwoordhandeling`
                                                WHERE `werkwoordhandeling`.`handeling`='".addslashes($id)."'"));
          $me['usecase']=(DB_doquer("SELECT DISTINCT `f1`.`usecase` AS `id`
                                       FROM `handeling`
                                       JOIN `use_case` AS f1 ON `f1`.`Handeling`='".addslashes($id)."'
                                      WHERE `handeling`.`i`='".addslashes($id)."'"));
          $me['rol']=firstCol(DB_doquer("SELECT DISTINCT `mag`.`rol`
                                           FROM `mag`
                                          WHERE `mag`.`handeling`='".addslashes($id)."'"));
          $me['grondslag']=(DB_doquer("SELECT DISTINCT `f1`.`artikel` AS `id`
                                         FROM `handeling`
                                         JOIN `handelingartikel` AS f1 ON `f1`.`Handeling`='".addslashes($id)."'
                                        WHERE `handeling`.`i`='".addslashes($id)."'"));
          $me['geregistreerde acties']=(DB_doquer("SELECT DISTINCT `actie`.`i` AS `id`
                                                     FROM `actie`
                                                    WHERE `actie`.`type`='".addslashes($id)."'"));
          foreach($me['usecase'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`omschrijving`
                                         , `f3`.`categorie`
                                         , `f4`.`opmerkingen`
                                         , `f5`.`form` AS `formuliercodes`
                                         , `f6`.`bron`
                                         , `f7`.`prio` AS `MoSCoW`
                                         , `f8`.`is_component_objecttype` AS `Component`
                                      FROM `usecase`
                                      LEFT JOIN `usecase` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `usecase` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `usecase` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `usecase` AS f5 ON `f5`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `usecase` AS f6 ON `f6`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `usecase` AS f7 ON `f7`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `usecase` AS f8 ON `f8`.`i`='".addslashes($v0['id'])."'
                                     WHERE `usecase`.`i`='".addslashes($v0['id'])."'"));
            $v0['super']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`usecase1` AS `super`
                                               FROM `usecase`
                                               JOIN `sub` AS f1 ON `f1`.`usecase`='".addslashes($v0['id'])."'
                                              WHERE `usecase`.`i`='".addslashes($v0['id'])."'"));
            $v0['sub']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`usecase` AS `sub`
                                             FROM `usecase`
                                             JOIN `sub` AS f1 ON `f1`.`usecase1`='".addslashes($v0['id'])."'
                                            WHERE `usecase`.`i`='".addslashes($v0['id'])."'"));
            $v0['fase']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Fase` AS `fase`
                                              FROM `usecase`
                                              JOIN `faseusecase` AS f1 ON `f1`.`usecase`='".addslashes($v0['id'])."'
                                             WHERE `usecase`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['grondslag'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `artikel`
                                      FROM `artikel`
                                     WHERE `artikel`.`i`='".addslashes($v0['id'])."'"));
            $v0['tekst']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Tekst` AS `tekst`
                                               FROM `artikel`
                                               JOIN `wetstekst` AS f1 ON `f1`.`artikel`='".addslashes($v0['id'])."'
                                              WHERE `artikel`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['geregistreerde acties'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Actie`
                                         , `f3`.`subject` AS `door`
                                         , `f4`.`type`
                                      FROM `actie`
                                      LEFT JOIN `actie` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `actie` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `actie`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_door($me['door']);
          $this->set_objectObjecttype($me['object Objecttype']);
          $this->set_werkwoord($me['werkwoord']);
          $this->set_usecase($me['usecase']);
          $this->set_rol($me['rol']);
          $this->set_grondslag($me['grondslag']);
          $this->set_geregistreerdeacties($me['geregistreerde acties']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttHandeling` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttHandeling`, `i`
                                  FROM `handeling`
                              ) AS fst
                          WHERE fst.`AttHandeling` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "door" => $this->_door, "object Objecttype" => $this->_objectObjecttype, "werkwoord" => $this->_werkwoord, "usecase" => $this->_usecase, "rol" => $this->_rol, "grondslag" => $this->_grondslag, "geregistreerde acties" => $this->_geregistreerdeacties);
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `usecase` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `usecase` (`i`,`omschrijving`,`categorie`,`opmerkingen`,`form`,`bron`,`prio`,`is_component_objecttype`) VALUES ('".addslashes($v0['id'])."', ".((null!=$v0['omschrijving'])?"'".addslashes($v0['omschrijving'])."'":"NULL").", ".((null!=$v0['categorie'])?"'".addslashes($v0['categorie'])."'":"NULL").", ".((null!=$v0['opmerkingen'])?"'".addslashes($v0['opmerkingen'])."'":"NULL").", ".((null!=$v0['formuliercodes'])?"'".addslashes($v0['formuliercodes'])."'":"NULL").", ".((null!=$v0['bron'])?"'".addslashes($v0['bron'])."'":"NULL").", ".((null!=$v0['MoSCoW'])?"'".addslashes($v0['MoSCoW'])."'":"NULL").", ".((null!=$v0['Component'])?"'".addslashes($v0['Component'])."'":"NULL").")", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['usecase'] as $i0=>$v0){
        foreach($v0['super'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `usecase` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['usecase'] as $i0=>$v0){
        foreach($v0['sub'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `usecase` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['geregistreerde acties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `actie` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['geregistreerde acties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `actie` (`i`,`subject`,`type`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['door'])."', '".addslashes($v0['type'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach  ($me['geregistreerde acties'] as $geregistreerdeacties){
        if(isset($me['id']))
          DB_doquer("UPDATE `actie` SET `type`='".addslashes($me['id'])."' WHERE `i`='".addslashes($geregistreerdeacties['id'])."'", 5);
      }
      // no code for Actie,i in actie
      foreach($me['door'] as $i0=>$v0){
        DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['door'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `orgaan` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['geregistreerde acties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['door'])."'",5);
      }
      foreach($me['geregistreerde acties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['door'])."')", 5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v0['omschrijving'])."'",5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v0['opmerkingen'])."'",5);
      }
      foreach($me['grondslag'] as $i0=>$v0){
        foreach($v0['tekst'] as $i1=>$v1){
          DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['usecase'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `tekst` (`i`) VALUES ('".addslashes($v0['omschrijving'])."')", 5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `tekst` (`i`) VALUES ('".addslashes($v0['opmerkingen'])."')", 5);
      }
      foreach($me['grondslag'] as $i0=>$v0){
        foreach($v0['tekst'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `tekst` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['grondslag'] as $i0=>$v0){
        DB_doquer("DELETE FROM `artikel` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['grondslag'] as $i0=>$v0){
        DB_doquer("DELETE FROM `artikel` WHERE `i`='".addslashes($v0['artikel'])."'",5);
      }
      foreach($me['grondslag'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `artikel` (`i`) VALUES ('".addslashes($v0['id'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['grondslag'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `artikel` (`i`) VALUES ('".addslashes($v0['artikel'])."')", 5);
      }
      foreach($me['geregistreerde acties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      foreach($me['geregistreerde acties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `handeling` (`i`) VALUES ('".addslashes($v0['type'])."')", 5);
      }
      foreach($me['object Objecttype'] as $i0=>$v0){
        DB_doquer("DELETE FROM `objecttype` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['object Objecttype'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `objecttype` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['werkwoord'] as $i0=>$v0){
        DB_doquer("DELETE FROM `werkwoord` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['werkwoord'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `werkwoord` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['rol'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['rol'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `rol` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `moscow` WHERE `i`='".addslashes($v0['MoSCoW'])."'",5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `moscow` (`i`) VALUES ('".addslashes($v0['MoSCoW'])."')", 5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        foreach($v0['fase'] as $i1=>$v1){
          DB_doquer("DELETE FROM `fase` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['usecase'] as $i0=>$v0){
        foreach($v0['fase'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `fase` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `gpstap` WHERE `i`='".addslashes($v0['categorie'])."'",5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `gpstap` (`i`) VALUES ('".addslashes($v0['categorie'])."')", 5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `component` WHERE `i`='".addslashes($v0['Component'])."'",5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `component` (`i`) VALUES ('".addslashes($v0['Component'])."')", 5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `formcodes` WHERE `i`='".addslashes($v0['formuliercodes'])."'",5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `formcodes` (`i`) VALUES ('".addslashes($v0['formuliercodes'])."')", 5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `referentie` WHERE `i`='".addslashes($v0['bron'])."'",5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `referentie` (`i`) VALUES ('".addslashes($v0['bron'])."')", 5);
      }
      foreach($me['grondslag'] as $i0=>$v0){
        DB_doquer("DELETE FROM `wetstekst` WHERE `artikel`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['grondslag'] as $i0=>$v0){
        foreach  ($v0['tekst'] as $tekst){
          $res=DB_doquer("INSERT IGNORE INTO `wetstekst` (`tekst`,`artikel`) VALUES ('".addslashes($tekst)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      DB_doquer("DELETE FROM `object` WHERE `handeling`='".addslashes($me['id'])."'",5);
      foreach  ($me['object Objecttype'] as $objectObjecttype){
        $res=DB_doquer("INSERT IGNORE INTO `object` (`objecttype`,`handeling`) VALUES ('".addslashes($objectObjecttype)."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `werkwoordhandeling` WHERE `handeling`='".addslashes($me['id'])."'",5);
      foreach  ($me['werkwoord'] as $werkwoord){
        $res=DB_doquer("INSERT IGNORE INTO `werkwoordhandeling` (`werkwoord`,`handeling`) VALUES ('".addslashes($werkwoord)."', '".addslashes($me['id'])."')", 5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `sub` WHERE `usecase`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `sub` WHERE `usecase1`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        foreach  ($v0['super'] as $super){
          $res=DB_doquer("INSERT IGNORE INTO `sub` (`usecase1`,`usecase`) VALUES ('".addslashes($super)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      foreach($me['usecase'] as $i0=>$v0){
        foreach  ($v0['sub'] as $sub){
          $res=DB_doquer("INSERT IGNORE INTO `sub` (`usecase`,`usecase1`) VALUES ('".addslashes($sub)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      DB_doquer("DELETE FROM `mag` WHERE `handeling`='".addslashes($me['id'])."'",5);
      foreach  ($me['rol'] as $rol){
        $res=DB_doquer("INSERT IGNORE INTO `mag` (`rol`,`handeling`) VALUES ('".addslashes($rol)."', '".addslashes($me['id'])."')", 5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `faseusecase` WHERE `usecase`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        foreach  ($v0['fase'] as $fase){
          $res=DB_doquer("INSERT IGNORE INTO `faseusecase` (`fase`,`usecase`) VALUES ('".addslashes($fase)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat als vertegenwoordiger van het orgaan dat de handeling uitvoert\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule31()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
        $DB_err='\"\"';
      } else
      if (!checkRule54()){
        $DB_err='\"\"';
      } else
      if (!checkRule55()){
        $DB_err='\"\"';
      } else
      if (!checkRule56()){
        $DB_err='\"\"';
      } else
      if (!checkRule57()){
        $DB_err='\"\"';
      } else
      if (!checkRule58()){
        $DB_err='\"\"';
      } else
      if (!checkRule59()){
        $DB_err='\"\"';
      } else
      if (!checkRule60()){
        $DB_err='\"\"';
      } else
      if (!checkRule61()){
        $DB_err='\"\"';
      } else
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule69()){
        $DB_err='\"\"';
      } else
      if (!checkRule71()){
        $DB_err='\"\"';
      } else
      if (!checkRule73()){
        $DB_err='\"\"';
      } else
      if (!checkRule79()){
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
      $me=array("id"=>$this->getId(), "door" => $this->_door, "object Objecttype" => $this->_objectObjecttype, "werkwoord" => $this->_werkwoord, "usecase" => $this->_usecase, "rol" => $this->_rol, "grondslag" => $this->_grondslag, "geregistreerde acties" => $this->_geregistreerdeacties);
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `usecase` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['geregistreerde acties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `actie` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['door'] as $i0=>$v0){
        DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['geregistreerde acties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['door'])."'",5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v0['omschrijving'])."'",5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v0['opmerkingen'])."'",5);
      }
      foreach($me['grondslag'] as $i0=>$v0){
        foreach($v0['tekst'] as $i1=>$v1){
          DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['grondslag'] as $i0=>$v0){
        DB_doquer("DELETE FROM `artikel` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['grondslag'] as $i0=>$v0){
        DB_doquer("DELETE FROM `artikel` WHERE `i`='".addslashes($v0['artikel'])."'",5);
      }
      foreach($me['geregistreerde acties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      foreach($me['object Objecttype'] as $i0=>$v0){
        DB_doquer("DELETE FROM `objecttype` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['werkwoord'] as $i0=>$v0){
        DB_doquer("DELETE FROM `werkwoord` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['rol'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rol` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `moscow` WHERE `i`='".addslashes($v0['MoSCoW'])."'",5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        foreach($v0['fase'] as $i1=>$v1){
          DB_doquer("DELETE FROM `fase` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `gpstap` WHERE `i`='".addslashes($v0['categorie'])."'",5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `component` WHERE `i`='".addslashes($v0['Component'])."'",5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `formcodes` WHERE `i`='".addslashes($v0['formuliercodes'])."'",5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `referentie` WHERE `i`='".addslashes($v0['bron'])."'",5);
      }
      foreach($me['grondslag'] as $i0=>$v0){
        DB_doquer("DELETE FROM `wetstekst` WHERE `artikel`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `object` WHERE `handeling`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `werkwoordhandeling` WHERE `handeling`='".addslashes($me['id'])."'",5);
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `sub` WHERE `usecase`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `sub` WHERE `usecase1`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `mag` WHERE `handeling`='".addslashes($me['id'])."'",5);
      foreach($me['usecase'] as $i0=>$v0){
        DB_doquer("DELETE FROM `faseusecase` WHERE `usecase`='".addslashes($v0['id'])."'",5);
      }
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat als vertegenwoordiger van het orgaan dat de handeling uitvoert\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule31()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
        $DB_err='\"\"';
      } else
      if (!checkRule54()){
        $DB_err='\"\"';
      } else
      if (!checkRule55()){
        $DB_err='\"\"';
      } else
      if (!checkRule56()){
        $DB_err='\"\"';
      } else
      if (!checkRule57()){
        $DB_err='\"\"';
      } else
      if (!checkRule58()){
        $DB_err='\"\"';
      } else
      if (!checkRule59()){
        $DB_err='\"\"';
      } else
      if (!checkRule60()){
        $DB_err='\"\"';
      } else
      if (!checkRule61()){
        $DB_err='\"\"';
      } else
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule69()){
        $DB_err='\"\"';
      } else
      if (!checkRule71()){
        $DB_err='\"\"';
      } else
      if (!checkRule73()){
        $DB_err='\"\"';
      } else
      if (!checkRule79()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_door($val){
      $this->_door=$val;
    }
    function get_door(){
      if(!isset($this->_door)) return array();
      return $this->_door;
    }
    function set_objectObjecttype($val){
      $this->_objectObjecttype=$val;
    }
    function get_objectObjecttype(){
      if(!isset($this->_objectObjecttype)) return array();
      return $this->_objectObjecttype;
    }
    function set_werkwoord($val){
      $this->_werkwoord=$val;
    }
    function get_werkwoord(){
      if(!isset($this->_werkwoord)) return array();
      return $this->_werkwoord;
    }
    function set_usecase($val){
      $this->_usecase=$val;
    }
    function get_usecase(){
      if(!isset($this->_usecase)) return array();
      return $this->_usecase;
    }
    function set_rol($val){
      $this->_rol=$val;
    }
    function get_rol(){
      if(!isset($this->_rol)) return array();
      return $this->_rol;
    }
    function set_grondslag($val){
      $this->_grondslag=$val;
    }
    function get_grondslag(){
      if(!isset($this->_grondslag)) return array();
      return $this->_grondslag;
    }
    function set_geregistreerdeacties($val){
      $this->_geregistreerdeacties=$val;
    }
    function get_geregistreerdeacties(){
      if(!isset($this->_geregistreerdeacties)) return array();
      return $this->_geregistreerdeacties;
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

  function getEachHandeling(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `handeling`'));
  }

  function readHandeling($id){
      // check existence of $id
      $obj = new Handeling($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delHandeling($id){
    $tobeDeleted = new Handeling($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>