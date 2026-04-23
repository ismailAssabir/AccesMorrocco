@if(session('msg'))
    <div id="success-alert" class="msg-item mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-2xl font-bold text-sm flex items-center gap-3 transition-all duration-500 ease-in-out shadow-sm">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span class="flex-1">{{ session('msg') }}</span>
    </div>
@endif

@if($errors->any())
    <div id="error-alert" class="msg-item mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-2xl font-bold text-sm transition-all duration-500 ease-in-out shadow-sm">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const messages = document.querySelectorAll('.msg-item');
        messages.forEach(msg => {
            setTimeout(() => {
                msg.style.opacity = '0';
                msg.style.transform = 'translateY(-10px)';
                setTimeout(() => msg.remove(), 500);
            }, 3000);
        });
    });
</script>
