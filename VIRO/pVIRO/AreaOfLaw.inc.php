<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 430, file "VIROENG.adl"
    SERVICE AreaOfLaw : I[AreaOfLaw]
   = [ Cases : areaOfLaw~
        = [ nr : [LegalCase]
          , type of case : appeal;caseType\/appealToAdminCourt;caseType\/objection;caseType
          ]
     ]
   *********/
  
  class AreaOfLaw {
    protected $_id=false;
    protected $_new=true;
    private $_Cases;
    function AreaOfLaw($id=null, $Cases=null){
      $this->_id=$id;
      $this->_Cases=$Cases;
      if(!isset($Cases) && isset($id)){
        // get a AreaOfLaw based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttAreaOfLaw` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttAreaOfLaw`, `i`
                                  FROM `areaoflaw`
                              ) AS fst
                          WHERE fst.`AttAreaOfLaw` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['Cases']=(DB_doquer("SELECT DISTINCT `legalcase`.`i` AS `id`
                                     FROM `legalcase`
                                    WHERE `legalcase`.`areaoflaw`='".addslashes($id)."'"));
          foreach($me['Cases'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `nr`
                                      FROM `legalcase`
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
          $this->set_Cases($me['Cases']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttAreaOfLaw` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttAreaOfLaw`, `i`
                                  FROM `areaoflaw`
                              ) AS fst
                          WHERE fst.`AttAreaOfLaw` = \''.addSlashes($id).'\'');
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
          DB_doquer("UPDATE `legalcase` SET `i`='".addslashes($v0['id'])."' WHERE `i`='".addslashes($v0['nr'])."'", 5);
      }
      foreach  ($me['Cases'] as $Cases){
        if(isset($me['id']))
          DB_doquer("UPDATE `legalcase` SET `areaoflaw`='".addslashes($me['id'])."' WHERE `i`='".addslashes($Cases['id'])."'", 5);
      }
      // no code for nr,i in legalcase
      foreach($me['Cases'] as $i0=>$v0){
        foreach($v0['type of case'] as $i1=>$v1){
          DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Cases'] as $i0=>$v0){
        foreach($v0['type of case'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `casetype` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      // no code for Cases,legalcase in plaintiff
      // no code for nr,legalcase in plaintiff
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
      $me=array("id"=>$this->getId(), "Cases" => $this->_Cases);
      foreach($me['Cases'] as $i0=>$v0){
        foreach($v0['type of case'] as $i1=>$v1){
          DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v1)."'",5);
        }
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

  function getEachAreaOfLaw(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `areaoflaw`'));
  }

  function readAreaOfLaw($id){
      // check existence of $id
      $obj = new AreaOfLaw($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delAreaOfLaw($id){
    $tobeDeleted = new AreaOfLaw($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>