@props(['dept', 'session', 'level', 'semester'])

<div>
    <div style="width:1500px;margin-left:20%;">
        <div title="logo" style="width:120px;float:left;">
            <img src="{{ url('/') }}/sbyte/logo.jpg" width="100px" height="110px">
        </div>

        <div title="logo" style="width:600px;float:left;text-transform:uppercase;font-weight:bold;line-height:15px;">
            <h2 class="inline-block mb-2 text-3xl font-extrabold tracking-wide text-gray-900 dark:text-white">
                PRINCE
                ABUBAKAR AUDU UNIVERSITY, ANYIGBA</h2>
            <p class="tracking-normal leading-normal2 font-bold text-3xl">
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
            <img src="{{ url('/') }}/sbyte/logo.jpg" width="100px" height="110px">
        </div>
        <br><br><br>
    </div>

    <style type="text/css">
        .pos {
            width: 5.5%
        }

        .mytab tr th {
            font-size: 12px;
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
            /* font-size: 12px;
            font-weight: bold; */
            text-align: center;
        }

        .smallSubj {
            font-size: 10px;
            font-weight: bolder;
        }

        .aggr_unit {
            font-weight: bolder;
            font-size: 12px;
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

    <div class="mt-15 print:mt-12">&nbsp;</div>

    <table align="center" width="90%" class="Tab" border="1">
        <tbody>
            <tr>
                <td class="font-bold print:font-bold" colspan="2" rowspan="2">
                    <p>Academic Session: {{ $session }}/{{ $session + 1 }}</p>
                </td>
                <td class="font-bold print:font-bold" colspan="2" rowspan="2">
                    <p>Level: &nbsp;{{ $level }} </p>
                </td>
                <td class="font-bold print:font-bold" colspan="2" rowspan="2">
                    <p>Semester: &nbsp;{{ $semester }} Semester</p>
                </td>
                <td class="font-bold print:font-bold" colspan="2" rowspan="2">
                    <p>PROGRAMME: &nbsp;Diploma {{ $dept->department }}</p>
                </td>
            </tr>
        </tbody>
    </table>

</div>
