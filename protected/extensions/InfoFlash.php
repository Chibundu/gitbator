<?php
/**
 * Notices Widget for Info, errors, etc.
 * @author Mbagwu Chibundu
 *
 */
class InfoFlash extends CWidget {
	/**
	 * The top-level CSS: alert-info, alert-warning, alert-error, etc
	 * @var string
	 */
	public $css = 'alert-info';
	
	/**
	 * Css for informational message section of the display
	 * @var string
	 */
	public $contentCss = 'info_alert';
	
	/**
	 * The heading
	 * @var string
	 */
	public $heading = '';
	
	/**
	 * The informational message
	 * @var string
	 */
	public $message = '';
	
	/**
	 * Whether or not to have a "close" link
	 * @var boolean
	 */
	public $isClosable = true;
	
	/**
	 * (non-PHPdoc)
	 * @see CWidget::run()
	 */
	public function run()
	{
		echo '<div class = "alert '.$this->css.'">';
		
		 if($this->isClosable){
		 	echo '<a class="close" data-dismiss="alert">&times;</a>';
		 }
		 
		 echo '<h4 class="alert-heading">'.$this->heading.'</h4>
		 <div class = "'.$this->contentCss.'">'.
		 	$this->message
		 .'</div>
		</div>';
	}

}

?>