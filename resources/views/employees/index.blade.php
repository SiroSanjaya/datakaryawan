<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Employees List</h2>
    <button class="btn btn-primary mb-3" id="addEmployeeBtn">Add New Employee</button>

    <table id="employeeTable" class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Salary</th>
            <th>Position</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="employeeForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeModalLabel">Add Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="employee_id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="salary" class="form-label">Salary</label>
                        <input type="number" class="form-control" id="salary" required>
                    </div>
                    <div class="mb-3">
                        <label for="position_id" class="form-label">Position</label>
                        <select class="form-control" id="position_id" required></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveEmployeeBtn">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        var table = $('#employeeTable').DataTable();

        function loadEmployees() {
            $.get('{{ url('/') }}', function (response) {
                table.clear();
                $.each(response.employees, function (index, employee) {
                    table.row.add([
                        employee.name,
                        employee.salary,
                        employee.position.name,
                        `<button class="btn btn-warning btn-sm edit-btn" data-id="${employee.id}">Edit</button>
                         <button class="btn btn-danger btn-sm delete-btn" data-id="${employee.id}">Delete</button>`
                    ]).draw();
                });
            });
        }

        function loadPositions() {
            $.get('{{ url('/employees/positions') }}', function (response) {
                $('#position_id').empty();
                $.each(response.positions, function (index, position) {
                    $('#position_id').append(`<option value="${position.id}">${position.name}</option>`);
                });
            });
        }

        $('#addEmployeeBtn').click(function () {
            $('#employeeForm')[0].reset();
            $('#employee_id').val('');
            $('#employeeModalLabel').text('Add Employee');
            $('#employeeModal').modal('show');
        });

        $('#employeeForm').submit(function (e) {
            e.preventDefault();
            var id = $('#employee_id').val();
            var url = id ? `/employees/${id}` : '/employees';
            var method = id ? 'PUT' : 'POST';
            var data = {
                name: $('#name').val(),
                salary: $('#salary').val(),
                position_id: $('#position_id').val(),
                _token: '{{ csrf_token() }}'
            };
            $.ajax({ url, method, data, success: function () {
                    $('#employeeModal').modal('hide');
                    loadEmployees();
                }
            });
        });

       $(document).on('click', '.edit-btn', function () {
    var id = $(this).data('id');
    $.get(`/employees/${id}`, function (response) {
        var employee = response.employee;
        var positions = response.positions;

        // Mengisi form dengan data employee
        $('#employee_id').val(employee.id);
        $('#name').val(employee.name); // Nama diisi tetapi fieldnya disabled (tidak bisa diedit)
        $('#salary').val(employee.salary);

        // Load posisi (semua posisi akan ditampilkan)
        $('#position_id').empty(); // Kosongkan dropdown terlebih dahulu
        $.each(positions, function (index, position) {
            $('#position_id').append(`<option value="${position.id}" ${position.id == employee.position_id ? 'selected' : ''}>${position.name}</option>`);
        });

        // Update judul modal
        $('#employeeModalLabel').text('Edit Employee');

        // Tampilkan modal
        $('#employeeModal').modal('show');
    });
});



        $(document).on('click', '.delete-btn', function () {
            var id = $(this).data('id');
            if (confirm('Are you sure?')) {
                $.ajax({
                    url: `/employees/${id}`,
                    method: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function () {
                        loadEmployees();
                    }
                });
            }
        });

        loadEmployees();
        loadPositions();
    });
</script>
</body>
</html>
