@include('emails.layouts.lawfirm', [
    'subject' => 'Case Updated | LawFirm',
    'label' => 'Case Management',
    'heading' => 'Case Information Updated',
    'greeting' => 'Hello ' . ($user->name ?? 'there') . ',',
    'message' =>
        'The information associated with your case has been updated. Please review the latest case details in the LawFirm system.',
    'details' => [
        'Case Number' => $case->case_number ?? 'N/A',
        'Case Title' => $case->title ?? ($case->case_title ?? 'N/A'),
        'Status' => ucfirst($case->status ?? 'Updated'),
    ],
    'actionUrl' => $actionUrl ?? url('/cases'),
    'actionText' => 'VIEW CASE',
])
