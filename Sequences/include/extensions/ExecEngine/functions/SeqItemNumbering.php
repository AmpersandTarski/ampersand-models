<?php
// SeqItemNumbering functions

function sinComputeItemValue($relation,$srcConcept,$srcAtom,$tgtConcept,$predSinValue)
	{   Notifications::addLog("sinComputeItemValue($relation,$srcConcept,$srcAtom,$tgtConcept,$predSinValue)",'MESSAGING');
		$predSinValue++; // See http://php.net/manual/en/language.operators.increment.php for the details.
		Notifications::addLog("Doing InsPair with ($relation,$srcConcept,$srcAtom,$tgtConcept,$predSinValue)",'MESSAGING');
		InsPair($relation,$srcConcept,$srcAtom,$tgtConcept,$predSinValue);
		Notifications::addLog("Done)",'MESSAGING');
	}

function sinComputeItemText($relation,$srcConcept,$srcAtom,$tgtConcept,$prefix,$itemSinValue,$postfix)
	{   Notifications::addLog("sinComputeItemText($relation,$srcConcept,$srcAtom,$tgtConcept,$prefix,$itemSinValue,$postfix)",'MESSAGING');
	    $tgtAtom = $itemSinValue;
	    Notifications::addLog("tgtAtom[1] = $tgtAtom",'MESSAGING');
	    if ($prefix != '_NULL') $tgtAtom = $prefix.$tgtAtom;
	    Notifications::addLog("tgtAtom[2] = $tgtAtom",'MESSAGING');
	    if ($postfix != '_NULL') $tgtAtom = $tgtAtom.$postfix;
	    Notifications::addLog("tgtAtom[3] = $tgtAtom",'MESSAGING');
		InsPair($relation,$srcConcept,$srcAtom,$tgtConcept,$tgtAtom);
	    Notifications::addLog("InsPair($relation,$srcConcept,$srcAtom,$tgtConcept,$tgtAtom)",'MESSAGING');
	}
?>