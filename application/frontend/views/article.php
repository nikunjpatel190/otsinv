<?php
	include(APPPATH.'views/top.php'); 
?>

<div class="article_title">
	<?php echo $arrPage["title"]; ?>
</div>

<div class="article_box" style="padding:15px;">

	<?php echo $arrPage["content"]; ?>

</div>

<?php 
	include(APPPATH.'views/bottom.php'); 
?>