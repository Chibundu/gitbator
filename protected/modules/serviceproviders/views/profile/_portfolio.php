<?php
$baseUrl = Yii::app()->request->baseURL; 
Yii::app()->clientScript->registerCssFile($baseUrl.'/assets/js/css/ui-lightness/jquery-ui-1.8.16.custom.css');
Yii::app()->clientScript->registerScriptFile($baseUrl.'/assets/js/jquery-1.3.2.js');
Yii::app()->clientScript->registerScriptFile($baseUrl.'/assets/js/jquery-ui-1.7.2.custom.js');
Yii::app()->clientScript->registerScriptFile($baseUrl.'/assets/js/jquery.jcoverflip.js');
?>

<div id="wrapper">
<ul id="flip">
      <li><img title="pdf document" src="<?php echo $baseUrl; ?>/images/pdf.png" style="opacity: 0.5; width: 100px; display: block; "></li>
      <li><img title="pp document" src="<?php echo $baseUrl; ?>/images/pp.png" style="opacity: 1; width: 200px; display: block; "></li>
      <li><img title="word document" src="<?php echo $baseUrl; ?>/images/word.png" style="opacity: 0.5; width: 100px; display: block; "></li> 
</ul>
<div id="scrollbar" >
</div>


</div>