@extends('admin.app')

@section('content')
<div class="min-h-screen bg-gray-50 px-6 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-3 mb-2">
                        <a href="{{ route('admin.support-requests.index') }}" class="text-blue-600 hover:text-blue-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <h2 class="text-3xl font-bold text-gray-800">Support Request #{{ $supportRequest->id }}</h2>
                    </div>
                    <p class="text-gray-600">Manage and respond to this support inquiry</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $supportRequest->status_color }}-100 text-{{ $supportRequest->status_color }}-800">
                        {{ ucfirst(str_replace('_', ' ', $supportRequest->status)) }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $supportRequest->priority_color }}-100 text-{{ $supportRequest->priority_color }}-800">
                        {{ ucfirst($supportRequest->priority) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Request Details -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Request Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <p class="text-gray-900">{{ $supportRequest->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <p class="text-gray-900">{{ $supportRequest->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">User Type</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $supportRequest->user_type === 'customer' ? 'bg-blue-100 text-blue-800' : 
                                   ($supportRequest->user_type === 'technician' ? 'bg-green-100 text-green-800' : 
                                    'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($supportRequest->user_type) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Submitted</label>
                            <p class="text-gray-900">{{ $supportRequest->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <p class="text-gray-900 font-medium">{{ $supportRequest->subject }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-900 whitespace-pre-wrap">{{ $supportRequest->message }}</p>
                        </div>
                    </div>
                </div>

                <!-- Attachments -->
                @if($supportRequest->attachments && count($supportRequest->attachments) > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Attachments</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($supportRequest->attachments as $attachment)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <span class="text-2xl">{{ $supportRequest->getFileIcon($attachment['filename']) }}</span>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $attachment['filename'] }}</p>
                                    <p class="text-xs text-gray-500">{{ number_format($attachment['size'] / 1024, 2) }} KB</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.support-requests.download', ['supportRequest' => $supportRequest->id, 'filename' => $attachment['filename']]) }}" 
                               class="text-blue-600 hover:text-blue-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Admin Notes -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Admin Notes</h3>
                    <form id="updateForm">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <textarea name="admin_notes" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Add internal notes about this request...">{{ $supportRequest->admin_notes }}</textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="pending" {{ $supportRequest->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ $supportRequest->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $supportRequest->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="closed" {{ $supportRequest->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                                <select name="priority" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="low" {{ $supportRequest->priority === 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ $supportRequest->priority === 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ $supportRequest->priority === 'high' ? 'selected' : '' }}>High</option>
                                    <option value="urgent" {{ $supportRequest->priority === 'urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Assign To</label>
                                <select name="assigned_to" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Unassigned</option>
                                    @foreach(\App\Models\User::where('role', 'admin')->get() as $admin)
                                    <option value="{{ $admin->id }}" {{ $supportRequest->assigned_to == $admin->id ? 'selected' : '' }}>
                                        {{ $admin->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors duration-200">
                            Update Request
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <button onclick="markAsResolved()" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                            Mark as Resolved
                        </button>
                        <button onclick="markAsInProgress()" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                            Mark as In Progress
                        </button>
                        <button onclick="setUrgent()" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                            Set as Urgent
                        </button>
                    </div>
                </div>

                <!-- Request Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Request Info</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-500">Request ID</span>
                            <p class="font-medium">#{{ $supportRequest->id }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Created</span>
                            <p class="font-medium">{{ $supportRequest->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        @if($supportRequest->resolved_at)
                        <div>
                            <span class="text-sm text-gray-500">Resolved</span>
                            <p class="font-medium">{{ $supportRequest->resolved_at->format('M d, Y H:i') }}</p>
                        </div>
                        @endif
                        @if($supportRequest->assignedAdmin)
                        <div>
                            <span class="text-sm text-gray-500">Assigned To</span>
                            <p class="font-medium">{{ $supportRequest->assignedAdmin->name }}</p>
                        </div>
                        @endif
                        <div>
                            <span class="text-sm text-gray-500">Attachments</span>
                            <p class="font-medium">{{ count($supportRequest->attachments ?? []) }} files</p>
                        </div>
                    </div>
                </div>

                <!-- Delete Action -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Danger Zone</h3>
                    <button onclick="deleteRequest()" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                        Delete Request
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('updateForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.innerHTML = 'Updating...';
    submitBtn.disabled = true;
    
    fetch('{{ route("admin.support-requests.update-status", $supportRequest) }}', {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            status: formData.get('status'),
            priority: formData.get('priority'),
            admin_notes: formData.get('admin_notes'),
            assigned_to: formData.get('assigned_to')
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: 'Support request has been updated successfully.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                location.reload();
            });
        } else {
            throw new Error(data.message || 'Failed to update request');
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: error.message
        });
    })
    .finally(() => {
        submitBtn.innerHTML = 'Update Request';
        submitBtn.disabled = false;
    });
});

function markAsResolved() {
    updateStatus('resolved', 'medium');
}

function markAsInProgress() {
    updateStatus('in_progress', '{{ $supportRequest->priority }}');
}

function setUrgent() {
    updateStatus('{{ $supportRequest->status }}', 'urgent');
}

function updateStatus(status, priority) {
    fetch('{{ route("admin.support-requests.update-status", $supportRequest) }}', {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            status: status,
            priority: priority,
            admin_notes: document.querySelector('textarea[name="admin_notes"]').value,
            assigned_to: document.querySelector('select[name="assigned_to"]').value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: 'Support request has been updated successfully.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                location.reload();
            });
        } else {
            throw new Error(data.message || 'Failed to update request');
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: error.message
        });
    });
}

function deleteRequest() {
    Swal.fire({
        title: 'Delete Request?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6'
    }).then((result) => {
        if (result.isConfirmed) {
            performDelete();
        }
    });
}

function performDelete() {
    fetch('{{ route("admin.support-requests.destroy", $supportRequest) }}', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: 'Support request has been deleted.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = '{{ route("admin.support-requests.index") }}';
            });
        } else {
            throw new Error(data.message || 'Failed to delete request');
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: error.message
        });
    });
}
</script>
@endsection 