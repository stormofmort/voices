<?php
	session_start();

	$error = 0;
	$tracker = 0;
	function uploadImage($i, $articleID, $imageNum, $thumb, $func) {
		global $error, $tracker;
		if ($func == 1) {
			$filename = 'newImage'.$i;
		} else if ($func == 2) {
			$filename = $articleID.'_'.$i;
		}
		$dimensions = getimagesize($_FILES[$filename]['tmp_name']);
		if ( $dimensions[0] > 1000 || $dimensions[1] > 1000 ) {
			++$error;
			$msg = "Image resolution is too large. Max resolution = 1000pixel x 1000pixel";
		}
		
		if ( isset($_FILES[$filename]) ) {
			if ( $_FILES[$filename]['size'] > $_POST['maxFileSize'] ) {
				$msg = "Filesize too big!";
				++$error;
			}
			
			if ( $_FILES[$filename]['size'] == 0 ) {
				$msg = "filesize zero error";
				++$error;
			}
			if ( $_FILES[$filename]['type'] == 'image/png' ) {
				$type = "png";
			} else if ( $_FILES[$filename]['type'] == 'image/jpeg' ) {
				$type = "jpeg";
			} else if ( $_FILES[$filename]['type'] == 'image/jpg' ) {
				$type = "jpg";
			} else if ( $_FILES[$filename]['type'] == 'image/gif' ) {
				$type = "gif";
			} else {
				$msg = "Wrong filetype";
				++$error;
			}
			
			if ( $error == 0 ) {
				$dir = "../images/articlePics/" . $articleID;
				if (!file_exists($dir)) {
					$result = mkdir($dir, 0777);
				}
					$tracker++;
					$upfile = $dir . "/" . $articleID . "_" . ($tracker+$imageNum) . "." . $type;
					
					$sql = "INSERT INTO `imagetable` (
						`imageID` ,
						`articleID` ,
						`imageName` ,
						`imageType` ,
						`imageSubmitDate` ,
						`imageApprovalDate` ,
						`imageStatus` ,
						`imageUserStatus` ,
						`imageThumb` 
					) VALUES (
						NULL , '". $articleID ."', '" . addslashes($articleID . "_" . ($tracker+$imageNum) ) . "', '" . $type . "', NOW(), NULL, '1', '1', '" . $thumb . "'
					)";
				
					if ( !copy($_FILES[$filename]['tmp_name'], $upfile) ) {
						echo "upload failed";
					} else {
						$conn = databaseConnect();
						
						$result = mysql_query($sql, $conn);
						if (!$result) {
							echo "Some database error";
						} else {
							//mysql_free_result($result);
							mysql_close($conn);
						}
					}
			} else {
				echo $msg;
				exit();
			}
		}
	}
?>