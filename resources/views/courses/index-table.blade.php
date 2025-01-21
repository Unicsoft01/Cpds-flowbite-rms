<div>
    <div
        class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">

                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                    Your students
                </h1>
            </div>
            <div class="flex flex-col">
                <div class="overflow-x-auto overflow-y-auto md:max-h-[500px] 2xl:max-h-fit">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden shadow">
                            <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-all" aria-describedby="checkbox-1" type="checkbox"
                                                    class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-all" class="sr-only">checkbox</label>
                                            </div>
                                        </th>
                                        <th scope="col"
                                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                            <div class="flex items-center">
                                                S/N
                                            </div>
                                        </th>
                                        <th scope="col"
                                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 cursor-pointer"
                                            wire:click="setSortBy('course_title')">
                                            <span class="flex">
                                                Course Title
                                            </span>
                                        </th>

                                        <th scope="col"
                                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 cursor-pointer"
                                            wire:click="setSortBy('course_code')">
                                            <span class="flex">
                                                Course code
                                            </span>
                                        </th>

                                        <th scope="col"
                                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 cursor-pointer"
                                            wire:click="setSortBy('unit')">
                                            <span class="flex">
                                                unit
                                            </span>
                                        </th>

                                        <th scope="col"
                                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                            Level
                                        </th>

                                        <th scope="col"
                                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                            Semester
                                        </th>

                                        <th scope="col"
                                            class="p-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                            Status
                                        </th>

                                        <th scope="col"
                                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                            Active Status
                                        </th>
                                        <th scope="col"
                                            class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    <tr
                                        class="hover:bg-gray-100 dark:hover:bg-gray-700 @if ($this->indicateChecked($course->course_id)) bg-blue-300 hover:bg-gray-200 dark:hover:bg-gray-900 dark:bg-blue-900 @endif">
                                        <td class="w-4 p-4">
                                            <div class="flex items-center">
                                                <input type="checkbox"
                                                    class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="{{ $course->course_id }}" class="sr-only">checkbox</label>
                                            </div>
                                        </td>
                                        <td
                                            class="w-4 p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center">
                                                1
                                            </div>
                                        </td>
                                        <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                            <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                <div class="text-base font-semibold text-gray-900 dark:text-white">
                                                    Lorem ipsum dolor sit amet consectetur adipisicing.
                                                </div>
                                                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                    Created Lorem, ipsum.</div>
                                            </div>
                                        </td>

                                        <td
                                            class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center">
                                                lorem
                                            </div>
                                        </td>

                                        <td
                                            class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center">
                                                lorem
                                            </div>
                                        </td>

                                        <td
                                            class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center">
                                                lorem
                                            </div>
                                        </td>

                                        <td
                                            class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center">
                                                lorem Sem.
                                            </div>
                                        </td>

                                        <td
                                            class="p-2 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center">
                                                lorem
                                            </div>
                                        </td>

                                        <td
                                            class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center">
                                                <div class="h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></div>
                                                Active
                                            </div>
                                        </td>
                                        <td class="p-4 space-x-2 whitespace-nowrap">
                                            <button
                                                class="px-5 py-2 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 sm:w-auto dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition ease-in-out duration-150">
                                                Lorem, ipsum dolor.
                                            </button>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
