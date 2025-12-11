@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-2 border-gray-300 p-2 text-base focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>
