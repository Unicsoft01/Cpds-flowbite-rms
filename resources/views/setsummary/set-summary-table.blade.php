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
                        SUMMARY OF RESULT FOR ALL {{ $session }}/{{ $session + 1 }} ACADEMIC SET
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
                            <td class="uppercase">{{ $student->regno }}</td>
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
                                @elseif ($cumulative['cgpa'] >= 2.4)
                                    Second Class Lower
                                @elseif ($cumulative['cgpa'] >= 1.5)
                                    Third Class
                                @else
                                    Pass
                                @endif
                            </td>
                            @php
                                $remark = $this->generateRemark($student);
                            @endphp

                            <th style="overflow: hidden;word-wrap: break-word;width:10%">
                                <span class="text-[11px] uppercase print:font-bold">{{ $remark }}
                                </span>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <x-result.official-section :$studentsChunked :$pageIndex :$officials />
        </div>
    @endforeach


    <div class="page-break">

        <x-result.head-section :$dept :$session :$level :$semester>
            SET SUMMARY LEGEND
        </x-result.head-section>

        <table style="table-layout:fixed;" width="80%" align="right">
            <div class="border-2 border-black">

                <thead>
                    <tr>
                        <th class="" width="60%">
                            <h2 class="text-3xl text-left pl-6 p-4 font-extrabold tracking-wide">
                                SET SUMMARY
                            </h2>
                        </th>
                        <th class="" width="20%">

                        </th>
                        <th class="" width="20%">

                        </th>
                        <th class="" width="20%">

                            <h2 class="text-3xl text-left pl-4 font-extrabold tracking-wide">
                                &nbsp;
                            </h2>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th class="p-4" style="font-size: 12px;">

                            <h3 class="mb-4  text-2xl font-extrabold tracking-wide text-left pl-4">
                                TOTAL NUMBER OF STUDENTS:
                            </h3>

                            <h3 class="mb-4  text-2xl font-extrabold tracking-wide text-left pl-4">
                                NUMBER OF STUDENTS WITH FIRST CLASS:
                            </h3>

                            <h3 class="mb-4  text-2xl font-extrabold tracking-wide text-left pl-4">
                                NUMBER OF STUDENTS WITH SECOND CLASS UPPER:
                            </h3>

                            <div class="mb-4  text-2xl font-extrabold tracking-wide text-left pl-4">
                                NUMBER OF STUDENTS WITH SECOND CLASS LOWER:
                            </div>

                            <div class="mb-4  text-2xl font-extrabold tracking-wide text-left pl-4">
                                NUMBER OF STUDENTS WITH THIRD CLASS:
                            </div>

                            <div class="mb-4  text-2xl font-extrabold tracking-wide text-left pl-4">
                                NUMBER OF STUDENTS WITH PASS:
                            </div>

                            <div class="mb-4  text-2xl font-extrabold tracking-wide text-left pl-4">
                                NUMBER OF STUDENTS GRADUATING:
                            </div>
                        </th>

                        @php
                            $summary = $this->getSummaryLegend();
                        @endphp

                        <th class="p-4">

                            <h3 class="mb-4 text-2xl font-extrabold tracking-wide text-left">
                                {{ $summary['total'] }}
                            </h3>

                            <h3 class="mb-4 text-2xl font-extrabold tracking-wide text-left">
                                {{ $summary['first_class'] }}
                            </h3>

                            <h3 class="mb-4 text-2xl font-extrabold tracking-wide text-left">
                                {{ $summary['second_class_upper'] }}
                            </h3>

                            <h3 class="mb-4 text-2xl font-extrabold tracking-wide text-left">
                                {{ $summary['second_class_lower'] }}
                            </h3>

                            <h3 class="mb-4 text-2xl font-extrabold tracking-wide text-left">
                                {{ $summary['third_class'] }}
                            </h3>

                            <h3 class="mb-4 text-2xl font-extrabold tracking-wide text-left">
                                {{ $summary['pass'] }}
                            </h3>

                            <h3 class="mb-4 text-2xl font-extrabold tracking-wide text-left">
                                {{-- {{ $summary['graduating'] }} --}} &nbsp;&nbsp;
                            </h3>
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
