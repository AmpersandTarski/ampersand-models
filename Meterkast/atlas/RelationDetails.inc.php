<?php // generated with ADL vs. 0.8.10-556
  
  /********* on line 255, file "comp/PWO_gmi/414.adl"
    SERVICE RelationDetails : I[Relation]
   = [ multiplicity properties : on~
        = [ property : property;display
          , derived rule : display
          , violations : violates~;display
          ]
     , homogeneous properties : on~
        = [ property : property;display
          , derived rule : display
          , violations : violates~;display
          ]
     , concepts {"DISPLAY=Concept.display"} : relvar;(source\/target)
     , used in rules {"DISPLAY=UserRule.display"} : morphisms~
     , pattern {"DISPLAY=Pattern.display"} : pattern
     , population : contains;display
     ]
   *********/
  
  class RelationDetails {
    protected $id=false;
    protected $_new=true;
    private $_multiplicityproperties;
    private $_homogeneousproperties;
    private $_concepts;
    private $_usedinrules;
    private $_pattern;
    private $_population;
    function RelationDetails($id=null, $_multiplicityproperties=null, $_homogeneousproperties=null, $_concepts=null, $_usedinrules=null, $_pattern=null, $_population=null){
      $this->id=$id;
      $this->_multiplicityproperties=$_multiplicityproperties;
      $this->_homogeneousproperties=$_homogeneousproperties;
      $this->_concepts=$_concepts;
      $this->_usedinrules=$_usedinrules;
      $this->_pattern=$_pattern;
      $this->_population=$_population;
      if(!isset($_multiplicityproperties) && isset($id)){
        // get a RelationDetails based on its identifier
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
                                    FROM `relation`
                                   WHERE `relation`.`i`='".addslashes($id)."'"));
          $me['multiplicity properties']=(DB_doquer("SELECT DISTINCT `multiplicityrule`.`i` AS `id`
                                                       FROM `multiplicityrule`
                                                      WHERE `multiplicityrule`.`on`='".addslashes($id)."'"));
          $me['homogeneous properties']=(DB_doquer("SELECT DISTINCT `homogeneousrule`.`i` AS `id`
                                                      FROM `homogeneousrule`
                                                     WHERE `homogeneousrule`.`on`='".addslashes($id)."'"));
          $me['concepts']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`source` AS `concepts`
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
                                                              WHERE F0.`Type`=F1.`i`
                                                           ) AS f1
                                                  ON `f1`.`relation`='".addslashes($id)."'
                                               WHERE `relation`.`i`='".addslashes($id)."'"));
          $me['used in rules']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`userrule` AS `used in rules`
                                                     FROM `relation`
                                                     JOIN `morphisms` AS f1 ON `f1`.`Relation`='".addslashes($id)."'
                                                    WHERE `relation`.`i`='".addslashes($id)."'"));
          $me['population']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `population`
                                                  FROM `relation`
                                                  JOIN  ( SELECT DISTINCT F0.`relation`, F1.`display`
                                                                 FROM `contains` AS F0, `pair` AS F1
                                                                WHERE F0.`Pair`=F1.`i`
                                                             ) AS f1
                                                    ON `f1`.`relation`='".addslashes($id)."'
                                                 WHERE `relation`.`i`='".addslashes($id)."'"));
          foreach($me['multiplicity properties'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`display` AS `property`
                                         , `f3`.`display` AS `derived rule`
                                      FROM `multiplicityrule`
                                      LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                     FROM `multiplicityrule` AS F0, `prop` AS F1
                                                    WHERE F0.`property`=F1.`i`
                                                 ) AS f2
                                        ON `f2`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `multiplicityrule` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                     WHERE `multiplicityrule`.`i`='".addslashes($v0['id'])."'"));
            $v0['violations']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `violations`
                                                    FROM `multiplicityrule`
                                                    JOIN  ( SELECT DISTINCT F0.`MultiplicityRule`, F1.`display`
                                                                   FROM `violatesmultiplicityrule` AS F0, `violation` AS F1
                                                                  WHERE F0.`violation`=F1.`i`
                                                               ) AS f1
                                                      ON `f1`.`MultiplicityRule`='".addslashes($v0['id'])."'
                                                   WHERE `multiplicityrule`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          foreach($me['homogeneous properties'] as $i0=>&$v0){
            $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                         , `f2`.`display` AS `property`
                                         , `f3`.`display` AS `derived rule`
                                      FROM `homogeneousrule`
                                      LEFT JOIN  ( SELECT DISTINCT F0.`i`, F1.`display`
                                                     FROM `homogeneousrule` AS F0, `prop` AS F1
                                                    WHERE F0.`property`=F1.`i`
                                                 ) AS f2
                                        ON `f2`.`i`='".addslashes($v0['id'])."'
                                      LEFT JOIN `homogeneousrule` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                     WHERE `homogeneousrule`.`i`='".addslashes($v0['id'])."'"));
            $v0['violations']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `violations`
                                                    FROM `homogeneousrule`
                                                    JOIN  ( SELECT DISTINCT F0.`HomogeneousRule`, F1.`display`
                                                                   FROM `violateshomogeneousrule` AS F0, `violation` AS F1
                                                                  WHERE F0.`violation`=F1.`i`
                                                               ) AS f1
                                                      ON `f1`.`HomogeneousRule`='".addslashes($v0['id'])."'
                                                   WHERE `homogeneousrule`.`i`='".addslashes($v0['id'])."'"));
          }
          unset($v0);
          $this->set_multiplicityproperties($me['multiplicity properties']);
          $this->set_homogeneousproperties($me['homogeneous properties']);
          $this->set_concepts($me['concepts']);
          $this->set_usedinrules($me['used in rules']);
          $this->set_pattern($me['pattern']);
          $this->set_population($me['population']);
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
      $me=array("id"=>$this->getId(), "multiplicity properties" => $this->_multiplicityproperties, "homogeneous properties" => $this->_homogeneousproperties, "concepts" => $this->_concepts, "used in rules" => $this->_usedinrules, "pattern" => $this->_pattern, "population" => $this->_population);
      // no code for used in rules,i in userrule
      foreach($me['multiplicity properties'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `multiplicityrule` SET `display`='".addslashes($v0['derived rule'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
      }
      foreach  ($me['multiplicity properties'] as $multiplicityproperties){
        if(isset($me['id']))
          DB_doquer("UPDATE `multiplicityrule` SET `on`='".addslashes($me['id'])."' WHERE `i`='".addslashes($multiplicityproperties['id'])."'", 5);
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        if(isset($v0['id']))
          DB_doquer("UPDATE `homogeneousrule` SET `display`='".addslashes($v0['derived rule'])."' WHERE `i`='".addslashes($v0['id'])."'", 5);
      }
      foreach  ($me['homogeneous properties'] as $homogeneousproperties){
        if(isset($me['id']))
          DB_doquer("UPDATE `homogeneousrule` SET `on`='".addslashes($me['id'])."' WHERE `i`='".addslashes($homogeneousproperties['id'])."'", 5);
      }
      if(isset($me['id']))
        DB_doquer("UPDATE `relation` SET `pattern`='".addslashes($me['pattern'])."' WHERE `i`='".addslashes($me['id'])."'", 5);
      // no code for pattern,i in pattern
      // no code for concepts,i in concept
      foreach($me['multiplicity properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['property'])."'",5);
      }
      foreach($me['multiplicity properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['derived rule'])."'",5);
      }
      foreach($me['multiplicity properties'] as $i0=>$v0){
        foreach($v0['violations'] as $i1=>$v1){
          DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['property'])."'",5);
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['derived rule'])."'",5);
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        foreach($v0['violations'] as $i1=>$v1){
          DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['population'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['multiplicity properties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['property'])."')", 5);
      }
      foreach($me['multiplicity properties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['derived rule'])."')", 5);
      }
      foreach($me['multiplicity properties'] as $i0=>$v0){
        foreach($v0['violations'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['property'])."')", 5);
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0['derived rule'])."')", 5);
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        foreach($v0['violations'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['population'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `string` (`i`) VALUES ('".addslashes($v0)."')", 5);
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
      $me=array("id"=>$this->getId(), "multiplicity properties" => $this->_multiplicityproperties, "homogeneous properties" => $this->_homogeneousproperties, "concepts" => $this->_concepts, "used in rules" => $this->_usedinrules, "pattern" => $this->_pattern, "population" => $this->_population);
      foreach($me['multiplicity properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['property'])."'",5);
      }
      foreach($me['multiplicity properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['derived rule'])."'",5);
      }
      foreach($me['multiplicity properties'] as $i0=>$v0){
        foreach($v0['violations'] as $i1=>$v1){
          DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['property'])."'",5);
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0['derived rule'])."'",5);
      }
      foreach($me['homogeneous properties'] as $i0=>$v0){
        foreach($v0['violations'] as $i1=>$v1){
          DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['population'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_multiplicityproperties($val){
      $this->_multiplicityproperties=$val;
    }
    function get_multiplicityproperties(){
      if(!isset($this->_multiplicityproperties)) return array();
      return $this->_multiplicityproperties;
    }
    function set_homogeneousproperties($val){
      $this->_homogeneousproperties=$val;
    }
    function get_homogeneousproperties(){
      if(!isset($this->_homogeneousproperties)) return array();
      return $this->_homogeneousproperties;
    }
    function set_concepts($val){
      $this->_concepts=$val;
    }
    function get_concepts(){
      if(!isset($this->_concepts)) return array();
      return $this->_concepts;
    }
    function set_usedinrules($val){
      $this->_usedinrules=$val;
    }
    function get_usedinrules(){
      if(!isset($this->_usedinrules)) return array();
      return $this->_usedinrules;
    }
    function set_pattern($val){
      $this->_pattern=$val;
    }
    function get_pattern(){
      return $this->_pattern;
    }
    function set_population($val){
      $this->_population=$val;
    }
    function get_population(){
      if(!isset($this->_population)) return array();
      return $this->_population;
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

  function getEachRelationDetails(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `relation`'));
  }

  function readRelationDetails($id){
      // check existence of $id
      $obj = new RelationDetails($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delRelationDetails($id){
    $tobeDeleted = new RelationDetails($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>