<div class="row prepend-top">

	<div class="span4 prepend-top">	
	<?php $this->beginWidget('zii.widgets.jui.CJuiDraggable', array(
   	 'options'=>array(
     	   'cursor'=>'move',
   		 ),    
	));
	?>
		<div class="dashboard_panel">
		<div class = "db-head top-rounded top-rounded">
		<h3>Jobs</h3>
		</div>
		<div class = "dashboard_content">
			<div class = "db-item-row-first">
				<div class = "three-quarters">
					Jobs in progress
				</div>
				<div  class = "one-quarter">
					<?php echo $dashboard['jobsInProgress']; ?>
				</div>
			</div>
			
			<div class = "db-item-row">
				<div class = "three-quarters">
					Completed Jobs
				</div>
				<div  class = "one-quarter">
					<?php echo $dashboard['completedJobs']; ?>
				</div>
			</div>
			<div class = "db-item-row">
				<div class = "three-quarters">
					Active Job Proposals
				</div>
				<div  class = "one-quarter">
					<?php echo $dashboard['activeJobProposals']; ?>
				</div>
			</div>
			<div class = "db-item-row">
				<div class = "three-quarters">
					Job Requests
				</div>
				<div  class = "one-quarter">
					<?php echo $dashboard['jobRequests']; ?>
				</div>
			</div>
					
		</div>		
				
		</div>
		<?php $this->endWidget();?>
	</div>
		<div class="span4 prepend-top">	
	<?php $this->beginWidget('zii.widgets.jui.CJuiDraggable', array(
   	 'options'=>array(
     	   'cursor'=>'move',
   		 ),    
	));
	?>
		<div class="dashboard_panel">
			<div class = "db-head top-rounded">
			<h3>Messages</h3>
			</div>
			<div class = "dashboard_content">
				<div class = "db-item-row-first">
					<div class = "three-quarters">
						Inbox
					</div>
					<div  class = "one-quarter">
						<?php echo $dashboard['inbox']; ?>
					</div>
				</div>			
				
				
				<div class = "db-item-row">
					<div class = "three-quarters">
						Job Request Alerts
					</div>
					<div  class = "one-quarter">
						<?php echo $dashboard['jobRequestAlerts'];  ?>
					</div>
				</div>
				<div class = "db-item-row">
					<div class = "three-quarters">
						Proposal Messages
					</div>
					<div  class = "one-quarter">
						<?php echo $dashboard['proposalMessages']; ?>
					</div>
				</div>
		
			</div>					
		</div>
		<?php $this->endWidget();?>
	</div>
		<div class="span4 prepend-top">	
	<?php $this->beginWidget('zii.widgets.jui.CJuiDraggable', array(
   	 'options'=>array(
     	   'cursor'=>'move',
   		 ),    
	));
	?>
		
		<div class="dashboard_panel">
			<div class = "db-head top-rounded">
			<h3>Ratings and Reviews</h3>
			</div>
			<div class = "dashboard_content">
				<div class = "db-item-row-first">
					<div class = "three-fifths">
						Average
					</div>
					<div  class = "two-fifths">
						<?php $this->widget('CStarRating',array(
							'minRating'=>1,
							'maxRating'=>5,		
			    			'name'=>'rating',
			    			'value'=>$dashboard['ratings'],
			   				'readOnly'=>true,
							//'htmlOptions'=>array('style'=>'text-align:;'),
						)); ?>
					</div>
				</div>					
		
			</div>					
		</div>				
		
		<?php $this->endWidget();?>
	</div>


	
	
</div>
<div class="row prepend-top">

	<div class="span4 prepend-top">	
	<?php $this->beginWidget('zii.widgets.jui.CJuiDraggable', array(
   	 'options'=>array(
     	   'cursor'=>'move',
   		 ),    
	));
	?>
		<div class="dashboard_panel">
			<div class = "db-head top-rounded">
			<h3>My Purse</h3>
			</div>
			<div class = "dashboard_content">
				<div class = "db-item-row-first">
					<div class = "three-quarters">
						Account Balance
					</div>
					<div  class = "one-quarter">
						$<?php echo number_format($dashboard['accountBalance'], 2); ?>
					</div>
				</div>			
				
				
				<div class = "db-item-row">
					<div class = "three-quarters">
						Earnings
					</div>
					<div  class = "one-quarter">
						$<?php echo number_format($dashboard['earnings'], 2); ?>
					</div>
				</div>
				<div class = "db-item-row">
					<div class = "three-quarters">
						Escrowed
					</div>
					<div  class = "one-quarter">
						$<?php echo number_format($dashboard['escrowedFunds'], 2); ?>
					</div>
				</div>
		
			</div>					
		</div>
		<?php $this->endWidget();?>
	</div>
		<div class="span4 prepend-top">	
	<?php $this->beginWidget('zii.widgets.jui.CJuiDraggable', array(
   	 'options'=>array(
     	   'cursor'=>'move',
   		 ),    
	));
	?>
		<div class="dashboard_panel">
			<div class = "db-head top-rounded">
			<h3>My Account</h3>
			</div>
			<div class = "dashboard_content">
				<div class = "db-item-row-first">
					<div class = "three-quarters">
						Subscription Package
					</div>
					<div  class = "one-quarter">
						<?php echo $dashboard['subscriptionPackage']; ?>
					</div>
				</div>			
				
				
				<div class = "db-item-row">
					<div class = "three-quarters">
						Last Logged In
					</div>
					<div  class = "one-quarter">
						<?php echo $dashboard['lastLoggedIn']; ?>
					</div>
				</div>				
		
			</div>					
		</div>
		<?php $this->endWidget();?>
	</div>
		<div class="span4 prepend-top">	
	<?php $this->beginWidget('zii.widgets.jui.CJuiDraggable', array(
   	 'options'=>array(
     	   'cursor'=>'move',
   		 ),    
	));
	?>
		<div class="dashboard_panel">
			<div class = "db-head top-rounded">
			<h3>Other Information</h3>
			</div>
			<div class = "dashboard_content">
				<div class = "db-item-row-first">
				Billings and Payments							
				</div>			
				
				
				<div class = "db-item-row">
				Terms and Condition
				</div>				
		
			</div>					
		</div>
		<?php $this->endWidget();?>
	</div>


	
	
</div>