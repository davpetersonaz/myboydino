<?php include('../router.php'); ?>
<?php include(HTMLS_PATH.'templates/header.php'); ?>

<div class="container-fluid">
	<?php include(HTMLS_PATH.$page.'.php'); ?>
</div><!-- //container-fluid -->

<?php include(HTMLS_PATH.'templates/footer.php'); ?>

<script>
$(document).ready(function(){
	//in the background, create any thumbnails that do not exist
	$.post('/ajax/verifyImages.php');
});
</script>
