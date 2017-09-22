<!-- 头部公共区块 -->
@include('homeheader')


    <section class="b-wrapper">
        <div class="b-left">
            <article class="con-panel">
                <header class="con-header">
                    <h1 class="con-title">{!! htmlspecialchars_decode($data['title']) !!}</h1>
                </header>
                <div>
                    {!! htmlspecialchars_decode($data['content']) !!}
                </div>
            </article>
        </div>

        @include('home.category')

    </section>


<!-- 底部区块 -->
@include('footer')
