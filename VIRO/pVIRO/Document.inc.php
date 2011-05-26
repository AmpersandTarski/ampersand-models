<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 182, file "VIROENG.adl"
    SERVICE Document : I[Document]
   = [ type : documentType
     , case : caseFile
        = [ area of law : areaOfLaw
          , type of case : appeal;caseType\/appealToAdminCourt;caseType\/objection;caseType
          ]
     ]
   *********/
  
  class Document {
    protected $_id=false;
    protected $_new=true;
    private $_type;
    private $_case;
    function Document($id=null, $type=null, $case=null){
      $this->_id=$id;
      $this->_type=$type;
      $this->_case=$case;
      if(!isset($type) && isset($id)){
        // get a Document based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttDocument` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttDocument`, `i`
                                  FROM `document`
                              ) AS fst
                          WHERE fst.`AttDocument` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `document`.`i` AS `id`
                                       , `document`.`documenttype` AS `type`
                                    FROM `document`
                                   WHERE `document`.`i`='".addslashes($id)."'"));
          $me['case']=(DB_doquer("SELECT DISTINCT `casefile`.`legalcase` AS `id`
                                    FROM `casefile`
                                   WHERE `casefile`.`document`='".addslashes($id)."'"));
          foreach($me['case'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`areaoflaw` AS `area of law`
                                      FROM `legalcase`
                                      LEFT JOIN `legalcase` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
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
          $this->set_type($me['type']);
          $this->set_case($me['case']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttDocument` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttDocument`, `i`
                                  FROM `document`
                              ) AS fst
                          WHERE fst.`AttDocument` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "type" => $this->_type, "case" => $this->_case);
      DB_doquer("INSERT IGNORE INTO `document` (`documenttype`,`i`) VALUES ('".addslashes($me['type'])."', '".addslashes($me['id'])."')", 5);
      if(mysql_affected_rows()==0 && $me['id']!=null){
        //nothing inserted, try updating:
        DB_doquer("UPDATE `document` SET `documenttype`='".addslashes($me['type'])."' WHERE `i`='".addslashes($me['id'])."'", 5);
      }
      foreach($me['case'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `legalcase` SET `areaoflaw`='".addslashes($v0['area of law'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
      }
      foreach($me['case'] as $i0=>$v0){
        DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($v0['area of law'])."'",5);
      }
      foreach($me['case'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `areaoflaw` (`i`) VALUES ('".addslashes($v0['area of law'])."')", 5);
      }
      DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($me['type'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `documenttype` (`i`) VALUES ('".addslashes($me['type'])."')", 5);
      foreach($me['case'] as $i0=>$v0){
        foreach($v0['type of case'] as $i1=>$v1){
          DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['case'] as $i0=>$v0){
        foreach($v0['type of case'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `casetype` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      // no code for case,legalcase in plaintiff
      DB_doquer("DELETE FROM `casefile` WHERE `document`='".addslashes($me['id'])."'",5);
      foreach  ($me['case'] as $case){
        $res=DB_doquer("INSERT IGNORE INTO `casefile` (`legalcase`,`document`) VALUES ('".addslashes($case['id'])."', '".addslashes($me['id'])."')", 5);
      }
      if (!checkRule3()){
        $DB_err='\"Written authorizations for representatives of a case are not put in the case file\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Every administrative case is either an appeal or an objection or an appeal to an administrative court. (Art.6:4 Awb)\"';
      } else
      if (!checkRule12()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
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
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule36()){
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
      $me=array("id"=>$this->getId(), "type" => $this->_type, "case" => $this->_case);
      foreach($me['case'] as $i0=>$v0){
        DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($v0['area of law'])."'",5);
      }
      DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($me['type'])."'",5);
      foreach($me['case'] as $i0=>$v0){
        foreach($v0['type of case'] as $i1=>$v1){
          DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      DB_doquer("DELETE FROM `casefile` WHERE `document`='".addslashes($me['id'])."'",5);
      if (!checkRule3()){
        $DB_err='\"Written authorizations for representatives of a case are not put in the case file\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Every administrative case is either an appeal or an objection or an appeal to an administrative court. (Art.6:4 Awb)\"';
      } else
      if (!checkRule12()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
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
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule36()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_type($val){
      $this->_type=$val;
    }
    function get_type(){
      return $this->_type;
    }
    function set_case($val){
      $this->_case=$val;
    }
    function get_case(){
      if(!isset($this->_case)) return array();
      return $this->_case;
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

  function getEachDocument(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `document`'));
  }

  function readDocument($id){
      // check existence of $id
      $obj = new Document($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delDocument($id){
    $tobeDeleted = new Document($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>