
<div id="provisoria-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow p-4 max-w-3xl w-full relative">
        <button id="provisoria-modal-close" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl">✕</button>
        <iframe src="" class="w-full h-96 rounded border" id="provisoria-iframe"></iframe>
    </div>
</div>


<div id="pdf-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow p-4 max-w-3xl w-full relative">
        <button id="pdf-modal-close" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl">✕</button>
        <div id="pdf-modal-content" class="p-4"></div>
    </div>
</div>


<div id="upload-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow p-4 max-w-md w-full relative">
        <button id="upload-modal-close" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl">✕</button>
        <h2 class="text-lg font-bold mb-4 text-eprimary">Subir Boleta SII</h2>
        <form id="upload-form" method="POST" action="" enctype="multipart/form-data" class="space-y-4">
            <?php echo csrf_field(); ?>
            <input type="file" name="boleta" accept="application/pdf" required class="w-full border rounded px-3 py-2">
            <button type="submit"
                class="bg-eaccent hover:bg-eaccent2 text-eprimary font-semibold px-4 py-2 rounded shadow transition w-full">
                Subir Boleta
            </button>
        </form>
    </div>
</div>
<?php /**PATH C:\Users\Vitalithis\Documents\GitHub\Equipo_5\resources\views/pedidos/partials/modals.blade.php ENDPATH**/ ?>