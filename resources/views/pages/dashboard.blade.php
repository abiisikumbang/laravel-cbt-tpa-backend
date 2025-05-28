@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">

            <div class="section-header">
                <div class="vertical">
                    <h1>Dashboard</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="home">Dashboard</a></div>
                        <div class="breadcrumb-item"><a href="users">All Users</a></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-md-10 col-12 col-sm-14">
                    <div class="card">
                        <div class="card-header">
                            <h4>Total Registered Users</h4>
                            <div class="card-header-action">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-primary" id="users-today-btn">Today</a>
                                    <a href="#" class="btn" id="users-week-btn">Week</a>
                                    <a href="#" class="btn" id="users-month-btn">Month</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="usersChart" height="182"></canvas>
                        </div>
                    </div>
                </div>

                @push('scripts')
                    <script>
                        // Example data, replace with dynamic data from backend if needed
                        const usersData = {
                            today: {
                                labels: [
                                    '00:00',
                                    '01:00',
                                    '02:00',
                                    '03:00',
                                    '04:00',
                                    '05:00',
                                    '06:00',
                                    '07:00',
                                    '08:00',
                                    '09:00',
                                    '10:00',
                                    '11:00',
                                    '12:00',
                                    '13:00',
                                    '14:00',
                                    '15:00',
                                    '16:00',
                                    '17:00',
                                    '18:00',
                                    '19:00',
                                    '20:00',
                                    '21:00',
                                    '22:00',
                                    '23:00'
                                ],
                                data: [
                                    {{ $usersTodayData[0] ?? 0 }},
                                    {{ $usersTodayData[1] ?? 0 }},
                                    {{ $usersTodayData[2] ?? 0 }},
                                    {{ $usersTodayData[3] ?? 0 }},
                                    {{ $usersTodayData[4] ?? 0 }},
                                    {{ $usersTodayData[5] ?? 0 }},
                                    {{ $usersTodayData[6] ?? 0 }},
                                    {{ $usersTodayData[7] ?? 0 }},
                                    {{ $usersTodayData[8] ?? 0 }},
                                    {{ $usersTodayData[9] ?? 0 }},
                                    {{ $usersTodayData[10] ?? 0 }},
                                    {{ $usersTodayData[11] ?? 0 }},
                                    {{ $usersTodayData[12] ?? 0 }},
                                    {{ $usersTodayData[13] ?? 0 }},
                                    {{ $usersTodayData[14] ?? 0 }},
                                    {{ $usersTodayData[15] ?? 0 }},
                                    {{ $usersTodayData[16] ?? 0 }},
                                    {{ $usersTodayData[17] ?? 0 }},
                                    {{ $usersTodayData[18] ?? 0 }},
                                    {{ $usersTodayData[19] ?? 0 }},
                                    {{ $usersTodayData[20] ?? 0 }},
                                    {{ $usersTodayData[21] ?? 0 }},
                                    {{ $usersTodayData[22] ?? 0 }},
                                    {{ $usersTodayData[23] ?? 0 }}
                                ]
                            },
                            week: {
                                labels: [
                                    'Monday',
                                    'Tuesday',
                                    'Wednesday',
                                    'Thursday',
                                    'Friday',
                                    'Saturday',
                                    'Sunday'
                                ],
                                data: [
                                    {{ $usersWeekData[0] ?? 0 }},
                                    {{ $usersWeekData[1] ?? 0 }},
                                    {{ $usersWeekData[2] ?? 0 }},
                                    {{ $usersWeekData[3] ?? 0 }},
                                    {{ $usersWeekData[4] ?? 0 }},
                                    {{ $usersWeekData[5] ?? 0 }},
                                    {{ $usersWeekData[6] ?? 0 }}
                                ]
                            },
                            month: {
                                labels: [
                                    'Week 1',
                                    'Week 2',
                                    'Week 3',
                                    'Week 4'
                                ],
                                data: [
                                    {{ $usersMonthData[0] ?? 0 }},
                                    {{ $usersMonthData[1] ?? 0 }},
                                    {{ $usersMonthData[2] ?? 0 }},
                                    {{ $usersMonthData[3] ?? 0 }}
                                ]
                            }
                        };

                        let currentRange = 'today';
                        let usersChart;

                        function renderUsersChart(range) {
                            const ctx = document.getElementById('usersChart').getContext('2d');
                            if (usersChart) usersChart.destroy();
                            usersChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: usersData[range].labels,
                                    datasets: [{
                                        label: 'Total Users',
                                        data: usersData[range].data,
                                        backgroundColor: 'rgba(63,82,227,0.2)',
                                        borderColor: 'rgba(63,82,227,1)',
                                        borderWidth: 2,
                                        pointBackgroundColor: 'rgba(63,82,227,1)',
                                        pointBorderColor: '#fff',
                                        pointRadius: 4,
                                        fill: true,
                                        tension: 0.3
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            precision: 0
                                        }
                                    }
                                }
                            });
                        }

                        document.getElementById('users-today-btn').addEventListener('click', function(e) {
                            e.preventDefault();
                            renderUsersChart('today');
                            setActiveBtn(this);
                        });
                        document.getElementById('users-week-btn').addEventListener('click', function(e) {
                            e.preventDefault();
                            renderUsersChart('week');
                            setActiveBtn(this);
                        });
                        document.getElementById('users-month-btn').addEventListener('click', function(e) {
                            e.preventDefault();
                            renderUsersChart('month');
                            setActiveBtn(this);
                        });

                        function setActiveBtn(btn) {
                            document.querySelectorAll('.card-header-action .btn').forEach(function(b) {
                                b.classList.remove('btn-primary');
                            });
                            btn.classList.add('btn-primary');
                        }

                        // Initial render
                        renderUsersChart(currentRange);
                    </script>
                @endpush
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush
