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

<div class="searchBar flex justify-center m-3">
    <form action="{{ route($routeName) }}" method="GET">
        <input type="text" id="searchInput" name="search"
            class="rounded-md border-gray border shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-2"
            placeholder="Pencarian">
    </form>
</div>
