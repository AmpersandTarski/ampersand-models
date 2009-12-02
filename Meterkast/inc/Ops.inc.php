<?php // generated with ADL vs. 0.8.10-408
  
  /********* on line 46, file "Meterkast.adl"
    SERVICE Ops : I[ONE]
   = [ Operations : [ONE*Operation]
        = [ name : name
          , call : call
          ]
     ]
   *********/
  
  class Ops {
    private $_Operations;
    function Ops($Operations=null){
      $this->_Operations=$Operations;
      if(!isset($Operations)){
        // get a Ops based on its identifier
        // fill the attributes
        $me=array();
        $me['Operations']=(DB_doquer("SELECT DISTINCT `f1`.`Operation` AS `id`
                                        FROM  ( SELECT DISTINCT csnd.Id AS `Operation`
                                                  FROM OperationTbl AS csnd
                                              ) AS f1"));
        foreach($me['Operations'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , `f2`.`name`
                                       , `f3`.`call`
                                    FROM `OperationTbl`
                                    LEFT JOIN `OperationTbl` AS f2 ON `f2`.`Id`='".addslashes($v0['id'])."'
                                    LEFT JOIN `OperationTbl` AS f3 ON `f3`.`Id`='".addslashes($v0['id'])."'
                                   WHERE `OperationTbl`.`Id`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Operations($me['Operations']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Operations" => $this->_Operations);
      foreach($me['Operations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `OperationTbl` WHERE `Id`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Operations'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `OperationTbl` (`Id`,`name`,`call`) VALUES (".((null!=$v0['id'])?"'".addslashes($v0['id'])."'":"NULL").", '".addslashes($v0['name'])."', '".addslashes($v0['call'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['Operations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `text` WHERE `text`='".addslashes($v0['name'])."'",5);
      }
      foreach($me['Operations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `text` WHERE `text`='".addslashes($v0['call'])."'",5);
      }
      foreach($me['Operations'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `text` (`text`) VALUES ('".addslashes($v0['name'])."')", 5);
        if($res!==false && !isset($v0['name']['id']))
          $v0['name']['id']=mysql_insert_id();
      }
      foreach($me['Operations'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `text` (`text`) VALUES ('".addslashes($v0['call'])."')", 5);
        if($res!==false && !isset($v0['call']['id']))
          $v0['call']['id']=mysql_insert_id();
      }
      if (!checkRule1()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule6()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule10()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule12()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule13()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule14()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule15()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule16()){
        $DB_err=$preErr.'\"\"';
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
      return $this->_Operations;
    }
  }

?>