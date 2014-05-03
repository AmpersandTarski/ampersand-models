<?php 
// Deze functies worden aangeroepen vanuit de applicatie 'Arbeidsduur'.

// VIOLATION (TXT "{EX} SetToday;vandaag;Datum")
function SetToday($relation,$Concept)
{ 	emitLog("SetToday($relation,$Concept)");
// Zorg dat $relation slechts 1 link bevat.
   global $curdate;
   if ($curdate == date('d-m-Y')) return; // No need to update relation if it's done already
   if ($curdate) // If we're here, and there is a $curdate, it is not equal to today's date.
   { ExecEngineWhispers("SetToday: DelPair($relation,$Concept,$curdate,$Concept,$curdate)");
// Eigenlijk zou nou de hele tabel $relation weggegooid moeten worden, maar we nemen gemakshalve aan dat er maar 1 link in staat, en wel ($curdate, $curdate).
     DelPair($relation,$Concept,$curdate,$Concept,$curdate); // so we should delete it.
   } 
   $curdate = date('d-m-Y'); // Set $curdate to today's date
   ExecEngineWhispers("SetToday: InsPair($relation,$Concept,$curdate,$Concept,$curdate)");
   InsPair($relation,$Concept,$curdate,$Concept,$curdate); // and store it in the database
   return;
}

// VIOLATION (TXT "{EX} dateGTE;gdga;Datum;" SRC I, TXT ";", TGT I)
function dateGTE($relation,$DateConcept,$srcAtom,$tgtAtom)
{ 	emitLog("dateGTE($relation,$DateConcept,$srcAtom,$tgtAtom)");
   if (($dt1 = strtotime($srcAtom)) === false) ExecEngineSHOUTS("dateGTE: Illegal date $dt1 specified in srcAtom (3rd arg): $srcAtom");
   if (($dt2 = strtotime($tgtAtom)) === false) ExecEngineSHOUTS("dateGTE: Illegal date $dt2 specified in tgtAtom (4th arg): $tgtAtom");
   if ($dt1 >= $dt2) InsPair($relation,$DateConcept,$srcAtom,$DateConcept,$tgtAtom);
   if ($dt2 >  $dt1) InsPair($relation,$DateConcept,$tgtAtom,$DateConcept,$srcAtom);
   return;
}

/* De functie 'datumDelta' kijkt of twee datums een zekere periode uit elkaar liggen,
   en ALLEEN als dat zo is wordt de (gespecificeerde) relatie met die datums gepopuleerd.

// VOORBEELD:           
   Naam van de relatie die evt. moet worden gepopuleerd
                                   |    Naam van het datum-concept
                                   |                 |   Eerste datum 
                                   |                 |        |  Periode tussen de datums
                                   |                 |        |             |       Tweede datum
                                   |                 |        |             |            |
   VIOLATION (TXT "{EX} DatumDelta;vierMaandenOfMeer;Datum;", SRC I, TXT ";-4 Months;", TGT I)

   In dit voorbeeld wordt de relatie 'meerDanVierMaanden[Datum*Datum]' gevuld met (SRC I, TGT I) als SRC minstens '4 Months' voor TGT zit (gebruik '+4 Months' om 4 maanden na TGT te zitten).
*/
function DatumDelta($dateRelation,$DateConcept,$srcAtom,$deltaperiod,$tgtAtom)
{ 	emitLog("datumDelta($dateRelation,$DateConcept,$srcAtom,$deltaperiod,$tgtAtom)");
   if (($dt1 = strtotime($srcAtom)) === false) ExecEngineSHOUTS("DatumDelta: Illegal date $dt1 specified in srcAtom (3rd arg): $srcAtom");
   if (($dt2 = strtotime($tgtAtom)) === false) ExecEngineSHOUTS("DatumDelta: Illegal date $dt2 specified in tgtAtom (5th arg): $tgtAtom");
   if ($dt1 >= $dt2) ExecEngineSHOUTS("DatumDelta: srcAtom (3rd arg) $srcAtom must be smaller than tgtAtom (5th arg) $tgtAtom");
   if (($dt3 = strtotime ($srcAtom . $deltaperiod)) === false) ExecEngineSHOUTS("DatumDelta: Illegal period $dt3 specified as period (4th arg): $deltaperiod");
// ExecEngineWhispers ("DatumDelta: dt1 = ".date('d-m-Y', $dt1)."; dt2 = ".date('d-m-Y', $dt2)."; dt3 = ".date('d-m-Y', $dt3));
// ExecEngineWhispers ("DatumDelta: 'InsPair' mag alleen als ".date('d-m-Y', $dt3)." voor $tgtAtom ligt.");
   if ($dt3 < $dt2) // i.e.: if SRC date + Period < TGT date, add (srcdate, tgtdate) to relation
   { ExecEngineWhispers("DatumDelta: InsPair($dateRelation,$DateConcept,$srcAtom,$DateConcept,$tgtAtom)");
     InsPair($dateRelation,$DateConcept,$srcAtom,$DateConcept,$tgtAtom);
   }
   return;
}

// VIOLATION (TXT "{EX} SetPeriod;eenMaandVoordien;Datum;-1 Month;", SRC I)
function SetPeriod($relation,$DateConcept,$srcAtom,$Period)
{ 	emitLog("SetPeriod($relation,$DateConcept,$srcAtom,$Period)");
// Insert the pair ($srcAtom,$srcAtom + $period) into $relation
   if (($dt1 = strtotime($srcAtom)) === false) ExecEngineSHOUTS("SetPeriod: Illegal date $dt1 specified in srcAtom (3rd arg): $srcAtom");
   if (($dt3 = strtotime ($srcAtom . $Period)) === false) ExecEngineSHOUTS("SetPeriod: Illegal period $dt3 specified as period (4th arg): $Period");
   $tgtAtom = date('d-m-Y', $dt3);
   ExecEngineWhispers("SetPeriod: InsPair($relation,$DateConcept,$srcAtom,$DateConcept,$tgtAtom)");
   InsPair($relation,$DateConcept,$srcAtom,$DateConcept,$tgtAtom);
   return;
}

?>