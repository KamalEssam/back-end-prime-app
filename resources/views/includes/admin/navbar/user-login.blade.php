<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
<li class="dropdown dropdown-user">
    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
       data-close-others="true">
        <span class="username username-hide-on-mobile">{{ auth()->user()->name }} </span>
        <i class="fa fa-angle-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-default">
        <li>
            <a href="{{ route('user.settings_form') }}">
                <i class="icon-key"></i>{{ ucwords(trans('admin.settings')) }}</a>
        </li>
        <li>
            <a href="{{ route('user.get_about_us') }}">
                <i class="icon-key"></i>{{ ucwords(trans('admin.about_us')) }}</a>
        </li>
        <li>
            <a href="{{ route('user.change_pass_view') }}">
                <i class="icon-key"></i>{{ ucwords(trans('admin.change_pass')) }}</a>
        </li>
        <li>
            <a href="/logout">
                <i class="icon-key"></i>{{ ucwords(trans('admin.log_out')) }}</a>
        </li>
    </ul>
</li>
