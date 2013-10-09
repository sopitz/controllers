<?php
include("../../controllers/Slider.php");
$slider = new Slider("../../lib/img/slider", "");
$filenames = $slider->getFileList();
$slider->sortImages($filenames);
echo "done\n";
?>