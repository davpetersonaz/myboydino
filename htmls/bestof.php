<?php
$pictures = new Pictures;
$featured_pics = $pictures->getFeaturedPics();
$best_pics = $pictures->getBestPics();
?>

<?php if(count($featured_pics)>0): ?>

	<div class='row'>
		<div class='col-xs-12 full-width'>
			<a href='<?=Pictures::PICS_URL.$featured_pics[0]?>'>
				<img src='<?=Pictures::FEAT_PICS_URL.$featured_pics[0]?>' class='full-width fancy-image-border'>
			</a>
		</div>
	</div>

	<div class='pictures row'>
		
	<?php foreach($best_pics as $picture): ?>

		<div class='pic-pad col-xs-12 col-sm-6 col-md-4'>
			<div class='pic-border'>
				<a href='<?=Pictures::PICS_URL.$picture?>'>
					<img class='img-responsive' src='<?=Pictures::BEST_THUMBS_URL.$picture?>'>
					<div class='caption'><p><?=$picture?></p></div>
				</a>
			</div>
		</div>

	<?php endforeach; ?>
		
	</div>
		
<?php endif;