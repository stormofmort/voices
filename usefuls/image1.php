

<?php
if(isset($_POST['Submit']))
{
$size = 600; // the thumbnail width
$filedir = 'image/'; // the directory for the original image
$thumbdir = 'image/'; // the directory for the thumbnail image
$prefix = 'small_'; // the prefix to be added to the original name
$maxfile = '200000'; //maximum file size to upload
$mode = '0666';
$userfile_name = $_FILES['image']['name'];
$userfile_tmp = $_FILES['image']['tmp_name'];
$userfile_size = $_FILES['image']['size'];
$userfile_type = $_FILES['image']['type'];
if (isset($_FILES['image']['name']))
{
$prod_img = $filedir.$userfile_name;
$prod_img_thumb = $thumbdir.$prefix.$userfile_name;
move_uploaded_file($userfile_tmp, $prod_img);
chmod ($prod_img, octdec($mode));
$sizes = getimagesize($prod_img);
$aspect_ratio = $sizes[0]/$sizes[1];
if ($sizes[0] <= $size)
{
$new_width = $sizes[0];
$new_height = $sizes[1];
}else{
$new_width = $size;
$new_height = abs($new_width/$aspect_ratio);
}
$destimg=ImageCreateTrueColor($new_width,$new_height) or die('Problem In Creating image');
$srcimg=ImageCreateFromJPEG($prod_img) or die('Problem In opening Source Image');
ImageCopyResampled($destimg, $srcimg, 0, 0, 0, 0, $new_width, $new_height, $sizes[0], $sizes[1]) or die('Problem In resampling');
ImageJPEG($destimg,$prod_img_thumb,90) or die('Problem In saving');
imagedestroy($destimg);
}
print_r($sizes);
echo"width new: $new_width<br>height new: $new_height";
echo '
<br><a href="'.$prod_img.'">
<img src="'.$prod_img_thumb.'" width="'.$new_width.'" heigt="'.$new_height.'">
</a>';
}else{
echo '
<form method="POST" action="'.$_SERVER['PHP_SELF'].'" enctype="multipart/form-data">
<input type="file" name="image"><p>
<input type="Submit" name="Submit" value="Submit">
</form>';
}
?>