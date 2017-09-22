<aside class="b-aside fr">
    <div class="aside-panel">
        <header class="aside-header">
            <h3 class="aside-title">标签</h3>
        </header>
        <ul class="class-list">
            @foreach($category as $cat)
                <li><a href="{{url('/c_id/'.$cat['id'])}}">{{$cat['name']}}</a></li>
            @endforeach
        </ul>
    </div>
</aside>
