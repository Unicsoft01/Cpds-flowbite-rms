<span>

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

    <x-nav-link :href="route('carryover.result')">
        <x-icons.book-open-icon />
        <span class="ml-3" sidebar-toggle-item>
            Carry over results
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

</span>
