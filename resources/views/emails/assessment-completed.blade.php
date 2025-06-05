<!-- resources/views/emails/assessment-completed.blade.php -->
@component('mail::message')
# Assessment Completed Notification

**User:** {{ $user->name }} ({{ $user->email }})  
**Assessment:** {{ $assessment->title }}  
**Final Score:** {{ $finalScore }}%  
**Completed At:** {{ now()->format('Y-m-d H:i:s') }}

@component('mail::button', ['url' => route('admin.assessments.show', $assessment->id)])
View Assessment Details
@endcomponent

Thanks for using the Employee Assessment Platform!  
@endcomponent