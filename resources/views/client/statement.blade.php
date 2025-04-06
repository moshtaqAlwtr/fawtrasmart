@extends('master')

@section('title')
   كشف حساب عميل
@stop

@section('content')
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex gap-2">
                        <strong>د }}</strong>
                        <span> }}</span>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-success d-inline-flex align-items-center print-button">
                            <i class="fas fa-print me-1"></i> طباعة 
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex gap-2">
                        <!-- تعديل -->
                      
                        <!-- طباعة -->
                        <a href="#" class="btn btn-sm btn-outline-success d-inline-flex align-items-center print-button">
                            <i class="fas fa-print me-1"></i> طباعة
                        </a>

                        <!-- PDF -->
                        <a href=""
                            class="btn btn-sm btn-outline-info d-inline-flex align-items-center">
                            <i class="fas fa-file-pdf me-1"></i> PDF
                        </a>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <ul class="nav nav-tabs" role="tablist">
                           
                            <li class="nav-item">
                                <a class="nav-link" id="entry-details-tab" data-toggle="tab" href="#entry-details"
                                    role="tab" aria-controls="entry-details" aria-selected="false">تفاصيل القيد</a>
                            </li>
                           
                        </ul>

                        <div class="tab-content mt-3">
                            <!-- القيد -->
                            <div class="tab-pane fade show active" id="entry" role="tabpanel" aria-labelledby="entry-tab">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="tab-pane fade show active"
                                            style="background: lightslategray; min-height: 100vh; padding: 20px;">
                                            <div class="card shadow" style="max-width: 600px; margin: 20px auto;">
                                                <div class="card-body bg-white p-4"
                                                    style="min-height: 400px; overflow: auto;">
                                                    <div style="transform: scale(0.8); transform-origin: top center;">
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- تفاصيل القيد -->
                            <div class="tab-pane fade" id="entry-details" role="tabpanel" aria-labelledby="entry-details-tab">
                                <div class="pdf-view" style="background: lightslategray; min-height: 100vh; padding: 20px;">
                                    
                                    <div class="card shadow" style="max-width: 600px; margin: 20px auto;">
                                        <div class="card-body bg-white p-4">
                                            <div style="transform: scale(0.8); transform-origin: top center;">
                                                <!-- PDF Content -->
                                                <div dir="rtl" style="font-family: 'Cairo', sans-serif;">
                                                    <div style="text-align: center; margin-bottom: 20px;">
                                                        <h2 style="margin: 0;">كشف حساب </h2>
                                                    </div>

                                                    <div style="margin-bottom: 20px;">
                                                        <p style="margin: 5px 0;">{{ $client->trade_name ?? ""}}</p>
                                                        <p style="margin: 5px 0;">{{ $client->region ?? "" }}</p>
                                                         <p style="margin: 5px 0;">{{ $client->phone ?? "" }}</p>
                                                    </div>
                                                    <table style="width: 100%; border-collapse: collapse;">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="2" style="border: 1px solid #000; padding: 8px; text-align: right;">مختصر الحساب حتى</th>
                                                                <th style="border: 1px solid #000; padding: 8px; text-align: right;">الرصيد الافتتاحي</th>
                                                                <th style="border: 1px solid #000; padding: 8px; text-align: right;">الإجمالي</th>
                                                                <th style="border: 1px solid #000; padding: 8px; text-align: right;">المدفوع حتى تاريخه</th>
                                                                <th style="border: 1px solid #000; padding: 8px; text-align: right;"> المبلغ المستحق </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                           
                                                            <tr>
                                                                <td style="border: 1px solid #000; padding: 8px;"></td>
                                                                <td style="border: 1px solid #000; padding: 8px;"></td>
                                                                <td style="border: 1px solid #000; padding: 8px;"></td>
                                                                   
                                                                
                                                                
                                                                <td style="border: 1px solid #000; padding: 8px;"></td>
                                                            </tr>
                                                        
                                                          
                                                           
                                                        </tbody>
                                                    </table>
                                                </br>
                                            </br>
                                                    <table style="width: 100%; border-collapse: collapse;">
                                                        <thead>
                                                            <tr>
                                                                <th style="border: 1px solid #000; padding: 8px; text-align: right;">التاريخ</th>
                                                                <th style="border: 1px solid #000; padding: 8px; text-align: right;">العملية</th>
                                                                <th style="border: 1px solid #000; padding: 8px; text-align: right;">المبلغ</th>
                                                                <th style="border: 1px solid #000; padding: 8px; text-align: right;">الرصيد</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($operationsPaginator as $operation)
                                                            <tr>
                                                                <td style="border: 1px solid #000; padding: 8px;">{{ \Carbon\Carbon::parse($operation['date'])->format('Y-m-d') }}</td>
                                                                <td style="border: 1px solid #000; padding: 8px;">{{$operation['operation']}}</td>
                                                                <td style="border: 1px solid #000; padding: 8px;">
                                                                    @if($operation['deposit'])
                                                                        {{ $operation['deposit'], 2 }}
                                                                    @elseif($operation['withdraw'])
                                                                        -{{ $operation['withdraw'], 2 }}
                                                                    @else
                                                                        0
                                                                    @endif
                                                                </td>
                                                                
                                                                <td style="border: 1px solid #000; padding: 8px;">{{ number_format($operation['balance_after'], 2) }}</td>
                                                            </tr>
                                                            @endforeach
                                                            <tr style="font-weight: bold;">
                                                                <td colspan="3" style="border: 1px solid #000; padding: 8px;">المبلغ المستحق</td>
                                                               
                                                                <td style="border: 1px solid #000; padding: 8px;">{{$account->balance ?? 0}} ر.س</td>
                                                            </tr>
                                                           
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <!-- سجل النشاطات -->
                            <div class="tab-pane fade" id="activity-log" role="tabpanel" aria-labelledby="activity-log-tab">
                                <div class="activity-log">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        $(document).ready(function() {
            $('.print-button').click(function() {
                window.print();
            });
        });
    </script>
@endsection
