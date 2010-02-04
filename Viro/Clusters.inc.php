<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3675, file "VIRO.adl"
    SERVICE Clusters : I[ONE]
   = [ Clusters : [ONE*Cluster]
        = [ nr : [Cluster]
          , naam : naam
          , zaken : cluster~
             = [ zorgdrager voor dossier : zorgdrager
               , rechtsgebied : rechtsgebied
               , proceduresoort : proceduresoort
               ]
          ]
     ]
   *********/
  
  class Clusters {
    private $_Clusters;
    function Clusters($Clusters=null){
      $this->_Clusters=$Clusters;
      if(!isset($Clusters)){
        // get a Clusters based on its identifier
        // fill the attributes
        $me=array();
        $me['Clusters']=(DB_doquer("SELECT DISTINCT `f1`.`Cluster` AS `id`
                                      FROM  ( SELECT DISTINCT csnd.i AS `Cluster`
                                                FROM `cluster` AS csnd
                                            ) AS f1"));
        foreach($me['Clusters'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `nr`
                                       , `f3`.`naam`
                                    FROM `cluster`
                                    LEFT JOIN `cluster` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                   WHERE `cluster`.`i`='".addslashes($v0['id'])."'"));
          $v0['zaken']=(DB_doquer("SELECT DISTINCT `f1`.`procedur` AS `id`
                                     FROM `cluster`
                                     JOIN `clusterprocedur` AS f1 ON `f1`.`Cluster`='".addslashes($v0['id'])."'
                                    WHERE `cluster`.`i`='".addslashes($v0['id'])."'"));
          foreach($v0['zaken'] as $i1=>&$v1){
            $v1=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v1['id'])."' AS `id`
                                         , `f2`.`zorgdrager` AS `zorgdrager voor dossier`
                                         , `f3`.`rechtsgebied`
                                         , `f4`.`proceduresoort`
                                      FROM `procedur`
                                      LEFT JOIN `procedur` AS f2 ON `f2`.`i`='".addslashes($v1['id'])."'
                                      LEFT JOIN `procedur` AS f3 ON `f3`.`i`='".addslashes($v1['id'])."'
                                      LEFT JOIN `procedur` AS f4 ON `f4`.`i`='".addslashes($v1['id'])."'
                                     WHERE `procedur`.`i`='".addslashes($v1['id'])."'"));
          }
          unset($v1);
        }
        unset($v0);
        $this->set_Clusters($me['Clusters']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Clusters" => $this->_Clusters);
      foreach($me['Clusters'] as $i0=>$v0){
        foreach($v0['zaken'] as $i1=>$v1){
          DB_doquer("DELETE FROM `procedur` WHERE `i`='".addslashes($v1['id'])."'",5);
        }
      }
      foreach($me['Clusters'] as $i0=>$v0){
        foreach($v0['zaken'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `procedur` (`i`,`zorgdrager`,`rechtsgebied`,`proceduresoort`) VALUES ('".addslashes($v1['id'])."', '".addslashes($v1['zorgdrager voor dossier'])."', '".addslashes($v1['rechtsgebied'])."', '".addslashes($v1['proceduresoort'])."')", 5);
          if($res!==false && !isset($v1['id']))
            $v1['id']=mysql_insert_id();
        }
      }
      foreach($me['Clusters'] as $i0=>$v0){
        DB_doquer("DELETE FROM `cluster` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Clusters'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `cluster` (`i`,`naam`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['naam'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for nr,i in cluster
      foreach($me['Clusters'] as $i0=>$v0){
        foreach($v0['zaken'] as $i1=>$v1){
          DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v1['zorgdrager voor dossier'])."'",5);
        }
      }
      foreach($me['Clusters'] as $i0=>$v0){
        foreach($v0['zaken'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `orgaan` (`i`) VALUES ('".addslashes($v1['zorgdrager voor dossier'])."')", 5);
        }
      }
      foreach($me['Clusters'] as $i0=>$v0){
        foreach($v0['zaken'] as $i1=>$v1){
          DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v1['rechtsgebied'])."'",5);
        }
      }
      foreach($me['Clusters'] as $i0=>$v0){
        foreach($v0['zaken'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `rechtsgebied` (`i`) VALUES ('".addslashes($v1['rechtsgebied'])."')", 5);
        }
      }
      foreach($me['Clusters'] as $i0=>$v0){
        foreach($v0['zaken'] as $i1=>$v1){
          DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v1['proceduresoort'])."'",5);
        }
      }
      foreach($me['Clusters'] as $i0=>$v0){
        foreach($v0['zaken'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `proceduresoort` (`i`) VALUES ('".addslashes($v1['proceduresoort'])."')", 5);
        }
      }
      foreach($me['Clusters'] as $i0=>$v0){
        DB_doquer("DELETE FROM `tekst` WHERE `i`='".addslashes($v0['naam'])."'",5);
      }
      foreach($me['Clusters'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `tekst` (`i`) VALUES ('".addslashes($v0['naam'])."')", 5);
      }
      // no code for zaken,procedur in eiser
      // no code for Clusters,cluster in grond
      // no code for nr,cluster in grond
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
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
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if (!checkRule58()){
        $DB_err='\"\"';
      } else
      if (!checkRule60()){
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
    function set_Clusters($val){
      $this->_Clusters=$val;
    }
    function get_Clusters(){
      if(!isset($this->_Clusters)) return array();
      return $this->_Clusters;
    }
  }

?>