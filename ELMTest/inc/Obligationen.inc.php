<?php // generated with Prototype vs. 1.1.0.874(core vs. 2.0.0.13)
  
  /********* on Nowhere
    SERVICE Obligationen : I[ONE*ONE]
   = [ Obligation : V[ONE*Obligation]
     ]
   *********/
  
  class Obligationen {
    private $_Obligation;
    function Obligationen($_Obligation=null){
      $this->_Obligation=$_Obligation;
      if(!isset($_Obligation)){
        // get a Obligationen based on its identifier
        // fill the attributes
        $me=array();
        $me['Obligation']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Obligation`
                                                FROM ( SELECT DISTINCT cfst.Obligation
                                                       FROM `Obligation` AS cfst ) AS f1"));
        $this->set_Obligation($me['Obligation']);
      }
    }

    function save(){}
    function set_Obligation($val){
      $this->_Obligation=$val;
    }
    function get_Obligation(){
      if(!isset($this->_Obligation)) return array();
      return $this->_Obligation;
    }
  }

?>