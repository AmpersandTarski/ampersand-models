<?php // generated with ADL vs. 0.8.10-452
  
  /********* on line 189, file "VIROENG.adl"
    SERVICE Documents : I[ONE]
   = [ Documents : V;(-(writtenAuthOf;writtenAuthOf~)/\I)
        = [ nr : [Document]
          , type : documentType
          , area of law : caseFile;areaOfLaw
          , type of case : caseFile;(appeal;caseType\/appealToAdminCourt;caseType\/objection;caseType)
          ]
     ]
   *********/
  
  class Documents {
    private $_Documents;
    function Documents($Documents=null){
      $this->_Documents=$Documents;
      if(!isset($Documents)){
        // get a Documents based on its identifier
        // fill the attributes
        $me=array();
        $me['Documents']=(DB_doquer("SELECT DISTINCT `f1`.`document` AS `id`
                                       FROM  ( SELECT DISTINCT fst.`document`
                                                 FROM 
                                                    ( SELECT DISTINCT isect0.`i` AS `document1`, isect0.`i` AS `document`
                                                        FROM `document` AS isect0
                                                       WHERE NOT EXISTS (SELECT *
                                                                    FROM 
                                                                       ( SELECT DISTINCT F0.`document`, F1.`document` AS `document1`
                                                                           FROM `writtenauthof` AS F0, `writtenauthof` AS F1
                                                                          WHERE F0.`Party`=F1.`Party`
                                                                       ) AS cp
                                                                   WHERE isect0.`i`=cp.`document` AND isect0.`i`=cp.`document1`) AND isect0.`i` IS NOT NULL AND isect0.`i` IS NOT NULL
                                                    ) AS fst
                                                WHERE fst.`document` IS NOT NULL
                                             ) AS f1"));
        foreach($me['Documents'] as $i0=>&$v0){
          $v0=firstRow(DB_doquer("SELECT DISTINCT '".addslashes($v0['id'])."' AS `id`
                                       , '".addslashes($v0['id'])."' AS `nr`
                                       , `f3`.`documenttype` AS `type`
                                    FROM `document`
                                    LEFT JOIN `document` AS f3 ON `f3`.`i`='".addslashes($v0['id'])."'
                                   WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          $v0['area of law']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`areaoflaw` AS `area of law`
                                                   FROM `document`
                                                   JOIN  ( SELECT DISTINCT F0.`document`, F1.`areaoflaw`
                                                                  FROM `casefile` AS F0, `legalcase` AS F1
                                                                 WHERE F0.`LegalCase`=F1.`i`
                                                              ) AS f1
                                                     ON `f1`.`document`='".addslashes($v0['id'])."'
                                                  WHERE `document`.`i`='".addslashes($v0['id'])."'"));
          $v0['type of case']=firstCol(DB_doquer("SELECT DISTINCT `f1`.`casetype` AS `type of case`
                                                    FROM `document`
                                                    JOIN  ( SELECT DISTINCT F0.`document`, F1.`casetype`
                                                                   FROM `casefile` AS F0, 
                                                                      ( 
                                                                        (SELECT DISTINCT F0.`legalcase`, F1.`casetype`
                                                                              FROM `appeal` AS F0, `legalcase` AS F1
                                                                             WHERE F0.`legalcase1`=F1.`i`
                                                                        ) UNION (SELECT DISTINCT F0.`legalcase`, F1.`casetype`
                                                                              FROM `appealtoadmincourt` AS F0, `legalcase` AS F1
                                                                             WHERE F0.`legalcase1`=F1.`i`
                                                                        ) UNION (SELECT DISTINCT F0.`legalcase`, F1.`casetype`
                                                                              FROM `objection` AS F0, `legalcase` AS F1
                                                                             WHERE F0.`legalcase1`=F1.`i`
                                                                        
                                                                        
                                                                        )
                                                                      ) AS F1
                                                                  WHERE F0.`LegalCase`=F1.`legalcase`
                                                               ) AS f1
                                                      ON `f1`.`document`='".addslashes($v0['id'])."'
                                                   WHERE `document`.`i`='".addslashes($v0['id'])."'"));
        }
        unset($v0);
        $this->set_Documents($me['Documents']);
      }
    }

    function save(){
      DB_doquer('START TRANSACTION');
      /****************************************\
      * Attributes that will not be saved are: *
      * -------------------------------------- *
      \****************************************/
      $me=array("id"=>1, "Documents" => $this->_Documents);
      foreach($me['Documents'] as $i0=>$v0){
        DB_doquer("INSERT IGNORE INTO `document` (`i`,`documenttype`) VALUES ('".addslashes($v0['id'])."', '".addslashes($v0['type'])."')", 5);
        if(mysql_affected_rows()==0 && $v0['id']!=null){
          //nothing inserted, try updating:
          DB_doquer("UPDATE `document` SET `i`='".addslashes($v0['id'])."', `documenttype`='".addslashes($v0['type'])."' WHERE `i`='".addslashes($v0['nr'])."'", 5);
        }
      }
      // no code for nr,i in document
      foreach($me['Documents'] as $i0=>$v0){
        foreach($v0['area of law'] as $i1=>$v1){
          DB_doquer("DELETE FROM `areaoflaw` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Documents'] as $i0=>$v0){
        foreach($v0['area of law'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `areaoflaw` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      foreach($me['Documents'] as $i0=>$v0){
        DB_doquer("DELETE FROM `documenttype` WHERE `i`='".addslashes($v0['type'])."'",5);
      }
      foreach($me['Documents'] as $i0=>$v0){
        $res=DB_doquer("INSERT IGNORE INTO `documenttype` (`i`) VALUES ('".addslashes($v0['type'])."')", 5);
      }
      foreach($me['Documents'] as $i0=>$v0){
        foreach($v0['type of case'] as $i1=>$v1){
          DB_doquer("DELETE FROM `casetype` WHERE `i`='".addslashes($v1)."'",5);
        }
      }
      foreach($me['Documents'] as $i0=>$v0){
        foreach($v0['type of case'] as $i1=>$v1){
          $res=DB_doquer("INSERT IGNORE INTO `casetype` (`i`) VALUES ('".addslashes($v1)."')", 5);
        }
      }
      if (!checkRule3()){
        $DB_err='\"Written authorizations for representatives of a case are not put in the case file\"';
      } else
      if (!checkRule4()){
        $DB_err='\"Every administrative case is either an appeal or an objection or an appeal to an administrative court. (Art.6:4 Awb)\"';
      } else
      if (!checkRule12()){
        $DB_err='\"An appeal lodged against a decision of an administrative authority of a province or municipality, or a water management board, or a region as referred to in article 21 of the 1993 Police Act, or of a joint body or public body established under the Joint Arrangements Act, falls within the jurisdiction of the district court within whose district the administrative authority has its seat. (art. 8:7 par.1 Awb.)\"';
      } else
      if (!checkRule14()){
        $DB_err='\"\"';
      } else
      if (!checkRule15()){
        $DB_err='\"\"';
      } else
      if (!checkRule16()){
        $DB_err='\"\"';
      } else
      if (!checkRule17()){
        $DB_err='\"\"';
      } else
      if (!checkRule18()){
        $DB_err='\"\"';
      } else
      if (!checkRule19()){
        $DB_err='\"\"';
      } else
      if (!checkRule20()){
        $DB_err='\"\"';
      } else
      if (!checkRule21()){
        $DB_err='\"\"';
      } else
      if (!checkRule22()){
        $DB_err='\"\"';
      } else
      if (!checkRule23()){
        $DB_err='\"\"';
      } else
      if (!checkRule24()){
        $DB_err='\"\"';
      } else
      if (!checkRule25()){
        $DB_err='\"\"';
      } else
      if(true){ // all rules are met
        DB_doquer('COMMIT');
        return true;
      }
      DB_doquer('ROLLBACK');
      return false;
    }
    function set_Documents($val){
      $this->_Documents=$val;
    }
    function get_Documents(){
      if(!isset($this->_Documents)) return array();
      return $this->_Documents;
    }
  }

?>