<div>

    <script>
        $(document).ready(function() {
            //Check if the current URL contains '# or hash'
            if (document.URL.indexOf("#") == -1) {
                // Set the URL to whatever it was plus "#loaded".
                url = document.URL + "#loaded";
                location = "#loaded";
                //Reload the page using reload() method
                location.reload(true);
            }
        });
    </script>

    <style>
        @media print {
            .page-break {
                page-break-after: always;
            }

            .officials {
                margin-bottom: 20px;
                font-size: 14px;
            }
        }
    </style>

    @foreach ($studentsChunked as $pageIndex => $students)
        <div class="page-break">

            <x-result.head-section :$dept :$session :$level :$semester>
                Examination Results
            </x-result.head-section>

            <table class="mytab" style="table-layout:fixed" width="100%" align="right">
                <tbody>
                    <tr>
                        <th width="2%" rowspan="2">S/N</th>
                        <th width="7%" rowspan="2">NAME</th>
                        <th width="7%" rowspan="2">MATRIC NUMBER</th>
                        <th colspan="{{ $coreCourse->count() + 2 + $eleCount->count() + 4 }}" width="48%">PRESENT
                            SEMESTER
                        </th>
                        <th width="12%" colspan="4">PREVIOUS</th>
                        <th width="12%" colspan="4">SUMMARY</th>
                        <th rowspan="2" style="overflow: hidden;word-wrap: break-word;font-size:10px;" class="pos"
                            width="10%">REMARKS</th>

                    </tr>
                    <tr>
                        <th width="33%" colspan="{{ $coreCourse->count() + 2 }}">CORE COURSES</th>
                        @if ($eleCount->count() > 0)
                            <th width="6%" colspan="{{ $eleCount->count() }}">ELECTIVES</th>
                        @endif

                        <th width="3%">TCR</th>
                        <th width="3%">TCE</th>
                        <th width="3%">TGP</th>
                        <th width="3%">GPA</th>

                        <th width="3%">CTCR</th>
                        <th width="3%">CTCE</th>
                        <th width="3%">CTGP</th>
                        <th width="3%">CGPA</th>

                        <th width="3%">CTCR</th>
                        <th width="3%">CTCE</th>
                        <th width="3%">CTGP</th>
                        <th width="3%">CGPA</th>
                    </tr>



                    @forelse ($students as $key => $student)
                        @if ($student->courseRegistrations)
                            <tr class="uppercase">
                                {{-- <th>{{ $loop->iteration }}</th> --}}
                                <td>{{ $key + 1 }}</td>
                                @if ($showNames)
                                    <th class="py-2" style="overflow: hidden">
                                        {{ $student->surname }}
                                        {{ $student->middlename }}
                                        {{ $student->firstname }}
                                    </th>
                                @else
                                    <th></th>
                                @endif

                                <th> {{ $student->regno }} </th>

                                @if (
                                    $student->courseRegistrations->isNotEmpty() &&
                                        $student->courseRegistrations->pluck('course_id')->intersect($coreCourse->pluck('course_id'))->isNotEmpty())
                                    <!-- Core Courses -->
                                    @foreach ($coreCourse as $course)
                                        @php
                                            $score = $student->courseRegistrations
                                                ->where('course_id', $course->course_id)
                                                ->first();
                                        @endphp
                                        <th class="leading-wider text-md">
                                            <span class="smallSubj">
                                                {{ $course->course_code ?? '' }}
                                            </span>
                                            <br>
                                            <span class="smallSubj">
                                                {{ $course->unit ?? 'N/A' }}
                                            </span>
                                            <br>
                                            <span class="aggr_unit">
                                                {{ $score->score ?? '' }}{{ $score->grade ?? '' }}
                                                <br>
                                                <span class="" style="font-size: 9px;">
                                                    {{ $score->grade_point ?? '' }}
                                                </span>
                                            </span>
                                        </th>
                                    @endforeach
                                @else
                                    <!-- Message for no registered courses -->
                                    <td style="font-size: 10px;s" colspan="{{ $coreCourse->count() }}"
                                        class="text-center text-red-500">
                                        Student did not register any courses this semester.
                                    </td>
                                @endif
                                <th></th>
                                <th></th>
                                {{-- @for ($x = 0; $x < $eleCount->count(); $x++) --}}
                                @if ($eleCount->count() > 0)
                                    <!-- Elective Courses -->
                                    @foreach ($eleCount as $course)
                                        @php
                                            $score = $student->courseRegistrations
                                                ->where('course_id', $course->course_id)
                                                ->first();
                                        @endphp
                                        <th class="leading-wider text-md">
                                            <span class="smallSubj">
                                                {{ $course->course_code ?? '' }}
                                            </span>
                                            <br>
                                            <span class="smallSubj">
                                                {{ $course->unit ?? 'N/A' }}
                                            </span>
                                            <br>
                                            <span class="aggr_unit">
                                                {{ $score->score ?? '' }}{{ $score->grade ?? '' }}
                                                <br>
                                                <span class="" style="font-size: 9px;">
                                                    {{ $score->grade_point ?? '' }}
                                                </span>
                                            </span>
                                        </th>
                                    @endforeach
                                @endif
                                {{-- @endfor --}}

                                <th> {{ $this->calculateTCR($student->courseRegistrations) }} </th>
                                <th> {{ $this->calculateTCE($student->courseRegistrations) }} </th>
                                <th> {{ $this->calculateTGP($student->courseRegistrations) }} </th>
                                <th> {{ $this->calculateGPA($student->courseRegistrations) }} </th>

                                @php

                                    $previousMetrics = $this->calculatePreviousMetrics(
                                        $student,
                                        $session,
                                        $semester,
                                        $level,
                                    );

                                    $summary = $this->calculateSummaryMetrics($student, $session, $semester, $level);

                                    // $remark = $this->generateRemark($student, $semester, $level, $coreCourse);
                                    $remark = $this->generateRemark($student);
                                @endphp


                                <!-- Previous Cumulative Metrics -->
                                <th>{{ $previousMetrics['ctcr'] }}</th>
                                <th>{{ $previousMetrics['ctce'] }}</th>
                                <th>{{ $previousMetrics['ctgp'] }}</th>
                                <th>{{ $previousMetrics['cgpa'] }}</th>

                                <th>{{ $summary['ctcr'] }}</th>
                                <th>{{ $summary['ctce'] }}</th>
                                <th>{{ $summary['ctgp'] }}</th>
                                <th>{{ $summary['cgpa'] }}</th>


                                <th style="overflow: hidden;word-wrap: break-word;width:10%"><tt><span
                                            style="font-size:10px;" class="uppercase ">{{ $remark }}</span></tt>
                                </th>
                            </tr>
                        @else
                            <tr>
                                <td>No reg</td>
                            </tr>
                        @endif

                    @empty
                        No Data to process
                    @endforelse


                </tbody>
            </table>

            <p style="font-size:20px"><strong> Page {{ $pageIndex + 1 }} of {{ $studentsChunked->count() }}</strong>
            </p>


            <div class="officials">
                <div style="width:400px;float:left;text-transform:uppercase;margin-top:5%;font-size:13px">
                    ..............................................<br>{{ $officials->exam_officer ?? null }}<br>Coordinator
                </div>
                <div style="width:400px;float:right;text-transform:uppercase;margin-top:5%;font-size:13px">
                    ................................................<br>{{ $officials->hod ?? null }}<br>Director

                </div>
            </div>
        </div>
    @endforeach
</div>
