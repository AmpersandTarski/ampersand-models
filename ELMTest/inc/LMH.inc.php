<?php // generated with Prototype vs. 1.1.0.874(core vs. 2.0.0.13)
  
  /********* on Nowhere
    SERVICE LMH : I[LMH*LMH]
   = [ oblRisk~ : oblRisk~
     ]
   *********/
  
  class LMH {
    protected $id=false;
    protected $_new=true;
    private $_oblRisk;
    function LMH($id=null,$_oblRisk=null){
      $this->id=$id;
      $this->_oblRisk=$_oblRisk;
      if(!isset($_oblRisk) && isset($id)){
        // get a LMH based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpLMH` AS `LMH`
                           FROM ( SELECT DISTINCT `LMH` AS `MpLMH`, `LMH`
                             FROM `LMH` ) AS fst
                          WHERE fst.`MpLMH` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['oblRisk~']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Obligation` AS `oblRisk~`
                                                FROM `LMH`
                                                JOIN `Obligation` AS f1 ON `f1`.`oblRisk`='".addslashes($id)."'
                                               WHERE `LMH`.`LMH`='".addslashes($id)."'"));
          $this->set_oblRisk($me['oblRisk~']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpLMH` AS `LMH`
                           FROM ( SELECT DISTINCT `LMH` AS `MpLMH`, `LMH`
                             FROM `LMH` ) AS fst
                          WHERE fst.`MpLMH` = \''.addSlashes($id).'\'');
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
       $oldme = array('LMH'=>null);
       $me = array('LMH'=>$this->getId());
       $newme = array('LMH'=>null);
       if (!$this->isNew()) {
          $oldme = firstRow(DB_doquer("SELECT * FROM `LMH` WHERE `LMH`='".addslashes($this->getId())."'"));
          DB_doquer("DELETE FROM `LMH` WHERE `LMH`='".addslashes($this->getId())."'",5);
          $shouldcut = false;
          $cancut = true;
          $cutoldme = false;
          if ($shouldcut){
             if ($cancut){
                $cutoldme = array("LMH"=>$oldme["LMH"]);
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
             DB_doquer("INSERT INTO `LMH` (`LMH`) VALUES (".((null!=$cutoldme['LMH'])?"'".addslashes($cutoldme['LMH'])."'":"NULL").")", 5);
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
       $selkey = DB_doquer("SELECT * FROM `LMH` WHERE `LMH`='".addslashes($newme['LMH'])."'");
       if (count($selkey)>0){
          $oldkey = firstRow($selkey);
          if (($oldkey["LMH"]==$newme["LMH"] || !isset($oldkey["LMH"]) || !isset($newme["LMH"]))){
             DB_doquer("DELETE FROM `LMH` WHERE `LMH`='".addslashes($newme['LMH'])."'",5);
             foreach ($newme as $fld => $newval){
                if (isset($me[$fld]))
                   $newme[$fld] = $newval; //the value on the screen is at least in newme
                else
                   $newme[$fld] = $oldkey[$fld];
             }
          } else {
             rollbacktransaction();
             if ($oldkey["LMH"]!=$newme["LMH"] && isset($oldkey["LMH"]) && isset($newme["LMH"])) $myerrors[] = print_r(array('error'=>"LMH ".$newme['LMH']." already identifies LMH ".$oldkey['LMH']." overwriting it with ".$newme['LMH']." would delete ".$oldkey['LMH'].". Please assign it to a different LMH or delete it first."));
             return false;
          }
       }
       DB_doquer("INSERT INTO `LMH` (`LMH`) VALUES (".((null!=$newme['LMH'])?"'".addslashes($newme['LMH'])."'":"NULL").")", 5);
       if(mysql_errno()!=0) {
          $err = mysql_error();
          rollbacktransaction();
          $myerrors[] = print_r(array('observation'=>'sql error while saving instance.'.$this->getId(),'erroranalysis'=>'you may have missing required fields','sqlerror'=>$err)).print_r($newme);
          return false;
       }
       
       //myatts
       //first delete myatt relations (SET to NULL)
       DB_doquer("UPDATE `Obligation` SET `oblRisk`=NULL WHERE `oblRisk`='".addslashes($this->getId())."' ");
       //then insert myatt relations as defined in this (key=$val is assumed to exist)
       foreach ($this->_oblRisk as $k => $val){
          DB_doquer("UPDATE `Obligation` SET `oblRisk`='".addslashes($this->getId())."' WHERE `Obligation`='".addslashes($val)."' ");
       }
       
       if (closetransaction()) {return $this->getId();} else {$myerrors[] = print_r(array('close'=>'close')); return false;}
    }
    function set_oblRisk($val){
      $this->_oblRisk=$val;
    }
    function get_oblRisk(){
      if(!isset($this->_oblRisk)) return array();
      return $this->_oblRisk;
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

  function getEachLMH(){
    return firstCol(DB_doquer('SELECT DISTINCT `LMH`
                                 FROM `LMH`'));
  }

  function readLMH($id){
      // check existence of $id
      $obj = new LMH($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delLMH($id){
    $tobeDeleted = new LMH($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>