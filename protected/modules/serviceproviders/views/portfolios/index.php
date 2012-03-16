<?php $baseUrl = Yii::app()->request->baseUrl;?>
<div class="row-fluid append-bottom">
	<div class="span2">
		<h2>Portfolio(<?php echo count($portfolio); ?>)</h2>
	</div>
	<div class="span10">
		<?php echo CHtml::link('<i class = "icon-plus-sign"></i> Add New Sample Work', array('portfolios/create'), array('class'=>'right btn'));?>
	</div>
</div>
<?php if(Yii::app()->user->hasFlash('error') || Yii::app()->user->hasFlash('success')):?>
<div class = "row-fluid append-bottom">
<?php $this->widget('BootAlert');?>
</div>
<?php endif;?>
<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile($baseUrl.'/assets/js/jquery-ui-1.7.2.custom.js');
$cs->registerScriptFile($baseUrl.'/assets/js/jquery.jcoverflip.js');

if(count($portfolio) == 0):
?>
Your portfolio is empty.
<?php else:

 Yii::app()->clientScript->registerScript('jCoverFlip', "
	var r = 100/".count($portfolio).";
	$('#flip').jcoverflip({
	      current: 2,
	      beforeCss: function( el, container, offset ){
	        return [
	          $.jcoverflip.animationElement( el, { left: ( container.width( )/2 - 210 - 110*offset + 20*offset )+'px', bottom: '20px' }, { } ),
	          $.jcoverflip.animationElement( el.find( 'img' ), { width: Math.max(10,100-20*offset*offset) + 'px' }, {} )
	        ];
	      },
	      afterCss: function( el, container, offset ){
	        return [
	          $.jcoverflip.animationElement( el, { left: ( container.width( )/2 + 110 + 110*offset )+'px', bottom: '20px' }, { } ),
	          $.jcoverflip.animationElement( el.find( 'img' ), { width: Math.max(10,100-20*offset*offset) + 'px' }, {} )
	        ];
	      },
	      currentCss: function( el, container ){
	        return [
	          $.jcoverflip.animationElement( el, { left: ( container.width( )/2 - 100 )+'px', bottom: 0 }, { } ),
	          $.jcoverflip.animationElement( el.find( 'img' ), { width: '200px' }, { } )
	        ];
	      },
	      change: function(event, ui){
	        jQuery('#scrollbar').slider('value', ui.to*r);
	      }
	    });
", CClientScript::POS_READY);
?>


<div id="wrapper">
<ul id="flip">
<?php foreach ($portfolio as $p):?>
	<?php switch($p->resourceType){
		case "pdf":
	?>
	 <li><?php echo CHtml::link(CHtml::image($baseUrl.'/images/pdf.png', $p->tag, array('title'=>$p->tag, 'style'=>"opacity: 1; width: 200px; display: block; ")), array('view','id'=>$p->id)); ?></li>
	<?php 
		break;
		case "ppt":
	?>
	 <li><?php echo CHtml::link(CHtml::image($baseUrl.'/images/pp.png', $p->tag, array('title'=>$p->tag, 'style'=>"opacity: 1; width: 200px; display: block; ")), array('view','id'=>$p->id)); ?></li>
	<?php 
		break;
		case "pptx":
	?>
	 <li><?php echo CHtml::link(CHtml::image($baseUrl.'/images/pp.png', $p->tag, array('title'=>$p->tag, 'style'=>"opacity: 1; width: 200px; display: block; ")), array('view','id'=>$p->id)); ?></li>
	<?php 
		break;		
		case "docx":
	?>
	  <li><?php echo CHtml::link(CHtml::image($baseUrl.'/images/word.png', $p->tag, array('title'=>$p->tag, 'style'=>"opacity: 1; width: 200px; display: block; ")), array('view','id'=>$p->id)); ?></li>
	<?php 
		break;
		case "doc":
	?>
	<li><?php echo CHtml::link(CHtml::image($baseUrl.'/images/word.png', $p->tag, array('title'=>$p->tag, 'style'=>"opacity: 1; width: 200px; display: block; ")), array('view','id'=>$p->id)); ?></li>
	<?php 
		break;
		default:	
	?>
	 <li><?php echo CHtml::link(CHtml::image(Miscellaneous::getRelativePortfolioPath().$p->resource_location, $p->tag, array('title'=>$p->tag, 'style'=>"opacity: 1; width: 200px; display: block; ")), array('view','id'=>$p->id)); ?></li>
	<?php 		
		break;			
	}        
   		endforeach;
  ?>       
</ul>
<?php 
$this->widget('zii.widgets.jui.CJuiSlider', array(
      'value'=>50,
	  'theme'=>'ui-lightness',
      // additional javascript options for the progress bar plugin
      'options'=>array(
          'stop'=>'js:function(event, ui) {
	        if(event.originalEvent) {
	          var r = 100/'.count($portfolio).';
	          var numItems = '.count($portfolio).';
	          var newVal = Math.round(ui.value/r);
	        
	          jQuery( "#flip" ).jcoverflip( "current", newVal );
	          jQuery("#scrollbar").slider("value", newVal * r);
	        }
	      }',		
     ),
     'htmlOptions'=>array(
          'id'=>'scrollbar',     
     ),
  ));
?>

</div>

<?php endif;?>