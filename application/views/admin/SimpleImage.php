<?php   
/* * File: SimpleImage.php * Author: Simon Jarvis * Copyright: 2006 Simon Jarvis * Date: 08/11/06 * Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php * * This program is free software;
 you can redistribute it and/or * modify it under the terms of the GNU General Public License * as published by the Free Software Foundation;
 either version 2 * of the License, or (at your option) any later version. * * This program is distributed in the hope that it will be useful, * but WITHOUT ANY WARRANTY;
 without even the implied warranty of * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the * GNU General Public License for more details: * http://www.gnu.org/licenses/gpl.html * */   

class SimpleImage 
{
	var $image;
	var $image_type;
	function load($filename) 
	{
		$image_info = getimagesize($filename);
		$this->image_type = $image_info['mime'];
		if( $this->image_type == 'image/jpeg' ) 
		{
			$this->image = imagecreatefromjpeg($filename);

		}
		elseif( $this->image_type == 'image/gif' ) 
		{
			$this->image = imagecreatefromgif($filename);

		}
			elseif( $this->image_type == 'image/png' ) 
		{
		$this->image = imagecreatefrompng($filename);

		}

	}
	function save($filename, $image_type='image/jpeg', $compression=75, $permissions=null) 
	{
		if( $image_type == 'image/jpeg' ) 
		{
			imagejpeg($this->image,$filename,$compression);

		}
		elseif( $image_type == 'image/gif' ) 
		{
			imagegif($this->image,$filename);

		}
		elseif( $image_type == 'image/png' ) 
		{
			imagepng($this->image,$filename);

		}
		if( $permissions != null) 
		{
		chmod($filename,$permissions);

		}

	}
	function output($image_type='image/jpeg') 
	{
		if( $image_type == 'image/jpeg' ) 
		{
			imagejpeg($this->image);

		}
		elseif( $image_type == 'image/gif' ) 
		{
			imagegif($this->image);

		}
		elseif( $image_type == 'image/png' ) 
		{
			imagepng($this->image);

		}

	}
	function getWidth() 
	{
		return imagesx($this->image);

	}
	function getHeight() 
	{
		return imagesy($this->image);

	}
	function resizeToHeight($height) 
	{
		$ratio = $height / $this->getHeight();
		$width = $this->getWidth() * $ratio;
		$this->resize($width,$height);

	}
	function resizeToWidth($width) 
	{
		$ratio = $width / $this->getWidth();
		$height = $this->getheight() * $ratio;
		$this->resize($width,$height);

	}
	function scale($scale) 
	{
		$width = $this->getWidth() * $scale/100;
		$height = $this->getheight() * $scale/100;
		$this->resize($width,$height);

	}

	function resize($width,$height) 
	{
		$new_image = imagecreatetruecolor($width, $height);
		if( $this->image_type == 'image/gif' || $this->image_type == 'image/png' ) 
		{
			$current_transparent = imagecolortransparent($this->image);
			if($current_transparent != -1) 
			{
				$transparent_color = imagecolorsforindex($this->image, $current_transparent);
				$current_transparent = imagecolorallocate($new_image, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
				imagefill($new_image, 0, 0, $current_transparent);
				imagecolortransparent($new_image, $current_transparent);

			}
			elseif( $this->image_type == 'image/png') 
			{
				imagealphablending($new_image, false);
				$color = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
				imagefill($new_image, 0, 0, $color);
				imagesavealpha($new_image, true);

			}

		}
		imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
		$this->image = $new_image;

	}

}
 ?>
