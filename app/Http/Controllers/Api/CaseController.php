<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CaseResource;
use App\Models\CaseFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CaseController extends Controller
{
    /**
     * Display cases belonging to the authenticated user.
     *
     * Clients see their own cases.
     * Lawyers see cases assigned to them.
     * Admins see all cases.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $query = CaseFile::with([
            'client:id,name,email',
            'lawyer:id,name,email',
        ]);

        if ($user->isClient()) {

            $query->where('client_id', $user->id);

        } elseif ($user->isLawyer()) {

            $query->where('lawyer_id', $user->id);

        } elseif ($user->isAdmin()) {

            // Admin can see all cases.

        } else {

            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view cases.',
            ], 403);
        }

        $cases = $query
            ->latest()
            ->get();

        return CaseResource::collection($cases);
    }

    /**
     * Store a newly created case.
     */
    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Only admins can create cases through this API.
        |--------------------------------------------------------------------------
        */
        if (!$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Only administrators can create cases.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [

            'case_number' => [
                'required',
                'string',
                'max:255',
                'unique:cases,case_number',
            ],

            'client_id' => [
                'required',
                'exists:users,id',
            ],

            'lawyer_id' => [
                'required',
                'exists:users,id',
            ],

            'case_type' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'status' => [
                'nullable',
                'in:opened,closed',
            ],

            'start_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $case = CaseFile::create([

            'case_number' => $request->case_number,

            'client_id' => $request->client_id,

            'lawyer_id' => $request->lawyer_id,

            'case_type' => $request->case_type,

            'description' => $request->description,

            'status' => $request->status ?? 'opened',

            'start_date' => $request->start_date,

            'end_date' => $request->end_date,
        ]);

        $case->load([
            'client:id,name,email',
            'lawyer:id,name,email',
        ]);

        return (new CaseResource($case))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display a specific case.
     */
    public function show(CaseFile $case)
    {
        /** @var User $user */
        $user = Auth::user();

        if (
            $user->isClient() &&
            $case->client_id !== $user->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view this case.',
            ], 403);
        }

        if (
            $user->isLawyer() &&
            $case->lawyer_id !== $user->id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view this case.',
            ], 403);
        }

        if (
            !$user->isClient() &&
            !$user->isLawyer() &&
            !$user->isAdmin()
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view this case.',
            ], 403);
        }

        $case->load([
            'client:id,name,email',
            'lawyer:id,name,email',
            'documents',
            'messages',
            'appointments',
            'invoices',
        ]);

        return new CaseResource($case);
    }
}