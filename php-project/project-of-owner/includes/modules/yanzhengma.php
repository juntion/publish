<?php 


//��������֤��
class randomString
{
 
 function createRandomStr($strLen)
 {
  list($usec, $sec) = explode(' ', microtime());
        (float) $sec + ((float) $usec * 100000);
        
  $number = '';
  $number_len = $strLen;
  $stuff = '1234567890abcdefghijklmnopqrstuvwxyz';//��������ʾ��ΧABCDEFGHIJKLMNOPQRSTUVWXYZ
  $stuff_len = strlen($stuff) - 1;
  for ($i = 0; $i < $number_len; $i++) {
  $number .= substr($stuff, mt_rand(0, $stuff_len), 1);
  }
  return $number;
 }
}
//ͨ��ZD�⽫��֤����ͼƬ
$createStr = new randomString();
$number = $createStr->createRandomStr('4');//��֤���λ��
$number_len = strlen($number);
$_SESSION["VERIFY_CODE"] = $number;

// �����֤��ͼƬ
$img_width = 60;
$img_height = 20;

$img = imageCreate($img_width, $img_height);
ImageColorAllocate($img, 0x6C, 0x74, 0x70);
$white = ImageColorAllocate($img, 0xff, 0xff, 0xff);

$ix = 6;
$iy = 2;
for ($i = 0; $i < $number_len; $i++) {
    imageString($img, 5, $ix, $iy, $number[$i], $white);
    $ix += 14;
}
for($i=0;$i<200;$i++)   //����������� 
{
    $randcolor = ImageColorallocate($img,rand(0,255),rand(0,255),rand(0,255));
    imagesetpixel($img, rand()%100 , rand()%50 , $randcolor);
}

// ���ͼƬ
header("Content-type: " . image_type_to_mime_type(IMAGETYPE_PNG));

imagepng($img);
imagedestroy($img);