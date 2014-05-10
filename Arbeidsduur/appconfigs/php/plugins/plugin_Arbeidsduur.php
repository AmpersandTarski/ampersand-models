<?php 
// Deze functies worden aangeroepen vanuit de applicatie 'Arbeidsduur'.

// VIOLATION (TXT "{EX} SetToday;vandaag;Vandaag;VANDAAG;Datum")
function SetToday($relation,$srcConcept,$srcAtom,$tgtConcept)
{ 	emitLog("SetToday($relation,$srcConcept,$srcAtom,$tgtConcept)");
   $curdate = date('d-m-Y');
// Als 'curdate' nog niet in de database bestaat als een instantie van $tgtConcept, dan moet die nog wel worden toegevoegd:
   if(!isAtomInConcept($curdate, $tgtConcept))
   {  addAtomToConcept($curdate, $tgtConcept);
   }
   global $execEngineWhispers; // Defined in 'pluginsettings.php'
   $execEngineWhispers=false;
   InsPair($relation,$srcConcept,$srcAtom,$tgtConcept,$curdate);
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
   global $execEngineWhispers; // Defined in 'pluginsettings.php'
   $execEngineWhispers=false;
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
   global $execEngineWhispers; // Defined in 'pluginsettings.php'
   $execEngineWhispers=false;
// ExecEngineWhispers("SetPeriod: InsPair($relation,$DateConcept,$srcAtom,$DateConcept,$tgtAtom)");
// Als '$tgtAtom' nog niet in de database bestaat als een instantie van $DateConcept, dan moet die nog wel worden toegevoegd:
   if(!isAtomInConcept($tgtAtom, $DateConcept))
   {  addAtomToConcept($tgtAtom, $DateConcept);
   }
   InsPair($relation,$DateConcept,$srcAtom,$DateConcept,$tgtAtom);
   return;
}

?>