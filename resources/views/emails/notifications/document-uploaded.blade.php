@include('emails.layouts.lawfirm', [
    'subject' => 'New Document | LawFirm',
    'label' => 'Documents',
    'heading' => 'New Document Uploaded',
    'greeting' => 'Hello ' . ($user->name ?? 'there') . ',',
    'message' =>
        'A new document has been uploaded to your case. You can review the document through your LawFirm account.',
    'details' => [
        'Document' => $document->title ?? ($document->name ?? 'New Document'),
        'Case Number' => $case->case_number ?? ($document->case->case_number ?? 'N/A'),
        'Uploaded By' => $document->user->name ?? ($document->uploadedBy->name ?? 'LawFirm'),
        'Uploaded' => isset($document->created_at) ? $document->created_at->format('F d, Y h:i A') : 'Recently',
    ],
    'actionUrl' => $actionUrl ?? url('/cases'),
    'actionText' => 'VIEW DOCUMENT',
])
