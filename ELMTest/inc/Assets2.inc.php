<?php // generated with Prototype vs. 1.1.0.874(core vs. 2.0.0.13)
  
  /********* on line 60, file "F:\\RJ$\\Prive\\CC model repository\\Adlfiles\\ELMTest.adl"
    SERVICE Assets2 : I[Asset];-statAssetRA
   = [ accepted : dAssetRA
     , obligations : obligationOf~
     ]
   *********/
  
  class Assets2 {
    protected $id=false;
    protected $_new=true;
    private $_accepted;
    private $_obligations;
    function Assets2($id=null,$_accepted=null, $_obligations=null){
      $this->id=$id;
      $this->_accepted=$_accepted;
      $this->_obligations=$_obligations;
      if(!isset($_accepted) && isset($id)){
        // get a Assets2 based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpAsset` AS `Asset`
                           FROM 
                              ( SELECT DISTINCT cfst.`Asset` AS `MpAsset`, csnd.`Asset1` AS `Asset`
                                  FROM `Asset` AS cfst, ( SELECT DISTINCT `Asset` AS `Asset1`
                                    FROM `Asset` ) AS csnd
                                 WHERE NOT EXISTS (SELECT *
                                              FROM ( SELECT DISTINCT `Asset`
                                                FROM `Asset` ) AS cp
                                             WHERE cfst.`Asset`=cp.`Asset` AND csnd.`Asset1`=cp.`Asset`)
                              ) AS fst
                          WHERE fst.`MpAsset` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `Asset`.`Asset` AS `id`
                                       , `Asset`.`dAssetRA` AS `accepted`
                                       , `Asset1`.`Asset` AS `accepted`
                                    FROM `Asset`
                                    LEFT JOIN `Asset` AS Asset1 ON `Asset1`.`dAssetRA`='".addslashes($id)."'
                                   WHERE `Asset`.`Asset`='".addslashes($id)."'"));
          $me['obligations']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Obligation` AS `obligations`
                                                   FROM `Asset`
                                                   JOIN `Obligation` AS f1 ON `f1`.`obligationOf`='".addslashes($id)."'
                                                  WHERE `Asset`.`Asset`='".addslashes($id)."'"));
          $this->set_accepted($me['accepted']);
          $this->set_obligations($me['obligations']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpAsset` AS `Asset`
                           FROM 
                              ( SELECT DISTINCT cfst.`Asset` AS `MpAsset`, csnd.`Asset1` AS `Asset`
                                  FROM `Asset` AS cfst, ( SELECT DISTINCT `Asset` AS `Asset1`
                                    FROM `Asset` ) AS csnd
                                 WHERE NOT EXISTS (SELECT *
                                              FROM ( SELECT DISTINCT `Asset`
                                                FROM `Asset` ) AS cp
                                             WHERE cfst.`Asset`=cp.`Asset` AND csnd.`Asset1`=cp.`Asset`)
                              ) AS fst
                          WHERE fst.`MpAsset` = \''.addSlashes($id).'\'');
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
       $oldme = array('Asset'=>null,'assetManager'=>null,'statAssetRA'=>null,'dAssetRA'=>null);
       $me = array('Asset'=>$this->getId(),'dAssetRA'=>$this->_accepted);
       $newme = array('Asset'=>null,'assetManager'=>null,'statAssetRA'=>null,'dAssetRA'=>null);
       if (!$this->isNew()) {
          $oldme = firstRow(DB_doquer("SELECT * FROM `Asset` WHERE `Asset`='".addslashes($this->getId())."'"));
          DB_doquer("DELETE FROM `Asset` WHERE `Asset`='".addslashes($this->getId())."'",5);
          $shouldcut = false;
          $cancut = false; //assetManager
          $cutoldme = false;
          if ($shouldcut){
             if ($cancut){
                $cutoldme = array("Asset"=>$oldme["Asset"], "assetManager"=>$oldme["assetManager"], "statAssetRA"=>$oldme["statAssetRA"], "dAssetRA"=>null);
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
             DB_doquer("INSERT INTO `Asset` (`Asset`,`assetManager`,`statAssetRA`,`dAssetRA`) VALUES (".((null!=$cutoldme['Asset'])?"'".addslashes($cutoldme['Asset'])."'":"NULL").", ".((null!=$cutoldme['assetManager'])?"'".addslashes($cutoldme['assetManager'])."'":"NULL").", ".((null!=$cutoldme['statAssetRA'])?"'".addslashes($cutoldme['statAssetRA'])."'":"NULL").", ".((null!=$cutoldme['dAssetRA'])?"'".addslashes($cutoldme['dAssetRA'])."'":"NULL").")", 5);
             if(mysql_errno()!=0) {
                $err = mysql_error();
                rollbacktransaction();
                $myerrors[] = print_r(array('yyy'=>'yyy','error'=>$err));
                return false;
             }
          //check the existence of attributes
          if(isset($cutoldme['dAssetRA']) && count(DB_doquer("SELECT `Asset` FROM `Asset` WHERE `Asset`='".addslashes($cutoldme['dAssetRA'])."'")) != 1){
             $rec = array('Asset'=>null,'assetManager'=>null,'statAssetRA'=>null,'dAssetRA'=>null);
             $rec['Asset']=$cutoldme['dAssetRA'];
             DB_doquer("INSERT INTO `Asset` (`Asset`,`assetManager`,`statAssetRA`,`dAssetRA`) VALUES (".((null!=$rec['Asset'])?"'".addslashes($rec['Asset'])."'":"NULL").", ".((null!=$rec['assetManager'])?"'".addslashes($rec['assetManager'])."'":"NULL").", ".((null!=$rec['statAssetRA'])?"'".addslashes($rec['statAssetRA'])."'":"NULL").", ".((null!=$rec['dAssetRA'])?"'".addslashes($rec['dAssetRA'])."'":"NULL").")", 5);
             if(mysql_errno()!=0) {
                $err = mysql_error();
                rollbacktransaction();
                $myerrors[] = print_r(array('observation'=>'you try to set an attribute to a new instance '.$cutoldme['dAssetRA'].' of concept Asset.','erroranalysis'=>'you can only refer to existing instances of Asset on this page, because it has required attributes that are not or cannot be specified on this page.','suggestion'=>'first create '.$cutoldme['dAssetRA'].' on a page that can create instances of Asset.','sqlerror'=>$err)).print_r($cutoldme);
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
       $selkey = DB_doquer("SELECT * FROM `Asset` WHERE `Asset`='".addslashes($newme['Asset'])."'");
       if (count($selkey)>0){
          $oldkey = firstRow($selkey);
          if (($oldkey["Asset"]==$newme["Asset"] || !isset($oldkey["Asset"]) || !isset($newme["Asset"]))){
             DB_doquer("DELETE FROM `Asset` WHERE `Asset`='".addslashes($newme['Asset'])."'",5);
             foreach ($newme as $fld => $newval){
                if (isset($me[$fld]))
                   $newme[$fld] = $newval; //the value on the screen is at least in newme
                else
                   $newme[$fld] = $oldkey[$fld];
             }
          } else {
             rollbacktransaction();
             if ($oldkey["Asset"]!=$newme["Asset"] && isset($oldkey["Asset"]) && isset($newme["Asset"])) $myerrors[] = print_r(array('error'=>"Asset ".$newme['Asset']." already identifies Asset ".$oldkey['Asset']." overwriting it with ".$newme['Asset']." would delete ".$oldkey['Asset'].". Please assign it to a different Asset or delete it first."));
             return false;
          }
       }
       DB_doquer("INSERT INTO `Asset` (`Asset`,`assetManager`,`statAssetRA`,`dAssetRA`) VALUES (".((null!=$newme['Asset'])?"'".addslashes($newme['Asset'])."'":"NULL").", ".((null!=$newme['assetManager'])?"'".addslashes($newme['assetManager'])."'":"NULL").", ".((null!=$newme['statAssetRA'])?"'".addslashes($newme['statAssetRA'])."'":"NULL").", ".((null!=$newme['dAssetRA'])?"'".addslashes($newme['dAssetRA'])."'":"NULL").")", 5);
       if(mysql_errno()!=0) {
          $err = mysql_error();
          rollbacktransaction();
          $myerrors[] = print_r(array('observation'=>'sql error while saving instance.'.$this->getId(),'erroranalysis'=>'you may have missing required fields','sqlerror'=>$err)).print_r($newme);
          return false;
       }
       
       //check the existence of attributes
       if(isset($newme['dAssetRA']) && count(DB_doquer("SELECT `Asset` FROM `Asset` WHERE `Asset`='".addslashes($newme['dAssetRA'])."'")) != 1){
          $rec = array('Asset'=>null,'assetManager'=>null,'statAssetRA'=>null,'dAssetRA'=>null);
          $rec['Asset']=$newme['dAssetRA'];
          DB_doquer("INSERT INTO `Asset` (`Asset`,`assetManager`,`statAssetRA`,`dAssetRA`) VALUES (".((null!=$rec['Asset'])?"'".addslashes($rec['Asset'])."'":"NULL").", ".((null!=$rec['assetManager'])?"'".addslashes($rec['assetManager'])."'":"NULL").", ".((null!=$rec['statAssetRA'])?"'".addslashes($rec['statAssetRA'])."'":"NULL").", ".((null!=$rec['dAssetRA'])?"'".addslashes($rec['dAssetRA'])."'":"NULL").")", 5);
          if(mysql_errno()!=0) {
             $err = mysql_error();
             rollbacktransaction();
             $myerrors[] = print_r(array('observation'=>'you try to set an attribute to a new instance '.$newme['dAssetRA'].' of concept Asset.','erroranalysis'=>'you can only refer to existing instances of Asset on this page, because it has required attributes that are not or cannot be specified on this page.','suggestion'=>'first create '.$newme['dAssetRA'].' on a page that can create instances of Asset.','sqlerror'=>$err)).print_r($newme);
             return false;
          }
       }
       //myatts
       //first delete myatt relations (SET to NULL)
       DB_doquer("UPDATE `Obligation` SET `obligationOf`=NULL WHERE `obligationOf`='".addslashes($this->getId())."' ");
       //then insert myatt relations as defined in this (key=$val is assumed to exist)
       foreach ($this->_obligations as $k => $val){
          DB_doquer("UPDATE `Obligation` SET `obligationOf`='".addslashes($this->getId())."' WHERE `Obligation`='".addslashes($val)."' ");
       }
       
       if (closetransaction()) {return $this->getId();} else {$myerrors[] = print_r(array('close'=>'close')); return false;}
    }
    function set_accepted($val){
      $this->_accepted=$val;
    }
    function get_accepted(){
      return $this->_accepted;
    }
    function set_obligations($val){
      $this->_obligations=$val;
    }
    function get_obligations(){
      if(!isset($this->_obligations)) return array();
      return $this->_obligations;
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

  function getEachAssets2(){
    return firstCol(DB_doquer('SELECT DISTINCT c0.`Asset`
                                 FROM `Asset` AS c0, `Asset` AS F1
                                WHERE NOT EXISTS (SELECT *
                                             FROM ( SELECT DISTINCT `Asset`, `statAssetRA` AS `Asset1`
                                   FROM `Asset` ) AS F0
                                            WHERE c0.`Asset`=F0.`Asset`)
                                AND c0.`Asset` IS NOT NULL'));
  }

  function readAssets2($id){
      // check existence of $id
      $obj = new Assets2($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delAssets2($id){
    $tobeDeleted = new Assets2($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>