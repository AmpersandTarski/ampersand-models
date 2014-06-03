<?php 
/* This file defines a limited number of functions that are being used in the 
   EURent application.
*/

/* RULE "Compute rental charge": I[CompRentalCharge] |- compRentalCharge;compRentalCharge~
VIOLATION (TXT "{EX} CompRentalCharge"
               , TXT ";compRentalCharge;CompRentalCharge;", SRC I, TXT ";Amount"
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
               , TXT ";compNrDays;CompNrDays;", SRC I, TXT ";Integer"
               , TXT ";", SRC brg1 -- = Actual end date
               , TXT ";", SRC brg2 -- = Actual start date
          )
*/
function compNrDays($relation,$srcConcept,$srcAtom,$tgtConcept,$brg1,$brg2)
{  emitLog("compNrDays($relation,$srcConcept,$srcAtom,$tgtConcept,$brg1,$brg2)");
   $datediff = strtotime($brg1) - strtotime($brg2);
   $result = 1 + max(0, floor($datediff/(60*60*24)));
   InsPair($relation,$srcConcept,$srcAtom,$tgtConcept,$result);
   return;
}
/*
VIOLATION (TXT "{EX} CompTariffedCharge" -- result  := integer * amount 
               , TXT ";compTariffedCharge;CompTariffedCharge;", SRC I, TXT ";Amount"
               , TXT ";", SRC crg1
               , TXT ";", SRC crg2
          )
*/
function CompTariffedCharge($relation,$srcConcept,$srcAtom,$tgtConcept,$crg1,$crg2)
{  emitLog("CompTariffedCharge($relation,$srcConcept,$srcAtom,$tgtConcept,$crg1,$crg2)");
   $result = $crg1 * $crt2;
   InsPair($relation,$srcConcept,$srcAtom,$tgtConcept,$result);
   return;
}
/*
VIOLATION (TXT "{EX} CompNrExcessDays"  -- Result = MAX(0, (Actual end date - Contracted end date))
               , TXT ";compNrExcessDays;CompNrExcessDays;", SRC I, TXT ";Integer"
               , TXT ";", SRC drg1
               , TXT ";", SRC drg2
          )
*/
function CompNrExcessDays($relation,$srcConcept,$srcAtom,$tgtConcept,$drg1,$drg2)
{  emitLog("CompNrExcessDays($relation,$srcConcept,$srcAtom,$tgtConcept,$drg1,$drg2)");
   $datediff = strtotime($drg1) - strtotime($drg2);
   $result = max(0, floor($datediff/(60*60*24)));
   InsPair($relation,$srcConcept,$srcAtom,$tgtConcept,$result);
   return;
}
?>