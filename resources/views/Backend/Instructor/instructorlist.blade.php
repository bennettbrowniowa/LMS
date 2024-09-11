@extends('Backend.main')
@section('content')
    <style>
        .admin-table-2 {
            width: 100%;
            background: white;
        }
        .admin-th-1{
            padding: 8px;
            border-right: 1px solid #8a8a8a;
            background: #9f9f9f;
            color: white;
        }
        .admin-tr-1{
            /*border: 1px solid #c5c5c5;*/
        }
        .admin-td-1 {
            border-right: 1px solid #cbcbcb;
            padding: 6px;
        }
        .admin-table-1 {
            background: white;
            padding: 26px 16px;
        }
        .admin-table-inner {
            display: flex;
        }

        .admin-table-p-01 {
            padding: 5px 10px;
        }
        .admin-table-p-02 {
            font-size: 15px;
            margin-bottom: 3px;
        }
        .edit-icon-2 {
            display: flex;
            justify-content: center;
        }
        .edit-icon-1 {
            background: #e77b23;
            color: white;
            border-radius: 50px;
            font-size: 11px;
            margin: 0 2px;
            width: 30px;
            height: 30px;
            padding: 8px 10px;
        }

        .badge.badge-danger {
            background-color: #dc3545 !important;
            color: #fff !important;
        }

        .badge.badge-success {
            background-color: #28a745; /* Green color */
            color: #fff; /* White text */
        }

        /* Optional: Hover effect */
        .badge.badge-success:hover {
            background-color: #218838; /* Darker green color on hover */
            color: #fff; /* White text on hover */
        }

        .badge-info {
            color: #fff;
            background-color: #17a2b8;
        }



        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: flex-end; /* Center the pagination container */
            padding: 20px 0; /* Add some padding above and below the pagination */
        }

        .pagination li {
            display: inline-block; /* Display the pagination items inline-block for better control */
        }

        .pagination li a, .pagination li span {
            color: #e77b23; /* Color of the page numbers */
            padding: 8px 16px; /* Padding inside pagination links */
            text-decoration: none; /* Remove underline from links */
            border: 1px solid #ddd; /* Add border to the links */
            margin: 0 4px; /* Add some space between pagination links */
            background-color: #fff; /* Background color for the links */
            border-radius: 5px; /* Optional: Rounded corners for the links */
        }

        .pagination li.active span, .pagination li a:hover {
            background-color: #e77b23; /* Background color for active/hover state */
            color: white; /* Text color for active/hover state */
            border-color: #e77b23; /* Border color for active/hover state */
        }



    </style>
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Success!</strong> {{ session('success') }}
        </div>
    @endif
        <div class="box-body table-responsive">
            <table id="Datatable" class="table table-striped">
                <tbody>
                <tr class="admin-tr-1">
                    <th class="admin-th-1">SL.NO</th>
                    <th class="admin-th-1">Personal</th>
                    <th class="admin-th-1">Details</th>
                    <th class="admin-th-1">Status</th>
                    <th class="admin-th-1">Edit</th>
                </tr>
                @if(!empty($admin_list) && count($admin_list) > 0)
                    @foreach($admin_list as $key=>$admin_lists)

                        <tr class="admin-tr-1 @if(($key+1)%2==0) act @endif">
                            <td class="admin-td-1">
                                <h3 class="text-center">{{$key+1}}</h3>
                            </td>
                            <td class="admin-td-1">
                                <div class="admin-table-inner">
                                    <img src="{{$admin_lists->profile_photo['path']}}" alt="" class="admin-table-img-01" height="80px" width="80px";>
                                    <p class="admin-table-p-01">{{$admin_lists->name}}</p>
                                </div>
                                @php
                                    $date = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $admin_lists->created_at);
                                     $formattedDate = $date->format('l F j, Y H:i');
                                @endphp
                                Register On : <span class="badge badge-info" >{{$formattedDate}}</span>
                            </td>
                            <td class="admin-td-1">
                                <div class="admin-table-inner-2">
                                    <p class="admin-table-p-02"><b>Email :</b>  <span class="badge badge-danger" style="font-size: unset;">{{$admin_lists->email}}</span></p>
                                    <p class="admin-table-p-02"><b>Auth Type. :</b> <span class="badge badge-info" style="font-size: unset;">{{$admin_lists->auth_type}}</span></p>
                                </div>
                            </td>
                            <td class="admin-td-1">
                                <div class="admin-table-inner">
                                    @if($admin_lists->is_blocked=='1')
                                        <span class="badge badge-danger" style="font-size: unset;">InActive</span>||
                                    @else
                                        <span class="badge badge-success" style="font-size: unset;">Active</span>||
                                    @endif
                                    @if($admin_lists->is_profile_completed=='0')
                                        <span class="badge badge-danger" style="font-size: unset;">Profile Incomplete</span>||
                                    @else
                                        <span class="badge badge-success" style="font-size: unset;">Profile Complete</span>||
                                    @endif
                                    @if($admin_lists->is_verified=='0')
                                        <span class="badge badge-danger" style="font-size: unset;">Not Verified</span>
                                    @else
                                        <span class="badge badge-success" style="font-size: unset;">Verified</span>
                                    @endif
                                </div>
                            </td>

                            <td class="admin-td-1">
                                <div class="edit-icon-2">

                                    <a onclick="return confirm('Are you sure you want to delete This Account?')" href="{{route('instructor_remove',$admin_lists->id)}}">
                                        <div class="edit-icon-1">
                                            <i class="fa fa-trash-o"></i>
                                        </div>
                                    </a>
                                    <a href="{{route('instructor_details',$admin_lists->id)}}">
                                        <div class="edit-icon-1">
                                            <i class="fa fa-eye"></i>
                                        </div>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                         <td colspan="5" style="text-align: center">No data found.</td>
                    </tr>
                @endif


                </tbody>
            </table>


                {{ $admin_list->links() }}




        </div>

        </section>

    </div>



    @endsection
