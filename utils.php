<?php
  // List files in folder $dir
  function getFileList($dir){
    // array to hold return value
    $retval = [];

    // add trailing slash if missing
    if(substr($dir, -1) != "/") {
      $dir .= "/";
    }

    // open pointer to directory and read list of files
    $d = @dir($dir) or die("getFileList: Failed opening directory {$dir} for reading");
    while(FALSE !== ($entry = $d->read())) {
      // skip hidden files
      if($entry[0] == ".") continue;
      if(is_dir("{$dir}{$entry}")) {
        $retval[] = [
          'name' => "{$dir}{$entry}/",
          'type' => filetype("{$dir}{$entry}"),
          'size' => 0,
          'lastmod' => filemtime("{$dir}{$entry}")
        ];
      } elseif(is_readable("{$dir}{$entry}")) {
        $retval[] = [
          'name' => "{$dir}{$entry}",
          'type' => mime_content_type("{$dir}{$entry}"),
          'size' => filesize("{$dir}{$entry}"),
          'lastmod' => filemtime("{$dir}{$entry}")
        ];
      }
    }
    $d->close();

    return $retval;
  }

  function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth ){
    // open the directory
    $dir = opendir( $pathToImages );

    // loop through it, looking for any/all JPG files:
    while (false !== ($fname = readdir( $dir ))) {
      // parse path for the extension
      $info = pathinfo($pathToImages . $fname);
      // continue only if this is a JPEG image
      if ( strtolower($info['extension']) == 'jpg')
      {
        //echo "Creating thumbnail for {$fname} <br />";

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

        // save thumbnail into a file
        imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
      }
    }
    // close the directory
    closedir( $dir );
  }


?>
