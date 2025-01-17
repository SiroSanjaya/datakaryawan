<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Data Karyawan')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles (optional) -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Data Karyawan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('employees.index') }}">Karyawan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('employees.create') }}">Tambah Karyawan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Content Area -->
        @yield('content')
    </div>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Scripts (optional) -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#addEmployeeForm').submit(function (e) {
                e.preventDefault(); // Mencegah form refresh halaman

                const formData = {
                    name: $('#name').val(),
                    salary: $('#salary').val(),
                    position_id: $('#position_id').val()
                };

                $.ajax({
                    url: '/employees', // Endpoint POST Laravel
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        // Tampilkan notifikasi
                        alert(response.message);

                        // Tambahkan data baru ke tabel
                        const newRow = `
                            <tr>
                                <td>${response.employee.id}</td>
                                <td>${response.employee.name}</td>
                                <td>${response.employee.salary}</td>
                                <td>${response.employee.position_id}</td>
                            </tr>
                        `;
                        $('#employeeTable tbody').append(newRow);

                        // Kosongkan form input
                        $('#addEmployeeForm')[0].reset();
                    },
                    error: function (error) {
                        console.error('Terjadi kesalahan:', error);
                        alert('Gagal menambahkan data!');
                    }
                });
            });
        });
    </script>

</body>

</html>
