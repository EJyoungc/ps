<div>


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        {{-- <li class="breadcrumb-item active">None</li> --}}
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Default box -->
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="card card-primary">
                        <div class="card-body">
                            <h4>Users</h4>
                            <p class="card-text">
                                <span class="badge badge-light"></span>
                            </p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card card-success">
                        <div class="card-body">
                            <h4>Suppliers</h4>
                            <p class="card-text">
                                <span class="badge badge-light"></span>
                                <button wire:click.prevent="assign" class="btn btn-primary"> assign <x-spinner for="assign" /></button>
                            </p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card card-success">
                        <div class="card-body">
                            <h4>Suppliers</h4>
                            <p class="card-text">
                                <span class="badge badge-light"></span>
                            </p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

            </div>


        </div>



    </section>





</div>
