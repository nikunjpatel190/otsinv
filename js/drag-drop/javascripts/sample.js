// Generated by CoffeeScript 1.9.3
(function() {
  $(function() {
    var brick;
    brick = "<div class='brick small'><div class='delete'>&times;</div></div>";
    /*$(document).on("click touchend", ".gridly .brick", function(event) {
      var $this, size;
      event.preventDefault();
      event.stopPropagation();
      $this = $(this);
      $this.toggleClass('small');
      $this.toggleClass('large');
      if ($this.hasClass('small')) {
        size = 140;
      }
      if ($this.hasClass('large')) {
        size = 300;
      }
      $this.data('width', size);
      $this.data('height', size);
      return $('.gridly').gridly('layout');
    });*/
    $(document).on("click", ".gridly .delete", function(event) {
      var $this;
      event.preventDefault();
      event.stopPropagation();
      $this = $(this);
      $this.closest('.brick').remove();
      return $('.gridly').gridly('layout');
    });
    $(document).on("click", ".add", function(event) {
      event.preventDefault();
      event.stopPropagation();
	  var stageTxt = $("#stage option:selected").text();
	  var stageVal = $("#stage").val();
	  
	  if(stageVal == "")
	  {
		  alert("Please select process stage");
		  return false;
	  }
	  
	  /*var stageIds = "";
	  $(".gridly .brick h3").each(function(){
	      stageIds += this.id+",";
	  });
	  stageIds = stageIds.slice(0,-1);
	  
	  if(stageIds.indexOf(stageVal) !== -1)
	  {
		  alert('Same stage can not be added');
		  return false;
	  }*/
	  
	  brick = "<div class='brick small'><div class='delete'>&times;</div><h3 id="+stageVal+">"+stageTxt+"</h3></div>";
	  /*brick = "<div class='brick small'><div class='delete'>&times;</div></div><input type='text' name="+stageVal+" id="+stageVal+" value="+stageTxt+">";*/
      $('.gridly').append(brick);
      return $('.gridly').gridly();
    });
    return $('.gridly').gridly();
  });

}).call(this);