@extends('master')

@section('title')
    تحليل الزيارات
@stop

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تحليل الزيارات</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                            <li class="breadcrumb-item active">عرض</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h4 class="card-title">
                <i class="fas fa-chart-line mr-1"></i> تحليل حركة العملاء
            </h4>
            <div class="heading-elements">
                <button class="btn btn-sm btn-outline-primary toggle-week-dates">
                    <i class="fas fa-calendar-alt"></i> إظهار/إخفاء التواريخ
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-3">
                    <input type="text" id="client-search" class="form-control" placeholder="بحث باسم العميل...">
                </div>
                <div class="col-md-3">
                    <select id="group-filter" class="form-control">
                        <option value="">جميع المجموعات</option>
                        @foreach ($groups as $group)
                            <option value="group-{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="activity-filter btn-group btn-group-toggle" data-toggle="buttons">
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
                <div class="col-md-3">
                    <button id="export-excel" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> تصدير لإكسل
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <button id="prev-period" class="btn btn-outline-primary">
                    <i class="fas fa-chevron-right"></i> الأسابيع السابقة
                </button>
                <h5 id="current-period" class="text-center">{{ $weeks[0]['month_year'] ?? '' }}</h5>
                <button id="next-period" class="btn btn-outline-primary">
                    الأسابيع التالية <i class="fas fa-chevron-left"></i>
                </button>
            </div>

            <div id="weeks-container" data-current-weeks="{{ json_encode($weeks) }}"></div>

            <div class="accordion" id="groups-accordion">
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

                    <div class="card mb-2 group-section" id="group-{{ $group->id }}">
                        <div class="card-header" id="heading-{{ $group->id }}">
                            <h5 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse"
                                    data-target="#collapse-{{ $group->id }}" aria-expanded="true"
                                    aria-controls="collapse-{{ $group->id }}">
                                    <i class="fas fa-map-marker-alt text-danger"></i> {{ $group->name }}
                                    <span class="badge badge-primary badge-pill ml-2">
                                        {{ $clients->count() }}
                                    </span>

                                    @foreach($statusCounts as $status => $count)
                                        @php
                                            $color = $clients->first(function($client) use ($status) {
                                                return (optional($client->status_client)->name ?? 'غير محدد') === $status;
                                            })->status_client->color ?? '#6c757d';
                                        @endphp
                                        <span class="badge badge-pill ml-1" style="background-color: {{ $color }}; color: white;">
                                            {{ $status }}: {{ $count }}
                                        </span>
                                    @endforeach
                                </button>
                            </h5>
                        </div>

                        <div id="collapse-{{ $group->id }}" class="collapse show"
                            aria-labelledby="heading-{{ $group->id }}" data-parent="#groups-accordion">
                            <div class="card-body p-0">
                                @if ($clients->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered text-center mb-0 client-table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 20%; min-width: 200px;">العميل</th>
                                                    @foreach ($weeks as $week)
                                                        <th class="week-header" style="min-width: 80px;">
                                                            <div class="week-number">الأسبوع {{ $week['week_number'] }}</div>
                                                            <div class="week-dates">
                                                                {{ \Carbon\Carbon::parse($week['start'])->format('d/m') }}
                                                                -
                                                                {{ \Carbon\Carbon::parse($week['end'])->format('d/m') }}
                                                            </div>
                                                        </th>
                                                    @endforeach
                                                    <th>إجمالي النشاط</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($clients as $client)
                                                    <tr class="client-row" data-client="{{ $client->trade_name }}" data-status="{{ optional($client->status_client)->name ?? 'غير محدد' }}">
                                                        <td class="text-start align-middle">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar mr-1">
                                                                    <span class="avatar-content" style="background-color: {{ optional($client->status_client)->color ?? '#6c757d' }}">
                                                                        {{ substr($client->trade_name, 0, 1) }}
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <strong>{{ $client->trade_name }}-{{ $client->code }}</strong>
                                                                    <strong>
                                                                        @if ($client->status_client)
                                                                            <span style="background-color: {{ $client->status_client->color }}; color: #fff; padding: 2px 8px; font-size: 12px; border-radius: 4px; display: inline-block;">
                                                                                {{ $client->status_client->name }}
                                                                            </span>
                                                                        @else
                                                                            <span style="background-color: #6c757d; color: #fff; padding: 2px 8px; font-size: 12px; border-radius: 4px; display: inline-block;">
                                                                                غير محدد
                                                                            </span>
                                                                        @endif
                                                                    </strong>
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

                                                                // فحص الفواتير
                                                                if ($client->invoices->whereBetween('created_at', [$week['start'], $week['end']])->count()) {
                                                                    $activities[] = ['icon' => '🧾', 'title' => 'فاتورة'];
                                                                    $hasActivity = true;
                                                                }

                                                                // فحص المدفوعات
                                                                if ($client->payments->whereBetween('created_at', [$week['start'], $week['end']])->count()) {
                                                                    $activities[] = ['icon' => '💵', 'title' => 'دفعة'];
                                                                    $hasActivity = true;
                                                                }

                                                                // فحص الملاحظات
                                                                if ($client->appointmentNotes->whereBetween('created_at', [$week['start'], $week['end']])->count()) {
                                                                    $activities[] = ['icon' => '📝', 'title' => 'ملاحظة'];
                                                                    $hasActivity = true;
                                                                }

                                                                // فحص الزيارات
                                                                if ($client->visits->whereBetween('created_at', [$week['start'], $week['end']])->count()) {
                                                                    $activities[] = ['icon' => '👣', 'title' => 'زيارة'];
                                                                    $hasActivity = true;
                                                                }

                                                                // فحص سندات القبض
                                                                $receiptsCount = $client->accounts->flatMap(function($account) use ($week) {
                                                                    return $account->receipts->whereBetween('created_at', [$week['start'], $week['end']]);
                                                                })->count();

                                                                if ($receiptsCount > 0) {
                                                                    $activities[] = ['icon' => '💰', 'title' => 'سند قبض'];
                                                                    $hasActivity = true;
                                                                }

                                                                if ($hasActivity) {
                                                                    $totalActivities++;
                                                                }
                                                            @endphp
                                                            <td class="align-middle activity-cell @if ($hasActivity) bg-light-success @endif"
                                                                data-has-activity="{{ $hasActivity ? '1' : '0' }}">
                                                                @if ($hasActivity)
                                                                    <div class="activity-icons">
                                                                        @foreach ($activities as $activity)
                                                                            <span title="{{ $activity['title'] }}">
                                                                                {{ $activity['icon'] }}
                                                                            </span>
                                                                        @endforeach
                                                                    </div>
                                                                @else
                                                                    <span class="text-muted">—</span>
                                                                @endif
                                                            </td>
                                                        @endforeach

                                                        <td class="align-middle">
                                                            <span class="badge badge-pill @if ($totalActivities > 0) badge-light-success @else badge-light-secondary @endif">
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
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .card-header h5 button {
            font-weight: 600;
            color: #5a5a5a;
            text-decoration: none;
            width: 100%;
            text-align: right;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header .badge-container {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-right: 10px;
        }

        .activity-icons span {
            margin: 0 2px;
            font-size: 1.2em;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .activity-icons span:hover {
            transform: scale(1.3);
        }

        .week-header {
            vertical-align: middle;
            font-size: 0.85rem;
        }

        .week-number {
            font-weight: bold;
            margin-bottom: 3px;
        }

        .week-dates {
            color: #6c757d;
            font-size: 0.75rem;
        }

        .client-table th {
            white-space: nowrap;
        }

        .avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
        }

        .avatar-content {
            color: white;
            font-weight: bold;
        }

        .toggle-week-dates {
            font-size: 0.8rem;
        }

        #current-period {
            font-weight: bold;
            padding: 5px 15px;
            background: #f8f9fa;
            border-radius: 20px;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }

        .loading-spinner {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .status-filter {
            margin-top: 10px;
        }

        .status-filter .btn {
            margin-left: 5px;
            margin-bottom: 5px;
            font-size: 0.8rem;
            padding: 3px 8px;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function() {
            // إعداد Toastr
            toastr.options = {
                "positionClass": "toast-top-left",
                "rtl": true,
                "timeOut": 3000
            };

            // إظهار/إخفاء تواريخ الأسابيع
            $('.toggle-week-dates').click(function() {
                $('.week-dates').toggle();
                $(this).toggleClass('btn-primary btn-outline-primary');
            });

            // فلترة حسب اسم العميل
            $('#client-search').on('keyup', function() {
                const searchText = $(this).val().toLowerCase();
                $('.client-row').each(function() {
                    const clientName = $(this).data('client').toLowerCase();
                    $(this).toggle(clientName.includes(searchText));
                });
            });

            // فلترة حسب المجموعة
            $('#group-filter').change(function() {
                const groupId = $(this).val();
                if (groupId) {
                    $('.group-section').addClass('d-none');
                    $(groupId).removeClass('d-none');
                } else {
                    $('.group-section').removeClass('d-none');
                }
            });

            // فلترة حسب النشاط
            $('input[name="activity"]').change(function() {
                const filter = $(this).val();
                $('.client-row').each(function() {
                    const row = $(this);
                    if (filter === 'all') {
                        row.show();
                    } else if (filter === 'has-activity') {
                        const hasActivity = row.find('.activity-cell[data-has-activity="1"]').length > 0;
                        row.toggle(hasActivity);
                    } else if (filter === 'no-activity') {
                        const noActivity = row.find('.activity-cell[data-has-activity="1"]').length === 0;
                        row.toggle(noActivity);
                    }
                });
            });

            // فلترة حسب حالة العميل
            $(document).on('click', '.status-filter-btn', function() {
                const status = $(this).data('status');
                $('.client-row').each(function() {
                    const rowStatus = $(this).data('status');
                    $(this).toggle(rowStatus === status);
                });

                // تحديث حالة الأزرار
                $('.status-filter-btn').removeClass('active').removeClass('btn-primary').addClass('btn-outline-primary');
                $(this).addClass('active').addClass('btn-primary').removeClass('btn-outline-primary');
            });

            // التصدير إلى Excel
            $('#export-excel').click(function() {
                // إنشاء ورقة عمل Excel
                const wb = XLSX.utils.book_new();
                const wsData = [];

                // إضافة العناوين
                const headers = ['العميل', 'الحالة'];
                $('.week-header .week-number').each(function() {
                    headers.push($(this).text());
                });
                headers.push('إجمالي النشاط');
                wsData.push(headers);

                // إضافة بيانات العملاء
                $('.client-row').each(function() {
                    if ($(this).is(':visible')) {
                        const row = [];
                        const clientName = $(this).find('td:first-child strong').first().text();
                        const clientStatus = $(this).data('status');
                        row.push(clientName, clientStatus);

                        $(this).find('.activity-cell').each(function() {
                            const hasActivity = $(this).data('has-activity') === '1';
                            row.push(hasActivity ? 'نعم' : 'لا');
                        });

                        const totalActivities = $(this).find('.badge-pill').text();
                        row.push(totalActivities);

                        wsData.push(row);
                    }
                });

                // تحويل البيانات إلى ورقة عمل
                const ws = XLSX.utils.aoa_to_sheet(wsData);

                // إضافة ورقة العمل إلى الكتاب
                XLSX.utils.book_append_sheet(wb, ws, "تحليل الزيارات");

                // تنزيل الملف
                XLSX.writeFile(wb, 'تحليل_الزيارات_' + new Date().toISOString().split('T')[0] + '.xlsx');
            });

            // متغيرات التحكم في الفترات الزمنية
            let currentWeekOffset = 0;
            let isLoading = false;

            // عرض شاشة التحميل
            function showLoading() {
                isLoading = true;
                $('body').append('<div class="loading-overlay"><div class="loading-spinner"></div></div>');
                $('.loading-overlay').fadeIn();
            }

            // إخفاء شاشة التحميل
            function hideLoading() {
                isLoading = false;
                $('.loading-overlay').fadeOut(function() {
                    $(this).remove();
                });
            }

            // تحديث الجدول بناء على الأسابيع
            function updateTable(weeks) {
                showLoading();

                // هنا يمكنك إجراء طلب Ajax لتحميل البيانات الجديدة
                $.ajax({
                    url: '{{ route("get.traffic.data") }}',
                    method: 'POST',
                    data: {
                        weeks: weeks,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // في هذا المثال، سنقوم فقط بتحديث عرض الفترة
                        // في تطبيق حقيقي، ستحتاج إلى تحديث الجدول بالبيانات الجديدة
                        updatePeriodDisplay(weeks);
                        hideLoading();
                    },
                    error: function() {
                        toastr.error('حدث خطأ أثناء تحميل البيانات');
                        hideLoading();
                    }
                });
            }

            // تحديث عرض الفترة الحالية
            function updatePeriodDisplay(weeks) {
                if (weeks.length > 0) {
                    const firstWeek = weeks[0];
                    const displayText = firstWeek.month_year;
                    $('#current-period').text(displayText);
                    $('#weeks-container').data('current-weeks', weeks);
                }
            }

            // تحميل الأسابيع السابقة
            $('#prev-period').click(function() {
                if (isLoading) return;

                currentWeekOffset += 4;
                loadWeeks();
            });

            // تحميل الأسابيع التالية
            $('#next-period').click(function() {
                if (isLoading) return;

                if (currentWeekOffset > 0) {
                    currentWeekOffset -= 4;
                    loadWeeks();
                } else {
                    toastr.info('أنت تشاهد أحدث الأسابيع');
                }
            });

            // تحميل بيانات الأسابيع
            function loadWeeks() {
                showLoading();

                $.ajax({
                    url: '{{ route("get.weeks.data") }}',
                    method: 'POST',
                    data: {
                        offset: currentWeekOffset,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        updateTable(response.weeks);
                    },
                    error: function() {
                        toastr.error('حدث خطأ أثناء تحميل الأسابيع');
                        hideLoading();
                    }
                });
            }

            // التهيئة الأولية
            updatePeriodDisplay(@json($weeks));
        });
    </script>
@endsection
