<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 3789, file "VIRO.adl"
    SERVICE ZaakInplannen : I[Behandeling]
   = [ zitting : zitting
     , zaak : zaak
     ]
   *********/
  
  class ZaakInplannen {
    protected $_id=false;
    protected $_new=true;
    private $_zitting;
    private $_zaak;
    function ZaakInplannen($id=null, $zitting=null, $zaak=null){
      $this->_id=$id;
      $this->_zitting=$zitting;
      $this->_zaak=$zaak;
      if(!isset($zitting) && isset($id)){
        // get a ZaakInplannen based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttBehandeling` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttBehandeling`, `i`
                                  FROM `behandeling`
                              ) AS fst
                          WHERE fst.`AttBehandeling` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `behandeling`.`i` AS `id`
                                       , `behandeling`.`zitting`
                                       , `behandeling`.`zaak`
                                    FROM `behandeling`
                                   WHERE `behandeling`.`i`='".addslashes($id)."'"));
          $this->set_zitting($me['zitting']);
          $this->set_zaak($me['zaak']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttBehandeling` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttBehandeling`, `i`
                                  FROM `behandeling`
                              ) AS fst
                          WHERE fst.`AttBehandeling` = \''.addSlashes($id).'\'');
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
      $me=array("id"=>$this->getId(), "zitting" => $this->_zitting, "zaak" => $this->_zaak);
      // no code for zitting,i in zitting
      // no code for zaak,i in procedur
      DB_doquer("DELETE FROM `behandeling` WHERE `i`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `behandeling` (`zitting`,`zaak`,`i`) VALUES ('".addslashes($me['zitting'])."', '".addslashes($me['zaak'])."', '".addslashes($me['id'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for zaak,procedur in eiser
      // no code for zitting,zitting in rechter
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule5()){
        $DB_err='\"Een bestuurszaak dient bij de rechter die bij de zetel van de gemeente, provincie, waterschap of politieregio hoort, waar tegen bezwaar was ingesteld (voorafgaande aan de procedure bij de bestuursrechter) (art. 8:7 Awb.)\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule15()){
        $DB_err='\"\"';
      } else
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule26()){
        $DB_err='\"\"';
      } else
      if (!checkRule27()){
        $DB_err='\"\"';
      } else
      if (!checkRule28()){
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
      if (!checkRule34()){
        $DB_err='\"\"';
      } else
      if (!checkRule37()){
        $DB_err='\"\"';
      } else
      if (!checkRule39()){
        $DB_err='\"\"';
      } else
      if (!checkRule45()){
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
      $me=array("id"=>$this->getId(), "zitting" => $this->_zitting, "zaak" => $this->_zaak);
      DB_doquer("DELETE FROM `behandeling` WHERE `i`='".addslashes($me['id'])."'",5);
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule5()){
        $DB_err='\"Een bestuurszaak dient bij de rechter die bij de zetel van de gemeente, provincie, waterschap of politieregio hoort, waar tegen bezwaar was ingesteld (voorafgaande aan de procedure bij de bestuursrechter) (art. 8:7 Awb.)\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule15()){
        $DB_err='\"\"';
      } else
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule26()){
        $DB_err='\"\"';
      } else
      if (!checkRule27()){
        $DB_err='\"\"';
      } else
      if (!checkRule28()){
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
      if (!checkRule34()){
        $DB_err='\"\"';
      } else
      if (!checkRule37()){
        $DB_err='\"\"';
      } else
      if (!checkRule39()){
        $DB_err='\"\"';
      } else
      if (!checkRule45()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_zitting($val){
      $this->_zitting=$val;
    }
    function get_zitting(){
      return $this->_zitting;
    }
    function set_zaak($val){
      $this->_zaak=$val;
    }
    function get_zaak(){
      return $this->_zaak;
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

  function getEachZaakInplannen(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `behandeling`'));
  }

  function readZaakInplannen($id){
      // check existence of $id
      $obj = new ZaakInplannen($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delZaakInplannen($id){
    $tobeDeleted = new ZaakInplannen($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>