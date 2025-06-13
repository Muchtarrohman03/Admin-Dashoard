@props(['message'])

<div x-data="{ open: true }" x-show="open" class="alert alert-success">
  <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
  <span class="text-secondary">{{$message ?? "Message Succes"}}</span>

  <button @click="open = false" class="btn btn-circle btn-ghost">
  <svg xmlns="http://www.w3.org/2000/svg" class=" fill-secondary h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
  </button>
</div>