@extends('admins.layouts.master')
@section('css')
    <!-- FILE UPLOADE CSS -->
    <link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>

    <!-- SELECT2 CSS -->
    <link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet"/>
    <style>
        .search {
            width: 100%;
            position: relative;
        }

        .search-result {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 9;
            width: 100%;
            background: #ccc;
        }

        tr.row-search:hover {
            background: #efa0b8;
        }

        tr.row-search {
            cursor: pointer;
        }
    </style>
@endsection
@section('page-header')
    <div class="search">
        <input type="text" name="search" class="form-control" id="add_medicine"
               placeholder="Nhập tên thuốc muốn thêm vào danh sách nhập....">
        <div class="search-result"></div>
    </div>
@endsection
@section('content')

    <!-- ROW-1 -->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <form action="{{route('admin.import_medicine.postAdd')}}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <div class="col-6 p-0">
                                <h3 class="mb-0 card-title">Danh sách thuốc cần nhập</h3>
                            </div>
                            <div class="col-6 p-0">
                                <div class="btn-list text-right">
                                    <button type="button" class="btn btn-outline-default" data-toggle="tooltip"
                                            title="Quay về trang danh sách thuốc">
                                        <a href="{{route('admin.import_medicine.getIndex')}}" style="color: inherit;"><i
                                                class="icon icon-action-undo mr-2"></i>Quay lại</a>
                                    </button>
                                    <button type="submit" class="btn btn-primary"
                                            id="add_continue"><i
                                            class="ti-save-alt mr-2"></i>Lưu
                                    </button>
                                </div>
                            </div>

                        </div>

                        <div class="card-body">

                            <div class="row">
                                <table id="import_datatable" class="table card-table table-vcenter text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>Tên thuốc</th>
                                        <th>Số lượng</th>
                                        <th>đơn vị tính</th>
                                        <th>Ghi chú</th>
                                        <th>Xóa</th>
                                    </tr>
                                    </thead>
                                    <tbody class="list_medicine">
                                    @foreach($medicines as $medicine)
                                        <tr class="row-medicine">
                                            <th>{{$medicine->name}}<input type="number" name="medicine_id[]"
                                                                          value="{{$medicine->id}}" hidden></th>
                                            <th>
                                                <input type="number" class="form-control"
                                                       name="amounts[]"
                                                       value=1>
                                            </th>
                                            <th>
                                                <select name="units[]"
                                                        class="form-control select2 custom-select"
                                                        data-placeholder="Chọn đơn vị tính">
                                                    <option label="Chọn đơn vị tính"></option>
                                                    @if(count($units = $medicine->units)>0)
                                                        @foreach($units as $unit)
                                                            <option value="{{$unit->id}}">{{$unit->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </th>
                                            <th>
                                                <textarea class="form-control" name="notes[]"
                                                          rows="1"></textarea>
                                            </th>
                                            <th>
                                                <div class="btn-list">
                                                    <button type="button" class="btn btn-icon remove_medicine btn-red"><i class="ti-close"></i></button>
                                                </div>
                                            </th>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <button type="submit" name="save_continue" hidden></button>
                            <button type="submit" name="save_close" hidden></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- ROW-1 CLOSED -->

@endsection

@section('js')
    <!-- FORMELEMENTS JS -->
    <script src="{{ URL::asset('assets/js/form-elements.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/date-picker/spectrum.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/time-picker/jquery.timepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/time-picker/toggles.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#add_medicine").keyup(function () {
                let keyword = $(this).val();
                if (keyword === "") {
                    $(".search-result").hide();
                } else {
                    $.ajax({
                        url: "{{route("admin.import_medicine.ajaxSearchMedicine")}}",
                        method: "get",
                        data: {
                            keyword: keyword
                        },
                        success: function (result) {
                            $(".search-result").html(result);
                            $(".search-result").show();
                        }
                    })
                }

            });
            $("body").on('click', ".row-search", function () {
                let medicine_id = $(this).data("medicine_id");
                let selected = $(this).data("selected");
                let that = $(this);
                if(selected ===0){
                    $.ajax({
                        url: "{{route("admin.import_medicine.ajaxAddImportMedicine")}}",
                        method: "get",
                        data: {
                            id: medicine_id
                        },
                        success: function (result) {
                            $(".list_medicine").before(result);
                            that.data("selected",1);
                        }
                    });
                }
            });
            $("body").on('click', ".remove_medicine", function () {
               $(this).parents(".row-medicine").remove()
            });
        })
    </script>
@endsection
