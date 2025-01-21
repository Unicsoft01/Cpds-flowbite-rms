<div class="flex flex-col">
    <div class="overflow-x-auto overflow-y-auto md:max-h-[500px] 2xl:max-h-fit">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow">
                <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                    {{ $slot }}
                </table>
            </div>
        </div>
    </div>
</div>
