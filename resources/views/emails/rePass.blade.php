<x-mail::message>
    Dear {{$email}}!
    Here is your current password:

    Password: {{$pass}}

    <x-mail::button :url="'http://bagalameni.kz/'">
        Go to a website
    </x-mail::button>

</x-mail::message>
