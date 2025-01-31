<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="env('VUE_APP_API_URL')">
<img style="padding: 40px; width: 250px;" src="https://site.3esolucoes.com.br/wp-content/uploads/2021/07/logo.png" alt="logo"/>
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} @lang('Joga Junto'). @lang('Todos os direitos reservados.')
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
