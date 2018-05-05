@extends('layouts.base')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-4 offset-md-1">
            <img src="http://via.placeholder.com/500x500" class="img-fluid" alt="Responsive image">
        </div>
        <div class="col-md-6">
            <h1 >InterSchool Quiz Competition</h1>
            <p class="lead">
                Participation is open to all students in the UAE and schools have to nomiate their official teams. 
                Over 300 schools in UAE have been invited and all teams will be pitted against each other in a 
                challenging elimination content to be held on January 20. 
            </p>
            <p class="lead">Register before January 18 to avoid disappointment.</p>
            <div style="bottom:0;width:100%;" class="position-absolute align-items-end" >
                <a href="{{ route('register') }}" class="  btn btn-lg btn-block btn-primary">REGISTER</a>
                <br/>
                <a href="{{ route('login') }}" >Click here</a> to login with your confirmed accounts.
            </div>


        </div>
    </div>
</div>
@endsection
