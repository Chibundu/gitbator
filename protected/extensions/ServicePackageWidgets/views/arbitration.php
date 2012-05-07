<div id = "arbitrate" class = "row-fluid">
		<div class = "span9">
			<div class = "right">
			<?php echo CHtml::link('<i class = "icon-hand-up icon-white"></i> Request Arbitration', '#', array('class'=>'btn btn-danger ra-btn'));?>
			</div>
		</div>
	</div>
	<div class = "a-options row-fluid" style = "display: none">
		<div class = "span9 box_shadow prepend-top" style = "padding: 10px 5px;">
			<div class = "row-fluid">
				<div class = "span4 rtb">
					<div class = "row-fluid">
						<div class = "span12">
							<div style = "width: 5%;float:left;">
								<?php echo CHtml::radioButton("arb", false, array('value'=>'mutual_cancel', 'class'=>'rb'));?>
							</div>
							<div style = "width: 95%; float:left;">
								<div style = "padding: 0px 5px;">
									<div style = "font-size: 1.2em; ">Both Parties Agree to Cancel Job Order</div>
									<div class = "info_alert_mini">Both Parties agree to drop the order. Payment is returned to the buyer's balance. This has no effect on your rating</div>
								</div>								
							</div>
						</div>
					</div>
				
				</div>
				<div class = "span4 rtb">
					<div class = "row-fluid">
						<div class = "span12">
							<div style = "width: 5%;float:left;">
								<?php echo CHtml::radioButton("arb", false, array('value'=>'forced_cancel', 'class'=>'rb'));?>
							</div>
							<div style = "width: 95%; float:left;">
								<div style = "padding: 0px 5px;">
									<div style = "font-size: 1.2em; ">Force Cancel Order</div>
									<div class = "info_alert_mini">Close the order, refund the buyer (has a negative effect on contractor's rating).</div>
								</div>								
							</div>													
						</div>
					</div>				
				</div>
				<div class = "span4 rtb">
					<div class = "row-fluid">					
						<div class = "span12">
							<div style = "width: 5%;float:left;">
								<?php echo CHtml::radioButton("arb", false, array('value'=>'varbitrate', 'class'=>'rb'));?>
							</div>
							<div style = "width: 95%; float:left;">
								<div style = "padding: 0px 5px;">
									<div style = "font-size: 1.2em;">Request Arbitration from the Vcubator</div>
									<div class = "info_alert_mini">Both parties could not come to a mutual agreement. Vcubator arbitrates with a binding settlement on both parties.</div>
								</div>								
							</div>												
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
<div class = "row-fluid prepend-top fcp" style = "display:none;">	
	<div class = "form_cont span12">
		<?php echo CHtml::beginForm(); ?>
		<span class = "help-block quiet">Reason for Cancellation</span>
		<?php echo CHtml::textArea("message", "", array('class'=>'span9 ms')); ?>
		<?php echo CHtml::submitButton('Submit Arbitration Request', array('class'=>'btn btn-inverse'));?>
		<?php echo CHtml::endForm()?>
	</div>
</div>