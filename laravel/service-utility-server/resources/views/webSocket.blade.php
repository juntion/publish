<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>WebSocket</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim 和 Respond.js 是为了让 IE8 支持 HTML5 元素和媒体查询（media queries）功能 -->
    <!-- 警告：通过 file:// 协议（就是直接将 html 页面拖拽到浏览器中）访问页面时 Respond.js 不起作用 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">

<form id="pushForm" class="form-signin" onsubmit="return showPopover()">
    <h2 class="form-signin-heading">WebSocket</h2>
    <div class="row">
        <div class="col-xs-6 form-group">
            <label for="client_id">client_id</label>
            <input name="client_id" type="text" id="client_id" class="form-control input-sm" placeholder="client_id" required>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 form-group">
            <label for="message">message</label>
            <textarea name="message" type="text" id="message" class="form-control input-sm" placeholder="message" required></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <button id="popover"
                    data-toggle="popover"
                    data-content="推送成功"
                    data-placement="bottom"
                    class="btn btn-sm btn-primary btn-block"
                    type="submit">
                push
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6" style="padding-top: 10px">
            <label>Notification 消息格式</label>
            <pre>{ "type": "notification", "title": "通知标题", "content": "通知内容" }</pre>
        </div>
    </div>
</form>
</div>
<!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
<!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
<script type="application/javascript">
    function showPopover() {
        $.ajax('/webSocket/push', {
            type: 'post',
            data: $("#pushForm").serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(data){
                console.log(data)
                $("#popover").attr('data-content', data.message).popover('show')
                setTimeout(function () {
                    $("#popover").popover('hide')
                }, 3000)
            }
        });
        return false;
    }
</script>
</body>
</html>