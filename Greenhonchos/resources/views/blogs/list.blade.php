<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>blogs</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <div class="container mt-2">
        @if(session('success'))
        <div class="alert alert-success" id="success-message">
            {{session('success')}}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger" id="success-message">
            {{session('error')}}
        </div>
        @endif
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Blogs </h2>

                </div>
                <div class="pull-right mb-2">
                    <a href="{{url('logout')}}" class="edit btn btn-primary btn-sm ">logout</a><br><br>
                    <a class="btn btn-success" onClick="add()" href="javascript:void(0)"> Create Blog</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="ajax-crud-datatable">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>title</th>
                        <th>content</th>
                        <th>tags</th>
                        <th width="150px">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- boostrap company model -->
    <div class="modal fade" id="blog-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="blogModel"></h4>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" id="blogForm" name="blogForm" class="form-horizontal"
                        method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">title</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Enter title " maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label"> content</label>
                            <div class="col-sm-12">
                                <textarea type="text" class="form-control" id="content" name="content"
                                    placeholder="Enter your content" maxlength="50" required=""></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">tags</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="tags" name="tags" placeholder="Enter tag"
                                    required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">image</label>
                            <div class="col-sm-12">
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                        </div>
                        <div class="form-group image">

                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-save">Save changes
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- end bootstrap model -->
</body>
<script type="text/javascript">
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#ajax-crud-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('blogs/list') }}",
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'title',
                name: 'title',
                render: function(data, type, row, meta) {
                    return '<a href="/blogs/show/' + row.id + '">' + data + '</a>';
                }
            },
            {
                data: 'content',
                name: 'content'
            },
            {
                data: 'tags',
                name: 'tags'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false
            },
        ],
        paging: true, // Enable pagination
        pageLength: 10, // Set the number of rows to display per page
        order: [
            [0, 'asc']
        ]
    });
});

function add() {
    $('#blogForm').trigger("reset");
    $('#blogModel').html("Add Company");
    $('#blog-modal').modal('show');
    $('#id').val('');
}

$('body').on('click', '.editPost', function() {
    var id = $(this).data("id");
    $.ajax({
        type: "get",
        url: "{{ url('blogs/edit') }}" + '/' + id,
        dataType: 'json',
        success: function(res) {
            $('#blogModel').html("Edit Company");
            $('#blog-modal').modal('show');
            $('#id').val(res.id);
            $('#title').val(res.title);
            $('#content').val(res.content);
            $('#tags').val(res.tags);
        }
    });
});

$('body').on('click', '.deletePost', function() {
    if (confirm("Delete Record?") == true) {
        var id = $(this).data("id");
        // ajax
        $.ajax({
            type: "DELETE",
            url: "{{ url('blogs/delete') }}" + '/' + id,
            dataType: 'json',
            success: function(res) {
                alert(res.success);
                var oTable = $('#ajax-crud-datatable').dataTable();
                oTable.fnDraw(false);

            }
        });
    }
});
$('#blogForm').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: "{{ url('blogs/store')}}",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: (data) => {
            if (data.status == 'TXN') {
                alert(data.success);
                $("#blog-modal").modal('hide');
                var oTable = $('#ajax-crud-datatable').dataTable();
                oTable.fnDraw(false);
                $("#btn-save").html('Submit');
                $("#btn-save").attr("disabled", false);
            } else {
                console.log(data);
                alert(data.error);
            }

        },
        error: function(data) {
            console.log('l');

            console.log(data);
        }
    });
});

// Hide the success message after 5 seconds
setTimeout(function() {
    $('#success-message').fadeOut('slow');
}, 5000);

// Hide the error message after 5 seconds
setTimeout(function() {
    $('#error-message').fadeOut('slow');
}, 5000);
</script>

</html