<div class="col-md-2 navLeft">
    <ul class="list-unstyled">

        @if(Auth::user()->group['type']=='base')
            <li><a href=""><img src="{{asset('icon/1490903058_circle-dashboard-meter-fuel-gauge-outline-stroke.png')}}"
                                alt=""> Dashboard</a></li>
            <li><a href="{{route('createBaseType')}}"><img src="{{asset('icon/1489860110_User_Group copy.png')}}" alt="">Create Variation
                    </a></li>
            <li><a href="{{route('createPattern')}}"><img src="{{asset('icon/11489856481_user.png')}}" alt="">Create Pattern</a>
            </li>

            <li><a href="{{route('createRole')}}"><img src="{{asset('icon/mask-32 copy.PNG')}}" alt=""> Uploade Base</a>
            </li>
            <li><a href=""><img src="{{asset('icon/1489860445_ic_history_48px.png')}}" alt="">Upload Layout</a></li>
            <li><a href="{{route('getSetting')}}"><img src="{{asset('icon/1489860597_SEO_cogwheels_setting.png')}}"
                                                       alt="">Base
                    Rule</a></li>
            <li><a href="{{route('logout')}}"><img src="{{asset('icon/1489860783_SignOut.png')}}" alt=""> Logout</a>
            </li>
        @endif
    </ul>
</div>