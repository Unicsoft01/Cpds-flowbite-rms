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

    {{-- {{ $students }} --}}
    <!--  <div style="position:fixed;float:right;margin-left:200px;" class="hide_printDialog"></div> -->

    <div style="width:1500px;margin-left:20%;">
        <div title="logo" style="width:120px;float:left;">
            <img src="{{ url('/') }}/sbyte/logo.jpg" width="90px" height="110px">
        </div>

        <div title="logo" style="width:600px;float:left;text-transform:uppercase;font-weight:bold;line-height:15px;">
            <h2 class="inline-block mb-2 text-4xl font-extrabold tracking-wide text-gray-900 dark:text-white">KOGI
                STATE
                UNIVERSITY, ANYIGBA</h2>
            <p class="tracking-normal" style="font-size:14px;">
                centre for predegree and diploma studies
                <br>
                Faculty of {{ $dept->facultyMember->faculty }}
                <br>
                Department of {{ $dept->department }}
                <br>
                Examination Results
            </p>
        </div>

        <div title="logo" style="width:400px;float:left;">
            <img src="{{ url('/') }}/sbyte/logo.jpg" width="90px" height="110px">
        </div>

    </div>

    <style type="text/css">
        .pos {
            width: 5.5%
        }

        .mytab tr th {
            font-size: 9px;
            text-align: center;
            border: 1px solid black !important;
            overflow: hidden;
        }

        .mytab {
            border-collapse: collapse;
        }

        @page {
            size: auto;
            margin: 7mm;
        }

        @media print {
            @page {
                size: landscape;
            }
        }

        * {
            font-size: 7px;
            font-weight: bold;
            text-align: center;
        }

        .smallSubj {
            font-size: 8px;
            font-weight: bolder;
        }

        .aggr_unit {
            font-weight: bolder;
            font-size: 10px;
        }

        .mytab tr {
            border: 2px solid black;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $("td:empty").html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
        });
    </script>

    <form action="" method="POST" class="hidden-print" style="overflow: hidden; display: block;">
        <!--
                                                                                                                                            &nbsp;<a onclick="return confirm('Caution:This Action Cannot be Undone!');"   href="result_processorAgreed.php" class="hidden-print" style="font-size:16px;">Approve?</a>-->

    </form>



    <div class="toggle_container" style="display: block;">
        <div class="block" style="font-size:15px;text-decoration:underline;"> SUPPLEMENTARY RESULT(S) </div>
    </div>
    <br>

    <table class="print:hidden mb-5" align="center" width="50%">
        {{-- <tbody>
            <tr>
                <td>
                    <form action="" method="POST" class="hidden-print">
                        <input type="text" name="new_fontSize" placeholder="Font Size"
                            style="width:150px;height:20px;font-size:12px;" minlength="1" maxlength="2"
                            value="8">
                        <input type="submit" name="sub_size" class="btn btn-primary" value="Minifier"
                            title="Change to Reduce or Increase Font Size">
                    </form>
                </td>
                <!-- <td><a style='text-decoration:none'   href="tentative_result.php" class="hidden-print" style="font-size:16px;">
                                                                                                                                            <button class="btn btn-info">Print Tentative</button></a></td> -->

                <td>
                    <form action="" method="POST" class="hidden-print">
                        <input type="text" name="new_session" placeholder="session"
                            style="width:150px;height:20px;font-size:12px;" class="formater" maxlength="9">
                        <input type="submit" name="sub_sess" class="btn btn-info" value="Update">
                    </form>
                </td>

                <script type="text/javascript">
                    $(".formater").keyup(function() {
                        var val = this.value.replace(/\D/g, '');
                        var newVal = '';
                        while (val.length > 4) {
                            newVal += val.substr(0, 4) + '/';
                            val = val.substr(4);
                        }
                        newVal += val;
                        this.value = newVal;
                    });
                </script>
            </tr>

        </tbody> --}}
        {{-- actions --}}
        <button wire:click="$dispatch('toggleNames')" wire:loading.attr="disabled" wire:loading.class="opacity-50"
            class="print:hidden text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-2xl px-4 py-2 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
            <span class="text-2xl " wire:loading.remove>
                @if ($showNames)
                    Hide Student Names
                @else
                    Show Student Names
                @endif
            </span>
            <span class="text-2xl" wire:loading>
                Processing...
            </span>
        </button>
    </table>


    <style>
        .Tab tr td {
            text-transform: uppercase;
        }

        th {
            font-weight: normal;
        }
    </style>
    <table align="center" width="90%" class="Tab" border="1">
        <tbody>
            <tr>
                <td colspan="2" rowspan="2">
                    <p style="font-size:12px;">Academic Session: {{ $session }}/{{ $session + 1 }}</p>
                </td>
                <td colspan="2" rowspan="2">
                    <p style="font-size:12px;">Level: &nbsp;{{ $level }} </p>
                </td>
                <td colspan="2" rowspan="2">
                    <p style="font-size:12px;">Semester: &nbsp;{{ $semester }} Semester</p>
                </td>
                <td colspan="2" rowspan="2">
                    <p style="font-size:12px;">PROGRAMME: &nbsp;Diploma {{ $dept->department }}</p>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- <div class="print:hidden">
        {{ $students }}
        {{ $session }}
    </div> --}}




    <table class="mytab" style="table-layout:fixed" width="100%" align="right">
        <tbody>
            <tr>
                <th width="2%" rowspan="2">S/N</th>
                <th width="7%" rowspan="2">NAME</th>
                <th width="7%" rowspan="2">MATRIC NUMBER</th>
                <th colspan="{{ $coreCourse->count() + 2 + $eleCount->count() + 4 }}" width="48%">PRESENT SEMESTER
                </th>
                <th width="12%" colspan="4">PREVIOUS</th>
                <th width="12%" colspan="4">SUMMARY</th>
                <th rowspan="2" style="overflow: hidden;word-wrap: break-word;font-size:10px;" class="pos"
                    width="7%">REMARKS</th>

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
                {{-- {{ $student->courseRegistrations->pluck('course_id') }} --}}

                @if ($student->courseRegistrations)
                    <tr class="uppercase">
                        <th>{{ $loop->iteration }}</th>
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
                                $score = $student->courseRegistrations->where('course_id', $course->course_id)->first();
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


                        {{-- <th><span class="smallSubj">POL101</span><br>3<br><span class="aggr_unit">65B<br>12</span></th>
                    <th>21</th> --}}


                        <th> {{ $this->calculateTCR($student->courseRegistrations) }} </th>
                        <th> {{ $this->calculateTCE($student->courseRegistrations) }} </th>
                        <th> {{ $this->calculateTGP($student->courseRegistrations) }} </th>
                        <th> {{ $this->calculateGPA($student->courseRegistrations) }} </th>

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
                            // Calculate previous cumulative metrics
                            // $previousMetrics = $this->calculatePreviousMetrics($student, $session, $semester, $level);

                            $previousMetrics = $this->calculatePreviousMetrics($student, $session, $semester, $level);

                            $summary = $this->calculateSummaryMetrics($student, $session, $semester, $level);

                            $remark = $this->generateRemark($student, $level_id, $semester_id, $cores);
                        @endphp


                        <!-- Previous Cumulative Metrics -->
                        <th>{{ $previousMetrics['ctcr'] }}</th>
                        <th>{{ $previousMetrics['ctce'] }}</th>
                        <th>{{ $previousMetrics['ctgp'] }}</th>
                        <th>{{ $previousMetrics['cgpa'] }}</th>

                        {{-- <th>{{ $this->calculateCTCR($student) }}</th>
                        <th>{{ $this->calculateCTCE($student) }}</th>
                        <th>{{ $this->calculateCTGP($student) }}</th>
                        <th>{{ $this->calculateCGPA($student) }}</th> --}}
                        <th>{{ $summary['ctcr'] }}</th>
                        <th>{{ $summary['ctce'] }}</th>
                        <th>{{ $summary['ctgp'] }}</th>
                        <th>{{ $summary['cgpa'] }}</th>


                        <th style="overflow: hidden;word-wrap: break-word;width:7%"><tt><span style="font-size:10px;"
                                    class="uppercase ">{{ $remark }}</span></tt></th>
                    </tr>
                    {{-- {{ $student->courseRegistrations->courses() }} --}}
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
    <div>
        <p style="font-size:20px"><strong> Total Records: {{ count($students) }}</strong></p>
        <!-- <form action="" method="POST" class="hidden-print">
                                                                                                                    <input type="text" name="no_of_rows" placeholder="No of rows" value="250" id='restrict'>
                                                                                                                    <input type="submit" name="no_rows" value="reload" disabled="">
                                                                                                                    
                                                                                                                    
                                                                                                                    </form> -->



    </div>

    <div style="width:400px;float:left;text-transform:uppercase;margin-top:5%;font-size:13px">
        ..............................................<br>{{ $officials->exam_officer ?? null }}<br>Coordinator

    </div>
    <div style="width:400px;float:right;text-transform:uppercase;margin-top:5%;font-size:13px">
        ................................................<br>{{ $officials->hod ?? null }}<br>Director



    </div>
</div>
