<?php
extract($_REQUEST);
if(isset($url)){
if($url){
if(preg_match('/.*drive.google.com\/.*\/(.*?)\/.*/is',$url,$id)){
$link='https://drive.google.com/uc?export=download&id='.$id[1];
$ua='Mozilla/5.0 (Linux; Android 4.2.1; en-us; Nexus 4 Build/JOP40D) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.166 Mobile Safari/535.19';
$ch=curl_init();
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch,CURLOPT_USERAGENT,$ua);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_COOKIEJAR,'');
curl_setopt($ch,CURLOPT_COOKIEFILE,'');
curl_setopt($ch,CURLOPT_HEADER,true);
curl_setopt($ch,CURLOPT_URL,$link);
$header=curl_exec($ch);
if(preg_match('#confirm=(.*?)&#is',$header,$confirm)){
curl_setopt($ch,CURLOPT_URL,$link.'&confirm='.$confirm[1]);
$header=curl_exec($ch);
}
curl_close($ch);
if(preg_match('/^Location: (.+)$/im',$header,$url)){
$link=trim($url[1]);
if(!preg_match('/.*accounts.google.com\/.*/is',$link)){
if(!isset($show)){
header('Location: '.$link);
exit;
}else{
$text='Đã xong!<form action="'.$link.'"><input value="'.$link.'"><input type="submit" value="Tải về"/></form>';
}}else{
$text='Link chưa bật tính năng chia sẻ!';
}}else{
$text='Không thể get link này!';
}}else{
$text='Link không hợp lệ!';
}}else{
$text='Vui lòng nhập Link!';
}
$html='<div class="list2">'.$text.'</div>';
}
echo '<div class="list1"><form method="post"><input name="url" value="" placeholder="https://drive.google.com/file/d/1-M8TLfpxYmwyW4Z6XJ2CXdRsHRKzM5lF/view?usp=drivesdk"/><input type="hidden" name="show"/><input type="submit" value="Get Link"/></form></div>'.$html;
?>