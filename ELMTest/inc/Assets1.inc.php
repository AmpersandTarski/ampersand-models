<?php // generated with Prototype vs. 1.1.0.874(core vs. 2.0.0.13)
  
  /********* on line 53, file "F:\\RJ$\\Prive\\CC model repository\\Adlfiles\\ELMTest.adl"
    SERVICE Assets1 : I[ONE]
   = [ Assets : V[ONE*Asset]
        = [ manager : assetManager
          , accepted : dAssetRA
          , obligations : obligationOf~
          ]
     ]
   *********/
  
  class Assets1 {
    private $_Assets;
    function Assets1($_Assets=null){
      $this->_Assets=$_Assets;
      if(!isset($_Assets)){
        // get a Assets1 based on its identifier
        // fill the attributes
        $me=array();
        $me['Assets']=(DB_doquer("SELECT DISTINCT `f1`.`Asset` AS `id`
                                    FROM ( SELECT DISTINCT cfst.Asset
                                           FROM `Asset` AS cfst ) AS f1"));
        foreach($me['Assets'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , `f2`.`assetManager` AS `manager`
                                       , `f3`.`Asset` AS `accepted`
                                    FROM `Asset`
                                    LEFT JOIN `Asset` AS f2 ON `f2`.`Asset`='".addslashes($v0['id'])."'
                                    LEFT JOIN ( SELECT DISTINCT `Asset`
                                                FROM `Asset` ) AS f3
                                      ON `f3`.`Asset`='".addslashes($v0['id'])."'
                                   WHERE `Asset`.`Asset`='".addslashes($v0['id'])."'"));
          $v0['obligations']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Obligation` AS `obligations`
                                                   FROM `Asset`
                                                      , ( SELECT DISTINCT `Obligation`
                                                          FROM `Obligation` ) AS f1"));
        }
        unset($v0);
        $this->set_Assets($me['Assets']);
      }
    }

    function save(){}
    function set_Assets($val){
      $this->_Assets=$val;
    }
    function get_Assets(){
      if(!isset($this->_Assets)) return array();
      return $this->_Assets;
    }
  }

  class Assets {
    private $_manager;
    private $_accepted;
    private $_obligations;
    function Assets($_manager=null, $_accepted=null, $_obligations=null){
      $this->_manager=$_manager;
      $this->_accepted=$_accepted;
      $this->_obligations=$_obligations;
      if(!isset($_manager)){
        // get a Assets based on its identifier
        // fill the attributes
        $me=firstRow(DB_doquer("SELECT DISTINCT `Asset`.`Asset` AS `id`
                                     , `Asset`.`dAssetRA` AS `accepted`
                                     , `Asset1`.`Asset` AS `accepted`
                                     , `f1`.`assetManager` AS `manager`
                                  FROM `Asset`
                                  LEFT JOIN `Asset` AS Asset1 ON `Asset1`.`dAssetRA`='".addslashes(1)."'
                                  LEFT JOIN `Asset` AS f1 ON `f1`.`Asset`='".addslashes(1)."'
                                 WHERE `Asset`.`Asset`='".addslashes(1)."'"));
        $me['obligations']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`Obligation` AS `obligations`
                                                 FROM `Asset`
                                                    , ( SELECT DISTINCT `Obligation`
                                                        FROM `Obligation` ) AS f1"));
        $this->set_manager($me['manager']);
        $this->set_accepted($me['accepted']);
        $this->set_obligations($me['obligations']);
      }
    }

    function save(){}
    function set_manager($val){
      $this->_manager=$val;
    }
    function get_manager(){
      return $this->_manager;
    }
    function set_accepted($val){
      $this->_accepted=$val;
    }
    function get_accepted(){
      return $this->_accepted;
    }
    function set_obligations($val){
      $this->_obligations=$val;
    }
    function get_obligations(){
      if(!isset($this->_obligations)) return array();
      return $this->_obligations;
    }
  }

?>