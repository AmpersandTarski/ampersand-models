<?php // generated with ADL vs. 1.1.0.801
  
  /********* on line 105, file "F:\\RJ$\\Prive\\CC model repository\\Adlfiles\\SessionAccounts.adl"
    SERVICE Login : I[Session]/\-(sUser;sUser~)
   = [ username : loginSession~;loginUsername
     , password : loginSession~;loginPassword
     , succes : (I[Session]/\sUser;sUser~);V[Session*Text];'U bent ingelogd'[Text]
     ]
   *********/
  
  class Login {
    protected $id=false;
    protected $_new=true;
    private $_username;
    private $_password;
    private $_succes;
    function Login($id=null, $_username=null, $_password=null, $_succes=null){
      $this->id=$id;
      $this->_username=$_username;
      $this->_password=$_password;
      $this->_succes=$_succes;
      if(!isset($_username) && isset($id)){
        // get a Login based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpSession` AS `I`
                           FROM 
                              ( SELECT DISTINCT isect0.`I` AS `MpSession`, isect0.`I`
                                  FROM `Session` AS isect0
                                 WHERE NOT EXISTS (SELECT *
                                              FROM 
                                                 ( SELECT DISTINCT F0.`I`, F1.`I` AS `I1`
                                                     FROM `Session` AS F0, `Session` AS F1
                                                    WHERE F0.`sUser`=F1.`sUser`
                                                 ) AS cp
                                             WHERE isect0.`I`=cp.`I` AND isect0.`I`=cp.`I1`) AND isect0.`I` IS NOT NULL AND isect0.`I` IS NOT NULL
                              ) AS fst
                          WHERE fst.`MpSession` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `Session`.`I` AS `id`
                                       , `f1`.`loginUsername` AS `username`
                                       , `f2`.`loginPassword` AS `password`
                                    FROM `Session`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`loginUsername`
                                                   FROM `Session` AS F0, `Session` AS F1
                                                  WHERE F0.`loginSession`=F1.`loginSession`
                                               ) AS f1
                                      ON `f1`.`I`='".addslashes($id)."'
                                    LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`loginPassword`
                                                   FROM `Session` AS F0, `Session` AS F1
                                                  WHERE F0.`loginSession`=F1.`loginSession`
                                               ) AS f2
                                      ON `f2`.`I`='".addslashes($id)."'
                                   WHERE `Session`.`I`='".addslashes($id)."'"));
          $me['succes']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`MpText` AS `succes`
                                              FROM `Session`
                                              JOIN  ( SELECT DISTINCT fst.`I`, snd.`MpText1` AS `MpText`
                                                             FROM 
                                                                ( SELECT DISTINCT isect0.`I`
                                                                    FROM 
                                                                       ( SELECT DISTINCT F0.`I`, F1.`I` AS `I1`
                                                                           FROM `Session` AS F0, `Session` AS F1
                                                                          WHERE F0.`sUser`=F1.`sUser`
                                                                       ) AS isect0, `Session` AS isect1
                                                                   WHERE isect0.`I` = isect0.`I1` AND isect0.`I` IS NOT NULL AND isect0.`I1` IS NOT NULL
                                                                ) AS fst, ( SELECT U bent ingelogd AS `MpText`, U bent ingelogd AS `MpText1` ) AS snd
                                                            WHERE fst.`I` IS NOT NULL
                                                         ) AS f1
                                                ON `f1`.`I`='".addslashes($id)."'
                                             WHERE `Session`.`I`='".addslashes($id)."'"));
          $this->set_username($me['username']);
          $this->set_password($me['password']);
          $this->set_succes($me['succes']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpSession` AS `I`
                           FROM 
                              ( SELECT DISTINCT isect0.`I` AS `MpSession`, isect0.`I`
                                  FROM `Session` AS isect0
                                 WHERE NOT EXISTS (SELECT *
                                              FROM 
                                                 ( SELECT DISTINCT F0.`I`, F1.`I` AS `I1`
                                                     FROM `Session` AS F0, `Session` AS F1
                                                    WHERE F0.`sUser`=F1.`sUser`
                                                 ) AS cp
                                             WHERE isect0.`I`=cp.`I` AND isect0.`I`=cp.`I1`) AND isect0.`I` IS NOT NULL AND isect0.`I` IS NOT NULL
                              ) AS fst
                          WHERE fst.`MpSession` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "username" => $this->_username, "password" => $this->_password, "succes" => $this->_succes);
      $res=DB_doquer("INSERT IGNORE INTO `Session` (`I`) VALUES ('".addslashes($me['id'])."')", 5);
      $res=DB_doquer("INSERT IGNORE INTO `UserAccount` (`I`) VALUES ('".addslashes($me['username'])."')", 5);
      foreach($me['succes'] as $i0=>$v0){
        DB_doquer("DELETE FROM `Text1` WHERE `I`='".addslashes($v0)."'",5);
      }
      foreach($me['succes'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `Text1` (`I`) VALUES ('".addslashes($v0)."')", 5);
      }
      DB_doquer("DELETE FROM `Password` WHERE `I`='".addslashes($me['password'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `Password` (`I`) VALUES ('".addslashes($me['password'])."')", 5);
      if (!checkRule2()){
        $DB_err='\"Als ooit in een sessie ingelogd is geweest, kan de sessie alleen\\nworden gecontinueerd met behulp van het oorspronkelijke sessie\\naccount.\\n\"';
      } else
      if (!checkRule3()){
        $DB_err='\"De relatie-namen sAccount\' en \'sUser\' zijn aliassen van elkaar.\\n\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Inloggen leidt tot een sessionuser desda het wachtwoord is ingevuld\\ndat bij de username hoort.\\n\"';
      } else
      if (!checkRule5()){
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
      $me=array("id"=>$this->getId(), "username" => $this->_username, "password" => $this->_password, "succes" => $this->_succes);
      foreach($me['succes'] as $i0=>$v0){
        DB_doquer("DELETE FROM `Text1` WHERE `I`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `Password` WHERE `I`='".addslashes($me['password'])."'",5);
      if (!checkRule2()){
        $DB_err='\"Als ooit in een sessie ingelogd is geweest, kan de sessie alleen\\nworden gecontinueerd met behulp van het oorspronkelijke sessie\\naccount.\\n\"';
      } else
      if (!checkRule3()){
        $DB_err='\"De relatie-namen sAccount\' en \'sUser\' zijn aliassen van elkaar.\\n\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Inloggen leidt tot een sessionuser desda het wachtwoord is ingevuld\\ndat bij de username hoort.\\n\"';
      } else
      if (!checkRule5()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_username($val){
      $this->_username=$val;
    }
    function get_username(){
      return $this->_username;
    }
    function set_password($val){
      $this->_password=$val;
    }
    function get_password(){
      return $this->_password;
    }
    function set_succes($val){
      $this->_succes=$val;
    }
    function get_succes(){
      if(!isset($this->_succes)) return array();
      return $this->_succes;
    }
    function setId($id){
      $this->id=$id;
      return $this->id;
    }
    function getId(){
      if($this->id===null) return false;
      return $this->id;
    }
    function isNew(){
      return $this->_new;
    }
  }

  function getEachLogin(){
    return firstCol(DB_doquer('SELECT DISTINCT isect0.`I`
                                 FROM `Session` AS isect0
                                WHERE NOT EXISTS (SELECT *
                                             FROM 
                                                ( SELECT DISTINCT F0.`I`, F1.`I` AS `I1`
                                                    FROM `Session` AS F0, `Session` AS F1
                                                   WHERE F0.`sUser`=F1.`sUser`
                                                ) AS cp
                                            WHERE isect0.`I`=cp.`I` AND isect0.`I`=cp.`I1`) AND isect0.`I` IS NOT NULL AND isect0.`I` IS NOT NULL'));
  }

  function readLogin($id){
      // check existence of $id
      $obj = new Login($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delLogin($id){
    $tobeDeleted = new Login($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>