<?php // generated with ADL vs. 1.1.0.801
  
  /********* on line 194, file "F:\\RJ$\\Prive\\CC model repository\\Adlfiles\\Historie.adl"
    SERVICE inhoud : I[Inhoud]
   = [ inhoud : I[Inhoud]
     , naam : object
     , versie : versie
     , opvolger : pre~;post/\versie;volgtOp~;versie~/\object;object~
     , voorganger : post~;pre/\versie;volgtOp;versie~/\object;object~
     ]
   *********/
  
  class inhoud {
    protected $id=false;
    protected $_new=true;
    private $_inhoud;
    private $_naam;
    private $_versie;
    private $_opvolger;
    private $_voorganger;
    function inhoud($id=null, $_inhoud=null, $_naam=null, $_versie=null, $_opvolger=null, $_voorganger=null){
      $this->id=$id;
      $this->_inhoud=$_inhoud;
      $this->_naam=$_naam;
      $this->_versie=$_versie;
      $this->_opvolger=$_opvolger;
      $this->_voorganger=$_voorganger;
      if(!isset($_inhoud) && isset($id)){
        // get a inhoud based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpInhoud` AS `I`
                           FROM ( SELECT DISTINCT `I` AS `MpInhoud`, `I`
                             FROM `Inhoud` ) AS fst
                          WHERE fst.`MpInhoud` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `Inhoud`.`I` AS `id`
                                       , `Inhoud`.`I` AS `inhoud`
                                       , `Inhoud`.`object` AS `naam`
                                       , `Inhoud`.`versie`
                                    FROM `Inhoud`
                                   WHERE `Inhoud`.`I`='".addslashes($id)."'"));
          $me['opvolger']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Inhoud` AS `opvolger`
                                                FROM `Inhoud`
                                                JOIN  ( SELECT DISTINCT isect0.`Inhoud`
                                                               FROM 
                                                                  ( SELECT DISTINCT F0.`Inhoud`, F1.`Inhoud` AS `Inhoud1`
                                                                      FROM `pre` AS F0, `post` AS F1
                                                                     WHERE F0.`Gebeurtenis`=F1.`Gebeurtenis`
                                                                  ) AS isect0, 
                                                                  ( SELECT DISTINCT F0.`I`, F2.`I` AS `I1`
                                                                      FROM `Inhoud` AS F0, `volgtOp` AS F1, `Inhoud` AS F2
                                                                     WHERE F0.`versie`=F1.`t_Versie`
                                                                     AND F1.`s_Versie`=F2.`versie`
                                                                  ) AS isect1, 
                                                                  ( SELECT DISTINCT F0.`I`, F1.`I` AS `I1`
                                                                      FROM `Inhoud` AS F0, `Inhoud` AS F1
                                                                     WHERE F0.`object`=F1.`object`
                                                                  ) AS isect2
                                                              WHERE (isect0.`Inhoud` = isect1.`I` AND isect0.`Inhoud1` = isect1.`I1`) AND (isect0.`Inhoud` = isect2.`I` AND isect0.`Inhoud1` = isect2.`I1`) AND isect0.`Inhoud` IS NOT NULL AND isect0.`Inhoud1` IS NOT NULL
                                                           ) AS f1
                                                  ON `f1`.`Inhoud`='".addslashes($id)."'
                                               WHERE `Inhoud`.`I`='".addslashes($id)."'"));
          $me['voorganger']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Inhoud` AS `voorganger`
                                                  FROM `Inhoud`
                                                  JOIN  ( SELECT DISTINCT isect0.`Inhoud`
                                                                 FROM 
                                                                    ( SELECT DISTINCT F0.`Inhoud`, F1.`Inhoud` AS `Inhoud1`
                                                                        FROM `post` AS F0, `pre` AS F1
                                                                       WHERE F0.`Gebeurtenis`=F1.`Gebeurtenis`
                                                                    ) AS isect0, 
                                                                    ( SELECT DISTINCT F0.`I`, F2.`I` AS `I1`
                                                                        FROM `Inhoud` AS F0, `volgtOp` AS F1, `Inhoud` AS F2
                                                                       WHERE F0.`versie`=F1.`s_Versie`
                                                                       AND F1.`t_Versie`=F2.`versie`
                                                                    ) AS isect1, 
                                                                    ( SELECT DISTINCT F0.`I`, F1.`I` AS `I1`
                                                                        FROM `Inhoud` AS F0, `Inhoud` AS F1
                                                                       WHERE F0.`object`=F1.`object`
                                                                    ) AS isect2
                                                                WHERE (isect0.`Inhoud` = isect1.`I` AND isect0.`Inhoud1` = isect1.`I1`) AND (isect0.`Inhoud` = isect2.`I` AND isect0.`Inhoud1` = isect2.`I1`) AND isect0.`Inhoud` IS NOT NULL AND isect0.`Inhoud1` IS NOT NULL
                                                             ) AS f1
                                                    ON `f1`.`Inhoud`='".addslashes($id)."'
                                                 WHERE `Inhoud`.`I`='".addslashes($id)."'"));
          $this->set_inhoud($me['inhoud']);
          $this->set_naam($me['naam']);
          $this->set_versie($me['versie']);
          $this->set_opvolger($me['opvolger']);
          $this->set_voorganger($me['voorganger']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpInhoud` AS `I`
                           FROM ( SELECT DISTINCT `I` AS `MpInhoud`, `I`
                             FROM `Inhoud` ) AS fst
                          WHERE fst.`MpInhoud` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "inhoud" => $this->_inhoud, "naam" => $this->_naam, "versie" => $this->_versie, "opvolger" => $this->_opvolger, "voorganger" => $this->_voorganger);
      DB_doquer("DELETE FROM `Inhoud` WHERE `I`='".addslashes($me['id'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `Inhoud` (`I`,`object`,`versie`) VALUES ('".addslashes($me['id'])."', '".addslashes($me['naam'])."', '".addslashes($me['versie'])."')", 5);
      if($newID) $this->setId($me['id']=mysql_insert_id());
      // no code for inhoud,I in Inhoud
      // no code for opvolger,I in Inhoud
      // no code for voorganger,I in Inhoud
      // no code for naam,I in Object
      DB_doquer("DELETE FROM `Versie` WHERE `I`='".addslashes($me['versie'])."'",5);
      $res=DB_doquer("INSERT IGNORE INTO `Versie` (`I`) VALUES ('".addslashes($me['versie'])."')", 5);
      if (!checkRule0()){
        $DB_err='\"Op elk moment moet een object verwijzen naar zijn actuele inhoud.\\nDaarom verwijst de relatie \'inhoud\' naar de meest recente inhoud\\nvan een object.\\n\\n\"';
      } else
      if (!checkRule1()){
        $DB_err='\"Van elke inhoud wordt een versie bijgehouden, om voor gebruikers de\\nleeftijd ten opzichte van andere inhouden zichtbaar te maken. Als\\neen inhoud verandert, krijgt die een opvolgende versie toegekend.\\n\\nAls door het optreden van een gebeurtenis de inhoud van een object\\nis veranderd, dan is de versie van de nieuwe inhoud gelijk aan de\\nopvolger van de versie heeft de oude inhoud.\\n\"';
      } else
      if (!checkRule2()){
        $DB_err='\"\"';
      } else
      if (!checkRule3()){
        $DB_err='\"\"';
      } else
      if (!checkRule4()){
        $DB_err='\"In de \'changelog\' kan van elke gebeurtenis die geleid heeft tot\\ninhoudelijke veranderingen worden vastgesteld welke objecten dat\\nbetrof. Ook omgekeerd kan van elk object worden teruggevonden welke\\ngebeurtenissen hebben geleid tot inhoudelijke veranderingen in het\\nobject.\\n\\n\"';
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
      $me=array("id"=>$this->getId(), "inhoud" => $this->_inhoud, "naam" => $this->_naam, "versie" => $this->_versie, "opvolger" => $this->_opvolger, "voorganger" => $this->_voorganger);
      DB_doquer("DELETE FROM `Inhoud` WHERE `I`='".addslashes($me['id'])."'",5);
      DB_doquer("DELETE FROM `Versie` WHERE `I`='".addslashes($me['versie'])."'",5);
      if (!checkRule0()){
        $DB_err='\"Op elk moment moet een object verwijzen naar zijn actuele inhoud.\\nDaarom verwijst de relatie \'inhoud\' naar de meest recente inhoud\\nvan een object.\\n\\n\"';
      } else
      if (!checkRule1()){
        $DB_err='\"Van elke inhoud wordt een versie bijgehouden, om voor gebruikers de\\nleeftijd ten opzichte van andere inhouden zichtbaar te maken. Als\\neen inhoud verandert, krijgt die een opvolgende versie toegekend.\\n\\nAls door het optreden van een gebeurtenis de inhoud van een object\\nis veranderd, dan is de versie van de nieuwe inhoud gelijk aan de\\nopvolger van de versie heeft de oude inhoud.\\n\"';
      } else
      if (!checkRule2()){
        $DB_err='\"\"';
      } else
      if (!checkRule3()){
        $DB_err='\"\"';
      } else
      if (!checkRule4()){
        $DB_err='\"In de \'changelog\' kan van elke gebeurtenis die geleid heeft tot\\ninhoudelijke veranderingen worden vastgesteld welke objecten dat\\nbetrof. Ook omgekeerd kan van elk object worden teruggevonden welke\\ngebeurtenissen hebben geleid tot inhoudelijke veranderingen in het\\nobject.\\n\\n\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_inhoud($val){
      $this->_inhoud=$val;
    }
    function get_inhoud(){
      return $this->_inhoud;
    }
    function set_naam($val){
      $this->_naam=$val;
    }
    function get_naam(){
      return $this->_naam;
    }
    function set_versie($val){
      $this->_versie=$val;
    }
    function get_versie(){
      return $this->_versie;
    }
    function set_opvolger($val){
      $this->_opvolger=$val;
    }
    function get_opvolger(){
      if(!isset($this->_opvolger)) return array();
      return $this->_opvolger;
    }
    function set_voorganger($val){
      $this->_voorganger=$val;
    }
    function get_voorganger(){
      if(!isset($this->_voorganger)) return array();
      return $this->_voorganger;
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

  function getEachinhoud(){
    return firstCol(DB_doquer('SELECT DISTINCT `I`
                                 FROM `Inhoud`'));
  }

  function readinhoud($id){
      // check existence of $id
      $obj = new inhoud($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delinhoud($id){
    $tobeDeleted = new inhoud($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>