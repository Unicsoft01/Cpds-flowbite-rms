<div>
    <p class="text-sm font-bold">Page {{ $pageIndex + 1 }} of
        {{ $studentsChunked->count() }} <span> CPDS-PAAU-Online from Unicsoft Workspace.</span>
    </p>

    <div class="officials text-[14px] font-extrabold">
        <div style="width:400px;float:left;text-transform:uppercase;margin-top:3%;">
            ..............................................<br>{{ $officials->exam_officer ?? null }}<br>Coordinator
        </div>
        <div style="width:400px;float:right;text-transform:uppercase;margin-top:3%;">
            ................................................<br>{{ $officials->hod ?? null }}<br>Director

        </div>
    </div>
</div>
