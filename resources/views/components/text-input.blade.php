@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all duration-200 disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed']) }}>
