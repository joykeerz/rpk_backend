@if (session('message'))
    <div class="bg-green-200 border-t border-b border-white-500  px-4 py-3 relative" role="alert" id="alertMessage">
        <p>{{ Session::get('message') }}.</p>
        <button id="close-button" type="button" data-dismiss="alert" aria-label="Close"
            class="close-button absolute top-0 bottom-0 right-0 px-4 py-3 text-rose">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="#ff3b00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
        </button>
    </div>
@elseif(session('error'))
    <div class="bg-red-700 border-t border-b border-white-500 text-white px-4 py-3 relative" role="alert"
        id="alertMessage">
        <p>{{ Session::get('error') }}.</p>
        <button type="button" data-dismiss="alert" aria-label="Close"
            class="close-button absolute top-0 bottom-0 right-0 px-4 py-3 text-rose">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="#ff3b00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
        </button>
    </div>
@endif

@script
    <script>
        console.log('Webpage loaded!');

        $wire.on('stockAdded', () => {
            console.log('stock added');

            var alert = document.getElementById('alertMessage');

            if (alert) {
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 5000);
            }

            var closeButton = document.getElementById('close-button');

            if (closeButton) {
                closeButton.addEventListener('click', function() {
                    alert.style.display = 'none';
                });
            }
        });
    </script>
@endscript
