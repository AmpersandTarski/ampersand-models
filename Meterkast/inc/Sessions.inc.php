<?php // generated with ADL vs. 0.8.10-529
  
  /********* on line 74, file "meterkast.adl"
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
        $me['Session']=(DB_doquer("SELECT DISTINCT `f1`.`Session` AS `id`
                                     FROM  ( SELECT DISTINCT csnd.id AS `Session`
                                               FROM `sessietbl` AS csnd
                                           ) AS f1"));
        foreach($me['Session'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `id`
                                       , `f3`.`ip`
                                       , `f4`.`bestand` AS `file`
                                    FROM `sessietbl`
                                    LEFT JOIN `sessietbl` AS f3 ON `f3`.`id`='".addslashes($v0['id'])."'
                                    LEFT JOIN `sessietbl` AS f4 ON `f4`.`id`='".addslashes($v0['id'])."'
                                   WHERE `sessietbl`.`id`='".addslashes($v0['id'])."'"));
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
      // no code for file,id in bestandtbl
      foreach($me['Session'] as $i0=>$v0){
        DB_doquer("DELETE FROM `sessietbl` WHERE `id`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Session'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `sessietbl` (`id`,`ip`,`bestand`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['ip'])."', ".((null!=$v0['file'])?"'".addslashes($v0['file'])."'":"NULL").")", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for id,id in sessietbl
      // no code for file,bestand in sessietbl
      foreach($me['Session'] as $i0=>$v0){
        DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($v0['ip'])."'",5);
      }
      foreach($me['Session'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `text` (`i`) VALUES ('".addslashes($v0['ip'])."')", 5);
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