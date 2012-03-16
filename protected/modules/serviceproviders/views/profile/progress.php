<div class = "row-fluid">
<div class = "span12">
<div class = "progress_tracker">
<ul>
<?php 
	$titles = array('Address', 'Services', 'Personal Details', 'Company Details');
	$level = 2;
	$numberOfSteps = 4;
	for($i = 1; $i <= $numberOfSteps; $i++):		
?>
<li
<?php 
	if($i == $level){ 
 		echo 'class = "active" ';
	} 
 	elseif($i < $level){
 		echo 'class = "past" ';
 	}
 	if($i == ($numberOfSteps))
 	{
 		echo 'id="lastStep" ';
 	}

 	echo 'style = "width:'.(100/$numberOfSteps).'%;"';
 ?>

><span><a href="" title = ""><?php echo $i; ?>. <?php echo $titles[$i-1]; ?></a></span></li>


<?php endfor;?>
</ul>
</div>
</div>
</div>