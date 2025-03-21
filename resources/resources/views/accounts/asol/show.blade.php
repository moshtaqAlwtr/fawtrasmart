@extends('master')

@section('title')
    عرض تفاصيل الأصل
@stop

@section('content')
    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if(session('success_message'))
                            <div class="alert alert-success">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <strong>{{ session('success_message') }}</strong>
                                </div>
                                @if(session('success_details'))
                                    <div class="mt-2">
                                        @foreach(session('success_details') as $label => $value)
                                            <div>{{ $label }}: {{ $value }}</div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center mb-3">
                                    <h4 class="mb-0">{{ $asset->name }}</h4>
                                    <span class="badge rounded-pill bg-{{ $asset->status == 2 ? 'success' : ($asset->status == 3 ? 'warning' : 'info') }} ms-2">
                                        @if($asset->status == 2)
                                            تم البيع
                                        @elseif($asset->status == 3)
                                            مهلك
                                        @else
                                            في الخدمة
                                        @endif
                                    </span>
                                </div>

                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <p class="mb-0">
                                            <strong>حساب الأستاذ:</strong>
                                            <span>{{ $asset->account ? $asset->account->name : '' }} #{{ $asset->account ? $asset->account->id : '' }}</span>
                                        </p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="mb-0">
                                            <strong>مجمع إهلاك:</strong>
                                            <span>{{ $asset->depreciation_account ? $asset->depreciation_account->name : '' }} #{{ $asset->depreciation_account ? $asset->depreciation_account->id : '' }}</span>
                                        </p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="mb-0">
                                            <strong>مصروف إهلاك:</strong>
                                            <span>{{ $asset->expense_account ? $asset->expense_account->name : '' }} #{{ $asset->expense_account ? $asset->expense_account->id : '' }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 text-end">
                                <div class="btn-group">
                                    @if($asset->status != 2)
                                    <a href="{{ route('Assets.showSell', $asset->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-dollar-sign"></i> بيع الأصل
                                    </a>
                                    @endif
                                    <a href="{{ route('Assets.generatePdf', $asset->id) }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-file-pdf"></i> PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex gap-2">
                                    <!-- تفاصيل الأصل -->
                                    <ul>
                                        <!-- تعديل -->
                                        <a href="{{ route('Assets.edit', $asset->id) }}"
                                            class="btn btn-sm d-inline-flex align-items-center"
                                            style="border: 2px solid #007bff; color: #007bff;">
                                            <i class="fas fa-edit me-1"></i> تعديل
                                        </a>

                                        <!-- طباعة -->
                                        <a href="#" class="btn btn-sm d-inline-flex align-items-center"
                                            style="border: 2px solid #6c757d; color: #6c757d;">
                                            <i class="fas fa-print me-1"></i> طباعة
                                        </a>

                                        <!-- PDF -->
                                        <a href="{{ route('assets.generatePdf', $asset->id) }}"
                                            class="btn btn-sm d-inline-flex align-items-center"
                                            style="border: 2px solid #dc3545; color: #dc3545;">
                                            <i class="fas fa-file-pdf me-1"></i> PDF
                                        </a>

                                        <!-- إضافة ملاحظة/مرفق -->
                                        <a href="{{ route('appointment.notes.create', ['id' => $asset->id]) }}"
                                            class="btn btn-sm d-inline-flex align-items-center"
                                            style="border: 2px solid #ffc107; color: #ffc107;">
                                            <i class="fas fa-paperclip me-1"></i> اضافة ملاحظة/مرفق
                                        </a>

                                        <!-- حذف -->
                                        <a href="" class="btn btn-sm d-inline-flex align-items-center"
                                            style="border: 2px solid #dc3545; color: #dc3545;">
                                            <i class="fas fa-trash-alt me-1"></i> حذف
                                        </a>

                                        <!-- اعادة تقييم -->
                                        <a href="" class="btn btn-sm d-inline-flex align-items-center"
                                            style="border: 2px solid #17a2b8; color: #17a2b8;">
                                            <i class="fas fa-redo-alt me-1"></i> اعادة تقييم
                                        </a>

                                        @if($asset->status != 2)
                                        <!-- بيع -->
                                        <a href="{{ route('Assets.showSell', $asset->id) }}" class="btn btn-sm d-inline-flex align-items-center"
                                            style="border: 2px solid #28a745; color: #28a745;">
                                            <i class="fas fa-dollar-sign me-1"></i> بيع
                                        </a>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs mt-3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab"
                                            aria-controls="details" aria-selected="true">معلومات </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="journal-entries-tab" data-toggle="tab" href="#journal-entries"
                                            role="tab" aria-controls="journal-entries" aria-selected="false">الحركات
                                            </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="activity-log-tab" data-toggle="tab" href="#activity-log"
                                            role="tab" aria-controls="activity-log" aria-selected="false">سجل النشاطات</a>
                                    </li>
                                </ul>

                                <div class="tab-content mt-3">
                                    <!-- تفاصيل الأصل -->
                                    <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="tab-pane fade show active" style="background: lightslategray; min-height: 100vh; padding: 20px;">
                                                    <div class="card shadow" style="max-width: 600px; margin: 20px auto;">
                                                        <div class="card-body bg-white p-4" style="min-height: 400px; overflow: auto;">
                                                            <div style="transform: scale(0.8); transform-origin: top center;">
                                                                @include('Accounts.asol.pdf', ['asset' => $asset])
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- الحركات -->
                                    <div class="tab-pane fade" id="journal-entries" role="tabpanel"
                                        aria-labelledby="journal-entries-tab">
                                        <div class="card">
                                            <div class="card-body">
                                                <!-- Header Controls -->
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <button class="btn btn-light btn-sm"><i class="fas fa-chevron-right"></i></button>
                                                        <button class="btn btn-light btn-sm"><i class="fas fa-chevron-left"></i></button>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="input-group">
                                                            <input type="date" class="form-control form-control-sm" placeholder="من">
                                                            <span class="input-group-text">إلى</span>
                                                            <input type="date" class="form-control form-control-sm" placeholder="إلى">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Total Debit -->
                                                <div class="d-flex align-items-center mb-3">
                                                    <span class="badge bg-primary">ALL {{ number_format($journalEntries->sum('debit'), 0) }}</span>
                                                    <span class="me-2 text-muted">مدين</span>
                                                </div>

                                                <!-- Previous Balance -->
                                                <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-light rounded">
                                                    <span class="text-muted">الرصيد قبل</span>
                                                    <span class="fw-bold">{{ number_format(0, 2) }} ر.س</span>
                                                </div>

                                                @if ($journalEntries->count() > 0)
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover">
                                                            <thead class="bg-light">
                                                                <tr>
                                                                    <th class="text-end">العملية</th>
                                                                    <th class="text-center">مدين</th>
                                                                    <th class="text-center">دائن</th>
                                                                    <th class="text-center">الرصيد بعد</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php $balance = 0; @endphp
                                                                @foreach ($journalEntries as $entry)
                                                                    @foreach ($entry->details as $detail)
                                                                        @php
                                                                            $balance += $detail->debit - $detail->credit;
                                                                        @endphp
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex flex-column">
                                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                                        <div>
                                                                                            <span class="text-primary">{{ $entry->description }}</span>
                                                                                            <a href="#" class="text-muted ms-2"><i class="fas fa-pencil-alt"></i></a>
                                                                                        </div>
                                                                                        <small class="text-muted">
                                                                                            <i class="fas fa-user-circle me-1"></i>
                                                                                            (#{{ $entry->id }}) {{ $entry->date }}
                                                                                        </small>
                                                                                    </div>
                                                                                    @if($entry->branch)
                                                                                        <small class="text-muted">{{ $entry->branch->name }} <i class="fas fa-building"></i></small>
                                                                                    @endif
                                                                                </div>
                                                                            </td>
                                                                            <td class="text-center {{ $detail->debit > 0 ? 'text-success' : '' }}">
                                                                                {{ $detail->debit > 0 ? number_format($detail->debit, 2) : '-' }}
                                                                            </td>
                                                                            <td class="text-center {{ $detail->credit > 0 ? 'text-danger' : '' }}">
                                                                                {{ $detail->credit > 0 ? number_format($detail->credit, 2) : '-' }}
                                                                            </td>
                                                                            <td class="text-center fw-bold">{{ number_format($balance, 2) }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <div class="alert alert-info">
                                                        لا توجد حركات لهذا الأصل
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>



                                    <!-- سجل النشاطات -->
                                    <div class="tab-pane fade" id="activity-log" role="tabpanel" aria-labelledby="activity-log-tab">
                                        <div class="bg-light p-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <button class="btn btn-primary btn-sm px-3">اليوم</button>
                                            </div>
                                        </div>

                                        <div class="activity-list p-3">
                                            @if($asset->created_at)
                                                <div class="activity-item bg-white p-3 rounded mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <div class="activity-icon bg-success rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                            <i class="fas fa-plus text-white" style="font-size: 12px;"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div class="activity-text">
                                                                    <span>
                                                                        {{ $asset->created_by ? $asset->created_by->name : 'النظام' }}
                                                                        أضاف أصل جديد # {{ $asset->id }}
                                                                        تحت حساب {{ $asset->account ? $asset->account->name : '' }}،
                                                                        سعر الشراء {{ number_format($asset->purchase_price, 2) }} {{ $asset->currency }}
                                                                        @if($asset->source_account)
                                                                            من حساب {{ $asset->source_account->name }}،
                                                                        @endif
                                                                        القيمة الحالية {{ number_format($asset->current_value, 2) }} {{ $asset->currency }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="activity-meta mt-1">
                                                                <small class="text-muted">
                                                                    <i class="fas fa-user-circle me-1"></i>
                                                                    {{ $asset->created_by ? $asset->created_by->name : 'النظام' }} -
                                                                </small>
                                                                <small class="text-muted">
                                                                    <i class="fas fa-building me-1"></i>
                                                                    {{ $asset->branch ? $asset->branch->name : 'الفرع الرئيسي' }} -
                                                                </small>
                                                                <small class="text-muted">{{ $asset->created_at->format('H:i:s') }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($asset->updated_at && $asset->updated_at != $asset->created_at)
                                                <div class="activity-item bg-white p-3 rounded mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <div class="activity-icon bg-info rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                            <i class="fas fa-edit text-white" style="font-size: 12px;"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div class="activity-text">
                                                                    <span>
                                                                        {{ $asset->updated_by ? $asset->updated_by->name : 'النظام' }}
                                                                        قام بتحديث الأصل # {{ $asset->id }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="activity-meta mt-1">
                                                                <small class="text-muted">
                                                                    <i class="fas fa-user-circle me-1"></i>
                                                                    {{ $asset->updated_by ? $asset->updated_by->name : 'النظام' }} -
                                                                </small>
                                                                <small class="text-muted">
                                                                    <i class="fas fa-building me-1"></i>
                                                                    {{ $asset->branch ? $asset->branch->name : 'الفرع الرئيسي' }} -
                                                                </small>
                                                                <small class="text-muted">{{ $asset->updated_at->format('H:i:s') }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-lighten-5">
                        <h6 class="text-dark mb-0">المرفقات</h6>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <!-- الصورة -->
                            <div class="col-md-4 text-end">
                                <img src="{{ asset('storage/' . $asset->attachments) }}" alt="مرفق"
                                     class="img-thumbnail" style="max-height: 150px; max-width: 100%;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal بيع الأصل -->

@endsection

@section('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('assets/js/applmintion.js') }}"></script>
@endsection
