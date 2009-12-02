<?php // generated with ADL vs. 0.8.10-408
  
  /********* on line 73, file "Meterkast.adl"
    SERVICE Actie : I[Actie]
   = [ file : object
     , operatie : type
     ]
   *********/
  
  class Actie {
    protected $_id=false;
    protected $_new=true;
    private $_file;
    private $_operatie;
    function Actie($id=null, $file=null, $operatie=null){
      $this->_id=$id;
      $this->_file=$file;
      $this->_operatie=$operatie;
      if(!isset($file) && isset($id)){
        // get a Actie based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttActie` AS `Id`
                           FROM 
                              ( SELECT DISTINCT Id AS `AttActie`, Id
                                  FROM ActieTbl
                              ) AS fst
                          WHERE fst.`AttActie` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `ActieTbl`.`object` AS `file`
                                       , `ActieTbl`.`type` AS `operatie`
                                       , '".addslashes($id)."' AS `id`
                                    FROM `ActieTbl`
                                   WHERE `ActieTbl`.`Id`='".addslashes($id)."'"));
          $this->set_file($me['file']);
          $this->set_operatie($me['operatie']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttActie` AS `Id`
                           FROM 
                              ( SELECT DISTINCT Id AS `AttActie`, Id
                                  FROM ActieTbl
                              ) AS fst
                          WHERE fst.`AttActie` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "file" => $this->_file, "operatie" => $this->_operatie);
      // no code for operatie,Id in OperationTbl
      DB_doquer("DELETE FROM `ActieTbl` WHERE `Id`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `ActieTbl` (`object`,`type`,`Id`) VALUES ('".addslashes($me['file'])."', '".addslashes($me['operatie'])."', ".(!$newID?"'".addslashes($me['id'])."'":"NULL").")", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for file,Id in BestandTbl
      // no code for file,bestand in SessieTbl
      if (!checkRule2()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule3()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule5()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule8()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule9()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule10()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule11()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule12()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule14()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule16()){
        $DB_err=$preErr.'\"\"';
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
      $me=array("id"=>$this->getId(), "file" => $this->_file, "operatie" => $this->_operatie);
      DB_doquer("DELETE FROM `ActieTbl` WHERE `Id`='".addslashes($me['id'])."'",5);
      if (!checkRule2()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule3()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule5()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule8()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule9()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule10()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule11()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule12()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule14()){
        $DB_err=$preErr.'\"\"';
      } else
      if (!checkRule16()){
        $DB_err=$preErr.'\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_file($val){
      $this->_file=$val;
    }
    function get_file(){
      return $this->_file;
    }
    function set_operatie($val){
      $this->_operatie=$val;
    }
    function get_operatie(){
      return $this->_operatie;
    }
    function setId($id){
      $this->_id=$id;
      return $this->_id;
    }
    function getId(){
      if($this->_id==null) return false;
      return $this->_id;
    }
    function isNew(){
      return $this->_new;
    }
  }

  function getEachActie(){
    return firstCol(DB_doquer('SELECT DISTINCT Id
                                 FROM ActieTbl'));
  }

  function readActie($id){
      // check existence of $id
      $obj = new Actie($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delActie($id){
    $tobeDeleted = new Actie($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>