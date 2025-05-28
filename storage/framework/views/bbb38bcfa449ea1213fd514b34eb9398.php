<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <!-- Tailwind + Vite -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>


</head>
<body class="font-sans antialiased bg-efore dark:bg-gray-900">
    <div class="min-h-screen flex flex-col">
        <?php echo $__env->make('layouts.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Page Heading -->
        <?php if(isset($header)): ?>
            <header class="bg-efore dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <?php echo e($header); ?>

                </div>
            </header>
        <?php endif; ?>

        <!-- Page Content -->
        <main class="flex-1 container mx-auto px-4 py-8 bg-efore">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <!-- Optional Footer -->
        
    </div>
<!---------
    <footer class="bg-gray-100 text-gray-700 mt-12 border-t">
        <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-4 gap-8 text-sm">

            Empresa
            <div>
                <h3 class="text-lg font-semibold text-eprimary mb-3">Nuestra empresa</h3>
                <ul class="space-y-2">
                    <li><a href="/sobre-nosotros" class="hover:underline">Sobre nosotros</a></li>
                    <li><a href="/contacto" class="hover:underline">Contáctanos</a></li>
                    <li><a href="/preguntas-frecuentes" class="hover:underline">Preguntas frecuentes</a></li>
                    <li><a href="/blog" class="hover:underline">Blog</a></li>
                </ul>
            </div>

            Ayuda
            <div>
                <h3 class="text-lg font-semibold text-eprimary mb-3">Atención al cliente</h3>
                <ul class="space-y-2">
                    <li><a href="/politicas/envio" class="hover:underline">Política de envío</a></li>
                    <li><a href="/politicas/devolucion" class="hover:underline">Política de devoluciones</a></li>
                    <li><a href="/terminos-condiciones" class="hover:underline">Términos y condiciones</a></li>
                    <li><a href="/politica-privacidad" class="hover:underline">Política de privacidad</a></li>
                </ul>
            </div>

            Categorías
            <div>
                <h3 class="text-lg font-semibold text-eprimary mb-3">Categorías</h3>
                <ul class="space-y-2">
                    <li><a href="/productos/interior" class="hover:underline">Plantas de interior</a></li>
                    <li><a href="/productos/exterior" class="hover:underline">Plantas de exterior</a></li>
                    <li><a href="/productos/maceteros" class="hover:underline">Maceteros</a></li>
                    <li><a href="/productos/accesorios" class="hover:underline">Accesorios</a></li>
                </ul>
            </div>

            Contacto -
            <div>
                <h3 class="text-lg font-semibold text-eprimary mb-3">Contáctanos</h3>
                <ul class="space-y-2">
                    <li>Email: <a href="mailto:contacto@ejemplo.cl" class="hover:underline">contacto@plantaseditha.cl</a></li>
                    <li>Teléfono: <a href="tel:+56912345678" class="hover:underline">+56 9 1234 5678</a></li>
                    <li>Dirección: San Pedro de la Paz, Chile</li>
                    <li class="flex space-x-3 mt-2">
                        <a href="#" class="hover:text-eaccent" aria-label="Facebook">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M..." /></svg>
                        </a>
                        <a href="#" class="hover:text-eaccent" aria-label="Instagram">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M..." /></svg>
                        </a>
                        <a href="#" class="hover:text-eaccent" aria-label="WhatsApp">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M..." /></svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>-->

        <div class="text-center text-xs text-gray-500 py-4 border-t">
            © <?php echo e(date('Y')); ?> Plantas Editha. Todos los derechos reservados.
        </div>
    </footer>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\resources\views/layouts/app.blade.php ENDPATH**/ ?>