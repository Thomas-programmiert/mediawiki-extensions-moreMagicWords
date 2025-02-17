<?php

class moreMagicWords {

	/**
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ParserGetVariableValueSwitch
     * assign value to magic words
	 *
	 * @param Parser $parser
	 * @param array &$variableCache - reference to array of already used variable magic words on a page
	 * @param string $magicWord - magic word to be handled
	 * @param ?string &$ret - null or reference to "return value" value that will replace the magic word
	 */
	static function onParserGetVariableValueSwitch( Parser $parser, &$variableCache, string $magicWord, ?string &$ret ) {

        if ( $magicWord === 'CONTENTMODEL' ) {	
			// read from cache if {{CONTENTMODEL}} was used on page previously
			if ( isset( $variableCache['CONTENTMODEL'] ) ) {
				$ret = $variableCache['CONTENTMODEL'];
				return true;
			}
			
			// fetch content model
            $page = MediaWiki\MediaWikiServices::getInstance()->getWikiPageFactory()->newFromTitle( $parser->getTitle() );
			$ret = $page ? $page->getContentModel() : 'unknown';
			$variableCache['CONTENTMODEL'] = $ret;
            return true;
        }
		return false;
	}

	/**
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/GetMagicVariableIDs
     * register {{CONTENTMODEL}} as a variable and not some other type of magic word
	 *
	 * @param aCustomVariableIds array of existing magic words that are custom variables
	 */
	static function onGetMagicVariableIDs( &$aCustomVariableIds  ) {
		$aCustomVariableIds [] = 'CONTENTMODEL' ;
		return true;
	}
}