@extends('layouts.result-layout')

@section('content')
    {{-- ['student_id', 'session_id', 'semester_id', 'level_id', 'dept_id'] --}}

    <div>
        <div class="text-center">
            <img src="https://png.pngtree.com/png-clipart/20230825/original/pngtree-login-access-denied-vector-illustration-picture-image_8480027.png"
                alt="Locked icon" class="w-50 h-50 mb-1 mx-auto">
            <h2 class="text-3xl font-bold text-red-600">RESULT PAGE IS LOCKED. PLEASE CONTACT THE ADMIN.</h2>
        </div>
    </div>

    {{-- <livewire:results.result-table :$student_id :$session_id :$semester_id :$level_id :$dept_id lazy /> --}}
@endsection
