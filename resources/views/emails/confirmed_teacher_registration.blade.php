@extends('layouts.email')
@section('content')
<p>Hi there,</p>
    <p>Dear {{ $user->first_name.' '.$user->last_name }},</p>
    <p>Thank you for the registration. Your registration is approved, please reset your password to continue with your account</p>
    <p>Your Login email address is:  {{ $user->email }} </p>
  <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
    <tbody>
      <tr>
        <td align="left">
          <table border="0" cellpadding="0" cellspacing="0">
            <tbody>
              <tr>
                <td> <a href="{{ URL::to('password/reset/'.$token) }}" target="_blank">Reset Password</a> </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>


@endsection