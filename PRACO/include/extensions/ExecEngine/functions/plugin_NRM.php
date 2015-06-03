<?php 
// Use:  VIOLATION (TXT "{EX} Increment;<relation>;<srcConcept>;<srcAtom>;<tgtConcept>;<tgtAtom>")
// This function increments tgtAtom, setting it to '1' if it does not exist.
function Increment($relation,$srcConcept,$srcAtom,$tgtConcept,$tgtAtom)
{  if ($tgtAtom === "") $tgtAtom=0;
   $tgtAtom = $tgtAtom + 1;
   InsPair($relation,$srcConcept,$srcAtom,$tgtConcept,$tgtAtom);
   return;
}

// Use:  VIOLATION (TXT "{EX} Decrement;<relation>;<srcConcept>;<srcAtom>;<tgtConcept>;<tgtAtom>")
// This function decrements tgtAtom, logging an error if it does not exist or drops below zero.
function Decrement($relation,$srcConcept,$srcAtom,$tgtConcept,$tgtAtom)
{  if ($tgtAtom === "") $tgtAtom=0;
   if ($tgtAtom < 1) throw new Exception ("Decrement below zero: $relation, $srcConcept, $srcAtom, $tgtConcept, $tgtAtom");
   $tgtAtom = $tgtAtom - 1;
   InsPair($relation,$srcConcept,$srcAtom,$tgtConcept,$tgtAtom);
   return;
}

// Use:  VIOLATION (TXT "{EX} Percentage;<relation>;<srcConcept>;<srcAtom>;<tgtConcept>;<teller>;<noemer>")
// This function computers 100*<teller>/<noemer>
function Percentage($relation,$srcConcept,$srcAtom,$tgtConcept,$teller,$noemer)
{  if ($noemer == 0) throw new Exception ("Cannot divide by zero: $teller, $noemer");
   $tgtAtom = number_format((100*$teller) / $noemer, 0);
   InsPair($relation,$srcConcept,$srcAtom,$tgtConcept,$tgtAtom);
   return;
}

?>
