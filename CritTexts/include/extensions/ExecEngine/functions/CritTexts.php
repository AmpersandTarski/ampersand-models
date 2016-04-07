<?php
use Ampersand\Log\Logger;

function ParseCritText ($rel        // the relation name that will contain the VarNames
                       ,$SrcConcept // the SRC concept of said relation
                       ,$CritAtom   // the criterion-atom of which the text is to be parsed
                       ,$TgtConcept // the TGT concept of said relation
                       ,$parsetext  // the criterion-text to be parsed
                       )
{	// Logger::getLogger('EXECENGINE')->debug("ParseCritText($rel,$SrcConcept,$CritAtom,$TgtConcept,$parsetext)");
	$itemizedText = $parsetext;
    while (strlen($parsetext))
	{ 	if ($parsetext[0] == '[') // Customize the Item as either a variable or a text
		{	// handle variable-names
			if (strpos($parsetext, ']') === false) break; // variable names must be properly terminated with a ']' character
			$chars = substr($parsetext, 1, strpos($parsetext, ']')-1); // the name of the variable is within '[' and ']'.
			$parsetext = substr($parsetext, strpos($parsetext, ']')+1); // set the remainder of the text to be parsed
 //			Logger::getLogger('EXECENGINE')->debug("ParseCritText - create VAR item $chars");
			InsPair($rel,$SrcConcept,$CritAtom,$TgtConcept,$chars);
		} else
		{	// handle phrase-texts
			$charspos = strpos($parsetext,'[');
			if ($charspos) // get the text up to the end or the next variable
			{	$chars = substr($parsetext, 0, $charspos);
			}else
			{	$chars = substr($parsetext, 0);
			}
			$parsetext = substr($parsetext, strlen($chars)); // set the remainder of the text to be parsed
		}
	}
//	Logger::getLogger('EXECENGINE')->debug("ParseCritText ------ done ------");
	return;
}
?>