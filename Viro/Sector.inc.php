<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3810, file "VIRO.adl"
    SERVICE Sector : I[Sector]
   = [ sector Kamer : sector~
        = [ Kamer : [Kamer]
          , gerecht : gerecht
          ]
     ]
   *********/
  
  class Sector {
    protected $_id=false;
    protected $_new=true;
    private $_sectorKamer;
    function Sector($id=null, $sectorKamer=null){
      $this->_id=$id;
      $this->_sectorKamer=$sectorKamer;
      if(!isset($sectorKamer) && isset($id)){
        // get a Sector based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttSector` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttSector`, `i`
                                  FROM `sector`
                              ) AS fst
                          WHERE fst.`AttSector` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['sector Kamer']=(DB_doquer("SELECT DISTINCT `kamer`.`i` AS `id`
                                            FROM `kamer`
                                           WHERE `kamer`.`sector`='".addslashes($id)."'"));
          foreach($me['sector Kamer'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Kamer`
                                         , `f3`.`gerecht`
                                      FROM `kamer`
                                      LEFT JOIN `kamer` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                     WHERE `kamer`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_sectorKamer($me['sector Kamer']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttSector` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttSector`, `i`
                                  FROM `sector`
                              ) AS fst
                          WHERE fst.`AttSector` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "sector Kamer" => $this->_sectorKamer);
      // no code for gerecht,i in gerecht
      foreach($me['sector Kamer'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `kamer` SET `i`='".addslashes($v0['id'])."', `gerecht`='".addslashes($v0['gerecht'])."' WHERE `i`='".addslashes($v0['Kamer'])."'", 5);
      }
      foreach  ($me['sector Kamer'] as $sectorKamer){
        if(isset($me['id']))
          DB_doquer("UPDATE `kamer` SET `sector`='".addslashes($me['id'])."' WHERE `i`='".addslashes($sectorKamer['id'])."'", 5);
      }
      // no code for Kamer,i in kamer
      if (!checkRule38()){
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
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if (!checkRule49()){
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
      $me=array("id"=>$this->getId(), "sector Kamer" => $this->_sectorKamer);
      if (!checkRule38()){
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
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if (!checkRule49()){
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
    function set_sectorKamer($val){
      $this->_sectorKamer=$val;
    }
    function get_sectorKamer(){
      if(!isset($this->_sectorKamer)) return array();
      return $this->_sectorKamer;
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

  function getEachSector(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `sector`'));
  }

  function readSector($id){
      // check existence of $id
      $obj = new Sector($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delSector($id){
    $tobeDeleted = new Sector($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>