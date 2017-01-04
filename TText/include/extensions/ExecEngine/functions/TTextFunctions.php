<?php
use Ampersand\Log\Logger;

// Following function parses $parsetext, splitting it into text-sections and TText names.
// {EX} ParseTemplatePhrase;ttPlaceholders;ttIsUsedBy;", SRC I, TXT ";ttPlaceholder;", TGT I
function ParseTemplatePhrase($rel        // the relation name that will contain the placeholder names
                            ,$SrcConcept // the SRC concept of said relation
                            ,$CritAtom   // the criterion-atom of which the text is to be parsed
                            ,$TgtConcept // the TGT concept of said relation
                            ,$parsetext  // the criterion-text to be parsed
                            )
{	Logger::getLogger('EXECENGINE')->debug("-- ParseTemplatePhrase($rel,$SrcConcept,$CritAtom,$TgtConcept,$parsetext)");
	$itemizedText = $parsetext;
    while (strlen($parsetext))
	{ 	if ($parsetext[0] == '[') // Customize the Item as either a TText or a text
		{	// handle TText-names
			if (strpos($parsetext, ']') === false) break; // TText names must be properly terminated with a ']' character
			$chars = substr($parsetext, 1, strpos($parsetext, ']')-1); // the name of the TText is within '[' and ']'.
			$parsetext = substr($parsetext, strpos($parsetext, ']')+1); // set the remainder of the text to be parsed
 //			Logger::getLogger('EXECENGINE')->debug("ParseTemplatePhrase - create VAR item $chars");
			InsPair($rel,$SrcConcept,$CritAtom,$TgtConcept,$chars);
		} else
		{	// handle phrase-texts
			$charspos = strpos($parsetext,'[');
			if ($charspos) // get the text up to the end or the next TText
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