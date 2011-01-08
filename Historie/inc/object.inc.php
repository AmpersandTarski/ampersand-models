<?php // generated with ADL vs. 1.1.0.801
  
  /********* on line 210, file "F:\\RJ$\\Prive\\CC model repository\\Adlfiles\\Historie.adl"
    SERVICE object : I[Object]
   = [ object : I[Object]
     , inhoud : object~;(-(pre~;post;post~;pre)/\I[Inhoud])
        = [ inhoud : I[Inhoud]
          , versie : versie
          ]
     , verloop : object~
     ]
   *********/
  
  class object {
    protected $id=false;
    protected $_new=true;
    private $_object;
    private $_inhoud;
    private $_verloop;
    function object($id=null, $_object=null, $_inhoud=null, $_verloop=null){
      $this->id=$id;
      $this->_object=$_object;
      $this->_inhoud=$_inhoud;
      $this->_verloop=$_verloop;
      if(!isset($_object) && isset($id)){
        // get a object based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpObject` AS `I`
                           FROM ( SELECT DISTINCT `I` AS `MpObject`, `I`
                             FROM `Object` ) AS fst
                          WHERE fst.`MpObject` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `Object`.`I` AS `id`
                                       , `Object`.`I` AS `object`
                                    FROM `Object`
                                   WHERE `Object`.`I`='".addslashes($id)."'"));
          $me['inhoud']=(DB_doquer("SELECT DISTINCT `f1`.`Inhoud` AS `id`
                                      FROM `Object`
                                      JOIN  ( SELECT DISTINCT F0.`object`, F1.`Inhoud`
                                                     FROM `Inhoud` AS F0, 
                                                        ( SELECT DISTINCT isect0.`I` AS `Inhoud`, isect0.`I` AS `Inhoud1`
                                                            FROM `Inhoud` AS isect0
                                                           WHERE NOT EXISTS (SELECT *
                                                                        FROM 
                                                                           ( SELECT DISTINCT F0.`Inhoud`, F3.`Inhoud` AS `Inhoud1`
                                                                               FROM `pre` AS F0, `post` AS F1, `post` AS F2, `pre` AS F3
                                                                              WHERE F0.`Gebeurtenis`=F1.`Gebeurtenis`
                                                                              AND F1.`Inhoud`=F2.`Inhoud`
                                                                              AND F2.`Gebeurtenis`=F3.`Gebeurtenis`
                                                                           ) AS cp
                                                                       WHERE isect0.`I`=cp.`Inhoud` AND isect0.`I`=cp.`Inhoud1`) AND isect0.`I` IS NOT NULL AND isect0.`I` IS NOT NULL
                                                        ) AS F1
                                                    WHERE F0.`I`=F1.`Inhoud`
                                                 ) AS f1
                                        ON `f1`.`object`='".addslashes($id)."'
                                     WHERE `Object`.`I`='".addslashes($id)."'"));
          $me['verloop']=firstCol(DB_doquer("SELECT DISTINCT `Inhoud`.`I` AS `verloop`
                                               FROM `Inhoud`
                                              WHERE `Inhoud`.`object`='".addslashes($id)."'"));
          foreach($me['inhoud'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , '".addslashes($v0['id'])."' AS `inhoud`
                                         , `f3`.`versie`
                                      FROM `Inhoud`
                                      LEFT JOIN `Inhoud` AS f3 ON `f3`.`I`='".addslashes($v0['id'])."'
                                     WHERE `Inhoud`.`I`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_object($me['object']);
          $this->set_inhoud($me['inhoud']);
          $this->set_verloop($me['verloop']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`MpObject` AS `I`
                           FROM ( SELECT DISTINCT `I` AS `MpObject`, `I`
                             FROM `Object` ) AS fst
                          WHERE fst.`MpObject` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "object" => $this->_object, "inhoud" => $this->_inhoud, "verloop" => $this->_verloop);
      foreach($me['inhoud'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `Inhoud` SET `I`='".addslashes($v0['id'])."', `versie`='".addslashes($v0['versie'])."' WHERE `I`='".addslashes($v0['inhoud'])."'", 5);
      }
      // no code for inhoud,I in Inhoud
      // no code for verloop,I in Inhoud
      foreach  ($me['verloop'] as $verloop){
        if(isset($me['id']))
          DB_doquer("UPDATE `Inhoud` SET `object`='".addslashes($me['id'])."' WHERE `I`='".addslashes($verloop)."'", 5);
      }
      if(isset($me['id']))
        DB_doquer("UPDATE `Object` SET `I`='".addslashes($me['id'])."' WHERE `I`='".addslashes($me['object'])."'", 5);
      // no code for object,I in Object
      foreach($me['inhoud'] as $i0=>$v0){
        DB_doquer("DELETE FROM `Versie` WHERE `I`='".addslashes($v0['versie'])."'",5);
      }
      foreach($me['inhoud'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `Versie` (`I`) VALUES ('".addslashes($v0['versie'])."')", 5);
      }
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
      $me=array("id"=>$this->getId(), "object" => $this->_object, "inhoud" => $this->_inhoud, "verloop" => $this->_verloop);
      foreach($me['inhoud'] as $i0=>$v0){
        DB_doquer("DELETE FROM `Versie` WHERE `I`='".addslashes($v0['versie'])."'",5);
      }
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
    function set_object($val){
      $this->_object=$val;
    }
    function get_object(){
      return $this->_object;
    }
    function set_inhoud($val){
      $this->_inhoud=$val;
    }
    function get_inhoud(){
      if(!isset($this->_inhoud)) return array();
      return $this->_inhoud;
    }
    function set_verloop($val){
      $this->_verloop=$val;
    }
    function get_verloop(){
      if(!isset($this->_verloop)) return array();
      return $this->_verloop;
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

  function getEachobject(){
    return firstCol(DB_doquer('SELECT DISTINCT `I`
                                 FROM `Object`'));
  }

  function readobject($id){
      // check existence of $id
      $obj = new object($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delobject($id){
    $tobeDeleted = new object($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>