<?php // generated with ADL vs. 1.0-632
  
  /********* on line 268, file "src/atlas/atlas.adl"
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
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttRelation` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttRelation`, `i`
                                  FROM `relation`
                              ) AS fst
                          WHERE fst.`AttRelation` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=firstRow(DB_doquer("SELECT DISTINCT `relation`.`i` AS `id`
                                       , `relation`.`pattern`
                                       , `f1`.`display` AS `uitleg`
                                    FROM `relation`
                                    LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                   FROM `relation` AS F0, `explanation` AS F1
                                                  WHERE F0.`description`=F1.`i`
                                               ) AS f1
                                      ON `f1`.`i`='".addslashes($id)."'
                                   WHERE `relation`.`i`='".addslashes($id)."'"));
          $me['cardinaliteitseigenschappen']=(DB_doquer("SELECT DISTINCT `multiplicityrule`.`i` AS `id`
                                                           FROM `multiplicityrule`
                                                          WHERE `multiplicityrule`.`on`='".addslashes($id)."'"));
          $me['homogene eigenschappen']=(DB_doquer("SELECT DISTINCT `homogeneousrule`.`i` AS `id`
                                                      FROM `homogeneousrule`
                                                     WHERE `homogeneousrule`.`on`='".addslashes($id)."'"));
          $me['concepten']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`source` AS `concepten`
                                                 FROM `relation`
                                                 JOIN  ( SELECT DISTINCT F0.`relation`, F1.`source`
                                                                FROM `relvar` AS F0, 
                                                                   ( 
                                                                     (SELECT DISTINCT i, source
                                                                           FROM `type`
                                                                     ) UNION (SELECT DISTINCT i, target AS `source`
                                                                           FROM `type`
                                                                     
                                                                     )
                                                                   ) AS F1
                                                               WHERE F0.`type`=F1.`i`
                                                            ) AS f1
                                                   ON `f1`.`relation`='".addslashes($id)."'
                                                WHERE `relation`.`i`='".addslashes($id)."'"));
          $me['toepassing in regels']=firstCol(DB_doquer("SELECT DISTINCT `morphisms`.`userrule` AS `toepassing in regels`
                                                            FROM `relation`
                                                            JOIN `morphisms` ON `morphisms`.`relation`='".addslashes($id)."'
                                                           WHERE `relation`.`i`='".addslashes($id)."'"));
          $me['populatie']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `populatie`
                                                 FROM `relation`
                                                 JOIN  ( SELECT DISTINCT F0.`relation`, F1.`display`
                                                                FROM `contains` AS F0, `pair` AS F1
                                                               WHERE F0.`pair`=F1.`i`
                                                            ) AS f1
                                                   ON `f1`.`relation`='".addslashes($id)."'
                                                WHERE `relation`.`i`='".addslashes($id)."'"));
          foreach($me['cardinaliteitseigenschappen'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`display` AS `eigenschap`
                                         , `f3`.`display` AS `afgeleide regel`
                                      FROM `multiplicityrule`
                                      LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                     FROM `multiplicityrule` AS F0, `prop` AS F1
                                                    WHERE F0.`property`=F1.`i`
                                                 ) AS f2
                                        ON `f2`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `multiplicityrule` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                     WHERE `multiplicityrule`.`i`='".addslashes($v0['id'])."'"));
            $v0['wordt overtreden door']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `wordt overtreden door`
                                                               FROM `multiplicityrule`
                                                               JOIN  ( SELECT DISTINCT F0.`multiplicityrule`, F1.`display`
                                                                              FROM `violatesmultiplicityrule` AS F0, `violation` AS F1
                                                                             WHERE F0.`violation`=F1.`i`
                                                                          ) AS f1
                                                                 ON `f1`.`multiplicityrule`='".addslashes($v0['id'])."'
                                                              WHERE `multiplicityrule`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['homogene eigenschappen'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`display` AS `eigenschap`
                                         , `f3`.`display` AS `afgeleide regel`
                                      FROM `homogeneousrule`
                                      LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                     FROM `homogeneousrule` AS F0, `prop` AS F1
                                                    WHERE F0.`property`=F1.`i`
                                                 ) AS f2
                                        ON `f2`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `homogeneousrule` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                     WHERE `homogeneousrule`.`i`='".addslashes($v0['id'])."'"));
            $v0['wordt overtreden door']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `wordt overtreden door`
                                                               FROM `homogeneousrule`
                                                               JOIN  ( SELECT DISTINCT F0.`homogeneousrule`, F1.`display`
                                                                              FROM `violateshomogeneousrule` AS F0, `violation` AS F1
                                                                             WHERE F0.`violation`=F1.`i`
                                                                          ) AS f1
                                                                 ON `f1`.`homogeneousrule`='".addslashes($v0['id'])."'
                                                              WHERE `homogeneousrule`.`i`='".addslashes($v0['id'])."'"));
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
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttRelation` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttRelation`, `i`
                                  FROM `relation`
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
      // no code for toepassing in regels,i in userrule
      foreach($me['cardinaliteitseigenschappen'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `multiplicityrule` SET `display`='".addslashes($v0['afgeleide regel'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
      }
      foreach  ($me['cardinaliteitseigenschappen'] as $cardinaliteitseigenschappen){
        if(isset($me['id']))
          DB_doquer("UPDATE `multiplicityrule` SET `on`='".addslashes($me['id'])."' WHERE `i`='".addslashes($cardinaliteitseigenschappen['id'])."'", 5);
      }
      foreach($me['homogene eigenschappen'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `homogeneousrule` SET `display`='".addslashes($v0['afgeleide regel'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
      }
      foreach  ($me['homogene eigenschappen'] as $homogeneeigenschappen){
        if(isset($me['id']))
          DB_doquer("UPDATE `homogeneousrule` SET `on`='".addslashes($me['id'])."' WHERE `i`='".addslashes($homogeneeigenschappen['id'])."'", 5);
      }
      if(isset($me['id']))
        DB_doquer("UPDATE `relation` SET `pattern`='".addslashes($me['pattern'])."' WHERE `i`='".addslashes($me['id'])."'", 5);
      // no code for concepten,i in concept
      // no code for pattern,i in pattern
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['uitleg'])."'",5);
      foreach($me['cardinaliteitseigenschappen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['eigenschap'])."'",5);
      }
      foreach($me['cardinaliteitseigenschappen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['afgeleide regel'])."'",5);
      }
      foreach($me['cardinaliteitseigenschappen'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['homogene eigenschappen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['eigenschap'])."'",5);
      }
      foreach($me['homogene eigenschappen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['afgeleide regel'])."'",5);
      }
      foreach($me['homogene eigenschappen'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['populatie'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($me['uitleg'])."')", 5);
      foreach($me['cardinaliteitseigenschappen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['eigenschap'])."')", 5);
      }
      foreach($me['cardinaliteitseigenschappen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['afgeleide regel'])."')", 5);
      }
      foreach($me['cardinaliteitseigenschappen'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['homogene eigenschappen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['eigenschap'])."')", 5);
      }
      foreach($me['homogene eigenschappen'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['afgeleide regel'])."')", 5);
      }
      foreach($me['homogene eigenschappen'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['populatie'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['concepten'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `containsconcept` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      DB_doquer("DELETE FROM `morphisms` WHERE `relation`='".addslashes($me['id'])."'",5);
      foreach($me['toepassing in regels'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `morphisms` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      if(count($me['toepassing in regels'])==0) $me['toepassing in regels'][] = null;
      foreach  ($me['toepassing in regels'] as $toepassinginregels){
        $res=DB_doquer("INSERT IGNORE INTO `morphisms` (`userrule`,`relation`) VALUES (".((null!=$toepassinginregels)?"'".addslashes($toepassinginregels)."'":"NULL").", ".((null!=$me['id'])?"'".addslashes($me['id'])."'":"NULL").")", 5);
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
      DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($me['uitleg'])."'",5);
      foreach($me['cardinaliteitseigenschappen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['eigenschap'])."'",5);
      }
      foreach($me['cardinaliteitseigenschappen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['afgeleide regel'])."'",5);
      }
      foreach($me['cardinaliteitseigenschappen'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['homogene eigenschappen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['eigenschap'])."'",5);
      }
      foreach($me['homogene eigenschappen'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['afgeleide regel'])."'",5);
      }
      foreach($me['homogene eigenschappen'] as $i0=>$v0){
        foreach($v0['wordt overtreden door'] as $i1=>$v1){
          DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['populatie'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      DB_doquer("DELETE FROM `morphisms` WHERE `relation`='".addslashes($me['id'])."'",5);
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
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `relation`'));
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