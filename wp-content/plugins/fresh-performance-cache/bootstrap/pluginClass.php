<?php

class ffPluginFreshMinificator extends ffPluginAbstract {
	const OPT_NAMESPACE = 'ff_minificator';
	/**
	 *
	 * @var ffPluginFreshMinificatorContainer
	 */
	protected $_container = null;
	
	/**
	 * 
	 * @var ffOptionsQuery
	 */
	protected $_query = null;
	
	protected function _registerAssets() {
		$this->_getContainer()->getFrameworkContainer()->getAdminScreenManager()->addAdminScreenClassName('ffAdminScreenMinificator');
	}
	
	
	protected function _run() {
		$fwc = $this->_getContainer()->getFrameworkContainer();
		$WPLayer = $fwc->getWPLayer();
		if( $WPLayer->is_admin() || $WPLayer->is_login_page() ) {
			return;
		}
	
		$hookManager =  $fwc->getWPLayer()->getHookManager();
		

		
		$dataStorage = $fwc->getDataStorageFactory()->createDataStorageWPOptionsNamespace('minificator');
		$options = $dataStorage->getOption('options');
		$optionsHolder = $fwc->getOptionsFactory()->createOptionsHolder('ffMinificatorOptionsHolder');
		$query = $fwc->getOptionsFactory()->createQuery($options, $optionsHolder);
		$this->_setQuery( $query );
	
		
		if( $query->get('minificator allow_css') == 1) 
			$hookManager->addActionWPPrintStyles( array( $this, 'actPrintStyles'), 19 );
		
		if( $query->get('minificator allow_js') == 1 ) {
			$hookManager->addActionWPPrintScripts( array( $this, 'actPrintScripts'), 19 );
			$fwc->getWPLayer()->add_action('wp_footer', array( $this, 'actPrintScriptsFooter'), 19 ); 
		}
		
	}

	public function actPrintScriptsFooter() {
		$dataStorage = $this->_getContainer()->getFrameworkContainer()->getDataStorageFactory()->createDataStorageWPOptionsNamespace('minificator');
		
		//if( $this->_getQuery()->get('minificator allow_monitoring_js') ) {
		// THIS WATCHING WAS OPTIONAL BUT NOW IT'S FORCED  
		if( true ) {
			$scriptWatcher = $this->_getContainer()->getScriptWatcher();
			$scriptList = $scriptWatcher->watchScripts();

			$dataStorage->addToOption('watched_scripts_header', $scriptList['header_scripts']);
			$dataStorage->addToOption('watched_scripts_footer', $scriptList['footer_scripts']);			
		}
		
		$bannedFiles = $dataStorage->getOption('banned_handles_scripts');
		
		$scriptMinificator = $this->_getContainer()->getScriptMinificator();
		$scriptMinificator->addBannedScriptHandle( $bannedFiles );
		$scriptMinificator->minify('footer');
		
	}
	
	
	public function actPrintStyles() {
		$dataStorage = $this->_getContainer()->getFrameworkContainer()->getDataStorageFactory()->createDataStorageWPOptionsNamespace('minificator');
		
		// THIS WATCHING WAS OPTIONAL BUT NOW IT'S FORCED		
		//if( $this->_getQuery()->get('minificator allow_monitoring_css') ) {
		if( true ) {
			$styleWatcher = $this->_getContainer()->getStyleWatcher();
			$styleList = $styleWatcher->watchStyles();
			
			$dataStorage->addToOption( 'watched_styles_header', $styleList);
		}
		

		
		$bannedFiles = $dataStorage->getOption('banned_handles_styles');
	
		$styleMinificator = $this->_getContainer()->getStyleMinificator();
		$styleMinificator->addBannedStyleHandle($bannedFiles);

		$styleMinificator->minify();
	}
	
	

	public function actPrintScripts(){
		$dataStorage = $this->_getContainer()->getFrameworkContainer()->getDataStorageFactory()->createDataStorageWPOptionsNamespace('minificator');
		
		//if( $this->_getQuery()->get('minificator allow_monitoring_js') ) {
		// THIS WATCHING WAS OPTIONAL BUT NOW IT'S FORCED  
		if( true ) {
			$scriptWatcher = $this->_getContainer()->getScriptWatcher();
			$scriptList = $scriptWatcher->watchScripts();

			$dataStorage->addToOption('watched_scripts_header', $scriptList['header_scripts']);
			$dataStorage->addToOption('watched_scripts_footer', $scriptList['footer_scripts']);			
		}
		
		$bannedFiles = $dataStorage->getOption('banned_handles_scripts');
		
		$scriptMinificator = $this->_getContainer()->getScriptMinificator();
		$scriptMinificator->addBannedScriptHandle( $bannedFiles );
		$scriptMinificator->minify();
		
		
	}
	
	
	
	protected function _setDependencies() {
			
	}

	
	/**
	 * @return ffPluginFreshMinificatorContainer
	 */
	protected function _getContainer() {
		return $this->_container;
	}

	protected function _getQuery() {
		return $this->_query;
	}
	
	protected function _setQuery(ffOptionsQuery $query) {
		$this->_query = $query;
		return $this;
	}
	
}