<!-- Open the modal using ID.showModal() method -->
<button onclick="delete_modal_{{ $loop->iteration }}.showModal()" class="btn btn-sm btn-error">
  <svg 
    xmlns="http://www.w3.org/2000/svg"  class="fill-current"
  viewBox="0 0 512 512" 
  width="12" 
  height="12" ><path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
</button>
<dialog id="delete_modal_{{ $index }}" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-secondary text-lg">Peringatan</h3>
    <p class="py-4 text-secondary text-base">Anda yakin akan menghapus data ini?</p>
    <div class="modal-action justify-end">
      <form method="dialog">
        <!-- if there is a button in form, it will close the modal -->
        <button class="btn btn-sm">Batal</button>
      </form>
      <form enctype="multipart/form-data" method="POST" action="{{ route('admin.services.destroy', $service->service_id) }}" >
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-error btn-sm ms-3 text-white">Hapus</button>
      </form>
    </div>
  </div>
</dialog>
