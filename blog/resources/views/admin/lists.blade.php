<!-- 头部公共区块 -->
@include('adminheader')

<section class="wrapper">
    <aside class="b-aside">
        <div class="aside-panel">
            <header class="aside-header">
                <h3 class="aside-title">文章分类</h3>
            </header>
            <ul class="class-list">
                <li>
                    <a class="js-updown" href="javascript:;">原创 <span class="icon-count">{{count($category)}}</span></a>
                    <ul class="sub-class-list">
                        @foreach($category as $cat)
                            <li><a href="{{url('admin/article/'.$cat['id'])}}">{{$cat['name']}}</a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </aside>
    <div class="article-content">
        <ul class="article-list">
            @foreach($list as $lv)
                <li>
                    <div class="art-group">
                        <h1 class="title"><a href="javascript:;">{{$lv['title']}}</a></h1>
                        <div class="title">
                            @foreach($lv['cat_id'] as $cid)
                                {{$category[$cid]['name']}}
                            @endforeach
                        </div>
                        <div class="operate-group">
                            <a href="{{url('admin/editor/'.$lv['id'])}}">编辑</a>
                            <a href="{{url('admin/change/'.$lv['id'])}}">{{$lv['status']>0 ? '关闭' : '发布'}}</a>
                            <a href="javascript:;" values="{{$lv['id']}}" class="js-del-article">删除</a>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        <div style="float: right;">{{$list->render()}}</div>
    </div>
</section>

<!-- 底部区块 -->
@include('footer')