<!-- 头部公共区块 -->
@include('adminheader')
@include('UEditor::head');

<div class="b-wrapper">
    <div class="editor-content">
        <form action="{{url('admin/save')}}" method="post" class="form editor-form ">
            <input name="id" type="hidden" value="{{$data['id']}}">
            <input name="_token" type="hidden" value="{{csrf_token()}}">
            <div class="form-group">
                <label>标题：</label><input name="title" type="text" placeholder="请输入标题内容" value="{{$data['title']}}">
            </div>
            <div class="form-group editor-cat">
                <ul>
                    @foreach($category as $cat)
                        <li><a>{{$cat['name']}}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="form-group">
                <!--<script id="editor" type="text/plain" style="width:100%;height:500px;"></script>-->
                <textarea type="text/plain" id="editor" name="content" style="width:100%;height:500px;">{{$data['content']}}</textarea>
            </div>
            <div class="form-group clearfix">
                <button type="submit" class="btn btn-bright fr">发布</button>
            </div>
        </form>
    </div>

</div>

<script type="text/javascript">
    var ue = UE.getEditor('editor');
    ue.ready(function () {
        //此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
//        ue.execCommand('serverparam', '_token', );
    });
</script>

<!-- 底部区块 -->
@include('footer')

