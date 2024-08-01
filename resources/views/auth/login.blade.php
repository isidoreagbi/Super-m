@extends('layout.app')

@section('title')
Connexion

@endsection
@section('content')

	@if($message = Session::get('error'))
		<div class="alert alert-success" style="color: red;">
		{{ $message }}
		</div>			
	@endif

	<div class="clear-loading spinner">
		<span></span>
	</div>
	<div class="w3ls-login box box--big">
		<!-- form starts here -->
		<form action="{{ route('login.processing') }}" method="POST">
			@csrf 

			<div class="agile-field-txt">
				<label><i class="fa fa-user" aria-hidden="true"></i> Username </label>
				<input type="text" name="username" placeholder="Enter User Name" required="" />
			</div>

            <div class="agile-field-txt">
			
			<div class="agile-field-txt">
				<label><i class="fa fa-unlock-alt" aria-hidden="true"></i> password </label>
				<input type="password" name="password" placeholder="Enter Password" required="" id="myInput" />
				
				<div class="agile_label">
					<input id="check3" name="check3" type="checkbox" value="show password" onclick="myFunction()">
					<label class="check" for="check3">Show password</label>
				</div>
				<div class="agile-right">
					<a href=" {{route('user.register')}} ">S'inscrire !</a>
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































