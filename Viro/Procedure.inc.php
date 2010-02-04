<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3623, file "VIRO.adl"
    SERVICE Procedure : I[Procedur]
   = [ eiser : eiser~
     , gemachtigde voor eiser : (eiser~;door~/\inzake~);gemachtigde~
     , gedaagde : gedaagde~
     , gemachtigde voor gedaagde : (gedaagde~;door~/\inzake~);gemachtigde~
     , gevoegd : gevoegde~
     , gemachtigde voor gevoegde : (gevoegde~;door~/\inzake~);gemachtigde~
     , rechtsgebied : rechtsgebied
     , proceduresoort : proceduresoort
     , zitting : zaak~;zitting
        = [ kamer : kamer
          , geagendeerd : geagendeerd
          , rechter : rechter
          , griffier : griffier
          ]
     , behandeling : zaak~
        = [ rolnummer : [Behandeling]
          , zittingsnummer : zitting
          , zaaknummer : zaak
          ]
     , bevoegd : bevoegd
     , zorgdrager voor dossier : zorgdrager
     , zaaksdossier : zaaksdossier~
        = [ Document : [Document]
          , type : type
          ]
     , cluster : cluster
        = [ nr : [Cluster]
          , naam : naam
          , grond : grond
          ]
     , machtigingen : inzake~
        = [ machtiging : [Machtiging]
          , partij : door
          , gemachtigde : gemachtigde~
          ]
     , zittingen : zaak~
        = [ behandeling : zitting
             = [ zitting : [Zitting]
               , rechter : rechter
               , locatie : locatie
               , kamer : kamer
               ]
          ]
     ]
   *********/
  
  class Procedure {
    protected $_id=false;
    protected $_new=true;
    private $_eiser;
    private $_gemachtigdevooreiser;
    private $_gedaagde;
    private $_gemachtigdevoorgedaagde;
    private $_gevoegd;
    private $_gemachtigdevoorgevoegde;
    private $_rechtsgebied;
    private $_proceduresoort;
    private $_zitting;
    private $_behandeling;
    private $_bevoegd;
    private $_zorgdragervoordossier;
    private $_zaaksdossier;
    private $_cluster;
    private $_machtigingen;
    private $_zittingen;
    function Procedure($id=null, $eiser=null, $gemachtigdevooreiser=null, $gedaagde=null, $gemachtigdevoorgedaagde=null, $gevoegd=null, $gemachtigdevoorgevoegde=null, $rechtsgebied=null, $proceduresoort=null, $zitting=null, $behandeling=null, $bevoegd=null, $zorgdragervoordossier=null, $zaaksdossier=null, $cluster=null, $machtigingen=null, $zittingen=null){
      $this->_id=$id;
      $this->_eiser=$eiser;
      $this->_gemachtigdevooreiser=$gemachtigdevooreiser;
      $this->_gedaagde=$gedaagde;
      $this->_gemachtigdevoorgedaagde=$gemachtigdevoorgedaagde;
      $this->_gevoegd=$gevoegd;
      $this->_gemachtigdevoorgevoegde=$gemachtigdevoorgevoegde;
      $this->_rechtsgebied=$rechtsgebied;
      $this->_proceduresoort=$proceduresoort;
      $this->_zitting=$zitting;
      $this->_behandeling=$behandeling;
      $this->_bevoegd=$bevoegd;
      $this->_zorgdragervoordossier=$zorgdragervoordossier;
      $this->_zaaksdossier=$zaaksdossier;
      $this->_cluster=$cluster;
      $this->_machtigingen=$machtigingen;
      $this->_zittingen=$zittingen;
      if(!isset($eiser) && isset($id)){
        // get a Procedure based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttProcedur` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttProcedur`, `i`
                                  FROM `procedur`
                              ) AS fst
                          WHERE fst.`AttProcedur` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `eiser`.`procedur` AS `id`
                                       , `procedur`.`rechtsgebied`
                                       , `procedur`.`proceduresoort`
                                       , `procedur`.`zorgdrager` AS `zorgdrager voor dossier`
                                    FROM `eiser`
                                    LEFT JOIN `procedur` ON `procedur`.`i`='".addslashes($id)."'
                                   WHERE `eiser`.`procedur`='".addslashes($id)."'"));
          $me['eiser']=firstCol(DB_doquer("SELECT DISTINCT `eiser`.`persoon` AS `eiser`
                                             FROM `eiser`
                                            WHERE `eiser`.`procedur`='".addslashes($id)."'"));
          $me['gemachtigde voor eiser']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `gemachtigde voor eiser`
                                                              FROM `procedur`
                                                              JOIN  ( SELECT DISTINCT F0.`procedur`, F1.`persoon`
                                                                             FROM 
                                                                                ( SELECT DISTINCT isect0.`procedur`, isect0.`i`
                                                                                    FROM 
                                                                                       ( SELECT DISTINCT F0.`procedur`, F1.`i`
                                                                                           FROM `eiser` AS F0, `machtiging` AS F1
                                                                                          WHERE F0.`persoon`=F1.`door`
                                                                                       ) AS isect0, `inzake` AS isect1
                                                                                   WHERE (isect0.`procedur` = isect1.`Procedur` AND isect0.`i` = isect1.`machtiging`) AND isect0.`procedur` IS NOT NULL AND isect0.`i` IS NOT NULL
                                                                                ) AS F0, `gemachtigde` AS F1
                                                                            WHERE F0.`i`=F1.`machtiging`
                                                                         ) AS f1
                                                                ON `f1`.`procedur`='".addslashes($id)."'
                                                             WHERE `procedur`.`i`='".addslashes($id)."'"));
          $me['gedaagde']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `gedaagde`
                                                FROM `procedur`
                                                JOIN `gedaagde` AS f1 ON `f1`.`Procedur`='".addslashes($id)."'
                                               WHERE `procedur`.`i`='".addslashes($id)."'"));
          $me['gemachtigde voor gedaagde']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `gemachtigde voor gedaagde`
                                                                 FROM `procedur`
                                                                 JOIN  ( SELECT DISTINCT F0.`Procedur`, F1.`persoon`
                                                                                FROM 
                                                                                   ( SELECT DISTINCT isect0.`Procedur`, isect0.`i`
                                                                                       FROM 
                                                                                          ( SELECT DISTINCT F0.`Procedur`, F1.`i`
                                                                                              FROM `gedaagde` AS F0, `machtiging` AS F1
                                                                                             WHERE F0.`persoon`=F1.`door`
                                                                                          ) AS isect0, `inzake` AS isect1
                                                                                      WHERE (isect0.`Procedur` = isect1.`Procedur` AND isect0.`i` = isect1.`machtiging`) AND isect0.`Procedur` IS NOT NULL AND isect0.`i` IS NOT NULL
                                                                                   ) AS F0, `gemachtigde` AS F1
                                                                               WHERE F0.`i`=F1.`machtiging`
                                                                            ) AS f1
                                                                   ON `f1`.`Procedur`='".addslashes($id)."'
                                                                WHERE `procedur`.`i`='".addslashes($id)."'"));
          $me['gevoegd']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `gevoegd`
                                               FROM `procedur`
                                               JOIN `gevoegde` AS f1 ON `f1`.`Procedur`='".addslashes($id)."'
                                              WHERE `procedur`.`i`='".addslashes($id)."'"));
          $me['gemachtigde voor gevoegde']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `gemachtigde voor gevoegde`
                                                                 FROM `procedur`
                                                                 JOIN  ( SELECT DISTINCT F0.`Procedur`, F1.`persoon`
                                                                                FROM 
                                                                                   ( SELECT DISTINCT isect0.`Procedur`, isect0.`i`
                                                                                       FROM 
                                                                                          ( SELECT DISTINCT F0.`Procedur`, F1.`i`
                                                                                              FROM `gevoegde` AS F0, `machtiging` AS F1
                                                                                             WHERE F0.`persoon`=F1.`door`
                                                                                          ) AS isect0, `inzake` AS isect1
                                                                                      WHERE (isect0.`Procedur` = isect1.`Procedur` AND isect0.`i` = isect1.`machtiging`) AND isect0.`Procedur` IS NOT NULL AND isect0.`i` IS NOT NULL
                                                                                   ) AS F0, `gemachtigde` AS F1
                                                                               WHERE F0.`i`=F1.`machtiging`
                                                                            ) AS f1
                                                                   ON `f1`.`Procedur`='".addslashes($id)."'
                                                                WHERE `procedur`.`i`='".addslashes($id)."'"));
          $me['zitting']=(DB_doquer("SELECT DISTINCT `behandeling`.`zitting` AS `id`
                                       FROM `behandeling`
                                      WHERE `behandeling`.`zaak`='".addslashes($id)."'"));
          $me['behandeling']=(DB_doquer("SELECT DISTINCT `behandeling`.`i` AS `id`
                                           FROM `behandeling`
                                          WHERE `behandeling`.`zaak`='".addslashes($id)."'"));
          $me['bevoegd']=firstCol(DB_doquer("SELECT DISTINCT `bevoegd`.`gerecht` AS `bevoegd`
                                               FROM `bevoegd`
                                              WHERE `bevoegd`.`procedur`='".addslashes($id)."'"));
          $me['zaaksdossier']=(DB_doquer("SELECT DISTINCT `f1`.`document` AS `id`
                                            FROM `procedur`
                                            JOIN `zaaksdossier` AS f1 ON `f1`.`Procedur`='".addslashes($id)."'
                                           WHERE `procedur`.`i`='".addslashes($id)."'"));
          $me['cluster']=(DB_doquer("SELECT DISTINCT `clusterprocedur`.`cluster` AS `id`
                                       FROM `clusterprocedur`
                                      WHERE `clusterprocedur`.`procedur`='".addslashes($id)."'"));
          $me['machtigingen']=(DB_doquer("SELECT DISTINCT `f1`.`machtiging` AS `id`
                                            FROM `procedur`
                                            JOIN `inzake` AS f1 ON `f1`.`Procedur`='".addslashes($id)."'
                                           WHERE `procedur`.`i`='".addslashes($id)."'"));
          $me['zittingen']=(DB_doquer("SELECT DISTINCT `behandeling`.`i` AS `id`
                                         FROM `behandeling`
                                        WHERE `behandeling`.`zaak`='".addslashes($id)."'"));
          foreach($me['zitting'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`kamer`
                                         , `f3`.`geagendeerd`
                                         , `f4`.`griffier`
                                      FROM `zitting`
                                      LEFT JOIN `zitting` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `zitting` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `zitting` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `zitting`.`i`='".addslashes($v0['id'])."'"));
            $v0['rechter']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `rechter`
                                                 FROM `zitting`
                                                 JOIN `rechter` AS f1 ON `f1`.`zitting`='".addslashes($v0['id'])."'
                                                WHERE `zitting`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['behandeling'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `rolnummer`
                                         , `f3`.`zitting` AS `zittingsnummer`
                                         , `f4`.`zaak` AS `zaaknummer`
                                      FROM `behandeling`
                                      LEFT JOIN `behandeling` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `behandeling` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `behandeling`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['zaaksdossier'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Document`
                                         , `f3`.`type`
                                      FROM `document`
                                      LEFT JOIN `document` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                     WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['cluster'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `nr`
                                         , `f3`.`naam`
                                      FROM `cluster`
                                      LEFT JOIN `cluster` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                     WHERE `cluster`.`i`='".addslashes($v0['id'])."'"));
            $v0['grond']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`tekst` AS `grond`
                                               FROM `cluster`
                                               JOIN `grond` AS f1 ON `f1`.`cluster`='".addslashes($v0['id'])."'
                                              WHERE `cluster`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['machtigingen'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `machtiging`
                                         , `f3`.`door` AS `partij`
                                      FROM `machtiging`
                                      LEFT JOIN `machtiging` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                     WHERE `machtiging`.`i`='".addslashes($v0['id'])."'"));
            $v0['gemachtigde']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `gemachtigde`
                                                     FROM `machtiging`
                                                     JOIN `gemachtigde` AS f1 ON `f1`.`machtiging`='".addslashes($v0['id'])."'
                                                    WHERE `machtiging`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['zittingen'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`zitting` AS `behandeling`
                                      FROM `behandeling`
                                      LEFT JOIN `behandeling` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                     WHERE `behandeling`.`i`='".addslashes($v0['id'])."'"));
            $v1 = $v0['behandeling'];
            $v0['behandeling']=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v1)."' AS `id`
                                                        , '".addslashes($v1)."' AS `zitting`
                                                        , `f3`.`locatie`
                                                        , `f4`.`kamer`
                                                     FROM `zitting`
                                                     LEFT JOIN `zitting` AS f3 ON `f3`.`i`='".addslashes($v1)."'
                                                     LEFT JOIN `zitting` AS f4 ON `f4`.`i`='".addslashes($v1)."'
                                                    WHERE `zitting`.`i`='".addslashes($v1)."'"));
            $v0['behandeling']['rechter']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `rechter`
                                                                FROM `zitting`
                                                                JOIN `rechter` AS f1 ON `f1`.`zitting`='".addslashes($v1)."'
                                                               WHERE `zitting`.`i`='".addslashes($v1)."'"));
          }
          unset($v0);
          $this->set_eiser($me['eiser']);
          $this->set_gemachtigdevooreiser($me['gemachtigde voor eiser']);
          $this->set_gedaagde($me['gedaagde']);
          $this->set_gemachtigdevoorgedaagde($me['gemachtigde voor gedaagde']);
          $this->set_gevoegd($me['gevoegd']);
          $this->set_gemachtigdevoorgevoegde($me['gemachtigde voor gevoegde']);
          $this->set_rechtsgebied($me['rechtsgebied']);
          $this->set_proceduresoort($me['proceduresoort']);
          $this->set_zitting($me['zitting']);
          $this->set_behandeling($me['behandeling']);
          $this->set_bevoegd($me['bevoegd']);
          $this->set_zorgdragervoordossier($me['zorgdrager voor dossier']);
          $this->set_zaaksdossier($me['zaaksdossier']);
          $this->set_cluster($me['cluster']);
          $this->set_machtigingen($me['machtigingen']);
          $this->set_zittingen($me['zittingen']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttProcedur` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttProcedur`, `i`
                                  FROM `procedur`
                              ) AS fst
                          WHERE fst.`AttProcedur` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "eiser" => $this->_eiser, "gemachtigde voor eiser" => $this->_gemachtigdevooreiser, "gedaagde" => $this->_gedaagde, "gemachtigde voor gedaagde" => $this->_gemachtigdevoorgedaagde, "gevoegd" => $this->_gevoegd, "gemachtigde voor gevoegde" => $this->_gemachtigdevoorgevoegde, "rechtsgebied" => $this->_rechtsgebied, "proceduresoort" => $this->_proceduresoort, "zitting" => $this->_zitting, "behandeling" => $this->_behandeling, "bevoegd" => $this->_bevoegd, "zorgdrager voor dossier" => $this->_zorgdragervoordossier, "zaaksdossier" => $this->_zaaksdossier, "cluster" => $this->_cluster, "machtigingen" => $this->_machtigingen, "zittingen" => $this->_zittingen);
      foreach($me['zitting'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `zitting` SET `kamer`='".addslashes($v0['kamer'])."', `geagendeerd`='".addslashes($v0['geagendeerd'])."', `griffier`='".addslashes($v0['griffier'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
      }
      // no code for zittingsnummer,i in zitting
      foreach($me['zittingen'] as $i0=>$v0){
        if(isset($v0['behandeling']['id']))
          DB_doquer("UPDATE `zitting` SET `i`='".addslashes($v0['behandeling']['id'])."', `locatie`='".addslashes($v0['behandeling']['locatie'])."', `kamer`='".addslashes($v0['behandeling']['kamer'])."' WHERE `i`='".addslashes($v0['behandeling']['zitting'])."'", 5);
      }
      // no code for zitting,i in zitting
      foreach($me['zaaksdossier'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `document` SET `i`='".addslashes($v0['id'])."', `type`='".addslashes($v0['type'])."' WHERE `i`='".addslashes($v0['Document'])."'", 5);
      }
      // no code for Document,i in document
      DB_doquer("DELETE FROM `procedur` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `procedur` (`rechtsgebied`,`proceduresoort`,`zorgdrager`,`i`) VALUES ('".addslashes($me['rechtsgebied'])."', '".addslashes($me['proceduresoort'])."', '".addslashes($me['zorgdrager voor dossier'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for zaaknummer,i in procedur
      DB_doquer("DELETE FROM `behandeling` WHERE `zaak`='".addslashes($me['id'])."'",5);
      foreach($me['behandeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `behandeling` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach  ($me['zitting'] as $zitting){
        foreach  ($me['behandeling'] as $behandeling){
          foreach  ($me['zittingen'] as $zittingen){
            $res=DB_doquer("INSERT IGNORE INTO `behandeling` (`zitting`,`i`,`zaak`) VALUES ('".addslashes($zitting['id'])."', '".addslashes($behandeling['id'])."', '".addslashes($me['id'])."')", 5);
            if($newID) $this->setId($me['id']=mysql_insert_id());
          }
        }
      }
      foreach($me['behandeling'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `behandeling` (`i`,`zitting`,`zaak`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['zittingsnummer'])."', '".addslashes($v0['zaaknummer'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for rolnummer,i in behandeling
      foreach($me['zittingen'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `behandeling` SET `zitting`='".addslashes($v0['behandeling']['id'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
      }
      // no code for bevoegd,i in gerecht
      // no code for locatie,i in gerecht
      // no code for kamer,i in kamer
      // no code for kamer,i in kamer
      foreach($me['machtigingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `machtiging` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['machtigingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `machtiging` (`i`,`door`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['partij'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for machtiging,i in machtiging
      foreach($me['cluster'] as $i0=>$v0){
        DB_doquer("DELETE FROM `cluster` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['cluster'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `cluster` (`i`,`naam`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['naam'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for nr,i in cluster
      foreach($me['zaaksdossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      foreach($me['zaaksdossier'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `documenttype` (`i`) VALUES ('".addslashes($v0['type'])."')", 5);
      }
      DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($me['zorgdrager voor dossier'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `orgaan` (`i`) VALUES ('".addslashes($me['zorgdrager voor dossier'])."')", 5);
      foreach($me['eiser'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['gemachtigde voor eiser'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['gemachtigde voor gedaagde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['gevoegd'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['gemachtigde voor gevoegde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['zitting'] as $i0=>$v0){
        foreach($v0['rechter'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['zitting'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['griffier'])."'",5);
      }
      foreach($me['machtigingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['partij'])."'",5);
      }
      foreach($me['machtigingen'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['zittingen'] as $i0=>$v0){
        foreach($v0['behandeling']['rechter'] as $i2=>$v2){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v2)."'",5);
        }
      }
      foreach($me['eiser'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['gemachtigde voor eiser'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['gemachtigde voor gedaagde'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['gevoegd'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['gemachtigde voor gevoegde'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['zitting'] as $i0=>$v0){
        foreach($v0['rechter'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['zitting'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['griffier'])."')", 5);
      }
      foreach($me['machtigingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['partij'])."')", 5);
      }
      foreach($me['machtigingen'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['zittingen'] as $i0=>$v0){
        foreach($v0['behandeling']['rechter'] as $i2=>$v2){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v2)."')", 5);
        }
      }
      DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($me['rechtsgebied'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `rechtsgebied` (`i`) VALUES ('".addslashes($me['rechtsgebied'])."')", 5);
      DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($me['proceduresoort'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `proceduresoort` (`i`) VALUES ('".addslashes($me['proceduresoort'])."')", 5);
      foreach($me['cluster'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v0['naam'])."'",5);
      }
      foreach($me['cluster'] as $i0=>$v0){
        foreach($v0['grond'] as $i1=>$v1){
          DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['cluster'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `tekst` (`i`) VALUES ('".addslashes($v0['naam'])."')", 5);
      }
      foreach($me['cluster'] as $i0=>$v0){
        foreach($v0['grond'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `tekst` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['zitting'] as $i0=>$v0){
        DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($v0['geagendeerd'])."'",5);
      }
      foreach($me['zitting'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `datum` (`i`) VALUES ('".addslashes($v0['geagendeerd'])."')", 5);
      }
      DB_doquer("DELETE FROM `eiser` WHERE `procedur`='".addslashes($me['id'])."'",5);
      foreach  ($me['eiser'] as $eiser){
        $res=DB_doquer("INSERT IGNORE INTO `eiser` (`persoon`,`procedur`) VALUES ('".addslashes($eiser)."', '".addslashes($me['id'])."')", 5);
      }
      // no code for zaaknummer,procedur in eiser
      foreach($me['machtigingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `gemachtigde` WHERE `machtiging`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['machtigingen'] as $i0=>$v0){
        foreach  ($v0['gemachtigde'] as $gemachtigde){
          $res=DB_doquer("INSERT IGNORE INTO `gemachtigde` (`machtiging`,`persoon`) VALUES ('".addslashes($v0['id'])."', '".addslashes($gemachtigde)."')", 5);
        }
      }
      // no code for machtiging,machtiging in gemachtigde
      DB_doquer("DELETE FROM `clusterprocedur` WHERE `procedur`='".addslashes($me['id'])."'",5);
      foreach  ($me['cluster'] as $cluster){
        $res=DB_doquer("INSERT IGNORE INTO `clusterprocedur` (`cluster`,`procedur`) VALUES ('".addslashes($cluster['id'])."', '".addslashes($me['id'])."')", 5);
      }
      foreach($me['cluster'] as $i0=>$v0){
        DB_doquer("DELETE FROM `grond` WHERE `cluster`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['cluster'] as $i0=>$v0){
        foreach  ($v0['grond'] as $grond){
          $res=DB_doquer("INSERT IGNORE INTO `grond` (`cluster`,`tekst`) VALUES ('".addslashes($v0['id'])."', '".addslashes($grond)."')", 5);
        }
      }
      // no code for nr,cluster in grond
      foreach($me['zitting'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechter` WHERE `zitting`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechter` WHERE `zitting`='".addslashes($v0['behandeling']['id'])."'",5);
      }
      foreach($me['zitting'] as $i0=>$v0){
        foreach  ($v0['rechter'] as $rechter){
          $res=DB_doquer("INSERT IGNORE INTO `rechter` (`zitting`,`persoon`) VALUES ('".addslashes($v0['id'])."', '".addslashes($rechter)."')", 5);
        }
      }
      // no code for zittingsnummer,zitting in rechter
      foreach($me['zittingen'] as $i0=>$v0){
        foreach  ($v0['behandeling']['rechter'] as $rechter){
          $res=DB_doquer("INSERT IGNORE INTO `rechter` (`zitting`,`persoon`) VALUES ('".addslashes($v0['behandeling']['id'])."', '".addslashes($rechter)."')", 5);
        }
      }
      // no code for zitting,zitting in rechter
      DB_doquer("DELETE FROM `bevoegd` WHERE `procedur`='".addslashes($me['id'])."'",5);
      foreach  ($me['bevoegd'] as $bevoegd){
        $res=DB_doquer("INSERT IGNORE INTO `bevoegd` (`gerecht`,`procedur`) VALUES ('".addslashes($bevoegd)."', '".addslashes($me['id'])."')", 5);
      }
      // no code for zaaksdossier,document in aan
      // no code for Document,document in aan
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
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
      if (!checkRule11()){
        $DB_err='\"\"';
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
      if (!checkRule15()){
        $DB_err='\"\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule17()){
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
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule24()){
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
      if (!checkRule49()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule58()){
        $DB_err='\"\"';
      } else
      if (!checkRule60()){
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
      if (!checkRule75()){
        $DB_err='\"\"';
      } else
      if (!checkRule76()){
        $DB_err='\"\"';
      } else
      if (!checkRule78()){
        $DB_err='\"\"';
      } else
      if (!checkRule80()){
        $DB_err='\"\"';
      } else
      if (!checkRule81()){
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
      $me=array("id"=>$this->getId(), "eiser" => $this->_eiser, "gemachtigde voor eiser" => $this->_gemachtigdevooreiser, "gedaagde" => $this->_gedaagde, "gemachtigde voor gedaagde" => $this->_gemachtigdevoorgedaagde, "gevoegd" => $this->_gevoegd, "gemachtigde voor gevoegde" => $this->_gemachtigdevoorgevoegde, "rechtsgebied" => $this->_rechtsgebied, "proceduresoort" => $this->_proceduresoort, "zitting" => $this->_zitting, "behandeling" => $this->_behandeling, "bevoegd" => $this->_bevoegd, "zorgdrager voor dossier" => $this->_zorgdragervoordossier, "zaaksdossier" => $this->_zaaksdossier, "cluster" => $this->_cluster, "machtigingen" => $this->_machtigingen, "zittingen" => $this->_zittingen);
      DB_doquer("DELETE FROM `procedur` WHERE `i`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `behandeling` WHERE `zaak`='".addslashes($me['id'])."'",5);
      foreach($me['behandeling'] as $i0=>$v0){
        DB_doquer("DELETE FROM `behandeling` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['machtigingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `machtiging` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['cluster'] as $i0=>$v0){
        DB_doquer("DELETE FROM `cluster` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['zaaksdossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($me['zorgdrager voor dossier'])."'",5);
      foreach($me['eiser'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['gemachtigde voor eiser'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['gemachtigde voor gedaagde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['gevoegd'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['gemachtigde voor gevoegde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['zitting'] as $i0=>$v0){
        foreach($v0['rechter'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['zitting'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['griffier'])."'",5);
      }
      foreach($me['machtigingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['partij'])."'",5);
      }
      foreach($me['machtigingen'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['zittingen'] as $i0=>$v0){
        foreach($v0['behandeling']['rechter'] as $i2=>$v2){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v2)."'",5);
        }
      }
      DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($me['rechtsgebied'])."'",5);
      DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($me['proceduresoort'])."'",5);
      foreach($me['cluster'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v0['naam'])."'",5);
      }
      foreach($me['cluster'] as $i0=>$v0){
        foreach($v0['grond'] as $i1=>$v1){
          DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['zitting'] as $i0=>$v0){
        DB_doquer("DELETE FROM `datum` WHERE `i`='".addslashes($v0['geagendeerd'])."'",5);
      }
      DB_doquer("DELETE FROM `eiser` WHERE `procedur`='".addslashes($me['id'])."'",5);
      foreach($me['machtigingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `gemachtigde` WHERE `machtiging`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `clusterprocedur` WHERE `procedur`='".addslashes($me['id'])."'",5);
      foreach($me['cluster'] as $i0=>$v0){
        DB_doquer("DELETE FROM `grond` WHERE `cluster`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['zitting'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechter` WHERE `zitting`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['zittingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechter` WHERE `zitting`='".addslashes($v0['behandeling']['id'])."'",5);
      }
      DB_doquer("DELETE FROM `bevoegd` WHERE `procedur`='".addslashes($me['id'])."'",5);
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
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
      if (!checkRule11()){
        $DB_err='\"\"';
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
      if (!checkRule15()){
        $DB_err='\"\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule17()){
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
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule24()){
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
      if (!checkRule49()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule58()){
        $DB_err='\"\"';
      } else
      if (!checkRule60()){
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
      if (!checkRule75()){
        $DB_err='\"\"';
      } else
      if (!checkRule76()){
        $DB_err='\"\"';
      } else
      if (!checkRule78()){
        $DB_err='\"\"';
      } else
      if (!checkRule80()){
        $DB_err='\"\"';
      } else
      if (!checkRule81()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_eiser($val){
      $this->_eiser=$val;
    }
    function get_eiser(){
      if(!isset($this->_eiser)) return array();
      return $this->_eiser;
    }
    function set_gemachtigdevooreiser($val){
      $this->_gemachtigdevooreiser=$val;
    }
    function get_gemachtigdevooreiser(){
      if(!isset($this->_gemachtigdevooreiser)) return array();
      return $this->_gemachtigdevooreiser;
    }
    function set_gedaagde($val){
      $this->_gedaagde=$val;
    }
    function get_gedaagde(){
      if(!isset($this->_gedaagde)) return array();
      return $this->_gedaagde;
    }
    function set_gemachtigdevoorgedaagde($val){
      $this->_gemachtigdevoorgedaagde=$val;
    }
    function get_gemachtigdevoorgedaagde(){
      if(!isset($this->_gemachtigdevoorgedaagde)) return array();
      return $this->_gemachtigdevoorgedaagde;
    }
    function set_gevoegd($val){
      $this->_gevoegd=$val;
    }
    function get_gevoegd(){
      if(!isset($this->_gevoegd)) return array();
      return $this->_gevoegd;
    }
    function set_gemachtigdevoorgevoegde($val){
      $this->_gemachtigdevoorgevoegde=$val;
    }
    function get_gemachtigdevoorgevoegde(){
      if(!isset($this->_gemachtigdevoorgevoegde)) return array();
      return $this->_gemachtigdevoorgevoegde;
    }
    function set_rechtsgebied($val){
      $this->_rechtsgebied=$val;
    }
    function get_rechtsgebied(){
      return $this->_rechtsgebied;
    }
    function set_proceduresoort($val){
      $this->_proceduresoort=$val;
    }
    function get_proceduresoort(){
      return $this->_proceduresoort;
    }
    function set_zitting($val){
      $this->_zitting=$val;
    }
    function get_zitting(){
      if(!isset($this->_zitting)) return array();
      return $this->_zitting;
    }
    function set_behandeling($val){
      $this->_behandeling=$val;
    }
    function get_behandeling(){
      if(!isset($this->_behandeling)) return array();
      return $this->_behandeling;
    }
    function set_bevoegd($val){
      $this->_bevoegd=$val;
    }
    function get_bevoegd(){
      if(!isset($this->_bevoegd)) return array();
      return $this->_bevoegd;
    }
    function set_zorgdragervoordossier($val){
      $this->_zorgdragervoordossier=$val;
    }
    function get_zorgdragervoordossier(){
      return $this->_zorgdragervoordossier;
    }
    function set_zaaksdossier($val){
      $this->_zaaksdossier=$val;
    }
    function get_zaaksdossier(){
      if(!isset($this->_zaaksdossier)) return array();
      return $this->_zaaksdossier;
    }
    function set_cluster($val){
      $this->_cluster=$val;
    }
    function get_cluster(){
      if(!isset($this->_cluster)) return array();
      return $this->_cluster;
    }
    function set_machtigingen($val){
      $this->_machtigingen=$val;
    }
    function get_machtigingen(){
      if(!isset($this->_machtigingen)) return array();
      return $this->_machtigingen;
    }
    function set_zittingen($val){
      $this->_zittingen=$val;
    }
    function get_zittingen(){
      if(!isset($this->_zittingen)) return array();
      return $this->_zittingen;
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

  function getEachProcedure(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `procedur`'));
  }

  function readProcedure($id){
      // check existence of $id
      $obj = new Procedure($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delProcedure($id){
    $tobeDeleted = new Procedure($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>