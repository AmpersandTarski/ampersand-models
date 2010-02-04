<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3961, file "VIRO.adl"
    SERVICE Machtiging : I[Machtiging]
   = [ machtiging : [Machtiging]
     , inzake : inzake
     , door : door
     , gemachtigde : gemachtigde~
     , schriftelijke machtiging : machtiging~
        = [ Document : [Document]
          , type : type
          ]
     ]
   *********/
  
  class Machtiging {
    protected $_id=false;
    protected $_new=true;
    private $_machtiging;
    private $_inzake;
    private $_door;
    private $_gemachtigde;
    private $_schriftelijkemachtiging;
    function Machtiging($id=null, $machtiging=null, $inzake=null, $door=null, $gemachtigde=null, $schriftelijkemachtiging=null){
      $this->_id=$id;
      $this->_machtiging=$machtiging;
      $this->_inzake=$inzake;
      $this->_door=$door;
      $this->_gemachtigde=$gemachtigde;
      $this->_schriftelijkemachtiging=$schriftelijkemachtiging;
      if(!isset($machtiging) && isset($id)){
        // get a Machtiging based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttMachtiging` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttMachtiging`, `i`
                                  FROM `machtiging`
                              ) AS fst
                          WHERE fst.`AttMachtiging` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `gemachtigde`.`machtiging` AS `id`
                                       , `gemachtigde`.`machtiging`
                                       , `machtiging`.`i` AS `machtiging`
                                       , `machtiging`.`door`
                                    FROM `gemachtigde`
                                    LEFT JOIN `machtiging` ON `machtiging`.`i`='".addslashes($id)."'
                                   WHERE `gemachtigde`.`machtiging`='".addslashes($id)."'"));
          $me['inzake']=firstCol(DB_doquer("SELECT DISTINCT `inzake`.`procedur` AS `inzake`
                                              FROM `inzake`
                                             WHERE `inzake`.`machtiging`='".addslashes($id)."'"));
          $me['gemachtigde']=firstCol(DB_doquer("SELECT DISTINCT `gemachtigde`.`persoon` AS `gemachtigde`
                                                   FROM `gemachtigde`
                                                  WHERE `gemachtigde`.`machtiging`='".addslashes($id)."'"));
          $me['schriftelijke machtiging']=(DB_doquer("SELECT DISTINCT `f1`.`document` AS `id`
                                                        FROM `machtiging`
                                                        JOIN `machtigingdocument` AS f1 ON `f1`.`Machtiging`='".addslashes($id)."'
                                                       WHERE `machtiging`.`i`='".addslashes($id)."'"));
          foreach($me['schriftelijke machtiging'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Document`
                                         , `f3`.`type`
                                      FROM `document`
                                      LEFT JOIN `document` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                     WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_machtiging($me['machtiging']);
          $this->set_inzake($me['inzake']);
          $this->set_door($me['door']);
          $this->set_gemachtigde($me['gemachtigde']);
          $this->set_schriftelijkemachtiging($me['schriftelijke machtiging']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttMachtiging` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttMachtiging`, `i`
                                  FROM `machtiging`
                              ) AS fst
                          WHERE fst.`AttMachtiging` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "machtiging" => $this->_machtiging, "inzake" => $this->_inzake, "door" => $this->_door, "gemachtigde" => $this->_gemachtigde, "schriftelijke machtiging" => $this->_schriftelijkemachtiging);
      foreach($me['schriftelijke machtiging'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `document` SET `i`='".addslashes($v0['id'])."', `type`='".addslashes($v0['type'])."' WHERE `i`='".addslashes($v0['Document'])."'", 5);
      }
      // no code for Document,i in document
      // no code for inzake,i in procedur
      DB_doquer("DELETE FROM `machtiging` WHERE `i`='".addslashes($me['id'])."'",5);
      // no code for machtiging,i in machtiging
      $res=DB_doquer("INSERT IGNORE INTO `machtiging` (`i`,`door`) VALUES ('".addslashes($me['machtiging'])."', '".addslashes($me['door'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      foreach($me['schriftelijke machtiging'] as $i0=>$v0){
        DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      foreach($me['schriftelijke machtiging'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `documenttype` (`i`) VALUES ('".addslashes($v0['type'])."')", 5);
      }
      DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($me['door'])."'",5);
      foreach($me['gemachtigde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($me['door'])."')", 5);
      foreach($me['gemachtigde'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      // no code for inzake,procedur in eiser
      DB_doquer("DELETE FROM `gemachtigde` WHERE `machtiging`='".addslashes($me['id'])."'",5);
      // no code for machtiging,machtiging in gemachtigde
      foreach  ($me['gemachtigde'] as $gemachtigde){
        $res=DB_doquer("INSERT IGNORE INTO `gemachtigde` (`machtiging`,`persoon`) VALUES ('".addslashes($me['machtiging'])."', '".addslashes($gemachtigde)."')", 5);
      }
      DB_doquer("DELETE FROM `inzake` WHERE `machtiging`='".addslashes($me['id'])."'",5);
      foreach  ($me['inzake'] as $inzake){
        $res=DB_doquer("INSERT IGNORE INTO `inzake` (`procedur`,`machtiging`) VALUES ('".addslashes($inzake)."', '".addslashes($me['id'])."')", 5);
      }
      // no code for schriftelijke machtiging,document in aan
      // no code for Document,document in aan
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
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
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if (!checkRule32()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule64()){
        $DB_err='\"\"';
      } else
      if (!checkRule67()){
        $DB_err='\"\"';
      } else
      if (!checkRule74()){
        $DB_err='\"\"';
      } else
      if (!checkRule75()){
        $DB_err='\"\"';
      } else
      if (!checkRule76()){
        $DB_err='\"\"';
      } else
      if (!checkRule78()){
        $DB_err='\"\"';
      } else
      if (!checkRule81()){
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
      $me=array("id"=>$this->getId(), "machtiging" => $this->_machtiging, "inzake" => $this->_inzake, "door" => $this->_door, "gemachtigde" => $this->_gemachtigde, "schriftelijke machtiging" => $this->_schriftelijkemachtiging);
      DB_doquer("DELETE FROM `machtiging` WHERE `i`='".addslashes($me['id'])."'",5);
      foreach($me['schriftelijke machtiging'] as $i0=>$v0){
        DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($me['door'])."'",5);
      foreach($me['gemachtigde'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `gemachtigde` WHERE `machtiging`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `inzake` WHERE `machtiging`='".addslashes($me['id'])."'",5);
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
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
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if (!checkRule32()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule64()){
        $DB_err='\"\"';
      } else
      if (!checkRule67()){
        $DB_err='\"\"';
      } else
      if (!checkRule74()){
        $DB_err='\"\"';
      } else
      if (!checkRule75()){
        $DB_err='\"\"';
      } else
      if (!checkRule76()){
        $DB_err='\"\"';
      } else
      if (!checkRule78()){
        $DB_err='\"\"';
      } else
      if (!checkRule81()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_machtiging($val){
      $this->_machtiging=$val;
    }
    function get_machtiging(){
      return $this->_machtiging;
    }
    function set_inzake($val){
      $this->_inzake=$val;
    }
    function get_inzake(){
      if(!isset($this->_inzake)) return array();
      return $this->_inzake;
    }
    function set_door($val){
      $this->_door=$val;
    }
    function get_door(){
      return $this->_door;
    }
    function set_gemachtigde($val){
      $this->_gemachtigde=$val;
    }
    function get_gemachtigde(){
      if(!isset($this->_gemachtigde)) return array();
      return $this->_gemachtigde;
    }
    function set_schriftelijkemachtiging($val){
      $this->_schriftelijkemachtiging=$val;
    }
    function get_schriftelijkemachtiging(){
      if(!isset($this->_schriftelijkemachtiging)) return array();
      return $this->_schriftelijkemachtiging;
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

  function getEachMachtiging(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `machtiging`'));
  }

  function readMachtiging($id){
      // check existence of $id
      $obj = new Machtiging($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delMachtiging($id){
    $tobeDeleted = new Machtiging($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>