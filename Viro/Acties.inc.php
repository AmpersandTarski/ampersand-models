<?php // generated with ADL vs. 0.8.10-451
  
  /********* on line 541, file "VIRO.adl"
    SERVICE Acties : I[ONE]
   = [ Acties : [ONE*Actie]
        = [ nr : [Actie]
          , subject Persoon : subject
          , type Handeling : type
          ]
     ]
   *********/
  
  class Acties {
    private $_Acties;
    function Acties($Acties=null){
      $this->_Acties=$Acties;
      if(!isset($Acties)){
        // get a Acties based on its identifier
        // fill the attributes
        $me=array();
        $me['Acties']=(DB_doquer("SELECT DISTINCT `f1`.`Actie` AS `id`
                                    FROM  ( SELECT DISTINCT csnd.i AS `Actie`
                                              FROM `actie` AS csnd
                                          ) AS f1"));
        foreach($me['Acties'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `nr`
                                       , `f3`.`subject` AS `subject Persoon`
                                       , `f4`.`type` AS `type Handeling`
                                    FROM `actie`
                                    LEFT JOIN `actie` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                    LEFT JOIN `actie` AS f4 ON `f4`.`i`='".addslashes($v0['id'])."'
                                   WHERE `actie`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Acties($me['Acties']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Acties" => $this->_Acties);
      foreach($me['Acties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `actie` WHERE `i`='".addslashes($v0['id'])."'",5);
      }
      foreach($me['Acties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `actie` (`i`,`subject`,`type`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['subject Persoon'])."', '".addslashes($v0['type Handeling'])."')", 5);
        if($res!==false && !isset($v0['id']))
          $v0['id']=mysql_insert_id();
      }
      // no code for nr,i in actie
      foreach($me['Acties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `persoon` WHERE `i`='".addslashes($v0['subject Persoon'])."'",5);
      }
      foreach($me['Acties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `persoon` (`i`) VALUES ('".addslashes($v0['subject Persoon'])."')", 5);
      }
      foreach($me['Acties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `handeling` WHERE `i`='".addslashes($v0['type Handeling'])."'",5);
      }
      foreach($me['Acties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `handeling` (`i`) VALUES ('".addslashes($v0['type Handeling'])."')", 5);
      }
      if (!checkRule7()){
        $DB_err='\"De persoon die een actie uitvoert doet dat als vertegenwoordiger van het orgaan dat de handeling uitvoert\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule31()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
        $DB_err='\"\"';
      } else
      if (!checkRule51()){
        $DB_err='\"\"';
      } else
      if (!checkRule52()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
        $DB_err='\"\"';
      } else
      if (!checkRule63()){
        $DB_err='\"\"';
      } else
      if (!checkRule69()){
        $DB_err='\"\"';
      } else
      if (!checkRule73()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Acties($val){
      $this->_Acties=$val;
    }
    function get_Acties(){
      if(!isset($this->_Acties)) return array();
      return $this->_Acties;
    }
  }

?>