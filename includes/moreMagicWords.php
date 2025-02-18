<?php

namespace MediaWiki\Extension\moreMagicWords;

use MediaWiki\Hook\ParserGetVariableValueSwitchHook;
use MediaWiki\Hook\GetMagicVariableIDsHook;
use MediaWiki\MediaWikiServices;

class moreMagicWords implements ParserGetVariableValueSwitchHook, GetMagicVariableIDsHook {
	/**
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ParserGetVariableValueSwitch
     * assign value to magic words
	 *
	 * @param $parser
	 * @param &$variableCache - reference to array of already used variable magic words on a page
	 * @param $magicWord - magic word to be handled
	 * @param &$ret - null or reference to "return value" value that will replace the magic word
	 * @param $frame - unused
	 */
    public function onParserGetVariableValueSwitch( $parser, &$variableCache, $magicWordId, &$ret, $frame ) {
        if ( $magicWordId === 'CONTENTMODEL' ) {	
			// read from cache if {{CONTENTMODEL}} was used on page previously
			if ( isset( $variableCache['CONTENTMODEL'] ) ) {
				$ret = $variableCache['CONTENTMODEL'];
				return;
			}
			
			// fetch content model
            $page = MediaWikiServices::getInstance()->getWikiPageFactory()->newFromTitle( $parser->getTitle() );
			$ret = $page ? $page->getContentModel() : 'unknown';
			$variableCache['CONTENTMODEL'] = $ret;
            return;
        }
		return;
    }

	/**
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/GetMagicVariableIDs
     * register {{CONTENTMODEL}} as a variable and not some other type of magic word
	 *
	 * @param aCustomVariableIds array of existing magic words that are custom variables
	 */
	public function onGetMagicVariableIDs( &$aCustomVariableIds  ) {
		$aCustomVariableIds [] = 'CONTENTMODEL' ;
		return;
	}
}
