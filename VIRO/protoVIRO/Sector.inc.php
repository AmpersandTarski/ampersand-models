<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 799, file "VIRO453ENG.adl"
    SERVICE Sector : I[Sector]
   = [ sector Panel : sector~
        = [ Panel : [Panel]
          , court : court
          ]
     ]
   *********/
  
  class Sector {
    protected $_id=false;
    protected $_new=true;
    private $_sectorPanel;
    function Sector($id=null, $sectorPanel=null){
      $this->_id=$id;
      $this->_sectorPanel=$sectorPanel;
      if(!isset($sectorPanel) && isset($id)){
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
          $me['sector Panel']=(DB_doquer("SELECT DISTINCT `panel`.`i` AS `id`
                                            FROM `panel`
                                           WHERE `panel`.`sector`='".addslashes($id)."'"));
          foreach($me['sector Panel'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `Panel`
                                         , `f3`.`court`
                                      FROM `panel`
                                      LEFT JOIN `panel` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                     WHERE `panel`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_sectorPanel($me['sector Panel']);
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
      $me=array("id"=>$this->getId(), "sector Panel" => $this->_sectorPanel);
      // no code for court,i in court
      foreach($me['sector Panel'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `panel` SET `i`='".addslashes($v0['id'])."', `court`='".addslashes($v0['court'])."' WHERE `i`='".addslashes($v0['Panel'])."'", 5);
      }
      foreach  ($me['sector Panel'] as $sectorPanel){
        if(isset($me['id']))
          DB_doquer("UPDATE `panel` SET `sector`='".addslashes($me['id'])."' WHERE `i`='".addslashes($sectorPanel['id'])."'", 5);
      }
      // no code for Panel,i in panel
      if (!checkRule35()){
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
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule46()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
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
      $me=array("id"=>$this->getId(), "sector Panel" => $this->_sectorPanel);
      if (!checkRule35()){
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
      if (!checkRule44()){
        $DB_err='\"\"';
      } else
      if (!checkRule46()){
        $DB_err='\"\"';
      } else
      if (!checkRule47()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_sectorPanel($val){
      $this->_sectorPanel=$val;
    }
    function get_sectorPanel(){
      if(!isset($this->_sectorPanel)) return array();
      return $this->_sectorPanel;
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