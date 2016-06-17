<?php

$appid = "wxbcb7a1667c4626a0";
$appsecret = "54993b45494154d19785645f88a9b14b";
$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";

$output = https_request($url);
$jsoninfo = json_decode($output, true);

$access_token = $jsoninfo["access_token"];


$jsonmenu = '{
      "button":[
      {
            "type":"view",
            "name":"用力猛戳",
            "url":"http://mp.weixin.qq.com/mp/homepage?__biz=MzIyMzE2MDYzMg==&hid=2&sn=03c1fea15657d178170c80c0d9450ecd#wechat_redirect"      
       },      
       {
            "type":"view",
            "name":"往期回顾",
            "url":"http://mp.weixin.qq.com/mp/getmasssendmsg?__biz=MzIyMzE2MDYzMg==#wechat_webview_type=1&wechat_redirect"
       },
       {
           "name":"关于我们",
           "sub_button":[
            {
               "type":"view",
               "name":"悠居主页",
               "url":"http://yourju.com.cn"
            },
            {
               "type":"view",
               "name":"用户登录",
               "url":"http://yourju.com.cn"
            },
            {
                "type":"view",
                "name":"转载、合作",
                "url":"https://mp.weixin.qq.com/cgi-bin/appmsg?t=media/appmsg_edit&action=edit&lang=zh_CN&token=1941684359&type=10&appmsgid=502865600&isMul=1"
            }]
       

       }]
 }';


$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
$result = https_request($url, $jsonmenu);
var_dump($result);

function https_request($url,$data = null){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

?>