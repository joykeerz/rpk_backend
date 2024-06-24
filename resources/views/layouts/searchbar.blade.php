<div class="searchBar flex justify-center m-3">
    <form class="flex flex-row"
        action="{{ isset($routeParameters) ? route($routeName, $routeParameters) : route($routeName) }}" method="GET">
        <label class="input input-bordered flex items-center gap-2 mr-3">
            <input id="searchInput" name="search" type="text" class="grow" placeholder="{!! $placeholder !!}" />
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70">
                <path fill-rule="evenodd"
                    d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                    clip-rule="evenodd" />
            </svg>
        </label>
        <button class="btn btn-primary" type="submit">Cari</button>
    </form>
</div>

{{-- <script>
    $(document).ready(function() {
        $('#searchInput').on('input', function() {
            var searchValue = $(this).val().toLowerCase();
            $('tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
                if ($(this).text().toLowerCase().indexOf(searchValue) > -1) {
                    $(this).removeClass('bg-gray-100');
                } else {
                    $(this).addClass('bg-white');
                }
            });
        });
    });
</script> --}}
