<ul class="nav nav-tabs">
    <li><a href="{{route('generalProfile')}}">General Info</a></li>
    <li><a href="{{route('accountSettingProfile')}}" >Account Setting</a></li>

    @role('Instructor')
    <li><a href="{{route('socialLink')}}">Profile</a></li>
    @endrole
</ul>
