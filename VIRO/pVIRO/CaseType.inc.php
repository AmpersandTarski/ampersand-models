<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 423, file "VIROENG.adl"
    SERVICE CaseType : I[CaseType]
   = [ Cases : caseType~;appeal~\/caseType~;appealToAdminCourt~\/caseType~;objection~
        = [ nr : [LegalCase]
          , area of law : areaOfLaw
          ]
     ]
   *********/
  
  class CaseType {
    protected $_id=false;
    protected $_new=true;
    private $_Cases;
    function CaseType($id=null, $Cases=null){
      $this->_id=$id;
      $this->_Cases=$Cases;
      if(!isset($Cases) && isset($id)){
        // get a CaseType based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttCaseType` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttCaseType`, `i`
                                  FROM `casetype`
                              ) AS fst
                          WHERE fst.`AttCaseType` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['Cases']=(DB_doquer("SELECT DISTINCT `f1`.`legalcase` AS `id`
                                     FROM `casetype`
                                     JOIN  ( 
                                                  (SELECT DISTINCT F0.`casetype`, F1.`legalcase`
                                                        FROM `legalcase` AS F0, `appeal` AS F1
                                                       WHERE F0.`i`=F1.`legalcase1`
                                                  ) UNION (SELECT DISTINCT F0.`casetype`, F1.`legalcase`
                                                        FROM `legalcase` AS F0, `appealtoadmincourt` AS F1
                                                       WHERE F0.`i`=F1.`legalcase1`
                                                  ) UNION (SELECT DISTINCT F0.`casetype`, F1.`legalcase`
                                                        FROM `legalcase` AS F0, `objection` AS F1
                                                       WHERE F0.`i`=F1.`legalcase1`
                                                  
                                                  
                                                  )
                                                ) AS f1
                                       ON `f1`.`casetype`='".addslashes($id)."'
                                    WHERE `casetype`.`i`='".addslashes($id)."'"));
          foreach($me['Cases'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `nr`
                                         , `f3`.`areaoflaw` AS `area of law`
                                      FROM `legalcase`
                                      LEFT JOIN `legalcase` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                     WHERE `legalcase`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_Cases($me['Cases']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttCaseType` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttCaseType`, `i`
                                  FROM `casetype`
                              ) AS fst
                          WHERE fst.`AttCaseType` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "Cases" => $this->_Cases);
      foreach($me['Cases'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `legalcase` SET `i`='".addslashes($v0['id'])."', `areaoflaw`='".addslashes($v0['area of law'])."' WHERE `i`='".addslashes($v0['nr'])."'", 5);
      }
      // no code for nr,i in legalcase
      foreach($me['Cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($v0['area of law'])."'",5);
      }
      foreach($me['Cases'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `areaoflaw` (`i`) VALUES ('".addslashes($v0['area of law'])."')", 5);
      }
      // no code for Cases,legalcase in plaintiff
      // no code for nr,legalcase in plaintiff
      if (!checkRule3()){
        $DB_err='\"Every administrative case is either an appeal or an objection or an appeal to an administrative court. (Art.6:4 Awb)\"';
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
      if (!checkRule35()){
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
      $me=array("id"=>$this->getId(), "Cases" => $this->_Cases);
      foreach($me['Cases'] as $i0=>$v0){
        DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($v0['area of law'])."'",5);
      }
      if (!checkRule3()){
        $DB_err='\"Every administrative case is either an appeal or an objection or an appeal to an administrative court. (Art.6:4 Awb)\"';
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
      if (!checkRule35()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Cases($val){
      $this->_Cases=$val;
    }
    function get_Cases(){
      if(!isset($this->_Cases)) return array();
      return $this->_Cases;
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

  function getEachCaseType(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `casetype`'));
  }

  function readCaseType($id){
      // check existence of $id
      $obj = new CaseType($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delCaseType($id){
    $tobeDeleted = new CaseType($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>