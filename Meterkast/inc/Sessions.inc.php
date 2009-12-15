<?php // generated with ADL vs. 0.8.10-485
  
  /********* on line 51, file "meterkast.adl"
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
      if (!checkRule1()){
        $DB_err='\"path[Bestand*Text] is univalent\"';
      } else
      if (!checkRule2()){
        $DB_err='\"path[Bestand*Text] is total\"';
      } else
      if (!checkRule3()){
        $DB_err='\"session[Bestand*Session] is injective\"';
      } else
      if (!checkRule4()){
        $DB_err='\"session[Bestand*Session] is univalent\"';
      } else
      if (!checkRule5()){
        $DB_err='\"session[Bestand*Session] is total\"';
      } else
      if (!checkRule6()){
        $DB_err='\"ip[Session*Text] is univalent\"';
      } else
      if (!checkRule7()){
        $DB_err='\"ip[Session*Text] is total\"';
      } else
      if (!checkRule8()){
        $DB_err='\"object[Actie*Bestand] is univalent\"';
      } else
      if (!checkRule13()){
        $DB_err='\"name[Operation*Text] is univalent\"';
      } else
      if (!checkRule15()){
        $DB_err='\"call[Operation*Text] is univalent\"';
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
      if(!isset($this->_Session)) return array();
      return $this->_Session;
    }
  }

?>