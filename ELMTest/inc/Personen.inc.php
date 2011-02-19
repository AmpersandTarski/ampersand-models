<?php // generated with Prototype vs. 1.1.0.874(core vs. 2.0.0.13)
  
  /********* on Nowhere
    SERVICE Personen : I[ONE*ONE]
   = [ Person : V[ONE*Person]
     ]
   *********/
  
  class Personen {
    private $_Person;
    function Personen($_Person=null){
      $this->_Person=$_Person;
      if(!isset($_Person)){
        // get a Personen based on its identifier
        // fill the attributes
        $me=array();
        $me['Person']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Person`
                                            FROM ( SELECT DISTINCT cfst.Person
                                                   FROM `Person` AS cfst ) AS f1"));
        $this->set_Person($me['Person']);
      }
    }

    function save(){}
    function set_Person($val){
      $this->_Person=$val;
    }
    function get_Person(){
      if(!isset($this->_Person)) return array();
      return $this->_Person;
    }
  }

?>