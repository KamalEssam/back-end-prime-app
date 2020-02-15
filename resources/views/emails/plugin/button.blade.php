<div style="text-align: center;margin: 27px 50px;">
    <a href="{{ $link }}"
       style="background-color: {{isset($bg_color) ?  $bg_color : ''}};
              color: #FFF;
              text-decoration: none;
              padding: 8px 10px;
            ">
            {{ $slot }}
    </a>
</div>