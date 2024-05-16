@extends('layouts/contentNavbarLayout')

@section('title', 'Tables - Basic Tables')

@section('content')
<!-- Modal -->
<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Add User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registerForm">
                    @csrf
                    <div class="row">
                        <div class="col mb-4 mt-2">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="nameBasic" name="name" class="form-control"
                                    placeholder="Enter Name">
                                <label for="nameBasic">Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-4">
                            <div class="form-floating form-floating-outline">
                                <input type="email" id="emailBasic" name="email" class="form-control"
                                    placeholder="xxxx@xxx.xx">
                                <label for="emailBasic">Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-2 form-floating form-floating-outline">
                            <select class="form-select" id="usertype" name="usertype"
                                aria-label="Default select example">
                                <option selected> </option>
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
                            <label for="role">Role</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-4 mt-2">
                            <div class="form-floating form-floating-outline">
                                <input type="password" id="passwordBasic" name="password" class="form-control"
                                    placeholder="Enter Password">
                                <label for="passwordBasic">Password</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="registerUserBtn">Save</button>
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
                                <input type="text" id="updateName" name="name" class="form-control"
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
                        <div class="col mb-2 form-floating form-floating-outline">
                            <select class="form-select" id="updateRole" name="usertype"
                                aria-label="Default select example">
                                <option value="Admin">Admin</option>
                                <option value="Staff">Staff</option>
                            </select>
                            <label for="updateRole">Role</label>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col mb-4 mt-2">
                            <div class="form-floating form-floating-outline">
                                <input type="password" id="updatePassword" name="password" class="form-control"
                                    placeholder="Enter Password">
                                <label for="passwordBasic">Password</label>
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
    List of User
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
                            <span class="d-none d-sm-inline-block">Add User</span>
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
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

<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/register.js') }}"></script>

<!--/ Hoverable Table rows -->

@endsection