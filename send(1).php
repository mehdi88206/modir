<?php
/*

========================================================
وبسایت جهان بات ارائه دهنده انواع سورس ربات و سایت

jahanbot.ir    کانال ما : @JahanBots

#imsoheilofficial-----@jahanbots------#ImSoheilOfficial
========================================================



*/

ini_set('display_errors',1);
error_reporting(E_ALL);

$ne=new mysqli('localhost','eramdate_modir1','-&V#h18}x81_','eramdate_modir');//اطلاعات دیتابیس را به ترتیب جا گذاری کنید

$ne->set_charset('utf8');

$token='6764875463:AAHSy-irxqbxHEn914Vdyo5EXXanH_GxRgI';//توکن 
define('API_KEY',$token);

function Neman($method,$data=[],$token=API_KEY) {
	$ch=curl_init('https://api.telegram.org/bot'.$token.'/'.$method);
	curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>1,CURLOPT_POSTFIELDS=>$data]);
	return json_decode(curl_exec($ch));
}

$fetch=$ne->query("select * from sendall")->fetch_assoc();

if($fetch) {
	$now=$fetch['now'];
	$send=json_decode($fetch['send'],1);
	$for=$send['for']=='gp'?'groups':'members';
	$num=$ne->query("select id from $for")->num_rows;
	$q=$ne->query("select id from $for limit ".($num-$now>=100?100:$num-$now).($now==0?'':" offset $now")) or die('error : '.$ne->error);
	$i=0;
	while(($r=$q->fetch_assoc())!==null) {
		if($send['send']=='forward')
			Neman('forwardmessage',[
				'chat_id'=>$r['id'],
				'from_chat_id'=>$send['chat'],
				'message_id'=>$send['msgid']
			]);
		else
			Neman('send'.$send['send'],[
				'chat_id'=>$r['id'],
				'text'=>$send['caption'],
				'caption'=>$send['caption'],
				$send['send']=>$send['file_id']
			]);
		++$i;
	}
	
	if($now+$i>=$num) {
		$ne->query("delete from sendall where id={$fetch['id']}") or die('error : '.$ne->error);
		Neman('sendmessage',[
			'chat_id'=>$send['chat'],
			'text'=>"ارسال شماره {$fetch['id']} به پایان رسید."
		]);
	}else
		$ne->query("update sendall set now=".($now+$i)." where id={$fetch['id']}");
}



/*

========================================================
وبسایت جهان بات ارائه دهنده انواع سورس ربات و سایت

jahanbot.ir    کانال ما : @JahanBots

#imsoheilofficial-----@jahanbots------#ImSoheilOfficial
========================================================


*/


