<?php // generated with ADL vs. 1.1-647
  
  /********* on line 73, file "apps/Meterkast/meterkast.adl"
    SERVICE Ops : I[S]
   = [ Operations : [S*Operation]
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
        $me['Operations']=(DB_doquer("SELECT DISTINCT `f1`.`Id` AS `id`
                                        FROM  ( SELECT DISTINCT csnd.Id
                                                  FROM `OperationTbl` AS csnd
                                              ) AS f1"));
        foreach($me['Operations'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , `f2`.`name`
                                       , `f3`.`call`
                                       , `f4`.`output` AS `outputURL`
                                    FROM `OperationTbl`
                                    LEFT JOIN `OperationTbl` AS f2 ON `f2`.`Id`='".addslashes($v0['id'])."'
                                    LEFT JOIN `OperationTbl` AS f3 ON `f3`.`Id`='".addslashes($v0['id'])."'
                                    LEFT JOIN `OperationTbl` AS f4 ON `f4`.`Id`='".addslashes($v0['id'])."'
                                   WHERE `OperationTbl`.`Id`='".addslashes($v0['id'])."'"));
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
        DB_doquer("DELETE FROM `OperationTbl` WHERE `Id`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Operations'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `OperationTbl` (`Id`,`name`,`call`,`output`) VALUES (".((null!=$v0['id'])?"'".addslashes($v0['id'])."'":"NULL").", '".addslashes($v0['name'])."', '".addslashes($v0['call'])."', '".addslashes($v0['outputURL'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      foreach($me['Operations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `Text` WHERE `I`='".addslashes($v0['name'])."'",5);
      }
      foreach($me['Operations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `Text` WHERE `I`='".addslashes($v0['call'])."'",5);
      }
      foreach($me['Operations'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `Text` (`I`) VALUES ('".addslashes($v0['name'])."')", 5);
      }
      foreach($me['Operations'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `Text` (`I`) VALUES ('".addslashes($v0['call'])."')", 5);
      }
      foreach($me['Operations'] as $i0=>$v0){
        DB_doquer("DELETE FROM `Compilation` WHERE `I`='".addslashes($v0['outputURL'])."'",5);
      }
      foreach($me['Operations'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `Compilation` (`I`) VALUES ('".addslashes($v0['outputURL'])."')", 5);
      }
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