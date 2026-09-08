@include('emails.layouts.lawfirm', [
    'subject' => 'Case Created | LawFirm',
    'label' => 'Case Management',
    'heading' => 'Case Created Successfully',
    'greeting' => 'Hello ' . ($user->name ?? 'there') . ',',
    'message' =>
        'A new case has been created in the LawFirm management system. The case information is now available for review.',
    'details' => [
        'Case Number' => $case->case_number ?? 'N/A',
        'Case Title' => $case->title ?? ($case->case_title ?? 'N/A'),
        'Status' => ucfirst($case->status ?? 'Active'),
    ],
    'actionUrl' => $actionUrl ?? url('/cases'),
    'actionText' => 'VIEW CASE',
])
