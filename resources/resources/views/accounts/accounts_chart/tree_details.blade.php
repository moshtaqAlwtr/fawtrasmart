
  

   
    <div class="card">
        <div class="card-body p-0">
           
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>العملية</th>
                            <th>مدين</th>

                            <th>دائن</th>
                       

                            <th>الرصيد بعد</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($journalEntries as $entry)
                            <tr>
                                <!-- القسم الأيمن - رقم القيد والمبلغ -->


                                <td>    {{$entry->description ?? ""}}  قيد رقم #{{$entry->journal_entry_id}}   </td>
                                
                                <td>    {{$entry->debit ?? ""}} </td>
                                <td>    {{$entry->credit ?? ""}} </td>
                                <td>    {{$entry->account->balance ?? ""}} </td>

                        
                                <!-- الإجراءات -->
                                <td>
                                    <div class="btn-group">
                                        <div class="dropdown">
                                            <button class="btn bg-gradient-info fa fa-ellipsis-v mr-1 mb-1" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ route('journal.edit', $entry->journalEntry->id) }}">
                                                    <i class="fa fa-edit me-2 text-success"></i>تعديل
                                                </a>
                                                <a class="dropdown-item" href="{{ route('journal.show', $entry->journalEntry->id) }}">
                                                    <i class="fa fa-eye me-2 text-primary"></i>عرض
                                                </a>
                                                <form action="{{ route('journal.destroy', $entry->journalEntry->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fa fa-trash me-2"></i>حذف
                                                    </button>
                                                </form>

                                                <a class="dropdown-item" href="">
                                                    <i class="fa fa-edit me-2 text-success"></i>عرض  المصدر
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
           
         
        </div>
    </div>


