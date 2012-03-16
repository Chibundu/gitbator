<?php

class ProgressTracker extends CWidget{
	
	/**	 
	 * A numeric array of the titles for each level e.g array('past', 'current', 'future');
	 * @var array
	 */
	public $levels = array();
	
	/**	 
	 * The current level in the process e.g 2. Please not that levels start from 1 not 0.
	 * @var int
	 */
	public $current = 1;
	
	public function run()
	{
		$this->publishRelatedFiles();
		echo '<div class = "progress_tracker"><ul>';
		$level = $this->current;
		$levels = $this->levels;
		if(is_array($levels) && is_numeric($level))
		{
			$numberOfLevels = count($levels);
			if($numberOfLevels > 0 && $level > 0)
			{
				for($i = 1; $i <= $numberOfLevels; $i++)
				{
					echo '<li';
 
					if($i == $level){ 
 						echo ' class = "active" ';
					} 
 					elseif($i < $level){
 						echo ' class = "past" ';
 					}
 					if($i == ($numberOfLevels))
 					{
 						echo ' id="lastStep" ';
 					}

 					echo ' style = "width:'.(100/$numberOfLevels).'%;"><a href="" title = "">';
 
	
					echo $i. ". ". $levels[$i-1].'</a>
					
					</li>';
				}
			} 
		}
		echo '</ul></div>';
		
	}
	
	private function publishRelatedFiles()
	{
		$app = Yii::app();		
		$assetDirectory = dirname(__FILE__).'/assets';
		$app->clientScript->registerCssFile($app->assetManager->publish($assetDirectory.'/css/progress_tracker.css'));		
	}

}
?>
