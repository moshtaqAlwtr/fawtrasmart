@extends('master')

@section('title')
    تحليل الزيارات
@stop

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">تحليل الزيارات</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="/">الرئيسية</a></li>
                        <li class="breadcrumb-item active">تحليل الزيارات</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-line mr-1"></i> تحليل حركة العملاء
            </h3>
            <div class="card-tools">
                <button class="btn btn-sm toggle-week-dates">
                    <i class="fas fa-calendar-alt"></i> إظهار/إخفاء التواريخ
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 col-sm-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" id="client-search" class="form-control" placeholder="بحث باسم العميل...">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <select id="group-filter" class="form-control select2">
                        <option value="">جميع المجموعات</option>
                        @foreach ($groups as $group)
                            <option value="group-{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                        <label class="btn btn-outline-primary active">
                            <input type="radio" name="activity" value="all" checked> الكل
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="activity" value="has-activity"> لديه نشاط
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="activity" value="no-activity"> بدون نشاط
                        </label>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <button id="export-excel" class="btn btn-success w-100">
                        <i class="fas fa-file-excel"></i> تصدير لإكسل
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <button id="prev-period" class="btn btn-outline-primary">
                    <i class="fas fa-chevron-right"></i> الأسابيع السابقة
                </button>
                <h4 id="current-period" class="text-center my-2 px-3 py-1 bg-light rounded">
                    {{ $weeks[0]['month_week'] ?? '' }} - {{ $weeks[7]['month_week'] ?? '' }}
                </h4>
                <button id="next-period" class="btn btn-outline-primary">
                    الأسابيع التالية <i class="fas fa-chevron-left"></i>
                </button>
            </div>

            <div id="weeks-container" data-current-weeks="{{ json_encode($weeks) }}"></div>

            <div class="accordion custom-accordion" id="groups-accordion">
                @foreach ($groups as $group)
                    @php
                        $clients = $group->neighborhoods
                            ->flatMap(function ($neigh) {
                                return $neigh->client ? [$neigh->client] : [];
                            })
                            ->filter()
                            ->unique('id');

                        $statusCounts = $clients->groupBy(function($client) {
                            return optional($client->status_client)->name ?? 'غير محدد';
                        })->map->count();
                    @endphp

                    <div class="card card-outline card-info mb-2 group-section" id="group-{{ $group->id }}">
                        <div class="card-header" id="heading-{{ $group->id }}">
                            <h5 class="mb-0 d-flex justify-content-between align-items-center">
                                <button class="btn btn-link text-dark font-weight-bold w-100 text-right collapsed"
                                        type="button" data-toggle="collapse"
                                        data-target="#collapse-{{ $group->id }}"
                                        aria-expanded="false"
                                        aria-controls="collapse-{{ $group->id }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-map-marker-alt mr-2"></i>
                                            {{ $group->name }}
                                            <span class="badge badge-primary badge-pill ml-2">
                                                {{ $clients->count() }}
                                            </span>
                                        </div>
                                        <div class="status-badges">
                                            @foreach($statusCounts as $status => $count)
                                                @php
                                                    $color = $clients->first(function($client) use ($status) {
                                                        return (optional($client->status_client)->name ?? 'غير محدد') === $status;
                                                    })->status_client->color ?? '#6c757d';
                                                @endphp
                                                <span class="badge badge-pill ml-1"
                                                      style="background-color: {{ $color }}; color: white;">
                                                    {{ $status }}: {{ $count }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </button>
                            </h5>
                        </div>

                        <div id="collapse-{{ $group->id }}" class="collapse"
                             aria-labelledby="heading-{{ $group->id }}"
                             data-parent="#groups-accordion">
                            <div class="card-body p-0">
                                @if ($clients->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered text-center mb-0 client-table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="align-middle" style="min-width: 220px;">العميل</th>
                                                    @foreach ($weeks as $week)
                                                        <th class="week-header align-middle" style="min-width: 80px;">
                                                            <div class="week-number">الأسبوع {{ $week['week_number'] }}</div>
                                                            <div class="week-dates">
                                                                {{ \Carbon\Carbon::parse($week['start'])->format('d/m') }}
                                                                -
                                                                {{ \Carbon\Carbon::parse($week['end'])->format('d/m') }}
                                                            </div>
                                                        </th>
                                                    @endforeach
                                                    <th class="align-middle">إجمالي النشاط</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($clients as $client)
                                                    <tr class="client-row"
                                                        data-client="{{ $client->trade_name }}"
                                                        data-status="{{ optional($client->status_client)->name ?? 'غير محدد' }}">
                                                        <td class="text-start align-middle">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar mr-2">
                                                                    <span class="avatar-content"
                                                                          style="background-color: {{ optional($client->status_client)->color ?? '#6c757d' }}">
                                                                        {{ substr($client->trade_name, 0, 1) }}
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <div class="font-weight-bold">
                                                                        {{ $client->trade_name }}-{{ $client->code }}
                                                                    </div>
                                                                    <div class="client-status-badge">
                                                                        @if ($client->status_client)
                                                                            <span style="background-color: {{ $client->status_client->color }};
                                                                                  color: #fff; padding: 2px 8px; font-size: 12px;
                                                                                  border-radius: 4px; display: inline-block;">
                                                                                {{ $client->status_client->name }}
                                                                            </span>
                                                                        @else
                                                                            <span style="background-color: #6c757d;
                                                                                  color: #fff; padding: 2px 8px; font-size: 12px;
                                                                                  border-radius: 4px; display: inline-block;">
                                                                                غير محدد
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="small text-muted">
                                                                        {{ optional($client->neighborhood)->name }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        @php $totalActivities = 0; @endphp
                                                        @foreach ($weeks as $week)
                                                            @php
                                                                $activities = [];
                                                                $hasActivity = false;
                                                                $activityTypes = [];

                                                                // فحص الفواتير
                                                                if ($client->invoices->whereBetween('created_at', [$week['start'], $week['end']])->count()) {
                                                                    $activities[] = ['icon' => 'fas fa-file-invoice', 'title' => 'فاتورة', 'color' => '#4e73df'];
                                                                    $activityTypes[] = 'invoice';
                                                                    $hasActivity = true;
                                                                }

                                                                // فحص المدفوعات
                                                                if ($client->payments->whereBetween('created_at', [$week['start'], $week['end']])->count()) {
                                                                    $activities[] = ['icon' => 'fas fa-money-bill-wave', 'title' => 'دفعة', 'color' => '#1cc88a'];
                                                                    $activityTypes[] = 'payment';
                                                                    $hasActivity = true;
                                                                }

                                                                // فحص الملاحظات
                                                                if ($client->appointmentNotes->whereBetween('created_at', [$week['start'], $week['end']])->count()) {
                                                                    $activities[] = ['icon' => 'fas fa-sticky-note', 'title' => 'ملاحظة', 'color' => '#f6c23e'];
                                                                    $activityTypes[] = 'note';
                                                                    $hasActivity = true;
                                                                }

                                                                // فحص الزيارات
                                                                if ($client->visits->whereBetween('created_at', [$week['start'], $week['end']])->count()) {
                                                                    $activities[] = ['icon' => 'fas fa-shoe-prints', 'title' => 'زيارة', 'color' => '#e74a3b'];
                                                                    $activityTypes[] = 'visit';
                                                                    $hasActivity = true;
                                                                }

                                                                // فحص سندات القبض
                                                                $receiptsCount = $client->accounts->flatMap(function($account) use ($week) {
                                                                    return $account->receipts->whereBetween('created_at', [$week['start'], $week['end']]);
                                                                })->count();

                                                                if ($receiptsCount > 0) {
                                                                    $activities[] = ['icon' => 'fas fa-hand-holding-usd', 'title' => 'سند قبض', 'color' => '#36b9cc'];
                                                                    $activityTypes[] = 'receipt';
                                                                    $hasActivity = true;
                                                                }

                                                                // تحديد لون الخلية بناء على نوع النشاط
                                                                $cellColorClass = '';
                                                                if (in_array('visit', $activityTypes)) {
                                                                    $cellColorClass = 'bg-visit-cell';
                                                                } elseif (in_array('invoice', $activityTypes)) {
                                                                    $cellColorClass = 'bg-invoice-cell';
                                                                } elseif (in_array('payment', $activityTypes)) {
                                                                    $cellColorClass = 'bg-payment-cell';
                                                                } elseif (in_array('receipt', $activityTypes)) {
                                                                    $cellColorClass = 'bg-receipt-cell';
                                                                } elseif (in_array('note', $activityTypes)) {
                                                                    $cellColorClass = 'bg-note-cell';
                                                                }

                                                                if ($hasActivity) {
                                                                    $totalActivities++;
                                                                }
                                                            @endphp
                                                            <td class="align-middle activity-cell {{ $cellColorClass }} @if ($hasActivity) has-activity @endif"
                                                                data-has-activity="{{ $hasActivity ? '1' : '0' }}"
                                                                data-activity-types="{{ implode(',', $activityTypes) }}">
                                                                @if ($hasActivity)
                                                                    <div class="activity-icons d-flex justify-content-center">
                                                                        @foreach ($activities as $activity)
                                                                            <i class="{{ $activity['icon'] }} mx-1"
                                                                               title="{{ $activity['title'] }}"
                                                                               data-toggle="tooltip"
                                                                               style="color: {{ $activity['color'] }}"></i>
                                                                        @endforeach
                                                                    </div>
                                                                @else
                                                                    <span class="text-muted">—</span>
                                                                @endif
                                                            </td>
                                                        @endforeach

                                                        <td class="align-middle">
                                                            <span class="badge badge-pill @if ($totalActivities > 0) badge-success @else badge-secondary @endif">
                                                                {{ $totalActivities }} / {{ count($weeks) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-info m-3">لا يوجد عملاء في هذه المجموعة</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <div class="small text-muted">
                    تاريخ التحديث: {{ now()->format('Y/m/d H:i') }}
                </div>
                <div>
                    <span class="badge badge-primary">مجموعات: {{ $groups->count() }}</span>
                    <span class="badge badge-success ml-2">عملاء: {{ $totalClients ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --secondary-color: #858796;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            direction: rtl;
        }

        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: none;
            border-radius: 0.35rem;
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.35rem;
            border-radius: 0.35rem 0.35rem 0 0 !important;
        }

        .card-title {
            font-weight: 700;
            color: #4e73df;
            margin-bottom: 0;
        }

        .custom-accordion .card {
            margin-bottom: 0.75rem;
            box-shadow: none;
            border: 1px solid rgba(0, 0, 0, 0.125);
        }

        .custom-accordion .card-header {
            padding: 0.75rem 1.25rem;
            background-color: rgba(0, 0, 0, 0.03);
        }

        .custom-accordion .btn-link {
            color: #5a5c69;
            text-decoration: none;
            padding: 0;
        }

        .custom-accordion .btn-link:hover {
            color: var(--primary-color);
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .activity-icons i {
            font-size: 1.1rem;
            margin: 0 3px;
            transition: all 0.3s ease;
            padding: 5px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.7);
        }

        .activity-icons i:hover {
            transform: scale(1.3);
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        .week-header {
            font-size: 0.85rem;
            white-space: nowrap;
        }

        .week-number {
            font-weight: bold;
            margin-bottom: 3px;
        }

        .week-dates {
            color: var(--secondary-color);
            font-size: 0.75rem;
        }

        .client-table th {
            vertical-align: middle;
            background-color: #f8f9fc;
        }

        /* ألوان خلفية الخلايا حسب نوع النشاط */
        .bg-visit-cell {
            background-color: rgba(231, 74, 59, 0.1) !important;
            border-left: 3px solid #e74a3b !important;
        }

        .bg-invoice-cell {
            background-color: rgba(78, 115, 223, 0.1) !important;
            border-left: 3px solid #4e73df !important;
        }

        .bg-payment-cell {
            background-color: rgba(28, 200, 138, 0.1) !important;
            border-left: 3px solid #1cc88a !important;
        }

        .bg-receipt-cell {
            background-color: rgba(54, 185, 204, 0.1) !important;
            border-left: 3px solid #36b9cc !important;
        }

        .bg-note-cell {
            background-color: rgba(246, 194, 62, 0.1) !important;
            border-left: 3px solid #f6c23e !important;
        }

        .status-badges {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            gap: 5px;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }

        .loading-spinner {
            width: 3rem;
            height: 3rem;
            border: 0.25em solid rgba(78, 115, 223, 0.2);
            border-left-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px);
            padding: 0.375rem 0.75rem;
            border: 1px solid #d1d3e2;
            border-radius: 0.35rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(2.25rem + 2px);
        }

        @media (max-width: 768px) {
            .status-badges {
                display: none;
            }

            .card-header h5 {
                font-size: 1rem;
            }

            .week-header {
                min-width: 60px !important;
                font-size: 0.7rem;
            }

            .week-number, .week-dates {
                font-size: 0.65rem;
            }

            .activity-icons i {
                font-size: 0.9rem;
                margin: 0 1px;
            }
        }

        @media (max-width: 576px) {
            .card-header .card-tools {
                margin-top: 0.5rem;
                width: 100%;
                justify-content: flex-end;
            }

            .week-header {
                min-width: 50px !important;
            }

            .client-table th, .client-table td {
                padding: 0.5rem;
            }
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // تهيئة Toastr
            toastr.options = {
                "positionClass": "toast-top-left",
                "rtl": true,
                "timeOut": 3000,
                "progressBar": true
            };

            // تهيئة Select2
            $('.select2').select2({
                placeholder: "اختر مجموعة",
                allowClear: true
            });

            // تهيئة أدوات التلميح
            $('[data-toggle="tooltip"]').tooltip({
                placement: 'top'
            });

            // إظهار/إخفاء تواريخ الأسابيع
            $('.toggle-week-dates').click(function() {
                $('.week-dates').toggle();
                $(this).toggleClass('btn-primary btn-outline-primary');
                toastr.info('تم تغيير عرض تواريخ الأسابيع');
            });

            // فلترة حسب اسم العميل
            $('#client-search').on('keyup', function() {
                const searchText = $(this).val().toLowerCase();
                let visibleRows = 0;

                $('.client-row').each(function() {
                    const clientName = $(this).data('client').toLowerCase();
                    const isVisible = clientName.includes(searchText);
                    $(this).toggle(isVisible);

                    if (isVisible) visibleRows++;
                });

                if (searchText.length > 0) {
                    toastr.info(`عرض ${visibleRows} عميل من نتائج البحث`);
                }
            });

            // فلترة حسب المجموعة
            $('#group-filter').change(function() {
                const groupId = $(this).val();
                if (groupId) {
                    $('.group-section').addClass('d-none');
                    $(`#${groupId}`).removeClass('d-none');
                    toastr.info('تم تطبيق فلتر المجموعة');
                } else {
                    $('.group-section').removeClass('d-none');
                    toastr.info('تم إظهار جميع المجموعات');
                }
            });

            // فلترة حسب النشاط
            $('input[name="activity"]').change(function() {
                const filter = $(this).val();
                let visibleRows = 0;

                $('.client-row').each(function() {
                    const row = $(this);
                    let showRow = true;

                    if (filter === 'has-activity') {
                        showRow = row.find('.activity-cell[data-has-activity="1"]').length > 0;
                    } else if (filter === 'no-activity') {
                        showRow = row.find('.activity-cell[data-has-activity="1"]').length === 0;
                    }

                    row.toggle(showRow);
                    if (showRow) visibleRows++;
                });

                toastr.info(`عرض ${visibleRows} عميل بعد تطبيق الفلتر`);
            });

            // التصدير إلى Excel
            $('#export-excel').click(function() {
                // إنشاء ورقة عمل Excel
                const wb = XLSX.utils.book_new();
                const wsData = [];

                // إضافة العناوين
                const headers = ['العميل', 'الحالة', 'المنطقة'];
                $('.week-header .week-number').each(function() {
                    headers.push($(this).text());
                });
                headers.push('إجمالي النشاط');
                wsData.push(headers);

                // إضافة بيانات العملاء
                $('.client-row').each(function() {
                    if ($(this).is(':visible')) {
                        const row = [];
                        const clientName = $(this).find('td:first-child .font-weight-bold').first().text().trim();
                        const clientStatus = $(this).data('status');
                        const clientArea = $(this).find('td:first-child .text-muted').text().trim();

                        row.push(clientName, clientStatus, clientArea);

                        $(this).find('.activity-cell').each(function() {
                            const hasActivity = $(this).data('has-activity') === '1';
                            row.push(hasActivity ? 'نعم' : 'لا');
                        });

                        const totalActivities = $(this).find('.badge-pill').text().trim();
                        row.push(totalActivities);

                        wsData.push(row);
                    }
                });

                // تحويل البيانات إلى ورقة عمل
                const ws = XLSX.utils.aoa_to_sheet(wsData);

                // إضافة ورقة العمل إلى الكتاب
                XLSX.utils.book_append_sheet(wb, ws, "تحليل الزيارات");

                // تنزيل الملف
                const date = new Date().toISOString().split('T')[0];
                XLSX.writeFile(wb, `تحليل_الزيارات_${date}.xlsx`);

                toastr.success('تم تصدير البيانات بنجاح');
            });

            // متغيرات التحكم في الفترات الزمنية
            let currentWeekOffset = 0;
            const weeksPerPage = 8; // عرض 8 أسابيع في كل مرة
            let isLoading = false;

            // عرض شاشة التحميل
            function showLoading() {
                if (isLoading) return;

                isLoading = true;
                $('body').append(`
                    <div class="loading-overlay">
                        <div class="loading-spinner"></div>
                        <div class="mt-3 text-primary font-weight-bold">جاري تحميل البيانات...</div>
                    </div>
                `);
                $('.loading-overlay').fadeIn();
            }

            // إخفاء شاشة التحميل
            function hideLoading() {
                isLoading = false;
                $('.loading-overlay').fadeOut(function() {
                    $(this).remove();
                });
            }

            // تحميل الأسابيع السابقة
            $('#prev-period').click(function() {
                if (isLoading) return;

                currentWeekOffset += weeksPerPage;
                loadWeeks();
            });

            // تحميل الأسابيع التالية
            $('#next-period').click(function() {
                if (isLoading) return;

                if (currentWeekOffset > 0) {
                    currentWeekOffset = Math.max(0, currentWeekOffset - weeksPerPage);
                    loadWeeks();
                } else {
                    toastr.info('أنت تشاهد أحدث الأسابيع المتاحة');
                }
            });

            // تحميل بيانات الأسابيع
            function loadWeeks() {
                showLoading();

                $.ajax({
                    url: '/get-weeks-data',
                    type: 'GET',
                    data: {
                        offset: currentWeekOffset,
                        limit: weeksPerPage
                    },
                    success: function(response) {
                        updateTable(response.weeks);
                        updatePeriodDisplay(response.weeks);
                        hideLoading();
                        toastr.success('تم تحديث بيانات الأسابيع بنجاح');
                    },
                    error: function() {
                        hideLoading();
                        toastr.error('حدث خطأ أثناء تحميل البيانات');
                    }
                });
            }

            // تحديث الجدول بناء على الأسابيع الجديدة
            function updateTable(weeks) {
                // هنا يجب تحديث الجدول بالبيانات الجديدة
                // هذا مثال مبسط، في التطبيق الحقيقي يجب استبدال البيانات كاملة
                $('#current-period').text(weeks[0].month_week + ' - ' + weeks[weeks.length-1].month_week);
            }

            // تحديث عرض الفترة الحالية
            function updatePeriodDisplay(weeks) {
                if (weeks.length > 0) {
                    const displayText = weeks[0].month_week + ' - ' + weeks[weeks.length-1].month_week;
                    $('#current-period').text(displayText);
                    $('#weeks-container').data('current-weeks', weeks);
                }
            }

            // التهيئة الأولية
            updatePeriodDisplay(@json($weeks));
        });
    </script>
@endsection
