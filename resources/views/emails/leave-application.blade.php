@component('mail::message')
# Leave Application

Dear {{ $user->name }},

{{$currentUser->name}} have applied for the Leave.
Please visit your dashboard to take action.
Leave Start Date: {{ $startDate }}
Leave End Date: {{ $endDate }}

Thank you for using our leave application system.

Regards,
{{ config('app.name') }}
@endcomponent
