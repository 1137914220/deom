<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bootstrap 实例 - 水平表单</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css">

    <!--引入JS-->
    <script type="text/javascript" src="/webuploader/webuploader.js"></script>
</head>
<body>

<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="{{url('save')}}">
    @csrf
    <div class="form-group">
        <label for="firstname" class="col-sm-1 control-label">标题</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="firstname"
                   placeholder="请输入标题" name="ttitle">
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-1 control-label">文章作者</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="lastname"
                   placeholder="请输入作者" name="name">
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-1 control-label">文章封面</label>
        <div class="col-sm-10">
            <div id="picker">选择文件</div>
            <p><img src="" alt="" id="ims"></p>
            <input type="hidden" name="img" value="" id="p">
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-1 control-label">摘要</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="lastname"
                   placeholder="请输入摘要" name="lot">
        </div>
    </div>
    <div class="form-group">
        <label for="lastname" class="col-sm-1 control-label">文章作者</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="lastname"
                   placeholder="请输入作者" name="text">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">添加</button>
        </div>
    </div>
</form>

</body>
</html>
<script>
    var uploader = WebUploader.create({
        // 选完文件后，是否自动上传。
        auto: true,
        // swf文件路径
        swf: '/webuploader/Uploader.swf',
        // 文件接收服务端。
        server: '{{url('lotimg')}}',
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#picker',
        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        resize: true,
        // 是否多个文件上传
        multiple:false,
        fileVal:'img',
        formData:{_token:"{{csrf_token()}}"},
        method:"POST"
    });
    // 修改后图片上传前，尝试将图片压缩到1600 * 1600
    uploader.option( 'compress', {
        width: 100,
        height: 100
    });
    uploader.on( 'uploadSuccess', function( file,res ) {
        $('#ims').attr('src',res.data);
        $('#p').val(res.data);
    });


</script>
