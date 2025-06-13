@props(['disabled' => false])

<textarea @disabled($disabled) {{ $attributes->merge(['class' => ' bg-base-100 text-primary border-gray-300 focus:border-primary 
focus:ring-primary rounded-md shadow-sm']) }}> {{$slot}} </textarea>
