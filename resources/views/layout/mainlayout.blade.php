<!DOCTYPE html>
<html lang="en">
  <head>
    @include('layout.partials.head')
  </head>
 <body>
 	<div class="main-div">
	 @include('layout.partials.nav')
	 @yield('content')
	 @include('layout.partials.footer-scripts')
	 @yield('scripts')
	</div>
  </body>
</html>