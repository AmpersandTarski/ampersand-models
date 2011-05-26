<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 174, file "VIROENG.adl"
    SERVICE Correspondence : I[Document]
   = [ case : caseFile
     , type : documentType
     , remark : remark
     , sent at : sent
     , received at : received
     ]
   *********/
  
  class Correspondence {
    protected $_id=false;
    protected $_new=true;
    private $_case;
    private $_type;
    private $_remark;
    private $_sentat;
    private $_receivedat;
    function Correspondence($id=null, $case=null, $type=null, $remark=null, $sentat=null, $receivedat=null){
      $this->_id=$id;
      $this->_case=$case;
      $this->_type=$type;
      $this->_remark=$remark;
      $this->_sentat=$sentat;
      $this->_receivedat=$receivedat;
      if(!isset($case) && isset($id)){
        // get a Correspondence based on its identifier
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
                                       , `document`.`sent` AS `sent at`
                                       , `document`.`received` AS `received at`
                                    FROM `document`
                                   WHERE `document`.`i`='".addslashes($id)."'"));
          $me['case']=firstCol(DB_doquer("SELECT DISTINCT `casefile`.`legalcase` AS `case`
                                            FROM `casefile`
                                           WHERE `casefile`.`document`='".addslashes($id)."'"));
          $me['remark']=firstCol(DB_doquer("SELECT DISTINCT `remark`.`text` AS `remark`
                                              FROM `remark`
                                             WHERE `remark`.`document`='".addslashes($id)."'"));
          $this->set_case($me['case']);
          $this->set_type($me['type']);
          $this->set_remark($me['remark']);
          $this->set_sentat($me['sent at']);
          $this->set_receivedat($me['received at']);
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
      $me=array("id"=>$this->getId(), "case" => $this->_case, "type" => $this->_type, "remark" => $this->_remark, "sent at" => $this->_sentat, "received at" => $this->_receivedat);
      DB_doquer("DELETE FROM `document` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `document` (`documenttype`,`sent`,`received`,`i`) VALUES ('".addslashes($me['type'])."', ".((null!=$me['sent at'])?"'".addslashes($me['sent at'])."'":"NULL").", ".((null!=$me['received at'])?"'".addslashes($me['received at'])."'":"NULL").", '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for case,i in legalcase
      DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($me['type'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `documenttype` (`i`) VALUES ('".addslashes($me['type'])."')", 5);
      DB_doquer("DELETE FROM `timestamp` WHERE `i`='".addslashes($me['sent at'])."'",5);
      DB_doquer("DELETE FROM `timestamp` WHERE `i`='".addslashes($me['received at'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `timestamp` (`i`) VALUES ('".addslashes($me['sent at'])."')", 5);
      $res=DB_doquer("INSERT IGNORE INTO `timestamp` (`i`) VALUES ('".addslashes($me['received at'])."')", 5);
      foreach($me['remark'] as $i0=>$v0){
        DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['remark'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `text` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      // no code for case,legalcase in plaintiff
      DB_doquer("DELETE FROM `casefile` WHERE `document`='".addslashes($me['id'])."'",5);
      foreach  ($me['case'] as $case){
        $res=DB_doquer("INSERT IGNORE INTO `casefile` (`legalcase`,`document`) VALUES ('".addslashes($case)."', '".addslashes($me['id'])."')", 5);
      }
      DB_doquer("DELETE FROM `remark` WHERE `document`='".addslashes($me['id'])."'",5);
      foreach  ($me['remark'] as $remark){
        $res=DB_doquer("INSERT IGNORE INTO `remark` (`text`,`document`) VALUES ('".addslashes($remark)."', '".addslashes($me['id'])."')", 5);
      }
      if (!checkRule3()){
        $DB_err='\"Written authorizations for representatives of a case are not put in the case file\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Every administrative case is either an appeal or an objection or an appeal to an administrative court. (Art.6:4 Awb)\"';
      } else
      if (!checkRule13()){
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
      if (!checkRule19()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule36()){
        $DB_err='\"\"';
      } else
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule64()){
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
      $me=array("id"=>$this->getId(), "case" => $this->_case, "type" => $this->_type, "remark" => $this->_remark, "sent at" => $this->_sentat, "received at" => $this->_receivedat);
      DB_doquer("DELETE FROM `document` WHERE `i`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($me['type'])."'",5);
      DB_doquer("DELETE FROM `timestamp` WHERE `i`='".addslashes($me['sent at'])."'",5);
      DB_doquer("DELETE FROM `timestamp` WHERE `i`='".addslashes($me['received at'])."'",5);
      foreach($me['remark'] as $i0=>$v0){
        DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `casefile` WHERE `document`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `remark` WHERE `document`='".addslashes($me['id'])."'",5);
      if (!checkRule3()){
        $DB_err='\"Written authorizations for representatives of a case are not put in the case file\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Every administrative case is either an appeal or an objection or an appeal to an administrative court. (Art.6:4 Awb)\"';
      } else
      if (!checkRule13()){
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
      if (!checkRule19()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule36()){
        $DB_err='\"\"';
      } else
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule64()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_case($val){
      $this->_case=$val;
    }
    function get_case(){
      if(!isset($this->_case)) return array();
      return $this->_case;
    }
    function set_type($val){
      $this->_type=$val;
    }
    function get_type(){
      return $this->_type;
    }
    function set_remark($val){
      $this->_remark=$val;
    }
    function get_remark(){
      if(!isset($this->_remark)) return array();
      return $this->_remark;
    }
    function set_sentat($val){
      $this->_sentat=$val;
    }
    function get_sentat(){
      return $this->_sentat;
    }
    function set_receivedat($val){
      $this->_receivedat=$val;
    }
    function get_receivedat(){
      return $this->_receivedat;
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

  function getEachCorrespondence(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `document`'));
  }

  function readCorrespondence($id){
      // check existence of $id
      $obj = new Correspondence($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delCorrespondence($id){
    $tobeDeleted = new Correspondence($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>