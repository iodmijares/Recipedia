<!-- Flash Messages Container -->
<div id="flash-messages-container" class="fixed top-4 right-4 z-50 space-y-3" style="z-index: 9999;">
    <!-- Success Messages -->
    @if (session('success'))
        <div class="flash-message bg-green-50 border border-green-200 rounded-lg shadow-lg p-4 max-w-md transform transition-all duration-500 ease-in-out" 
             data-type="success"
             data-auto-dismiss="true">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-green-800">Success!</h3>
                    <p class="mt-1 text-sm text-green-700">{{ session('success') }}</p>
                </div>
                <div class="ml-4 flex-shrink-0">
                    <button type="button" class="flash-close inline-flex text-green-400 hover:text-green-600 focus:outline-none" onclick="dismissFlashMessage(this)">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="mt-2 bg-green-200 rounded-full h-1">
                <div class="progress-bar bg-green-400 h-1 rounded-full transition-all duration-5000 ease-linear" style="width: 100%;"></div>
            </div>
        </div>
    @endif

    <!-- Error Messages -->
    @if (session('error') || $errors->any())
        <div class="flash-message bg-red-50 border border-red-200 rounded-lg shadow-lg p-4 max-w-md transform transition-all duration-500 ease-in-out" 
             data-type="error"
             data-auto-dismiss="true">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-red-800">Error!</h3>
                    @if(session('error'))
                        <p class="mt-1 text-sm text-red-700">{{ session('error') }}</p>
                    @endif
                    @if($errors->any())
                        <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="ml-4 flex-shrink-0">
                    <button type="button" class="flash-close inline-flex text-red-400 hover:text-red-600 focus:outline-none" onclick="dismissFlashMessage(this)">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="mt-2 bg-red-200 rounded-full h-1">
                <div class="progress-bar bg-red-400 h-1 rounded-full transition-all duration-5000 ease-linear" style="width: 100%;"></div>
            </div>
        </div>
    @endif

    <!-- Warning Messages -->
    @if (session('warning'))
        <div class="flash-message bg-yellow-50 border border-yellow-200 rounded-lg shadow-lg p-4 max-w-md transform transition-all duration-500 ease-in-out" 
             data-type="warning"
             data-auto-dismiss="true">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-yellow-800">Warning!</h3>
                    <p class="mt-1 text-sm text-yellow-700">{{ session('warning') }}</p>
                </div>
                <div class="ml-4 flex-shrink-0">
                    <button type="button" class="flash-close inline-flex text-yellow-400 hover:text-yellow-600 focus:outline-none" onclick="dismissFlashMessage(this)">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="mt-2 bg-yellow-200 rounded-full h-1">
                <div class="progress-bar bg-yellow-400 h-1 rounded-full transition-all duration-5000 ease-linear" style="width: 100%;"></div>
            </div>
        </div>
    @endif

    <!-- Info Messages -->
    @if (session('info'))
        <div class="flash-message bg-blue-50 border border-blue-200 rounded-lg shadow-lg p-4 max-w-md transform transition-all duration-500 ease-in-out" 
             data-type="info"
             data-auto-dismiss="true">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-blue-800">Info</h3>
                    <p class="mt-1 text-sm text-blue-700">{{ session('info') }}</p>
                </div>
                <div class="ml-4 flex-shrink-0">
                    <button type="button" class="flash-close inline-flex text-blue-400 hover:text-blue-600 focus:outline-none" onclick="dismissFlashMessage(this)">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="mt-2 bg-blue-200 rounded-full h-1">
                <div class="progress-bar bg-blue-400 h-1 rounded-full transition-all duration-5000 ease-linear" style="width: 100%;"></div>
            </div>
        </div>
    @endif

    <!-- Toast Messages -->
    @if (session('toast_success'))
        <div class="flash-message toast bg-green-600 text-white rounded-lg shadow-lg p-3 max-w-sm transform transition-all duration-300 ease-in-out" 
             data-type="toast"
             data-auto-dismiss="true">
            <div class="flex items-center">
                <svg class="h-4 w-4 text-white mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-medium">{{ session('toast_success') }}</span>
            </div>
        </div>
    @endif

    <!-- Toast Info Messages -->
    @if (session('toast_info'))
        <div class="flash-message toast bg-blue-600 text-white rounded-lg shadow-lg p-3 max-w-sm transform transition-all duration-300 ease-in-out" 
             data-type="toast"
             data-auto-dismiss="true">
            <div class="flex items-center">
                <svg class="h-4 w-4 text-white mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-medium">{{ session('toast_info') }}</span>
            </div>
        </div>
    @endif

    <!-- Toast Warning Messages -->
    @if (session('toast_warning'))
        <div class="flash-message toast bg-yellow-600 text-white rounded-lg shadow-lg p-3 max-w-sm transform transition-all duration-300 ease-in-out" 
             data-type="toast"
             data-auto-dismiss="true">
            <div class="flex items-center">
                <svg class="h-4 w-4 text-white mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-medium">{{ session('toast_warning') }}</span>
            </div>
        </div>
    @endif
</div>

<style>
    .flash-message {
        animation: slideIn 0.3s ease-out;
    }
    
    .flash-message.fade-out {
        animation: slideOut 0.3s ease-in forwards;
    }
    
    .toast {
        min-width: 250px;
    }
    
    .progress-bar {
        animation: shrink 5s linear forwards;
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    @keyframes shrink {
        from {
            width: 100%;
        }
        to {
            width: 0%;
        }
    }
</style>

<script>
    // Flash message management
    document.addEventListener('DOMContentLoaded', function() {
        initializeFlashMessages();
    });

    function initializeFlashMessages() {
        const messages = document.querySelectorAll('.flash-message[data-auto-dismiss="true"]');
        
        messages.forEach(function(message) {
            // Auto-dismiss after 5 seconds
            setTimeout(function() {
                if (message.parentNode) {
                    dismissFlashMessage(message.querySelector('.flash-close'));
                }
            }, 5000);
        });
    }

    function dismissFlashMessage(button) {
        const message = button.closest('.flash-message');
        if (message) {
            message.classList.add('fade-out');
            setTimeout(function() {
                if (message.parentNode) {
                    message.remove();
                }
            }, 300);
        }
    }
</script>