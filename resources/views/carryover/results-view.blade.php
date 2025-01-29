@extends('layouts.result-layout')

@section('content')
    {{-- ['student_id', 'session_id', 'semester_id', 'level_id', 'dept_id'] --}}
    <livewire:carryover.result-table :$student_id :$session_id :$semester_id :$level_id :$dept_id lazy />
@endsection
