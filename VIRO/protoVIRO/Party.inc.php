<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 720, file "VIRO453ENG.adl"
    SERVICE Party : I[Party]
   = [ cases : plaintiff\/defendant\/joinedInterestedParty
        = [ nr : [Case]
          , caretaker of case file : caretaker
          , area of law : areaOfLaw
          , type of case : caseType
          ]
     , role : actsas
     , authorized : by~
        = [ representative : authorizedRepresentative~
          ]
     , correspondence : from~\/to~
        = [ from : from
          , to : to
          , sent at : sent
          ]
     ]
   *********/
  
  class Party {
    protected $_id=false;
    protected $_new=true;
    private $_cases;
    private $_role;
    private $_authorized;
    private $_correspondence;
    function Party($id=null, $cases=null, $role=null, $authorized=null, $correspondence=null){
      $this->_id=$id;
      $this->_cases=$cases;
      $this->_role=$role;
      $this->_authorized=$authorized;
      $this->_correspondence=$correspondence;
      if(!isset($cases) && isset($id)){
        // get a Party based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttParty` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttParty`, `i`
                                  FROM `party`
                              ) AS fst
                          WHERE fst.`AttParty` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['cases']=(DB_doquer("SELECT DISTINCT `f1`.`case` AS `id`
                                     FROM `party`
                                     JOIN  ( 
                                                  (SELECT DISTINCT party, case
                                                        FROM `plaintiff`
                                                  ) UNION (SELECT DISTINCT party, case
                                                        FROM `defendant`
                                                  ) UNION (SELECT DISTINCT party, case
                                                        FROM `joinedinterestedparty`
                                                  
                                                  
                                                  )
                                                ) AS f1
                                       ON `f1`.`party`='".addslashes($id)."'
                                    WHERE `party`.`i`='".addslashes($id)."'"));
          $me['role']=firstCol(DB_doquer("SELECT DISTINCT `actsas`.`role`
                                            FROM `actsas`
                                           WHERE `actsas`.`party`='".addslashes($id)."'"));
          $me['authorized']=(DB_doquer("SELECT DISTINCT `authorization`.`i` AS `id`
                                          FROM `authorization`
                                         WHERE `authorization`.`by`='".addslashes($id)."'"));
          $me['correspondence']=(DB_doquer("SELECT DISTINCT `f1`.`i` AS `id`
                                              FROM `party`
                                              JOIN  ( 
                                                           (SELECT DISTINCT from, i
                                                                 FROM `document`
                                                           ) UNION (SELECT DISTINCT party AS `from`, document AS `i`
                                                                 FROM `to`
                                                           
                                                           )
                                                         ) AS f1
                                                ON `f1`.`from`='".addslashes($id)."'
                                             WHERE `party`.`i`='".addslashes($id)."'"));
          foreach($me['cases'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `nr`
                                         , `f3`.`caretaker` AS `caretaker of case file`
                                         , `f4`.`areaoflaw` AS `area of law`
                                         , `f5`.`casetype` AS `type of case`
                                      FROM `case`
                                      LEFT JOIN `case` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `case` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `case` AS f5 ON `f5`.`i`='".addslashes($v0['id'])."'
                                     WHERE `case`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['authorized'] as $i0=>&$v0){
            $v0['representative']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `representative`
                                                        FROM `authorization`
                                                        JOIN `authorizedrepresentative` AS f1 ON `f1`.`authorization`='".addslashes($v0['id'])."'
                                                       WHERE `authorization`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['correspondence'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`from`
                                         , `f3`.`sent` AS `sent at`
                                      FROM `document`
                                      LEFT JOIN `document` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `document` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                     WHERE `document`.`i`='".addslashes($v0['id'])."'"));
            $v0['to']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `to`
                                            FROM `document`
                                            JOIN `to` AS f1 ON `f1`.`document`='".addslashes($v0['id'])."'
                                           WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_cases($me['cases']);
          $this->set_role($me['role']);
          $this->set_authorized($me['authorized']);
          $this->set_correspondence($me['correspondence']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttParty` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttParty`, `i`
                                  FROM `party`
                              ) AS fst
                          WHERE fst.`AttParty` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "cases" => $this->_cases, "role" => $this->_role, "authorized" => $this->_authorized, "correspondence" => $this->_correspondence);
      foreach($me['correspondence'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `document` SET `from`='".addslashes($v0['from'])."', `sent`='".addslashes($v0['sent at'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
      }
      foreach($me['cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `case` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['cases'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `case` (`i`,`caretaker`,`areaoflaw`,`casetype`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['caretaker of case file'])."', '".addslashes($v0['area of law'])."', '".addslashes($v0['type of case'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for nr,i in case
      DB_doquer("DELETE FROM `authorization` WHERE `by`='".addslashes($me['id'])."'",5);
      // no code for authorized,i in authorization
      foreach  ($me['authorized'] as $authorized){
        $res=DB_doquer("INSERT IGNORE INTO `authorization` (`i`,`by`) VALUES ('".addslashes($authorized['id'])."', '".addslashes($me['id'])."')", 5);
        if($newID) $this->setId($me['id']=mysql_insert_id());
      }
      foreach($me['cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `organ` WHERE `i`='".addslashes($v0['caretaker of case file'])."'",5);
      }
      foreach($me['cases'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `organ` (`i`) VALUES ('".addslashes($v0['caretaker of case file'])."')", 5);
      }
      foreach($me['authorized'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['correspondence'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['from'])."'",5);
      }
      foreach($me['correspondence'] as $i0=>$v0){
        foreach($v0['to'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['authorized'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['correspondence'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0['from'])."')", 5);
      }
      foreach($me['correspondence'] as $i0=>$v0){
        foreach($v0['to'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($v0['area of law'])."'",5);
      }
      foreach($me['cases'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `areaoflaw` (`i`) VALUES ('".addslashes($v0['area of law'])."')", 5);
      }
      foreach($me['cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v0['type of case'])."'",5);
      }
      foreach($me['cases'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `casetype` (`i`) VALUES ('".addslashes($v0['type of case'])."')", 5);
      }
      foreach($me['role'] as $i0=>$v0){
        DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['role'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `role` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['correspondence'] as $i0=>$v0){
        DB_doquer("DELETE FROM `timestamp` WHERE `i`='".addslashes($v0['sent at'])."'",5);
      }
      foreach($me['correspondence'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `timestamp` (`i`) VALUES ('".addslashes($v0['sent at'])."')", 5);
      }
      // no code for cases,case in plaintiff
      // no code for nr,case in plaintiff
      foreach($me['authorized'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorizedrepresentative` WHERE `authorization`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['authorized'] as $i0=>$v0){
        foreach  ($v0['representative'] as $representative){
          $res=DB_doquer("INSERT IGNORE INTO `authorizedrepresentative` (`authorization`,`party`) VALUES ('".addslashes($v0['id'])."', '".addslashes($representative)."')", 5);
        }
      }
      DB_doquer("DELETE FROM `actsas` WHERE `party`='".addslashes($me['id'])."'",5);
      foreach  ($me['role'] as $role){
        $res=DB_doquer("INSERT IGNORE INTO `actsas` (`role`,`party`) VALUES ('".addslashes($role)."', '".addslashes($me['id'])."')", 5);
      }
      foreach($me['correspondence'] as $i0=>$v0){
        DB_doquer("DELETE FROM `to` WHERE `document`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['correspondence'] as $i0=>$v0){
        foreach  ($v0['to'] as $to){
          $res=DB_doquer("INSERT IGNORE INTO `to` (`document`,`party`) VALUES ('".addslashes($v0['id'])."', '".addslashes($to)."')", 5);
        }
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule8()){
        $DB_err='\"\"';
      } else
      if (!checkRule9()){
        $DB_err='\"\"';
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
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule15()){
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
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule45()){
        $DB_err='\"\"';
      } else
      if (!checkRule46()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if (!checkRule48()){
        $DB_err='\"\"';
      } else
      if (!checkRule49()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
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
      $me=array("id"=>$this->getId(), "cases" => $this->_cases, "role" => $this->_role, "authorized" => $this->_authorized, "correspondence" => $this->_correspondence);
      foreach($me['cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `case` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `authorization` WHERE `by`='".addslashes($me['id'])."'",5);
      foreach($me['cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `organ` WHERE `i`='".addslashes($v0['caretaker of case file'])."'",5);
      }
      foreach($me['authorized'] as $i0=>$v0){
        foreach($v0['representative'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['correspondence'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['from'])."'",5);
      }
      foreach($me['correspondence'] as $i0=>$v0){
        foreach($v0['to'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($v0['area of law'])."'",5);
      }
      foreach($me['cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v0['type of case'])."'",5);
      }
      foreach($me['role'] as $i0=>$v0){
        DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['correspondence'] as $i0=>$v0){
        DB_doquer("DELETE FROM `timestamp` WHERE `i`='".addslashes($v0['sent at'])."'",5);
      }
      foreach($me['authorized'] as $i0=>$v0){
        DB_doquer("DELETE FROM `authorizedrepresentative` WHERE `authorization`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `actsas` WHERE `party`='".addslashes($me['id'])."'",5);
      foreach($me['correspondence'] as $i0=>$v0){
        DB_doquer("DELETE FROM `to` WHERE `document`='".addslashes($v0['id'])."'",5);
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule8()){
        $DB_err='\"\"';
      } else
      if (!checkRule9()){
        $DB_err='\"\"';
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
      if (!checkRule13()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule15()){
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
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule45()){
        $DB_err='\"\"';
      } else
      if (!checkRule46()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if (!checkRule48()){
        $DB_err='\"\"';
      } else
      if (!checkRule49()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_cases($val){
      $this->_cases=$val;
    }
    function get_cases(){
      if(!isset($this->_cases)) return array();
      return $this->_cases;
    }
    function set_role($val){
      $this->_role=$val;
    }
    function get_role(){
      if(!isset($this->_role)) return array();
      return $this->_role;
    }
    function set_authorized($val){
      $this->_authorized=$val;
    }
    function get_authorized(){
      if(!isset($this->_authorized)) return array();
      return $this->_authorized;
    }
    function set_correspondence($val){
      $this->_correspondence=$val;
    }
    function get_correspondence(){
      if(!isset($this->_correspondence)) return array();
      return $this->_correspondence;
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

  function getEachParty(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `party`'));
  }

  function readParty($id){
      // check existence of $id
      $obj = new Party($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delParty($id){
    $tobeDeleted = new Party($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>