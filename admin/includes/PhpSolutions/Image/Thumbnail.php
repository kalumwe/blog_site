<?php
/*PHP Solution 10-1: Getting the Image Details.
  PHP Solution 10-2: Changing Default Values.
  PHP Solution 10-3: Calculating the Thumbnail’s Dimensions.
  PHP Solution 10-4: Generating the Thumbnail Image.
*/

namespace PhpSolutions\Image;

class Thumbnail {
    protected $original;
    protected $originalwidth;
    protected $originalheight;
    protected $basename;
    protected $maxSize = 120;
    protected $imageType;
    protected $destination;
    protected $suffix = '_thb';
    protected $success_messages = [];
	protected $errormessages = [];
	

   public function __construct($image, $destination, $maxSize = 120, $suffix = '_thb') {
    if (is_file($image) && is_readable($image)) {
        $details = getimagesize($image);
    } else {
		throw new \Exception("Cannot open $image.");
    }
    if (!is_array($details)) {
        throw new \Exception("$image doesn't appear to be an image.");
    } else {
    if ($details[0] == 0) {
            throw new \Exception("Cannot determine size of $image.");
    }
        // check the MIME type
        if (!$this->checkType($details['mime'])) {
            throw new \Exception('Cannot process that type of file.');
        }
        $this->original = $image;
        $this->originalwidth = $details[0];
        $this->originalheight = $details[1];
        $this->basename = pathinfo($image, PATHINFO_FILENAME);
		$this->setDestination($destination);
        $this->setMaxSize($maxSize);
        $this->setSuffix($suffix);
    }
   }
	
	/*//Test function	
	public function test() {
	  $ratio = $this->calculateRatio($this->originalwidth, $this->originalheight, $this->maxSize);
      $thumbwidth = round($this->originalwidth * $ratio);
      $thumbheight = round($this->originalheight * $ratio);
      $details = <<<END
<pre>
File: $this->original
Original width: $this->originalwidth
Original height: $this->originalheight
Base name: $this->basename
Image type: $this->imageType
Destination: $this->destination
Max size: $this->maxSize
Suffix: $this->suffix
Thumb width: $thumbwidth
Thumb height: $thumbheight
</pre>
END;
        // Remove the indentation of the preceding line in < PHP 7.3
        echo $details;
        if ($this->messages) {
            print_r($this->messages);
        }
    }*/
	
	public function create() {
	  $ratio = $this->calculateRatio($this->originalwidth, $this->originalheight, $this->maxSize);
      $thumbwidth = round($this->originalwidth * $ratio);
      $thumbheight = round($this->originalheight * $ratio);
	  $resource = $this->createImageResource();
      $thumb = imagecreatetruecolor($thumbwidth, $thumbheight);//(274)
	  imagecopyresampled($thumb, $resource, 0, 0, 0, 0, $thumbwidth, $thumbheight,
        $this->originalwidth, $this->originalheight); //to copy thumb from original 
	  $newname = $this->basename . $this->suffix; //to save thumb
      switch ($this->imageType) {
        case 'jpeg':
            $newname .= '.jpg';
            $success = imagejpeg($thumb, $this->destination . $newname);
            break;
		case 'png':
            $newname .= '.png';
            $success = imagepng($thumb, $this->destination . $newname);
            break;
        case 'gif':
            $newname .= '.gif';
            $success = imagegif($thumb, $this->destination . $newname);
            break;
        case 'webp':
            $newname .= '.webp';
            $success = imagewebp($thumb, $this->destination . $newname);
            break;
      }
	  if ($success) {
         $this->success_messages[] = "$newname created successfully.";
      } else {
         $this->errormessages[] = "Couldn't create a thumbnail for " . basename($this->original);
      }
      imagedestroy($resource);
      imagedestroy($thumb);
	  
	}
	
	public function geterrorMessages() {
        return $this->errormessages;
    }
	
	public function getsuccess_Messages() {
        return $this->success_messages;
    }
	
   protected function checkType($mime) {
        $mimetypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (in_array($mime, $mimetypes)) {
            // extract the characters after '/'
            $this->imageType = substr($mime, strpos($mime, '/')+1);//(262)
            return true;
        }
        return false;
    }
	
	protected function createImageResource() {
        switch ($this->imageType) {
            case 'jpeg':
                return imagecreatefromjpeg($this->original);
            case 'png':
                return imagecreatefrompng($this->original);
            case 'gif':
                return imagecreatefromgif($this->original);
            case 'webp':
                return imagecreatefromwebp($this->original);
        }
    }
	
	
   protected function setDestination($destination) {
       if (is_dir($destination) && is_writable($destination)) {
            $this->destination = rtrim($destination, '/\\') . DIRECTORY_SEPARATOR;
        
        } else {
            throw new \Exception("Cannot write to $destination.");
        }
   }	
   
   protected function setMaxSize($size) {
        if (is_numeric($size) && $size > 0) {
            //$this->maxSize = abs($size);
			$this->maxSize = $size;
        } else {
            throw new \Exception('The value for setMaxSize() must be a positive number.');
        }
   }
   
   protected function setSuffix($suffix) {
        if (preg_match('/^\w+$/', $suffix)) { //(266)
            if (strpos($suffix, '_') !== 0) { //(267)if '_' is not the first
                $this->suffix = '_' . $suffix;
            } else {
                $this->suffix = $suffix;
            }
        }
    }
	
	protected function calculateRatio($width, $height, $maxSize) {
        if ($width <= $maxSize && $height <= $maxSize) {
            return 1;
        } elseif ($width > $height) {
            return $maxSize/$width;
	    } else {
            return $maxSize/$height;
        }
    }
	
	
	
}