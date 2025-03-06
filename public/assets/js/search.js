$(document).ready(function() {
    // دالة للبحث
    function filterSearch(inputSelector, resultSelector, type) {
        $(inputSelector).on('keyup', function() {
            var query = $(this).val();
            if (query.length > 0) {
                $(resultSelector + 'Icon').removeClass('d-none'); // عرض أيقونة التحميل
                $.ajax({
                    url: "{{ route('invoices.index') }}",
                    type: "GET",
                    data: { query: query, type: type },
                    success: function(response) {
                        $(resultSelector).html(response.options);
                    },
                    complete: function() {
                        $(resultSelector + 'Icon').addClass('d-none'); // إخفاء أيقونة التحميل
                    }
                });
            } else {
                $(resultSelector).html('');
                $(resultSelector + 'Icon').addClass('d-none'); // إخفاء الأيقونة إذا لم يكن هناك نص
            }
        });
    }

    // استدعاء دالة البحث
    filterSearch('#searchClient', '#accountResults', 'client');
    filterSearch('#searchEmployee', '#employeeResults', 'employee');
    filterSearch('#searchProduct', '#productResults', 'product');
});
