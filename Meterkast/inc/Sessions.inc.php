<?php // generated with ADL vs. 1.1-647
  
  /********* on line 81, file "apps/Meterkast/meterkast.adl"
    SERVICE Sessions : I[S]
   = [ Session : [S*Session]
        = [ id : [Session]
          , ip : ip
          , file : session~
          ]
     ]
   *********/
  
  class Sessions {
    private $_Session;
    function Sessions($_Session=null){
      $this->_Session=$_Session;
      if(!isset($_Session)){
        // get a Sessions based on its identifier
        // fill the attributes
        $me=array();
        $me['Session']=(DB_doquer("SELECT DISTINCT `f1`.`Id` AS `id`
                                     FROM  ( SELECT DISTINCT csnd.Id
                                               FROM `SessieTbl` AS csnd
                                           ) AS f1"));
        foreach($me['Session'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `id`
                                       , `f3`.`ip`
                                       , `f4`.`Id` AS `file`
                                    FROM `SessieTbl`
                                    LEFT JOIN `SessieTbl` AS f3 ON `f3`.`Id`='".addslashes($v0['id'])."'
                                    LEFT JOIN `SessieTbl` AS f4 ON `f4`.`bestand`='".addslashes($v0['id'])."'
                                   WHERE `SessieTbl`.`Id`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Session($me['Session']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $me=array("id"=>1, "Session" => $this->_Session);
      // no code for file,Id in BestandTbl
      foreach($me['Session'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `SessieTbl` SET `Id`='".addslashes($v0['id'])."', `ip`='".addslashes($v0['ip'])."', `bestand`=".((null!=$v0['file'])?"'".addslashes($v0['file'])."'":"NULL")." WHERE `Id`='".addslashes($v0['id'])."'", 5);
      }
      // no code for id,Id in SessieTbl
      // no code for file,bestand in SessieTbl
      foreach($me['Session'] as $i0=>$v0){
        DB_doquer("DELETE FROM `Text` WHERE `I`='".addslashes($v0['ip'])."'",5);
      }
      foreach($me['Session'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `Text` (`I`) VALUES ('".addslashes($v0['ip'])."')", 5);
      }
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
      if(!isset($this->_Session)) return array();
      return $this->_Session;
    }
  }

?>