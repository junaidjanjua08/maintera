<!-- Floating Support Icon -->
<div class="fixed bottom-4 right-4 z-50" style="position: fixed; bottom: 16px; right: 16px; z-index: 50;">
    <button onclick="openSupportModal()" 
            style="background-color: #2563eb; color: white; width: 48px; height: 48px; border-radius: 50%; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); display: flex; align-items: center; justify-content: center; cursor: pointer; border: none; transition: all 0.2s;"
            onmouseover="this.style.backgroundColor='#1d4ed8'"
            onmouseout="this.style.backgroundColor='#2563eb'"
            title="Get Support">
        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </button>
</div>

<!-- Support Modal -->
<div id="supportModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 50; display: none; align-items: center; justify-content: center; padding: 16px;">
    <div style="background: white; border-radius: 8px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); max-width: 500px; width: 100%; margin: 0 16px; max-height: 90vh; overflow-y: auto;">
        <!-- Header -->
        <div style="background-color: #2563eb; color: white; padding: 16px; border-radius: 8px 8px 0 0; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 style="font-weight: 600; margin: 0;">Support Request</h3>
            </div>
            <button onclick="closeSupportModal()" style="background: none; border: none; color: white; cursor: pointer; padding: 0;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Form -->
        <div style="padding: 16px;">
            <form id="supportForm" onsubmit="submitSupportForm(event)" enctype="multipart/form-data">
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 4px;">Name *</label>
                        <input type="text" name="name" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 4px; outline: none;">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 4px;">Email *</label>
                        <input type="email" name="email" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 4px; outline: none;">
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 4px;">Subject *</label>
                        <select name="subject" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 4px; outline: none;">
                            <option value="">Select topic</option>
                            <option value="technical_issue">Technical Issue</option>
                            <option value="billing">Billing & Payment</option>
                            <option value="service_request">Service Request</option>
                            <option value="account">Account Issues</option>
                            <option value="general">General Inquiry</option>
                        </select>
                    </div>
                    
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 4px;">Message *</label>
                        <textarea name="message" rows="4" required style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 4px; outline: none; resize: vertical;" placeholder="Describe your issue or question..."></textarea>
                    </div>
                    
                    <!-- File Upload Section -->
                    <div>
                        <label style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 4px;">Attachments (Optional)</label>
                        <div id="fileUploadArea" style="border: 2px dashed #d1d5db; border-radius: 4px; padding: 20px; text-align: center; background-color: #f9fafb; cursor: pointer; transition: all 0.2s;" 
                             onmouseover="this.style.borderColor='#2563eb'; this.style.backgroundColor='#eff6ff'"
                             onmouseout="this.style.borderColor='#d1d5db'; this.style.backgroundColor='#f9fafb'"
                             onclick="document.getElementById('fileInput').click()">
                            <svg width="32" height="32" fill="none" stroke="#6b7280" viewBox="0 0 24 24" style="margin: 0 auto 8px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p style="margin: 0; color: #6b7280; font-size: 14px;">Click to upload files or drag and drop</p>
                            <p style="margin: 4px 0 0 0; color: #9ca3af; font-size: 12px;">PDF, DOC, Images, etc. (Max 10MB each)</p>
                        </div>
                        <input type="file" id="fileInput" name="attachments[]" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.txt,.zip,.rar" style="display: none;" onchange="handleFileSelect(event)">
                    </div>
                    
                    <!-- File List -->
                    <div id="fileList" style="display: none;">
                        <h4 style="margin: 0 0 8px 0; font-size: 14px; font-weight: 500; color: #374151;">Selected Files:</h4>
                        <div id="fileItems" style="display: flex; flex-direction: column; gap: 4px;"></div>
                    </div>
                    
                    <button type="submit" style="width: 100%; background-color: #2563eb; color: white; padding: 12px 16px; border: none; border-radius: 4px; font-weight: 500; cursor: pointer; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#1d4ed8'" onmouseout="this.style.backgroundColor='#2563eb'">
                        Send Support Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let selectedFiles = [];

function openSupportModal() {
    console.log('Opening support modal...');
    const modal = document.getElementById('supportModal');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        console.log('Modal opened successfully');
    } else {
        console.error('Modal element not found');
    }
}

function closeSupportModal() {
    console.log('Closing support modal...');
    const modal = document.getElementById('supportModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        // Reset form
        document.getElementById('supportForm').reset();
        selectedFiles = [];
        updateFileList();
        console.log('Modal closed successfully');
    }
}

function handleFileSelect(event) {
    const files = Array.from(event.target.files);
    selectedFiles = selectedFiles.concat(files);
    updateFileList();
}

function updateFileList() {
    const fileList = document.getElementById('fileList');
    const fileItems = document.getElementById('fileItems');
    
    if (selectedFiles.length === 0) {
        fileList.style.display = 'none';
        return;
    }
    
    fileList.style.display = 'block';
    fileItems.innerHTML = '';
    
    selectedFiles.forEach((file, index) => {
        const fileItem = document.createElement('div');
        fileItem.style.cssText = 'display: flex; align-items: center; justify-content: space-between; padding: 8px; background-color: #f3f4f6; border-radius: 4px; font-size: 12px;';
        
        const fileInfo = document.createElement('div');
        fileInfo.style.cssText = 'display: flex; align-items: center; gap: 8px;';
        
        const fileIcon = document.createElement('span');
        fileIcon.textContent = getFileIcon(file.name);
        fileIcon.style.fontSize = '16px';
        
        const fileName = document.createElement('span');
        fileName.textContent = file.name.length > 30 ? file.name.substring(0, 30) + '...' : file.name;
        fileName.style.color = '#374151';
        
        const fileSize = document.createElement('span');
        fileSize.textContent = formatFileSize(file.size);
        fileSize.style.color = '#6b7280';
        
        const removeBtn = document.createElement('button');
        removeBtn.textContent = '×';
        removeBtn.style.cssText = 'background: #ef4444; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 14px; line-height: 1;';
        removeBtn.onclick = () => removeFile(index);
        
        fileInfo.appendChild(fileIcon);
        fileInfo.appendChild(fileName);
        fileInfo.appendChild(fileSize);
        
        fileItem.appendChild(fileInfo);
        fileItem.appendChild(removeBtn);
        fileItems.appendChild(fileItem);
    });
}

function removeFile(index) {
    selectedFiles.splice(index, 1);
    updateFileList();
}

function getFileIcon(filename) {
    const extension = filename.split('.').pop().toLowerCase();
    const icons = {
        'pdf': '📄',
        'doc': '📝', 'docx': '📝',
        'xls': '📊', 'xlsx': '📊',
        'ppt': '📋', 'pptx': '📋',
        'jpg': '🖼️', 'jpeg': '🖼️', 'png': '🖼️', 'gif': '🖼️',
        'txt': '📄',
        'zip': '📦', 'rar': '📦'
    };
    return icons[extension] || '📎';
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function submitSupportForm(event) {
    event.preventDefault();
    console.log('Submitting support form...');
    
    const formData = new FormData(event.target);
    
    // Add files to form data
    selectedFiles.forEach(file => {
        formData.append('attachments[]', file);
    });
    
    // Add user info
    formData.append('user_type', '{{ auth()->user()->role ?? "guest" }}');
    formData.append('user_id', '{{ auth()->id() ?? "guest" }}');
    
    const submitBtn = event.target.querySelector('button[type="submit"]');
    submitBtn.innerHTML = 'Sending...';
    submitBtn.disabled = true;
    
    // Debug: Log form data
    console.log('Form data entries:');
    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }
    
    fetch('{{ route("support.submit") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return response.text().then(text => {
            console.log('Response text:', text);
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('Failed to parse JSON:', e);
                console.error('Response text was:', text);
                throw new Error('Invalid JSON response from server');
            }
        });
    })
    .then(result => {
        console.log('Parsed result:', result);
        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Support request sent successfully! We\'ll get back to you soon.',
                timer: 3000,
                showConfirmButton: false
            });
            closeSupportModal();
        } else {
            throw new Error(result.message || 'Failed to send message');
        }
    })
    .catch(error => {
        console.error('Support form error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error: ' + error.message + '\n\nPlease check the browser console for more details.'
        });
    })
    .finally(() => {
        submitBtn.innerHTML = 'Send Support Request';
        submitBtn.disabled = false;
    });
}

// Drag and drop functionality
document.addEventListener('DOMContentLoaded', function() {
    const fileUploadArea = document.getElementById('fileUploadArea');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight(e) {
        fileUploadArea.style.borderColor = '#2563eb';
        fileUploadArea.style.backgroundColor = '#eff6ff';
    }
    
    function unhighlight(e) {
        fileUploadArea.style.borderColor = '#d1d5db';
        fileUploadArea.style.backgroundColor = '#f9fafb';
    }
    
    fileUploadArea.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        selectedFiles = selectedFiles.concat(Array.from(files));
        updateFileList();
    }
});

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('supportModal');
    if (event.target === modal) {
        closeSupportModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeSupportModal();
    }
});

// Debug: Check if script loaded
console.log('Support button script loaded successfully');
</script> 