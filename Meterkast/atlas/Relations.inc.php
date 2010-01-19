<?php // generated with ADL vs. 0.8.10-547
  
  /********* on line 204, file "comp/PWO_gmi/281.adl"
    SERVICE Relations : I[S]
   = [ Relation_s {"DISPLAY=Relation.display"} : V;(user;s;user~/\script;s;script~)
     ]
   *********/
  
  class Relations {
    private $_Relations;
    function Relations($_Relations=null){
      $this->_Relations=$_Relations;
      if(!isset($_Relations)){
        // get a Relations based on its identifier
        // fill the attributes
        $me=array();
        $me['Relation_s']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`i` AS `Relation_s`
                                                FROM  ( SELECT DISTINCT fst.`i`
                                                          FROM 
                                                             ( SELECT DISTINCT TODO.`i`, TODO.`i` AS i1 FROM `Relation` AS TODO WHERE TODO.`User`='".$GLOBALS['ctxenv']['User']."'AND TODO.`Script`='".$GLOBALS['ctxenv']['Script']."'
                                                             ) AS fst
                                                         WHERE fst.`i` IS NOT NULL
                                                      ) AS f1"));
        $this->set_Relations($me['Relation_s']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /**************************\
      * All attributes are saved *
      \**************************/
      $me=array("id"=>1, "Relation_s" => $this->_Relations);
      // no code for Relation_s,i in relation
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Relations($val){
      $this->_Relations=$val;
    }
    function get_Relations(){
      if(!isset($this->_Relations)) return array();
      return $this->_Relations;
    }
  }

?>