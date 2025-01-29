<div>
    <aside id="sidebar"
        class="fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width"
        aria-label="Sidebar">
        <div
            class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
                <div
                    class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    <ul class="pb-2 space-y-2">

                        <x-nav-link :href="route('students.dashboard')">
                            <x-icons.dashboard />
                            <span class="ml-3" sidebar-toggle-item>
                                Dashboard
                            </span>
                        </x-nav-link>

                        <x-nav-drop-down text="Course registrations">
                            <x-slot:icon>
                                <x-icons.todo-list-icon />
                            </x-slot:icon>

                            <x-nav-drop-down-link linktext="Register new courses" :href="route('student-course-reg.create')" />

                            <x-nav-drop-down-link linktext="Registeration history" :href="route('student-course-reg.index')" />
                        </x-nav-drop-down>
                    </ul>
                </div>
            </div>
        </div>
    </aside>
</div>
