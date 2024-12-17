@extends('layouts.dashboard')

@section('content')
    <style>
        tr td {
            color: black
        }

        /* تنسيق زر التصدير */
        .btn-export-pdf {
            background-color: #C5FF41;
            color: black;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin-bottom: 20px;
            transition: background-color 0.3s ease;
        }

        .btn-export-pdf:hover {
            background-color: #a0d136;
        }
    </style>

    <div class="container mt-4">
        <h2>التقارير</h2>

        <!-- زر تصدير PDF -->

        <table id="reportsTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">المعرف</th>
                    <th scope="col">اسم المستخدم</th>
                    <th scope="col">السبب</th>
                    <th scope="col">الرسالة</th>
                    <th scope="col">تاريخ الإنشاء</th>
                </tr>
            </thead>
            <tbody>
                @php
                    use App\Models\Report;
                    use Illuminate\Support\Facades\Auth;

                    // Get the logged-in user
                    $user = Auth::user();

                    // Fetch reports based on user type
                    $reports =
                        $user->type === 'admin'
                            ? Report::with('user')->get() // Admin sees all reports with user data
                            : Report::with('user')
                                ->where('user_id', $user->id)
                                ->get(); // Student sees their own reports with user data
                @endphp

                @forelse($reports as $report)
                    <tr>
                        <td style="color: black">{{ $report->id }}</td>
                        <td style="color: black">{{ $report->user->name }}</td>
                        <td style="color: black">{{ $report->reason }}</td>
                        <td style="color: black">{{ $report->message }}</td>
                        <td style="color: black">{{ $report->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">لم يتم العثور على تقارير</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- DataTables CDN -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

        <!-- jsPDF CDN -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jsPDF/2.5.1/jspdf.umd.min.js"></script>

        <!-- Initialize DataTables and the Export Button -->
        <script>
            $(document).ready(function() {
                // Initialize DataTables
                $('#reportsTable').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/ar.json'
                    },
                    paging: false,
                    searching: true,
                    columnDefs: [
                        { targets: '_all', searchable: true }
                    ],
                    lengthChange: true,
                    ordering: true,
                    info: true,
                    autoWidth: true,
                    responsive: true
                });

                // Event listener for the PDF export button
                $('#exportPdfButton').click(function() {
                    const { jsPDF } = window.jspdf;
                    const doc = new jsPDF();

                    // Get the table data
                    const table = document.getElementById("reportsTable");
                    const rows = table.getElementsByTagName("tr");
                    const tableData = [];

                    // Loop through the table rows and columns
                    for (let row of rows) {
                        const rowData = [];
                        const cols = row.getElementsByTagName("td");
                        if (cols.length > 0) { // Skip header row
                            for (let col of cols) {
                                rowData.push(col.innerText);
                            }
                            tableData.push(rowData);
                        }
                    }

                    // Add the table data to the PDF
                    doc.autoTable({
                        head: [['المعرف', 'اسم المستخدم', 'السبب', 'الرسالة', 'تاريخ الإنشاء']],
                        body: tableData,
                    });

                    // Save the PDF
                    doc.save('التقارير.pdf');
                });
            });
        </script>
    </div>
@endsection
