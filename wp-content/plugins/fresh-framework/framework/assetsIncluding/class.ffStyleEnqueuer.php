<?php

class ffStyleEnqueuer extends ffBasicObject {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	/**
	 * 
	 * @var ffStyle_Factory
	 */
	private $_styleFactory = null;

	/**
	 * 
	 * @var ffFileSystem
	 */
	private $_fileSystem = null;


	/**
	 * 
	 * @var array[ffStyle]
	 */
	protected $_styles = array();
	
	protected $_stylesNonMinificable = array();
	
	protected $_actionEnqueueStylesHeaderTriggered = false;

	
	private $_lessVariables = array();
	
	private $_lessCodes = array();
	
	private $_actionLessVariablesAdded = false;
	
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct( ffWPLayer $WPLayer, ffStyle_Factory $styleFactory, ffFileSystem $fileSystem ) {
		$this->_setWplayer($WPLayer);
		$this->_setStylefactory($styleFactory);
		//$this->_getWplayer()->getHookManager()->addActionEnqueuScripts(array( $this, 'actionEnqueueStyles' ));
		$this->_setFileSystem($fileSystem);
		$this->_getWplayer()->add_action_enque_scripts(array( $this, 'actionEnqueueStyles' ), 9);
	}
	
	public function addStyleFramework( $handle = null, $source = null, $dependencies = null, $version = null, $media = null, $type = null, $additionalInfo = null ) {
		$source = $this->_getWplayer()->getFrameworkUrl() . $source;
		$this->addStyle($handle, $source, $dependencies, $version, $media, $type, $additionalInfo );
	}
	
	public function addStyle( $handle = null, $source = null, $dependencies = null, $version = null, $media = null, $type = null, $additionalInfo = null ) {
		
		$style = $this->_getStylefactory()
						->createStyle( $handle, $source, $dependencies, $version, $media, $type, $additionalInfo);
		
		$this->_addStyle( $style );
	}
	
	public function addStyleObject( ffStyle $style ) {
		$this->_addStyle($style);
	}



	public function addLessVariable( $handle, $name, $value ){
		if( is_array($handle) ){
			foreach ($handle as $single_handle) {
				$this->addLessVariable($single_handle, $name, $value );
			}
		}else{
			if( empty( $this->_lessVariables[ $handle ] ) ){
				$this->_lessVariables[ $handle ] = array();
			}
			$this->_lessVariables[ $handle ][ $name ] = $value;
			if( ! $this->_actionLessVariablesAdded ){
				$this->_actionLessVariablesAdded = true;
				$this->_getWplayer()->add_action( ffHookManager::ACTION_GATHER_LESS_SCSS_VARIABLES, array($this, 'applyLessVariables') );
			}
		}
	}
	
	public function addLessCode( $handle, $name, $value ) {
		if( empty( $this->_lessCodes[ $handle ] ) ){
			$this->_lessCodes[ $handle ] = array();
		}
		$this->_lessCodes[ $handle ][ $name ] = $value;
		
		if( ! $this->_actionLessVariablesAdded ){
			$this->_actionLessVariablesAdded = true;
			$this->_getWplayer()->add_action( ffHookManager::ACTION_GATHER_LESS_SCSS_VARIABLES, array($this, 'applyLessVariables') );
		}
	}

	public function addLessImportFile( $handle, $name, $file ) {
		// echo '<pre>';
		// var_dump( $file ); echo "<br />";
		// var_dump( $this->_getWplayer()->get_wp_styles()->registered[$handle]->src); echo "<br />";
		// var_dump( $this->_getWplayer()->get_wp_styles()->registered );
		$file = $this->_getfileSystem()->getRelativePath( $this->_getWplayer()->get_wp_styles()->registered[$handle]->src , $file );
		// var_dump( $file); echo "<br /><br />";
		// echo '</pre>';
		//exit;
		$this->addLessCode( $handle, $name, "\n\n".'@import "'.$file.'";'."\n\n");
	}

	public function addLessVariablesFromFile( $style_slug, $file ){
		$file = $this->_getfileSystem()->file( $file );
		foreach ($file as $line) {
			$line = trim( $line );
			if( '@' != substr($line, 0, 1) ) continue;
			if( FALSE === strpos($line, ':') ) continue;
			$line = explode(':', $line);
			$variable = trim( $line[0] );
			$variable = substr($variable, 1);
			$value = trim( $line[1] );
			if( FALSE !== strpos($value, ';') ){
				$value = explode(';', $value);
				$value = $value[0];
			}
			$this->addLessVariable($style_slug, $variable, $value);
		}
	}

	public function applyLessVariables( ffVariableTransporter $variables){
		if( !empty( $this->_lessVariables ) ) {
			foreach ($this->_lessVariables as $style_slug => $style_variables) {
				foreach ($style_variables as $style_variable => $style_variable_value) {
					$variables->addVariable($style_slug, $style_variable, $style_variable_value);
				}
			}
		}
		
		if( !empty( $this->_lessCodes ) ) {
			foreach ( $this->_lessCodes as $handle => $codes ) {
				foreach( $codes as $oneCodeName=> $oneCodeValue ) {
					$variables->addCode($handle, $oneCodeName, $oneCodeValue);
				}
			}
		}
	}
	
	public function actionEnqueueStyles() {
		$this->_actionEnqueueStylesHeaderTriggered = true;
		$this->_enqueueNonMinificableStyles();
		if( !empty($this->_styles) ) {
			foreach( $this->_styles as $oneStyle ) {
				$this->_getWplayer()
					->wp_enqueue_style(
							$oneStyle->handle,
							$oneStyle->source, 
							$oneStyle->dependencies, 
							null
					);

				// TODO: $style IS NOT DEFINED THERE ???

				if( !empty($style) and $style->additionalInfo != null ) {
					$this->_getWplayer()
					->wp_enqueue_style_add_param( $style->handle, ffStyle::PARAM_ADDITIONAL_INFO, $style->additionalInfo);
				}
			}
		}
	}
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	protected function _enqueueNonMinificableStyles() {
		if( !empty($this->_stylesNonMinificable) ) {
			foreach( $this->_stylesNonMinificable as $oneStyle ) {
				$this->_getWplayer()
				->wp_enqueue_style(
						$oneStyle->handle,
						$oneStyle->source,
						$oneStyle->dependencies,
						null,
						null//$oneStyle->inFooter
				);
			}
		}
	}
	
	private function _addStyle( ffStyle $style ) {
		if( $this->_actionEnqueueStylesHeaderTriggered ) {
			$this->_getWplayer()
				->wp_enqueue_style(
						$style->handle,
						$style->source,
						$style->dependencies,
						null,
						null
				);
			
			if( $style->additionalInfo != null ) {
				$this->_getWplayer()
					->wp_enqueue_style_add_param( $style->handle, ffStyle::PARAM_ADDITIONAL_INFO, $style->additionalInfo);
			}
		}
		$this->_styles[ $style->handle ] = $style;
	//	if( $style->canBeMinified == true ) {
			
	//	} else {
		//	$this->_stylesNonMinificable[ $style->handle ] = $style;
	//	}
		
	}
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/	
	
	/**
	 * @return ffWPLayer
	 */
	protected function _getWplayer() {
		return $this->_WPLayer;
	}
	
	/**
	 * @param ffWPLayer $_WPLayer
	 */
	protected function _setWplayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}
	
	/**
	 * @return ffStyle_Factory
	 */
	protected function _getStylefactory() {
		return $this->_styleFactory;
	}
	
	/**
	 * @param ffStyle_Factory $_styleFactory
	 */
	protected function _setStylefactory(ffStyle_Factory $styleFactory) {
		$this->_styleFactory = $styleFactory;
		return $this;
	}	

	/**
	 * @return ffFileSystem
	 */
	protected function _getfileSystem() {
		return $this->_fileSystem;
	}
	
	/**
	 * @param ffFileSystem $_fileSystem
	 */
	protected function _setfileSystem(ffFileSystem $fileSystem) {
		$this->_fileSystem = $fileSystem;
		return $this;
	}


}





