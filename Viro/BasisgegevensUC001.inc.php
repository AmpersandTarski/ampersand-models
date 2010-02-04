<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3548, file "VIRO.adl"
    SERVICE BasisgegevensUC001 : I[Procedur]
   = [ eiser : eiser~;door~/\inzake~
        = [ partij : door
          , gemachtigde : gemachtigde~
          ]
     , gedaagde : gedaagde~;door~/\inzake~
        = [ partij : door
          , gemachtigde : gemachtigde~
          ]
     , gevoegde : gevoegde~;door~/\inzake~
        = [ partij : door
          , gemachtigde : gemachtigde~
          ]
     , rechtsgebied : rechtsgebied
     , proceduresoort : proceduresoort
     , bevoegd : bevoegd
     , zorgdrager voor dossier : zorgdrager
     , dossierstukken : zaaksdossier~
        = [ Document : [Document]
          , type : type
          ]
     , cluster : cluster
        = [ naam : [Cluster]
          , grond : grond
          ]
     , machtigingen : inzake~
        = [ machtiging : [Machtiging]
          , partij : door
          , gemachtigde : gemachtigde~
          ]
     ]
   *********/
  
  class BasisgegevensUC001 {
    protected $_id=false;
    protected $_new=true;
    private $_eiser;
    private $_gedaagde;
    private $_gevoegde;
    private $_rechtsgebied;
    private $_proceduresoort;
    private $_bevoegd;
    private $_zorgdragervoordossier;
    private $_dossierstukken;
    private $_cluster;
    private $_machtigingen;
    function BasisgegevensUC001($id=null, $eiser=null, $gedaagde=null, $gevoegde=null, $rechtsgebied=null, $proceduresoort=null, $bevoegd=null, $zorgdragervoordossier=null, $dossierstukken=null, $cluster=null, $machtigingen=null){
      $this->_id=$id;
      $this->_eiser=$eiser;
      $this->_gedaagde=$gedaagde;
      $this->_gevoegde=$gevoegde;
      $this->_rechtsgebied=$rechtsgebied;
      $this->_proceduresoort=$proceduresoort;
      $this->_bevoegd=$bevoegd;
      $this->_zorgdragervoordossier=$zorgdragervoordossier;
      $this->_dossierstukken=$dossierstukken;
      $this->_cluster=$cluster;
      $this->_machtigingen=$machtigingen;
      if(!isset($eiser) && isset($id)){
        // get a BasisgegevensUC001 based on its identifier
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
          $me['eiser']=(DB_doquer("SELECT DISTINCT `f1`.`i` AS `id`
                                     FROM `procedur`
                                     JOIN  ( SELECT DISTINCT isect0.`procedur`, isect0.`i`
                                                    FROM 
                                                       ( SELECT DISTINCT F0.`procedur`, F1.`i`
                                                           FROM `eiser` AS F0, `machtiging` AS F1
                                                          WHERE F0.`persoon`=F1.`door`
                                                       ) AS isect0, `inzake` AS isect1
                                                   WHERE (isect0.`procedur` = isect1.`Procedur` AND isect0.`i` = isect1.`machtiging`) AND isect0.`procedur` IS NOT NULL AND isect0.`i` IS NOT NULL
                                                ) AS f1
                                       ON `f1`.`procedur`='".addslashes($id)."'
                                    WHERE `procedur`.`i`='".addslashes($id)."'"));
          $me['gedaagde']=(DB_doquer("SELECT DISTINCT `f1`.`i` AS `id`
                                        FROM `procedur`
                                        JOIN  ( SELECT DISTINCT isect0.`Procedur`, isect0.`i`
                                                       FROM 
                                                          ( SELECT DISTINCT F0.`Procedur`, F1.`i`
                                                              FROM `gedaagde` AS F0, `machtiging` AS F1
                                                             WHERE F0.`persoon`=F1.`door`
                                                          ) AS isect0, `inzake` AS isect1
                                                      WHERE (isect0.`Procedur` = isect1.`Procedur` AND isect0.`i` = isect1.`machtiging`) AND isect0.`Procedur` IS NOT NULL AND isect0.`i` IS NOT NULL
                                                   ) AS f1
                                          ON `f1`.`Procedur`='".addslashes($id)."'
                                       WHERE `procedur`.`i`='".addslashes($id)."'"));
          $me['gevoegde']=(DB_doquer("SELECT DISTINCT `f1`.`i` AS `id`
                                        FROM `procedur`
                                        JOIN  ( SELECT DISTINCT isect0.`Procedur`, isect0.`i`
                                                       FROM 
                                                          ( SELECT DISTINCT F0.`Procedur`, F1.`i`
                                                              FROM `gevoegde` AS F0, `machtiging` AS F1
                                                             WHERE F0.`persoon`=F1.`door`
                                                          ) AS isect0, `inzake` AS isect1
                                                      WHERE (isect0.`Procedur` = isect1.`Procedur` AND isect0.`i` = isect1.`machtiging`) AND isect0.`Procedur` IS NOT NULL AND isect0.`i` IS NOT NULL
                                                   ) AS f1
                                          ON `f1`.`Procedur`='".addslashes($id)."'
                                       WHERE `procedur`.`i`='".addslashes($id)."'"));
          $me['bevoegd']=firstCol(DB_doquer("SELECT DISTINCT `bevoegd`.`gerecht` AS `bevoegd`
                                               FROM `bevoegd`
                                              WHERE `bevoegd`.`procedur`='".addslashes($id)."'"));
          $me['dossierstukken']=(DB_doquer("SELECT DISTINCT `f1`.`document` AS `id`
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
          foreach($me['eiser'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`door` AS `partij`
                                      FROM `machtiging`
                                      LEFT JOIN `machtiging` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                     WHERE `machtiging`.`i`='".addslashes($v0['id'])."'"));
            $v0['gemachtigde']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `gemachtigde`
                                                     FROM `machtiging`
                                                     JOIN `gemachtigde` AS f1 ON `f1`.`machtiging`='".addslashes($v0['id'])."'
                                                    WHERE `machtiging`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['gedaagde'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`door` AS `partij`
                                      FROM `machtiging`
                                      LEFT JOIN `machtiging` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                     WHERE `machtiging`.`i`='".addslashes($v0['id'])."'"));
            $v0['gemachtigde']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `gemachtigde`
                                                     FROM `machtiging`
                                                     JOIN `gemachtigde` AS f1 ON `f1`.`machtiging`='".addslashes($v0['id'])."'
                                                    WHERE `machtiging`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['gevoegde'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`door` AS `partij`
                                      FROM `machtiging`
                                      LEFT JOIN `machtiging` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                     WHERE `machtiging`.`i`='".addslashes($v0['id'])."'"));
            $v0['gemachtigde']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `gemachtigde`
                                                     FROM `machtiging`
                                                     JOIN `gemachtigde` AS f1 ON `f1`.`machtiging`='".addslashes($v0['id'])."'
                                                    WHERE `machtiging`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['dossierstukken'] as $i0=>&$v0){
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
                                         , '".addslashes($v0['id'])."' AS `naam`
                                      FROM `cluster`
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
          $this->set_eiser($me['eiser']);
          $this->set_gedaagde($me['gedaagde']);
          $this->set_gevoegde($me['gevoegde']);
          $this->set_rechtsgebied($me['rechtsgebied']);
          $this->set_proceduresoort($me['proceduresoort']);
          $this->set_bevoegd($me['bevoegd']);
          $this->set_zorgdragervoordossier($me['zorgdrager voor dossier']);
          $this->set_dossierstukken($me['dossierstukken']);
          $this->set_cluster($me['cluster']);
          $this->set_machtigingen($me['machtigingen']);
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
      $me=array("id"=>$this->getId(), "eiser" => $this->_eiser, "gedaagde" => $this->_gedaagde, "gevoegde" => $this->_gevoegde, "rechtsgebied" => $this->_rechtsgebied, "proceduresoort" => $this->_proceduresoort, "bevoegd" => $this->_bevoegd, "zorgdrager voor dossier" => $this->_zorgdragervoordossier, "dossierstukken" => $this->_dossierstukken, "cluster" => $this->_cluster, "machtigingen" => $this->_machtigingen);
      foreach($me['dossierstukken'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `document` SET `i`='".addslashes($v0['id'])."', `type`='".addslashes($v0['type'])."' WHERE `i`='".addslashes($v0['Document'])."'", 5);
      }
      // no code for Document,i in document
      DB_doquer("DELETE FROM `procedur` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `procedur` (`rechtsgebied`,`proceduresoort`,`zorgdrager`,`i`) VALUES ('".addslashes($me['rechtsgebied'])."', '".addslashes($me['proceduresoort'])."', '".addslashes($me['zorgdrager voor dossier'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for bevoegd,i in gerecht
      foreach($me['eiser'] as $i0=>$v0){
        DB_doquer("DELETE FROM `machtiging` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `machtiging` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['gevoegde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `machtiging` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['machtigingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `machtiging` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['eiser'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `machtiging` (`i`,`door`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['partij'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `machtiging` (`i`,`door`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['partij'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['gevoegde'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `machtiging` (`i`,`door`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['partij'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['machtigingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `machtiging` (`i`,`door`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['partij'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for machtiging,i in machtiging
      foreach($me['cluster'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `cluster` SET `i`='".addslashes($v0['id'])."' WHERE `i`='".addslashes($v0['naam'])."'", 5);
      }
      // no code for naam,i in cluster
      foreach($me['dossierstukken'] as $i0=>$v0){
        DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      foreach($me['dossierstukken'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `documenttype` (`i`) VALUES ('".addslashes($v0['type'])."')", 5);
      }
      DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($me['zorgdrager voor dossier'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `orgaan` (`i`) VALUES ('".addslashes($me['zorgdrager voor dossier'])."')", 5);
      foreach($me['eiser'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['partij'])."'",5);
      }
      foreach($me['eiser'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['partij'])."'",5);
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['gevoegde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['partij'])."'",5);
      }
      foreach($me['gevoegde'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['machtigingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['partij'])."'",5);
      }
      foreach($me['machtigingen'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['eiser'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['partij'])."')", 5);
      }
      foreach($me['eiser'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['partij'])."')", 5);
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['gevoegde'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['partij'])."')", 5);
      }
      foreach($me['gevoegde'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['machtigingen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['partij'])."')", 5);
      }
      foreach($me['machtigingen'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($me['rechtsgebied'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `rechtsgebied` (`i`) VALUES ('".addslashes($me['rechtsgebied'])."')", 5);
      DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($me['proceduresoort'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `proceduresoort` (`i`) VALUES ('".addslashes($me['proceduresoort'])."')", 5);
      foreach($me['cluster'] as $i0=>$v0){
        foreach($v0['grond'] as $i1=>$v1){
          DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['cluster'] as $i0=>$v0){
        foreach($v0['grond'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `tekst` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['eiser'] as $i0=>$v0){
        DB_doquer("DELETE FROM `gemachtigde` WHERE `machtiging`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `gemachtigde` WHERE `machtiging`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['gevoegde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `gemachtigde` WHERE `machtiging`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['machtigingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `gemachtigde` WHERE `machtiging`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['eiser'] as $i0=>$v0){
        foreach  ($v0['gemachtigde'] as $gemachtigde){
          $res=DB_doquer("INSERT IGNORE INTO `gemachtigde` (`machtiging`,`persoon`) VALUES ('".addslashes($v0['id'])."', '".addslashes($gemachtigde)."')", 5);
        }
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        foreach  ($v0['gemachtigde'] as $gemachtigde){
          $res=DB_doquer("INSERT IGNORE INTO `gemachtigde` (`machtiging`,`persoon`) VALUES ('".addslashes($v0['id'])."', '".addslashes($gemachtigde)."')", 5);
        }
      }
      foreach($me['gevoegde'] as $i0=>$v0){
        foreach  ($v0['gemachtigde'] as $gemachtigde){
          $res=DB_doquer("INSERT IGNORE INTO `gemachtigde` (`machtiging`,`persoon`) VALUES ('".addslashes($v0['id'])."', '".addslashes($gemachtigde)."')", 5);
        }
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
      // no code for naam,cluster in grond
      DB_doquer("DELETE FROM `bevoegd` WHERE `procedur`='".addslashes($me['id'])."'",5);
      foreach  ($me['bevoegd'] as $bevoegd){
        $res=DB_doquer("INSERT IGNORE INTO `bevoegd` (`gerecht`,`procedur`) VALUES ('".addslashes($bevoegd)."', '".addslashes($me['id'])."')", 5);
      }
      // no code for dossierstukken,document in aan
      // no code for Document,document in aan
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule5()){
        $DB_err='\"Een bestuurszaak dient bij de rechter die bij de zetel van de gemeente, provincie, waterschap of politieregio hoort, waar tegen bezwaar was ingesteld (voorafgaande aan de procedure bij de bestuursrechter) (art. 8:7 Awb.)\"';
      } else
      if (!checkRule10()){
        $DB_err='\"\"';
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
      if (!checkRule27()){
        $DB_err='\"\"';
      } else
      if (!checkRule31()){
        $DB_err='\"\"';
      } else
      if (!checkRule37()){
        $DB_err='\"\"';
      } else
      if (!checkRule39()){
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
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule57()){
        $DB_err='\"\"';
      } else
      if (!checkRule59()){
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
      if (!checkRule74()){
        $DB_err='\"\"';
      } else
      if (!checkRule75()){
        $DB_err='\"\"';
      } else
      if (!checkRule77()){
        $DB_err='\"\"';
      } else
      if (!checkRule79()){
        $DB_err='\"\"';
      } else
      if (!checkRule80()){
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
      $me=array("id"=>$this->getId(), "eiser" => $this->_eiser, "gedaagde" => $this->_gedaagde, "gevoegde" => $this->_gevoegde, "rechtsgebied" => $this->_rechtsgebied, "proceduresoort" => $this->_proceduresoort, "bevoegd" => $this->_bevoegd, "zorgdrager voor dossier" => $this->_zorgdragervoordossier, "dossierstukken" => $this->_dossierstukken, "cluster" => $this->_cluster, "machtigingen" => $this->_machtigingen);
      DB_doquer("DELETE FROM `procedur` WHERE `i`='".addslashes($me['id'])."'",5);
      foreach($me['eiser'] as $i0=>$v0){
        DB_doquer("DELETE FROM `machtiging` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `machtiging` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['gevoegde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `machtiging` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['machtigingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `machtiging` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['dossierstukken'] as $i0=>$v0){
        DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($me['zorgdrager voor dossier'])."'",5);
      foreach($me['eiser'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['partij'])."'",5);
      }
      foreach($me['eiser'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['partij'])."'",5);
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['gevoegde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['partij'])."'",5);
      }
      foreach($me['gevoegde'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['machtigingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['partij'])."'",5);
      }
      foreach($me['machtigingen'] as $i0=>$v0){
        foreach($v0['gemachtigde'] as $i1=>$v1){
          DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($me['rechtsgebied'])."'",5);
      DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($me['proceduresoort'])."'",5);
      foreach($me['cluster'] as $i0=>$v0){
        foreach($v0['grond'] as $i1=>$v1){
          DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['eiser'] as $i0=>$v0){
        DB_doquer("DELETE FROM `gemachtigde` WHERE `machtiging`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['gedaagde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `gemachtigde` WHERE `machtiging`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['gevoegde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `gemachtigde` WHERE `machtiging`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['machtigingen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `gemachtigde` WHERE `machtiging`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `clusterprocedur` WHERE `procedur`='".addslashes($me['id'])."'",5);
      foreach($me['cluster'] as $i0=>$v0){
        DB_doquer("DELETE FROM `grond` WHERE `cluster`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `bevoegd` WHERE `procedur`='".addslashes($me['id'])."'",5);
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule5()){
        $DB_err='\"Een bestuurszaak dient bij de rechter die bij de zetel van de gemeente, provincie, waterschap of politieregio hoort, waar tegen bezwaar was ingesteld (voorafgaande aan de procedure bij de bestuursrechter) (art. 8:7 Awb.)\"';
      } else
      if (!checkRule10()){
        $DB_err='\"\"';
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
      if (!checkRule27()){
        $DB_err='\"\"';
      } else
      if (!checkRule31()){
        $DB_err='\"\"';
      } else
      if (!checkRule37()){
        $DB_err='\"\"';
      } else
      if (!checkRule39()){
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
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule57()){
        $DB_err='\"\"';
      } else
      if (!checkRule59()){
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
      if (!checkRule74()){
        $DB_err='\"\"';
      } else
      if (!checkRule75()){
        $DB_err='\"\"';
      } else
      if (!checkRule77()){
        $DB_err='\"\"';
      } else
      if (!checkRule79()){
        $DB_err='\"\"';
      } else
      if (!checkRule80()){
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
    function set_gedaagde($val){
      $this->_gedaagde=$val;
    }
    function get_gedaagde(){
      if(!isset($this->_gedaagde)) return array();
      return $this->_gedaagde;
    }
    function set_gevoegde($val){
      $this->_gevoegde=$val;
    }
    function get_gevoegde(){
      if(!isset($this->_gevoegde)) return array();
      return $this->_gevoegde;
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
    function set_dossierstukken($val){
      $this->_dossierstukken=$val;
    }
    function get_dossierstukken(){
      if(!isset($this->_dossierstukken)) return array();
      return $this->_dossierstukken;
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

  function getEachBasisgegevensUC001(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `procedur`'));
  }

  function readBasisgegevensUC001($id){
      // check existence of $id
      $obj = new BasisgegevensUC001($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delBasisgegevensUC001($id){
    $tobeDeleted = new BasisgegevensUC001($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>