<ul class="page-breadcrumb">


    @foreach($tree as $branch)
        <li>
            <a href="{{ $branch['href'] }}">{{ $branch['page'] }}</a>
            <i class="fa fa-circle"></i>
        </li>
    @endforeach

    <li>
        <span>{{ $current }}</span>
    </li>
</ul>