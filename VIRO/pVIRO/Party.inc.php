<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 397, file "VIROENG.adl"
    SERVICE Party : I[Party]
   = [ cases : plaintiff\/defendant
        = [ nr : [LegalCase]
          , area of law : areaOfLaw
          , type of case : appeal;caseType\/appealToAdminCourt;caseType\/objection;caseType
          ]
     , role : actsas
     , authorized : authBy~
        = [ representative : writtenAuthOf
          ]
     ]
   *********/
  
  class Party {
    protected $_id=false;
    protected $_new=true;
    private $_cases;
    private $_role;
    private $_authorized;
    function Party($id=null, $cases=null, $role=null, $authorized=null){
      $this->_id=$id;
      $this->_cases=$cases;
      $this->_role=$role;
      $this->_authorized=$authorized;
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
          $me=firstRow(DB_doquer("SELECT DISTINCT `party`.`i` AS `id`
                                       , `party`.`actsas` AS `role`
                                    FROM `party`
                                   WHERE `party`.`i`='".addslashes($id)."'"));
          $me['cases']=(DB_doquer("SELECT DISTINCT `f1`.`legalcase` AS `id`
                                     FROM `party`
                                     JOIN  ( 
                                                  (SELECT DISTINCT party, legalcase
                                                        FROM `plaintiff`
                                                  ) UNION (SELECT DISTINCT party, legalcase
                                                        FROM `defendant`
                                                  
                                                  )
                                                ) AS f1
                                       ON `f1`.`party`='".addslashes($id)."'
                                    WHERE `party`.`i`='".addslashes($id)."'"));
          $me['authorized']=(DB_doquer("SELECT DISTINCT `f1`.`document` AS `id`
                                          FROM `party`
                                          JOIN `authby` AS f1 ON `f1`.`Party`='".addslashes($id)."'
                                         WHERE `party`.`i`='".addslashes($id)."'"));
          foreach($me['cases'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `nr`
                                         , `f3`.`areaoflaw` AS `area of law`
                                      FROM `legalcase`
                                      LEFT JOIN `legalcase` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                     WHERE `legalcase`.`i`='".addslashes($v0['id'])."'"));
            $v0['type of case']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`casetype` AS `type of case`
                                                      FROM `legalcase`
                                                      JOIN  ( 
                                                                   (SELECT DISTINCT F0.`legalcase`, F1.`casetype`
                                                                         FROM `appeal` AS F0, `legalcase` AS F1
                                                                        WHERE F0.`legalcase1`=F1.`i`
                                                                   ) UNION (SELECT DISTINCT F0.`legalcase`, F1.`casetype`
                                                                         FROM `appealtoadmincourt` AS F0, `legalcase` AS F1
                                                                        WHERE F0.`legalcase1`=F1.`i`
                                                                   ) UNION (SELECT DISTINCT F0.`legalcase`, F1.`casetype`
                                                                         FROM `objection` AS F0, `legalcase` AS F1
                                                                        WHERE F0.`legalcase1`=F1.`i`
                                                                   
                                                                   
                                                                   )
                                                                 ) AS f1
                                                        ON `f1`.`legalcase`='".addslashes($v0['id'])."'
                                                     WHERE `legalcase`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['authorized'] as $i0=>&$v0){
            $v0['representative']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Party` AS `representative`
                                                        FROM `document`
                                                        JOIN `writtenauthof` AS f1 ON `f1`.`document`='".addslashes($v0['id'])."'
                                                       WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_cases($me['cases']);
          $this->set_role($me['role']);
          $this->set_authorized($me['authorized']);
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
      $me=array("id"=>$this->getId(), "cases" => $this->_cases, "role" => $this->_role, "authorized" => $this->_authorized);
      // no code for authorized,i in document
      foreach($me['cases'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `legalcase` SET `i`='".addslashes($v0['id'])."', `areaoflaw`='".addslashes($v0['area of law'])."' WHERE `i`='".addslashes($v0['nr'])."'", 5);
      }
      // no code for nr,i in legalcase
      DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `party` (`actsas`,`i`) VALUES ('".addslashes($me['role'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for representative,i in party
      foreach($me['cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($v0['area of law'])."'",5);
      }
      foreach($me['cases'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `areaoflaw` (`i`) VALUES ('".addslashes($v0['area of law'])."')", 5);
      }
      foreach($me['cases'] as $i0=>$v0){
        foreach($v0['type of case'] as $i1=>$v1){
          DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['cases'] as $i0=>$v0){
        foreach($v0['type of case'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `casetype` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($me['role'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `role` (`i`) VALUES ('".addslashes($me['role'])."')", 5);
      // no code for cases,legalcase in plaintiff
      // no code for nr,legalcase in plaintiff
      foreach($me['authorized'] as $i0=>$v0){
        DB_doquer("DELETE FROM `writtenauthof` WHERE `document`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['authorized'] as $i0=>$v0){
        foreach  ($v0['representative'] as $representative){
          $res=DB_doquer("INSERT IGNORE INTO `writtenauthof` (`party`,`document`) VALUES ('".addslashes($representative)."', '".addslashes($v0['id'])."')", 5);
        }
      }
      if (!checkRule1()){
        $DB_err='\"The plaintiff in an administrative case is a juristic person\"';
      } else
      if (!checkRule2()){
        $DB_err='\"The defendant in an administrative case is an administrative authority as referred to in art.1:1 Awb.\"';
      } else
      if (!checkRule3()){
        $DB_err='\"Every administrative case is either an appeal or an objection or an appeal to an administrative court. (Art.6:4 Awb)\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Every party is either a person or an organization or an administrative authority.\"';
      } else
      if (!checkRule11()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
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
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule24()){
        $DB_err='\"\"';
      } else
      if (!checkRule26()){
        $DB_err='\"\"';
      } else
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if (!checkRule30()){
        $DB_err='\"\"';
      } else
      if (!checkRule32()){
        $DB_err='\"\"';
      } else
      if (!checkRule35()){
        $DB_err='\"\"';
      } else
      if (!checkRule42()){
        $DB_err='\"\"';
      } else
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule45()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
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
      $me=array("id"=>$this->getId(), "cases" => $this->_cases, "role" => $this->_role, "authorized" => $this->_authorized);
      DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($me['id'])."'",5);
      foreach($me['cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($v0['area of law'])."'",5);
      }
      foreach($me['cases'] as $i0=>$v0){
        foreach($v0['type of case'] as $i1=>$v1){
          DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      DB_doquer("DELETE FROM `role` WHERE `i`='".addslashes($me['role'])."'",5);
      foreach($me['authorized'] as $i0=>$v0){
        DB_doquer("DELETE FROM `writtenauthof` WHERE `document`='".addslashes($v0['id'])."'",5);
      }
      if (!checkRule1()){
        $DB_err='\"The plaintiff in an administrative case is a juristic person\"';
      } else
      if (!checkRule2()){
        $DB_err='\"The defendant in an administrative case is an administrative authority as referred to in art.1:1 Awb.\"';
      } else
      if (!checkRule3()){
        $DB_err='\"Every administrative case is either an appeal or an objection or an appeal to an administrative court. (Art.6:4 Awb)\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Every party is either a person or an organization or an administrative authority.\"';
      } else
      if (!checkRule11()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
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
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule24()){
        $DB_err='\"\"';
      } else
      if (!checkRule26()){
        $DB_err='\"\"';
      } else
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if (!checkRule30()){
        $DB_err='\"\"';
      } else
      if (!checkRule32()){
        $DB_err='\"\"';
      } else
      if (!checkRule35()){
        $DB_err='\"\"';
      } else
      if (!checkRule42()){
        $DB_err='\"\"';
      } else
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule45()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
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
      return $this->_role;
    }
    function set_authorized($val){
      $this->_authorized=$val;
    }
    function get_authorized(){
      if(!isset($this->_authorized)) return array();
      return $this->_authorized;
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