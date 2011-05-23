<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 935, file "VIRO453ENG.adl"
    SERVICE InterestedParty : I[Party]
   = [ cases : plaintiff\/defendant\/joinedInterestedParty
        = [ nr : [Case]
          , caretaker of case file : caretaker
          , area of law : areaOfLaw
          , type of case : caseType
          ]
     , correspondence : from~\/to~
        = [ from : from
          , to : to
          , mark : propertyOf
          , sent at : sent
          ]
     ]
   *********/
  
  class InterestedParty {
    protected $_id=false;
    protected $_new=true;
    private $_cases;
    private $_correspondence;
    function InterestedParty($id=null, $cases=null, $correspondence=null){
      $this->_id=$id;
      $this->_cases=$cases;
      $this->_correspondence=$correspondence;
      if(!isset($cases) && isset($id)){
        // get a InterestedParty based on its identifier
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
          foreach($me['correspondence'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`from`
                                         , `f3`.`propertyof` AS `mark`
                                         , `f4`.`sent` AS `sent at`
                                      FROM `document`
                                      LEFT JOIN `document` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `document` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `document` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `document`.`i`='".addslashes($v0['id'])."'"));
            $v0['to']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `to`
                                            FROM `document`
                                            JOIN `to` AS f1 ON `f1`.`document`='".addslashes($v0['id'])."'
                                           WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_cases($me['cases']);
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
      $me=array("id"=>$this->getId(), "cases" => $this->_cases, "correspondence" => $this->_correspondence);
      foreach($me['correspondence'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `document` SET `from`='".addslashes($v0['from'])."', `propertyof`='".addslashes($v0['mark'])."', `sent`='".addslashes($v0['sent at'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
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
      foreach($me['cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `organ` WHERE `i`='".addslashes($v0['caretaker of case file'])."'",5);
      }
      foreach($me['cases'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `organ` (`i`) VALUES ('".addslashes($v0['caretaker of case file'])."')", 5);
      }
      foreach($me['correspondence'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0['from'])."'",5);
      }
      foreach($me['correspondence'] as $i0=>$v0){
        foreach($v0['to'] as $i1=>$v1){
          DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v1)."'",5);
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
      foreach($me['correspondence'] as $i0=>$v0){
        DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($v0['mark'])."'",5);
      }
      foreach($me['correspondence'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `text` (`i`) VALUES ('".addslashes($v0['mark'])."')", 5);
      }
      foreach($me['correspondence'] as $i0=>$v0){
        DB_doquer("DELETE FROM `timestamp` WHERE `i`='".addslashes($v0['sent at'])."'",5);
      }
      foreach($me['correspondence'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `timestamp` (`i`) VALUES ('".addslashes($v0['sent at'])."')", 5);
      }
      // no code for cases,case in plaintiff
      // no code for nr,case in plaintiff
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
      if (!checkRule14()){
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
      if (!checkRule19()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
        $DB_err='\"\"';
      } else
      if (!checkRule48()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
        $DB_err='\"\"';
      } else
      if (!checkRule54()){
        $DB_err='\"\"';
      } else
      if (!checkRule55()){
        $DB_err='\"\"';
      } else
      if (!checkRule56()){
        $DB_err='\"\"';
      } else
      if (!checkRule57()){
        $DB_err='\"\"';
      } else
      if (!checkRule58()){
        $DB_err='\"\"';
      } else
      if (!checkRule59()){
        $DB_err='\"\"';
      } else
      if (!checkRule60()){
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
      $me=array("id"=>$this->getId(), "cases" => $this->_cases, "correspondence" => $this->_correspondence);
      foreach($me['cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `case` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `organ` WHERE `i`='".addslashes($v0['caretaker of case file'])."'",5);
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
      foreach($me['correspondence'] as $i0=>$v0){
        DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($v0['mark'])."'",5);
      }
      foreach($me['correspondence'] as $i0=>$v0){
        DB_doquer("DELETE FROM `timestamp` WHERE `i`='".addslashes($v0['sent at'])."'",5);
      }
      foreach($me['correspondence'] as $i0=>$v0){
        DB_doquer("DELETE FROM `to` WHERE `document`='".addslashes($v0['id'])."'",5);
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
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
      if (!checkRule14()){
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
      if (!checkRule19()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
        $DB_err='\"\"';
      } else
      if (!checkRule48()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
        $DB_err='\"\"';
      } else
      if (!checkRule54()){
        $DB_err='\"\"';
      } else
      if (!checkRule55()){
        $DB_err='\"\"';
      } else
      if (!checkRule56()){
        $DB_err='\"\"';
      } else
      if (!checkRule57()){
        $DB_err='\"\"';
      } else
      if (!checkRule58()){
        $DB_err='\"\"';
      } else
      if (!checkRule59()){
        $DB_err='\"\"';
      } else
      if (!checkRule60()){
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

  function getEachInterestedParty(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `party`'));
  }

  function readInterestedParty($id){
      // check existence of $id
      $obj = new InterestedParty($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delInterestedParty($id){
    $tobeDeleted = new InterestedParty($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>