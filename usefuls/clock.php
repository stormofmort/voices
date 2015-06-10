<?PHP
/*
clock1.php
Simple example that generates an analog clock image from the current time
*/

// Step 1. Create a new blank image
$im = imageCreate(101, 101);

// Step 2. Add Content
// begin by defining the colors used in the image
// with imageCreate, the first allocated color becomes the background
$white = imageColorAllocate ($im, 0xFF, 0xFF, 0xFF); 
$other = ImageColorAllocate ($im, 0x8B, 0x45, 0x13); 
$black = imageColorAllocate ($im, 0x00, 0x00, 0x00); 

// then use those colors to draw a series of overlapping circles
imageFilledEllipse ($im, 50, 50, 100, 100, $black); 
imageFilledEllipse ($im, 50, 50,  90,  90, $other); 
imageFilledEllipse ($im, 50, 50,  75,  75, $white);

// for the hands, calculate the degrees for arc from current time
$hd = imgDegreesFromTime('hour') ;
$md = imgDegreesFromTime('minute') ;
$sd = imgDegreesFromTime('second') ;

// draw the hands using degrees calculated above with small offsets
imageFilledArc ($im, 50, 50, 52, 52, $hd-6, $hd+6, $other, IMG_ARC_PIE); 
imageFilledArc ($im, 50, 50, 65, 65, $md-3, $md+2, $other, IMG_ARC_PIE); 
imageFilledArc ($im, 50, 50, 70, 70, $sd-2, $sd+1, $black, IMG_ARC_PIE); 

// add a final small dot on top
imageFilledEllipse ($im, 50, 50,   5,   5, $other); 

// Steps 3-5. Send headers, image data, & destroy image
// refresh won't work for most browsers & not within HTML
header ('Refresh: 1; URL='.$_SERVER['PHP_SELF']); 
header('Content-type: image/png');
imagePNG ($im); 
imageDestroy ($im); 

/**
 * @param $kind string    'hour', 'minute' or 'second'
 * @return int            calculated degrees w/ 0 at 3 o'clock
 * @desc converts the hour, minute or second to 360¼ value
 *       shifted to 3 o'clock for use in GD image functions
 */
function imgDegreesFromTime($kind) {
    switch ($kind) {
        case 'hour' :
            return ((date('g') * 30) + 270) % 360 ; // 30 = 360 / 12 hours
        case 'minute' :
            return ((date('i') * 6)  + 270) % 360 ; //  6 = 360 / 60 minutes
        case 'second' :
            return ((date('s') * 6)  + 270) % 360 ; //  6 = 360 / 60 seconds
    }
}
?> 