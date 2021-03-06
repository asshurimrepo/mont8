<?php

class ffFrameworkScriptLoader extends ffBasicObject {

	/**
	 *
	 * @var ffScriptEnqueuer
	 */
	private $_scriptEnqueuer = null;

	/**
	 *
	 * @var ffStyleEnqueuer
	 */
	private $_styleEnqueuer = null;

	public function __construct( ffWPLayer $WPLayer, ffScriptEnqueuer $scriptEnqueuer, ffStyleEnqueuer $styleEnequeuer ) {
		$this->_setScriptEnqueuer( $scriptEnqueuer );
		$this->_setStyleEnqueuer( $styleEnequeuer );
		$this->_setWPLayer( $WPLayer );
	}

	public function requireFrsLib() {
		$this->_getScriptEnqueuer()
				->addScriptFramework( 'ff-frslib', '/framework/frslib/src/frslib.js', array('jquery'));
		
		return $this;
	}
	
	public function requireMinicolors() {
		$this->requireFrsLib();
		$this->_getScriptEnqueuer()->addScriptFramework('ff-minicolors', '/framework/extern/minicolors/jquery.minicolors.js', array('jquery'));
		$this->_getStyleEnqueuer()->addStyleFramework('ff-minicolors', '/framework/extern/minicolors/jquery.minicolors.css');
		
		return $this;
	}

	public function requireFrsLibOptions() {
		$this->_getScriptEnqueuer()
		->addScriptFramework( 'ff-frslib-options', '/framework/frslib/src/frslib-options.js', array('jquery'));
		
		return $this;
	}
	
	public function requireFrsLibModal() {
		$this->_getScriptEnqueuer()
		->addScriptFramework( 'ff-frslib-modal', '/framework/frslib/src/frslib-modal.js', array('jquery'));
		
		return $this;
	}

	public function requireFrsLibMetaboxes() {
		$this->_getScriptEnqueuer()
				->addScriptFramework('ff-frslib-metaboxes', '/framework/frslib/src/frslib-metaboxes.js', array('jquery'));
		
		return $this;
	}
	
	public function requireSelect2() {
		$this->_getStyleEnqueuer()->addStyleFramework('select2', '/framework/extern/select2/jquery.select2.css');
		$this->_getScriptEnqueuer()->addScriptFramework('select2', '/framework/extern/select2/jquery.select2.min.js');
		$this->_getScriptEnqueuer()->addScriptFramework('select2-tools', '/framework/extern/select2/select2-tools.js');
		
		return $this;
	}
	
	public function requireJsTree() {
		$this->_getStyleEnqueuer()->addStyleFramework('ff-jstree-style', '/framework/extern/jstree/themes/default/style.min.css');
		$this->_getScriptEnqueuer()->addScriptFramework('ff-jstree-script', '/framework/extern/jstree/jstree.js', array('jquery'));
	}

	public function requireFfAdmin() {
		if( ('plugins.php' == basename($_SERVER['SCRIPT_NAME']) ) or ( 'update.php' == basename($_SERVER['SCRIPT_NAME']) ) ){
			$this->_getScriptEnqueuer()->addScriptFramework('ff-update-hide', '/framework/adminScreens/assets/js/update.js');
		}
		$this->_getStyleEnqueuer()->addStyleFramework('ff-admin', 'framework/adminScreens/assets/css/ff-admin.less', null, null, null, null);
		$this->addAdminColorsToStyle('ff-admin');
		$this->_getStyleEnqueuer()->addLessVariable('ff-admin','fresh-framework-url', '"'.ffContainer::getInstance()->getWPLayer()->getFrameworkUrl().'"' );
		
		return $this;
	}
	
	public function addAdminColorsToStyle( $styleName ){

		$userID      = $this->_getWPlayer()->get_current_user_id();
		$admin_color = $this->_getWPlayer()->get_the_author_meta( 'admin_color', $userID );

		$_wp_admin_css_colors = $this->_getWPlayer()->get_wp_admin_css_colors();

		if( empty( $_wp_admin_css_colors[ $admin_color ] ) ){
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_colors_0',            '#222');
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_colors_1',            '#333');
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_colors_2',            '#0074a2');
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_colors_3',            '#2ea2cc');
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_icon_colors_base',    '#999');
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_icon_colors_focus',   '#2ea2cc');
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_icon_colors_current', '#fff');
		}else{
			$colors = $_wp_admin_css_colors[ $admin_color ];
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_colors_0',            $colors->colors['0']);
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_colors_1',            $colors->colors['1']);
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_colors_2',            $colors->colors['2']);
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_colors_3',            $colors->colors['3']);
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_icon_colors_base',    $colors->icon_colors['base']);
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_icon_colors_focus',   $colors->icon_colors['focus']);
			$this->_getStyleEnqueuer()->addLessVariable( $styleName, 'wpadmin_icon_colors_current', $colors->icon_colors['current']);
		}
	}

	/**
	 * @return ffScriptEnqueuer
	 */
	protected function _getScriptEnqueuer() {
		return $this->_scriptEnqueuer;
	}

	/**
	 * @param ffScriptEnqueuer $scriptEnqueuer
	 */
	protected function _setScriptEnqueuer($scriptEnqueuer) {
		$this->_scriptEnqueuer = $scriptEnqueuer;
		return $this;
	}

	/**
	 *
	 * @return ffStyleEnqueuer
	 */
	protected function _getStyleEnqueuer() {
		return $this->_styleEnqueuer;
	}

	/**
	 *
	 * @param ffStyleEnqueuer $_styleEnqueuer
	 */
	protected function _setStyleEnqueuer(ffStyleEnqueuer $_styleEnqueuer) {
		$this->_styleEnqueuer = $_styleEnqueuer;
		return $this;
	}

	/**
	 * @return ffWPLayer instance of ffWPLayer
	 */
	protected function _getWPlayer() {
		return $this->_WPLayer;
	}

	/**
	 * @param ffWPLayer $_WPLayer
	 * @return ffLessWPOptions_Factory caller instance of ffLessWPOptions_Factory
	 */
	protected function _setWPlayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}

}