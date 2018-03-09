<?php
use Ampersand\Log\Logger;
use Ampersand\Rule\ExecEngine;

// Following function parses $parsetext, splitting it into text-sections and placeholders (TText names).
// {EX} ParsePhraseForPlaceholders;ttPlaceholders;TText;", SRC I, TXT ";TTName;", SRC ttTemplate
ExecEngine::registerFunction('ParsePhraseForPlaceholders', 
    function ($rel // the relation name that contains the placeholder names
			,$SrcConcept // the SRC concept of $rel (i.e. TText)
			,$SrcAtom    // the (TText) Atom whose template text is to be parsed
			,$TgtConcept // the TGT concept of $rel (i.e. TTName)
			,$parsetext  // the template text that needs to be parsed
			)
{
    Logger::getLogger('EXECENGINE')->debug("-- ParsePhraseForPlaceholders($rel,$SrcConcept,$SrcAtom,$TgtConcept,$parsetext)");
    $placeholders = array();
    while (strlen($parsetext)) // Parse the remainder of the template text until it is empty.
	{ 	if ($parsetext[0] == '[') // Found a placeholder (i.e. the TTName of some TText)
		{	// handle placeholder
			if (strpos($parsetext, ']') === false) break; // Placeholders are terminated with a ']' character
			$chars = substr($parsetext, 1, strpos($parsetext, ']')-1); // the name of the TText is within '[' and ']'.
			$parsetext = substr($parsetext, strpos($parsetext, ']')+1); // set the remainder of the text to be parsed
 //			Logger::getLogger('EXECENGINE')->debug("ParsePhraseForPlaceholders - create VAR item $chars");
            if (!in_array($chars, $placeholders))
            {  $placeholders[] = $chars; 
			   ExecEngine::getFunction('InsPair')($rel,$SrcConcept,$SrcAtom,$TgtConcept,$chars);
			}
		} else
		{	// handle non-placeholder texts
			$charspos = strpos($parsetext,'['); // see if there is a placeholder in the (remaining) text.
			if ($charspos) // get the text up to the end or the next placeholder
			{	$chars = substr($parsetext, 0, $charspos);
			}else
			{	$chars = substr($parsetext, 0);
			}
			$parsetext = substr($parsetext, strlen($chars)); // set the remainder of the text to be parsed
		}
	}
//	Logger::getLogger('EXECENGINE')->debug("ParsePhraseForPlaceholders ------ done ------");
	return;

});

// Following function populates `ttParsedType` with a `Concept` if that is specified in `ttName`
// {EX} ParseTTName;ttParsedType;TText;", SRC I, TXT ";Concept;", TGT I
ExecEngine::registerFunction('ParseTTName', 
	function ($rel        // the relation name that contains the parsed type/concept
             ,$SrcConcept // the SRC concept of $rel (i.e. TText)
             ,$SrcAtom    // the (TText) Atom whose template text is to be parsed
             ,$TgtConcept // the TGT concept of $rel (i.e. Concept)
             ,$parsetext  // the TTName text that needs to be parsed
             )
{	Logger::getLogger('EXECENGINE')->debug("-- ParseTTName($rel,$SrcConcept,$SrcAtom,$TgtConcept,$parsetext)");
	$charspos = strpos($parsetext,':'); // Get the position of the separator
	if ($charspos >= 1) // Concept name must have at least one char
	{	$chars = substr($parsetext, 0, $charspos);
 //		Logger::getLogger('EXECENGINE')->debug("ParseTTName - found Concept item $chars");
		ExecEngine::getFunction('InsPair')($rel,$SrcConcept,$SrcAtom,$TgtConcept,$chars);
	}
//	Logger::getLogger('EXECENGINE')->debug("ParseTTName ------ done ------");
	return;
});

//VIOLATION (TXT "{EX}_;ReplacePlaceholdersInTTextInstance"
//                     ,TXT "_;", TGT I           -- TText source atom for ttInstance
//                     ,TXT "_;", TGT ttInstance  -- string in which the replacements should take place
//                     ,TXT "_;", SRC ttName      -- placeholder that needs to be replaced
//                     ,TXT "_;", SRC ttValue     -- value by which to replace the placeholders
//          )
ExecEngine::registerFunction('ReplacePlaceholdersInTTextInstance', 
	function ($SrcAtom     // the (TText) Atom
             ,$string      // string in which the replacements should be made, and that should be stored as target atom
             ,$placeholder // text to search for/to replace all occurences of
             ,$value       // text by which the needle is to be replaced
             )
{	Logger::getLogger('EXECENGINE')->debug("-- ReplacePlaceholdersInTTextInstance($SrcAtom,$string,$placeholder,$value)");
    $string = str_replace('['.$placeholder.']', $value, $string);
	ExecEngine::getFunction('InsPair')('ttInstance','TText',$SrcAtom,'TTPhrase',$string);
	return;
});
