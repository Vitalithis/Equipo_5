<section class="bg-white dark:bg-gray-900">
    <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
        <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">¡Contáctanos!</h2>
        <p class="mb-8 lg:mb-16 font-light text-center text-gray-500 dark:text-gray-400 sm:text-xl">
            ¿Tienes dudas sobre nuestras plantas, productos o servicios? ¡Estamos aquí para ayudarte!
            Escríbenos o visítanos, y con gusto responderemos todas tus consultas.
        </p>
        <form action="<?php echo e(route('contact.send')); ?>" method="POST" class="space-y-8">
            <?php echo csrf_field(); ?>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tu Correo</label>
                <input type="email" id="email" name="email" required
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                    focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5
                    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                    dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light"
                    placeholder="tunombre@correo.cl">
            </div>
            <div>
                <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Asunto</label>
                <input type="text" id="subject" name="subject" required
                    class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm
                    focus:ring-primary-500 focus:border-primary-500
                    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                    dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light"
                    placeholder="Dinos cómo podemos ayudarte">
            </div>
            <div class="sm:col-span-2">
                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Cuerpo</label>
                <textarea id="message" name="message" rows="6" required
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300
                    focus:ring-primary-500 focus:border-primary-500
                    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                    dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Cuéntanos más detalles"></textarea>
            </div>
            <button type="submit"
                class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-primary-700 sm:w-fit
                hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300
                dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                Enviar Mensaje
            </button>
        </form>
    </div>
</section>
<?php /**PATH D:\Code\Equipo_5\resources\views/components/contact.blade.php ENDPATH**/ ?>