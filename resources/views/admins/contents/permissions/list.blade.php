@extends('admins.layouts.master')
@section('page-header')
    <!-- PAGE-HEADER -->
    <div class="btn-list">
        <a class="mr-2" href="{{route('admin.permission.getAdd')}}" style="color: inherit;">
            <button type="button" class="btn btn-outline-secondary">
                <i class="fe fe-plus"></i>Tạo mới
            </button>
        </a>
    </div>
    <!-- PAGE-HEADER END -->
@endsection
@section('content')
    <!-- ROW-1 -->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-6 p-0">
                        <h3 class="mb-0 card-title">Danh sách Quyền</h3>
                    </div>
                    <div class="col-6 p-0">
                        <div class="btn-list text-right">
                            <div class="btn-group mt-2 mb-2">
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                    <i class="fe fe-calendar mr-2"></i>Hành động
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" id="delete_selected" href="#">Xóa tất cả</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="medicine_datatable" class="table card-table table-vcenter text-nowrap">
                            <thead>
                            <tr>
                                <th scope="row">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="select_all_row">
                                        <span class="custom-control-label"></span>
                                    </label>
                                </th>
                                <th>ID</th>
                                <th>Tên quyền</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- table-responsive -->
            </div>
        </div>
    </div>
    <!-- ROW-1 CLOSED -->
@endsection
@section('js')
    <script>
        $('body').ready(function () {
            //Selected all checkbox
            $('input[name=select_all_row]').click(function () {
                let status = $(this).is(":checked");
                if (status) {
                    $('.select_row').prop("checked", true);
                } else {
                    $('.select_row').prop("checked", false);
                }
            });
            //delete multil
            $('#delete_selected').click(function () {
                // let selected = $('.select_row').is('checked');
                let checkboxValues = [];
                $('input[name=select_row]:checked').each(function () {
                    checkboxValues.push($(this).val());
                });
                let ids = checkboxValues;

                if (!jQuery.isEmptyObject(ids)) {
                    Swal.fire({
                        title: 'Bạn có muốn xóa không?',
                        type: 'warning',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Xóa'
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "{{route('admin.permission.getDeleteMultil')}}",
                                method: 'get',
                                data: {
                                    ids: ids
                                },
                                success: function (data) {
                                    if (data.status) {
                                        swal.fire({
                                            title: data.message,
                                            type: "success",
                                            icon: 'success',
                                            timer: 1500
                                        }).then(function () {
                                            location.reload();
                                        });
                                    } else {
                                        swal.fire({
                                            title: 'Lỗi...',
                                            type: 'error',
                                            timer: '1500'
                                        })
                                    }
                                }
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'Bạn chưa chọn bane ghi nào !!!',
                    })
                }
            });
            //Datatable
            $('#medicine_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.permission.data') }}',
                columns: [
                    {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                ],

            });
        });
    </script>
@endsection
