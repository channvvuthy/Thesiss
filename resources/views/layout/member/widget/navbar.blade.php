<div class="col-md-2 navLeft">
    <ul class="list-unstyled">

        @if(Auth::user()->group['type']=='base')

            <li><a href=""><img src="{{asset('icon/1490903058_circle-dashboard-meter-fuel-gauge-outline-stroke.png')}}" alt=""> Dashboard</a></li>
            <li><a href="{{route('createPath')}}"><img src="{{asset('icon/1493238617_folder-2.png')}}" alt=""> Your Directory</a></li>
            <li><a href="{{ route('tool') }}"><img src="{{asset('icon/1493238408_settings.png')}}" alt=""> Tool</a></li>
            <li><a href="@if(Auth::check()) @if(!empty(Auth::user()->path)){{route('createBase')}} @else {{route('createPath')}}@endif @endif"><img src="{{asset('icon/variation.PNG')}}" alt="">Create Base
                </a></li>


            <li><a href="{{route('memberViewBase')}}"><img src="{{asset('icon/layout.png')}}" alt="">Your Base</a>
            </li>
            <li><a href="{{route('logout')}}"><img src="{{asset('icon/1489860783_SignOut.png')}}" alt=""> Logout</a>
            </li>
        @endif
    </ul>
</div>