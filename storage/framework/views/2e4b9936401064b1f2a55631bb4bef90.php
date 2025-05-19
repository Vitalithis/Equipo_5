<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hero Section -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap&family=Dancing+Script:wght@400;700&display=swap"
        rel="stylesheet">

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <section class="relative bg-gray-100">
        <div class="w-full h-[70vh] overflow-hidden relative">
            <!-- Slider Wrapper -->
            <div id="slider" class="flex h-full transition-transform duration-700">
                <!-- Slider Position 1 -->
                <div class="w-full flex-shrink-0 flex items-center justify-center">
<<<<<<< Updated upstream
<<<<<<< Updated upstream
                    <img src="<?php echo e(asset('/storage/home/slides/slide1.webp')); ?>" alt="Slide 1"
=======
                    <img src="<?php echo e(asset('/storage/images/slide1.jpg')); ?>" alt="Slide 1"
>>>>>>> Stashed changes
=======
                    <img src="<?php echo e(asset('/storage/images/slide1.jpg')); ?>" alt="Slide 1"
>>>>>>> Stashed changes
                        class="w-full h-full object-cover opacity-70 mix-blend-darken brightness-50">
                </div>

                <!-- Slider Position 2 -->
                <div class="w-full flex-shrink-0 flex items-center justify-center">
<<<<<<< Updated upstream
<<<<<<< Updated upstream
                    <img src="<?php echo e(asset('storage/home/slides/slide-2.webp')); ?>" alt="Slide 2"
=======
                    <img src="<?php echo e(asset('/storage/images/slide2.jpg')); ?>" alt="Slide 2"
>>>>>>> Stashed changes
=======
                    <img src="<?php echo e(asset('/storage/images/slide2.jpg')); ?>" alt="Slide 2"
>>>>>>> Stashed changes
                        class="w-full h-full object-cover opacity-70 mix-blend-darken brightness-50">
                </div>

                <!-- Slider Position 3 -->
                <div class="w-full flex-shrink-0 flex items-center justify-center">
<<<<<<< Updated upstream
<<<<<<< Updated upstream
                    <img src="<?php echo e(asset('storage/home/slides/slide-3.webp')); ?>" alt="Slide 3"
=======
                    <img src="<?php echo e(asset('/storage/images/slide3.jpg')); ?>" alt="Slide 3"
>>>>>>> Stashed changes
=======
                    <img src="<?php echo e(asset('/storage/images/slide3.jpg')); ?>" alt="Slide 3"
>>>>>>> Stashed changes
                        class="w-full h-full object-cover opacity-70 mix-blend-darken brightness-50">
                </div>
            </div>

            <!-- Indicators -->
            <div class="absolute bottom-5 left-1/2 transform -translate-x-1/2 flex space-x-2 z-10" id="indicators">
                <!-- Los íconos se inyectan por JS -->
            </div>
        </div>
    </section>

    <!-- Últimos productos -->
    <section class="bg-gray-50 ">
        <div class="container mx-auto py-20">
            <h2 class="text-2xl font-semibold mb-4 text-eprimary text-center">Últimos Productos agregados</h2>
            <div class="grid grid-cols-4 gap-4">
<<<<<<< Updated upstream
<<<<<<< Updated upstream
                <?php $__currentLoopData = $productos->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white p-4 shadow rounded hover:p-2 hover:shadow-lg transition-all duration-300 hover:bg-eaccent"
                        data-height="<?php echo e($producto->tamano); ?>" data-category="<?php echo e($producto->categoria); ?>">
                        <a href="<?php echo e(route('products.show', $producto->slug)); ?>">
                            <!-- Imagen del producto -->
                            <img src="<?php echo e($producto->imagen); ?>" alt="<?php echo e($producto->nombre); ?>"
                                class="w-full h-40 object-cover mb-4 rounded">
                            <h3 class="font-bold text-eprimary-100 text-xl"><?php echo e($producto->nombre); ?></h3>
                            <p class="text-sm text-gray-600"><?php echo e($producto->dificultad); ?></p>
                            <p class="text-sm text-gray-600"><?php echo e($producto->descripcion); ?></p>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
=======
=======
>>>>>>> Stashed changes
                <?php $__currentLoopData = $productos->sortByDesc('created_at')->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white p-4 shadow rounded hover:p-2 hover:shadow-lg transition-all duration-300 hover:bg-eaccent"
                        data-height="<?php echo e($producto->tamano); ?>" data-category="<?php echo e($producto->categoria); ?>">

                        <a href="<?php echo e(route('products.show', $producto->slug)); ?>">
                            <!-- Imagen del producto -->
                            <img src="/storage/images/default-logo.png" alt="<?php echo e($producto->nombre); ?>"
                                class="w-full h-40 object-cover mb-4 rounded" crossorigin="anonymous">

                            <h3 class="font-bold text-eprimary-100 text-xl"><?php echo e($producto->nombre); ?></h3>

                            <p class="text-sm text-gray-600"><?php echo e(number_format($producto->precio, 0, ',', '.')); ?> CLP</p>

                            <?php if($producto->descripcion): ?>
                                <p class="text-sm text-gray-600"><?php echo e(Str::limit($producto->descripcion, 80)); ?></p>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
            </div>
        </div>
    </section>

    <!--Nuestro Catálogo Reveal on Slide-->
    <section class="bg-eaccent-500 py-16 font-[Poppins] ">
        <div class="container mx-auto px-4 py-16">
            <div class="flex justify-center items-center mb-6 flex-col">
                <h2 class="text-left text-5xl sm:text-6xl lg:text-7xl font-extrabold text-eprimary leading-none  align-text-top -ml-40"
                    data-aos="fade-right" data-aos-duration="1000">
                    Nuestro
                </h2>
                <h2 class="text-right text-3xl sm:text-5xl lg:text-6xl font-thin text-eprimary leading-tight ml-40 mt-5 align-bottom font-[Dancing Script]"
                    data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    Catálogo
                </h2>
            </div>
            <p class="text-center text-gray-600 text-2xl" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                Explora nuestra amplia variedad de plantas.
            </p>
        </div>
    </section>
    <!-- Main Content -->
    <section class="container mx-auto py-8">
        <div class="grid grid-cols-4 gap-4">
            <!-- Sidebar for Filters -->
            <aside class="col-span-1 bg-eaccent2-100 p-4 rounded sticky top-4 self-start">
<<<<<<< Updated upstream
<<<<<<< Updated upstream
                <form  action="<?php echo e(route('products.index')); ?>#product-catalog" method="GET">
=======
                <form action="<?php echo e(route('products.index')); ?>#product-catalog" method="GET">
>>>>>>> Stashed changes
=======
                <form action="<?php echo e(route('products.index')); ?>#product-catalog" method="GET">
>>>>>>> Stashed changes
                    <h2 class="text-xl font-semibold mb-4">Filtrar Plantas</h2>

                    <!-- Tamaño -->
                    <button onclick="toggleAccordion(1)" type="button"
                        class="w-full flex justify-between items-center py-5 text-slate-800">
                        <div class="icon flex items-center gap-2">
                            <?php echo \App\Helpers\SvgHelper::inline('tall-fill', 'fill-eaccent2-9'); ?>

                            <span>Tamaño</span>
                        </div>
                        <span id="icon-1" class="text-slate-800 transition-transform duration-300">
                            <!-- ícono -->
                        </span>
                    </button>
                    <div id="content-1"
                        class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-eaccent2-800">
                        <div class="w-full max-w-md px-4 text-sm text-efore border-b-4 border-green- rounded-sm py-2">
                            <label for="tamano" class="block mb-2 text-sm font-medium text-gray-700">
                                Hasta <span id="valorSeleccionado" class="text-sm font-medium text-gray-800">2</span>
                                metros.
                            </label>
                            <input type="range" id="tamano" name="tamano" min="1" max="20" value="2"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-eaccent2-600"
                                oninput="document.getElementById('valorSeleccionado').textContent = this.value">
                            <div class="flex justify-between text-sm text-gray-600 mt-1 pxr-2">
                                <span>1</span><span>20</span>
                            </div>
                        </div>
                    </div>

                    <!-- Categoría -->
                    <button onclick="toggleAccordion(2)" type="button"
                        class="w-full flex justify-between items-center py-5 text-slate-800">
                        <div class="icon flex items-center gap-2">
                            <?php echo \App\Helpers\SvgHelper::inline('potted-plant-fill', 'fill-eaccent2-9'); ?>

                            <span>Categoría</span>
                        </div>
                        <span id="icon-2" class="text-slate-800 transition-transform duration-300"></span>
                    </button>
                    <div id="content-2"
                        class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-eaccent2-800">
                        <div class="text-sm text-efore border-b-4 border-green- rounded-sm">
                            <ul class="px-4 py-2">
                                <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="flex items-center gap-2 text-base py-1">
                                        <input type="checkbox" id="categoria_<?php echo e($categoria->id); ?>" name="categorias[]"
                                            value="<?php echo e($categoria->id); ?>"
                                            class="rounded-sm border border-gray-300 bg-white checked:border-eprimary-100 checked:bg-eprimary-100">
                                        <label for="categoria_<?php echo e($categoria->id); ?>"><?php echo e($categoria->nombre); ?></label>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Dificultad -->
                    <button onclick="toggleAccordion(3)" type="button"
                        class="w-full flex justify-between items-center py-5 text-slate-800">
                        <div class="icon flex items-center gap-2">
                            <?php echo \App\Helpers\SvgHelper::inline('brain-fill', 'fill-eaccent2-9'); ?>

                            <span>Dificultad</span>
                        </div>
                        <span id="icon-3" class="text-slate-800 transition-transform duration-300"></span>
                    </button>
                    <div id="content-3"
                        class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-eaccent2-800">
                        <div class="text-sm text-efore border-b-4 border-green- rounded-sm">
                            <ul class="px-4 py-2">
                                <?php $__currentLoopData = $productos->unique('nivel_dificultad'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(!empty($producto->nivel_dificultad)): ?>
                                        <li class="flex items-center gap-2 text-base py-1">
                                            <input type="checkbox" id="dificultad_<?php echo e($loop->index); ?>" name="dificultades[]"
                                                value="<?php echo e($producto->nivel_dificultad); ?>"
                                                class="rounded-sm border border-gray-300 bg-white checked:border-eprimary-100 checked:bg-eprimary-100">
                                            <label for="dificultad_<?php echo e($loop->index); ?>"><?php echo e($producto->nivel_dificultad); ?></label>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Ordenar por -->
                    <div class="mb-4">
                        <label for="ordenar_por" class="block mb-2 text-sm text-slate-700">
                            <div class="icon flex items-center gap-2">
                                <?php echo \App\Helpers\SvgHelper::inline('funnel-simple-fill', 'fill-eaccent2-9'); ?>

                                <span>Ordenar por:</span>
                            </div>
                        </label>
                        <select id="ordenar_por" name="ordenar_por"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-eaccent2-100 focus:ring focus:ring-eaccent2-100">
                            <option value="relevancia">Relevancia</option>
                            <option value="precio">Precio</option>
                            <option value="popularidad">Popularidad</option>
                        </select>
                    </div>

                    <!-- Orden ascendente/descendente -->
                    <div class="mb-4">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="ascendente" value="1" class="accent-eaccent2-100">
                            <span class="text-sm text-gray-700">Orden Ascendente</span>
                        </label>
                    </div>

                    <div class="flex justify-center mt-5">
                        <button type="submit"
                            class="bg-eaccent hover:bg-eprimary  text-white px-6 py-2 rounded-full transition-all duration-300">
                            Filtrar
                        </button>
                    </div>
                </form>
            </aside>

            <!-- Product Catalog -->
            <div class="col-span-3 bg-gray-50 p-4 rounded" id="product-catalog">
                <h2 class="text-2xl font-semibold mb-4 text-eprimary">Catálogo de Productos</h2>
                <div class="grid grid-cols-3 gap-4">

                    <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white p-4 shadow rounded hover:p-2 hover:shadow-lg transition-all duration-300 hover:bg-eaccent"
                            data-height="<?php echo e($producto->tamano); ?>" data-category="<?php echo e($producto->categoria); ?>">

                            <a href="<?php echo e(route('products.show', $producto->slug)); ?>">
                                <!-- Imagen del producto -->
<<<<<<< Updated upstream
<<<<<<< Updated upstream
                                <img src="<?php echo e($producto->imagen); ?>" alt="<?php echo e($producto->nombre); ?>"
                                    class="w-full h-40 object-cover mb-4 rounded">
=======
                                <img src="/storage/images/default-logo.png" alt="<?php echo e($producto->nombre); ?>"
                                    class="w-full h-40 object-cover mb-4 rounded" crossorigin="anonymous">
>>>>>>> Stashed changes
=======
                                <img src="/storage/images/default-logo.png" alt="<?php echo e($producto->nombre); ?>"
                                    class="w-full h-40 object-cover mb-4 rounded" crossorigin="anonymous">
>>>>>>> Stashed changes
                                <h3 class="font-bold text-eprimary-100 text-xl"><?php echo e($producto->nombre); ?></h3>
                                <p class="text-sm text-gray-600"><?php echo e($producto->dificultad); ?></p>
                                <p class="text-sm text-gray-600"><?php echo e($producto->descripcion); ?></p>
                            </a>
                        </div>

<<<<<<< Updated upstream
<<<<<<< Updated upstream
                        
=======

>>>>>>> Stashed changes
=======

>>>>>>> Stashed changes

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Paginación -->
                <div class="mt-4">
                    <?php echo e($productos->links()); ?>

                </div>
            </div>

        </div>
    </section>
    <script>
        function toggleAccordion(index) {
            const content = document.getElementById(`content-${index}`);
            const icon = document.getElementById(`icon-${index}`);

            // SVG for Minus icon
            const minusSVG = `
<<<<<<< Updated upstream
<<<<<<< Updated upstream
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                                                                            <path d="M3.75 7.25a.75.75 0 0 0 0 1.5h8.5a.75.75 0 0 0 0-1.5h-8.5Z" />
                                                                                        </svg>
                                                                                        `;

            // SVG for Plus icon
            const plusSVG = `
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                                                                            <path d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
                                                                                        </svg>
                                                                                        `;
=======
=======
>>>>>>> Stashed changes
                                                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                                                                                            <path d="M3.75 7.25a.75.75 0 0 0 0 1.5h8.5a.75.75 0 0 0 0-1.5h-8.5Z" />
                                                                                                        </svg>
                                                                                                        `;

            // SVG for Plus icon
            const plusSVG = `
                                                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4">
                                                                                                            <path d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
                                                                                                        </svg>
                                                                                                        `;
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes

            // Toggle the content's max-height for smooth opening and closing
            if (content.style.maxHeight && content.style.maxHeight !== '0px') {
                content.style.maxHeight = '0';
                icon.innerHTML = plusSVG;
            } else {
                content.style.maxHeight = content.scrollHeight + 'px';
                icon.innerHTML = minusSVG;
            }
        }

        function toggleSortIcon(button) {
            const iconSpan = button.querySelector('.icon');
            const textSpan = button.querySelector('span.text-sm');

            const ascIcon = `<?php echo \App\Helpers\SvgHelper::inline('sort-ascending-fill', 'fill-eaccent2-9'); ?>`;
            const descIcon = `<?php echo \App\Helpers\SvgHelper::inline('sort-descending-fill', 'fill-eaccent2-9'); ?>`;

            const isAscending = iconSpan.innerHTML.includes('sort-ascending-fill');

            iconSpan.innerHTML = isAscending ? descIcon : ascIcon;
            textSpan.textContent = isAscending ? 'Ordenar Descendente' : 'Ordenar Ascendente';
        }
        const slider = document.getElementById('slider');
        const indicatorsContainer = document.getElementById('indicators');
        const slides = slider.children;
        const totalSlides = slides.length;
        let currentIndex = 0;
        let interval;
        const iconActive = `
<<<<<<< Updated upstream
<<<<<<< Updated upstream
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="fill-eaccent2-9 w-5 h-5">
                  <rect width="256" height="256" fill="none"/>
                  <path fill='#AEC68D' d="M200,144h-76.7l22.41-22.41a59.55,59.55,0,0,0,26.1,6.36,49.56,49.56,0,0,0,25.89-7.22c23.72-14.36,36.43-47.6,34-88.92a8,8,0,0,0-7.52-7.52c-41.32-2.43-74.56,10.28-88.93,34-9.35,15.45-9.59,34.11-.86,52L120,124.68l-12.21-12.21c6-13.25,5.57-27-1.39-38.48C95.53,56,70.61,46.41,39.73,48.22a8,8,0,0,0-7.51,7.51C30.4,86.6,40,111.52,58,122.4A38.22,38.22,0,0,0,78,128a45,45,0,0,0,18.52-4.19L108.69,136l-8,8H56a8,8,0,0,0,0,16h9.59L78.8,219.47A15.89,15.89,0,0,0,94.42,232h67.17a15.91,15.91,0,0,0,15.62-12.53L190.42,160H200a8,8,0,0,0,0-16Z"/>
                </svg>
                `;
        const iconInactive = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="fill-eaccent2-9 w-5 h-5">
                  <rect width="256" height="256" fill="none"/>
                  <path  d="M200,144h-76.7l22.41-22.41a59.55,59.55,0,0,0,26.1,6.36,49.56,49.56,0,0,0,25.89-7.22c23.72-14.36,36.43-47.6,34-88.92a8,8,0,0,0-7.52-7.52c-41.32-2.43-74.56,10.28-88.93,34-9.35,15.45-9.59,34.11-.86,52L120,124.68l-12.21-12.21c6-13.25,5.57-27-1.39-38.48C95.53,56,70.61,46.41,39.73,48.22a8,8,0,0,0-7.51,7.51C30.4,86.6,40,111.52,58,122.4A38.22,38.22,0,0,0,78,128a45,45,0,0,0,18.52-4.19L108.69,136l-8,8H56a8,8,0,0,0,0,16h9.59L78.8,219.47A15.89,15.89,0,0,0,94.42,232h67.17a15.91,15.91,0,0,0,15.62-12.53L190.42,160H200a8,8,0,0,0,0-16Z"/>
                </svg>`; // Ícono para slide inactivo
=======
=======
>>>>>>> Stashed changes
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="fill-eaccent2-9 w-5 h-5">
                                  <rect width="256" height="256" fill="none"/>
                                  <path fill='#AEC68D' d="M200,144h-76.7l22.41-22.41a59.55,59.55,0,0,0,26.1,6.36,49.56,49.56,0,0,0,25.89-7.22c23.72-14.36,36.43-47.6,34-88.92a8,8,0,0,0-7.52-7.52c-41.32-2.43-74.56,10.28-88.93,34-9.35,15.45-9.59,34.11-.86,52L120,124.68l-12.21-12.21c6-13.25,5.57-27-1.39-38.48C95.53,56,70.61,46.41,39.73,48.22a8,8,0,0,0-7.51,7.51C30.4,86.6,40,111.52,58,122.4A38.22,38.22,0,0,0,78,128a45,45,0,0,0,18.52-4.19L108.69,136l-8,8H56a8,8,0,0,0,0,16h9.59L78.8,219.47A15.89,15.89,0,0,0,94.42,232h67.17a15.91,15.91,0,0,0,15.62-12.53L190.42,160H200a8,8,0,0,0,0-16Z"/>
                                </svg>
                                `;
        const iconInactive = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="fill-eaccent2-9 w-5 h-5">
                                  <rect width="256" height="256" fill="none"/>
                                  <path  d="M200,144h-76.7l22.41-22.41a59.55,59.55,0,0,0,26.1,6.36,49.56,49.56,0,0,0,25.89-7.22c23.72-14.36,36.43-47.6,34-88.92a8,8,0,0,0-7.52-7.52c-41.32-2.43-74.56,10.28-88.93,34-9.35,15.45-9.59,34.11-.86,52L120,124.68l-12.21-12.21c6-13.25,5.57-27-1.39-38.48C95.53,56,70.61,46.41,39.73,48.22a8,8,0,0,0-7.51,7.51C30.4,86.6,40,111.52,58,122.4A38.22,38.22,0,0,0,78,128a45,45,0,0,0,18.52-4.19L108.69,136l-8,8H56a8,8,0,0,0,0,16h9.59L78.8,219.47A15.89,15.89,0,0,0,94.42,232h67.17a15.91,15.91,0,0,0,15.62-12.53L190.42,160H200a8,8,0,0,0,0-16Z"/>
                                </svg>`; // Ícono para slide inactivo
<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes

        // Crear indicadores
        for (let i = 0; i < totalSlides; i++) {
            const dot = document.createElement('button');
            dot.classList.add('text-2xl', 'transition-transform', 'duration-300');
            dot.innerHTML = i === 0 ? iconActive : iconInactive;
            dot.dataset.index = i;
            dot.addEventListener('click', () => {
                clearInterval(interval); // si hace click, detenemos el auto slide
                goToSlide(i);
            });
            indicatorsContainer.appendChild(dot);
        }

        function updateIndicators(index) {
            Array.from(indicatorsContainer.children).forEach((dot, i) => {
                dot.innerHTML = i === index ? iconActive : iconInactive;
            });
        }

        function goToSlide(index) {
            slider.style.transform = `translateX(-${index * 100}%)`;
            currentIndex = index;
            updateIndicators(index);
        }

        function nextSlide() {
            const nextIndex = (currentIndex + 1) % totalSlides;
            goToSlide(nextIndex);
        }

        // Iniciar auto slide
        interval = setInterval(nextSlide, 4000); // cambia cada 4s
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Vitalithis\Documents\GitHub\Equipo_5\resources\views/home.blade.php ENDPATH**/ ?>