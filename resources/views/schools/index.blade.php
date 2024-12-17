@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1>المدارس</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('schools.create') }}" class="btn btn-primary mb-3">إضافة مدرسة جديدة</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>نوع التعليم</th>
                <th>المراحل الدراسية</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schools as $school)
                <tr>
                    <td>{{ $school->name }}</td>
                    <td>
                        <ul>
                            @foreach($school->education_level as $education)
                                <li>{{ $education->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <a href="{{ route('schools.education.create', $school->id) }}" class="btn btn-info">إضافة مرحلة دراسية</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
