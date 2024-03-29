@extends('dashboard.vendor.layouts.app')

@section('content')
<style>
    .skeleton-container {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
  
    .skeleton-table {
      width: 100%;
      border-collapse: collapse;
    }
  
    .skeleton-table th,
    .skeleton-table td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
  
    .skeleton-item {
      background-color: #f0f0f0;
      border-radius: 5px;
      overflow: hidden;
      position: relative;
    }
  
    .skeleton-item::before {
      content: "";
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
      animation: loading 1.5s infinite;
    }
  
    @keyframes loading {
      0% {
        left: -100%;
      }
      100% {
        left: 100%;
      }
    }
  
    .skeleton-content {
      padding: 20px;
    }
  
    .skeleton-line {
      height: 12px;
      margin-bottom: 10px;
      background-color: #ddd;
      border-radius: 5px;
    }
  </style>
<div class="row justify-content-center">
    <div class="col-12">
        <h2 class="mb-2 page-title">Blogs</h2>
        <p class="card-text">Blogs table</p>
        <div class="row my-4">
            <!-- data table -->
            <div class="col-md-12">
                <a href="{{ route('vendor.blogs.create') }}" class="btn btn-primary mb-2">Add New Blog</a>
                <div class="card shadow">
                    <div class="card-body skeleton-container">
                        <!-- table -->
                        <table class="skeleton-table table table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Sr#</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="user-table-body">
                                @for ($i = 1; $i <= 10; $i++)
                                    <tr>
                                        <td class="skeleton-item"><div class="skeleton-content"><div class="skeleton-line" style="width: 100%;"></div></div></td>
                                        <td class="skeleton-item"><div class="skeleton-content"><div class="skeleton-line" style="width: 100%;"></div></div></td>
                                        <td class="skeleton-item"><div class="skeleton-content"><div class="skeleton-line" style="width: 100%;"></div></div></td>
                                        <td class="skeleton-item"><div class="skeleton-content"><div class="skeleton-line" style="width: 100%;"></div></div></td>
                                        <td class="skeleton-item"><div class="skeleton-content"><div class="skeleton-line" style="width: 100%;"></div></div></td>
                                        <td class="skeleton-item"><div class="skeleton-content"><div class="skeleton-line" style="width: 100%;"></div></div></td>
                                        <td class="skeleton-item"><div class="skeleton-content"><div class="skeleton-line" style="width: 100%;"></div></div></td>
                                        <td class="skeleton-item"><div class="skeleton-content"><div class="skeleton-line" style="width: 100%;"></div></div></td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                        <nav aria-label="Table Paging" class="mb-0 text-muted">
                            <ul class="pagination justify-content-center mb-0" id="user-pagination">
                                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div> <!-- data table -->
        </div> <!-- end section -->
    </div> <!-- .col-12 -->
</div>

@endsection
@section('bottom_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.js"></script>
<script>
    var search = null;
    $("input").keyup(function() {
        search = $(this).val();
        fetchDataOnReady();
    });
    $(document).ready(function() {
        fetchDataOnReady();
    });

    function fetchDataOnClick(page) {
        console.log(page);
        $.ajax({
            url: "{{ route('vendor.blogs.index') }}",
            type: "GET",
            data: {
                type: 'ajax',
                page: page
            },
            success: function(response) {
                console.log("Data fetched successfully on click:", response);
                generateTableRows(response.data);
                generatePagination(response);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data on click:", error);
            }
        });
    }

    function fetchDataOnReady() {
        $.ajax({
            url: "{{ route('vendor.blogs.index') }}",
            type: "GET",
            data: {
                type: 'ajax',
                search: search
            },
            success: function(response) {
                console.log("Data fetched successfully on document ready:", response);
                $('#user-table-body').empty();
                generateTableRows(response.data);
                generatePagination(response);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data on document ready:", error);
            }
        });
    }

    function generateTableRows(response) {
        var html = '';
        const currentUrl = window.location.href;
        let i = 1;
        $.each(response, function(index, row) {
            html += '<tr>';
            html += '<td></td>';
            html += '<td>' + i + '</td>';
            html += '<td>' + row.title + '</td>';
            html += '<td>' + row.user.first_name + ' '+ row.user.last_name +'</td>';
            html += '<td>' + row.category.title + '</td>';
            html += '<td>';
            html += row.status == 1 ? '<span class="badge bg-success">Acrive</span>' : '<span class="badge bg-danger">InActive</span>';
            html += '</td>';
            html += '<td class="text-center">' + moment(row.created_at).format('DD/MM/YYYY hh:mm:ss') + '</td>';
            html += '<td>';
            html +=
                '  <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            html += '<span class="text-muted sr-only">Action</span>';
            html += '</button>';
            html += '<div class="dropdown-menu dropdown-menu-right shadow">';
            html += '<a class="dropdown-item" href="' + currentUrl + '/' + row.id +
                '/edit"><i class="fe fe-edit-2 fe-12 mr-3 text-muted"></i>Edit</a>';
            // html += '<a class="dropdown-item" href="#"><i class="fe fe-trash fe-12 mr-3 text-muted"></i>Remove</a>';
            // html += '<a class="dropdown-item" href="#"><i class="fe fe-flag fe-12 mr-3 text-muted"></i>Assign</a>';
            html += '</div></td>';
            html += '</tr>';
            i++;
        });
        $('#user-table-body').html(html);
    }
    pre = 0;
    nxt = 0;

    function generatePagination(response) {
        var html = '';
        if (response.prev_page_url) {
            pre = response.current_page - 1;
            html += '<li class="page-item"><a onclick="fetchDataOnClick(\'' + pre +
                '\')" href="javascript:void(0);" class="page-link" >Previous</a></li>';
        }
        for (var i = 1; i <= response.last_page; i++) {
            html += '<li class="page-item ' + (i == response.current_page ? 'active' : '') +
                '"><a class="page-link pg-btn" onclick="fetchDataOnClick(\'' + i + '\')" data-attr="page=' + i +
                '" href="javascript:void(0);">' + i + '</a></li>';
        }
        if (response.next_page_url) {
            nxt = response.current_page + 1;
            html += '<li class="page-item"><a class="page-link" onclick="fetchDataOnClick(\'' + nxt +
                '\')" href="javascript:void(0);">Next</a></li>';
        }
        $('#user-pagination').html(html);
    }
</script>
@endsection
