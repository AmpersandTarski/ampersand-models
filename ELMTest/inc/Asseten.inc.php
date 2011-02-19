<?php // generated with Prototype vs. 1.1.0.874(core vs. 2.0.0.13)
  
  /********* on Nowhere
    SERVICE Asseten : I[ONE*ONE]
   = [ Asset : V[ONE*Asset]
     ]
   *********/
  
  class Asseten {
    private $_Asset;
    function Asseten($_Asset=null){
      $this->_Asset=$_Asset;
      if(!isset($_Asset)){
        // get a Asseten based on its identifier
        // fill the attributes
        $me=array();
        $me['Asset']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Asset`
                                           FROM ( SELECT DISTINCT cfst.Asset
                                                  FROM `Asset` AS cfst ) AS f1"));
        $this->set_Asset($me['Asset']);
      }
    }

    function save(){}
    function set_Asset($val){
      $this->_Asset=$val;
    }
    function get_Asset(){
      if(!isset($this->_Asset)) return array();
      return $this->_Asset;
    }
  }

?>