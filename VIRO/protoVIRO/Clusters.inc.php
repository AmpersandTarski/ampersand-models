<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 664, file "VIRO453ENG.adl"
    SERVICE Clusters : I[ONE]
   = [ Clusters : [ONE*Cluster]
        = [ nr : [Cluster]
          , name : name
          , cases : cluster~
             = [ caretaker of case file : caretaker
               , area of law : areaOfLaw
               , type of case : caseType
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
                                       , `f3`.`name`
                                    FROM `cluster`
                                    LEFT JOIN `cluster` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                   WHERE `cluster`.`i`='".addslashes($v0['id'])."'"));
          $v0['cases']=(DB_doquer("SELECT DISTINCT `f1`.`case` AS `id`
                                     FROM `cluster`
                                     JOIN `clustercase` AS f1 ON `f1`.`Cluster`='".addslashes($v0['id'])."'
                                    WHERE `cluster`.`i`='".addslashes($v0['id'])."'"));
          foreach($v0['cases'] as $i1=>&$v1){
            $v1=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v1['id'])."' AS `id`
                                         , `f2`.`caretaker` AS `caretaker of case file`
                                         , `f3`.`areaoflaw` AS `area of law`
                                         , `f4`.`casetype` AS `type of case`
                                      FROM `case`
                                      LEFT JOIN `case` AS f2 ON `f2`.`i`='".addslashes($v1['id'])."'
                                      LEFT JOIN `case` AS f3 ON `f3`.`i`='".addslashes($v1['id'])."'
                                      LEFT JOIN `case` AS f4 ON `f4`.`i`='".addslashes($v1['id'])."'
                                     WHERE `case`.`i`='".addslashes($v1['id'])."'"));
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
        foreach($v0['cases'] as $i1=>$v1){
          DB_doquer("DELETE FROM `case` WHERE `i`='".addslashes($v1['id'])."'",5);
        }
      }
      foreach($me['Clusters'] as $i0=>$v0){
        foreach($v0['cases'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `case` (`i`,`caretaker`,`areaoflaw`,`casetype`) VALUES ('".addslashes($v1['id'])."', '".addslashes($v1['caretaker of case file'])."', '".addslashes($v1['area of law'])."', '".addslashes($v1['type of case'])."')", 5);
          if($res!==false && !isset($v1['id']))
            $v1['id']=mysql_insert_id();
        }
      }
      foreach($me['Clusters'] as $i0=>$v0){
        DB_doquer("DELETE FROM `cluster` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Clusters'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `cluster` (`i`,`name`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['name'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for nr,i in cluster
      foreach($me['Clusters'] as $i0=>$v0){
        foreach($v0['cases'] as $i1=>$v1){
          DB_doquer("DELETE FROM `organ` WHERE `i`='".addslashes($v1['caretaker of case file'])."'",5);
        }
      }
      foreach($me['Clusters'] as $i0=>$v0){
        foreach($v0['cases'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `organ` (`i`) VALUES ('".addslashes($v1['caretaker of case file'])."')", 5);
        }
      }
      foreach($me['Clusters'] as $i0=>$v0){
        foreach($v0['cases'] as $i1=>$v1){
          DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($v1['area of law'])."'",5);
        }
      }
      foreach($me['Clusters'] as $i0=>$v0){
        foreach($v0['cases'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `areaoflaw` (`i`) VALUES ('".addslashes($v1['area of law'])."')", 5);
        }
      }
      foreach($me['Clusters'] as $i0=>$v0){
        foreach($v0['cases'] as $i1=>$v1){
          DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v1['type of case'])."'",5);
        }
      }
      foreach($me['Clusters'] as $i0=>$v0){
        foreach($v0['cases'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `casetype` (`i`) VALUES ('".addslashes($v1['type of case'])."')", 5);
        }
      }
      foreach($me['Clusters'] as $i0=>$v0){
        DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($v0['name'])."'",5);
      }
      foreach($me['Clusters'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `text` (`i`) VALUES ('".addslashes($v0['name'])."')", 5);
      }
      // no code for cases,case in plaintiff
      // no code for Clusters,cluster in base
      // no code for nr,cluster in base
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
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
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule59()){
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