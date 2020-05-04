<li>
	<span>
		<a href='{{url(app()->getLocale().'/login')}}'>
			<i class="fa fa-sign-out"></i>
			&nbsp;&nbsp;
            <span class="hidden-xs">@lang('msg.logout')</span>
		</a>
        <span class="hidden-xs"><small> | </small></span>
        <a href='{{url(app()->getLocale().'/account')}}' title="@lang('msg.mio_account')">
            <i class="fa fa-user"></i>
            <span class="hidden-xs">
                &nbsp;&nbsp;
                @lang('msg.mio_account')
            </span>
        </a>
        <small class="hidden-xs"> | </small>

        <a href='{{url(app()->getLocale().'/orders')}}' title="@lang('msg.miei_ordini')">
            <i class="fa fa-book"></i>
            <span class="hidden-xs">
                &nbsp;&nbsp;
                @lang('msg.miei_ordini')
            </span>
        </a>
    </span>
</li>