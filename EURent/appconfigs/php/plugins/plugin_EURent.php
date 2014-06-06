<?php 
// This file defines a limited number of functions that are being used in the EURent application. //
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
?>