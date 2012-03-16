<?php
/*
 * jCoverFlip widget class file.
 * @author Ramin Mousavi <ramin.mousavy@gmail.com>
 * @link http://www.raminmousavi.com
 */
 
class jCoverFlip extends CWidget{
	
	public $elements = array();
	public $options = array();
	
	public function init(){
		$this->publishAssets();
	}
	
	public function run(){
	
		echo CHtml::openTag('div', array('id' => 'wrapper')) ;
		
			echo CHtml::openTag('ul', array('id' => 'flip', 'class' => 'ui-jcoverflip')) ;
			
			foreach($this->elements as $element){
			
				echo CHtml::openTag('li', array('class' => 'ui-jcoverflip--item'));
				
				echo CHtml::openTag('span', array('style' => 'display: none', 'class' => 'title',));
					echo $element['title'];
				echo CHtml::closeTag('span');
				
				echo CHtml::openTag('img', array('style' => 'opacity: 0.5; width: 100px; display: block;', 'src' => $element['image']));
				echo CHtml::closeTag('img');
				
				echo CHtml::closeTag('li');
			}		
			
			echo CHtml::closeTag('ul');
		
		echo CHtml::closeTag('div');
		
	}
	
	private function publishAssets(){
	
		$assets = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' ;
		$baseUrl = Yii::app()->getAssetManager()->publish($assets);
		
		$config = CJavaScript::encode($this->options);
		
		if (is_dir($assets)){		
			Yii::app()->clientScript->registerCoreScript('jquery', CClientScript::POS_HEAD);			
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/jui.js', CClientScript::POS_HEAD);
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/jquery.jcoverflip.js', CClientScript::POS_HEAD);
			Yii::app()->clientScript->registerCssFile($baseUrl . '/style.css', 'all');
				
			Yii::app()->clientScript->registerScript(__CLASS__ , "
					$('#flip').jcoverflip($config);
					$('#flip').jcoverflip('next',$('#flip').jcoverflip('length')/2); 
				", CClientScript::POS_READY
			);			
			
			
		}
	}
}
?>