<?php

class UserImage {
	
	private $userID;
	private $userImage;
	private $newWidth;
	private $newHeight;
	private $origWidth;
	private $origHeight;


	private function __construct() {
		
	}
	
	
	public static function getImageConstructor($userID, $width, $height) {
		
		$userImage = new UserImage();
		
		$userImage->userID = Verifier::validateNumber($userID);
		$userImage->newWidth = Verifier::validateDimension($width);
		$userImage->newHeight = Verifier::validateDimension($height);
		
		$pathToImages = GlobalSettings::getGlobalSettings()->getPathToImages();
		
		$imagePath = $pathToImages . $userImage->userID . ".jpg";
		$defaultImagePath = $pathToImages . "default.jpg";
		$facebookImagePath = $pathToImages . $userImage->userID . "_fb.jpg";
		
		$userImage->userImage = @imagecreatefromjpeg($imagePath);

		if(!$userImage->userImage) {
			$userImage->userImage = @imagecreatefromjpeg($facebookImagePath);

    		if(!$userImage->userImage)
				$userImage->userImage = @imagecreatefromjpeg($defaultImagePath);
			
		}
		
		return $userImage;
		
	}
	
	
	public static function setImageConstructor($imagePath, $type) {
		
		$userImage = new UserImage();
		
		if ($type == 'image/pjpeg' || $type == 'image/jpeg' || $type == 'image/JPG')
			$userImage->userImage = @imagecreatefromjpeg($imagePath);
		else if ($type == 'image/X-PNG' || $type == 'image/PNG' || $type == 'image/png')
			$userImage->userImage = @imagecreatefrompng($imagePath);
		else if ($type == 'image/gif' || $type == 'image/GIF')
			$userImage->userImage = @imagecreatefromgif($imagePath);
		
		Verifier::validateImageCreated($userImage->userImage);
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$imageSizeAR = getimagesize($imagePath);

		$userImage->origWidth = $imageSizeAR[0];
		$userImage->origHeight = $imageSizeAR[1];
		
		return $userImage;
		
		
	}
	
	
	public static function saveImageToFile($url, $path) {
		
		  $urlImage = @fopen($url, "r");
		  $buffer = "";
		  
		  try {
			  
			 if ($urlImage) {
			  
				 while (!feof($urlImage))		  
					 $buffer .= fgets($urlImage, 4096);
			  
				 fclose($urlImage);
			  
			 }
			 else
			 	throw new ValidationException("Image saving failed.", 4);
		  
			 $imageFile = fopen($path, "wb");
		  
			 $numbytes = fwrite($imageFile, $buffer);
		  
			 fclose($imageFile);
			 
		  }
		  
		  catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		  }

		
	}
	
	
	public function displayImage() {
		
		$outputImage = imagecreatetruecolor($this->newWidth, $this->newHeight);
		
		// Resize
		imagecopyresized($outputImage, $this->userImage, 0, 0, 0, 0, $this->newWidth, $this->newHeight, 50, 50);
		
		imagejpeg($outputImage);
		
	}
	
	
	public function saveUploadedImage($imageID) {
		
		$newWidth = $this->origWidth > $this->origHeight ? ceil((50/$this->origHeight) * $this->origWidth) : 50;
		$newHeight = $this->origHeight > $this->origWidth ? ceil((50/$this->origWidth) * $this->origHeight) : 50;
		
		$newX = $newWidth > $newHeight ? ceil(($newWidth - 50) / 2) : 0;
		$newY = $newHeight > $newWidth ? ceil(($newHeight - 50) / 2) : 0;
				
		$tempImageOne = imagecreatetruecolor($newWidth,$newHeight);

		imagecopyresampled($tempImageOne,$this->userImage,0,0,0,0,$newWidth,$newHeight,$this->origWidth,$this->origHeight);
		
		$tempImageTwo = imagecreatetruecolor(50,50);
		
		imagecopyresampled($tempImageTwo,$tempImageOne,0,0,$newX,$newY,50,50,50,50);
		
		$pathToImages = GlobalSettings::getGlobalSettings()->getPathToImages();
		
		$ins = $imageID == NULL ? $_SESSION['user_id'] : $imageID;

		imagejpeg($tempImageTwo,$pathToImages . $ins . ".jpg");
		
	}
	
	public static function tryTransferRegisterImage() {

		if (!isset($_SESSION['imageID']))
			return false;
	
		$userImage = new UserImage();
			
		$pathToImages = GlobalSettings::getGlobalSettings()->getPathToImages();
		
		$imagePath = $pathToImages . $_SESSION['imageID'] . ".jpg";

		$userImage->userImage = @imagecreatefromjpeg($imagePath);
		$userImage->middleX = 0;
		$userImage->middleY = 0;
		
		if ($userImage->userImage) {
			$userImage->saveUploadedImage(NULL);
			unlink($imagePath);
			unset($_SESSION['imageID']);			
		}
		
	}
	

}

?>