<!-- Sidebar -->
<div class="sidebar" id="sidebar">
			<div class="sidebar-logo">
				<a href="{{route('dashboard')}}">
					<img  src="{{asset('assets/img/logo/home.png')}}" class="img-fluid mb-3" alt="">
				</a>
			</div>
			<div class="sidebar-inner slimscroll">
				<div id="sidebar-menu" class="sidebar-menu">
					<ul>
						<li class="{{ Request::is('dashboard') ? 'active' : '' }} {{ Request::is('dashboard/MH') ? 'active' : '' }}">
							<a href="{{route('dashboard')}}"><i class="fa fa-home"></i> <span>Dashboard</span></a>
						</li>
						
						<li class="{{ Request::is('teams') ? 'active' : '' }}">
							<a href="{{route('teams.index')}}"><i class="fas fa-users"></i> <span>Teams</span></a>
						</li>
						<li class="{{ Request::is('members') ? 'active' : '' }}">
							<a href="{{route('members.index')}}"><i class="fas fa-user-tie"></i> <span>Members</span></a>
						</li>

						<li class="{{ Request::is('activities') ? 'active' : '' }}">
							<a href="{{route('activities.index')}}"><i class="fas fa-calendar"></i> <span>Activities</span></a>
						</li>

						@if(Auth::user()->role_id == 1)
						<li class="{{ Request::is('send-emails') ? 'active' : '' }}">
							<a href="{{route('email.index')}}"><i class="fa fa-envelope" aria-hidden="true"></i> <span>Send Emails</span></a>
						</li>
						@endif
						
						<li class="{{ Request::is('change-password') ? 'active' : '' }}">
							<a href="{{route('password.change')}}"><i class="fa fa-key" aria-hidden="true"></i> <span>Password</span></a>
						</li>

						<li class="">
							<a href="{{route('logout')}}"><i class="fas fa-sign-out-alt" aria-hidden="true"></i> <span>Logout</span></a>
						</li>
						
					</ul>
				</div>
			</div>
		</div>
		<!-- /Sidebar -->