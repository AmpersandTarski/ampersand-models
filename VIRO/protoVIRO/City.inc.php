<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 556, file "VIRO453ENG.adl"
    SERVICE City : I[City]
   = [ courts : localCities
     , district : localCities;district
     , sessions : city~
        = [ Session : [Session]
          , judge : judge
          , scheduled : scheduled
          , panel : panel
          ]
     , main city : mainCity~
     ]
   *********/
  
  class City {
    protected $_id=false;
    protected $_new=true;
    private $_courts;
    private $_district;
    private $_sessions;
    private $_maincity;
    function City($id=null, $courts=null, $district=null, $sessions=null, $maincity=null){
      $this->_id=$id;
      $this->_courts=$courts;
      $this->_district=$district;
      $this->_sessions=$sessions;
      $this->_maincity=$maincity;
      if(!isset($courts) && isset($id)){
        // get a City based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttCity` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttCity`, `i`
                                  FROM `city`
                              ) AS fst
                          WHERE fst.`AttCity` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `city`.`i` AS `id`
                                       , `city`.`localcities` AS `courts`
                                       , `f1`.`district`
                                    FROM `city`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`district`
                                                   FROM `city` AS F0, `court` AS F1
                                                  WHERE F0.`localcities`=F1.`i`
                                               ) AS f1
                                      ON `f1`.`i`='".addslashes($id)."'
                                   WHERE `city`.`i`='".addslashes($id)."'"));
          $me['sessions']=(DB_doquer("SELECT DISTINCT `session`.`i` AS `id`
                                        FROM `session`
                                       WHERE `session`.`city`='".addslashes($id)."'"));
          $me['main city']=firstCol(DB_doquer("SELECT DISTINCT `court`.`i` AS `main city`
                                                 FROM `court`
                                                WHERE `court`.`maincity`='".addslashes($id)."'"));
          foreach($me['sessions'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Session`
                                         , `f3`.`scheduled`
                                         , `f4`.`panel`
                                      FROM `session`
                                      LEFT JOIN `session` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `session` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `session`.`i`='".addslashes($v0['id'])."'"));
            $v0['judge']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `judge`
                                               FROM `session`
                                               JOIN `judge` AS f1 ON `f1`.`session`='".addslashes($v0['id'])."'
                                              WHERE `session`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_courts($me['courts']);
          $this->set_district($me['district']);
          $this->set_sessions($me['sessions']);
          $this->set_maincity($me['main city']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttCity` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttCity`, `i`
                                  FROM `city`
                              ) AS fst
                          WHERE fst.`AttCity` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "courts" => $this->_courts, "district" => $this->_district, "sessions" => $this->_sessions, "main city" => $this->_maincity);
      foreach($me['sessions'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `session` SET `i`='".addslashes($v0['id'])."', `scheduled`='".addslashes($v0['scheduled'])."', `panel`='".addslashes($v0['panel'])."' WHERE `i`='".addslashes($v0['Session'])."'", 5);
      }
      foreach  ($me['sessions'] as $sessions){
        if(isset($me['id']))
          DB_doquer("UPDATE `session` SET `city`='".addslashes($me['id'])."' WHERE `i`='".addslashes($sessions['id'])."'", 5);
      }
      // no code for Session,i in session
      // no code for courts,i in court
      // no code for main city,i in court
      foreach  ($me['main city'] as $maincity){
        if(isset($me['id']))
          DB_doquer("UPDATE `court` SET `maincity`='".addslashes($me['id'])."' WHERE `i`='".addslashes($maincity)."'", 5);
      }
      // no code for panel,i in panel
      DB_doquer("DELETE FROM `city` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `city` (`localcities`,`i`) VALUES (".((null!=$me['courts'])?"'".addslashes($me['courts'])."'":"NULL").", '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      foreach($me['sessions'] as $i0=>$v0){
        foreach($v0['judge'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['sessions'] as $i0=>$v0){
        foreach($v0['judge'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['scheduled'])."'",5);
      }
      foreach($me['sessions'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `date` (`i`) VALUES ('".addslashes($v0['scheduled'])."')", 5);
      }
      DB_doquer("DELETE FROM `courtofappeal` WHERE `i`='".addslashes($me['district'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `courtofappeal` (`i`) VALUES ('".addslashes($me['district'])."')", 5);
      foreach($me['sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['sessions'] as $i0=>$v0){
        foreach  ($v0['judge'] as $judge){
          $res=DB_doquer("INSERT IGNORE INTO `judge` (`session`,`party`) VALUES ('".addslashes($v0['id'])."', '".addslashes($judge)."')", 5);
        }
      }
      // no code for Session,session in judge
      if (!checkRule3()){
        $DB_err='\"Alle sessionen worden scheduled\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Elke session vindt city in de hoofdvestigingscity van een court of een van de localCitiesvestigingscityen (tekst checken, Article 47 lid 2 RO)\"';
      } else
      if (!checkRule6()){
        $DB_err='\"De judge ter session maakt deel uit from de members from de panel die de session houdt\"';
      } else
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule19()){
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
      if (!checkRule42()){
        $DB_err='\"\"';
      } else
      if (!checkRule43()){
        $DB_err='\"\"';
      } else
      if (!checkRule44()){
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
      $me=array("id"=>$this->getId(), "courts" => $this->_courts, "district" => $this->_district, "sessions" => $this->_sessions, "main city" => $this->_maincity);
      DB_doquer("DELETE FROM `city` WHERE `i`='".addslashes($me['id'])."'",5);
      foreach($me['sessions'] as $i0=>$v0){
        foreach($v0['judge'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `date` WHERE `i`='".addslashes($v0['scheduled'])."'",5);
      }
      DB_doquer("DELETE FROM `courtofappeal` WHERE `i`='".addslashes($me['district'])."'",5);
      foreach($me['sessions'] as $i0=>$v0){
        DB_doquer("DELETE FROM `judge` WHERE `session`='".addslashes($v0['id'])."'",5);
      }
      if (!checkRule3()){
        $DB_err='\"Alle sessionen worden scheduled\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Elke session vindt city in de hoofdvestigingscity van een court of een van de localCitiesvestigingscityen (tekst checken, Article 47 lid 2 RO)\"';
      } else
      if (!checkRule6()){
        $DB_err='\"De judge ter session maakt deel uit from de members from de panel die de session houdt\"';
      } else
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule19()){
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
      if (!checkRule42()){
        $DB_err='\"\"';
      } else
      if (!checkRule43()){
        $DB_err='\"\"';
      } else
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_courts($val){
      $this->_courts=$val;
    }
    function get_courts(){
      return $this->_courts;
    }
    function set_district($val){
      $this->_district=$val;
    }
    function get_district(){
      return $this->_district;
    }
    function set_sessions($val){
      $this->_sessions=$val;
    }
    function get_sessions(){
      if(!isset($this->_sessions)) return array();
      return $this->_sessions;
    }
    function set_maincity($val){
      $this->_maincity=$val;
    }
    function get_maincity(){
      if(!isset($this->_maincity)) return array();
      return $this->_maincity;
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

  function getEachCity(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `city`'));
  }

  function readCity($id){
      // check existence of $id
      $obj = new City($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delCity($id){
    $tobeDeleted = new City($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>