<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>POS</title>
    <link rel="apple-touch-icon" href="{{asset('app-assets/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('app-assets/images/ico/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/vendors-rtl.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/extensions/nouislider.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/ui/prism.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/select/select2.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/core/colors/palette-gradient.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/extensions/noui-slider.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/pages/app-ecommerce-shop.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/custom-rtl.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style-rtl.css')}}">
    <!-- END: Custom CSS-->

    <link rel="stylesheet" href="{{ asset('assets/fonts/Cairo/stylesheet.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        .content-wrapper {
            display: flex;
            height: 100%;
        }

        .left-card {
            flex: 2;
        }

        .right-card {
            flex: 1;
        }

        .card {
            height: 100%;
        }
        body, h1, h2, h3, h4, h5, h6,.navigation,.header-navbar,.breadcrumb {
            font-family: 'Cairo';
        }
        .header-right {
            background-color: #373F6A;
            color: white;
            align-items: center;
            padding: 10px 15px;
        }

        .header-right .actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-right .actions button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .header-right .actions button:hover {
            background-color: #45a049;
        }

        .content-right {
            background-color: #E9EEF4;
            height: calc(90vh - 120px);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px;
        }

        .footer-right {
            background-color: white;
            box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-right .summary {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-right .summary span {
            font-weight: bold;
            color: green;
        }

        .footer-right .payment-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .footer-right .payment-btn:hover {
            background-color: #45a049;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 10px;
            overflow: hidden;
            white-space: nowrap;
        }

        .numbers-container {
            display: flex;
            gap: 5px;
            padding: 5px;
            overflow-x: hidden;
            white-space: nowrap;
        }

        .number-display {
            font-weight: bold;
            border: 1px solid white;
            border-radius: 5px;
            padding: 7px 14px;
            display: inline-block;
            margin: 2px;
            flex-shrink: 0;
            cursor: pointer;
            user-select: none;
        }
    </style>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static   menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

    <!-- BEGIN: Content-->
    <div class="app-content p-1" style="margin-right: 0px; height: 100vh;">
        <div class="content-wrapper" style="display: flex; height: 100%;">

            <div class="col-md-4 right-card">
                <div class="card" style="height: 100%;">
                    <div class="card-content">
                        <div class="card-body">

                            <header class="header-right">
                                <div class="d-flex justify-content-between">
                                    <div class="div"></div>
                                    <div class="actions">
                                        <div class="numbers-container" id="numbers-container">
                                            <!-- Numbers will be added here -->
                                        </div>

                                        <button id="prev-btn"><i class="fas fa-angle-double-right"></i></button>
                                        <button id="next-btn"><i class="fas fa-angle-double-left"></i></button>
                                        <button id="add-btn"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <hr style="background: white">
                                <a href="#" class="text-white" id="choose-client">
                                    <span><i class="fas fa-user"></i> <span id="selected-client-name">اختر العميل</span></span>
                                </a>
                            </header>

                            <main class="content-right" style="width: 100%; overflow: auto;align-items: start; height: 66vh;">
                                <table class="table" id="product-table">
                                    <tbody>
                                    </tbody>
                                </table>
                            </main>

                            <footer class="footer-right">
                                <div class="summary">
                                    <span class="p-1">البنود : <span id="total-points">0</span></span>
                                    <span class="p-1">الإجمالي : <span id="total-price">0.00</span> ر.س</span>
                                </div>
                                <button class="payment-btn">عملية الدفع</button>
                            </footer>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-md-6 left-card">
                <div class="card" style="height: 100%">
                    <div class="card-content">
                        <div class="card-body">
                            <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-light navbar-shadow" style="background-color: #373F6A">
                                <div class="navbar-wrapper">
                                    <div class="navbar-container content">
                                        <div class="navbar-collapse" id="navbar-mobile-1">
                                            <ul class="nav navbar-nav bookmark-icons mr-auto float-left">
                                                <li class="nav-item nav-search"><a class="nav-link"><i class="ficon feather icon-printer text-white"></i></a>
                                                    <div class="search-input">
                                                        <div class="search-input-icon"><i class="feather icon-printer primary"></i></div>
                                                    </div>
                                                </li>

                                                <li class="nav-item nav-search"><a class="nav-link"><i class="ficon feather icon-airplay text-white"></i></a>
                                                    <div class="search-input">
                                                        <div class="search-input-icon"><i class="feather icon-airplay primary"></i></div>
                                                    </div>
                                                </li>

                                                <li class="nav-item nav-search"><a href="{{ route('dashboard_sales.index') }}" target="_blank" class="nav-link"><i class="ficon feather icon-home text-white"></i></a>
                                                    <div class="search-input">
                                                        <div class="search-input-icon"><i class="feather icon-home primary"></i></div>
                                                    </div>
                                                </li>
                                            </ul>

                                            <ul class="nav navbar-nav float-right">

                                                <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                                        <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600 text-white">{{ auth()->user()->name }}</span>
                                                            <span class="user-status">
                                                                <span class="text-white">{{ \Carbon\Carbon::now()->translatedFormat('l، d F Y') }}</span>
                                                            </span>
                                                        </div>
                                                        <span>
                                                            <img class="round" src="{{asset('app-assets/images/portrait/small/avatar-s-13.jpg')}}" alt="avatar" height="40" width="40">
                                                        </span>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#"><i class="feather icon-user"></i> Edit Profile</a>
                                                        <a class="dropdown-item" href="#"><i class="feather icon-mail"></i> My Inbox</a>
                                                        <a class="dropdown-item" href="#"><i class="feather icon-check-square"></i> Task</a>
                                                        <a class="dropdown-item" href="#"><i class="feather icon-message-square"></i> Chats</a>
                                                        <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="feather icon-power"></i> Logout</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </nav>

                            <div class="row pt-1">
                                <div class="col-md-3 d-flex">
                                    <button type="button" class="btn btn-icon btn-flat-primary mr-1 mb-1 waves-effect waves-light" id="products-btn"><i class="feather icon-list"></i></button>
                                    <div class="dropdown">
                                        <button class="btn btn-flat-primary dropdown-toggle mr-1 mb-1 waves-effect waves-light" type="button" id="dropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="feather icon-package"></i> المنتجات
                                        </button>

                                        <div class="dropdown-menu" aria-labelledby="dropdownButton">
                                            <a class="dropdown-item" href="#" id="search-product">
                                                <i class="feather icon-package"></i> بحث عن منتج
                                            </a>
                                            <a class="dropdown-item" href="#" id="search-invoice">
                                                <i class="feather icon-file"></i> بحث عن فاتورة
                                            </a>
                                            <a class="dropdown-item" href="#" id="search-client">
                                                <i class="feather icon-user"></i> بحث عن عميل
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="search" id="search" class="form-control" placeholder="بحث عن منتج">
                                </div>
                            </div>

                        </div>
                        <div class="card-body pt-0" style="height: 70vh; overflow: auto">

                            <div class="row p-1 products-card" id="products-card">
                                @foreach ($products as $product)
                                    <div class="col-md-2 mr-1 p-0 mb-1">
                                        <div class="card product-card" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->sale_price }}" data-unit="1" style="border: 1px solid #ccc;box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1)">
                                            <div class="card-content">
                                                @if($product->images)
                                                    <img class="card-img-top img-fluid" src="{{ asset('assets/uploads/product/' . $product->images) }}" alt="Card image cap">
                                                @else
                                                    <img class="card-img-top img-fluid" src="{{ asset('assets/uploads/no_image.jpg') }}" alt="Card image cap">
                                                @endif
                                                <div class="card-body">
                                                    <h6>{{ $product->name }}</h6>
                                                    <div class="d-flex justify-content-between">
                                                        <small class="text-muted">{{ $product->sale_price }} SAR</small>
                                                        <a href="#" data-toggle="modal" data-target="#xlarge{{ $product->id }}"><i class="fa fa-info-circle"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade text-left" id="xlarge{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel16"><strong>{{ $product->name }}</strong> | @if($product->status == 0) <small class="bullet bullet-success bullet-sm"></small> <small>نشط</small> @else <small class="bullet bullet-danger bullet-sm"></small> <small>غير نشط</small> @endif</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th><i class="feather icon-shopping-cart text-warning font-medium-1"></i> اجمالي القطع المباعة</th>
                                                                <th><i class="feather icon-calendar text-danger font-medium-1"></i> اخر 28 يوم</th>
                                                                <th><i class="feather icon-calendar text-primary font-medium-1"></i> اخر 7 ايام</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>0</td>
                                                                <td>0</td>
                                                                <td>0</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <strong>التفاصيل :</strong>
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    @if($product->images)
                                                                        <img class="" src="{{ asset('assets/uploads/product/' . $product->images) }}" alt="Card image cap" width="150px">
                                                                    @else
                                                                        <img class="" src="{{ asset('assets/uploads/no_image.jpg') }}" alt="Card image cap">
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <strong>كود المنتج </strong>: {{ $product->code }}#
                                                                </td>
                                                                <td>
                                                                    <strong>التصنيفات</strong><br>
                                                                    <small>منتج</small>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">اغلاق</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                @endforeach
                            </div>

                            <!-- Clients Card -->
                            <div id="clients-card" class="card clients-card" style="display: none;">
                                @foreach ($clients as $client)
                                    <div class="col-md-3 mr-1 p-0 mb-1">
                                        <div class="card client-card align-items-center" style="border: 1px solid #ccc;box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1)">
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <div class="mb-1">
                                                        <strong>{{ $client->trade_name }}</strong>
                                                    </div>
                                                    <div class="mr-1">
                                                        <small class="text-muted"><i class="fa fa-phone mr-1"></i>{{ $client->phone }}</small>
                                                    </div>
                                                    <a href="#"><i class="fa fa-info-circle m-1"></i></a>
                                                    <a href="#"><i class="fa fa-edit m-1"></i></a>
                                                    <a href="#"><i class="fa fa-map-marker m-1"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Invoice Card -->
                            <div id="invoice-card" class="card" style="display: none;">
                                الفواتير
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('app-assets/vendors/js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('app-assets/vendors/js/ui/prism.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/extensions/wNumb.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/extensions/nouislider.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('app-assets/js/core/app-menu.js')}}"></script>
    <script src="{{asset('app-assets/js/core/app.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/components.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{asset('app-assets/js/scripts/pages/app-ecommerce-shop.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const numbersContainer = document.getElementById('numbers-container');
            const productCards = document.querySelectorAll('.product-card');
            const productTable = document.getElementById('product-table').querySelector('tbody');
            const totalPriceElement = document.getElementById('total-price');
            const totalPointsElement = document.getElementById('total-points');
            const selectedClientName = document.getElementById('selected-client-name');

            let orders = []; // قائمة لتخزين الطلبات
            let currentOrder = null; // الطلب الحالي
            let selectedClient = null; // العميل المحدد

            // إنشاء الرقم الأول (#1) عند تحميل الصفحة
            const initialNumberDiv = document.createElement('div');
            initialNumberDiv.className = 'number-display';
            initialNumberDiv.textContent = '#1';
            initialNumberDiv.style.backgroundColor = "#4CAF50"; // تعيين لون الخلفية للرقم الأول
            numbersContainer.appendChild(initialNumberDiv);

            // إنشاء الطلب الأول (#1)
            currentOrder = {
                orderNumber: 1,
                client: null,
                products: [],
                totalPrice: 0,
                totalPoints: 0
            };
            orders.push(currentOrder);

            // تغيير لون خلفية الرقم عند النقر عليه
            numbersContainer.addEventListener('click', (e) => {
                const clickedDiv = e.target.closest('.number-display');
                if (clickedDiv) {
                    // إعادة تعيين لون الخلفية لجميع الأرقام
                    document.querySelectorAll('.number-display').forEach(div => {
                        div.style.backgroundColor = "";
                    });

                    // تغيير لون خلفية الرقم المحدد
                    clickedDiv.style.backgroundColor = "#4CAF50";

                    // تحديث الطلب الحالي بناءً على الرقم المحدد
                    const orderNumber = parseInt(clickedDiv.textContent.replace('#', ''));
                    currentOrder = orders.find(order => order.orderNumber === orderNumber);
                    selectedClient = currentOrder.client;
                    selectedClientName.textContent = selectedClient ? selectedClient : "اختر العميل";
                    updateProductTable(currentOrder.products);
                    updateTotals(currentOrder.totalPrice, currentOrder.totalPoints);
                }
            });

            // التمرير إلى اليسار (<<)
            document.getElementById('prev-btn').addEventListener('click', () => {
                numbersContainer.scrollBy({
                    left: -100, // التمرير لليسار بمقدار 100px
                    behavior: 'smooth' // تمرير سلس
                });
            });

            // التمرير إلى اليمين (>>)
            document.getElementById('next-btn').addEventListener('click', () => {
                numbersContainer.scrollBy({
                    left: 100, // التمرير لليمين بمقدار 100px
                    behavior: 'smooth' // تمرير سلس
                });
            });

            // إضافة رقم جديد (طلب جديد)
            document.getElementById('add-btn').addEventListener('click', () => {
                const newOrderNumber = orders.length + 1;
                const newNumberDiv = document.createElement('div');
                newNumberDiv.className = 'number-display';
                newNumberDiv.textContent = `#${newOrderNumber}`;
                numbersContainer.appendChild(newNumberDiv);

                // إنشاء طلب جديد
                const newOrder = {
                    orderNumber: newOrderNumber,
                    client: null,
                    products: [],
                    totalPrice: 0,
                    totalPoints: 0
                };
                orders.push(newOrder);
                currentOrder = newOrder;
                selectedClient = null;
                selectedClientName.textContent = "اختر العميل";
                updateProductTable([]);
                updateTotals(0, 0);
            });

            // اختيار العميل
            document.getElementById("choose-client").addEventListener("click", function () {
                const dropdownButton = document.getElementById('dropdownButton');
                const searchInput = document.getElementById('search');

                document.getElementById("products-card").style.display = "none";
                document.getElementById("clients-card").style.display = "ruby";
                dropdownButton.innerHTML = '<i class="feather icon-users"></i> العملاء';
                searchInput.placeholder = 'بحث عن عميل';
                searchInput.focus();
            });

            document.getElementById("products-btn").addEventListener("click", function () {
                const dropdownButton = document.getElementById('dropdownButton');
                const searchInput = document.getElementById('search');

                document.getElementById("products-card").style.display = "flex";
                document.getElementById("clients-card").style.display = "none";
                dropdownButton.innerHTML = '<i class="feather icon-package"></i> المنتجات';
                searchInput.placeholder = 'بحث عن منتج';
                searchInput.focus();

            });

            // عند النقر على عميل
            const clientCards = document.querySelectorAll('.client-card');
            clientCards.forEach(card => {
                card.addEventListener('click', function () {
                    const clientName = this.querySelector('strong').textContent;
                    selectedClientName.textContent = clientName;
                    selectedClient = clientName; // تخزين العميل المحدد

                    // ربط العميل بالطلب الحالي
                    if (currentOrder) {
                        currentOrder.client = clientName;
                    }
                });
            });

            // إضافة منتج
            productCards.forEach(card => {

                card.addEventListener('click', (event) => {
                    // التحقق من وجود عميل محدد
                    if (!selectedClient) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'تنبيه!',
                            text: 'الرجاء اختيار عميل أولاً!',
                            confirmButtonText: 'حسناً'
                        });
                        return; // إيقاف الإجراء إذا لم يتم اختيار عميل
                    }

                    // التحقق إذا كان العنصر الذي تم النقر عليه هو رابط (fa-info-circle)
                    if (event.target.closest('a')) {
                        return; // إذا كان الرابط تم النقر عليه، قم بإيقاف تنفيذ الكود
                    }

                    const productId = card.getAttribute('data-id');
                    const productName = card.getAttribute('data-name');
                    const productPrice = parseFloat(card.getAttribute('data-price'));

                    // إضافة المنتج إلى الطلب الحالي
                    const existingProduct = currentOrder.products.find(product => product.id === productId);

                    if (existingProduct) {
                        existingProduct.quantity += 1;
                        existingProduct.totalPrice = existingProduct.quantity * productPrice;
                    } else {
                        currentOrder.products.push({
                            id: productId,
                            name: productName,
                            price: productPrice,
                            quantity: 1,
                            totalPrice: productPrice
                        });
                    }

                    // تحديث الإجمالي للطلب الحالي
                    currentOrder.totalPrice = currentOrder.products.reduce((sum, product) => sum + product.totalPrice, 0);
                    currentOrder.totalPoints = currentOrder.products.reduce((sum, product) => sum + product.quantity, 0);

                    updateProductTable(currentOrder.products);
                    updateTotals(currentOrder.totalPrice, currentOrder.totalPoints);
                });
            });

            // تحديث جدول المنتجات
            function updateProductTable(products) {
                productTable.innerHTML = ''; // مسح الجدول الحالي

                products.forEach(product => {
                    const newRow = document.createElement('tr');
                    newRow.setAttribute('data-product-id', product.id);
                    newRow.innerHTML = `
                        <td>
                            <p><strong>الوحدة</strong></p>
                            <small class="quantity">${product.quantity}</small>
                        </td>
                        <td>
                            <p><strong>${product.name}</strong></p>
                            <small>السعر : ${product.price}</small>
                        </td>
                        <td class="price">${product.totalPrice.toFixed(2)}</td>
                        <td><i class="feather icon-trash-2 delete-icon text-danger" style="cursor: pointer;"></i></td>
                    `;
                    productTable.appendChild(newRow);

                    newRow.querySelector('.delete-icon').addEventListener('click', function () {
                        currentOrder.products = currentOrder.products.filter(p => p.id !== product.id);
                        currentOrder.totalPrice = currentOrder.products.reduce((sum, product) => sum + product.totalPrice, 0);
                        currentOrder.totalPoints = currentOrder.products.reduce((sum, product) => sum + product.quantity, 0);
                        updateProductTable(currentOrder.products);
                        updateTotals(currentOrder.totalPrice, currentOrder.totalPoints);
                    });
                });
            }

            // تحديث الإجمالي
            function updateTotals(totalPrice, totalPoints) {
                totalPriceElement.innerText = totalPrice.toFixed(2);
                totalPointsElement.innerText = totalPoints;
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdownButton = document.getElementById('dropdownButton');
            const productsCard = document.getElementById('products-card');
            const clientsCard = document.getElementById('clients-card');
            const invoiceCard = document.getElementById('invoice-card');
            const searchInput = document.getElementById('search');

            document.getElementById('search-product').addEventListener('click', function (e) {
                e.preventDefault();
                productsCard.style.display = 'flex';
                clientsCard.style.display = 'none';
                invoiceCard.style.display = 'none';
                dropdownButton.innerHTML = '<i class="feather icon-package"></i> المنتجات';
                searchInput.placeholder = 'بحث عن منتج';
                searchInput.focus();
            });

            document.getElementById('search-invoice').addEventListener('click', function (e) {
                e.preventDefault();
                productsCard.style.display = 'none';
                clientsCard.style.display = 'none';
                invoiceCard.style.display = 'block';
                dropdownButton.innerHTML = '<i class="feather icon-file"></i> الفواتير';
                searchInput.placeholder = 'بحث عن فاتورة';
                searchInput.focus();
            });

            document.getElementById('search-client').addEventListener('click', function (e) {
                e.preventDefault();
                productsCard.style.display = 'none';
                clientsCard.style.display = 'ruby';
                invoiceCard.style.display = 'none';
                dropdownButton.innerHTML = '<i class="feather icon-users"></i> العملاء';
                searchInput.placeholder = 'بحث عن عميل';
                searchInput.focus();
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search'); // حقل البحث
            const productsCard = document.getElementById('products-card'); // قسم المنتجات
            const clientsCard = document.getElementById('clients-card'); // قسم العملاء

            // حدث عند الكتابة في حقل البحث
            searchInput.addEventListener('input', function () {
                const query = this.value; // النص المدخل في حقل البحث

                // إرسال طلب AJAX
                fetch(`/search?query=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        // تحديث واجهة المستخدم بناءً على النتائج
                        if (productsCard.style.display !== 'none') {
                            updateProducts(data); // إذا كان قسم المنتجات معروضًا
                        } else if (clientsCard.style.display !== 'none') {
                            updateClients(data); // إذا كان قسم العملاء معروضًا
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });

            // تحديث قسم المنتجات
            function updateProducts(products) {
                productsCard.innerHTML = ''; // مسح المحتوى الحالي

                products.forEach(product => {
                    const productCard = `
                        <div class="col-md-2 mr-1 p-0 mb-1">
                            <div class="card product-card" data-id="${product.id}" data-name="${product.name}" data-price="${product.sale_price}" data-unit="1" style="border: 1px solid #ccc;box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1)">
                                <div class="card-content">
                                    <img class="card-img-top img-fluid" src="${product.images && product.images !== 'null' ? '/assets/uploads/product/' + product.images : '/assets/uploads/no_image.jpg'}" alt="Card image cap">

                                    <div class="card-body">
                                        <h6>${product.name}</h6>
                                        <div class="d-flex justify-content-between">
                                            <small class="text-muted">${product.sale_price} SAR</small>
                                            <a href="#" data-toggle="modal" data-target="#xlarge${product.id}"><i class="fa fa-info-circle"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    productsCard.innerHTML += productCard; // إضافة المنتج إلى القسم
                });
            }

            // تحديث قسم العملاء
            function updateClients(clients) {
                clientsCard.innerHTML = ''; // مسح المحتوى الحالي

                clients.forEach(client => {
                    const clientCard = `
                        <div class="col-md-3 mr-1 p-0 mb-1">
                            <div class="card client-card align-items-center" style="border: 1px solid #ccc;box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1)">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="mb-1">
                                            <strong>${client.trade_name}</strong>
                                        </div>
                                        <div class="mr-1">
                                            <small class="text-muted"><i class="fa fa-phone mr-1"></i>${client.phone}</small>
                                        </div>
                                        <a href="#"><i class="fa fa-info-circle m-1"></i></a>
                                        <a href="#"><i class="fa fa-edit m-1"></i></a>
                                        <a href="#"><i class="fa fa-map-marker m-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    clientsCard.innerHTML += clientCard; // إضافة العميل إلى القسم
                });
            }

            searchInput.addEventListener('input',
            function () {
                productsCard.innerHTML = `
                <div class="spinner-grow" role="status">
                    <span class="sr-only">جاري البحث...</span>
                </div>`;
                clientsCard.innerHTML = `
                <div class="spinner-grow" role="status">
                    <span class="sr-only">جاري البحث...</span>
                </div>`;
            });
        });
    </script>


</body>
<!-- END: Body-->

</html>
