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

    {{--  --}}
    <style type="text/css">
        .myt {
            transform: rotate(-90deg);
            font-size: 8px;
            overflow: hidden;
        }

        .mytd {
            transform: rotate(-90deg);
            overflow: hidden
        }

        .mytab tr td,
        .mytab tr th {
            border: 1px solid black !important;
        }

        .mytab {
            border-collapse: collapse;
            border-spacing: 200px;
            table-layout: fixed;
            width: 100%;
            text-align: center;
            font-size: 12px;
        }

        td {
            overflow: hidden;
            word-wrap: break-word;
        }

        @media print {
            .hide_printDialog {
                display: none;
            }

            #hide {
                display: none;
            }

            #div_pagination {
                display: none;
            }

            .mytab {
                width: 80%;
            }

            .mytab tr td,
            .mytab tr th {
                border: 1px solid black !important;
                font-size: 11px;
            }

            .mytab {
                border-collapse: collapse;
                border-spacing: 200px;
                table-layout: fixed;
                width: 90%;
                text-align: center;
                font-size: 9px;
            }

            td {
                overflow: hidden;
                word-wrap: break-word;
            }

            .hide_1,
            .hide_2 {
                display: none;
            }

            .myt {
                font-size: 8px;
            }
        }

        @page {
            size 8.5in 11in;
            margin: 0cm;
        }

        div.page {
            page-break-after: always;
        }

        /* /*@page{size:auto;margin:4mm;} */
    </style>

    @foreach ($studentsChunked as $pageIndex => $students)
        <div class="page-break">
            <x-result.head-section :$dept :$session :$level :$semester>
                Examination Results
                <div class="toggle_container">
                    <div class="tracking-normal leading-normal font-bold text-3xl underline mt-5 mb-2">
                        SUMMARY RESULT FOR ALL {{ $session }}/{{ $session + 1 }} ACADEMIC SET
                    </div>
                </div>
            </x-result.head-section>

            <table align="center" class="mytab" cellpadding="5" cellspacing="50" width="80%">
                <tbody>
                    <tr>
                        <td rowspan="2" width="160">MAT NUM</td>
                        <td rowspan="2">NAME</td>
                        <th colspan="4">Diploma1</th>
                        <th colspan="4">Diploma2</th>
                        <td colspan="3">Summary</td>
                        <td rowspan="2">CGPA</td>
                        <td rowspan="2">Class of Degree</td>
                        <td rowspan="2">Remark</td>
                    </tr>
                    <tr>
                        <td>TCR</td>
                        <td>TCE</td>
                        <td>TGP</td>
                        <td>GPA</td>
                        <td>TCR</td>
                        <td>TCE</td>
                        <td>TGP</td>
                        <td>GPA</td>
                        <td>CTCR</td>
                        <td>CTCE</td>
                        <td>CTGP</td>
                    </tr>

                    @foreach ($students as $student)
                        @php
                            $diploma1 = $this->getStudentMetrics($student->student_id, 1);
                            $diploma2 = $this->getStudentMetrics($student->student_id, 2);
                            $cumulative = $this->getCumulativeMetrics($student->student_id);
                        @endphp
                        <tr class="h-20">
                            <td>{{ $student->regno }}</td>
                            <td>{{ strtoupper($student->surname . ' ' . $student->middlename . ' ' . $student->firstname) }}
                            </td>

                            <td>{{ $diploma1['tcr'] }}</td>
                            <td>{{ $diploma1['tce'] }}</td>
                            <td>{{ $diploma1['tgp'] }}</td>
                            <td>{{ $diploma1['gpa'] }}</td>

                            <td>{{ $diploma2['tcr'] }}</td>
                            <td>{{ $diploma2['tce'] }}</td>
                            <td>{{ $diploma2['tgp'] }}</td>
                            <td>{{ $diploma2['gpa'] }}</td>

                            <td>{{ $cumulative['ctcr'] }}</td>
                            <td>{{ $cumulative['ctce'] }}</td>
                            <td>{{ $cumulative['ctgp'] }}</td>

                            <td>{{ $cumulative['cgpa'] }}</td>
                            <td>
                                @if ($cumulative['cgpa'] >= 4.5)
                                    First Class
                                @elseif ($cumulative['cgpa'] >= 3.5)
                                    Second Class Upper
                                @elseif ($cumulative['cgpa'] >= 2.49)
                                    Second Class Lower
                                @elseif ($cumulative['cgpa'] >= 2.0)
                                    Third Class
                                @else
                                    Pass
                                @endif
                            </td>
                            <td>{{ $cumulative['cgpa'] >= 1.0 ? 'Passed' : 'Failed' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <x-result.official-section :$studentsChunked :$pageIndex :$officials />
        </div>
    @endforeach


    <div class="page-break">

        <x-result.head-section :$dept :$session :$level :$semester>
            SUMMARY OF GRADUATING STUDENT RESULTS
        </x-result.head-section>

        {{-- <table style="table-layout:fixed;" width="80%" align="right">
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
        </table> --}}


        <table style="table-layout:fixed;" width="80%" align="right">
            <div class="border-2 border-black">

                <thead>
                    <tr>
                        <th class="" width="40%">
                            <h2 class="text-3xl text-left pl-6 p-4 font-extrabold tracking-wide">
                                SET SUMMARY
                            </h2>
                        </th>

                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th class="p-4" style="font-size: 12px;">

                            <h3 class="mb-4  text-2xl font-extrabold tracking-wide text-left pl-4">
                                Total NUMBER OF STUDENTS
                            </h3>

                            <h3 class="mb-4  text-2xl font-extrabold tracking-wide text-left pl-4">
                                NUMBER OF FIRST CLASS
                            </h3>

                            <h3 class="mb-4  text-2xl font-extrabold tracking-wide text-left pl-4">
                                NUMBER OF Second CLASS UPPER
                            </h3>

                            <div class="mb-4  text-2xl font-extrabold tracking-wide text-left pl-4">
                                NUMBER OF Second CLASS LOWER
                            </div>

                            <div class="mb-4  text-2xl font-extrabold tracking-wide text-left pl-4">
                                NUMBER OF Third CLASS
                            </div>

                            <div class="mb-4  text-2xl font-extrabold tracking-wide text-left pl-4">
                                NUMBER OF Pass
                            </div>

                            <div class="mb-4  text-2xl font-extrabold tracking-wide text-left pl-4">
                                Graduating
                            </div>
                        </th>
                        <th class="p-2">

                            <h3 class="mb-4  text-2xl font-extrabold tracking-wide text-left">
                                25
                            </h3>

                            <h3 class="mb-4  text-2xl font-extrabold tracking-wide text-left">
                                1
                            </h3>

                            <h3 class="mb-4  text-2xl font-extrabold tracking-wide text-left">
                                19
                            </h3>

                            <h3 class="mb-4  text-2xl font-extrabold tracking-wide text-left">
                                6
                            </h3>

                            <div class="mb-4  text-2xl font-extrabold tracking-wide text-left">
                                1
                            </div>

                            <div class="mb-4  text-2xl font-extrabold tracking-wide text-left">
                                0
                            </div>

                            <div class="mb-4  text-2xl font-extrabold tracking-wide text-left">
                                25
                            </div>
                        </th>
                        <th>

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
