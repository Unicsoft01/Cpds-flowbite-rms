@script
    <script>
        $wire.on('swal', (event) => {
            const data = event
            Swal.fire({
                title: data[0]['title'],
                text: data[0]['message'],
                icon: data[0]['icon'],
                // confirmButtonClass: 'btn btn-success w-sm mt-2',
                customClass: {
                    // popup: "!bg-white !dark:bg-gray-500",
                    confirmButton: "px-5 py-2 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 sm:w-auto dark:bg-blue-600 dark:hover:bg-blue-700 transition ease-in-out duration-150",
                },
                buttonsStyling: false,
                showCloseButton: false
            })
        });

        // delete comfirm only
        $wire.on('delete-prompt', (event) => {
            const data = event
            // console.log(data.id);
            Swal.fire({
                title: 'Confirm Delete?',
                text: 'Are you sure you want to delete this record? This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                // cancelButtonClass: 'btn btn-success w-sm mt-2',
                // confirmButtonClass: 'btn btn-danger w-sm mt-2',
                confirmButtonText: 'Confirm Delete!',
                cancelButtonColor: 'crimson',

                // buttonsStyling: false,
                customClass: {
                    confirmButton: "px-5 py-2 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 sm:w-auto dark:bg-blue-600 dark:hover:bg-blue-700 transition ease-in-out duration-150",
                    cancelButton: "px-5 py-2 text-base font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 sm:w-auto dark:bg-red-600 dark:hover:bg-red-700 transition ease-in-out duration-150",
                },
                buttonsStyling: false,
                // showCloseButton: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch('Confirm-Delete', {
                        id: data.id
                    })
                }
            })
        });


        // export comfirm only
        $wire.on('export-prompt', (event) => {
            const data = event
            // console.log(data.id);
            Swal.fire({
                title: 'Confirm File Export?',
                text: 'You are about to export selected records, are you sure your want to proceed to Export?',
                icon: 'question',
                showCancelButton: true,
                // cancelButtonClass: 'btn btn-success w-sm mt-2',
                // confirmButtonClass: 'btn btn-danger w-sm mt-2',
                confirmButtonText: 'Proceed!',
                cancelButtonColor: 'crimson',

                // buttonsStyling: false,
                customClass: {
                    confirmButton: "px-5 py-2 text-base font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 sm:w-auto dark:bg-green-600 dark:hover:bg-green-700 transition ease-in-out duration-150",
                    cancelButton: "px-5 py-2 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 sm:w-auto dark:bg-blue-600 dark:hover:bg-blue-700 transition ease-in-out duration-150",
                },
                buttonsStyling: false,
                // showCloseButton: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch('Confirm-Export')
                }
            })
        });


        // Delete multiple comfirm only
        $wire.on('delete-multiple-prompt', (event) => {
            const data = event
            // console.log(data.id);
            Swal.fire({
                title: 'Confirm Delete?',
                text: 'Are you sure you want to delete this records? This action cannot be undone and any record associated with the selected records will be deleted permanently!',
                icon: 'question',
                showCancelButton: true,
                // cancelButtonClass: 'btn btn-success w-sm mt-2',
                // confirmButtonClass: 'btn btn-danger w-sm mt-2',
                confirmButtonText: 'Confirm Delete!',
                cancelButtonColor: 'crimson',

                // buttonsStyling: false,
                customClass: {
                    confirmButton: "px-5 py-2 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 sm:w-auto dark:bg-blue-600 dark:hover:bg-blue-700 transition ease-in-out duration-150",
                    cancelButton: "px-5 py-2 text-base font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 sm:w-auto dark:bg-red-600 dark:hover:bg-red-700 transition ease-in-out duration-150",
                },
                buttonsStyling: false,
                // showCloseButton: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch('Confirm-Multiple-Delete')
                }
            })
        });

        // Release selected results confirmation
        $wire.on('release-results-prompt', (event) => {

            const count = event.count ?? 0;

            // No students selected
            if (count < 1) {
                Swal.fire({
                    title: 'No Students Selected',
                    text: 'Please select one or more students before releasing results.',
                    icon: 'warning',

                    customClass: {
                        confirmButton: "px-5 py-2 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700 transition ease-in-out duration-150",
                    },

                    buttonsStyling: false
                });

                return;
            }

            Swal.fire({
                title: 'Release Selected Results?',

                html: `
            <div class="text-left">
                <p class="mb-3">
                    You are about to release results for
                    <strong>${count} selected student${count > 1 ? 's' : ''}</strong>.
                </p>

                <p class="mb-3">
                    Once released, the selected students will be able to view
                    their results from their student portal.
                </p>

                <p class="font-semibold text-red-600">
                    Please ensure that all scores, grades and result details
                    are correct before proceeding.
                </p>
            </div>
        `,

                icon: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Yes, Release Results',
                cancelButtonText: 'Cancel',

                reverseButtons: true,

                customClass: {
                    confirmButton: "px-5 py-2 text-base font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 dark:bg-green-600 dark:hover:bg-green-700 transition ease-in-out duration-150",

                    cancelButton: "px-5 py-2 text-base font-medium text-center text-white bg-gray-600 rounded-lg hover:bg-gray-700 dark:bg-gray-600 dark:hover:bg-gray-700 transition ease-in-out duration-150 mr-2",
                },

                buttonsStyling: false,

            }).then((result) => {

                if (result.isConfirmed) {

                    $wire.dispatch('Confirm-Release-Results');

                }

            });
        });
    </script>
@endscript
