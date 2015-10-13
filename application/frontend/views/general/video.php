<?php
	include(APPPATH.'views/general/header.php');  
?>

<div id="tabs">

	<ul>
		<li><a href="#tab1" style="width:435px;text-align:center;">Employer</a></li>
        <li><a href="#tab2" style="width:435px;text-align:center;">Intern</a></li>
	</ul>
    
    <div class="round_box_dark" id="tab1">
        <iframe width="560" height="315" src="http://www.youtube.com/embed/j7giq6EuPxI" frameborder="0" allowfullscreen>
        </iframe>
    </div>
    
    
    <div class="round_box_dark" id="tab2">
        <iframe width="560" height="315" src="http://www.youtube.com/embed/qlnJbg_AZ1E" frameborder="0" allowfullscreen>
        </iframe>
    </div>
    
</div>


<script type="text/javascript">

$(document).ready(function() {
  
	$(function() {
		$( "#tabs" ).tabs();
	});
  
});

</script>

<?php
	include(APPPATH.'views/general/footer.php'); 
?>