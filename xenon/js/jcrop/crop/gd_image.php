<?php
class gd_image{
	
	public function __construct(){}
	public function resize($img,$neww,$newh,$quality=100)
	{
		$sizes = $this->getProperties($img);
		$oldw = $sizes['w'];
		$oldh = $sizes['h'];
		switch($sizes['type'])
		{
			case 'jpg':
				$src_img=imagecreatefromjpeg($img);
				$dst_img=ImageCreateTrueColor($neww,$newh);
				imagecopyresampled($dst_img,$src_img,0,0,0,0,$neww, $newh, $oldw, $oldh);
				imagejpeg($dst_img,$img,$quality); 
				break;
			case 'png':
				$quality = ceil($quality / 10);
				$quality = ($quality == 0)? 9 : (($quality - 1) % 9);
				$src_img=imagecreatefrompng($img);			
				$dst_img=ImageCreateTrueColor($neww,$newh);
				imagealphablending($dst_img, false);
				imagecopyresampled($dst_img,$src_img,0,0,0,0,$neww, $newh, $oldw, $oldh);
				imagesavealpha($dst_img, true);
				imagepng($dst_img,$img, $quality); 
				break;
			case 'gif':
				$src_img=imagecreatefromgif($img);
				$dst_img=ImageCreateTrueColor($neww,$newh);
				imagecopyresampled($dst_img,$src_img,0,0,0,0,$neww, $newh, $oldw, $oldh);
				imagegif($dst_img,$img); 
				break;
		}
		imagedestroy($dst_img); 
		imagedestroy($src_img);
	}
	public function crop($img,$x,$y,$w,$h,$quality=100)
	{
		$sizes = $this->getProperties($img);
		switch($sizes['type']){
			
			case 'jpg':
				$src_img=imagecreatefromjpeg($img);
				$dst_img=ImageCreateTrueColor($w,$h);
				imagecopyresampled($dst_img,$src_img,0,0,$x, $y, $w, $h, $w, $h);
				imagejpeg($dst_img,$img,$quality); 
				break;
			case 'png':
				$quality = ceil($quality / 10);
				$quality = ($quality == 0)? 9 : (($quality - 1) % 9);
				$src_img=imagecreatefrompng($img);			
				$dst_img=ImageCreateTrueColor($w,$h);
				imagealphablending($dst_img, false);
				imagecopyresampled($dst_img,$src_img,0,0,$x, $y, $w, $h, $w, $h);
				imagesavealpha($dst_img, true);
				imagepng($dst_img,$img,$quality); 
				break;
			case 'gif':
				$src_img=imagecreatefromgif($img);
				$dst_img=ImageCreateTrueColor($w,$h);
				imagecopyresampled($dst_img,$src_img,0,0,$x, $y, $w, $h, $w, $h);
				imagegif($dst_img,$img); 
				break;
		}
		imagedestroy($dst_img); 
		imagedestroy($src_img);
	}
	public function copy($src,$dest)
	{
		copy($src,$dest);
	}
	public function getProperties($src)
	{
		$sizes = getimagesize($src);
		$imgtypes = array('1'=>'gif', '2'=>'jpg', '3'=>'png', '4'=>'png');
		return array("w"=>$sizes[0],"h"=>$sizes[1], 'type'=>$imgtypes[$sizes[2]], 'mime'=>$sizes['mime']);
	}
	public function getAspectRatio($w,$h,$to_w,$to_h,$before_crop=false)
	{
		$sizes = array("w"=>0,"h"=>0);
		if($before_crop){ 
			if(($w-$to_w) >= ($h-$to_h))
				$to_w=0;
			else $to_h=0;
		}
		if($to_w != 0 && $to_h != 0){
			$sizes["w"] = $to_w;
			$sizes["h"] = $to_h;
		}
		elseif($to_w != 0){
			$sizes["w"] = $to_w;
			$sizes["h"] = intval(($to_w * $h) / $w);
		}
		elseif($to_h != 0){
			$sizes["w"] = intval(($to_h * $w) / $h);
			$sizes["h"] = $to_h;				
		}
		else{
			$sizes["w"] = $w;
			$sizes["h"] = $h;
		}
		return $sizes;
	}
	public function createName($curr,$alias)
	{		
		return $alias.$curr;
	}
	public function __destruct(){}
}
?>
