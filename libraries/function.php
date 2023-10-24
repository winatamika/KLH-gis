	
    <?php
	
	//Mengambil content dari sebuah HTML atau XML
    function getTextContent($content,$length){
		//parsing dan membersihkan tag
		$content = preg_replace("/<xml>[^>]+\>/i", "", $content); 
		$content = preg_replace("/<![^>]+\>/i", "", $content); 
		$content = preg_replace("/<style>[^>]+\>/i", "", $content); 
		$content = preg_replace("/<[^>]+\>/i", "", $content); 
		$content = substr($content,0,$length);
		return $content;
	}
	
	//Mencari nilai terbilang dari sebuah angka
	function Terbilang($x){
	  $abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
	  if ($x < 12)
	    return " " . $abil[$x];
	  elseif ($x < 20)
	    return Terbilang($x - 10) . "belas";
	  elseif ($x < 100)
	    return Terbilang($x / 10) . " Puluh" . Terbilang($x % 10);
	  elseif ($x < 200)
	    return " Seratus" . Terbilang($x - 100);
	  elseif ($x < 1000)
	    return Terbilang($x / 100) . " Ratus" . Terbilang($x % 100);
	  elseif ($x < 2000)
	    return " Seribu" . Terbilang($x - 1000);
	  elseif ($x < 1000000)
	    return Terbilang($x / 1000) . " Ribu" . Terbilang($x % 1000);
	  elseif ($x < 1000000000)
	    return Terbilang($x / 1000000) . " Juta" . Terbilang($x % 1000000);
	}
	
	
	//Menghilangkan SQL injection string pada sebuah query.
	function SQLFilter($val){
		// Karakter yang sering digunakan untuk sqlInjection
		$char = array ('\\','#',';','\'','"',"'",
						'{','}','`','~','%','$','^','&','*','=','+');

		// Hilangkan karakter yang telah disebutkan di array $char
		$cleanval = str_replace($char, '', trim($val));

		return $cleanval;
	}
	
	//mencheck string rawan sql injection atau tidak
	function checkSafeString($val){
		// Karakter yang sering digunakan untuk sqlInjection
		$char = array ('\\','#',';','\'','"',"'","<",">",
						'{','}','`','~','%','$','^','&','*','=','+');
		 $result = true;
		$val=str_split($val);
		foreach($val as $v){
			if (in_array($v,$char)) {
				$result = false;
				break;
			}
		}
		return $result;
	}
	
	//mengambil gambar pertama dari sebuah text/HTML
	function getFirstImage($str){
		$str = stripslashes($str); //membersihkan tanda \ pada string
		$start = strpos($str, '<img'); //mencari posisi <img 
		$sub = substr($str,$start); // sub string dimuali dari <img
		$end = strpos($sub, '>'); // mengambil posisi > dari tag <img
		$vimg = substr($sub,0,$end); // mengambil 1 tag image lengkap content yg lain dibuang
		$src =  strpos($vimg, 'src="'); //mencari posis src="
		$vsrc = substr($vimg,$src); //mengambil sub string src="
		$src =  strpos($vsrc, '"'); //mengambil posisi karakter " pada src
		$vsrc = substr($vsrc,$src+1); //
		$src =  strpos($vsrc, '"');			
		$vsrc = substr($vsrc,0,$src);
		$vsrc = str_replace("%20"," ",$vsrc);
		
		//menghilangkan http://servername
		
		//$sn = $_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"];
		//$x = strpos($sn,"index.php");
		//$sn = substr($sn,0,$x); 
	
		$x = strpos($vsrc,$sn);
		$vsrc = substr($vsrc,$x+strlen($sn));
		
		return $vsrc;
	}
	//menggenerate thumb dari sebuah gambar
	function ganerateThumb($src,$newwidth,$newheight=0,$src_w=0,$src_h=0,$src_x=0,$src_y=0,$newfilename=""){
			//filename
			$arr = explode("/",$src);
			$larr = count($arr);
			$fn = $arr[$larr-1]; //filename image
			//dir
			$dir = "";
			for($i=0;$i<$larr-1;$i++){
				$dir .= $arr[$i]."/";
			}
			//ext
			$arr = explode(".",$fn);
			$larr = count($arr);
			$ext = strtolower($arr[$larr-1]); //ext image
			
			if($newfilename==""){
				$th = $fn."_".$newwidth;	
			}else{
				$th = $newfilename;
			}
			
			$out = false;
			//$dir = "files/image/";
			if(!file_exists($dir.$th)){
				if(($ext=="jpg") || ($ext=="jpeg") || ($ext=="gif") || ($ext=="png")){
					$filename = $src;
					//if(copy($src,$filename)){
					    $target = $dir.$th;
						list($width, $height) = getimagesize($filename);
						if($src_w>0){
							$width = $src_w; 
						}
						if($src_h>0){
							$height = $src_h; 
						}
						
						if(($width>=0) && ($height>=0)){
							//samakan w dan h
							/*if($width<$height){
								$height = $width;
							}else{
								$width = $height;
							}*/
							//$newwidth=150;
							if($newheight==0){
								$newheight=floor($height/$width * $newwidth);
							}
							
							$thumb = imagecreatetruecolor($newwidth,$newheight);
							if(($ext=="jpg") || ($ext=="jpeg")){
								$source = imagecreatefromjpeg($filename);
								$resize = imagecopyresampled($thumb, $source, 0, 0, $src_x, $src_y, $newwidth, $newheight, $width, $height);
								if(imagejpeg($thumb,$target)){
									$out = true;
								}
							}else if($ext=="gif"){
								$source = imagecreatefromgif($filename);
								$resize = imagecopyresampled($thumb, $source, 0, 0, $src_x, $src_y, $newwidth, $newheight, $width, $height);
								if(imagegif($thumb,$target)){
									$out = true;
								}
							}else if($ext=="png"){
								$source = imagecreatefrompng($filename);
								$resize = imagecopyresampled($thumb, $source, 0, 0, $src_x, $src_y, $newwidth, $newheight, $width, $height);
								if(imagepng($thumb,$target)){
									$out = true;
								}
							}				
						}
					//}
				}
			}
			
			return $out; // keluaranya array (img,thumb)
	}
	
	?>