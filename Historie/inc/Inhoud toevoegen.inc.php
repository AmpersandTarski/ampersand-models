<?php // generated with ADL vs. 1.1.0.801
  
  /********* on line 231, file "F:\\RJ$\\Prive\\CC model repository\\Adlfiles\\Historie.adl"
    SERVICE Inhoud toevoegen : I[Object]
   = [ object : I[Object]
     , inhoud : object~
        = [ inhoud : I[Inhoud]
          , versie : versie
          ]
     ]
   *********/
  
  class Inhoud toevoegen {
    protected $id=false;
    protected $_new=true;
    private $_object;
    private $_inhoud;
    function Inhoud toevoegen($id=null, $_object=null, $_inhoud=null){
      $this->id=$id;
      $this->_object=$_object;
      $this->_inhoud=$_inhoud;
      if(!isset($_object) && isset($id)){
        // get a Inhoud toevoegen based on its identifier
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
          $me['inhoud']=(DB_doquer("SELECT DISTINCT `Inhoud`.`I` AS `id`
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
      $me=array("id"=>$this->getId(), "object" => $this->_object, "inhoud" => $this->_inhoud);
      foreach($me['inhoud'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `Inhoud` SET `I`='".addslashes($v0['id'])."', `versie`='".addslashes($v0['versie'])."' WHERE `I`='".addslashes($v0['inhoud'])."'", 5);
      }
      foreach  ($me['inhoud'] as $inhoud){
        if(isset($me['id']))
          DB_doquer("UPDATE `Inhoud` SET `object`='".addslashes($me['id'])."' WHERE `I`='".addslashes($inhoud['id'])."'", 5);
      }
      // no code for inhoud,I in Inhoud
      foreach($me['inhoud'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `Versie` (`I`) VALUES ('".addslashes($v0['versie'])."')", 5);
      }
      if(isset($me['id']))
        DB_doquer("UPDATE `Object` SET `I`='".addslashes($me['id'])."' WHERE `I`='".addslashes($me['object'])."'", 5);
      // no code for object,I in Object
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
        $DB_err='\"de relatie \'isVoorgangerVan\' is irreflexief.\\n\"';
      } else
      if (!checkRule5()){
        $DB_err='\"Van elke inhoud moet traceerbaar zijn volgens welk pad van\\nbewerkingen/veranderingen die inhoud tot stand is gekomen. Daartoe\\nmoet van elke inhoud diens directe voorganger bekend zijn. Deze\\ndirecte voorganger is de inhoud die middels een enkele bewerking\\nwerd getransformeerd in de inhoud waarvan het de voorganger is.\\nEchter, omdat bewerkingen meerdere inhouden kunnen transformeren,\\nmoet de versie van de inhoud ook volgen op die van diens\\nvoorganger, en moeten beide inhouden hetzelfde object betreffen.\\n\\nInhoud X is de voorganger van inhoud Y als er een gebeurtenis is\\nwaarin X werd getransformeerd in Y en vice versa.\\n\"';
      } else
      if (!checkRule6()){
        $DB_err='\"de relatie \'isOpvolgerVan\' is irreflexief.\\n\"';
      } else
      if (!checkRule7()){
        $DB_err='\"Vanuit elke inhoud willen we kunnen navigeren naar de verzameling\\nvan verschillende inhouden die daaruit zijn ontstaan. De\\nverzameling van (directe) opvolgers van een zekere inhoud zijn die\\ninhouden die middels een enkele bewerking zijn ontstaan uit een\\nbewerking op die inhoud. Echter, omdat bewerkingen inhouden van\\nmeerdere objecten kunnen transformeren, moet de versie van de\\nopvolger volgen op die van de bewerkte inhoud, en moeten beide\\ninhouden hetzelfde object betreffen.\\n\\nInhoud Y is een opvolger van inhoud X als er een gebeurtenis is\\nwaarin X werd getransformeerd in Y en vice versa.\\n\"';
      } else
      if (!checkRule8()){
        $DB_err='\"de relatie \'isOpvolgerVan\' is irreflexief.\\n\"';
      } else
      if (!checkRule9()){
        $DB_err='\"Een historische database wordt geacht alleen die inhouden te\\nbevatten die deel uitmaken van de geschiedenis van de verzameling\\ninhouden van het actuele moment. Daarom moet van elke inhoud kunnen\\nworden vastgesteld dat tenminste 1 inhoud bestaat die actueel is\\nvoor het huidige moment en die een (indirecte) opvolger is van deze\\n(eerste) inhoud.\\n\\nInhoud Y is een indirecte opvolger van inhoud X als er een of meer\\ngebeurtenissen zijn waarin X werd getransformeerd in Y en vice\\nversa.\\n\"';
      } else
      if (!checkRule10()){
        $DB_err='\"Een historische database wordt geacht alleen die inhouden te\\nbevatten die deel uitmaken van de geschiedenis van de verzameling\\ninhouden van het actuele moment.\\n\\n\"';
      } else
      if (!checkRule11()){
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
      $me=array("id"=>$this->getId(), "object" => $this->_object, "inhoud" => $this->_inhoud);
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
        $DB_err='\"de relatie \'isVoorgangerVan\' is irreflexief.\\n\"';
      } else
      if (!checkRule5()){
        $DB_err='\"Van elke inhoud moet traceerbaar zijn volgens welk pad van\\nbewerkingen/veranderingen die inhoud tot stand is gekomen. Daartoe\\nmoet van elke inhoud diens directe voorganger bekend zijn. Deze\\ndirecte voorganger is de inhoud die middels een enkele bewerking\\nwerd getransformeerd in de inhoud waarvan het de voorganger is.\\nEchter, omdat bewerkingen meerdere inhouden kunnen transformeren,\\nmoet de versie van de inhoud ook volgen op die van diens\\nvoorganger, en moeten beide inhouden hetzelfde object betreffen.\\n\\nInhoud X is de voorganger van inhoud Y als er een gebeurtenis is\\nwaarin X werd getransformeerd in Y en vice versa.\\n\"';
      } else
      if (!checkRule6()){
        $DB_err='\"de relatie \'isOpvolgerVan\' is irreflexief.\\n\"';
      } else
      if (!checkRule7()){
        $DB_err='\"Vanuit elke inhoud willen we kunnen navigeren naar de verzameling\\nvan verschillende inhouden die daaruit zijn ontstaan. De\\nverzameling van (directe) opvolgers van een zekere inhoud zijn die\\ninhouden die middels een enkele bewerking zijn ontstaan uit een\\nbewerking op die inhoud. Echter, omdat bewerkingen inhouden van\\nmeerdere objecten kunnen transformeren, moet de versie van de\\nopvolger volgen op die van de bewerkte inhoud, en moeten beide\\ninhouden hetzelfde object betreffen.\\n\\nInhoud Y is een opvolger van inhoud X als er een gebeurtenis is\\nwaarin X werd getransformeerd in Y en vice versa.\\n\"';
      } else
      if (!checkRule8()){
        $DB_err='\"de relatie \'isOpvolgerVan\' is irreflexief.\\n\"';
      } else
      if (!checkRule9()){
        $DB_err='\"Een historische database wordt geacht alleen die inhouden te\\nbevatten die deel uitmaken van de geschiedenis van de verzameling\\ninhouden van het actuele moment. Daarom moet van elke inhoud kunnen\\nworden vastgesteld dat tenminste 1 inhoud bestaat die actueel is\\nvoor het huidige moment en die een (indirecte) opvolger is van deze\\n(eerste) inhoud.\\n\\nInhoud Y is een indirecte opvolger van inhoud X als er een of meer\\ngebeurtenissen zijn waarin X werd getransformeerd in Y en vice\\nversa.\\n\"';
      } else
      if (!checkRule10()){
        $DB_err='\"Een historische database wordt geacht alleen die inhouden te\\nbevatten die deel uitmaken van de geschiedenis van de verzameling\\ninhouden van het actuele moment.\\n\\n\"';
      } else
      if (!checkRule11()){
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

  function getEachInhoudtoevoegen(){
    return firstCol(DB_doquer('SELECT DISTINCT `I`
                                 FROM `Object`'));
  }

  function readInhoudtoevoegen($id){
      // check existence of $id
      $obj = new Inhoudtoevoegen($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delInhoudtoevoegen($id){
    $tobeDeleted = new Inhoudtoevoegen($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>