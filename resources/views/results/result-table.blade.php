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
                <div class="toggle_container">
                    <div class="tracking-normal leading-normal font-bold text-3xl underline"> SUPPLEMENTARY RESULT(S)
                    </div>
                </div>
            </x-result.head-section>

            <table class="text-[12px] mytab" style="table-layout:fixed" width="100%" align="right">
                <tbody>
                    <tr>
                        <th class="print:text-sm font-bold print:font-bold" width="2%" rowspan="2">S/N</th>
                        <th class="print:text-sm font-bold print:font-bold" width="7%" rowspan="2">NAME</th>
                        <th class="print:text-sm font-bold print:font-bold" width="10%" rowspan="2">MATRIC NUMBER
                        </th>
                        <th class="print:text-sm font-bold print:font-bold"
                            colspan="{{ $coreCourse->count() + 1 + $eleCount->count() + 4 }}" width="49%">PRESENT
                            SEMESTER
                        </th>
                        <th class="print:text-sm font-bold print:font-bold" width="12%" colspan="4">PREVIOUS</th>
                        <th class="print:text-sm font-bold print:font-bold" width="12%" colspan="4">SUMMARY</th>
                        <th class="font-bold" rowspan="2"
                            style="overflow: hidden;word-wrap: break-word;font-size:12px;" class="pos"
                            width="7%">REMARKS</th>

                    </tr>
                    <tr>
                        <th class="font-bold print:font-bold" width="34%" colspan="{{ $coreCourse->count() + 1 }}">
                            CORE COURSES</th>
                        @if ($eleCount->count() > 0)
                            <th class="font-bold print:font-bold" width="6%" colspan="{{ $eleCount->count() }}">
                                ELECTIVES</th>
                        @endif

                        <th class="print:text-[14px] font-bold print:font-bold" width="3%">TCR</th>
                        <th class="print:text-[14px] font-bold print:font-bold" width="3%">TCE</th>
                        <th class="print:text-[14px] font-bold print:font-bold" width="3%">TGP</th>
                        <th class="print:text-[14px] font-bold print:font-bold" width="3%">GPA</th>

                        <th class="print:text-[14px] font-bold print:font-bold" width="3%">CTCR</th>
                        <th class="print:text-[14px] font-bold print:font-bold" width="3%">CTCE</th>
                        <th class="print:text-[14px] font-bold print:font-bold" width="3%">CTGP</th>
                        <th class="print:text-[14px] font-bold print:font-bold" width="3%">CGPA</th>

                        <th class="print:text-[14px] font-bold print:font-bold" width="3%">CTCR</th>
                        <th class="print:text-[14px] font-bold print:font-bold" width="3%">CTCE</th>
                        <th class="print:text-[14px] font-bold print:font-bold" width="3%">CTGP</th>
                        <th class="print:text-[14px] font-bold print:font-bold" width="3%">CGPA</th>
                    </tr>



                    @forelse ($students as $key => $student)
                        @if ($student->courseRegistrations)
                            <tr class="uppercase text-sm">
                                {{-- <th>{{ $loop->iteration }}</th> --}}
                                <td class="text-[12px] font-bold print:font-bold">{{ $key + 1 }}</td>
                                @if ($showNames)
                                    <th class="py-1 print:text-md font-bold print:font-bold" style="overflow: hidden">
                                        {{ $student->surname }}
                                        {{ $student->middlename }}
                                        {{ $student->firstname }}
                                    </th>
                                @else
                                    <th></th>
                                @endif

                                <th class="px-2 font-bold print:font-bold"> {{ $student->regno }} </th>

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
                                        <th class="text-mds py-1 font-bold print:font-bold">
                                            <span class="text-[12px] font-bold">
                                                {{ $course->course_code ?? '' }}
                                            </span>
                                            <br>
                                            <span class="text-[14px] font-normal">
                                                {{ $course->unit ?? 'N/A' }}
                                            </span>
                                            {{-- <span class="mt-4">&nbsp;</span> --}}
                                            <br>
                                            <br>
                                            <span class="aggr_unitd text-[13px] font-bold print:font-extrabold py-1">
                                                {{ $score->score ?? '' }}{{ $score->grade ?? '' }}
                                                <br>
                                                <span class=" font-bold">
                                                    {{ $score->grade_point ?? '' }}
                                                </span>
                                            </span>
                                        </th>
                                    @endforeach
                                @else
                                    <!-- Message for no registered courses -->
                                    <td colspan="{{ $coreCourse->count() }}"
                                        class="text-[12px] text-center text-red-700 print:text-black font-bold print:font-bold">
                                        Student did not register any course(s) this semester.
                                    </td>
                                @endif
                                {{-- <th></th> --}}
                                <th></th>
                                {{-- @for ($x = 0; $x < $eleCount->count(); $x++) --}}
                                @if ($eleCount->count() > 0)
                                    @if (
                                        $student->courseRegistrations->isNotEmpty() &&
                                            $student->courseRegistrations->pluck('course_id')->intersect($eleCount->pluck('course_id'))->isNotEmpty())
                                        <!-- Elective Courses -->
                                        @foreach ($eleCount as $course)
                                            @php
                                                $score = $student->courseRegistrations
                                                    ->where('course_id', $course->course_id)
                                                    ->first();
                                            @endphp
                                            <th class="text-mds py-1 font-bold print:font-bold">
                                                <span class="text-[12px] font-bold">
                                                    {{ $course->course_code ?? '' }}
                                                </span>
                                                <br>
                                                <span class="text-[14px] font-normal">
                                                    {{ $course->unit ?? 'N/A' }}
                                                </span>
                                                <br>
                                                <br>
                                                <span
                                                    class="aggr_unitd text-[13px] font-bold print:font-extrabold py-1">
                                                    {{ $score->score ?? '' }}{{ $score->grade ?? '' }}
                                                    <br>
                                                    <span class=" font-bold">
                                                        {{ $score->grade_point ?? '' }}
                                                    </span>
                                                </span>
                                            </th>
                                        @endforeach
                                    @else
                                        <!-- Message for no registered courses -->
                                        <td colspan="{{ $eleCount->count() }}"
                                            class="text-[12px] text-center text-red-700 print:text-black font-bold print:font-bold">

                                        </td>
                                    @endif
                                @endif
                                {{-- @endfor --}}

                                <th class="font-bold print:font-bold">
                                    {{ $this->calculateTCR($student->courseRegistrations) }} </th>
                                <th class="font-bold print:font-bold">
                                    {{ $this->calculateTCE($student->courseRegistrations) }} </th>
                                <th class="font-bold print:font-bold">
                                    {{ $this->calculateTGP($student->courseRegistrations) }} </th>
                                <th class="font-bold print:font-bold">
                                    {{ $this->calculateGPA($student->courseRegistrations) }} </th>

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
                                <th class="font-bold print:font-bold">{{ $previousMetrics['ctcr'] }}</th>
                                <th class="font-bold print:font-bold">{{ $previousMetrics['ctce'] }}</th>
                                <th class="font-bold print:font-bold">{{ $previousMetrics['ctgp'] }}</th>
                                <th class="font-bold print:font-bold">{{ $previousMetrics['cgpa'] }}</th>

                                <th class="font-bold print:font-bold">{{ $summary['ctcr'] }}</th>
                                <th class="font-bold print:font-bold">{{ $summary['ctce'] }}</th>
                                <th class="font-bold print:font-bold">{{ $summary['ctgp'] }}</th>
                                <th class="font-bold print:font-bold">{{ $summary['cgpa'] }}</th>


                                <th style="overflow: hidden;word-wrap: break-word;width:10%"><tt><span
                                            class="text-[11px] uppercase font-bold print:font-bold">{{ $remark }}</span></tt>
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

            <x-result.official-section :$studentsChunked :$pageIndex :$officials />
        </div>
    @endforeach

    <div class="page-break">

        <x-result.head-section :$dept :$session :$level :$semester>
            Results summary aNd legend
        </x-result.head-section>

        <table style="table-layout:fixed;" width="80%" align="right">
            <div class="border-2 border-black">

                <thead>
                    <tr>
                        <th class="" width="20%">
                            <h2 class="text-3xl text-left pl-6 p-4 font-extrabold tracking-wide">
                                SUMMARY
                            </h2>
                        </th>
                        <th class="" width="10%">

                        </th>
                        <th class="" width="10%">

                        </th>
                        <th class="" width="60%">

                            <h2 class="text-3xl text-left pl-4 font-extrabold tracking-wide">
                                LEGEND
                            </h2>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th class="p-4" style="font-size: 12px;">

                            <h3 class="mb-4  text-2xl font-extrabold tracking-wide text-left pl-4">
                                Total students:
                            </h3>

                            <h3 class="mb-4  text-2xl font-extrabold tracking-wide text-left pl-4">
                                Number Registered:
                            </h3>

                            <h3 class="mb-4  text-2xl font-extrabold tracking-wide text-left pl-4">
                                Number Examined:
                            </h3>

                            <div class="mb-4  text-2xl font-extrabold tracking-wide text-left pl-4">
                                Number with Passes:
                            </div>

                            <div class="mb-4  text-2xl font-extrabold tracking-wide text-left pl-4">
                                Number with CarryOver:
                            </div>

                            <div class="mb-4  text-2xl font-extrabold tracking-wide text-left pl-4">
                                Number Absent:
                            </div>
                        </th>
                        <th class="p-4">

                            <h3 class="mb-4  text-2xl font-extrabold tracking-wide text-left">
                                {{ $this->studentsWithCourses() + $this->studentsWithoutRegistrations() }}
                            </h3>

                            <h3 class="mb-4  text-2xl font-extrabold tracking-wide text-left">
                                {{ $this->studentsWithCourses() }}
                            </h3>

                            <h3 class="mb-4  text-2xl font-extrabold tracking-wide text-left">
                                {{ $this->studentsWithScores() }}
                            </h3>

                            <div class="mb-4  text-2xl font-extrabold tracking-wide text-left">
                                {{ $this->studentsWhoPassed() }}
                            </div>

                            <div class="mb-4  text-2xl font-extrabold tracking-wide text-left">
                                {{ $this->studentsWithCarryOver() }}
                            </div>

                            <div class="mb-4  text-2xl font-extrabold tracking-wide text-left">
                                {{ $this->studentsWithoutRegistrations() }}
                            </div>
                        </th>
                        <th>

                        </th>
                        <th>
                            <div class="text-left m-0 p-0 text-2xl font-extrabold uppercase tracking-wide">
                                @foreach ($coreCourse as $coreCourse)
                                    {{ $coreCourse->course_code }}&nbsp;&nbsp;&nbsp;{{ $coreCourse->course_title }}
                                    <br>
                                @endforeach
                                <br>
                                @foreach ($eleCount as $elective)
                                    {{ $elective->course_code }}&nbsp;&nbsp;&nbsp;{{ $elective->course_title }}
                                    <br>
                                @endforeach
                            </div>
                        </th>
                    </tr>

                </tbody>
            </div>
        </table>

        <p class="text-sm font-bold">CPDS-Online made with &hearts; from UNICSOFT.</span>
        </p>

        <div class="officials text-[14px] font-extrabold">
            <div style="width:400px;float:left;text-transform:uppercase;margin-top:5%;">
                ..............................................<br>{{ $officials->exam_officer ?? null }}<br>Coordinator
            </div>
            <div style="width:400px;float:right;text-transform:uppercase;margin-top:5%;">
                ................................................<br>{{ $officials->hod ?? null }}<br>Director

            </div>
        </div>
    </div>


</div>
