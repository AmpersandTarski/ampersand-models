<?php // generated with Prototype vs. 1.1.0.899(core vs. 2.0.0.25)
  
  /********* on Nowhere
    SERVICE LMHen : I[ONE]
   = [ LMH : V[ONE*LMH]
     ]
   *********/
  
  class LMHen {
    private $_LMH;
    function LMHen($_LMH=null){
      $this->_LMH=$_LMH;
      if(!isset($_LMH)){
        // get a LMHen based on its identifier
        // fill the attributes
        $me=array();
        $me['LMH']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`LMH`
                                         FROM ( SELECT DISTINCT cfst.LMH
                                                FROM `LMH` AS cfst ) AS f1"));
        $this->set_LMH($me['LMH']);
      }
    }

    function save(){}
    function set_LMH($val){
      $this->_LMH=$val;
    }
    function get_LMH(){
      if(!isset($this->_LMH)) return array();
      return $this->_LMH;
    }
  }

?>