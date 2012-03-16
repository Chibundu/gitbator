<?php
/** 
 * Based on Twitter Bootstrap, this widget checks for the availability of flash messages and displays them 
 */
class SimpleFlash extends CWidget{	

	/**	 
	 * The message to be displayed
	 * @var string
	 */
	public $message;
	
	/**
	 * css to be used
	 * @var string 
	 */
	public $css = 'alert-info';
	
	public function run()
	{
		if($this->message == NULL){
			if(Yii::app()->user->hasFlash('error')){
	
				echo '<div class = "alert alert-block alert-error">'.
					'<a class="close" data-dismiss="alert">&times;'.Yii::app()->user->getFlash('error').'</div>';
			}
			
			if(Yii::app()->user->hasFlash('success')){
	
				echo '<div class = "alert alert-block alert-success">'.
					'<a class="close" data-dismiss="alert">&times;</a>'.Yii::app()->user->getFlash('success').'</div>';
			}
			
			
			if(Yii::app()->user->hasFlash('warning')){
	
				echo '<div class = "alert alert-block alert">'.
					'<a class="close" data-dismiss="alert">&times;</a>'.Yii::app()->user->getFlash('warning').'</div>';
			}
			
			
			if(Yii::app()->user->hasFlash('info')){
	
				echo '<div class = "alert alert-block alert-info">'.
					'<a class="close" data-dismiss="alert">&times;</a>'.Yii::app()->user->getFlash('info').'</div>';
			}
		}
		else 
		{
			echo '<div class = "alert alert-block '.$this->css.'">'.
					'<a class="close" data-dismiss="alert">&times;</a>'.
						$this->message.
					'</div>';
			
		}
		
		
	}
	
}

?>