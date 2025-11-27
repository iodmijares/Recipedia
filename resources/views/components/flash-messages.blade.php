<div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
    <div id="global-toast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2">
                <span id="toast-icon" class="fs-4"></span>
                <div>
                    <strong id="toast-title" class="d-block"></strong>
                    <span id="toast-message"></span>
                </div>
            </div>
            <button type="button" id="toast-close-btn" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
    window.showBootstrapToast = function(type, message) {
        const toastEl = document.getElementById('global-toast');
        const toastTitle = document.getElementById('toast-title');
        const toastMessage = document.getElementById('toast-message');
        const toastIcon = document.getElementById('toast-icon');
        const closeBtn = document.getElementById('toast-close-btn');
        
        if (!toastEl) return;

        // 1. Reset Classes (Keep base toast classes)
        toastEl.className = 'toast align-items-center border-0';
        closeBtn.className = 'btn-close me-2 m-auto'; // Reset close button

        let iconHtml = '';
        let titleText = '';
        let colorClass = '';

        // 2. Determine Styling based on type
        switch(type) {
            case 'success':
                iconHtml = '<i class="bi bi-check-circle-fill"></i>';
                titleText = 'Success';
                colorClass = 'text-bg-success'; // BS5 Auto contrast
                closeBtn.classList.add('btn-close-white'); // White X for dark bg
                break;
            case 'error':
            case 'danger':
                iconHtml = '<i class="bi bi-x-circle-fill"></i>';
                titleText = 'Error';
                colorClass = 'text-bg-danger';
                closeBtn.classList.add('btn-close-white');
                break;
            case 'warning':
                iconHtml = '<i class="bi bi-exclamation-triangle-fill"></i>';
                titleText = 'Warning';
                colorClass = 'text-bg-warning';
                // Warning is usually yellow/black, so we keep the dark close button
                break;
            case 'info':
            default:
                iconHtml = '<i class="bi bi-info-circle-fill"></i>';
                titleText = 'Info';
                colorClass = 'text-bg-info';
                break;
        }

        // 3. Apply Content and Classes
        toastIcon.innerHTML = iconHtml;
        toastTitle.textContent = titleText;
        toastMessage.textContent = message;
        toastEl.classList.add(colorClass);
        
        // 4. Show the Toast
        if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
            // Dispose existing instance to reset timer if clicked rapidly
            const toastInstance = bootstrap.Toast.getInstance(toastEl);
            if (toastInstance) {
                toastInstance.dispose();
            }
            const newToast = new bootstrap.Toast(toastEl);
            newToast.show();
        } else {
            console.warn('Bootstrap JS is missing.');
            toastEl.style.display = 'block'; // Fallback
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Listen for JS Events
        window.addEventListener('show-toast', function(e) {
            showBootstrapToast(e.detail.type || 'info', e.detail.message || '');
        });

        
        @if(session('toast_success'))
            showBootstrapToast('success', @json(session('toast_success')));
        @endif

        @if(session('toast_error'))
            showBootstrapToast('error', @json(session('toast_error')));
        @endif

        @if(session('toast_warning'))
            showBootstrapToast('warning', @json(session('toast_warning')));
        @endif

        @if(session('toast_info'))
            showBootstrapToast('info', @json(session('toast_info')));
        @endif
        
        // Handle standard Laravel 'status' or 'success' keys if you use those
        @if(session('status'))
            showBootstrapToast('info', @json(session('status')));
        @endif
    });
</script>