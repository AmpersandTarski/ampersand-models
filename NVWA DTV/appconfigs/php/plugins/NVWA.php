<?php 
/* COMPARING DATES AND TIMES for use within NVWA

>> EXAMPLE OF USE:
   -- First, you define the relations you want to compute
   RELATION leqDatum[Datum*Datum] [RFX,ASY,TRN,AUT] PRAGMA "" " ligt op of gaat vooraf aan "
   RELATION geqDatum[Datum*Datum] [RFX,ASY,TRN,AUT] PRAGMA "" " ligt op of volgt op "

   -- Then, you define the rules that populate these relations   
   ROLE ExecEngine MAINTAINS "Automatically ccompute date comparison relations"
   RULE "Automatically ccompute date comparison relations": V[Datum] |- leqDatum \/ geqDatum
   VIOLATION (TXT "{EX} dateLEQ;leqDatum;Datum;", SRC I, TXT ";", TGT I
             ,TXT "{EX} dateGEQ;geqDatum;Datum;", SRC I, TXT ";", TGT I
             )
            
>> LIMITATIONS OF USE:
1) If you use many atoms in DateTime, this will take increasingly
   more time to check for violations. So do not use that many...
   
2) Dates in the m/d/y or d-m-y formats are disambiguated by looking
   at the separator between the various components: if the separator
   is a slash (/), then the American m/d/y is assumed; whereas if
   the separator is a dash (-) or a dot (.), then the European 
   d-m-y format is assumed.
*/
// VIOLATION (TXT "{EX} dateLEQ;Datum;" SRC I, TXT ";", TGT I)
function dateLEQ($relation,$DateConcept,$srcAtom,$tgtAtom)
{  emitLog("dateLEQ($relation,$DateConcept,$srcAtom,$tgtAtom)");
   if (($dt1 = strtotime($srcAtom)) === false) ExecEngineSHOUTS("dateLEQ: Illegal date $dt1 specified in srcAtom (3rd arg): $srcAtom");
   if (($dt2 = strtotime($tgtAtom)) === false) ExecEngineSHOUTS("dateLEQ: Illegal date $dt2 specified in tgtAtom (4th arg): $tgtAtom");
   global $execEngineWhispers; // Defined in 'pluginsettings.php'
   $execEngineWhispers=false;
   if ($dt1 <= $dt2)
   { InsPair($relation,$DateConcept,$srcAtom,$DateConcept,$tgtAtom);
   }
   return;
}

// VIOLATION (TXT "{EX} dateGEQ;Datum;" SRC I, TXT ";", TGT I)
function dateGEQ($relation,$DateConcept,$srcAtom,$tgtAtom)
{  emitLog("dateGEQ($relation,$DateConcept,$srcAtom,$tgtAtom)");
   if (($dt1 = strtotime($srcAtom)) === false) ExecEngineSHOUTS("dateGEQ: Illegal date $dt1 specified in srcAtom (3rd arg): $srcAtom");
   if (($dt2 = strtotime($tgtAtom)) === false) ExecEngineSHOUTS("dateGEQ: Illegal date $dt2 specified in tgtAtom (4th arg): $tgtAtom");
   global $execEngineWhispers; // Defined in 'pluginsettings.php'
   $execEngineWhispers=false;
   if ($dt1 >= $dt2)
   { InsPair($relation,$DateConcept,$srcAtom,$DateConcept,$tgtAtom);
   echo("dateGEQ: $dt1 >= $dt2 </br>");
   }
   return;
}

// VIOLATION (TXT "{EX} dateLT;Datum;" SRC I, TXT ";", TGT I)
function dateLT($relation,$DateConcept,$srcAtom,$tgtAtom)
{  emitLog("dateLT($relation,$DateConcept,$srcAtom,$tgtAtom)");
   if (($dt1 = strtotime($srcAtom)) === false) ExecEngineSHOUTS("dateLT: Illegal date $dt1 specified in srcAtom (3rd arg): $srcAtom");
   if (($dt2 = strtotime($tgtAtom)) === false) ExecEngineSHOUTS("dateLT: Illegal date $dt2 specified in tgtAtom (4th arg): $tgtAtom");
   global $execEngineWhispers; // Defined in 'pluginsettings.php'
   $execEngineWhispers=false;
   if ($dt1 < $dt2)
   { InsPair($relation,$DateConcept,$srcAtom,$DateConcept,$tgtAtom);
   }
   return;
}

// VIOLATION (TXT "{EX} dateGT;Datum;" SRC I, TXT ";", TGT I)
function dateGT($relation,$DateConcept,$srcAtom,$tgtAtom)
{  emitLog("dateGT($relation,$DateConcept,$srcAtom,$tgtAtom)");
   if (($dt1 = strtotime($srcAtom)) === false) ExecEngineSHOUTS("dateGT: Illegal date $dt1 specified in srcAtom (3rd arg): $srcAtom");
   if (($dt2 = strtotime($tgtAtom)) === false) ExecEngineSHOUTS("dateGT: Illegal date $dt2 specified in tgtAtom (4th arg): $tgtAtom");
   global $execEngineWhispers; // Defined in 'pluginsettings.php'
   $execEngineWhispers=false;
   if ($dt1 > $dt2)
   { InsPair($relation,$DateConcept,$srcAtom,$DateConcept,$tgtAtom);
   }
   return;
}

// VIOLATION (TXT "{EX} timeofdayGEQ;Tijdstip;" SRC I, TXT ";", TGT I)
function timeofdayGEQ($relation,$TimeofdayConcept,$srcAtom,$tgtAtom)
{  emitLog("timeofdayGEQ($relation,$TimeofdayConcept,$srcAtom,$tgtAtom)");
   if (($dt1 = strtotime($srcAtom)) === false) ExecEngineSHOUTS("timeofdayGEQ: Illegal timeofday $dt1 specified in srcAtom (3rd arg): $srcAtom");
   if (($dt2 = strtotime($tgtAtom)) === false) ExecEngineSHOUTS("timeofdayGEQ: Illegal timeofday $dt2 specified in tgtAtom (4th arg): $tgtAtom");
   global $execEngineWhispers; // Defined in 'pluginsettings.php'
   $execEngineWhispers=false;
   if ($dt1 >= $dt2)
   { InsPair($relation,$TimeofdayConcept,$srcAtom,$TimeofdayConcept,$tgtAtom);
   }
   return;
}

// VIOLATION (TXT "{EX} timeofdayLT;Tijdstip;" SRC I, TXT ";", TGT I)
function timeofdayLT($relation,$TimeofdayConcept,$srcAtom,$tgtAtom)
{  emitLog("timeofdayLT($relation,$TimeofdayConcept,$srcAtom,$tgtAtom)");
   if (($dt1 = strtotime($srcAtom)) === false) ExecEngineSHOUTS("timeofdayLT: Illegal timeofday $dt1 specified in srcAtom (3rd arg): $srcAtom");
   if (($dt2 = strtotime($tgtAtom)) === false) ExecEngineSHOUTS("timeofdayLT: Illegal timeofday $dt2 specified in tgtAtom (4th arg): $tgtAtom");
   global $execEngineWhispers; // Defined in 'pluginsettings.php'
   $execEngineWhispers=false;
   if ($dt1 < $dt2)
   { InsPair($relation,$TimeofdayConcept,$srcAtom,$TimeofdayConcept,$tgtAtom);
   }
   return;
}

// VIOLATION (TXT "{EX} timeofdayGT;Tijdstip;" SRC I, TXT ";", TGT I)
function timeofdayGT($relation,$TimeofdayConcept,$srcAtom,$tgtAtom)
{  emitLog("timeofdayGT($relation,$TimeofdayConcept,$srcAtom,$tgtAtom)");
   if (($dt1 = strtotime($srcAtom)) === false) ExecEngineSHOUTS("timeofdayGT: Illegal timeofday $dt1 specified in srcAtom (3rd arg): $srcAtom");
   if (($dt2 = strtotime($tgtAtom)) === false) ExecEngineSHOUTS("timeofdayGT: Illegal timeofday $dt2 specified in tgtAtom (4th arg): $tgtAtom");
   global $execEngineWhispers; // Defined in 'pluginsettings.php'
   $execEngineWhispers=false;
   if ($dt1 > $dt2)
   { InsPair($relation,$TimeofdayConcept,$srcAtom,$TimeofdayConcept,$tgtAtom);
   }
   return;
}

?>