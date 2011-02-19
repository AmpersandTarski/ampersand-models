<?php // generated with Prototype vs. 1.1.0.874(core vs. 2.0.0.13)
  
  /********* on Nowhere
    SERVICE Person : I[Person*Person]
   = [ assetManager~ : assetManager~
     ]
   *********/
  
  class Person {
    protected $id=false;
    protected $_new=true;
    private $_assetManager;
    function Person($id=null,$_assetManager=null){
      $this->id=$id;
      $this->_assetManager=$_assetManager;
      if(!isset($_assetManager) && isset($id)){
        // get a Person based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpPerson` AS `Person`
                           FROM ( SELECT DISTINCT `Person` AS `MpPerson`, `Person`
                             FROM `Person` ) AS fst
                          WHERE fst.`MpPerson` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['assetManager~']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Asset` AS `assetManager~`
                                                     FROM `Person`
                                                     JOIN `Asset` AS f1 ON `f1`.`assetManager`='".addslashes($id)."'
                                                    WHERE `Person`.`Person`='".addslashes($id)."'"));
          $this->set_assetManager($me['assetManager~']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpPerson` AS `Person`
                           FROM ( SELECT DISTINCT `Person` AS `MpPerson`, `Person`
                             FROM `Person` ) AS fst
                          WHERE fst.`MpPerson` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
       global $myerrors;
       starttransaction(); //transaction runs untill closed by somebody
       
       //me is a record with a kernelfield for this->id 
       //this class/service can only create me records (and the identity of concepts in them => kernelfields)
       //this->id is an instance of some concept
       //$this contains possibly new values from the screen
       //one value has one certain relation r with this->id
       //at this moment, we assume that r is not an expression, but declared
       //r may be stored in me or in some other plug
       //not all relations in me have to be in this
       //me must be completed with oldme values if this->id is not new.
       //if me is new, then all required fields for this->id in me must be present to be able to insert this->id
       //the me part of this cannot be inserted the binary way, because it is not stored in a binplug
       //the other relations in this will be inserted the binary way
       //this implies updates of morattfields in other tblplugs than me and del/ins in binplugs where src or trg = this->id
       //updates of morattfields will not check whether it was already set in the old situation i.e. overwrite.
       $oldme = array('Person'=>null);
       $me = array('Person'=>$this->getId());
       $newme = array('Person'=>null);
       if (!$this->isNew()) {
          $oldme = firstRow(DB_doquer("SELECT * FROM `Person` WHERE `Person`='".addslashes($this->getId())."'"));
          DB_doquer("DELETE FROM `Person` WHERE `Person`='".addslashes($this->getId())."'",5);
          $shouldcut = false;
          $cancut = true;
          $cutoldme = false;
          if ($shouldcut){
             if ($cancut){
                $cutoldme = array("Person"=>$oldme["Person"]);
                foreach ($oldme as $fld => $oldval){
                   if (isset($me[$fld]))
                      $newme[$fld] = $me[$fld]; //the value on the screen is at least in newme
                   elseif (!isset($cutoldme[$fld]))
                      $newme[$fld] = $oldval; //cut old values not in cutoldme
                }
             } else { //should cut but can't because kernelfields will not unique or not all requiredfields for this->id are in this
                rollbacktransaction();
                $myerrors[] = print_r(array('xxx'=>'xxx'));
                return false;
             }
          } else { //no cutting just copy me to newme completed with old values (requires allrequiredinthis)
             foreach ($oldme as $fld => $oldval){
                if (isset($me[$fld]))
                   $newme[$fld] = $me[$fld]; //the value on the screen is at least in newme
                else
                   $newme[$fld] = $oldval;
             }
          }
          if ($cutoldme){ //try INS cutoldme (failure would be strange)
             DB_doquer("INSERT INTO `Person` (`Person`) VALUES (".((null!=$cutoldme['Person'])?"'".addslashes($cutoldme['Person'])."'":"NULL").")", 5);
             if(mysql_errno()!=0) {
                $err = mysql_error();
                rollbacktransaction();
                $myerrors[] = print_r(array('yyy'=>'yyy','error'=>$err));
                return false;
             }
          }
       } else {
          foreach ($newme as $fld => $nullval){
             if (isset($me[$fld]))
                $newme[$fld] = $me[$fld]; //the value on the screen is at least in newme
          }
       }
       $selkey = DB_doquer("SELECT * FROM `Person` WHERE `Person`='".addslashes($newme['Person'])."'");
       if (count($selkey)>0){
          $oldkey = firstRow($selkey);
          if (($oldkey["Person"]==$newme["Person"] || !isset($oldkey["Person"]) || !isset($newme["Person"]))){
             DB_doquer("DELETE FROM `Person` WHERE `Person`='".addslashes($newme['Person'])."'",5);
             foreach ($newme as $fld => $newval){
                if (isset($me[$fld]))
                   $newme[$fld] = $newval; //the value on the screen is at least in newme
                else
                   $newme[$fld] = $oldkey[$fld];
             }
          } else {
             rollbacktransaction();
             if ($oldkey["Person"]!=$newme["Person"] && isset($oldkey["Person"]) && isset($newme["Person"])) $myerrors[] = print_r(array('error'=>"Person ".$newme['Person']." already identifies Person ".$oldkey['Person']." overwriting it with ".$newme['Person']." would delete ".$oldkey['Person'].". Please assign it to a different Person or delete it first."));
             return false;
          }
       }
       DB_doquer("INSERT INTO `Person` (`Person`) VALUES (".((null!=$newme['Person'])?"'".addslashes($newme['Person'])."'":"NULL").")", 5);
       if(mysql_errno()!=0) {
          $err = mysql_error();
          rollbacktransaction();
          $myerrors[] = print_r(array('observation'=>'sql error while saving instance.'.$this->getId(),'erroranalysis'=>'you may have missing required fields','sqlerror'=>$err)).print_r($newme);
          return false;
       }
       
       //myatts
       //first delete myatt relations (SET to NULL)
       DB_doquer("UPDATE `Asset` SET `assetManager`=NULL WHERE `assetManager`='".addslashes($this->getId())."' ");
       //then insert myatt relations as defined in this (key=$val is assumed to exist)
       foreach ($this->_assetManager as $k => $val){
          DB_doquer("UPDATE `Asset` SET `assetManager`='".addslashes($this->getId())."' WHERE `Asset`='".addslashes($val)."' ");
       }
       
       if (closetransaction()) {return $this->getId();} else {$myerrors[] = print_r(array('close'=>'close')); return false;}
    }
    function set_assetManager($val){
      $this->_assetManager=$val;
    }
    function get_assetManager(){
      if(!isset($this->_assetManager)) return array();
      return $this->_assetManager;
    }
    function setId($id){
      $this->id=$id;
      return $this->id;
    }
    function getId(){
      if($this->id===null) return false;
      return $this->id;
    }
    function isNew(){
      return $this->_new;
    }
  }

  function getEachPerson(){
    return firstCol(DB_doquer('SELECT DISTINCT `Person`
                                 FROM `Person`'));
  }

  function readPerson($id){
      // check existence of $id
      $obj = new Person($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delPerson($id){
    $tobeDeleted = new Person($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>