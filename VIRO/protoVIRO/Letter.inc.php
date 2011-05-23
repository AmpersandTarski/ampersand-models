<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 306, file "VIRO453ENG.adl"
    SERVICE Letter : I[Document]
   = [ case : caseFile
     , type : documentType
     , from : from
     , to : to
     , mark : propertyOf
     , sent at : sent
     , received at : received
     ]
   *********/
  
  class Letter {
    protected $_id=false;
    protected $_new=true;
    private $_case;
    private $_type;
    private $_from;
    private $_to;
    private $_mark;
    private $_sentat;
    private $_receivedat;
    function Letter($id=null, $case=null, $type=null, $from=null, $to=null, $mark=null, $sentat=null, $receivedat=null){
      $this->_id=$id;
      $this->_case=$case;
      $this->_type=$type;
      $this->_from=$from;
      $this->_to=$to;
      $this->_mark=$mark;
      $this->_sentat=$sentat;
      $this->_receivedat=$receivedat;
      if(!isset($case) && isset($id)){
        // get a Letter based on its identifier
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
          $me=firstRow(DB_doquer("SELECT DISTINCT `to`.`document` AS `id`
                                       , `document`.`documenttype` AS `type`
                                       , `document`.`from`
                                       , `document`.`propertyof` AS `mark`
                                       , `document`.`sent` AS `sent at`
                                       , `document`.`received` AS `received at`
                                    FROM `to`
                                    LEFT JOIN `document` ON `document`.`i`='".addslashes($id)."'
                                   WHERE `to`.`document`='".addslashes($id)."'"));
          $me['case']=firstCol(DB_doquer("SELECT DISTINCT `casefile`.`case`
                                            FROM `casefile`
                                           WHERE `casefile`.`document`='".addslashes($id)."'"));
          $me['to']=firstCol(DB_doquer("SELECT DISTINCT `to`.`party` AS `to`
                                          FROM `to`
                                         WHERE `to`.`document`='".addslashes($id)."'"));
          $this->set_case($me['case']);
          $this->set_type($me['type']);
          $this->set_from($me['from']);
          $this->set_to($me['to']);
          $this->set_mark($me['mark']);
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
      $me=array("id"=>$this->getId(), "case" => $this->_case, "type" => $this->_type, "from" => $this->_from, "to" => $this->_to, "mark" => $this->_mark, "sent at" => $this->_sentat, "received at" => $this->_receivedat);
      DB_doquer("DELETE FROM `document` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `document` (`documenttype`,`from`,`propertyof`,`sent`,`received`,`i`) VALUES ('".addslashes($me['type'])."', '".addslashes($me['from'])."', '".addslashes($me['mark'])."', '".addslashes($me['sent at'])."', ".((null!=$me['received at'])?"'".addslashes($me['received at'])."'":"NULL").", '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for case,i in case
      DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($me['type'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `documenttype` (`i`) VALUES ('".addslashes($me['type'])."')", 5);
      DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($me['from'])."'",5);
      foreach($me['to'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($me['from'])."')", 5);
      foreach($me['to'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($me['mark'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `text` (`i`) VALUES ('".addslashes($me['mark'])."')", 5);
      DB_doquer("DELETE FROM `timestamp` WHERE `i`='".addslashes($me['sent at'])."'",5);
      DB_doquer("DELETE FROM `timestamp` WHERE `i`='".addslashes($me['received at'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `timestamp` (`i`) VALUES ('".addslashes($me['sent at'])."')", 5);
      $res=DB_doquer("INSERT IGNORE INTO `timestamp` (`i`) VALUES ('".addslashes($me['received at'])."')", 5);
      DB_doquer("DELETE FROM `casefile` WHERE `document`='".addslashes($me['id'])."'",5);
      foreach  ($me['case'] as $case){
        $res=DB_doquer("INSERT IGNORE INTO `casefile` (`case`,`document`) VALUES ('".addslashes($case)."', '".addslashes($me['id'])."')", 5);
      }
      // no code for case,case in plaintiff
      DB_doquer("DELETE FROM `to` WHERE `document`='".addslashes($me['id'])."'",5);
      foreach  ($me['to'] as $to){
        $res=DB_doquer("INSERT IGNORE INTO `to` (`party`,`document`) VALUES ('".addslashes($to)."', '".addslashes($me['id'])."')", 5);
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
      if (!checkRule11()){
        $DB_err='\"\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
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
      $me=array("id"=>$this->getId(), "case" => $this->_case, "type" => $this->_type, "from" => $this->_from, "to" => $this->_to, "mark" => $this->_mark, "sent at" => $this->_sentat, "received at" => $this->_receivedat);
      DB_doquer("DELETE FROM `document` WHERE `i`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($me['type'])."'",5);
      DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($me['from'])."'",5);
      foreach($me['to'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `text` WHERE `i`='".addslashes($me['mark'])."'",5);
      DB_doquer("DELETE FROM `timestamp` WHERE `i`='".addslashes($me['sent at'])."'",5);
      DB_doquer("DELETE FROM `timestamp` WHERE `i`='".addslashes($me['received at'])."'",5);
      DB_doquer("DELETE FROM `casefile` WHERE `document`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `to` WHERE `document`='".addslashes($me['id'])."'",5);
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule8()){
        $DB_err='\"\"';
      } else
      if (!checkRule9()){
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
      if (!checkRule17()){
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
    function set_from($val){
      $this->_from=$val;
    }
    function get_from(){
      return $this->_from;
    }
    function set_to($val){
      $this->_to=$val;
    }
    function get_to(){
      if(!isset($this->_to)) return array();
      return $this->_to;
    }
    function set_mark($val){
      $this->_mark=$val;
    }
    function get_mark(){
      return $this->_mark;
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

  function getEachLetter(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `document`'));
  }

  function readLetter($id){
      // check existence of $id
      $obj = new Letter($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delLetter($id){
    $tobeDeleted = new Letter($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>