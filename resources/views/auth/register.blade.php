@extends('layout.app')

@section('title')
Inscription

@endsection
@section('content')


<div class="clear-loading spinner">
		<span></span>
	</div>
	<div class="w3ls-login box box--big">
	
		<form action="{{ route('register.processing') }}" method="POST">
			@csrf 

			<div class="agile-field-txt">
				<label><i class="fa fa-user" aria-hidden="true"></i> Username </label>
				<input type="text" name="username" placeholder="Enter User Name" required="" />
			</div>

            <div class="agile-field-txt">
			
				<label><i class="fa fa-envelope" aria-hidden="true"></i>Email</label>
				<input type="text" name="email" placeholder="email" required="" />
			</div>

			<div class="agile-field-txt">
				<label><i class="fa fa-unlock-alt" aria-hidden="true"></i> password </label>
				<input type="password" name="password" placeholder="Enter Password" required="" id="myInput" />
				
                <div class="agile-field-txt">
				<label><i class="fa fa-unlock-alt" aria-hidden="true"></i> Confirm password </label>
				<input type="password" name="ConfirmPassword" placeholder="Confirm Password" required="" id="myInput" />
				
				<div class="agile_label">
					<input id="check3" name="check3" type="checkbox" value="show password" onclick="myFunction()">
					<label class="check" for="check3">Show password</label>
				</div>
				<div class="agile-right">
					<a href=" {{route('login')}} ">Se connecter !</a>
				</div> 
			</div>
			<!-- script for show password -->
			<script>
				function myFunction() {
					var x = document.getElementById("myInput");
					if (x.type === "password") {
						x.type = "text";
					} else {
						x.type = "password";
					}
				}
			</script>
			<!-- //end script -->
				<input type="submit" value="LOGIN">
		</form>
	</div>
	
    @endsection
