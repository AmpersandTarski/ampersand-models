<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 267, file "VIROENG.adl"
    SERVICE CaseParties : I[ONE]
   = [ Plaintiffs : V;plaintiff;plaintiff~
     , Defendants : V;defendant;defendant~
     ]
   *********/
  
  class CaseParties {
    private $_Plaintiffs;
    private $_Defendants;
    function CaseParties($Plaintiffs=null, $Defendants=null){
      $this->_Plaintiffs=$Plaintiffs;
      $this->_Defendants=$Defendants;
      if(!isset($Plaintiffs)){
        // get a CaseParties based on its identifier
        // fill the attributes
        $me=array();
        $me['Plaintiffs']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `Plaintiffs`
                                                FROM  ( SELECT DISTINCT fst.`party`
                                                          FROM 
                                                             ( SELECT DISTINCT F0.`party` AS `party1`, F1.`party`
                                                                 FROM `plaintiff` AS F0, `plaintiff` AS F1
                                                                WHERE F0.`legalcase`=F1.`legalcase`
                                                             ) AS fst
                                                         WHERE fst.`party` IS NOT NULL
                                                      ) AS f1"));
        $me['Defendants']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`party` AS `Defendants`
                                                FROM  ( SELECT DISTINCT fst.`party`
                                                          FROM 
                                                             ( SELECT DISTINCT F0.`party` AS `party1`, F1.`party`
                                                                 FROM `defendant` AS F0, `defendant` AS F1
                                                                WHERE F0.`LegalCase`=F1.`LegalCase`
                                                             ) AS fst
                                                         WHERE fst.`party` IS NOT NULL
                                                      ) AS f1"));
        $this->set_Plaintiffs($me['Plaintiffs']);
        $this->set_Defendants($me['Defendants']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Plaintiffs" => $this->_Plaintiffs, "Defendants" => $this->_Defendants);
      // no code for Plaintiffs,i in party
      // no code for Defendants,i in party
      if (!checkRule1()){
        $DB_err='\"The plaintiff in an administrative case is a juristic person\"';
      } else
      if (!checkRule2()){
        $DB_err='\"The defendant in an administrative case is an administrative authority as referred to in art.1:1 Awb.\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Every party is either a person or an organization or an administrative authority.\"';
      } else
      if (!checkRule11()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
      } else
      if (!checkRule12()){
        $DB_err='\"\"';
      } else
      if (!checkRule26()){
        $DB_err='\"\"';
      } else
      if (!checkRule28()){
        $DB_err='\"\"';
      } else
      if (!checkRule30()){
        $DB_err='\"\"';
      } else
      if (!checkRule32()){
        $DB_err='\"\"';
      } else
      if (!checkRule42()){
        $DB_err='\"\"';
      } else
      if (!checkRule45()){
        $DB_err='\"\"';
      } else
      if (!checkRule50()){
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
  }

?>