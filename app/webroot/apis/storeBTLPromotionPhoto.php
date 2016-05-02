<?php
/**
 * Accepts GET and POST
 * 
 * Each request will be identified by TAG
 * Response will be JSON data
 
  /**
 * check for POST request 
 */


    $file_path = "uploads/merchant/";
    $file_path = $file_path . basename( $_FILES['uploaded_file']['name']);
  

function create_cropped_thumbnail($image_path, $thumb_width, $thumb_height, $prefix) {

    if (!(is_integer($thumb_width) && $thumb_width > 0) && !($thumb_width === "*")) {
        echo "The width is invalid";
        exit(1);
    }

    if (!(is_integer($thumb_height) && $thumb_height > 0) && !($thumb_height === "*")) {
        echo "The height is invalid";
        exit(1);
    }

    $extension = pathinfo($image_path, PATHINFO_EXTENSION);

    switch ($extension) {
        case "jpg":
        case "jpeg":
            $source_image = imagecreatefromjpeg($image_path);
            break;
        case "gif":
            $source_image = imagecreatefromgif($image_path);
            break;
        case "png":
            $source_image = imagecreatefrompng($image_path);
            break;
        default:
            exit(1);
            break;
    }

   $degrees = -90;

   $source_image = imagerotate($source_image, $degrees , 0);

    $source_width = imageSX($source_image);
    $source_height = imageSY($source_image);

    if (($source_width / $source_height) == ($thumb_width / $thumb_height)) {
        $source_x = 0;
        $source_y = 0;
    }

    if (($source_width / $source_height) > ($thumb_width / $thumb_height)) {
        $source_y = 0;
        $temp_width = $source_height * $thumb_width / $thumb_height;
        $source_x = ($source_width - $temp_width) / 2;
        $source_width = $temp_width;
    }

    if (($source_width / $source_height) < ($thumb_width / $thumb_height)) {
        $source_x = 0;
        $temp_height = $source_width * $thumb_height / $thumb_width;
        $source_y = ($source_height - $temp_height) / 2;
        $source_height = $temp_height;
    }

    $target_image = ImageCreateTrueColor($thumb_width, $thumb_height);

    imagecopyresampled($target_image, $source_image, 0, 0, $source_x, $source_y, $thumb_width, $thumb_height, $source_width, $source_height);

	$target_file = pathinfo($image_path, PATHINFO_DIRNAME) . "/thumbnails/";
	$target_file .= pathinfo($image_path, PATHINFO_FILENAME).".".$extension;

    switch ($extension) {
        case "jpg":
        case "jpeg":
            imagejpeg($target_image, $target_file);
            break;
        case "gif":
            imagegif($target_image, $target_file);
            break;
        case "png":
            imagepng($target_image, $target_file);
            break;
        default:
            exit(1);
            break;
    }

    imagedestroy($target_image);
    imagedestroy($source_image);
}


	function createThumbs( $fname, $pathToImages, $pathToThumbs, $thumbWidth ) 
	{
	  // open the directory
	  //$dir = opendir( $pathToImages );

	  // loop through it, looking for any/all JPG files:
	 // while (false !== ($fname = readdir( $dir ))) {
		// parse path for the extension
		$info = pathinfo($pathToImages . $fname);

		// continue only if this is a JPEG image
		if ( strtolower($info['extension']) == 'jpg' ) 
		{
		//  echo "Creating thumbnail for {$fname} <br />";

		  // load image and get image size
		  $img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
		  $width = imagesx( $img );
		  $height = imagesy( $img );

		  // calculate thumbnail size
		  $new_width = $thumbWidth;
		  $new_height = floor( $height * ( $thumbWidth / $width ) );

		  // create a new temporary image
		  $tmp_img = imagecreatetruecolor( $new_width, $new_height );

		  // copy and resize old image into new image 
		  imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
		  $degrees = -90;

		  $tmp_img = imagerotate($tmp_img, $degrees , 0);

		  // save thumbnail into a file
		  imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
		}
	 // }
	  // close the directory
	  closedir( $dir );
	}
	
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {		
		create_cropped_thumbnail("uploads/merchant/".basename( $_FILES['uploaded_file']['name']), 100, 100, "");
		//createThumbs(basename( $_FILES['uploaded_file']['name']),"uploads/retailers/","uploads/retailers/thumbnails/",100);
        echo "success";
    } else{
        echo "fail";
    }
exit;
?>