@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>مواعيدك</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>المعلم</th>
                <th>تاريخ البدء</th>
                <th>تاريخ الانتهاء</th>
                <th>رابط الجلسة</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->teacher->name }}</td>
                    <td>{{ $appointment->start_time }}</td>
                    <td>{{ $appointment->end_time }}</td>
                    <td>
                        @if($appointment->session_link)
                            <a href="{{ $appointment->session_link }}" target="_blank">اذهب للجلسة</a>
                        @else
                            <span>لا يوجد رابط</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
