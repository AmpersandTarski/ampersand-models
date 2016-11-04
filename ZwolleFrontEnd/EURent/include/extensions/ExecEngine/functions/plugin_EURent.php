<?php 
// This file defines a limited number of functions that are being used in the EURent application. //

use Ampersand\Log\Logger; 

/*
rcRentalPeriodIsChecked :: RentalCase * RentalCase [PROP]
rcRentalPeriodIsWithinMaxRentalDuration :: RentalCase * RentalCase [PROP]

VIOLATION (TXT "{EX} MaxDurationTest;", SRC I          -- RentalCase
                    ,TXT ";", SRC contractedStartDate  -- StartDate
                    ,TXT ";", SRC contractedEndDate    -- EndDate
                    ,TXT ";", SRC rcMaxRentalDuration  -- MaxDuration
*/
function MaxDurationTest($RentalCase,$StartDate,$EndDate,$MaxDuration)
{  Logger::getLogger('EXECENGINE')->debug("MaxDurationTest($RentalCase,$StartDate,$EndDate,$MaxDuration)");
   $projectedRentalDuration = strtotime($EndDate) - strtotime($StartDate);
   $projectedRentalDuration = floor($projectedRentalDuration/(60*60*24));
   if ($projectedRentalDuration <= $MaxDuration)
   { InsPair('rcRentalPeriodIsWithinMaxRentalDuration','RentalCase',$RentalCase,'RentalCase',$RentalCase);
   }
   InsPair('rcRentalPeriodIsChecked','RentalCase',$RentalCase,'RentalCase',$RentalCase);
   return;
}
/* RULE "Compute rental charge": I[CompRentalCharge] |- computedRentalCharge;computedRentalCharge~
VIOLATION (TXT "{EX} CompRentalCharge"
               , TXT ";computedRentalCharge;CompRentalCharge;", SRC I, TXT ";Amount"
               , TXT ";", SRC arg1
               , TXT ";", SRC arg2
               , TXT ";", SRC arg3
          )
*/
function CompRentalCharge($relation,$srcConcept,$srcAtom,$tgtConcept,$arg1,$arg2,$arg3)
{  Logger::getLogger('EXECENGINE')->debug("CompRentalCharge($relation,$srcConcept,$srcAtom,$tgtConcept,$arg1,$arg2,$arg3)");
   $result = intval($arg1) + intval($arg2) + intval($arg3);
   $result = strval($result); // Writing a '0' (integer) results in an empty string.
   InsPair($relation,$srcConcept,$srcAtom,$tgtConcept,$result);
   return;
}
/*
VIOLATION (TXT "{EX} CompTariffedCharge" -- result  := integer * amount 
               , TXT ";computedTariffedCharge;CompTariffedCharge;", SRC I, TXT ";Amount"
               , TXT ";", SRC ctcNrOfDays
               , TXT ";", SRC ctcDailyAmount
          )
*/
function CompTariffedCharge($relation,$srcConcept,$srcAtom,$tgtConcept,$ctcNrOfDays,$ctcDailyAmount)
{  Logger::getLogger('EXECENGINE')->debug("CompTariffedCharge($relation,$srcConcept,$srcAtom,$tgtConcept,$ctcNrOfDays,$ctcDailyAmount)");
   $result = intval($ctcNrOfDays) * intval($ctcDailyAmount);
   $result = strval($result); // Writing a '0' (integer) results in an empty string.
   InsPair($relation,$srcConcept,$srcAtom,$tgtConcept,$result);
   return;
}
?>