<?php $__env->startSection('title', 'Productos || Plantas Editha'); ?>
<?php $__env->startSection('description', 'Nuestra tienda ofrece una amplia variedad de plantas de interior y exterior, ideales para cualquier espacio. Desde suculentas hasta plantas de sombra, tenemos lo que necesitas para embellecer tu hogar o jardín. Además, contamos con un equipo de expertos listos para asesorarte en el cuidado y mantenimiento de tus plantas.'); ?>
<?php $__env->startSection('content'); ?>

<!-- Banner principal -->
<div class="relative w-full h-64 md:h-96 bg-greenPrimary overflow-hidden">
    <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
        <div class="text-center px-4">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">Nuestros Productos</h1>
            <p class="text-xl md:text-2xl text-white max-w-2xl mx-auto">Descubre nuestra selección de plantas para todos los espacios y niveles de cuidado</p>
        </div>
    </div>
    <img src="<?php echo e(asset('/storage/images/banner-productos.jpg')); ?>" alt="Variedad de plantas" class="w-full h-full object-cover">
</div>

<!-- Contenedor principal -->
<div class="container mx-auto px-4 py-12">
    <div class="flex flex-col md:flex-row gap-8">

        <!-- Aside de filtros -->
        <aside class="w-full md:w-1/4 lg:w-1/5">
            <form id='filter-form'>
                
            <div class="bg-white p-6 rounded-lg shadow-md sticky top-4">
                <h2 class="text-xl font-bold text-blueDark mb-6 border-b pb-2">Filtrar Productos</h2>
                <!-- Filtro por categoría -->
                <div class="mb-6">
                    <h3 class="font-semibold text-greenDark mb-2">Categorías</h3>
                    <ul class="space-y-2" id="categorias-container">
                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox"
                                    name="categorias[]"
                                    id="categoria_<?php echo e($categoria->id); ?>"
                                    value="<?php echo e($categoria->nombre); ?>"
                                    class="mr-2 h-4 w-4 text-greenPrimary rounded border-gray-300 focus:ring-greenPrimary transition"
                                    <?php echo e($categoria->selected ? 'checked' : ''); ?>

                                    data-category-id="<?php echo e($categoria->id); ?>">
                                <span class="flex items-center text-blueDark group-hover:text-greenPrimary transition-colors">
                                    <span class="mr-2">•</span>
                                    <?php echo e($categoria->nombre); ?>

                                    
                                </span>
                            </label>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                <!-- Filtro por tamaño -->
                <div class="mb-6">
                    <h3 class="font-semibold text-greenDark mb-2">Tamaño máximo (cm)</h3>
                    <input type="range" id="tamano" name="tamano" min="10" max="200"
                        value="<?php echo e($tamano ?? 200); ?>"
                        class="w-full h-2 bg-greenMid rounded-lg appearance-none cursor-pointer">
                    <div class="flex justify-between text-sm text-blueDark mt-1">
                        <span>10cm</span>
                        <span id="tamanoValue"><?php echo e($tamano ?? 200); ?>cm</span>
                        <span>200cm</span>
                    </div>
                </div>

                <!-- Filtro por dificultad -->
                <div class="mb-6">
                    <h3 class="font-semibold text-greenDark mb-2">Nivel de dificultad</h3>
                    <select name="dificultad" id="dificultad" class="w-full p-2 border border-greenMid rounded-lg text-blueDark">
                        <option value="">Todos los niveles</option>
                        <option value="facil" <?php echo e($dificultad == 'baja' ? 'selected' : ''); ?>>Fácil</option>
                        <option value="intermedia" <?php echo e($dificultad == 'media' ? 'selected' : ''); ?>>Intermedia</option>
                        <option value="experto" <?php echo e($dificultad == 'alta' ? 'selected' : ''); ?>>Experto</option>
                    </select>
                </div>

                <!-- Filtro de orden -->
                <div class="mb-6">
                    <h3 class="font-semibold text-greenDark mb-2">Ordenar por</h3>
                    <select name="filter2" id="filter2" class="w-full p-2 border border-greenMid rounded-lg text-blueDark">
                        <option value="relevancia" <?php echo e($ordenar_por == 'relevancia' ? 'selected' : ''); ?>>Relevancia</option>
                        <option value="precio" <?php echo e($ordenar_por == 'precio' ? 'selected' : ''); ?>>Precio</option>
                        <option value="popularidad" <?php echo e($ordenar_por == 'popularidad' ? 'selected' : ''); ?>>Popularidad</option>
                    </select>
                    <div class="mt-2 flex items-center">
                        <input type="radio" id="ascendente" name="filter3" value="ascendente"
                            <?php echo e($ordenar_ascendente ? 'checked' : ''); ?> class="mr-2">
                        <label for="ascendente" class="text-sm text-blueDark">Ascendente</label>
                        <input type="radio" id="descendente" name="filter3" value="descendente"
                            <?php echo e(!$ordenar_ascendente ? 'checked' : ''); ?> class="ml-4 mr-2">
                        <label for="descendente" class="text-sm text-blueDark">Descendente</label>
                    </div>
                </div>

                <button id="aplicarFiltros" class="w-full py-2 bg-greenPrimary text-white rounded-lg hover:bg-greenDark transition-colors">
                    Aplicar Filtros
                </button>
            </div>
            
            </form>
        </aside>

        <!-- Sección de productos -->
        <div class="w-full md:w-3/4 lg:w-4/5">
            <?php if($productos->count() > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <a href="<?php echo e(route('products.show', $producto->slug)); ?>" class="block">
                        <div class="h-48 overflow-hidden">
                            <img src="<?php echo e(asset('storage/' . $producto->imagen_principal)); ?>"
                                alt="<?php echo e($producto->nombre); ?>"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <h3 class="text-lg font-semibold text-blueDark"><?php echo e($producto->nombre); ?></h3>
                                <span class="text-greenPrimary font-bold"><?php echo e(number_format($producto->precio, 0, ',', '.')); ?> CLP</span>
                            </div>
                            <div class="flex items-center mt-2">
                                <span class="text-sm text-blueDark bg-blueLight px-2 py-1 rounded mr-2">
                                    <?php echo e($producto->nivel_dificultad); ?>

                                </span>
                                <span class="text-sm text-blueDark"><?php echo e($producto->tamano); ?>cm</span>
                            </div>
                            <p class="text-blueDark mt-2 line-clamp-2"><?php echo e($producto->descripcion_corta); ?></p>
                            <button class="mt-4 w-full py-2 bg-greenPrimary text-white rounded-lg hover:bg-greenDark transition-colors">
                                Ver detalles
                            </button>
                        </div>
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Paginación -->
            <div class="mt-8">
                <?php echo e($productos->links()); ?>

            </div>
            <?php else: ?>
            <div class="text-center py-12">
                <h3 class="text-xl font-semibold text-blueDark">No se encontraron productos</h3>
                <p class="text-blueDark mt-2">Intenta ajustar tus filtros de búsqueda</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tamanoSlider = document.getElementById('tamano');
        const tamanoValue = document.getElementById('tamanoValue');
        const aplicarFiltrosBtn = document.getElementById('aplicarFiltros');
        const filterForm = document.getElementById('filter-form'); // Agrega este ID a tu formulario

        if (tamanoSlider && tamanoValue) {
            // Establecer valor inicial
            tamanoValue.textContent = `${tamanoSlider.value}cm`;
            
            // Evento para cambios
            tamanoSlider.addEventListener('input', function() {
                tamanoValue.textContent = `${this.value}cm`;
            });
        }

        if (aplicarFiltrosBtn) {
            aplicarFiltrosBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Crear objeto URLSearchParams para manejar parámetros
                const params = new URLSearchParams();
                
                // Obtener valores de los filtros
                const getFilterValue = (name) => {
                    const element = document.querySelector(`[name="${name}"]`);
                    return element ? element.value : null;
                };
                
                // Agregar filtros solo si tienen valor
                const filters = {
                    tamano: getFilterValue('tamano'),
                    categorias: Array.from(document.querySelectorAll('input[name="categorias[]"]:checked'))
                                .map(input => input.value)
                                .join(','),
                    dificultad: getFilterValue('dificultad'),
                    filter2: getFilterValue('filter2'),
                    filter3: document.querySelector('input[name="filter3"]:checked')?.value
                };
                
                // Construir parámetros de URL
                Object.entries(filters).forEach(([key, value]) => {
                    if (value && value !== 'null') {
                        params.append(key, value);
                    }
                });
                
                // Redireccionar con los filtros aplicados
                const baseUrl = '<?php echo e(route("products.index")); ?>';
                window.location.href = `${baseUrl}?${params.toString()}`;
            });
        }
        
        function restoreFiltersFromUrl() {
            const urlParams = new URLSearchParams(window.location.search);
            
            // Tamaño
            if (urlParams.has('tamano') && tamanoSlider) {
                tamanoSlider.value = urlParams.get('tamano');
                tamanoValue.textContent = `${urlParams.get('tamano')}cm`;
            }
            
            // Categorías
            if (urlParams.has('categorias')) {
                const activeCategories = urlParams.get('categorias').split(',');
                document.querySelectorAll('input[name="categorias[]"]').forEach(checkbox => {
                    checkbox.checked = activeCategories.includes(checkbox.value);
                });
            }
            
            // Otros filtros
            ['dificultad', 'filter2'].forEach(filter => {
                if (urlParams.has(filter)) {
                    const element = document.querySelector(`[name="${filter}"]`);
                    if (element) element.value = urlParams.get(filter);
                }
            });
            
            // Orden dirección
            if (urlParams.has('filter3')) {
                const radio = document.querySelector(`input[name="filter3"][value="${urlParams.get('filter3')}"]`);
                if (radio) radio.checked = true;
            }
        }
        
        // Ejecutar al cargar
        restoreFiltersFromUrl();
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\Equipo_5\resources\views/products/index.blade.php ENDPATH**/ ?>