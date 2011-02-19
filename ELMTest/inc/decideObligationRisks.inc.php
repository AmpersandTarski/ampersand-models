<?php // generated with Prototype vs. 1.1.0.874(core vs. 2.0.0.13)
  
  /********* on line 74, file "F:\\RJ$\\Prive\\CC model repository\\Adlfiles\\ELMTest.adl"
    SERVICE decideObligationRisks : I[Obligation]
   = [ risk : oblRisk
     , accepted : dOblRA
     ]
   *********/
  
  class decideObligationRisks {
    protected $id=false;
    protected $_new=true;
    private $_risk;
    private $_accepted;
    function decideObligationRisks($id=null,$_risk=null, $_accepted=null){
      $this->id=$id;
      $this->_risk=$_risk;
      $this->_accepted=$_accepted;
      if(!isset($_risk) && isset($id)){
        // get a decideObligationRisks based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpObligation` AS `Obligation`
                           FROM ( SELECT DISTINCT `Obligation` AS `MpObligation`, `Obligation`
                             FROM `Obligation` ) AS fst
                          WHERE fst.`MpObligation` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `Obligation`.`Obligation` AS `id`
                                       , `Obligation`.`dOblRA` AS `accepted`
                                       , `Obligation1`.`Obligation` AS `accepted`
                                       , `f1`.`oblRisk` AS `risk`
                                    FROM `Obligation`
                                    LEFT JOIN `Obligation` AS Obligation1 ON `Obligation1`.`dOblRA`='".addslashes($id)."'
                                    LEFT JOIN `Obligation` AS f1 ON `f1`.`Obligation`='".addslashes($id)."'
                                   WHERE `Obligation`.`Obligation`='".addslashes($id)."'"));
          $this->set_risk($me['risk']);
          $this->set_accepted($me['accepted']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpObligation` AS `Obligation`
                           FROM ( SELECT DISTINCT `Obligation` AS `MpObligation`, `Obligation`
                             FROM `Obligation` ) AS fst
                          WHERE fst.`MpObligation` = \''.addSlashes($id).'\'');
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
       $oldme = array('Obligation'=>null,'obligationOf'=>null,'oblRisk'=>null,'statOblRA'=>null,'dOblRA'=>null);
       $me = array('Obligation'=>$this->getId(),'oblRisk'=>$this->_risk,'dOblRA'=>$this->_accepted);
       $newme = array('Obligation'=>null,'obligationOf'=>null,'oblRisk'=>null,'statOblRA'=>null,'dOblRA'=>null);
       if (!$this->isNew()) {
          $oldme = firstRow(DB_doquer("SELECT * FROM `Obligation` WHERE `Obligation`='".addslashes($this->getId())."'"));
          DB_doquer("DELETE FROM `Obligation` WHERE `Obligation`='".addslashes($this->getId())."'",5);
          $shouldcut = false;
          $cancut = false; //obligationOf
          $cutoldme = false;
          if ($shouldcut){
             if ($cancut){
                $cutoldme = array("Obligation"=>$oldme["Obligation"], "obligationOf"=>$oldme["obligationOf"], "oblRisk"=>null, "statOblRA"=>$oldme["statOblRA"], "dOblRA"=>null);
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
             DB_doquer("INSERT INTO `Obligation` (`Obligation`,`obligationOf`,`oblRisk`,`statOblRA`,`dOblRA`) VALUES (".((null!=$cutoldme['Obligation'])?"'".addslashes($cutoldme['Obligation'])."'":"NULL").", ".((null!=$cutoldme['obligationOf'])?"'".addslashes($cutoldme['obligationOf'])."'":"NULL").", ".((null!=$cutoldme['oblRisk'])?"'".addslashes($cutoldme['oblRisk'])."'":"NULL").", ".((null!=$cutoldme['statOblRA'])?"'".addslashes($cutoldme['statOblRA'])."'":"NULL").", ".((null!=$cutoldme['dOblRA'])?"'".addslashes($cutoldme['dOblRA'])."'":"NULL").")", 5);
             if(mysql_errno()!=0) {
                $err = mysql_error();
                rollbacktransaction();
                $myerrors[] = print_r(array('yyy'=>'yyy','error'=>$err));
                return false;
             }
          //check the existence of attributes
          if(isset($cutoldme['oblRisk']) && count(DB_doquer("SELECT `LMH` FROM `LMH` WHERE `LMH`='".addslashes($cutoldme['oblRisk'])."'")) != 1){
             $rec = array('LMH'=>null);
             $rec['LMH']=$cutoldme['oblRisk'];
             DB_doquer("INSERT INTO `LMH` (`LMH`) VALUES (".((null!=$rec['LMH'])?"'".addslashes($rec['LMH'])."'":"NULL").")", 5);
             if(mysql_errno()!=0) {
                $err = mysql_error();
                rollbacktransaction();
                $myerrors[] = print_r(array('observation'=>'you try to set an attribute to a new instance '.$cutoldme['oblRisk'].' of concept LMH.','erroranalysis'=>'you can only refer to existing instances of LMH on this page, because it has required attributes that are not or cannot be specified on this page.','suggestion'=>'first create '.$cutoldme['oblRisk'].' on a page that can create instances of LMH.','sqlerror'=>$err)).print_r($cutoldme);
                return false;
             }
          }
          //check the existence of attributes
          if(isset($cutoldme['dOblRA']) && count(DB_doquer("SELECT `Obligation` FROM `Obligation` WHERE `Obligation`='".addslashes($cutoldme['dOblRA'])."'")) != 1){
             $rec = array('Obligation'=>null,'obligationOf'=>null,'oblRisk'=>null,'statOblRA'=>null,'dOblRA'=>null);
             $rec['Obligation']=$cutoldme['dOblRA'];
             DB_doquer("INSERT INTO `Obligation` (`Obligation`,`obligationOf`,`oblRisk`,`statOblRA`,`dOblRA`) VALUES (".((null!=$rec['Obligation'])?"'".addslashes($rec['Obligation'])."'":"NULL").", ".((null!=$rec['obligationOf'])?"'".addslashes($rec['obligationOf'])."'":"NULL").", ".((null!=$rec['oblRisk'])?"'".addslashes($rec['oblRisk'])."'":"NULL").", ".((null!=$rec['statOblRA'])?"'".addslashes($rec['statOblRA'])."'":"NULL").", ".((null!=$rec['dOblRA'])?"'".addslashes($rec['dOblRA'])."'":"NULL").")", 5);
             if(mysql_errno()!=0) {
                $err = mysql_error();
                rollbacktransaction();
                $myerrors[] = print_r(array('observation'=>'you try to set an attribute to a new instance '.$cutoldme['dOblRA'].' of concept Obligation.','erroranalysis'=>'you can only refer to existing instances of Obligation on this page, because it has required attributes that are not or cannot be specified on this page.','suggestion'=>'first create '.$cutoldme['dOblRA'].' on a page that can create instances of Obligation.','sqlerror'=>$err)).print_r($cutoldme);
                return false;
             }
          }
          }
       } else {
          foreach ($newme as $fld => $nullval){
             if (isset($me[$fld]))
                $newme[$fld] = $me[$fld]; //the value on the screen is at least in newme
          }
       }
       $selkey = DB_doquer("SELECT * FROM `Obligation` WHERE `Obligation`='".addslashes($newme['Obligation'])."'");
       if (count($selkey)>0){
          $oldkey = firstRow($selkey);
          if (($oldkey["Obligation"]==$newme["Obligation"] || !isset($oldkey["Obligation"]) || !isset($newme["Obligation"]))){
             DB_doquer("DELETE FROM `Obligation` WHERE `Obligation`='".addslashes($newme['Obligation'])."'",5);
             foreach ($newme as $fld => $newval){
                if (isset($me[$fld]))
                   $newme[$fld] = $newval; //the value on the screen is at least in newme
                else
                   $newme[$fld] = $oldkey[$fld];
             }
          } else {
             rollbacktransaction();
             if ($oldkey["Obligation"]!=$newme["Obligation"] && isset($oldkey["Obligation"]) && isset($newme["Obligation"])) $myerrors[] = print_r(array('error'=>"Obligation ".$newme['Obligation']." already identifies Obligation ".$oldkey['Obligation']." overwriting it with ".$newme['Obligation']." would delete ".$oldkey['Obligation'].". Please assign it to a different Obligation or delete it first."));
             return false;
          }
       }
       DB_doquer("INSERT INTO `Obligation` (`Obligation`,`obligationOf`,`oblRisk`,`statOblRA`,`dOblRA`) VALUES (".((null!=$newme['Obligation'])?"'".addslashes($newme['Obligation'])."'":"NULL").", ".((null!=$newme['obligationOf'])?"'".addslashes($newme['obligationOf'])."'":"NULL").", ".((null!=$newme['oblRisk'])?"'".addslashes($newme['oblRisk'])."'":"NULL").", ".((null!=$newme['statOblRA'])?"'".addslashes($newme['statOblRA'])."'":"NULL").", ".((null!=$newme['dOblRA'])?"'".addslashes($newme['dOblRA'])."'":"NULL").")", 5);
       if(mysql_errno()!=0) {
          $err = mysql_error();
          rollbacktransaction();
          $myerrors[] = print_r(array('observation'=>'sql error while saving instance.'.$this->getId(),'erroranalysis'=>'you may have missing required fields','sqlerror'=>$err)).print_r($newme);
          return false;
       }
       
       //check the existence of attributes
       if(isset($newme['oblRisk']) && count(DB_doquer("SELECT `LMH` FROM `LMH` WHERE `LMH`='".addslashes($newme['oblRisk'])."'")) != 1){
          $rec = array('LMH'=>null);
          $rec['LMH']=$newme['oblRisk'];
          DB_doquer("INSERT INTO `LMH` (`LMH`) VALUES (".((null!=$rec['LMH'])?"'".addslashes($rec['LMH'])."'":"NULL").")", 5);
          if(mysql_errno()!=0) {
             $err = mysql_error();
             rollbacktransaction();
             $myerrors[] = print_r(array('observation'=>'you try to set an attribute to a new instance '.$newme['oblRisk'].' of concept LMH.','erroranalysis'=>'you can only refer to existing instances of LMH on this page, because it has required attributes that are not or cannot be specified on this page.','suggestion'=>'first create '.$newme['oblRisk'].' on a page that can create instances of LMH.','sqlerror'=>$err)).print_r($newme);
             return false;
          }
       }
       //check the existence of attributes
       if(isset($newme['dOblRA']) && count(DB_doquer("SELECT `Obligation` FROM `Obligation` WHERE `Obligation`='".addslashes($newme['dOblRA'])."'")) != 1){
          $rec = array('Obligation'=>null,'obligationOf'=>null,'oblRisk'=>null,'statOblRA'=>null,'dOblRA'=>null);
          $rec['Obligation']=$newme['dOblRA'];
          DB_doquer("INSERT INTO `Obligation` (`Obligation`,`obligationOf`,`oblRisk`,`statOblRA`,`dOblRA`) VALUES (".((null!=$rec['Obligation'])?"'".addslashes($rec['Obligation'])."'":"NULL").", ".((null!=$rec['obligationOf'])?"'".addslashes($rec['obligationOf'])."'":"NULL").", ".((null!=$rec['oblRisk'])?"'".addslashes($rec['oblRisk'])."'":"NULL").", ".((null!=$rec['statOblRA'])?"'".addslashes($rec['statOblRA'])."'":"NULL").", ".((null!=$rec['dOblRA'])?"'".addslashes($rec['dOblRA'])."'":"NULL").")", 5);
          if(mysql_errno()!=0) {
             $err = mysql_error();
             rollbacktransaction();
             $myerrors[] = print_r(array('observation'=>'you try to set an attribute to a new instance '.$newme['dOblRA'].' of concept Obligation.','erroranalysis'=>'you can only refer to existing instances of Obligation on this page, because it has required attributes that are not or cannot be specified on this page.','suggestion'=>'first create '.$newme['dOblRA'].' on a page that can create instances of Obligation.','sqlerror'=>$err)).print_r($newme);
             return false;
          }
       }
       
       if (closetransaction()) {return $this->getId();} else {$myerrors[] = print_r(array('close'=>'close')); return false;}
    }
    function set_risk($val){
      $this->_risk=$val;
    }
    function get_risk(){
      return $this->_risk;
    }
    function set_accepted($val){
      $this->_accepted=$val;
    }
    function get_accepted(){
      return $this->_accepted;
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

  function getEachdecideObligationRisks(){
    return firstCol(DB_doquer('SELECT DISTINCT `Obligation`
                                 FROM `Obligation`'));
  }

  function readdecideObligationRisks($id){
      // check existence of $id
      $obj = new decideObligationRisks($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function deldecideObligationRisks($id){
    $tobeDeleted = new decideObligationRisks($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>