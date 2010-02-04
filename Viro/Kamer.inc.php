<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3755, file "VIRO.adl"
    SERVICE Kamer : I[Kamer]
   = [ gerecht : gerecht
     , sector : sector
     , bezetting : bezetting~
     , zittingen : kamer~
     ]
   *********/
  
  class Kamer {
    protected $_id=false;
    protected $_new=true;
    private $_gerecht;
    private $_sector;
    private $_bezetting;
    private $_zittingen;
    function Kamer($id=null, $gerecht=null, $sector=null, $bezetting=null, $zittingen=null){
      $this->_id=$id;
      $this->_gerecht=$gerecht;
      $this->_sector=$sector;
      $this->_bezetting=$bezetting;
      $this->_zittingen=$zittingen;
      if(!isset($gerecht) && isset($id)){
        // get a Kamer based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttKamer` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttKamer`, `i`
                                  FROM `kamer`
                              ) AS fst
                          WHERE fst.`AttKamer` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `kamer`.`i` AS `id`
                                       , `kamer`.`gerecht`
                                       , `kamer`.`sector`
                                    FROM `kamer`
                                   WHERE `kamer`.`i`='".addslashes($id)."'"));
          $me['bezetting']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`persoon` AS `bezetting`
                                                 FROM `kamer`
                                                 JOIN `bezetting` AS f1 ON `f1`.`Kamer`='".addslashes($id)."'
                                                WHERE `kamer`.`i`='".addslashes($id)."'"));
          $me['zittingen']=firstCol(DB_doquer("SELECT DISTINCT `zitting`.`i` AS `zittingen`
                                                 FROM `zitting`
                                                WHERE `zitting`.`kamer`='".addslashes($id)."'"));
          $this->set_gerecht($me['gerecht']);
          $this->set_sector($me['sector']);
          $this->set_bezetting($me['bezetting']);
          $this->set_zittingen($me['zittingen']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttKamer` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttKamer`, `i`
                                  FROM `kamer`
                              ) AS fst
                          WHERE fst.`AttKamer` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "gerecht" => $this->_gerecht, "sector" => $this->_sector, "bezetting" => $this->_bezetting, "zittingen" => $this->_zittingen);
      // no code for zittingen,i in zitting
      foreach  ($me['zittingen'] as $zittingen){
        if(isset($me['id']))
          DB_doquer("UPDATE `zitting` SET `kamer`='".addslashes($me['id'])."' WHERE `i`='".addslashes($zittingen)."'", 5);
      }
      // no code for gerecht,i in gerecht
      DB_doquer("DELETE FROM `kamer` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `kamer` (`gerecht`,`sector`,`i`) VALUES ('".addslashes($me['gerecht'])."', '".addslashes($me['sector'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      foreach($me['bezetting'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['bezetting'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      DB_doquer("DELETE FROM `sector` WHERE `i`='".addslashes($me['sector'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `sector` (`i`) VALUES ('".addslashes($me['sector'])."')", 5);
      // no code for zittingen,zitting in rechter
      if (!checkRule6()){
        $DB_err='\"De rechter ter zitting maakt deel uit van de bezetting van de kamer die de zitting houdt\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
        $DB_err='\"\"';
      } else
      if (!checkRule30()){
        $DB_err='\"\"';
      } else
      if (!checkRule31()){
        $DB_err='\"\"';
      } else
      if (!checkRule33()){
        $DB_err='\"\"';
      } else
      if (!checkRule36()){
        $DB_err='\"\"';
      } else
      if (!checkRule37()){
        $DB_err='\"\"';
      } else
      if (!checkRule38()){
        $DB_err='\"\"';
      } else
      if (!checkRule39()){
        $DB_err='\"\"';
      } else
      if (!checkRule40()){
        $DB_err='\"\"';
      } else
      if (!checkRule41()){
        $DB_err='\"\"';
      } else
      if (!checkRule42()){
        $DB_err='\"\"';
      } else
      if (!checkRule43()){
        $DB_err='\"\"';
      } else
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule46()){
        $DB_err='\"\"';
      } else
      if (!checkRule48()){
        $DB_err='\"\"';
      } else
      if (!checkRule49()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule69()){
        $DB_err='\"\"';
      } else
      if (!checkRule73()){
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
      $me=array("id"=>$this->getId(), "gerecht" => $this->_gerecht, "sector" => $this->_sector, "bezetting" => $this->_bezetting, "zittingen" => $this->_zittingen);
      DB_doquer("DELETE FROM `kamer` WHERE `i`='".addslashes($me['id'])."'",5);
      foreach($me['bezetting'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `sector` WHERE `i`='".addslashes($me['sector'])."'",5);
      if (!checkRule6()){
        $DB_err='\"De rechter ter zitting maakt deel uit van de bezetting van de kamer die de zitting houdt\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
        $DB_err='\"\"';
      } else
      if (!checkRule30()){
        $DB_err='\"\"';
      } else
      if (!checkRule31()){
        $DB_err='\"\"';
      } else
      if (!checkRule33()){
        $DB_err='\"\"';
      } else
      if (!checkRule36()){
        $DB_err='\"\"';
      } else
      if (!checkRule37()){
        $DB_err='\"\"';
      } else
      if (!checkRule38()){
        $DB_err='\"\"';
      } else
      if (!checkRule39()){
        $DB_err='\"\"';
      } else
      if (!checkRule40()){
        $DB_err='\"\"';
      } else
      if (!checkRule41()){
        $DB_err='\"\"';
      } else
      if (!checkRule42()){
        $DB_err='\"\"';
      } else
      if (!checkRule43()){
        $DB_err='\"\"';
      } else
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule46()){
        $DB_err='\"\"';
      } else
      if (!checkRule48()){
        $DB_err='\"\"';
      } else
      if (!checkRule49()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule69()){
        $DB_err='\"\"';
      } else
      if (!checkRule73()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_gerecht($val){
      $this->_gerecht=$val;
    }
    function get_gerecht(){
      return $this->_gerecht;
    }
    function set_sector($val){
      $this->_sector=$val;
    }
    function get_sector(){
      return $this->_sector;
    }
    function set_bezetting($val){
      $this->_bezetting=$val;
    }
    function get_bezetting(){
      if(!isset($this->_bezetting)) return array();
      return $this->_bezetting;
    }
    function set_zittingen($val){
      $this->_zittingen=$val;
    }
    function get_zittingen(){
      if(!isset($this->_zittingen)) return array();
      return $this->_zittingen;
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

  function getEachKamer(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `kamer`'));
  }

  function readKamer($id){
      // check existence of $id
      $obj = new Kamer($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delKamer($id){
    $tobeDeleted = new Kamer($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>