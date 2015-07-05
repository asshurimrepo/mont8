<?php

class ffLessVariableParser extends ffBasicObject {
################################################################################
# CONSTANTS
################################################################################
	const TYPE_COLOR = 'type_color';
################################################################################
# PRIVATE OBJECTS
################################################################################
	
################################################################################
# PRIVATE VARIABLES	
################################################################################	
	private $_content = null;
################################################################################
# CONSTRUCTOR
################################################################################	

################################################################################
# ACTIONS
################################################################################
	
################################################################################
# PUBLIC FUNCTIONS
################################################################################	

	/* Original from : http://www.w3schools.com/cssref/css_colornames.asp */
	private $_possibleStringCollors = array( 'aliceblue', 'antiquewhite', 'aqua', 'aquamarine', 'azure', 'beige', 'bisque', 'black',
			'blanchedalmond', 'blue', 'blueviolet', 'brown', 'burlywood', 'cadetblue', 'chartreuse', 'chocolate', 'coral',
			'cornflowerblue', 'cornsilk', 'crimson', 'cyan', 'darkblue', 'darkcyan', 'darkgoldenrod', 'darkgray', 'darkgreen',
			'darkkhaki', 'darkmagenta', 'darkolivegreen', 'darkorange', 'darkorchid', 'darkred', 'darksalmon', 'darkseagreen',
			'darkslateblue', 'darkslategray', 'darkturquoise', 'darkviolet', 'deeppink', 'deepskyblue', 'dimgray', 'dodgerblue',
			'firebrick', 'floralwhite', 'forestgreen', 'fuchsia', 'gainsboro', 'ghostwhite', 'gold', 'goldenrod', 'gray', 'green',
			'greenyellow', 'honeydew', 'hotpink', 'indianred ', 'indigo ', 'ivory', 'khaki', 'lavender', 'lavenderblush', 'lawngreen',
			'lemonchiffon', 'lightblue', 'lightcoral', 'lightcyan', 'lightgoldenrodyellow', 'lightgray', 'lightgreen', 'lightpink',
			'lightsalmon', 'lightseagreen', 'lightskyblue', 'lightslategray', 'lightsteelblue', 'lightyellow', 'lime', 'limegreen',
			'linen', 'magenta', 'maroon', 'mediumaquamarine', 'mediumblue', 'mediumorchid', 'mediumpurple', 'mediumseagreen',
			'mediumslateblue', 'mediumspringgreen', 'mediumturquoise', 'mediumvioletred', 'midnightblue', 'mintcream', 'mistyrose',
			'moccasin', 'navajowhite', 'navy', 'oldlace', 'olive', 'olivedrab', 'orange', 'orangered', 'orchid', 'palegoldenrod',
			'palegreen', 'paleturquoise', 'palevioletred', 'papayawhip', 'peachpuff', 'peru', 'pink', 'plum', 'powderblue', 'purple',
			'red', 'rosybrown', 'royalblue', 'saddlebrown', 'salmon', 'sandybrown', 'seagreen', 'seashell', 'sienna', 'silver', 'skyblue',
			'slateblue', 'slategray', 'snow', 'springgreen', 'steelblue', 'tan', 'teal', 'thistle', 'tomato', 'turquoise', 'violet',
			'wheat', 'white', 'whitesmoke', 'yellow', 'yellowgreen',
	);
	
	/**
	 * return input type by value in bootstrap variable file
	 * @param  string $value devined value
	 * @return string        one of ffOneOption type constants
	*/
	public function getTypeByValue( $value ){
	
		$value = trim( $value );
	
		// Special case - color with name:
		if( in_array( strtolower($value) , $this->_possibleStringCollors ) ){
			return ffLessVariableParser::TYPE_COLOR;
		}
	
		$types_pattern = array(
				ffLessVariableParser::TYPE_COLOR => array(
						// rgb ( 1, 2, 3 )
						'/^rgb\s*\(\s*[0-9]{1,3}\s*\,\s*[0-9]{1,3}\s*\,\s*[0-9]{1,3}\s*\)$/mUi' ,
	
						// rgba ( 1, 2, 3, .5 )
						'/^rgba\s*\((\s*[0-9]{1,3}\s*\,){3}\s*[01]?\.[0-9]{1,}\s*\)$/mUi' ,
	
						// #123 or #AbC
						'/^\#[0-9a-f]{3}$/mUi' ,
	
						// #123456 or #AbCdEf
						'/^\#[0-9a-f]{6}$/mUi' ,
	
						// lighten( #000 , 60% )
						// lighten(,)
						'/^lighten\s*\([^\)]*,[^\)]*\)$/mUi' ,
	
						// darken( #000 , 60% )
						// darken(,)
						'/^darken\s*\([^\)]*,[^\)]*\)$/mUi' ,
				) ,
		);
	
		foreach ($types_pattern as $ffOneOption_TYPE => $patterns) {
			foreach ($patterns as $single_pattern) {
				if( 1 === preg_match( $single_pattern, $value ) ){
					return $ffOneOption_TYPE;
				}
			}
		}
	
		//return ffOneOption::TYPE_TEXT;
		return '';
	}
	
 	public function getLessVariablesFromString( $text ) {
 		$combined = $this->getLessVariablesFromStringWithReferences($text);

 		$this->_currentVariables = $combined;
 		$this->_removeReferencesFromVariables();
 		$this->_removeOtherVariablesThanColors();
 		
 		$currentVariables = $this->_currentVariables;
 		$this->_currentVariables = null;
 		
 		return $currentVariables;
 	}
 	
 	public function getReferenceChainFromString( $text ) {
 		$lessVariables = $this->getLessVariablesFromStringWithReferences($text);
		 		
 		$variablesChainArray = array();
 		foreach( $lessVariables as $oneVarName => $oneVarValue ) {
 			$result = $this->_getVariableReferences($lessVariables, $oneVarName );
 			
 			if( !empty( $result )) {
 				$variablesChainArray[] = $result . $oneVarName;//$oneVarName.','. substr($result,0,-1);
 			}
 		}
 		
 		$bannedVariables = array();
 		
 		foreach( $variablesChainArray as $oneChain ) {
 			$exploded = explode(',', $oneChain);
 			
 			for( $i = 0; $i< count( $exploded); $i++ ) {
 				$first = array_shift( $exploded );
 				
 				foreach( $exploded as $variableName ) {
 					if( !isset( $bannedVariables[ $first ] ) || !in_array($variableName, $bannedVariables[ $first ] )) {
 						$bannedVariables[ $first ][] = $variableName;
 					}
 				}
 			}
 		}
 		return $bannedVariables;
 	}
 	
 	private function _getVariableReferences( $lessVariables, $oneVariable, $string = '', $isFirst = true ) {
 		
 	
 		if( !isset( $lessVariables[ $oneVariable ] ) ){
 			return;
 		}
 		$oneVariableValue = $lessVariables[ $oneVariable ];
 		 
 		if( $oneVariableValue[0] == '@' ) {
 			$string = $oneVariableValue . ',' . $string;
 			$string = $this->_getVariableReferences($lessVariables, $oneVariableValue, $string, false);
 		} 
 		
 		return $string;
 	}
 	
 	public function getLessVariablesFromStringWithReferences( $text ) {
 		$parsedVariables = array();
 		
 		preg_match_all("/(\@[^\:\;\s]*)\:\s*([^\s]*)\s*;/mU", $text, $parsedVariables);
 			
 		$combined = array_combine( $parsedVariables[1], $parsedVariables[2]);
 		
 		return $combined;
 	}
################################################################################
# PRIVATE FUNCTIONS
################################################################################
 	private function _removeReferencesFromVariables() {
 		foreach( $this->_currentVariables as $name => $value ) {
 			if( $value[0] == '@' ) {
 				$originalVariableValue = $this->_getVariableValue( $value );
 				if( $originalVariableValue == null ) {
 					unset( $this->_currentVariables[ $name ] );
 				} else {
 					$this->_currentVariables[ $name ] = $originalVariableValue;
 				}
 	
 			}
 		}
 	}
 	
 	private function _removeOtherVariablesThanColors() {
 		// TODO
 		foreach( $this->_currentVariables as $name => $value ) {
 			if( $this->getTypeByValue( $value ) !== ffLessVariableParser::TYPE_COLOR ) {
 				unset( $this->_currentVariables[ $name ] );
 			}
 		}
 	}
 	
 	private function _getVariableValue( $variableName ) {
		if( !isset( $this->_currentVariables[ $variableName ] ) ) {
 			return null;
 		}
 	
 		$value = $this->_currentVariables[ $variableName ];
 	
 		if( $value[0] == '@' ) {
 			$value = $this->_getVariableValue( $value );
 		}
 	
 		return $value;
 	}
################################################################################
# GETTERS AND SETTERS
################################################################################	
	
}