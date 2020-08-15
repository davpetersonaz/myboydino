<?php 
$pictures = new Pictures;
if(isset($_GET['chrono'])){
	$pics = $pictures->getPicturesChronological();
}elseif(isset($_GET['alpha'])){
	$pics = $pictures->getPicturesAlphabetical();
}else{
	$pics = $pictures->getPicturesShuffled();
}
?>

<div class="row">
	<div class="col-sm-12 sort-pics text-center">
		<a href='/pictures.php?chrono' class='btn'>sort chronologically</a>
		<a href='/pictures.php?alpha' class='btn'>sort alphabetically</a>
		<a href='/pictures.php?shuffle' class='btn'>shuffle the order</a>
	</div>
</div>

<div class='pictures row'>

<?php foreach($pics as $picture){ ?>

	<div class='pic-pad col-xs-12 col-sm-6 col-md-4 col-lg-3'>
		<div class='pic-border'>
			<a href='<?=Pictures::PICS_URL.$picture?>'>
				<img class='img-responsive' src='<?=Pictures::PIC_THUMBS_URL.$picture?>'>
				<div class='caption'><p><?=$picture?></p></div>
			</a>

			<div>
<?php if($alreadyLoggedIn){ ?>
				<button class='btn' id='description'>description</button>
<?php } ?>
			</div>
			<!-- this is where i will have the heart, and double-heart (double can only be clicked if the first was clicked more than a month previously) -->
			<!-- glyphicon glyphicon-heart and glyphicon glyphicon-heart-empty -->
			<!-- might as well include a download button -->
			<!-- maybe a "set as screensaver" button?  (naw) -->
			<!-- include a 'flag as inappropriate' for all those sjw's -->
			<!-- maybe there is something else i can do -->
		</div>
	</div>

<?php } ?>

</div>

<script>
$(document).ready(function(){
	
	$('#description').on('click', function()
		
		//show edit-text-box
		
	});
	
});
</script>
