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
                        @if (auth()->user()->hasRole('User'))
                            <x-nav-link :href="route('dashboard')">
                                <x-icons.dashboard />
                                <span class="ml-3" sidebar-toggle-item>
                                    Dashboard
                                </span>
                            </x-nav-link>

                            <x-nav-link :href="route('sessions.index')">
                                <x-icons.calender-icon />
                                <span class="ml-3" sidebar-toggle-item>
                                    Academic sessions
                                </span>
                            </x-nav-link>

                            <x-nav-link :href="route('carryover.index')">
                                <x-icons.book-open-icon />
                                <span class="ml-3" sidebar-toggle-item>
                                    Carry over
                                </span>
                            </x-nav-link>

                            <x-nav-link :href="route('courses.index')">
                                <x-icons.book-open-icon />
                                <span class="ml-3" sidebar-toggle-item>
                                    Courses
                                </span>
                            </x-nav-link>

                            <x-nav-link :href="route('course-reg.index')">
                                <x-icons.todo-list-icon />
                                <span class="ml-3" sidebar-toggle-item>
                                    Course registrations
                                </span>
                            </x-nav-link>

                            <x-nav-link :href="route('departments.index')">
                                <x-icons.building-icon />
                                <span class="ml-3" sidebar-toggle-item>
                                    Departments
                                </span>
                            </x-nav-link>

                            <x-nav-link :href="route('faculties.index')">
                                <x-icons.building-icon />
                                <span class="ml-3" sidebar-toggle-item>
                                    Faculties
                                </span>
                            </x-nav-link>

                            <x-nav-link :href="route('results.index')">
                                <x-icons.todo-list-icon />
                                <span class="ml-3" sidebar-toggle-item>
                                    Semester results
                                </span>
                            </x-nav-link>

                            <x-nav-link :href="route('scores.index')">
                                <x-icons.todo-list-icon />
                                <span class="ml-3" sidebar-toggle-item>
                                    Score sheets
                                </span>
                            </x-nav-link>

                            <x-nav-link :href="route('students.index')">
                                <x-icons.users-group-icon />
                                <span class="ml-3" sidebar-toggle-item>
                                    Students list
                                </span>
                            </x-nav-link>

                            <x-nav-link :href="route('spillover.index')">
                                <x-icons.book-open-icon />
                                <span class="ml-3" sidebar-toggle-item>
                                    Spill over
                                </span>
                            </x-nav-link>
                        @endif

                        @if (auth()->user()->hasRole('Admin'))
                            <livewire:sidebars.director-sidebar />
                        @endif

                        @if (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super_admin'))
                            <x-nav-link :href="route('users.index')">
                                <x-icons.users-group-icon />
                                <span class="ml-3" sidebar-toggle-item>
                                    Staff list
                                </span>
                            </x-nav-link>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </aside>
</div>
