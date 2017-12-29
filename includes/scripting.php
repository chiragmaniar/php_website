<head>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script>
	$(document).ready(function(){
		// jQuery methodS ...
		$(".yes").click(function(){
			$(".reveal-if-active").show();
		});
		$(".no").click(function(){
			$(".reveal-if-active").hide();
		});		

		$(".non-vac").click(function(){
			$(".second-reveal").show();
		});
		$(".vac").click(function(){
			$(".second-reveal").hide();
		});
		$(".1").click(function(){
			$(".reveal-if-active").show();
		});
		$(".0").click(function(){
			$(".reveal-if-active").hide();
		});		
		$(".applicable_yes").click(function(){
			$(".reveal-if-active").show();
		});
		$(".applicable_no").click(function(){
			$(".reveal-if-active").hide();
		});	
});
	
	</script>
        <style>
		.reveal-if-active, .second-reveal {display:none;}
		.second-reveal, .reveal-if-active {padding-left:20px;}
		
        </style>
    </head>
