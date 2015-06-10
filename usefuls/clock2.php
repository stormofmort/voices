<?PHP
/*
clock2.php
Generates an analog clock png from the current time
on a transparent background
*/

// Step 1. Create a new blank image
$im = imageCreate(101, 101);

// Step 2. Add Content
// begin by defining the colors used in the image
// this time, the first color defined will become transparent
$background = imageColorAllocate ($im, 0, 0, 0);
$background = imageColorTransparent($im,$background);

$nyphpPurp = imageColorAllocate ($im, 0x70, 0x6D, 0x85); 
$nyphpBlue = imageColorAllocate ($im, 0x1A, 0x1A, 0x73); 
$nyphpGrey = imageColorAllocate ($im, 0xDD, 0xDD, 0xDD); 

// then use those colors to draw a series of overlapping circles
imageFilledEllipse ($im, 50, 50, 100, 100, $nyphpBlue); 
imageFilledEllipse ($im, 50, 50,  90,  90, $nyphpPurp); 
imageFilledEllipse ($im, 50, 50,  75,  75, $nyphpGrey);

// for the hands, calculate the degrees for arc from current time
$hd = imgDegreesFromTime('hour') ;
$md = imgDegreesFromTime('minute') ;
$sd = imgDegreesFromTime('second') ;

// draw the hands using degrees calculated above with small offsets
imageFilledArc ($im, 50, 50, 52, 52, $hd-6, $hd+6, $nyphpPurp, IMG_ARC_PIE); 
imageFilledArc ($im, 50, 50, 65, 65, $md-3, $md+2, $nyphpPurp, IMG_ARC_PIE); 
imageFilledArc ($im, 50, 50, 70, 70, $sd-2, $sd+1, $nyphpBlue, IMG_ARC_PIE); 

// add a final small dot on top
imageFilledEllipse ($im, 50, 50,   5,   5, $nyphpPurp); 

// Steps 3-5. Send headers, image data, & destroy image
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