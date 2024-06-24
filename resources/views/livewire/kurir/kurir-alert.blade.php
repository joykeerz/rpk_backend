@if (session('message'))
    <div class="fixed inset-0 z-50 overflow-auto bg-neutral-950 bg-opacity-75 flex justify-center items-center">
        <div class="bg-neutral-50 rounded-lg p-8 transform transition-all duration-300 ease-out">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-bold mb-4">Notifikasi</h2>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" wire:click="closeAlert">
                    ✕
                </button>
            </div>

            <div role="alert" class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ Session::get('message') }}</span>
            </div>

        </div>
    </div>
@elseif(session('error'))
    <div class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-75 flex justify-center items-center">
        <div class="bg-white rounded-lg p-8 transform transition-all duration-300 ease-out">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-bold mb-4">Notifikasi</h2>
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" wire:click="closeAlert">
                    ✕
                </button>
            </div>

            <div role="alert" class="alert alert-error">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ Session::get('error') }}</span>
            </div>

        </div>
    </div>
@endif
