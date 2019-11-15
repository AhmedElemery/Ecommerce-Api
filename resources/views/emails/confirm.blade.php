Hello {{ $user->name }}

please verify thisaccount using the link below

{{ route('verify' , $user->verification_token) }}
