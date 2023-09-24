<?php
function stripAnchorTags($string) {
    // 使用正则表达式匹配并替换<a>标签
    $pattern = '/<a\b[^>]*>(.*?)<\/a>/i';
    $replacement = '$1';
    $result = preg_replace($pattern, $replacement, $string);

    // 返回处理后的结果
    return $result;
}

// 验证微信服务器的有效性
$token = "2uiapi"; // 替换成您在微信公众号后台设置的Token
$signature = $_GET["signature"];
$timestamp = $_GET["timestamp"];
$nonce = $_GET["nonce"];
$echostr = $_GET["echostr"];

$tokenList = [$token, $timestamp, $nonce];
sort($tokenList);
$signatureCheck = sha1(implode($tokenList));
$aaa=stripAnchorTags(file_get_contents("http://home.2ui.top/htapi/index.php"));


if ($signatureCheck == $signature) {
    echo $echostr;
    exit;
}

// 处理消息
$postData = file_get_contents("php://input");
$xml = simplexml_load_string($postData, 'SimpleXMLElement', LIBXML_NOCDATA);

$fromUserName = $xml->FromUserName;
$toUserName = $xml->ToUserName;
$msgType = $xml->MsgType;

if ($msgType == "text") {
    $content = "历史上的今天发生了很多事：\n".$aaa; // 回复消息内容
} else {
    $content = "暂时不支持此消息类型的处理";
}

// 构建回复消息
$responseXml = "<xml>
    <ToUserName><![CDATA[$fromUserName]]></ToUserName>
    <FromUserName><![CDATA[$toUserName]]></FromUserName>
    <CreateTime>" . time() . "</CreateTime>
    <MsgType><![CDATA[text]]></MsgType>
    <Content><![CDATA[$content]]></Content>
</xml>";

echo $responseXml;
