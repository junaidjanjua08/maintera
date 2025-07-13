<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\SupportRequest;

class SupportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'IsAdmin'])->only(['index', 'show', 'updateStatus', 'downloadAttachment', 'destroy']);
    }

    /**
     * Submit a support request with file uploads
     */
    public function submit(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string|max:2000',
                'user_type' => 'nullable|string|in:customer,technician,admin,guest',
                'user_id' => 'nullable|string',
                'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar|max:10240' // 10MB max
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }

        try {
            $attachments = [];
            
            // Handle file uploads
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    if ($file->isValid()) {
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $path = $file->storeAs('support-attachments', $filename, 'public');
                        $attachments[] = [
                            'filename' => $file->getClientOriginalName(),
                            'path' => $path,
                            'size' => $file->getSize(),
                            'type' => $file->getMimeType()
                        ];
                    }
                }
            }

            // Create support request
            $supportRequest = SupportRequest::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'user_type' => $request->user_type ?? 'guest',
                'user_id' => $request->user_id !== 'guest' ? $request->user_id : null,
                'status' => 'pending',
                'priority' => 'medium',
                'attachments' => $attachments
            ]);

            // Log the support request
            Log::info('Support request submitted', [
                'id' => $supportRequest->id,
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'user_type' => $request->user_type,
                'attachments_count' => count($attachments)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Support request submitted successfully. We\'ll get back to you within 24 hours.',
                'request_id' => $supportRequest->id
            ]);

        } catch (\Exception $e) {
            Log::error('Support request submission failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to submit support request: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get support statistics for admin dashboard
     */
    public function getStats()
    {
        $totalRequests = SupportRequest::count();
        $pendingRequests = SupportRequest::where('status', 'pending')->count();
        $urgentRequests = SupportRequest::where('priority', 'urgent')->where('status', '!=', 'resolved')->count();
        
        $recentRequests = SupportRequest::with(['user', 'assignedAdmin'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'total_requests' => $totalRequests,
            'pending_requests' => $pendingRequests,
            'urgent_requests' => $urgentRequests,
            'recent_requests' => $recentRequests
        ]);
    }

    /**
     * Get all support requests for admin
     */
    public function index(Request $request)
    {
        $query = SupportRequest::with(['user', 'assignedAdmin']);

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%")
                  ->orWhere('subject', 'like', "%{$searchTerm}%")
                  ->orWhere('message', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        // Filter by user type
        if ($request->has('user_type') && $request->user_type !== 'all') {
            $query->where('user_type', $request->user_type);
        }

        $supportRequests = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.support-requests', compact('supportRequests'));
    }

    /**
     * Show support request details
     */
    public function show(SupportRequest $supportRequest)
    {
        $supportRequest->load(['user', 'assignedAdmin']);
        return view('admin.support-request-details', compact('supportRequest'));
    }

    /**
     * Update support request status
     */
    public function updateStatus(Request $request, SupportRequest $supportRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved,closed',
            'priority' => 'required|in:low,medium,high,urgent',
            'admin_notes' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id'
        ]);

        $supportRequest->update([
            'status' => $request->status,
            'priority' => $request->priority,
            'admin_notes' => $request->admin_notes,
            'assigned_to' => $request->assigned_to,
            'resolved_at' => in_array($request->status, ['resolved', 'closed']) ? now() : null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Support request updated successfully'
        ]);
    }

    /**
     * Download attachment
     */
    public function downloadAttachment(SupportRequest $supportRequest, $filename)
    {
        $attachments = $supportRequest->attachments ?? [];
        
        foreach ($attachments as $attachment) {
            if ($attachment['filename'] === $filename) {
                $path = storage_path('app/public/' . $attachment['path']);
                
                if (file_exists($path)) {
                    return response()->download($path, $attachment['filename']);
                }
            }
        }

        abort(404, 'File not found');
    }

    /**
     * Delete support request
     */
    public function destroy(SupportRequest $supportRequest)
    {
        try {
            Log::info('Attempting to delete support request', [
                'id' => $supportRequest->id,
                'name' => $supportRequest->name,
                'email' => $supportRequest->email
            ]);

            // Delete attachments
            if ($supportRequest->attachments) {
                foreach ($supportRequest->attachments as $attachment) {
                    try {
                        Storage::disk('public')->delete($attachment['path']);
                        Log::info('Deleted attachment', ['path' => $attachment['path']]);
                    } catch (\Exception $e) {
                        Log::warning('Failed to delete attachment', [
                            'path' => $attachment['path'],
                            'error' => $e->getMessage()
                        ]);
                    }
                }
            }

            $supportRequest->delete();

            Log::info('Support request deleted successfully', ['id' => $supportRequest->id]);

            return response()->json([
                'success' => true,
                'message' => 'Support request deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to delete support request', [
                'id' => $supportRequest->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete support request: ' . $e->getMessage()
            ], 500);
        }
    }
} 