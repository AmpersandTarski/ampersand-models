<?php // generated with ADL vs. 1.1-646
  
  /********* on line 273, file "src/atlas/atlas.adl"
    SERVICE Relatiedetails : I[Relation]
   = [ uitleg : description;display
     , cardinaliteitseigenschappen : on~
        = [ eigenschap : property;display
          , afgeleide regel : display
          , wordt overtreden door : violates~;display
          ]
     , homogene eigenschappen : on~
        = [ eigenschap : property;display
          , afgeleide regel : display
          , wordt overtreden door : violates~;display
          ]
     , concepten {"DISPLAY=Concept.display"} : relvar;(source\/target)
     , toepassing in regels {"DISPLAY=UserRule.display"} : morphisms~
     , pattern {"DISPLAY=Pattern.display"} : pattern
     , populatie : contains;display
     ]
   *********/
  
  class Relatiedetails {
    protected $id=false;
    protected $_new=true;
    private $_uitleg;
    private $_cardinaliteitseigenschappen;
    private $_homogeneeigenschappen;
    private $_concepten;
    private $_toepassinginregels;
    private $_pattern;
    private $_populatie;
    function Relatiedetails($id=null, $_uitleg=null, $_cardinaliteitseigenschappen=null, $_homogeneeigenschappen=null, $_concepten=null, $_toepassinginregels=null, $_pattern=null, $_populatie=null){
      $this->id=$id;
      $this->_uitleg=$_uitleg;
      $this->_cardinaliteitseigenschappen=$_cardinaliteitseigenschappen;
      $this->_homogeneeigenschappen=$_homogeneeigenschappen;
      $this->_concepten=$_concepten;
      $this->_toepassinginregels=$_toepassinginregels;
      $this->_pattern=$_pattern;
      $this->_populatie=$_populatie;
      if(!isset($_uitleg) && isset($id)){
        // get a Relatiedetails based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttRelation` AS `I`
                           FROM 
                              ( SELECT DISTINCT `I` AS `AttRelation`, `I`
                                  FROM `Relation`
                              ) AS fst
                          WHERE fst.`AttRelation` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `Relation`.`I` AS `id`
                                       , `Relation`.`pattern`
                                       , `f1`.`display` AS `uitleg`
                                    FROM `Relation`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`display`
                                                   FROM `Relation` AS F0, `Explanation` AS F1
                                                  WHERE F0.`description`=F1.`I`
                                               ) AS f1
                                      ON `f1`.`I`='".addslashes($id)."'
                                   WHERE `Relation`.`I`='".addslashes($id)."'"));
          $me['cardinaliteitseigenschappen']=(DB_doquer("SELECT DISTINCT `MultiplicityRule`.`I` AS `id`
                                                           FROM `MultiplicityRule`
                                                          WHERE `MultiplicityRule`.`on`='".addslashes($id)."'"));
          $me['homogene eigenschappen']=(DB_doquer("SELECT DISTINCT `HomogeneousRule`.`I` AS `id`
                                                      FROM `HomogeneousRule`
                                                     WHERE `HomogeneousRule`.`on`='".addslashes($id)."'"));
          $me['concepten']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`source` AS `concepten`
                                                 FROM `Relation`
                                                 JOIN  ( SELECT DISTINCT F0.`Relation`, F1.`source`
                                                                FROM `relvar` AS F0, 
                                                                   ( 
                                                                     (SELECT DISTINCT I, source
                                                                           FROM `Type`
                                                                     ) UNION (SELECT DISTINCT I, target AS `source`
                                                                           FROM `Type`
                                                                     
                                                                     )
                                                                   ) AS F1
                                                               WHERE F0.`Type`=F1.`I`
                                                            ) AS f1
                                                   ON `f1`.`Relation`='".addslashes($id)."'
                                                WHERE `Relation`.`I`='".addslashes($id)."'"));
          $me['toepassing in regels']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`UserRule` AS `toepassing in regels`
                                                            FROM `Relation`
                                                            JOIN `morphisms1` AS f1 ON `f1`.`Relation`='".addslashes($id)."'
                                                           WHERE `Relation`.`I`='".addslashes($id)."'"));
          $me['populatie']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `populatie`
                                                 FROM `Relation`
                                                 JOIN  ( SELECT DISTINCT F0.`Relation`, F1.`display`
                                                                FROM `contains1` AS F0, `Pair` AS F1
                                                               WHERE F0.`Pair`=F1.`I`
                                                            ) AS f1
                                                   ON `f1`.`Relation`='".addslashes($id)."'
                                                WHERE `Relation`.`I`='".addslashes($id)."'"));
          foreach($me['cardinaliteitseigenschappen'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`display` AS `eigenschap`
                                         , `f3`.`display` AS `afgeleide regel`
                                      FROM `MultiplicityRule`
                                      LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`display`
                                                     FROM `MultiplicityRule` AS F0, `Prop` AS F1
                                                    WHERE F0.`property`=F1.`I`
                                                 ) AS f2
                                        ON `f2`.`I`='".addslashes($v0['id'])."'
                                      LEFT JOIN `MultiplicityRule` AS f3 ON `f3`.`I`='".addslashes($v0['id'])."'
                                     WHERE `MultiplicityRule`.`I`='".addslashes($v0['id'])."'"));
            $v0['wordt overtreden door']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `wordt overtreden door`
                                                               FROM `MultiplicityRule`
                                                               JOIN  ( SELECT DISTINCT F0.`MultiplicityRule`, F1.`display`
                                                                              FROM `violates3` AS F0, `Violation` AS F1
                                                                             WHERE F0.`Violation`=F1.`I`
                                                                          ) AS f1
                                                                 ON `f1`.`MultiplicityRule`='".addslashes($v0['id'])."'
                                                              WHERE `MultiplicityRule`.`I`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['homogene eigenschappen'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`display` AS `eigenschap`
                                         , `f3`.`display` AS `afgeleide regel`
                                      FROM `HomogeneousRule`
                                      LEFT JOIN  ( SELECT DISTINCT F0.`I`, F1.`display`
                                                     FROM `HomogeneousRule` AS F0, `Prop` AS F1
                                                    WHERE F0.`property`=F1.`I`
                                                 ) AS f2
                                        ON `f2`.`I`='".addslashes($v0['id'])."'
                                      LEFT JOIN `HomogeneousRule` AS f3 ON `f3`.`I`='".addslashes($v0['id'])."'
                                     WHERE `HomogeneousRule`.`I`='".addslashes($v0['id'])."'"));
            $v0['wordt overtreden door']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `wordt overtreden door`
                                                               FROM `HomogeneousRule`
                                                               JOIN  ( SELECT DISTINCT F0.`HomogeneousRule`, F1.`display`
                                                                              FROM `violates4` AS F0, `Violation` AS F1
                                                                             WHERE F0.`Violation`=F1.`I`
                                                                          ) AS f1
                                                                 ON `f1`.`HomogeneousRule`='".addslashes($v0['id'])."'
                                                              WHERE `HomogeneousRule`.`I`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_uitleg($me['uitleg']);
          $this->set_cardinaliteitseigenschappen($me['cardinaliteitseigenschappen']);
          $this->set_homogeneeigenschappen($me['homogene eigenschappen']);
          $this->set_concepten($me['concepten']);
          $this->set_toepassinginregels($me['toepassing in regels']);
          $this->set_pattern($me['pattern']);
          $this->set_populatie($me['populatie']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttRelation` AS `I`
                           FROM 
                              ( SELECT DISTINCT `I` AS `AttRelation`, `I`
                                  FROM `Relation`
                              ) AS fst
                          WHERE fst.`AttRelation` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "uitleg" => $this->_uitleg, "cardinaliteitseigenschappen" => $this->_cardinaliteitseigenschappen, "homogene eigenschappen" => $this->_homogeneeigenschappen, "concepten" => $this->_concepten, "toepassing in regels" => $this->_toepassinginregels, "pattern" => $this->_pattern, "populatie" => $this->_populatie);
      // no code for toepassing in regels,I in UserRule
      foreach($me['homogene eigenschappen'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `HomogeneousRule` SET `display`='".addslashes($v0['afgeleide regel'])."' WHERE `I`='".addslashes($v0['id'])."'", 5);
      }
      foreach  ($me['homogene eigenschappen'] as $homogeneeigenschappen){
        if(isset($me['id']))
          DB_doquer("UPDATE `HomogeneousRule` SET `on`='".addslashes($me['id'])."' WHERE `I`='".addslashes($homogeneeigenschappen['id'])."'", 5);
      }
      foreach($me['cardinaliteitseigenschappen'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `MultiplicityRule` SET `display`='".addslashes($v0['afgeleide regel'])."' WHERE `I`='".addslashes($v0['id'])."'", 5);
      }
      foreach  ($me['cardinaliteitseigenschappen'] as $cardinaliteitseigenschappen){
        if(isset($me['id']))
          DB_doquer("UPDATE `MultiplicityRule` SET `on`='".addslashes($me['id'])."' WHERE `I`='".addslashes($cardinaliteitseigenschappen['id'])."'", 5);
      }
      if(isset($me['id']))
        DB_doquer("UPDATE `Relation` SET `pattern`='".addslashes($me['pattern'])."' WHERE `I`='".addslashes($me['id'])."'", 5);
      // no code for concepten,I in Concept
      // no code for pattern,I in Pattern
      DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($me['uitleg'])."'",5);
      foreach($me['cardinaliteitseigenschappen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v0['eigenschap'])."'",5);
      }
      foreach($me['cardinaliteitseigenschappen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v0['afgeleide regel'])."'",5);
      }
      foreach($me['cardinaliteitseigenschappen'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['homogene eigenschappen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v0['eigenschap'])."'",5);
      }
      foreach($me['homogene eigenschappen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v0['afgeleide regel'])."'",5);
      }
      foreach($me['homogene eigenschappen'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['populatie'] as $i0=>$v0){
        DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v0)."'",5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($me['uitleg'])."')", 5);
      foreach($me['cardinaliteitseigenschappen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($v0['eigenschap'])."')", 5);
      }
      foreach($me['cardinaliteitseigenschappen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($v0['afgeleide regel'])."')", 5);
      }
      foreach($me['cardinaliteitseigenschappen'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['homogene eigenschappen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($v0['eigenschap'])."')", 5);
      }
      foreach($me['homogene eigenschappen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($v0['afgeleide regel'])."')", 5);
      }
      foreach($me['homogene eigenschappen'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['populatie'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `String` (`I`) VALUES ('".addslashes($v0)."')", 5);
      }
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return $this->getId();
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function del(){
      DB_doquer('START TRANSACTION');
      $me=array("id"=>$this->getId(), "uitleg" => $this->_uitleg, "cardinaliteitseigenschappen" => $this->_cardinaliteitseigenschappen, "homogene eigenschappen" => $this->_homogeneeigenschappen, "concepten" => $this->_concepten, "toepassing in regels" => $this->_toepassinginregels, "pattern" => $this->_pattern, "populatie" => $this->_populatie);
      DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($me['uitleg'])."'",5);
      foreach($me['cardinaliteitseigenschappen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v0['eigenschap'])."'",5);
      }
      foreach($me['cardinaliteitseigenschappen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v0['afgeleide regel'])."'",5);
      }
      foreach($me['cardinaliteitseigenschappen'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['homogene eigenschappen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v0['eigenschap'])."'",5);
      }
      foreach($me['homogene eigenschappen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v0['afgeleide regel'])."'",5);
      }
      foreach($me['homogene eigenschappen'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['populatie'] as $i0=>$v0){
        DB_doquer("DELETE FROM `String` WHERE `I`='".addslashes($v0)."'",5);
      }
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_uitleg($val){
      $this->_uitleg=$val;
    }
    function get_uitleg(){
      return $this->_uitleg;
    }
    function set_cardinaliteitseigenschappen($val){
      $this->_cardinaliteitseigenschappen=$val;
    }
    function get_cardinaliteitseigenschappen(){
      if(!isset($this->_cardinaliteitseigenschappen)) return array();
      return $this->_cardinaliteitseigenschappen;
    }
    function set_homogeneeigenschappen($val){
      $this->_homogeneeigenschappen=$val;
    }
    function get_homogeneeigenschappen(){
      if(!isset($this->_homogeneeigenschappen)) return array();
      return $this->_homogeneeigenschappen;
    }
    function set_concepten($val){
      $this->_concepten=$val;
    }
    function get_concepten(){
      if(!isset($this->_concepten)) return array();
      return $this->_concepten;
    }
    function set_toepassinginregels($val){
      $this->_toepassinginregels=$val;
    }
    function get_toepassinginregels(){
      if(!isset($this->_toepassinginregels)) return array();
      return $this->_toepassinginregels;
    }
    function set_pattern($val){
      $this->_pattern=$val;
    }
    function get_pattern(){
      return $this->_pattern;
    }
    function set_populatie($val){
      $this->_populatie=$val;
    }
    function get_populatie(){
      if(!isset($this->_populatie)) return array();
      return $this->_populatie;
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

  function getEachRelatiedetails(){
    return firstCol(DB_doquer('SELECT DISTINCT `I`
                                 FROM `Relation`'));
  }

  function readRelatiedetails($id){
      // check existence of $id
      $obj = new Relatiedetails($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delRelatiedetails($id){
    $tobeDeleted = new Relatiedetails($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>