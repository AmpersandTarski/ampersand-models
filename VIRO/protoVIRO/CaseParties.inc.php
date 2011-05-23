<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 734, file "VIRO453ENG.adl"
    SERVICE CaseParties : I[ONE]
   = [ Plaintiffs : V;plaintiff;plaintiff~
     , Defendants : V;defendant;defendant~
     , Joined Parties : V;joinedInterestedParty;joinedInterestedParty~
     ]
   *********/
  
  class CaseParties {
    private $_Plaintiffs;
    private $_Defendants;
    private $_JoinedParties;
    function CaseParties($Plaintiffs=null, $Defendants=null, $JoinedParties=null){
      $this->_Plaintiffs=$Plaintiffs;
      $this->_Defendants=$Defendants;
      $this->_JoinedParties=$JoinedParties;
      if(!isset($Plaintiffs)){
        // get a CaseParties based on its identifier
        // fill the attributes
        $me=array();
        $me['Plaintiffs']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `Plaintiffs`
                                                FROM  ( SELECT DISTINCT fst.`party`
                                                          FROM 
                                                             ( SELECT DISTINCT F0.`party` AS `party1`, F1.`party`
                                                                 FROM `plaintiff` AS F0, `plaintiff` AS F1
                                                                WHERE F0.`case`=F1.`case`
                                                             ) AS fst
                                                         WHERE fst.`party` IS NOT NULL
                                                      ) AS f1"));
        $me['Defendants']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `Defendants`
                                                FROM  ( SELECT DISTINCT fst.`party`
                                                          FROM 
                                                             ( SELECT DISTINCT F0.`party` AS `party1`, F1.`party`
                                                                 FROM `defendant` AS F0, `defendant` AS F1
                                                                WHERE F0.`Case`=F1.`Case`
                                                             ) AS fst
                                                         WHERE fst.`party` IS NOT NULL
                                                      ) AS f1"));
        $me['Joined Parties']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `Joined Parties`
                                                    FROM  ( SELECT DISTINCT fst.`party`
                                                              FROM 
                                                                 ( SELECT DISTINCT F0.`party` AS `party1`, F1.`party`
                                                                     FROM `joinedinterestedparty` AS F0, `joinedinterestedparty` AS F1
                                                                    WHERE F0.`Case`=F1.`Case`
                                                                 ) AS fst
                                                             WHERE fst.`party` IS NOT NULL
                                                          ) AS f1"));
        $this->set_Plaintiffs($me['Plaintiffs']);
        $this->set_Defendants($me['Defendants']);
        $this->set_JoinedParties($me['Joined Parties']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Plaintiffs" => $this->_Plaintiffs, "Defendants" => $this->_Defendants, "Joined Parties" => $this->_JoinedParties);
      foreach($me['Plaintiffs'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['Defendants'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['Joined Parties'] as $i0=>$v0){
        DB_doquer("DELETE FROM `party` WHERE `i`='".addslashes($v0)."'",5);
      }
      foreach($me['Plaintiffs'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['Defendants'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      foreach($me['Joined Parties'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `party` (`i`) VALUES ('".addslashes($v0)."')", 5);
      }
      if (!checkRule1()){
        $DB_err='\"Voor elke procedure moet er tenminste een eisende partij zijn.\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule29()){
        $DB_err='\"\"';
      } else
      if (!checkRule48()){
        $DB_err='\"\"';
      } else
      if (!checkRule53()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Plaintiffs($val){
      $this->_Plaintiffs=$val;
    }
    function get_Plaintiffs(){
      if(!isset($this->_Plaintiffs)) return array();
      return $this->_Plaintiffs;
    }
    function set_Defendants($val){
      $this->_Defendants=$val;
    }
    function get_Defendants(){
      if(!isset($this->_Defendants)) return array();
      return $this->_Defendants;
    }
    function set_JoinedParties($val){
      $this->_JoinedParties=$val;
    }
    function get_JoinedParties(){
      if(!isset($this->_JoinedParties)) return array();
      return $this->_JoinedParties;
    }
  }

?>