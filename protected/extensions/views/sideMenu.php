<?php if(is_array($links) && count($links) > 0): ?>

<?php 	
	$controller = Yii::app()->controller->id;
	$focused_link = '';
	$route = $this->controller->getRoute(); 
	$module = $this->controller->module->id;
	$def  = $module.'/'.$controller;	

?>
	<dl class="nice vertical tabs">
			
		<?php foreach ($links as $link):
				$isAvailable = false;
				$url = $link['url'][0];	
				//add the module string to the url if it doesn't exist			
				if(strpos($url, $module)===false)
				{					
					$url = $module.'/'.$url;				
				}
				
				if(($this->controller->action->id == 'index')){						
								
					$isAvailable = ($url == $route) || ($url == substr($route, 0, -5) || $url == substr($route, 0, -6));
				}
				else
				{		
					 $url_ = $url;
					 if(strrpos($url,'/')==strlen($url)-1)//remove the last slash if it exists
						$url_ = substr($url, 0, strlen($url)-1);
					$isAvailable = (strpos($route, $url_)!== false)?true:false;
							
				}
						
		?>	 
		 
		<dd>
		<?php
			if($isAvailable)
				echo CHtml::link($link['text'], $link['url'], array('class'=>'active'));
			else
				echo CHtml::link($link['text'], $link['url']);			

		 ?>
		 </dd>
				
		<?php  endforeach;?>				
	</dl>

<?php endif; ?>

