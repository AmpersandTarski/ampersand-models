<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 424, file "VIRO.adl"
    SERVICE Document : I[Document]
   = [ type : type
     , zaaksdossier : zaaksdossier
        = [ zorgdrager : zorgdrager
          , rechtsgebied : rechtsgebied
          , proceduresoort : proceduresoort
          ]
     ]
   *********/
  
  class Document {
    protected $_id=false;
    protected $_new=true;
    private $_type;
    private $_zaaksdossier;
    function Document($id=null, $type=null, $zaaksdossier=null){
      $this->_id=$id;
      $this->_type=$type;
      $this->_zaaksdossier=$zaaksdossier;
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
          $me=firstRow(DB_doquer("SELECT DISTINCT `aan`.`document` AS `id`
                                       , `document`.`type`
                                    FROM `aan`
                                    LEFT JOIN `document` ON `document`.`i`='".addslashes($id)."'
                                   WHERE `aan`.`document`='".addslashes($id)."'"));
          $me['zaaksdossier']=(DB_doquer("SELECT DISTINCT `zaaksdossier`.`procedur` AS `id`
                                            FROM `zaaksdossier`
                                           WHERE `zaaksdossier`.`document`='".addslashes($id)."'"));
          foreach($me['zaaksdossier'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`zorgdrager`
                                         , `f3`.`rechtsgebied`
                                         , `f4`.`proceduresoort`
                                      FROM `procedur`
                                      LEFT JOIN `procedur` AS f2 ON `f2`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `procedur` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `procedur` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                     WHERE `procedur`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_type($me['type']);
          $this->set_zaaksdossier($me['zaaksdossier']);
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
      $me=array("id"=>$this->getId(), "type" => $this->_type, "zaaksdossier" => $this->_zaaksdossier);
      if(isset($me['id']))
        DB_doquer("UPDATE `document` SET `type`='".addslashes($me['type'])."' WHERE `i`='".addslashes($me['id'])."'", 5);
      foreach($me['zaaksdossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `procedur` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['zaaksdossier'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `procedur` (`i`,`zorgdrager`,`rechtsgebied`,`proceduresoort`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['zorgdrager'])."', '".addslashes($v0['rechtsgebied'])."', '".addslashes($v0['proceduresoort'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($me['type'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `documenttype` (`i`) VALUES ('".addslashes($me['type'])."')", 5);
      foreach($me['zaaksdossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v0['zorgdrager'])."'",5);
      }
      foreach($me['zaaksdossier'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `orgaan` (`i`) VALUES ('".addslashes($v0['zorgdrager'])."')", 5);
      }
      foreach($me['zaaksdossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v0['rechtsgebied'])."'",5);
      }
      foreach($me['zaaksdossier'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `rechtsgebied` (`i`) VALUES ('".addslashes($v0['rechtsgebied'])."')", 5);
      }
      foreach($me['zaaksdossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v0['proceduresoort'])."'",5);
      }
      foreach($me['zaaksdossier'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `proceduresoort` (`i`) VALUES ('".addslashes($v0['proceduresoort'])."')", 5);
      }
      DB_doquer("DELETE FROM `zaaksdossier` WHERE `document`='".addslashes($me['id'])."'",5);
      foreach  ($me['zaaksdossier'] as $zaaksdossier){
        $res=DB_doquer("INSERT IGNORE INTO `zaaksdossier` (`procedur`,`document`) VALUES ('".addslashes($zaaksdossier['id'])."', '".addslashes($me['id'])."')", 5);
      }
      // no code for zaaksdossier,procedur in eiser
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
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
      if (!checkRule27()){
        $DB_err='\"\"';
      } else
      if (!checkRule74()){
        $DB_err='\"\"';
      } else
      if (!checkRule75()){
        $DB_err='\"\"';
      } else
      if (!checkRule77()){
        $DB_err='\"\"';
      } else
      if (!checkRule80()){
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
      $me=array("id"=>$this->getId(), "type" => $this->_type, "zaaksdossier" => $this->_zaaksdossier);
      foreach($me['zaaksdossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `procedur` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($me['type'])."'",5);
      foreach($me['zaaksdossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `orgaan` WHERE `i`='".addslashes($v0['zorgdrager'])."'",5);
      }
      foreach($me['zaaksdossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `rechtsgebied` WHERE `i`='".addslashes($v0['rechtsgebied'])."'",5);
      }
      foreach($me['zaaksdossier'] as $i0=>$v0){
        DB_doquer("DELETE FROM `proceduresoort` WHERE `i`='".addslashes($v0['proceduresoort'])."'",5);
      }
      DB_doquer("DELETE FROM `zaaksdossier` WHERE `document`='".addslashes($me['id'])."'",5);
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
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
      if (!checkRule27()){
        $DB_err='\"\"';
      } else
      if (!checkRule74()){
        $DB_err='\"\"';
      } else
      if (!checkRule75()){
        $DB_err='\"\"';
      } else
      if (!checkRule77()){
        $DB_err='\"\"';
      } else
      if (!checkRule80()){
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
    function set_zaaksdossier($val){
      $this->_zaaksdossier=$val;
    }
    function get_zaaksdossier(){
      if(!isset($this->_zaaksdossier)) return array();
      return $this->_zaaksdossier;
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