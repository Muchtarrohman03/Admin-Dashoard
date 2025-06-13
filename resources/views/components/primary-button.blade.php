<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-secondary border border-transparent rounded-md font-semibold text-xs text-base-100 uppercase tracking-widest hover:text-secondary  active:bg-accent focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
