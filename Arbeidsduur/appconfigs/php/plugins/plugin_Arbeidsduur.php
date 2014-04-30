<?php 
/* De functie 'datumDelta' kijkt of twee datums een zekere periode uit elkaar liggen,
   en als dat zo is wordt de (gespecificeerde) relatie met die datums gepopuleerd.
   Deze functies zijn nodig voor de applicatie 'Arbeidsduur'.
   Code is deels afgekeken van 'plugin_DateTime.php'

// VOORBEELD:           Naam van de functie
                        |          Naam van de relatie die evt. moet worden gepopuleerd
                        |          |                 Naam van het datum-concept
                        |          |                 |        Eerste datum 
                        |          |                 |        |             Periode tussen de datums
                        |          |                 |        |             |            Tweede datum
                        |          |                 |        |             |            |
   VIOLATION (TXT "{EX} DatumDelta;vierMaandenOfMeer;Datum;", SRC I, TXT ";'4 Months';", TGT I)

   In dit voorbeeld wordt de relatie 'meerDanVierMaanden[Datum*Datum]' gevuld met (SRC I, TGT I) als SRC minstens '4 Months' voor TGT zit.
*/
function DatumDelta($dateRelation,$DateConcept,$srcAtom,$deltaperiod,$tgtAtom)
{ 	emitLog("datumDelta($dateRelation,$DateConcept,$srcAtom,$deltaperiod,$tgtAtom)");
// ExecEngineSays("datumDelta($dateRelation,$DateConcept,$srcAtom,$deltaperiod,$tgtAtom)");
   $dt1 = strtotime($srcAtom);
   if ($dt1 == false) ExecEngineSHOUTS("Illegal date specified in srcAtom (3rd arg): $srcAtom");
   $dtperiod = strtotime($deltaperiod);
   if ($dt1 == false) ExecEngineSHOUTS("Illegal date specified in deltaperiod (4th arg): $deltaperiod");
   $dt2 = strtotime($tgtAtom);
   if ($dt2 == false) ExecEngineSHOUTS("Illegal date specified in tgtAtom (5th arg): $tgtAtom");
// ExecEngineSays ("dt1 = $dt1; dtperiod = $dtperiod; dt2 = $dt2");
   if ($dt1 < $dt2)
   { if ($dt1+$dtperiod < $dt2) 
     { InsPair($dateRelation,$DateConcept,$srcAtom,$DateConcept,$tgtAtom);
// ExecEngineSays("InsPair($dateRelation,$DateConcept,$srcAtom,$DateConcept,$tgtAtom)");
   } }
   return;
}

?>