<div class="col-md-2 navLeft">
    <ul class="list-unstyled">

        @if(Auth::user()->group['type']=='base')

            <li><a href=""><img src="{{asset('icon/1490903058_circle-dashboard-meter-fuel-gauge-outline-stroke.png')}}"
                                alt=""> Dashboard</a></li>
            <li><a href="{{route('createBaseType')}}"><img src="{{asset('icon/variation.PNG')}}" alt="">Create Variation
                </a></li>
            <li><a href="{{route('createPattern')}}"><img src="{{asset('icon/pattern.png')}}" alt="">Create Pattern</a>
            </li>

            <li><a href="{{route('createLayout')}}"><img src="{{asset('icon/layout.png')}}" alt="">Layout Name</a>
            </li>
            <li><a href="{{route('uploadLayout')}}"><img src="{{asset('icon/1489860445_ic_history_48px.png')}}" alt="">Upload
                    Layout</a></li>
            <li><a href="{{route('uploadVersion')}}"><img src="{{asset('icon/1489860445_ic_history_48px.png')}}" alt="">
                    Version</a></li>
            <li><a href="{{route('uploadType')}}"><img src="{{asset('icon/1489860445_ic_history_48px.png')}}" alt="">
                    Type</a></li>
            <li><a href="{{route('getMemberBase')}}"><img src="{{asset('icon/11489856481_user.png')}}">Assign Base
                    Pattern</a></li>
            <li><a href="{{route('listBaseMember')}}"><img src="{{asset('icon/11489856481_user.png')}}">All Base</a>
            </li>
            <li><a href="{{route('baseDirectory')}}"><img src="{{asset('icon/pattern.png')}}" alt="">Directory</a>
            </li>
            <li><a href="{{route('logout')}}"><img src="{{asset('icon/1489860783_SignOut.png')}}" alt=""> Logout</a>
            </li>
        @endif
    </ul>
</div>