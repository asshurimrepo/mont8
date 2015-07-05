<?php
/**
 * Basically options for the whole minificator plugin. They could be
 * accessed via the admin screen. They will also be accessed across
 * the whole plugin.
 * 
 * @author boobs.lover
 */
class ffMinificatorOptionsHolder extends ffOptionsHolder {
	public function getOptions() {
		$s = $this->_getOnestructurefactory()->createOneStructure('minificator');
		
		$s->startSection('minificator');

			//$s->addElement( ffOneElement::TYPE_PARAGRAPH, '', 'Cache is gradually improved as your site is being browsed.');
		
			$s->addElement( ffOneElement::TYPE_TABLE_START );

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'General');
				
					$s->addOption(ffOneOption::TYPE_CHECKBOX, 'allow_css', 'Minify CSS ', 1, '');
					
					$s->addElement( ffOneElement::TYPE_NEW_LINE);
					
					$s->addOption(ffOneOption::TYPE_CHECKBOX, 'allow_js', 'Minify JavaScript ', 1, '');
					
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
				
				
				/*
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'Allow monitoring of included assets');
				
					$s->addOption(ffOneOption::TYPE_CHECKBOX, 'allow_monitoring_css', 'of CSS ', 1, '');
					
					$s->addElement( ffOneElement::TYPE_NEW_LINE);
					
					$s->addOption(ffOneOption::TYPE_CHECKBOX, 'allow_monitoring_js', 'of JavaScript ', 1, '');
					
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
				
				*/
		
			$s->addElement(ffOneElement::TYPE_TABLE_END);
	
		$s->endSection();
		
		return $s;
	}
}

