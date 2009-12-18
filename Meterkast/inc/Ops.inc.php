<?php // generated with ADL vs. 0.8.10-495
  
  /********* on line 57, file "meterkast.adl"
    SERVICE Ops : I[ONE]
   = [ Operations : [ONE*Operation]
        = [ name : name
          , call : call
          , outputURL : output
          ]
     ]
   *********/
  
  class Ops {
    private $_Operations;
    function Ops($_Operations=null){
      $this->_Operations=$_Operations;
      if(!isset($_Operations)){
        // get a Ops based on its identifier
        // fill the attributes
        $me=array();
        $me['Operations']=(DB_doquer("SELECT DISTINCT `f1`.`Operation` AS `id`
                                        FROM  ( SELECT DISTINCT csnd.id AS `Operation`
                                                  FROM `operationtbl` AS csnd
                                              ) AS f1"));
        foreach($me['Operations'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , `f2`.`name`
                                       , `f3`.`call`
                                       , `f4`.`output` AS `outputURL`
                                    FROM `operationtbl`
                                    LEFT JOIN `operationtbl` AS f2 ON `f2`.`id`='".addslashes($v0['id'])."'
                                    LEFT JOIN `operationtbl` AS f3 ON `f3`.`id`='".addslashes($v0['id'])."'
                                    LEFT JOIN `operationtbl` AS f4 ON `f4`.`id`='".addslashes($v0['id'])."'
                                   WHERE `operationtbl`.`id`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Operations($me['Operations']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $me=array("id"=>1, "Operations" => $this->_Operations);
      foreach($me['Operations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `operationtbl` WHERE `id`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Operations'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `operationtbl` (`id`,`name`,`call`,`output`) VALUES (".((null!=$v0['id'])?"'".addslashes($v0['id'])."'":"NULL").", '".addslashes($v0['name'])."', '".addslashes($v0['call'])."', '".addslashes($v0['outputURL'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['Operations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($v0['name'])."'",5);
      }
      foreach($me['Operations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($v0['call'])."'",5);
      }
      foreach($me['Operations'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `text` (`i`) VALUES ('".addslashes($v0['name'])."')", 5);
      }
      foreach($me['Operations'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `text` (`i`) VALUES ('".addslashes($v0['call'])."')", 5);
      }
      foreach($me['Operations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `compilation` WHERE `i`='".addslashes($v0['outputURL'])."'",5);
      }
      foreach($me['Operations'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `compilation` (`i`) VALUES ('".addslashes($v0['outputURL'])."')", 5);
      }
      if (!checkRule1()){
        $DB_err='\"path[Bestand*Text] is univalent\"';
      } else
      if (!checkRule6()){
        $DB_err='\"ip[Session*Text] is univalent\"';
      } else
      if (!checkRule10()){
        $DB_err='\"type[Actie*Operation] is univalent\"';
      } else
      if (!checkRule14()){
        $DB_err='\"name[Operation*Text] is injective\"';
      } else
      if (!checkRule15()){
        $DB_err='\"name[Operation*Text] is univalent\"';
      } else
      if (!checkRule16()){
        $DB_err='\"name[Operation*Text] is total\"';
      } else
      if (!checkRule17()){
        $DB_err='\"call[Operation*Text] is univalent\"';
      } else
      if (!checkRule18()){
        $DB_err='\"call[Operation*Text] is total\"';
      } else
      if (!checkRule19()){
        $DB_err='\"output[Operation*Compilation] is univalent\"';
      } else
      if (!checkRule20()){
        $DB_err='\"output[Operation*Compilation] is total\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Operations($val){
      $this->_Operations=$val;
    }
    function get_Operations(){
      if(!isset($this->_Operations)) return array();
      return $this->_Operations;
    }
  }

?>