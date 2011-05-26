<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 315, file "VIROENG.adl"
    SERVICE Panels : I[ONE]
   = [ Panels : [ONE*Panel]
        = [ panel : [Panel]
          , court : court
          , members : members~
          ]
     ]
   *********/
  
  class Panels {
    private $_Panels;
    function Panels($Panels=null){
      $this->_Panels=$Panels;
      if(!isset($Panels)){
        // get a Panels based on its identifier
        // fill the attributes
        $me=array();
        $me['Panels']=(DB_doquer("SELECT DISTINCT `f1`.`Panel` AS `id`
                                    FROM  ( SELECT DISTINCT csnd.i AS `Panel`
                                              FROM `panel` AS csnd
                                          ) AS f1"));
        foreach($me['Panels'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `panel`
                                       , `f3`.`court`
                                    FROM `panel`
                                    LEFT JOIN `panel` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                   WHERE `panel`.`i`='".addslashes($v0['id'])."'"));
          $v0['members']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `members`
                                               FROM `panel`
                                               JOIN `members` AS f1 ON `f1`.`Panel`='".addslashes($v0['id'])."'
                                              WHERE `panel`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Panels($me['Panels']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Panels" => $this->_Panels);
      // no code for court,i in court
      // no code for members,i in party
      foreach($me['Panels'] as $i0=>$v0){
        DB_doquer("DELETE FROM `panel` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Panels'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `panel` (`i`,`court`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['court'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for panel,i in panel
      if (!checkRule1()){
        $DB_err='\"The plaintiff in an administrative case is a juristic person\"';
      } else
      if (!checkRule2()){
        $DB_err='\"The defendant in an administrative case is an administrative authority as referred to in art.1:1 Awb.\"';
      } else
      if (!checkRule5()){
        $DB_err='\"Every party is either a person or an organization or an administrative authority.\"';
      } else
      if (!checkRule8()){
        $DB_err='\"A judge at a session is a member of the panel that runs the session.\"';
      } else
      if (!checkRule27()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
        $DB_err='\"\"';
      } else
      if (!checkRule31()){
        $DB_err='\"\"';
      } else
      if (!checkRule33()){
        $DB_err='\"\"';
      } else
      if (!checkRule38()){
        $DB_err='\"\"';
      } else
      if (!checkRule40()){
        $DB_err='\"\"';
      } else
      if (!checkRule41()){
        $DB_err='\"\"';
      } else
      if (!checkRule43()){
        $DB_err='\"\"';
      } else
      if (!checkRule46()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
        $DB_err='\"\"';
      } else
      if (!checkRule56()){
        $DB_err='\"\"';
      } else
      if (!checkRule59()){
        $DB_err='\"\"';
      } else
      if (!checkRule60()){
        $DB_err='\"\"';
      } else
      if (!checkRule61()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Panels($val){
      $this->_Panels=$val;
    }
    function get_Panels(){
      if(!isset($this->_Panels)) return array();
      return $this->_Panels;
    }
  }

?>