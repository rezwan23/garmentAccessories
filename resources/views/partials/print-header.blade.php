<div class="text-center print-header">
    <h4 class="title text-uppercase">{{ $company->name }}</h4>
    <p>{{ $company->address }} <br> Email: {{ $company->emails }} <br> Phone: {{ $company->phones }}</p>
    {!! $slot ?? '' !!}
</div>