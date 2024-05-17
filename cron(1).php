<?php

/*

========================================================
وبسایت جهان بات ارائه دهنده انواع سورس ربات و سایت

jahanbot.ir    کانال ما : @JahanBots

#imsoheilofficial-----@jahanbots------#ImSoheilOfficial
========================================================



*/

error_reporting(0);
set_time_limit(60);
$ne=new mysqli('localhost','eramdate_modir1','-&V#h18}x81_','eramdate_modir');//اطلاعات دیتابیس به ترتیب جا گذاری کنید

$token='6764875463:AAHSy-irxqbxHEn914Vdyo5EXXanH_GxRgI';//توکن
define('API_KEY',$token);

function Neman($method,$data=[],$token=API_KEY) {
	$ch=curl_init('https://api.telegram.org/bot'.$token.'/'.$method);
	curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>1,CURLOPT_POSTFIELDS=>$data]);
	return json_decode(curl_exec($ch));
}
$i=0;
while($i<=60) {
$q=$ne->query("select id,del from groups where `del` IS NOT NULL");
	while($r=$q->fetch_assoc()) {
		foreach(json_decode($r['del']) as $msgid=>$time)
			if($time<=time()) {
				Neman('deletemessage',[
					'chat_id'=>$r['id'],
					'message_id'=>$msgid
				]);
				$ne->query("update groups set del='' where id='{$r['id']}'");
			}
	}
sleep(1);
$i++;
}

/*

========================================================
وبسایت جهان بات ارائه دهنده انواع سورس ربات و سایت

jahanbot.ir    کانال ما : @JahanBots

#imsoheilofficial-----@jahanbots------#ImSoheilOfficial
========================================================



*/
