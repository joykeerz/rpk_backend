@if (Session::has('message'))
    <!-- Open the modal using ID.showModal() method -->
    {{-- <button class="btn" onclick="messageModal.showModal()">open modal</button> --}}
    <dialog id="messageModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Notifikasi</h3>
            <p class="py-4">{{ Session::get('message') }}</p>
            <div class="modal-action">
                <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button class="btn">Tutup</button>
                </form>
            </div>
        </div>
    </dialog>
    <script>
        (function() {
            setTimeout(function() {
                document.getElementById('messageModal').showModal();
            }, 300);
        })();
    </script>
@elseif (Session::has('error'))
    <!-- Open the modal using ID.showModal() method -->
    {{-- <button class="btn" onclick="errorModal.showModal()">open modal</button> --}}
    <dialog id="errorModal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Error</h3>
            <p class="py-4">{{ Session::get('error') }}</p>
            <div class="modal-action">
                <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button class="btn">Tutup</button>
                </form>
            </div>
        </div>
    </dialog>
    <script>
        (function() {
            (function() {
                setTimeout(function() {
                    document.getElementById('errorModal').showModal();
                }, 300);
            })();
        })();
    </script>
@endif
