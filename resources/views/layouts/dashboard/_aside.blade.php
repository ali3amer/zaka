<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('dashboard_files/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">
            <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-th"></i><span>@lang('site.dashboard')</span></a>
            </li>
            {{--            @if (auth()->user()->hasPermission('read_users'))--}}
            <li>
                <router-link to="/users"><i class="fa fa-users"></i><span>المستخدمين</span></router-link>
            </li>
            {{--            @endif--}}
            {{--            @if (auth()->user()->hasPermission('read_crops'))--}}
            <li>
                <router-link to="/crops"><i class="fa fa-tree"></i><span>المحاصيل</span></router-link>
            </li>
            {{--            @endif--}}
            {{--            @if (auth()->user()->hasPermission('read_states'))--}}
            <li>
                <router-link to="/states"><i class="fa fa-map"></i><span>الولايات</span></router-link>
            </li>
            {{--            @endif--}}
            {{--            @if (auth()->user()->hasPermission('read_towns'))--}}
            <li>
                <router-link to="/towns"><i class="fa fa-university"></i><span>المحليات</span></router-link>
            </li>
            {{--            @endif--}}
            {{--            @if (auth()->user()->hasPermission('read_offices'))--}}
            <li>
                <router-link to="/offices"><i class="fa fa-map-marker"></i><span>المكاتب</span></router-link>
            </li>
            {{--            @endif--}}
            {{--            @if (auth()->user()->hasPermission('read_zones'))--}}
            <li>
                <router-link to="/zones"><i class="fa fa-road"></i><span>المناطق</span></router-link>
            </li>
            {{--            @endif--}}
            {{--            @if (auth()->user()->hasPermission('read_delegates'))--}}
            <li>
                <router-link to="/delegates"><i class="fa fa-user-secret"></i><span>المناديب</span></router-link>
            </li>
            {{--            @endif--}}
            {{--            @if (auth()->user()->hasPermission('read_books'))--}}
            <li>
                <router-link to="/books"><i class="fa fa-book"></i><span>الدفاتر</span></router-link>
            </li>
            {{--            @endif--}}
            {{--            @if (auth()->user()->hasPermission('read_books'))--}}
            <li>
                <router-link to="/receipts"><i class="fa fa-file-text"></i><span>الإيصالات</span></router-link>
            </li>
            {{--            @endif--}}
        </ul>

    </section>

</aside>

