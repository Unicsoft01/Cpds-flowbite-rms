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
                Carry-over & dropped courses result sheet
            </x-result.head-section>


            <table class="mytab" style="table-layout:fixed" width="100%" align="right">
                <tbody>
                    <tr height="30px">
                        <th width="2%" rowspan="2" class="font-bold">S/N</th>
                        <th width="7%" rowspan="2" class="font-bold">NAME</th>
                        <th width="7%" rowspan="2" class="font-bold">MATRIC NUMBER</th>
                        <th class="font-bold" colspan="{{ $coreCourse->count() + 2 }}" width="48%">PRESENT SEMESTER
                        </th>
                        <th class="font-bold" width="3%">TCR</th>
                        <th class="font-bold" width="3%">TCE</th>
                        <th class="font-bold" width="3%">TGP</th>
                        {{-- <th class="font-bold" width="3%">GPA</th> --}}
                        {{-- <th width="12%" colspan="4">SUMMARY</th> --}}
                        <th class="font-bold" rowspan="2"
                            style="overflow: hidden;word-wrap: break-word;font-size:12px;" class="pos"
                            width="7%">REMARKS</th>

                    </tr>
                    <tr>

                    </tr>


                    @forelse ($students as $key => $student)
                        @if ($student->courseRegistrations)
                            <tr class="uppercase text-sm">
                                <td class="text-[12px]">{{ $key + 1 }}</td>
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

                                <!-- Core Courses -->
                                @foreach ($coreCourse as $course)
                                    @php
                                        $score = $student->courseRegistrations
                                            ->where('course_id', $course->course_id)
                                            ->first();
                                    @endphp

                                    @if (
                                        !empty($score) &&
                                            ($score->grade_point < 1 || $score->grade === 'F' || $score->is_carryover || is_null($score->score)))
                                        <th class="leading-wider text-mds py-4">
                                            <span class="text-[12px] font-bold">
                                                {{ $course->course_code ?? '' }}
                                            </span>
                                            <br>
                                            <span class="text-[14px] font-normal">
                                                {{ $course->unit ?? 'N/A' }}
                                            </span>
                                            <div class="mt-1">&nbsp;</div>
                                            <br>
                                            <span class="aggr_unitd text-[13px] font-bold py-2">
                                                {{ $score->score ?? '' }}{{ $score->grade ?? '' }}
                                                <br>
                                                <span class=" font-bold">
                                                    {{ $score->grade_point ?? '' }}
                                                </span>
                                            </span>
                                        </th>
                                    @else
                                        <th></th>
                                    @endif
                                @endforeach

                                <th></th>
                                <th></th>

                                <th> {{ $this->calculateTCR($student->courseRegistrations) }} </th>
                                <th> {{ $this->calculateTCE($student->courseRegistrations) }} </th>
                                <th> {{ $this->calculateTGP($student->courseRegistrations) }} </th>
                                {{-- <th> {{ $this->calculateGPA($student->courseRegistrations) }} </th> --}}

                                @php
                                    $lv = \App\Models\Level::find($level_id);
                                    $sm = \App\Models\Semester::find($semester_id);

                                    $cores = \App\Models\Courses::where('dept_id', $dept->dept_id)
                                        ->where('status', 'C')
                                        ->where('level_id', '<=', $lv->level_id)
                                        ->where('semester_id', '<=', $sm->semester_id)
                                        ->get();

                                @endphp


                                @php

                                    $remark = $this->generateRemark($student, $level_id, $semester_id, $cores);
                                @endphp

                                <th style="overflow: hidden;word-wrap: break-word;width:7%">
                                    <ttr><span style="font-size:12px;" class="uppercase ">{{ $remark }}</span>
                                    </ttr>
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
</div>
