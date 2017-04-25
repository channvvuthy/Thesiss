<div class="col-md-2 navLeft">
    <ul class="list-unstyled">

        @if(Auth::user()->group['type']=='base')

            <li><a href=""><img src="{{asset('icon/1490903058_circle-dashboard-meter-fuel-gauge-outline-stroke.png')}}" alt=""> Dashboard</a></li>
            <li><a href="{{route('createPath')}}"><img src="{{asset('icon/1490903058_circle-dashboard-meter-fuel-gauge-outline-stroke.png')}}" alt=""> Your Directory</a></li>
            <li><a href="@if(Auth::check()) @if(!empty(Auth::user()->path)){{route('createBase')}} @else {{route('createPath')}}@endif @endif"><img src="{{asset('icon/variation.PNG')}}" alt="">Create Base
                </a></li>


            <li><a href="{{route('createLayout')}}"><img src="{{asset('icon/layout.png')}}" alt="">Your Base</a>
            </li>
            <li><a href="{{route('logout')}}"><img src="{{asset('icon/1489860783_SignOut.png')}}" alt=""> Logout</a>
            </li>
        @endif
    </ul>
</div>