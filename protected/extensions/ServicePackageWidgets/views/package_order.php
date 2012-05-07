<?php
$app = Yii::app();
$baseUrl = $app->request->baseUrl;
$service_packages_dir = $app->params['service_packages_dir'];

$app->clientScript->registerScriptFile("$baseUrl/js/ajax-form.js", CClientScript::POS_HEAD);
$app->clientScript->registerScriptFile("$baseUrl/js/spin.min.js", CClientScript::POS_HEAD);
$app->clientScript->registerScriptFile("$baseUrl/js/et-package-order.js", CClientScript::POS_END);


?>

	<div id = "temp" style = "display: none;" data-id = <?php echo $order_id; ?>>	
	<div class = "row-fluid mcont">	
					<div class = "span12 mbox">		
						<div class = "row-fluid">
							<div class = "span1">
							<?php echo CHtml::image("$baseUrl/profilepics/thumbnails/$tlPic", '#', array('style'=>'margin: 6px 10px; width: 50px;'))?>
							</div>
							<div class = "span10">
								<h5><?php echo $etName; ?></h5>
								<div class = "row-fluid">
									<div class = "span12">									
										<div class = "ellipsis pmess">
											
										</div>
									</div>
								</div>
								<div class = "row-fluid">
									<div class = "span12">
										<span class = "mout">message sent to <b><?php echo $spName; ?></b> at <span class = "time">9:00 am 4 April, 2012</span></span>
									</div>
								</div>
							</div>
						</div>		
					</div>
			</div>				
	</div>


<div class = "row-fluid prepend-top">
	<div class = "span4">		
		<div class = "thumbnail"><?php echo CHtml::image("$baseUrl/$service_packages_dir"."larger/$package_pic");?></div>
			<h5 class = "prepend-top"><?php echo $package_title; ?></h5>			
	</div>
	<div class = "span5">
		<span class = "status_cont right"><span class = "quiet">status</span> <span class="status label <?php echo ($status)?"label-success": "label-inverse"?>"><?php echo Packages::getStatusMessage($status); ?></span></span>
		<div class = "row-fluid">
			<div class = "span12">
			<?php if(!$duration['isDue']):?>
				<div class = "picture_frame_mini rounded count_down prepend-top">
					<?php
						$days = $duration['time']['days'];
						$hours = $duration['time']['hours'];
						$minutes = $duration['time']['minutes'];
						$seconds = $duration['time']['seconds'];
					?>
					<div style = "width: 100%; padding: 10px;">
						<span class = "fdays" style = "font-size: 2.0em"><?php echo $days; ?></span><span class = "ldays" style = "font-size: 1.1em; margin-right: 5px;"> day<?php echo (($days != 1)? "s": ""); ?></span>
				 		<span class = "fhours" style = "font-size: 2.0em"><?php echo $hours; ?></span><span class = "lhours" style = "font-size: 1.1em; margin-right: 5px;"> hour<?php echo (($hours != 1)? "s": ""); ?></span>
				 		<span class = "fminutes" style = "font-size: 2.0em"><?php echo $minutes ?></span><span class = "lminutes" style = "font-size: 1.1em; margin-right: 5px;"> minute<?php echo (($minutes != 1)? "s": ""); ?></span>
				 		<span class = "fseconds" style = "font-size: 2.0em"><?php echo $seconds ?></span><span class = "lseconds" style = "font-size: 1.1em; margin-right: 5px;"> second<?php echo (($seconds != 1)? "s": ""); ?></span>
				 	    <span class = "quiet">Count down to delivery</span>				 		
					</div>			 	
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<div class = "row-fluid prepend-top">	
	<div class = "span9">
	<hr>
	<span class = "quiet">
	Ordered From <?php echo CHtml::link("<b>$spName</b>", array("packages/viewByProvider", "id"=>$spId)); ?> on <?php echo $dateOrdered; ?>
	<span class = "right"><i class = "icon-comment"></i> <?php echo CHtml::link("Conversations with  <b>$spName</b>", '#'); ?></span>
	</span>
	<hr>
	</div>	
</div>

<div class = "row-fluid prepend-top">	
	<div class = "span9">
		<div>
			<?php
				 $this->widget('ext.InfoFlash', array(
					'contentCss'=>'info_ok',
					'css'=>'alert-neutral',
				 	'isClosable'=>false,
					'message'=>'<h4>Order received and funds escrowed</h4>
					 <p>Your payment for this order has been escrowed. The service provider will only be paid when you mark this order as satisfactorily fulfilled.</p>'
					));
			 ?>
		</div>
	</div>	
</div>

<div class = "row-fluid prepend-top nf <?php echo ($isReqSent)?"hide":""; ?>">	
	<div class = "span9">
		<div>
			<?php
				 $this->widget('ext.InfoFlash', array(
					'contentCss'=>'info_required',
					'css'=>'alert-warning',
				 	'isClosable'=>false,
					'message'=>'<h4>Service Provider needs the following to get started</h4>
					 <p>'.$instructions.'</p>'
					));
			 ?>
		</div>
	</div>	
</div>



<section id = "conversation" class = "append-bottom prepend-top hide">
	<div class = "row-fluid">
		<div class = "span9">
		<div class = "row-fluid">
					<div class = "span12">
						<hr>
						<div class = "right"><h4>Conversations with <b><?php echo $spName; ?></b></h4></div>
					</div>
				</div>
		</div>
	</div>
	<div class = "row-fluid">
		<div class = "span9 mrows">	
				
			</div>
	  </div>	
	  <div class = "row-fluid">
		<div class = "span9">
		<div class = "row-fluid">
			<div class = "span12">						
				<div class = "pager right">
				
				</div>												
			</div>					
		</div>
		<hr>
		</div>
	</div>
</section>

<div class = "rs row-fluid prepend-top hide">	
	<div class = "span9">
		<div>
			<?php
				 $this->widget('ext.InfoFlash', array(
					'contentCss'=>'info_ok',
					'css'=>'alert-success',
				 	'isClosable'=>true,
					'message'=>'<h4>Requirements Posted.</h4>
					 <p>You message was successully posted to <b>'.$spName.'</b>. The project is expected to be delivered <span id = "ad" class = "bold"></span> from when you supply stated requirements. The countdown begins now (See clock above).</p>'
					));
			 ?>
		</div>
	</div>	
</div>

<section id = "arbitration" style = "<?php echo (!$isReqSent)? "display: none": ""; ?>">
	<?php $this->widget('ext.ServicePackageWidgets.Arbitration');?>
</section>

<section id = "send_message" class = "<?php echo (!$isReqSent)? "hide": ""; ?>">
	<div class = "row-fluid prepend-top">
		<div class = "msg-box span9">
			<div class = "row-fluid">
				<div class = "span12">
						<?php echo CHtml::beginForm(array("packages/sendOrderMessage", 'id'=>$order_id),"post", array('enctype'=>'multipart/form-data', 'id'=>'msg-form'));?>				
					<div class="box">				
						<h4>Send a message to <?php echo $spName; ?></h4>
						<span class = "help-block">Simply type a message and hit the Enter/Return key (Alternatively click the "Send Message" button below.))</span>		
						<div class = "row-fluid alert_container" style = "display: none;">
							<div class = "span10">
									<div class="alert">
										<a class="close" data-dismiss="alert">×</a>
										<strong></strong>
										<span class = "alert_content"></span>
									</div>
							</div>
						</div>
						<?php echo CHtml::textArea("order_msg", "", array('class'=>'order_msg expand span12'));?>				
						<div class = "row-fluid">
							<div class = "span7">
								<div style = "position: relative">
								<span class = "quiet attach_file">Add a file attachment</span>
								<span id = "spinner_1" style = "margin-left: 25px;"></span>
									<div class = "row-fluid">
										<div class = "span12">
										<?php echo CHtml::fileField("order_ar", "", array('style'=>'position: absolute; top: -5px; opacity:0;'));?>								
										</div>
									</div>
								<span id = "muploaded_file" style = "color: #000; font-style: italic;"></span>															
								</div>
							</div>
						</div>	
							
					</div>
					<div class = "row-fluid">
						<div class = "span12">
							<?php echo CHtml::submitButton('Send Message', array('class'=>'btn btn-inverse sm'));?>
						</div>
					</div>
					<?php echo CHtml::endForm(); ?>				
				</div>
			</div>
		</div>
	</div>
</section>


<?php if(!$isReqSent):?>
<div class = "row-fluid prepend-top req_cont">	
	<div class = "span9">
		<div class = "row-fluid">
		<div class = "span2">
		<div style = "float: left; min-width: 30px; background-color: #009933; padding: 5px; color: #fff; font-size: 14px; font-weight: bold;">
			Next Step
		</div>
		<div style = "float: left; width:0px; border-right: 14px solid transparent; border-left: 14px solid #009933; border-top: 14px solid transparent; border-bottom: 14px solid transparent;"></div>
		</div>
		
		<div class = "span10">			
		
			<?php echo CHtml::beginForm(array("packages/requirement", 'id'=>$order_req->id),"post", array('enctype'=>'multipart/form-data', 'id'=>'po_form'));?>
			<h4>Respond to service provider to start this order</h4>
			<div class="box">			
				<div class = "row-fluid alert_container" style = "display: none;">
					<div class = "span10">
							<div class="alert alert-error">
								<a class="close" data-dismiss="alert">×</a>
								<strong>The Following errors occured:</strong>
								<span class = "alert_content"></span>
							</div>
					</div>
				</div>
				<?php echo CHtml::activeTextArea($order_req, 'message', array('cols'=>100, 'rows'=>6, 'class'=>'span12 order_req'));?>
				<div class = "row-fluid">
					<div class = "span12">
						<div style = "position: relative">
						<span class = "quiet attach_file">Add a file attachment</span>
						<span id = "spinner_2" style = "margin-left: 25px;"></span>
							<div class = "row-fluid">
								<div class = "span10">
								<?php echo CHtml::activeFileField($order_req, 'associated_resource', array('style'=>'position: absolute; top: -5px; opacity:0;')); ?>
								</div>
							</div>
						<span id = "uploaded_file" style = "color: #000; font-style: italic;"></span>															
						</div>
					</div>
				</div>	
					
			</div>
			<div class = "row-fluid prepend-top">
				<div class = "span10">
					<div style = "right">
						<?php echo CHtml::submitButton('Send Requirements', array('class'=>'btn btn-inverse')); ?>
					</div>
				</div>
			</div>
			<?php echo CHtml::endForm(); ?>
		</div>
		</div>
	</div>	
</div>
<?php endif; ?>


