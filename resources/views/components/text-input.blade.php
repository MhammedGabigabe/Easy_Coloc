@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-slate-700 bg-slate-800/50 text-white focus:border-easy-blue focus:ring-easy-blue rounded-xl shadow-sm backdrop-blur-sm']) !!}>