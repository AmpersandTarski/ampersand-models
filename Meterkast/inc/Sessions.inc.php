<?php // generated with ADL vs. 0.8.10-408
  
  /********* on line 53, file "Meterkast.adl"
    SERVICE Sessions : I[ONE]
   = [ Session : [ONE*Session]
        = [ id : [Session]
          , ip : ip
          , file : session~
          ]
     ]
   *********/
  
  class Sessions {
    private $_Session;
    function Sessions($Session=null){
      $this->_Session=$Session;
      if(!isset($Session)){
        // get a Sessions based on its identifier
        // fill the attributes
        $me=array();
        $me['Session']=(DB_doquer("SELECT DISTINCT `f1`.`Session` AS `id`
                                     FROM  ( SELECT DISTINCT csnd.Id AS `Session`
                                               FROM SessieTbl AS csnd
                                           ) AS f1"));
        foreach($me['Session'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `id`
                                       , `f3`.`ip`
                                       , `f4`.`bestand` AS `file`
                                    FROM `SessieTbl`
                                    LEFT JOIN `SessieTbl` AS f3 ON `f3`.`Id`='".addslashes($v0['id'])."'
                                    LEFT JOIN `SessieTbl` AS f4 ON `f4`.`Id`='".addslashes($v0['id'])."'
                                   WHERE `SessieTbl`.`Id`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Session($me['Session']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      * id                                     *
      \****************************************/
      $me=array("id"=>1, "Session" => $this->_Session);
      // no code for file,Id in BestandTbl
      foreach($me['Session'] as $i0=>$v0){
        DB_doquer("DELETE FROM `SessieTbl` WHERE `Id`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Session'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `SessieTbl` (`Id`,`ip`,`bestand`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['ip'])."', ".((null!=$v0['file'])?"'".addslashes($v0['file'])."'":"NULL").")", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for file,bestand in SessieTbl
      foreach($me['Session'] as $i0=>$v0){
        DB_doquer("DELETE FROM `text` WHERE `text`='".addslashes($v0['ip'])."'",5);
      }
      foreach($me['Session'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `text` (`text`) VALUES ('".addslashes($v0['ip'])."')", 5);
        if($res!==false && !isset($v0['ip']['id']))
          $v0['ip']['id']=mysql_insert_id();
      }
      if (!checkRule1()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule2()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule3()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule4()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule5()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule6()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule7()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule8()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule13()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule15()){
        $DB_err=$preErr.'\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Session($val){
      $this->_Session=$val;
    }
    function get_Session(){
      return $this->_Session;
    }
  }

?>