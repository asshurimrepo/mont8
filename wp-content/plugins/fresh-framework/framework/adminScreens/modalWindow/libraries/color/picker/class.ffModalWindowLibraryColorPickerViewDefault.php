<?php

class ffModalWindowLibraryColorPickerViewDefault extends ffModalWindowView {
	
	/**
	 * 
	 * @var ffModalWindowLibraryColorPickerColorPreparator
	 */
	private $colorLibraryPreparator = null;
	
	protected function _initialize() {
		$this->_setViewName('Default');
		$this->_setWrappedInnerContent( false );
	}
	
	

	protected  function _requireAssets() {
		//$this->_getStyleEnqueuer()->addStyleFramework('select2', '/framework/extern/select2/jquery.select2.css');
		//$this->_getScriptEnqueuer()->addScriptFramework('select2', '/framework/extern/select2/jquery.select2.min.js');
		//$this->_getScriptEnqueuer()->addScriptFramework('select2-tools', '/framework/extern/select2/select2-tools.js');
		$this->_getScriptEnqueuer()->getFrameworkScriptLoader()
										->requireSelect2()
										->requireFrsLib()
										->requireFrsLibOptions()
										->requireFrsLibModal();
										
	}
	
	private function _colorLibraryItemToJSON( ffUserColorLibraryItem $colorItem ) {
		$array = array();
		$array['id'] = $colorItem->getId();
		$array['tags'] = $colorItem->getTags();
		$array['timestamp'] = $colorItem->getTimestamp();
		$array['title'] = $colorItem->getTitle();
		
		$color = $colorItem->getColor();
		
		$array['r'] = $color->getR();
		$array['g'] = $color->getG();
		$array['b'] = $color->getB();
		$array['a'] = $color->getA();
		
		return json_encode($array);
	}

	protected function _render() {
		//$dataStorage = ffContainer::getInstance()->getDataStorageFactory()->createDataStorageOptionsPostType();
		
		$colorLib = ffContainer::getInstance()->getLibManager()->createUserColorLibrary();
		
		/*
		$colorItem = $colorLib->getNewColor();
		$colorItem->setTitle('nova barvea');
		$colorItem->setTags('aa,bb,cc,dd,ee');
		
		$color = $colorItem->getColor();
		$color->setRgb(0, 125, 118, 0.5);
		
		$colorLib->setColor( $colorItem );
		*/

		$colors = $colorLib->getColors();
		
		
		
	?>
 
			<div class="attachments-browser">
				<div class="media-toolbar">
					<div class="media-toolbar-secondary">
						<select class="attachment-filters">
							<option value="all">All (324)</option>
  							<optgroup label="User">
								<option value="uploaded">blue brand (19)</option>
								<option value="uploaded">green variant (19)</option>
							</optgroup>
  							<optgroup label="Themes">
								<option value="uploaded">Sentinel (43)</option>
							</optgroup>
  							<optgroup label="Plugins">
								<option value="uploaded">Fresh Shortcodes (124)</option>
								<option value="uploaded">Fresh Social (124)</option>
								<option value="uploaded">Bootstrap (53)</option>
							</optgroup>
						</select>
						<span class="spinner" style="display: none;"></span>
					</div>
					<div class="media-toolbar-primary"><input type="search" placeholder="Search" class="search"></div>
				</div>

				<div class="ff-modal-library-items-container ff-modal-library-items-group-item-size-12">
<?php 
// 					<div class="ff-modal-library-items-groups-titles-container">
// 						<div class="ff-modal-library-items-groups-titles-wrapper">
// 							<div class="ff-modal-library-items-groups-titles">
// 								<div class="ff-modal-library-items-group-title" style="background:red;" data-font-class="placeholder-font-awesome" data-top="-171">
// 									<label>
// 										awesome
// 										<span class="ff-modal-library-items-group-counter">
// 											<span class="ff-modal-library-items-group-counter-filtered">368</span>
// 											<span class="ff-modal-library-items-group-counter-slash">/</span>
// 											<span class="ff-modal-library-items-group-counter-total">368</span>
// 										</span>
// 									</label>
// 								</div><!-- END MODAL LIBRARY GROUP TITLE -->
// 							</div>
// 						</div>
// 					</div><!-- END MODAL LIBRARY GROUPS TITLES -->
					?>
					<div class="ff-modal-library-items-wrapper">
						<div class="ff-modal-library-items">

						
						
<?php 

						$variableName = '@brand-primary';
						$userColors = $this->_getColorLibraryPreparator()->getPreparedUserColors($variableName);
						
						foreach( $userColors as $groupName => $groupValue ) {
							echo '<div class="ff-modal-library-items-group">';
							echo '<div class="ff-modal-library-items-group-title" data-font-class="placeholder-font-awesome" data-top="-171">';
								echo '<label>';
									echo str_replace('-', ' ',$groupName);
									echo '<span class="ff-modal-library-items-group-counter">';
										echo '<span class="ff-modal-library-items-group-counter-filtered">368</span>';
										echo '<span class="ff-modal-library-items-group-counter-slash">/</span>';
										echo '<span class="ff-modal-library-items-group-counter-total">368</span>';
									echo '</span>';
								echo '</label>';
							echo '</div><!-- END MODAL LIBRARY GROUP TITLE -->';
							echo '<div class="ff-modal-library-items-group-items">';
							//var_dump( $groupValue );
							foreach( $groupValue as $oneItem ) {
						
								echo '<div class="ff-modal-library-items-group-item" style="background-color:'.$oneItem->getColor()->getHex().'">';
									echo '&nbsp;';
								echo '</div><!-- END MODAL LIBRARY GROUP ITEM -->';
							}
							
							echo '</div><!-- END MODAL LIBRARY GROUP ITEMS -->';
							echo '</div><!-- END MODAL LIBRARY GROUP -->';
						}
						
						$systemColors = $this->_getColorLibraryPreparator()->getPreparedSystemColors( $variableName );
						
						
						foreach( $systemColors as $groupName => $groupValue ) {
							echo '<div class="ff-modal-library-items-group">';
							echo '<div class="ff-modal-library-items-group-title" data-font-class="placeholder-font-awesome" data-top="-171">';
							echo '<label>';
							echo str_replace('-', ' ',$groupName);
							echo '<span class="ff-modal-library-items-group-counter">';
							echo '<span class="ff-modal-library-items-group-counter-filtered">368</span>';
							echo '<span class="ff-modal-library-items-group-counter-slash">/</span>';
							echo '<span class="ff-modal-library-items-group-counter-total">368</span>';
							echo '</span>';
							echo '</label>';
							echo '</div><!-- END MODAL LIBRARY GROUP TITLE -->';
							echo '<div class="ff-modal-library-items-group-items">';
							//var_dump( $groupValue );
							foreach( $groupValue as $itemName => $oneItem ) {
								//var_Dump( $oneItem );
								echo '<div class="ff-modal-library-items-group-item" style="background-color:'.$oneItem.'">';
								echo '&nbsp;';
								echo '</div><!-- END MODAL LIBRARY GROUP ITEM -->';
							}
								
							echo '</div><!-- END MODAL LIBRARY GROUP ITEMS -->';
							echo '</div><!-- END MODAL LIBRARY GROUP -->';
						}
						
						//var_dump( $userColors );

// 							<?php for ( $groups_index = 0; $groups_index < 8; $groups_index++ ){  

// 							<div class="ff-modal-library-items-group">
// 								<div class="ff-modal-library-items-group-title" data-font-class="placeholder-font-awesome" data-top="-171">
// 									<label>
// 										awesome
// 										<span class="ff-modal-library-items-group-counter">
// 											<span class="ff-modal-library-items-group-counter-filtered">368</span>
// 											<span class="ff-modal-library-items-group-counter-slash">/</span>
// 											<span class="ff-modal-library-items-group-counter-total">368</span>
// 										</span>
// 									</label>
// 								</div><!-- END MODAL LIBRARY GROUP TITLE -->
// 								<div class="ff-modal-library-items-group-items">


									

// 									<?php for ( $items_index = 0; $items_index < $groups_index*$groups_index+40; $items_index++ ){  

// 									<div class="ff-modal-library-items-group-item">
// 										Aa
// 									</div><!-- END MODAL LIBRARY GROUP ITEM -->

// 									<?php } // for ( $items_index = 0; $items_index < 10; $items_index++ ){  




// 								</div><!-- END MODAL LIBRARY GROUP ITEMS -->
// 							</div><!-- END MODAL LIBRARY GROUP -->

// 							<?php } // for ( $groups_index = 0; $groups_index < 10; $groups_index++ ){ 


?>

						</div><!-- END MODAL LIBRARY ITEMS -->
					</div>
				</div>









				<!--
				<ul class="attachments ui-sortable ui-sortable-disabled">
				
					<?php 
					/*
						if( !empty( $colors ) ) {
							foreach( $colors as $oneColor ) {
 
								echo '<li class="attachment save-ready ff-one-color-item">';
									echo '<div class="" style="background-color:'.$oneColor->getColor()->getHex().'" data-family="ff-font-awesome" data-tags="eject player awesome" data-content="2ecf">';
										echo 'xxx';
									echo '</div>';
									echo '<div class="info">'. $oneColor->getTags().'</div>'; 
									echo '<div class="json_data">'.$this->_colorLibraryItemToJSON( $oneColor ).'</div>';
								echo '</li>';
							}
						}
					*/
					?>

				</ul>
				-->









				
				<?php $this->_printSidebar(); ?>
			</div>
 
		<?php 
	}
	
	
	private function _printSidebar() {
	?>
	
		<div class="media-sidebar">
			<div class="attachment-details save-ready">
				<h3>Color Details</h3>
				<div class="attachment-info">
					<div class="thumbnail">
						<div class="ff-modal-library-item-color" style="background: lightgreen;"></div>
					</div>
					<div class="details">
						<div class="filename">MyColor3</div>
						<!--<div class="uploaded">May 9, 2014</div>-->
						
						<a class="edit-attachment" href="" target="_blank">Edit Color</a>
						<a class="edit-attachment" href="" target="_blank">Duplicate Color</a>
						
						<a class="delete-attachment" href="#">Delete Permanently</a>
					</div>
				</div>
				<div class="ff-modal-library-item-details-settings-row">
					<div class="ff-modal-library-item-details-settings-th">Tags</div>
					<div class="ff-modal-library-item-details-settings-td">
						<p><a href="">Bootstrap</a></p>
					</div>
				</div>
				<div class="ff-modal-library-item-details-settings-row">
					<div class="ff-modal-library-item-details-settings-th">HEX</div>
					<div class="ff-modal-library-item-details-settings-td">
						<p>#65c1a5</p>
					</div>
				</div>
				<div class="ff-modal-library-item-details-settings-row">
					<div class="ff-modal-library-item-details-settings-th">RGBA</div>
					<div class="ff-modal-library-item-details-settings-td">
						<p>rgba(152,120,255,0.5)</p>
					</div>
				</div>
				<div class="ff-modal-library-item-details-settings-row">
					<div class="ff-modal-library-item-details-settings-th">Math function</div>
					<div class="ff-modal-library-item-details-settings-td">
						<div class="ff-modal-library-color-math-function">
							<ul class="ff-repeatable ff-repeatable-modal-library-color-math-function">
								<li class="ff-repeatable-item ff-repeatable-item-modal-library-color-math-function">
									<select class="ff-modal-library-color-math-function-select">
										<option value="darken" selected="">darken</option>
										<option value="lighten">lighten</option>
										<option value="spin">spin</option>
									</select>
									<input type="text" value="20" class="ff-modal-library-color-math-function-value">
									<p class="ff-modal-library-color-math-function-unit">%</p>
									<a href="" class="ff-modal-library-color-math-function-remove"></a>
								</li>
							</ul>
							<input type="button" class="button button-small" value="+ Add">
						</div>
					</div>
				</div>		
			</div>
		</div>
	<?php
	}
	
	public function printToolbar() {
		return;
		echo '<div class="media-frame-toolbar">';
			echo '<div class="media-toolbar">';
				echo '<div class="media-toolbar-primary">';
					echo '<input type="submit" class="ff-conditional-submit button media-button button-primary button-large" value="Save Changes">';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}

	public function proceedAjax( ffAjaxRequest $request ) {
		
		$colorId = $request->data['colorId'];
		
		$colorLibrary =  ffContainer::getInstance()->getLibManager()->createColorLibrary();
		$colorLibrary->deleteColorById( $colorId );
		
		echo '1';
	}


	private function _printForm( $data = array() ) {
 
	}
	
	/**
	 *
	 * @return ffModalWindowLibraryColorPickerColorPreparator
	 */
	protected function _getColorLibraryPreparator() {
		return $this->_colorLibraryPreparator;
	}
	
	/**
	 *
	 * @param ffModalWindowLibraryColorPickerColorPreparator $colorLibraryPreparator        	
	 */
	public function setColorLibraryPreparator(ffModalWindowLibraryColorPickerColorPreparator $colorLibraryPreparator) {
		$this->_colorLibraryPreparator = $colorLibraryPreparator;
		return $this;
	}
	
}