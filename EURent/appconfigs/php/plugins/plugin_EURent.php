<?php 
/* This file defines a limited number of functions that are being used in the 
   EURent application.
*/

/*
VIOLATION (TXT "{EX} InsPair;dateIntervalCompTrigger;Date;", SRC I, TXT ";Date;", TGT I
          ,TXT "{EX} MaxDurationTest;dateIntervalIsWithinMaxRentalDuration"
               ,TXT ";Date;", SRC I
               ,TXT ";Date;", TGT I
               ,TXT ";",      SRC rcMaxRentalDuration
          )
*/
function MaxDurationTest($relation,$srcConcept,$srcAtom,$tgtConcept,$tgtAtom,$maxRentalDuration)
{  emitLog("MaxDurationTest($relation,$srcConcept,$srcAtom,$tgtConcept,$tgtAtom,$maxRentalDuration)");
   $projectedRentalDuration = strtotime($tgtAtom) - strtotime($srcAtom);
   $projectedRentalDuration = floor($projectedRentalDuration/(60*60*24));
   if ($projectedRentalDuration <= $maxRentalDuration)
   { InsPair($relation,$srcConcept,$srcAtom,$tgtConcept,$tgtAtom);
   }
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
{  emitLog("CompRentalCharge($relation,$srcConcept,$srcAtom,$tgtConcept,$arg1,$arg2,$arg3)");
   $result = $arg1 + $arg2 + $arg3;
   InsPair($relation,$srcConcept,$srcAtom,$tgtConcept,$result);
   return;
}
/*
VIOLATION (TXT "{EX} CompNrDays" -- Result = 1 + MAX(0, (Actual end date - Actual start date))
               , TXT ";computedRentalPeriod;CompNrDays;", SRC I, TXT ";Integer"
               , TXT ";", SRC latestDate -- = Actual end date
               , TXT ";", SRC earliestDate -- = Actual start date
          )
implemented function is ok.
*/
function CompNrDays($relation,$srcConcept,$srcAtom,$tgtConcept,$earliestDate,$latestDate)
{  emitLog("CompNrDays($relation,$srcConcept,$srcAtom,$tgtConcept,$earliestDate,$latestDate)");
   $datediff = strtotime($latestDate) - strtotime($earliestDate);
   $result = 1 + max(0, floor($datediff/(60*60*24)));
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
{  emitLog("CompTariffedCharge($relation,$srcConcept,$srcAtom,$tgtConcept,$ctcNrOfDays,$ctcDailyAmount)");
   $result = $ctcNrOfDays * $ctcDailyAmount;
   InsPair($relation,$srcConcept,$srcAtom,$tgtConcept,$result);
   return;
}
/*
VIOLATION (TXT "{EX} CompNrExcessDays"  -- Result = MAX(0, (Actual end date - Contracted end date))
               , TXT ";computedNrOfExcessDays;CompNrExcessDays;", SRC I, TXT ";Integer"
               , TXT ";", SRC lastDate
               , TXT ";", SRC firstDate
          )
*/
function CompNrExcessDays($relation,$srcConcept,$srcAtom,$tgtConcept,$firstDate,$lastDate)
{  emitLog("CompNrExcessDays($relation,$srcConcept,$srcAtom,$tgtConcept,$firstDate,$lastDate)");
   $datediff = strtotime($lastDate) - strtotime($firstDate);
   $result = max(0, floor($datediff/(60*60*24)));
   InsPair($relation,$srcConcept,$srcAtom,$tgtConcept,$result);
   return;
}
?>