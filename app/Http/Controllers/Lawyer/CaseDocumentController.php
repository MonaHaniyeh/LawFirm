<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\CaseFile;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CaseDocumentController extends Controller
{
    /**
     * Upload a document to a case.
     */
    public function store(Request $request, CaseFile $case)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'document' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
        ]);

        $file = $request->file('document');

        $path = $file->store(
            'cases/' . $case->id . '/documents',
            'public'
        );

        $case->documents()->create([
            'title' => $request->title,
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
        ]);

        return back()->with(
            'success',
            'Document uploaded successfully.'
        );
    }

    /**
     * Download a document.
     */
    public function download(CaseFile $case, Document $document)
    {
        /** @var CaseFile $case */
        /** @var Document $document */

        // Make sure the document belongs to this case
        if ($document->case_id != $case->id) {
            return back()->with('error', 'Document not found.');
        }

        $path = $document->file_path;

        /** @var \Illuminate\Filesystem\FilesystemAdapter $storage */
        $storage = Storage::disk('local');

        // If the file doesn't exist, return to the case page
        // instead of showing Laravel's 404 page.
        if (!$storage->exists($path)) {
            return back()->with('error', 'The document file could not be found.');
        }

        // Download directly — no redirect.
        return $storage->download(
            $path,
            $document->original_name ?? basename($path)
        );
    }
    /**
     * Delete a document.
     */
    public function destroy(CaseFile $case, Document $document)
    {
        // Make sure this document belongs to this case.
        if ($document->case_id != $case->id) {
            abort(404);
        }

        // Delete the physical file.
        if (
            !empty($document->file_path) &&
            Storage::disk('public')->exists($document->file_path)
        ) {
            Storage::disk('public')->delete($document->file_path);
        }

        // Delete the database record.
        $document->delete();

        return back()->with(
            'success',
            'Document deleted successfully.'
        );
    }
}
