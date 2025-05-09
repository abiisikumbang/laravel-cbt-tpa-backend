@extends('layouts.app')


@section('title', 'Detail User')


@section('main')

    <section class="section">

            <h1>Detail User</h1>

            <div class="section-header-breadcrumb">

                <div class="breadcrumb-item active"><a href="{{ route('users.index') }}">Users</a></div>

                <div class="breadcrumb-item">Detail User</div>

            </div>

        </div>


        <div class="main-content">

          <section class="section">

            <div class="row">

                <div class="col-md-4">

                    <div class="card">

                        <div class="card-header">

                            <h4>Informasi User</h4>

                        </div>

                        <div class="card-body">

                            <table class="table table-striped">

                                <tr>

                                    <th>Nama</th>

                                    <td>{{ $user->name }}</td>

                                </tr>

                                <tr>

                                    <th>Email</th>

                                    <td>{{ $user->email }}</td>

                                </tr>

                                <tr>

                                    <th>Telepon</th>

                                    <td>{{ $user->phone }}</td>

                                </tr>

                                <tr>

                                    <th>Roles</th>

                                    <td>{{ $user->roles }}</td>

                                </tr>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

            </section>

        </div>

    </section>

@endsection
