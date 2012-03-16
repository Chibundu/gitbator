<?php
$this->breadcrumbs = array(
	'Service Provider'=>array('/serviceproviders'),
	'Profile'=>array('profile/'),
	'Verifications'=>array('verifications'),
	'Verify '.$qual->qual,
); 
$baseUrl = Yii::app()->request->baseUrl;
$holder = $qual->holder;
?>
<h3>Verify  <?php echo $qual->qual?></h3>

<?php $this->widget('ext.bootstrap.widgets.BootAlert'); ?>
<div class="row">
	<div class="span9">
	<?php echo CHtml::beginForm();?>
		<div class="dec_box alt">
		
			<div class="row">
				<div class="span9">
					<div class="dec_row">
						<div class="span3 bold">Qualification</div>
						<div class="span5"><i><?php echo $qual->qual; ?></i></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="span9">
					<div class="dec_row">
						<div class="span3 bold">Reference Number</div>
						<div class="span5"><i><?php echo $qual->ref ?></i></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="span9">
					<div class="dec_row">
						<div class="span3 bold">Date Earned</div>
						<div class="span5"><i><?php echo $qual->sto; ?></i></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="span9">
					<div class="dec_row">
						<div class="span3 bold">Awarding Institution</div>
						<div class="span5"><i><?php echo $qual->institution; ?></i></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="span9">
					<div class="dec_row">
						<div class="span3 bold">Holder</div>
						<div class="span5"><i><?php echo $holder->firstname.' '.$holder->lastname; ?></i></div>
					</div>
				</div>
			</div>
			
			
		</div>
		<div class="actions">
			<?php echo CHtml::submitButton('Send Verification Request', array('name'=>'submit','class'=>'primary btn'));?>
		</div>
		<?php echo CHtml::endForm(); ?>	
	</div>
</div>
