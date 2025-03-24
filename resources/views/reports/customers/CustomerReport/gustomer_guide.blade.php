@extends('master')

@section('title')
    تقرير دليل العملاء
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
    <style>
        /* أنماط الأزرار */
        .btn-primary {
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #2575fc, #6a11cb);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: linear-gradient(45deg, #ff5722, #e64a19);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: linear-gradient(45deg, #e64a19, #ff5722);
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(45deg, #4caf50, #388e3c);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: linear-gradient(45deg, #388e3c, #4caf50);
            transform: translateY(-2px);
        }

        .btn-export {
            background: linear-gradient(45deg, #ff9800, #f57c00);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-export:hover {
            background: linear-gradient(45deg, #f57c00, #ff9800);
            transform: translateY(-2px);
        }

        /* أنماط كارت الخريطة */
        .map-card {
            height: 100%;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: none;
            display: flex;
            flex-direction: column;
        }

        .map-card .card-header {
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            color: white;
            border-radius: 8px 8px 0 0 !important;
            padding: 12px 20px;
            border-bottom: none;
        }

        .map-card .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
        }

        .map-card .card-body {
            padding: 0;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        /* أنماط الخريطة */
        #clientMap {
            height: 500px;
            width: 100%;
            border-radius: 0 0 8px 8px;
            display: none;
        }

        /* أنماط العنصر المؤقت */
        #mapPlaceholder {
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 0 0 8px 8px;
            flex-grow: 1;
        }

        .placeholder-content {
            max-width: 80%;
            text-align: center;
            padding: 20px;
        }

        #mapPlaceholder i {
            font-size: 3.5rem;
            color: #adb5bd;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        #mapPlaceholder h5 {
            color: #6c757d;
            margin-bottom: 10px;
            font-weight: 600;
        }

        #mapPlaceholder p {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .map-card .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #eee;
            padding: 8px 15px;
            text-align: center;
            font-size: 0.8rem;
            color: #6c757d;
            border-radius: 0 0 8px 8px;
        }

        /* تأثيرات عند إظهار الخريطة */
        .map-visible #mapPlaceholder {
            display: none;
        }

        .map-visible #clientMap {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* تحسينات للجدول */
        .table-responsive {
            max-height: 600px;
            overflow-y: auto;
        }

        .location-link {
            color: #2575fc;
            cursor: pointer;
            text-decoration: underline;
            transition: all 0.2s ease;
        }

        .location-link:hover {
            color: #6a11cb;
            text-decoration: none;
        }
    </style>
@endsection

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">تقرير دليل العملاء</h2>
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

    <div class="card mb-4">
        <div class="card-body">
            <div class="filter-section">
                <form action="{{ route('ClientReport.customerGuide') }}" method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="region" class="form-label">المنطقة:</label>
                            <select id="region" name="region" class="form-control" onchange="updateCities()">
                                <option value="الكل">الكل</option>
                                @foreach(array_keys($saudiRegions) as $region)
                                    <option value="{{ $region }}" {{ request('region') == $region ? 'selected' : '' }}>
                                        {{ $region }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="city" class="form-label">المدينة:</label>
                            <select id="city" name="city" class="form-control">
                                <option value="الكل">الكل</option>
                                @if(request('region') && request('region') !== 'الكل')
                                    @foreach($saudiRegions[request('region')] as $city)
                                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                            {{ $city }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>                        <div class="col-md-3">
                            <label for="country" class="form-label">البلد:</label>
                            <input type="text" id="country" name="country" class="form-control" value="{{ request('country') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="classification" class="form-label">التصنيف:</label>
                            <select id="classification" name="classification" class="form-control">
                                <option value="الكل">الكل</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('classification') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label for="branch" class="form-label">الفرع:</label>
                            <select id="branch" name="branch" class="form-control">
                                <option value="الكل">الكل</option>
                                @foreach ($branch as $br)
                                    <option value="{{ $br->id }}" {{ request('branch') == $br->id ? 'selected' : '' }}>
                                        {{ $br->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="group-by" class="form-label">تجميع حسب:</label>
                            <select id="group-by" name="group_by" class="form-control">
                                <option value="العميل" {{ request('group_by') == 'العميل' ? 'selected' : '' }}>العميل</option>
                                <option value="الفرع" {{ request('group_by') == 'الفرع' ? 'selected' : '' }}>الفرع</option>
                                <option value="المدينة" {{ request('group_by') == 'المدينة' ? 'selected' : '' }}>المدينة</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-center">
                            <input type="checkbox" id="view-details" name="view_details" class="form-check-input me-2" {{ request('view_details') ? 'checked' : '' }}>
                            <label for="view-details" class="form-check-label">مشاهدة التفاصيل</label>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-filter"></i> تطبيق الفلتر
                            </button>
                            <a href="{{ route('ClientReport.customerGuide') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> إلغاء الفلتر
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="action-buttons text-end">
                <button class="btn btn-success" onclick="window.print()">
                    <i class="fas fa-print"></i> طباعة
                </button>
                <button class="btn btn-export export-excel">
                    <i class="fas fa-file-excel"></i> تصدير إلى Excel
                </button>
            </div>
        </div>
    </div>
    <div class="card mt-4" id="mapSection">
        <div class="card-body">
            <div class="col-md-12">
                <div class="card map-card h-60">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title text-center mb-0">
                            <i class="fas fa-map-marked-alt me-2"></i>خريطة مواقع العملاء
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <!-- Placeholder -->
                        <div id="mapPlaceholder" class="text-center p-5">
                            <div class="placeholder-content">
                                <i class="fas fa-map-marked-alt"></i>
                                <h5>خريطة مواقع العملاء</h5>
                                <p>اختر عميلاً من الجدول لعرض موقعه على الخريطة</p>
                            </div>
                        </div>

                        <!-- Actual Map (hidden by default) -->
                        <div id="clientMap"></div>
                    </div>
                    <div class="card-footer bg-light text-center py-2">
                        <small class="text-muted">انقر على "عرض على الخريطة" في الجدول</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-center mb-4">دليل العملاء - تجميع حسب {{ request('group_by', 'العميل') }}</h5>
                    <p class="text-center">الوقت: {{ now()->format('H:i d/m/Y') }}</p>
                    <p class="text-center">مؤسسة أعمال خاصة للتجارة</p>
                    <p class="text-center">صاحب الحساب: {{ auth()->user()->name }}</p>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-center">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>الكود</th>
                                    <th>الاسم</th>
                                    <th>الموقع</th>
                                    <th>المنطقة</th>
                                    <th>الهاتف</th>
                                    <th>الجوال</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clients as $index => $client)
                                    <tr data-client-id="{{ $client->id }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $client->code }}</td>
                                        <td>{{ $client->trade_name }}</td>
                                        <td>
                                            @if($client->locations)
                                                <a href="#mapSection" class="location-link"
                                                   data-lat="{{ $client->locations->latitude }}"
                                                   data-lng="{{ $client->locations->longitude }}"
                                                   data-name="{{ $client->trade_name }}"
                                                   data-code="{{ $client->code }}">
                                                    عرض على الخريطة
                                                </a>
                                            @else
                                                <span class="text-muted">غير متوفر</span>
                                            @endif
                                        </td>
                                        <td>{{ $client->region }}</td>
                                        <td>{{ $client->phone }}</td>
                                        <td>{{ $client->mobile }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap&libraries=places&v=weekly" async defer></script>


    <script>
        let map;
        const markers = [];
        let mapInitialized = false;
        let googleMapsLoading = false;

        function loadGoogleMaps() {
            return new Promise((resolve, reject) => {
                if (typeof google !== 'undefined' && google.maps) {
                    resolve();
                    return;
                }

                if (googleMapsLoading) {
                    const check = setInterval(() => {
                        if (typeof google !== 'undefined' && google.maps) {
                            clearInterval(check);
                            resolve();
                        }
                    }, 100);
                    return;
                }

                googleMapsLoading = true;
                const script = document.createElement('script');
                script.src = `https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap&libraries=places&v=weekly`;
                script.async = true;
                script.defer = true;
                script.onload = () => {
                    googleMapsLoading = false;
                    resolve();
                };
                script.onerror = () => {
                    googleMapsLoading = false;
                    reject(new Error('Failed to load Google Maps API'));
                };
                document.head.appendChild(script);
            });
        }

        function initMap() {
            const mapElement = document.getElementById("clientMap");
            if (!mapElement) return;

            map = new google.maps.Map(mapElement, {
                center: { lat: 24.7136, lng: 46.6753 },
                zoom: 6,
                styles: [
                    {
                        "featureType": "poi",
                        "stylers": [
                            { "visibility": "off" }
                        ]
                    }
                ]
            });
            mapInitialized = true;

            @foreach($clients as $client)
                @if($client->locations)
                    addClientMarker(
                        {{ $client->id }},
                        {{ $client->locations->latitude }},
                        {{ $client->locations->longitude }},
                        "{{ $client->trade_name }}",
                        "{{ $client->code }}"
                    );
                @endif
            @endforeach
        }

        async function showMapWithMarker(lat, lng, clientId, name, code) {
            try {
                // Add visible class to parent card
                const mapCard = document.querySelector('.map-card');
                mapCard.classList.add('map-visible');

                // Scroll to map section smoothly
                document.getElementById('mapSection').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                // Load Google Maps API if not loaded
                await loadGoogleMaps();

                // Initialize map if not already done
                if (!mapInitialized) {
                    initMap();
                }

                // Make sure map is initialized
                const checkMap = setInterval(() => {
                    if (mapInitialized) {
                        clearInterval(checkMap);

                        // Center the map on the selected location
                        map.setCenter({ lat, lng });
                        map.setZoom(15);

                        // Find or create the marker
                        let marker = markers.find(m => m.id == clientId);
                        if (!marker) {
                            marker = addClientMarker(clientId, lat, lng, name, code);
                        }

                        // Animate the marker
                        marker.marker.setAnimation(google.maps.Animation.BOUNCE);
                        setTimeout(() => {
                            marker.marker.setAnimation(null);
                        }, 1500);

                        // Open info window
                        marker.infoWindow.open(map, marker.marker);
                    }
                }, 100);
            } catch (error) {
                console.error('Error loading Google Maps:', error);
                alert('حدث خطأ أثناء تحميل الخريطة. يرجى المحاولة مرة أخرى.');
            }
        }

        function addClientMarker(id, lat, lng, name = null, code = null) {
            const position = { lat, lng };
            const marker = new google.maps.Marker({
                position,
                map,
                title: name || '',
                icon: {
                    url: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png'
                }
            });

            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div style="direction: rtl; text-align: right; min-width: 200px;">
                        ${name ? `<h6 style="margin-bottom: 5px; color: #2575fc;">${name}</h6>` : ''}
                        ${code ? `<p style="margin: 0; color: #6c757d;"><small>الكود: ${code}</small></p>` : ''}
                        <div style="margin-top: 10px;">
                            <a href="https://www.google.com/maps?q=${lat},${lng}" target="_blank"
                               style="color: #4caf50; text-decoration: none;">
                                <i class="fas fa-external-link-alt"></i> فتح في خرائط جوجل
                            </a>
                        </div>
                    </div>
                `,
            });

            marker.addListener("click", () => {
                infoWindow.open(map, marker);
            });

            const markerObj = { id, marker, infoWindow };
            markers.push(markerObj);
            return markerObj;
        }

        // Handle click on location links
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.location-link').forEach(link => {
                link.addEventListener('click', async function(e) {
                    e.preventDefault();
                    const lat = parseFloat(this.dataset.lat);
                    const lng = parseFloat(this.dataset.lng);
                    const clientId = this.closest('tr').dataset.clientId;
                    const name = this.dataset.name;
                    const code = this.dataset.code;

                    await showMapWithMarker(lat, lng, clientId, name, code);
                });
            });
        });

        // Export to Excel function
        function exportToExcel() {
            const table = document.querySelector('table');
            const workbook = XLSX.utils.table_to_book(table, { sheet: "دليل العملاء" });
            XLSX.writeFile(workbook, 'دليل_العملاء_' + new Date().toISOString().slice(0, 10) + '.xlsx');
        }

        document.querySelector('.export-excel').addEventListener('click', exportToExcel);

    </script>
@endsection
