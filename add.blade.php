<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bootstrap 实例 - 基本的表格</title>

    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <!-- DataTables -->
    <script type="text/javascript" charset="utf8" src="http://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
{{--    <link rel="stylesheet" href="/layer/layer/css/layui.css?t=1611854082986" media="all">--}}
</head>
<body>

<!--第二步：添加如下 HTML 代码-->
<table id="table_id_example" class="display">
    <thead>
    <tr>
        <th>ID</th>
        <th>标题</th>
        <th>作者</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $v)
    <tr>
        <td>{{$v->id}}</td>
        <td>{{$v->ttitle}}</td>
        <td>{{$v->name}}</td>
        <td><a href="#"  class="del" lot="{{$v->id}}" >删除</a></td>
    </tr>
    @endforeach
    </tbody>
</table>
<div>
    <button><a href="{{url('tian')}}">添加表单</a></button>
</div>
</body>
</html>
<script>
    // <!--第三步：初始化Datatables-->
    $(document).ready( function () {
        $('#table_id_example').DataTable();
    } );


    $('.del').click(function () {
        var id=$(this).attr('lot');
        $.ajax({
            type: "POST",
            url: "{{url('delete')}}",
            data: {id:id,_token:"{{csrf_token()}}"},
            success: function(msg){
                if(msg.code==200){
                    alert('删除成功');
                }
            }
        });
    })
</script>




