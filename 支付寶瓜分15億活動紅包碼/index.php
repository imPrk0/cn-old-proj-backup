<?php

// 搜索碼
$number = '';

// 紅包二維碼地址 (支付寶紅包碼圖片直接連結)
$qrCode = '';

$phone = false;
$isWeixin = false;
$alert = '搜索码复制成功，请在支付宝首页粘贴搜索！';

$alipayUrl = '#';
if (checkMobile()) {
    $phone = true;
    $alipayUrl = 'alipays://';
}

if (!!strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')) {
    $phone = true;
    $isWeixin = true;
    $alert = "搜索码复制成功,请在支付宝APP首页粘贴搜索!";
}

function checkmobile() {
    return (
        dstrpos(strtolower($_SERVER['HTTP_USER_AGENT']), [
                'android', 'midp', 'nokia', 'mobile',
                'iphone', 'ipod', 'blackberry', 'windows phone'
            ])
        || strexists($_SERVER['HTTP_ACCEPT'], 'VND.WAP')
        || strexists($_SERVER['HTTP_VIA'], 'wap')
    );
}

function strexists($string, $find) {
    return !!strpos($string, $find);
}

function dstrpos($string, $arr) {
    if (empty($string)) return false;
    foreach ((array) $arr as $v) {
        if (!!strpos($string, $v) !== false) return true;
    }
    return false;
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="author" content="Prk" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
        <title>仅需两步瓜分支付宝15亿</title>
        <meta name="keywords" content="支付宝,红包,瓜分,15亿,活动" />
        <meta name="description" content="支付宝15亿红包活动，瓜分15亿红包，支付宝红包活动" />
        <script type="text/javascript" src="https://cdn.staticfile.net/jquery/1.8.3/jquery.min.js"></script>
        <script type="text/javascript">
            document.onmousedown = e => {
                var e = event || window.event || arguments.callee.caller.arguments[0];
                if (2 == e.button || 3 == e.button) alert('感谢您的使用');
            };

            document.oncontextmenu = new Function('return void 0;');

            document.onkeydown = document.onkeyup = document.onkeypress = e => {
                var e = event || window.event || arguments.callee.caller.arguments[0];
                if (e && 123 === e.keyCode) {
                    alert('感谢您的使用');
                    e.returnValue = false;
                    return void 0;
                }
            };

            let copied = true;
            const isWeixin = <?php echo $isWeixin ? 'true' : 'false'; ?>;
        </script>
    </head>
    <body>
        <div>
            <?php if ($phone) { ?>
                <span class="title">两步瓜分支付宝15亿</span>
                <br /><br />
                <button data-clipboard-text="<?=$number?>" class="step1 button">
                    第一步:&nbsp;点击复制搜索码
                </button>
                <div id="tips" style="visibility: hidden;">
                    <small id="small">请点击上方按钮复制搜索码</small>
                    <div class="numbers">
                        <ul class="number">
                            <?=$number?>
                        </ul>
                    </div>
                </div>
                <a class="button" href="alipays://" onclick="return check();">
                    第二步:&nbsp;点击唤起支付宝
                </a>
                <br /><br />
                <img src="./mobile.jpg" width="100%" />
                <br /><br />
            <?php } else { ?>
                <h3>请使用支付宝&nbsp;APP&nbsp;扫描下方二维码</h3>
                <img src="./scan.jpg" width="100%" />
                <br /><br />
                <img src="<?=$qrCode?>" width="100%" />
            <?php }; ?>

            <footer>
                蚂蚁金服&nbsp;|&nbsp;支付宝&nbsp;APP&nbsp;|&nbsp;Prk
            </footer>
        </div>
        <script type="text/javascript">
            const check = () => {
                if (!copied) {
                    alert('请您先确保已完成第一步！');
                    return void 0;
                }

                if (isWeixin) {
                    alert('微信中无法唤起支付宝，请您手动打开支付宝 APP');
                    return void 0;
                }

                return true;
            };

            var clipboard = new Clipboard('.step1');
            clipboard.on('success', e => {
                copied = true;
                $('#small').css('margin-top', '28px');
                $('#small').text('成功复制搜索码！');
                $('#tips').css('visibility', 'visible');
                alert('<?=$alert?>');
                e.clearSelection();
            });

            clipboard.on('error', e => {
                copied = true;
                $('#small').css('margin-top', '28px');
                $('#tips').css('visibility', 'visible');
                alert('复制失败，请手动复制页面上的搜索码！');
            });
        </script>
    </body>
</html>
