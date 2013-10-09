<?php
/**
 * @author bschoene
 * @date   2013-05-13
 */

include("../../controllers/Slider.php");
$slider = new Slider("../../lib/img/slider", "<li class=\"ui-state-default\"><img class=\"slider\" id=\"{FILENAME}\" src=\"{IMAGE_SOURCE}\" title=\"\" alt=\"\" /></li>");

$values = $_GET['order'];
$slider->sortImages($values);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>slider sortable</title>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<style type="text/css">
ul { list-style-type: none; margin: 0; padding: 0; width: 100%; }
li { display: inline; margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; width: 150px; height: 47px; }
li img { max-width: 150px; }
</style>
</head>
<body>
<ul id="slider">
	<?php echo $slider->genSlider(); ?>
</ul>
<script type="text/javascript">
$(function() {
    $("#slider").sortable({
    	update: function() {
            var order = $(this).sortable("serialize");
            $.post("slider.php",
                    order,
                    function() {
            			alert(order);
            		});
    	}
    });
    $("#slider").disableSelection();
});
</script>
</body>
</html>