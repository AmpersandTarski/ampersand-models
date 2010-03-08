<?php // generated with ADL vs. 1.0-632
  
  /********* on line 257, file "src/atlas/atlas.adl"
    SERVICE Population2 : I[SubExpression]
   = [ populatie : contains;display
     ]
   *********/
  
  class Population2 {
    protected $id=false;
    protected $_new=true;
    private $_populatie;
    function Population2($id=null, $_populatie=null){
      $this->id=$id;
      $this->_populatie=$_populatie;
      if(!isset($_populatie) && isset($id)){
        // get a Population2 based on its identifier
        // check if it exists:
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttSubExpression` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttSubExpression`, `i`
                                  FROM `subexpression`
                              ) AS fst
                          WHERE fst.`AttSubExpression` = \''.addSlashes($id).'\'');
        if(count($ctx)==0) $this->_new=true; else
        {
          $this->_new=false;
          // fill the attributes
          $me=array();
          $me['populatie']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`display` AS `populatie`
                                                 FROM `subexpression`
                                                 JOIN  ( SELECT DISTINCT F0.`subexpression`, F1.`display`
                                                                FROM `containssubexpression` AS F0, `pair` AS F1
                                                               WHERE F0.`pair`=F1.`i`
                                                            ) AS f1
                                                   ON `f1`.`subexpression`='".addslashes($id)."'
                                                WHERE `subexpression`.`i`='".addslashes($id)."'"));
          $this->set_populatie($me['populatie']);
        }
      }
      else if(isset($id)){ // just check if it exists
        $ctx = DB_doquer('SELECT DISTINCT fst.`AttSubExpression` AS `i`
                           FROM 
                              ( SELECT DISTINCT `i` AS `AttSubExpression`, `i`
                                  FROM `subexpression`
                              ) AS fst
                          WHERE fst.`AttSubExpression` = \''.addSlashes($id).'\'');
        $this->_new=(count($ctx)==0);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $newID = ($this->getId()===false);
      $me=array("id"=>$this->getId(), "populatie" => $this->_populatie);
      foreach($me['populatie'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['populatie'] as $i0=>$v0){
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
      $me=array("id"=>$this->getId(), "populatie" => $this->_populatie);
      foreach($me['populatie'] as $i0=>$v0){
        DB_doquer("DELETE FROM `string` WHERE `i`='".addslashes($v0)."'",5);
      }
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
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

  function getEachPopulation2(){
    return firstCol(DB_doquer('SELECT DISTINCT `i`
                                 FROM `subexpression`'));
  }

  function readPopulation2($id){
      // check existence of $id
      $obj = new Population2($id);
      if($obj->isNew()) return false; else return $obj;
  }

  function delPopulation2($id){
    $tobeDeleted = new Population2($id);
    if($tobeDeleted->isNew()) return true; // item never existed in the first place
    if($tobeDeleted->del()) return true; else return $tobeDeleted;
  }

?>