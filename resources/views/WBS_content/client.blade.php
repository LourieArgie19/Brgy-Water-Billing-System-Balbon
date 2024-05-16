@extends('layouts/contentNavbarLayout')

@section('title', 'Tables - Basic Tables')

@section('content')
<!-- Modal -->
<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Add Client</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="clientForm">
                    @csrf
                    <div class="row">
                        <div class="col mb-4 mt-2">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="fullname" name="fullname" class="form-control"
                                    placeholder="Enter Fullname">
                                <label for="Fullname">Fullname</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="imailname@gmail.com">
                                <label for="Emial">Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="purok" id="purok" name="purok" class="form-control"
                                    placeholder="street address">
                                <label for="Purok">Purok</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="date" id="date" name="date" class="form-control" placeholder="xxxx@xxx.xx">
                                <label for="Date">Date</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="metersnumber" id="metersnumber" name="metersnumber" class="form-control"
                                    placeholder="0000">
                                <label for="MetersNumber">Meters Number</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-4 mt-2">
                            <div class="form-floating form-floating-outline">
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="Enter Password">
                                <label for="passwordBasic">Password</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="registerclientBtn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Edit User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm">
                    @csrf
                    <input type="hidden" id="user_id" name="user_id">
                    <div class="row">
                        <div class="col mb-4 mt-2">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="updateName" name="fullname" class="form-control"
                                    placeholder="Enter Name">
                                <label for="nameBasic">Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="email" id="updateEmail" name="email" class="form-control"
                                    placeholder="name@gmail.com">
                                <label for="emailBasic">Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="purok" id="updatePurok" name="purok" class="form-control"
                                    placeholder="Purok">
                                <label for="Purok">Purok</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-4 mt-2">
                            <div class="form-floating form-floating-outline">
                                <input type="metersnumber" id="updateMetersNumber" name="metersnumber"
                                    class="form-control" placeholder="Meters Number">
                                <label for="MetersNumber">Meters Number</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="updateUserBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<h4 class="py-3 mb-4">
    List of Clients
</h4>
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
            <div class="card-header flex-column flex-md-row">
                <div class="d-flex justify-content-between mb-2">
                    <button class="dt-button create-new btn btn-primary" tabindex="0" aria-controls="DataTables_Table_0"
                        type="button" data-bs-toggle="modal" data-bs-target="#basicModal">
                        <span>
                            <i class="mdi mdi-plus me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">Add Client</span>
                        </span>
                    </button>
                    <div class="nav-item d-flex align-items-center">
                        <i class="mdi mdi-magnify mdi-24px lh-0"></i>
                        <input type="text" id="searchInput" class="form-control border-2 shadow-none mr-2"
                            placeholder="Search..." aria-label="Search...">
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="datatables-basic table table-hover dataTable no-footer dtr-column collapsed"
                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                        <thead class="table-dark">
                            <tr>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Purok</th>
                                <th>Meters Number</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <!-- Table rows will be dynamically populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/client.js') }}"></script>

<!--/ Hoverable Table rows -->

@endsection