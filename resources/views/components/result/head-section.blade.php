@props(['dept', 'session', 'level', 'semester'])

<div>
    <div style="width:1500px;margin-left:20%;">
        <div title="logo" style="width:120px;float:left;">
            <img src="{{ url('/') }}/sbyte/logo.jpg" width="90px" height="110px">
        </div>

        <div title="logo" style="width:600px;float:left;text-transform:uppercase;font-weight:bold;line-height:15px;">
            <h2 class="inline-block mb-2 text-3xl font-extrabold tracking-wide text-gray-900 dark:text-white">
                PRINCE
                ABUBAKAR AUDU UNIVERSITY, ANYIGBA</h2>
            <p class="tracking-normal" style="font-size:14px;">
                centre for predegree and diploma studies
                <br>
                Faculty of {{ $dept->facultyMember->faculty }}
                <br>
                Department of {{ $dept->department }}
                <br>
                {{ $slot }}
            </p>
        </div>

        <div title="logo" style="width:400px;float:left;">
            <img src="{{ url('/') }}/sbyte/logo.jpg" width="90px" height="110px">
        </div>
        <br><br><br>
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


    </form>



    {{-- <div class="toggle_container" style="display: block;">
    <div class="block" style="font-size:15px;text-decoration:underline;"> SUPPLEMENTARY RESULT(S) </div>
</div> --}}
    <br>

    <table class="print:hidden mb-5" align="center" width="50%">

        {{-- actions --}}
        {{-- <button wire:click="toggleNames()" wire:loading.attr="disabled" wire:loading.class="opacity-50"
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
    </button> --}}
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

</div>
