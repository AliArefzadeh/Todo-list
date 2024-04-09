<x-mail::message>
    # Email Verification

    Please verify your email by clicking the button below

<x-mail::button :url="$url">
        Verifying Email
</x-mail::button>

Thanks<br>
Karlancer.

<h6>{{now()}}</h6>
</x-mail::message>
