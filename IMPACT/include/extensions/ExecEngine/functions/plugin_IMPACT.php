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
?>
