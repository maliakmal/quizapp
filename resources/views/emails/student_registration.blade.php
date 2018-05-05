@extends('layouts.email')
@section('content')

	<p>Your account has been created!</p>
  <p>Here are your login details</p>
  <p>Your Login email address is:  {{ $user->email }} </p>
  
  <p>You can change your password by </p>
  <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
    <tbody>
      <tr>
        <td align="left">
          <table border="0" cellpadding="0" cellspacing="0">
            <tbody>
              <tr>
                <td> <a href="{{ URL::to('password/reset/'.$token) }}" target="_blank">Clicking here</a> </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  
@endsection