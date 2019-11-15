Hello {{ $user->name }}

thank you for create an account please verify this account using this link

{{ route('verify' , $user->verification_token) }}
