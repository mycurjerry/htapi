<?php
// 验证服务器URL有效性
$token = '2uiapi';
$signature = $_GET['signature'];
$timestamp = $_GET['timestamp'];
$nonce = $_GET['nonce'];
$echoStr = $_GET['echostr'];

$tokenArray = array($token, $timestamp, $nonce);
sort($tokenArray, SORT_STRING);
$sortedString = implode($tokenArray);
$sha1String = sha1($sortedString);

if ($sha1String == $signature) {
    // 验证成功，返回echostr给微信服务器
    echo $echoStr;
} else {
    // 验证失败
    echo '验证失败';
}

// 处理用户消息
$postData = file_get_contents("php://input");
if (!empty($postData)) {
    $xmlData = simplexml_load_string($postData);
    $fromUser = $xmlData->FromUserName;
    $toUser = $xmlData->ToUserName;
    $msgType = $xmlData->MsgType;
    $content = trim($xmlData->Content);

    if ($msgType === 'text') {
        if ($content === '查询') {
            // 用户发送了"查询"，回复"好的"
            $replyText = '好的';
        } else {
            // 用户输入错误，回复"输入错误"
            $replyText = '输入错误';
        }

        // 构造回复消息
        $responseXml = "<xml>
            <ToUserName><![CDATA[$fromUser]]></ToUserName>
            <FromUserName><![CDATA[$toUser]]></FromUserName>
            <CreateTime>" . time() . "</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[$replyText]]></Content>
        </xml>";

        // 输出回复消息
        echo $responseXml;
    }
}
?>
