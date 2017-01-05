<?php
use Ampersand\Log\Logger;

// Following function parses $parsetext, splitting it into text-sections and placeholders (TText names).
// {EX} ParseTemplatePhrase;ttPlaceholders;TText;", SRC I, TXT ";TTName;", SRC ttTemplate
function ParseTemplatePhrase($rel        // the relation name that contains the placeholder names
                            ,$SrcConcept // the SRC concept of $rel (i.e. TText)
                            ,$SrcAtom    // the (TText) Atom whose template text is to be parsed
                            ,$TgtConcept // the TGT concept of $rel (i.e. TTName)
                            ,$parsetext  // the template text that needs to be parsed
                            )
{	Logger::getLogger('EXECENGINE')->debug("-- ParseTemplatePhrase($rel,$SrcConcept,$SrcAtom,$TgtConcept,$parsetext)");
    while (strlen($parsetext)) // Parce the remainder of the template text until it is empty.
	{ 	if ($parsetext[0] == '[') // Found a placeholder (i.e. the TTName of some TText)
		{	// handle placeholder
			if (strpos($parsetext, ']') === false) break; // Placeholders are terminated with a ']' character
			$chars = substr($parsetext, 1, strpos($parsetext, ']')-1); // the name of the TText is within '[' and ']'.
			$parsetext = substr($parsetext, strpos($parsetext, ']')+1); // set the remainder of the text to be parsed
 //			Logger::getLogger('EXECENGINE')->debug("ParseTemplatePhrase - create VAR item $chars");
			InsPair($rel,$SrcConcept,$SrcAtom,$TgtConcept,$chars);
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
//	Logger::getLogger('EXECENGINE')->debug("ParseTemplatePhrase ------ done ------");
	return;
}

?>