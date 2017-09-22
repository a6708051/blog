<!-- 头部公共区块 -->
@include('homeheader')


    <section class="b-wrapper">
        <div class="b-left">
            @foreach($list as $lv)
                <div class="art-list">
                    <article class="art-panel">
                        <header class="art-header">
                            <h2 class="art-title"><a href="{{url('detail/'.$lv['id'])}}">{{$lv['title']}}</a></h2>
                        </header>
                        <div class="art-body">
                            <div class="art-content">{!!htmlspecialchars_decode($lv['content'])!!}}</div>
                        </div>

                        <footer class="art-footer">
                            <span><a href="{{url('detail/'.$lv['id'])}}">详情</a></span>
                        </footer>

                    </article>
                    <aside class="art-date">
                        <p>
                            <span>{{date('Y', strtotime($lv['release_day']))}}年</span>
                            <span>{{date('m', strtotime($lv['release_day']))}}月{{date('d', strtotime($lv['release_day']))}}日</span>
                        </p>
                    </aside>
                </div>
            @endforeach
            <div style="float: right;height: 80px;">{{ $list->render() }}</div>
        </div>

        @include('home.category')

    </section>


<!-- 底部区块 -->
@include('footer')
