
<!-- Bootstrap Toast Container -->
<div aria-live="polite" aria-atomic="true" style="position: fixed; top: 2rem; right: 2rem; z-index: 9999; min-width: 300px;">
	<div id="global-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3500">
		<div class="toast-header">
			<span id="toast-icon" class="me-2"></span>
			<strong class="me-auto" id="toast-title">Message</strong>
			<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
		<div class="toast-body" id="toast-body"></div>
	</div>
</div>

<script>
	window.showBootstrapToast = function(type, message) {
		const toastEl = document.getElementById('global-toast');
		const toastTitle = document.getElementById('toast-title');
		const toastBody = document.getElementById('toast-body');
		const toastIcon = document.getElementById('toast-icon');
        
        if (!toastEl) return;

		let iconHtml = '';
		let titleText = '';
		let bgClass = '';
		switch(type) {
			case 'success':
				iconHtml = '<span class="text-success"><i class="bi bi-check-circle-fill"></i></span>';
				titleText = 'Success';
				bgClass = 'bg-success text-white';
				break;
			case 'error':
				iconHtml = '<span class="text-danger"><i class="bi bi-x-circle-fill"></i></span>';
				titleText = 'Error';
				bgClass = 'bg-danger text-white';
				break;
			case 'warning':
				iconHtml = '<span class="text-warning"><i class="bi bi-exclamation-triangle-fill"></i></span>';
				titleText = 'Warning';
				bgClass = 'bg-warning text-dark';
				break;
			case 'info':
			default:
				iconHtml = '<span class="text-info"><i class="bi bi-info-circle-fill"></i></span>';
				titleText = 'Info';
				bgClass = 'bg-info text-dark';
				break;
		}
		toastIcon.innerHTML = iconHtml;
		toastTitle.textContent = titleText;
		toastBody.textContent = message;
		// Remove previous bg classes
		toastEl.classList.remove('bg-success','bg-danger','bg-warning','bg-info','text-white','text-dark');
		if (bgClass) {
            const classes = bgClass.split(' ');
            classes.forEach(c => toastEl.classList.add(c));
        }
        
        if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
		    const toast = new bootstrap.Toast(toastEl);
		    toast.show();
        } else {
            console.warn('Bootstrap JS not loaded, cannot show toast');
            // Fallback for debugging
            toastEl.style.display = 'block';
            setTimeout(() => { toastEl.style.display = 'none'; }, 3500);
        }
	}

    document.addEventListener('DOMContentLoaded', function() {
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
    });
</script>
 