@extends('layouts.master')
@section('title')
    قائمة الفواتير
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفواتير</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('delete_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم حذف الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif
    @if (session()->has('Archive_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم ارشفة الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif

    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session()->has('delete'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!-- row -->
    <div class="row">


        <!--/div-->

        <!--div-->

        <!--/div-->

        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    @can('اضافة فاتورة')
                        <a href="{{route('invoices.create')}}" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                                class="fas fa-plus"></i>&nbsp; اضافة فاتورة</a>

                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap">
                            <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">رقم الفاتوره</th>
                                <th class="border-bottom-0">تاريخ الفاتوره</th>
                                <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                <th class="border-bottom-0">المنتج</th>
                                <th class="border-bottom-0">القسم</th>
                                <th class="border-bottom-0">الخصم</th>
                                <th class="border-bottom-0">نسبة الضريبه</th>
                                <th class="border-bottom-0">قيمة الضريبه</th>
                                <th class="border-bottom-0">الاجمالي</th>
                                <th class="border-bottom-0">الحاله</th>
                                <th class="border-bottom-0">ملاحظات</th>
                                <th class="border-bottom-0">عمليات</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $index=0;?>
                            @foreach($invoice as $invoices)
                                <?php $index++;?>
                                <td>{{$index}}</td>
                                <td>{{$invoices->invoice_number}}</td>
                                <td>{{$invoices->invoice_Date}}</td>
                                <td>{{$invoices->Due_date}}</td>
                                <td>{{$invoices->product}}</td>
                                <td>{{$invoices->section->section_name}} </td>
                                <td>{{$invoices->Discount}}</td>
                                <td>{{$invoices->Rate_VAT}}</td>
                                <td>{{$invoices->Value_VAT}}</td>
                                <td>{{$invoices->Total}}</td>
                                <td>
                                    @if($invoices->Value_Status==1)
                                        <span class="text-success">{{$invoices->Status}}</span>
                                    @elseif($invoices->Value_Status==2)
                                        <span class="text-danger">{{$invoices->Status}}</span>
                                    @else
                                        <span class="text-warning">{{$invoices->Status}}</span>
                                    @endif
                                </td>
                                <td>{{$invoices->note}}</td>
                                {{--                                    <td>--}}

                                {{--                                        <a class="btn btn-outline-success btn-sm"--}}
                                {{--                                         href="{{url('InvoicesDetails')}}/{{$invoices->id}}"--}}
                                {{--                                           target="_blank"--}}
                                {{--                                           role="button"><i class="fas fa-eye"></i>&nbsp;--}}
                                {{--                                            عرض</a>--}}

                                {{--                                       <form action="{{url('delete/invoices')}}/{{$invoices->id}}" method="post">--}}
                                {{--                                           @csrf--}}
                                {{--                                           @method('delete')--}}
                                {{--                                           <button class="btn btn-outline-danger btn-sm"--}}
                                {{--                                                 data-target="#delete_file" style="width: 66px;margin-top: 3px;">حذف</button>--}}
                                {{--                                       </form>--}}
                                {{--                                    </td>--}}
                                <td>
                                    <div class="dropdown">
                                        <button style="    width: max-content;margin-top: 9px;" aria-expanded="false" aria-haspopup="true"
                                                class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                        <div class="dropdown-menu tx-13">
                                            @can('تفاصيل')
                                                <a href="{{url('InvoicesDetails')}}/{{$invoices->id}}"target="_blank" role="button" class="dropdown-item">
                                                    <i class="fas fa-eye"></i>&nbsp;تفاصيل</a>
                                            @endcan
                                            @can('تعديل الفاتورة')
                                                <a  class="dropdown-item"
                                                    href="{{route('invoices.edit',$invoices->id)}}">تعديل الفاتورة</a>
                                            @endcan
                                            @can('حذف الفاتورة')
                                                <a  class="dropdown-item" style="cursor: pointer"
                                                    data-toggle="modal"
                                                    data-id="{{ $invoices->id }}"
                                                    data-invoice_number="{{ $invoices->invoice_number }}"
                                                    data-target="#delete_file"> <i
                                                        class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف الفاتورة</a>
                                            @endcan
                                            @can('تغير حالة الدفع')
                                                <a class="dropdown-item"  href="{{route('status.show',$invoices->id)}}"><i  class=" text-success fas  fa-money-bill"></i>&nbsp;&nbsp;تغير
                                                    حالة
                                                    الدفع</a>

                                            @endcan
                                            @can('ارشفة الفاتورة')
                                                <a class="dropdown-item" href="#Transfer_invoice" data-invoice_id="{{$invoices->id}}" id="delete_invoice"
                                                   data-toggle="modal" data-target="#Transfer_invoice"><i
                                                        class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;نقل الي
                                                    الارشيف</a>
                                            @endcan
                                            @can('طباعةالفاتورة')
                                                <a class="dropdown-item" href="{{route('invoices.print',$invoices->id)}}"><i
                                                        class="text-success fas fa-print"></i>&nbsp;&nbsp;طباعة
                                                    الفاتورة
                                                </a>
                                            @endcan
                                        </div>
                                    </div>

                                </td>

                                </tr>


                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->

        <!--div-->

    </div>
    </div>
    <!-- row closed -->

    <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <form action="{{route('invoices.delete')}}" method="post">
                    @method('delete')
                    @csrf
                    <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                        </p>

                        <input type="hidden" name="id" id="id" value="">

                        <input type="hidden" name="invoice_number" id="invoice_number" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Archive-->

    <div class="modal fade" id="Transfer_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    @can('ارشفة الفاتورة')
                        <h5 class="modal-title" id="exampleModalLabel">ارشفة الفاتورة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    @endcan
                    <form action="{{route('invoices.destroy')}}" method="post">
                    @method('delete')
                    @csrf
                </div>
                <div class="modal-body">
                    هل انت متاكد من عملية الارشفة ؟
                    <input type="hidden" name="invoice_id"  id="invoice_id" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-success">تاكيد</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{--    end Archive--}}

    </div>
    <!-- Container closed -->

    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id= button.data('id')
            var invoice_number = button.data('invoice_number')

            var modal = $(this)

            modal.find('.modal-body #id').val(id);

            modal.find('.modal-body #invoice_number').val(invoice_number);
        })

    </script>
    <script>
        $('#Transfer_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id= button.data('invoice_id')

            var modal = $(this)

            modal.find('.modal-body #invoice_id').val(id);

        })

    </script>
@endsection
