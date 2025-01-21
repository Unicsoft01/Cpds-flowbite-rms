@props([
    'colspan' => 6,
    'message' => 'No records available at the moment, Create or import some!!',
])
<tr>
    <td colspan="{{ $colspan }}"
        class="p-4 text-base text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
        {{ $message }}
    </td>
</tr>
