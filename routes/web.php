    <?php

    use App\Http\Controllers\ProfileController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\CategoriaController;
    use App\Http\Controllers\ProductoController;
    use App\Http\Controllers\DescuentoController;
    use App\Http\Controllers\HomeController;

    use App\Http\Controllers\LoginController;
    use App\Http\Controllers\UserController;

    use App\Http\Controllers\CartController;
    use App\Http\Controllers\PedidoController;
    use App\Http\Controllers\BoletaController;
    use App\Http\Controllers\ProveedorController;


    use App\Http\Controllers\WebpayController;
    use App\Http\Controllers\CheckoutController;

    use App\Http\Controllers\RoleController;
    use App\Http\Controllers\UserRoleController;
    use App\Http\Controllers\PermissionController;


    use App\Http\Controllers\TreatmentController;
    use App\Http\Controllers\TreatmentApplicationController;
    use App\Http\Controllers\TransportController;
use App\Http\Controllers\FertilizanteController;
use App\Http\Controllers\OrdenProduccionController;
use App\Http\Controllers\CuidadoController;
use App\Http\Controllers\FinanzaController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\FertilizationController;
use App\Http\Controllers\ProductionController;


use App\Models\ProductCategory;

use App\Http\Controllers\AdminClienteController;
use App\Http\Controllers\ClienteController;

use App\Http\Controllers\WorkController;
use App\Http\Controllers\ThemeController;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\SimpleCalendarController;

use App\Http\Controllers\MaintenanceReportController;

use App\Http\Controllers\ContactController;

//Ruta de prueba
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\UserDevice;
/////////////
use Illuminate\Support\Facades\Mail;
use App\Mail\StockBajo;
use App\Models\Producto;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::get('/test-mail', function () {
    $user = new \App\Models\User([
        'name' => 'Prueba',
        'email' => 'scarrascos@ing.ucsc.cl'
    ]);

    \Mail::to($user->email)->send(new \App\Mail\ClienteCreado($user));

    return 'Correo de prueba enviado.';
});




Route::post('/device', function (Request $request) {
    if (auth()->check() && $request->player_id) {
        UserDevice::updateOrCreate(
            ['player_id' => $request->player_id],
            ['user_id' => auth()->id()]
        );
    }
    return response()->noContent();
});



Route::get('/notificacion-prueba', function () {
    $playerId = 'AQUÍ_TU_PLAYER_ID'; // ← pega aquí el que viste en consola

    $response = Http::withHeaders([
        'Authorization' => 'Basic ' . env('ONESIGNAL_REST_API_KEY'),
        'Content-Type'  => 'application/json',
    ])->post('https://onesignal.com/api/v1/notifications', [
        'app_id' => env('ONESIGNAL_APP_ID'),
        'include_player_ids' => [$playerId],
        'headings' => ['en' => '🎉 Notificación de prueba'],
        'contents' => ['en' => 'Hola, esto es un mensaje enviado desde Laravel'],
    ]);

    return $response->json();
});


//////////////

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index']);
// theme
Route::middleware(['auth'])->group(function () {
    Route::get('/preferencias', [ThemeController::class, 'index'])->name('preferences.index');
    Route::put('/preferencias', [ThemeController::class, 'update'])->name('theme.update');

    // Solución: usar POST para evitar colisión con DELETE
    Route::post('/preferencias/eliminar-logo', [ThemeController::class, 'removeLogo'])->name('theme.remove.logo');
    Route::post('/preferencias/eliminar-perfil', [ThemeController::class, 'removeProfile'])->name('theme.remove.profile');
});
Route::middleware(['auth', 'tenant', 'permission:ver dashboard'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/api/finanzas/ingresos-egresos', [HomeController::class, 'ingresosEgresosPorMes']);
    Route::get('/api/ventas/por-dia', [HomeController::class, 'ventasPorDia']);
    Route::get('/api/ventas/por-semana', [HomeController::class, 'ventasPorSemana']);
    Route::get('/api/ventas/por-mes', [HomeController::class, 'ventasPorMes']);
    Route::get('/api/ventas/ultimos-6-meses', [HomeController::class, 'ventasUltimos6Meses']);
    Route::get('/api/ventas/mes-vs-anterior', [HomeController::class, 'ventasMesVsAnterior']);
    Route::get('/api/ventas/ultimos-3-meses', [HomeController::class, 'ventasUltimos3Meses']);
});
// calendario simple de siembra y trasplante
Route::middleware(['auth'])->prefix('simple-calendar')->group(function () {
    Route::get('/', [SimpleCalendarController::class, 'index'])->name('simple_calendar.index');
    Route::get('/crear', [SimpleCalendarController::class, 'create'])->name('simple_calendar.create');
    Route::post('/', [SimpleCalendarController::class, 'store'])->name('simple_calendar.store');
});

// alertas de trasplante para mostrar en dashboard
Route::get('/alertas-transplante', [SimpleCalendarController::class, 'alertasTransplante'])->middleware('auth');


Route::middleware(['web', 'auth', 'tenant'])->group(function () {

    // Rutas protegidas por "ver dashboard"
    Route::middleware(['permission:ver dashboard'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
        Route::get('/api/finanzas/ingresos-egresos', [HomeController::class, 'ingresosEgresosPorMes']);
        Route::get('/api/ventas/por-dia', [HomeController::class, 'ventasPorDia']);
    });

    // Gestión de usuarios
    Route::get('/usuarios', [UserRoleController::class, 'index'])->middleware('permission:gestionar usuarios')->name('users.index');
    Route::put('/usuarios/{user}/asignar-rol', [UserRoleController::class, 'updateRole'])->middleware('permission:gestionar usuarios')->name('users.updateRole');

    // Gestión de roles
    Route::get('/roles', [RoleController::class, 'index'])->middleware('permission:ver roles')->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->middleware('permission:crear roles')->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->middleware('permission:crear roles')->name('roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->middleware('permission:editar roles')->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->middleware('permission:editar roles')->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->middleware('permission:eliminar roles')->name('roles.destroy');
});


//Mails


    use App\Http\Controllers\DeviceController;


use App\Http\Controllers\NotificationTestController;



    Route::middleware(['auth', 'tenant', 'permission:gestionar permisos'])->group(function () {
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
        Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    });


    Route::middleware(['auth', 'tenant', 'permission:ver dashboard'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
        Route::get('/api/finanzas/ingresos-egresos', [HomeController::class, 'ingresosEgresosPorMes']);
        Route::get('/api/ventas/por-dia', [HomeController::class, 'ventasPorDia']);

        // 👉 Esta línea es la clave
        Route::get('/ingresos', [FinanzaController::class, 'index'])->name('ingresos');
    });


    Route::middleware(['auth', 'tenant', 'permission:gestionar egresos'])->group(function () {
        Route::get('/egresos', [FinanzaController::class, 'index'])->name('egresos.index');
    });




Route::get('dashboard.catalogo', [ProductoController::class, 'dashboard_show'])
    ->middleware(['auth', 'tenant', 'permission:gestionar catálogo'])
    ->name('dashboard.catalogo');
Route::get('/dashboard/catalogo/create', [ProductoController::class, 'create'])->middleware('permission:gestionar catálogo')->name('catalogo.create');
Route::post('/dashboard/catalogo', [ProductoController::class, 'store'])->middleware('permission:gestionar catálogo')->name('catalogo.store');
Route::get('/dashboard/catalogo/{id}/edit', [ProductoController::class, 'edit'])->middleware('permission:gestionar catálogo')->name('catalogo_edit');
Route::put('/dashboard/catalogo/{id}', [ProductoController::class, 'update'])->middleware('permission:gestionar catálogo')->name('catalogo.update');
Route::delete('/dashboard/catalogo/{id}', [ProductoController::class, 'destroy'])->middleware('permission:gestionar catálogo')->name('catalogo.destroy');
Route::post('/dashboard/catalogo/{id}/merma', [ProductoController::class, 'registrarMerma'])->middleware('permission:gestionar catálogo')->name('catalogo.merma');
Route::get('/dashboard/catalogo/mermas', [ProductoController::class, 'verMermas'])->middleware('permission:gestionar catálogo')->name('catalogo.mermas');

Route::get('/dashboard/descuentos', [DescuentoController::class, 'mostrarTodos'])->middleware(['auth', 'permission:gestionar descuentos'])->name('dashboard.descuentos');
Route::get('dashboard/descuentos/create', [DescuentoController::class, 'create'])->middleware('permission:gestionar descuentos')->name('descuentos.create');
Route::post('/dashboard/descuentos', [DescuentoController::class, 'store'])->middleware('permission:gestionar descuentos')->name('descuentos.store');
Route::get('/dashboard/descuentos/{id}/edit', [DescuentoController::class, 'edit'])->middleware('permission:gestionar descuentos')->name('descuentos_edit');
Route::put('/dashboard/descuentos/{id}', [DescuentoController::class, 'update'])->middleware('permission:gestionar descuentos')->name('descuentos.update');
Route::delete('/dashboard/descuentos/{id}', [DescuentoController::class, 'destroy'])->middleware('permission:gestionar descuentos')->name('descuentos.destroy');


Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');




Route::middleware(['auth'])->group(function () {
    Route::post('/device', [DeviceController::class, 'store'])->name('device.store');
});


Route::get('/notificaciones', function () {
    return view('push.notificaciones');
})->middleware(['auth']);

    //Mail

    Route::get('/probar-mailgun', function () {
        Mail::to('scarrascos@ing.ucsc.cl')->send(new PruebaMailgun());
        return 'Correo enviado';
    });
    Route::put('/pedidos/{pedido}/estado', [PedidoController::class, 'actualizarEstado'])->name('pedidos.actualizarEstado');


    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/', [HomeController::class, 'index']);

    Route::middleware(['auth', 'tenant', 'permission:ver dashboard'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

        Route::get('/usuarios', [UserRoleController::class, 'index'])->middleware('permission:gestionar usuarios')->name('users.index');
        Route::put('/usuarios/{user}/asignar-rol', [UserRoleController::class, 'updateRole'])->middleware('permission:gestionar usuarios')->name('users.updateRole');

        Route::get('/roles', [RoleController::class, 'index'])->middleware('permission:ver roles')->name('roles.index');
        Route::get('/roles/create', [RoleController::class, 'create'])->middleware('permission:crear roles')->name('roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->middleware('permission:crear roles')->name('roles.store');
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->middleware('permission:editar roles')->name('roles.edit');
        Route::put('/roles/{role}', [RoleController::class, 'update'])->middleware('permission:editar roles')->name('roles.update');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->middleware('permission:eliminar roles')->name('roles.destroy');
    });




        Route::middleware(['auth', 'tenant', 'permission:gestionar permisos'])->group(function () {
            Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
            Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
            Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
            Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
            Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
            Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
        });


        Route::middleware(['auth', 'tenant', 'permission:gestionar ingresos'])->group(function () {
            Route::get('/ingresos', [IngresoController::class, 'index'])->name('ingresos.index');
        });

        Route::middleware(['auth', 'tenant', 'permission:gestionar egresos'])->group(function () {
            Route::get('/egresos', [EgresoController::class, 'index'])->name('egresos.index');
        });

    //Ruta tratamientos

    Route::prefix('dashboard')->middleware(['auth', 'permission:gestionar tratamientos'])->group(function () {
        Route::get('/treatments', [TreatmentController::class, 'index'])->name('dashboard.treatments');
        Route::get('/treatments/create', [TreatmentController::class, 'create'])->name('dashboard.treatments.create');
        Route::post('/treatments', [TreatmentController::class, 'store'])->name('dashboard.treatments.store');
        Route::get('/treatments/{id}/edit', [TreatmentController::class, 'edit'])->name('dashboard.treatments.edit');
        Route::put('/treatments/{id}', [TreatmentController::class, 'update'])->name('dashboard.treatments.update');
        Route::delete('/treatments/{id}', [TreatmentController::class, 'destroy'])->name('dashboard.treatments.destroy');

        Route::get('/treatment-applications/search', [TreatmentApplicationController::class, 'search'])->name('treatment_applications.search');
        Route::get('/plant-treatments/search', [TreatmentController::class, 'search'])->name('plant_treatments.search');


        Route::get('/treatment-applications', [TreatmentApplicationController::class, 'index'])->name('treatment_applications.index');
        Route::get('/treatment-applications/create', [TreatmentApplicationController::class, 'create'])->name('treatment_applications.create');
        Route::post('/treatment-applications', [TreatmentApplicationController::class, 'store'])->name('treatment_applications.store');
    });

    //Transporte

    Route::prefix('dashboard')->middleware(['auth'])->group(function () {
        Route::resource('transports', TransportController::class)->names('dashboard.transports');
    });


    Route::get('dashboard.catalogo', [ProductoController::class, 'dashboard_show'])
        ->middleware(['auth', 'tenant', 'permission:gestionar catálogo'])
        ->name('dashboard.catalogo');
    Route::get('/dashboard/catalogo/create', [ProductoController::class, 'create'])->middleware('permission:gestionar catálogo')->name('catalogo.create');
    Route::post('/dashboard/catalogo', [ProductoController::class, 'store'])->middleware('permission:gestionar catálogo')->name('catalogo.store');
    Route::get('/dashboard/catalogo/{id}/edit', [ProductoController::class, 'edit'])->middleware('permission:gestionar catálogo')->name('catalogo_edit');
    Route::put('/dashboard/catalogo/{id}', [ProductoController::class, 'update'])->middleware('permission:gestionar catálogo')->name('catalogo.update');
    Route::delete('/dashboard/catalogo/{id}', [ProductoController::class, 'destroy'])->middleware('permission:gestionar catálogo')->name('catalogo.destroy');

    Route::get('/dashboard/descuentos', [DescuentoController::class, 'mostrarTodos'])->middleware(['auth', 'permission:gestionar descuentos'])->name('dashboard.descuentos');
    Route::get('dashboard/descuentos/create', [DescuentoController::class, 'create'])->middleware('permission:gestionar descuentos')->name('descuentos.create');
    Route::post('/dashboard/descuentos', [DescuentoController::class, 'store'])->middleware('permission:gestionar descuentos')->name('descuentos.store');
    Route::get('/dashboard/descuentos/{id}/edit', [DescuentoController::class, 'edit'])->middleware('permission:gestionar descuentos')->name('descuentos_edit');
    Route::put('/dashboard/descuentos/{id}', [DescuentoController::class, 'update'])->middleware('permission:gestionar descuentos')->name('descuentos.update');
    Route::delete('/dashboard/descuentos/{id}', [DescuentoController::class, 'destroy'])->middleware('permission:gestionar descuentos')->name('descuentos.destroy');
    // Ruta Formulario Contacto

    Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');


    // Ruta para el mantenedor de mantenimientos de infraestructura

    Route::middleware(['auth'])->group(function () {
        Route::resource('maintenance', MaintenanceReportController::class);
    });





    Route::middleware(['auth', 'tenant'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::middleware(['auth', 'verified'])->group(function () {
        //Pedidos,
        Route::resource('pedidos', PedidoController::class);
        Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');

        // Boletas
        Route::get('/boletas/{pedido}/provisoria', [BoletaController::class, 'generar'])->name('boletas.provisoria');
        Route::get('/boletas/{pedido}/pdf', [BoletaController::class, 'generarPDF'])->name('boletas.pdf');
        Route::post('/boletas/{pedido}/subir', [BoletaController::class, 'guardar'])->name('boletas.subir');
        Route::get('/boletas/{pedido}/provisoria', [BoletaController::class, 'generarProvisoria'])->name('boletas.provisoria');


    });

    Route::resource('proveedores', ProveedorController::class)->parameters(['proveedores' => 'proveedor'])->middleware('permission:gestionar proveedores');
    // check a esto
    Route::get('/boletas/{pedido}/provisoria', [BoletaController::class, 'generar'])->name('boletas.provisoria');
    Route::get('/boletas/{pedido}/pdf', [BoletaController::class, 'generarPDF'])->name('boletas.pdf');
    Route::post('/boletas/{pedido}/subir', [BoletaController::class, 'guardar'])->name('boletas.subir');
    Route::get('/boletas/{pedido}/provisoria', [BoletaController::class, 'generarProvisoria'])->name('boletas.provisoria');
    Route::resource('proveedores', ProveedorController::class)->parameters(['proveedores' => 'proveedor'])->middleware('permission:gestionar proveedores');

    Route::middleware(['auth', 'tenant'])->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/agregar', [CartController::class, 'agregarProducto'])->name('cart.agregar');
        Route::post('/cart/actualizar/{id}', [CartController::class, 'actualizarProducto'])->name('cart.actualizar');

        // Eliminar producto del carrito (sesión)
        Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove.solo');
        Route::post('/cart/add/{id}', [CartController::class, 'añadirCarrito'])->name('cart.add');
        Route::post('/cart/guardar', [CartController::class, 'guardarCarrito'])->name('cart.guardar');
        Route::get('/cart/obtener', [CartController::class, 'obtenerCarrito'])->name('cart.obtener');
        Route::post('/cart/vaciar', [CartController::class, 'vaciarCarrito'])->name('cart.vaciar');
        Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

        // Vaciar carrito en base de datos
        Route::delete('/cart/vaciar', [CartController::class, 'vaciarCarrito'])->name('cart.vaciar');

        // Ajax para agregar producto al carrito
        Route::post('/cart/ajax/agregar/{id}', [CartController::class, 'ajaxAñadirCarrito'])->name('cart.ajaxAdd');
    });

    Route::middleware(['auth', 'tenant'])->group(function () {
        Route::get('/pagar', [WebpayController::class, 'pagar'])->name('webpay.pagar');
        Route::post('/respuesta', [WebpayController::class, 'respuesta'])->name('webpay.respuesta');
    });
    //rutas de checkout
    Route::middleware(['auth'])->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
        Route::get('/checkout/response', [CheckoutController::class, 'response'])->name('checkout.response');
        Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
        Route::post('/checkout/clear', [CheckoutController::class, 'clearCart'])->name('checkout.clearCart');
    });

    // Cotizaciones
    use App\Http\Controllers\CotizacionController;

    Route::middleware(['auth'])->group(function () {
        Route::get('/cotizacion', [CotizacionController::class, 'index'])->name('cotizacion.index');
        Route::post('/cotizacion/agregar/{producto}', [CotizacionController::class, 'agregar'])->name('cotizacion.agregar');
        Route::delete('/cotizacion/{cotizacion}/producto/{producto}', [CotizacionController::class, 'eliminarProducto'])->name('cotizacion.eliminar');
        Route::post('/cotizaciones/{id}/enviar', [CotizacionController::class, 'enviarCotizacion'])->name('cotizacion.enviar');
        Route::post('/cotizacion/ajax/agregar/{id}', [App\Http\Controllers\CotizacionController::class, 'ajaxAgregar'])->middleware('auth');
    });
    // Ajax para agregar producto al carrito
    Route::post('/cart/ajax/agregar/{id}', [CartController::class, 'ajaxAñadirCarrito'])->name('cart.ajaxAdd');


    // Cotizaciones admin
    use App\Http\Controllers\Admin\CotizacionAdminController;

    Route::prefix('dashboard')->middleware(['auth', 'can:ver dashboard'])->group(function () {
        Route::get('/cotizaciones', [CotizacionAdminController::class, 'index'])->name('dashboard.cotizaciones.index');
        Route::get('/cotizaciones/{id}', [CotizacionAdminController::class, 'show'])->name('dashboard.cotizaciones.show');
        Route::post('/cotizaciones/{id}/responder', [CotizacionAdminController::class, 'responder'])->name('dashboard.cotizaciones.responder');
    });



    Route::put('/cart/update/{id}', [CartController::class, 'actualizarProducto'])->name('cart.update');
    Route::post('/cart/aplicar-descuento', [CartController::class, 'aplicarDescuento'])->name('cart.aplicar-descuento');

// Productos
Route::get('/producto/{slug}', [ProductoController::class, 'show'])->name('products.show');
Route::get('/productos', [ProductoController::class, 'home'])->name('products.index');
Route::get('/productos/categoria/{category}', [ProductoController::class, 'filterByCategory'])
    ->name('producto.filterByCategory');
Route::get(
    '/productos/filtrar/{category?}/{tamano?}/{dificultad?}/{ordenar_por?}/{ordenar_ascendente?}',
    [ProductoController::class, 'filter']
)
    ->where([
        'tamano' => '\d+',
        'ordenar_ascendente' => 'true|false'
    ])
    ->name('productos.filter');
//Categorias
Route::prefix('dashboard/categorias')->name('categorias.')->controller(CategoriaController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::get('/add', 'add')->name('add');
    Route::get('/{categoria}/edit', 'edit')->name('edit');
    Route::put('/{categoria}', 'update')->name('update');
    Route::delete('/{categoria}', 'destroy')->name('destroy');
});

    Route::get('/dashboard/fertilizantes', [FertilizanteController::class, 'mostrarTodos'])->middleware(['auth', 'permission:gestionar productos'])->name('dashboard.fertilizantes');
    Route::get('/dashboard/fertilizantes/create', [FertilizanteController::class, 'create'])->middleware('permission:gestionar productos')->name('fertilizantes.create');
    Route::post('/dashboard/fertilizantes', [FertilizanteController::class, 'store'])->middleware('permission:gestionar productos')->name('fertilizantes.store');
    Route::get('/dashboard/fertilizantes/{id}/edit', [FertilizanteController::class, 'edit'])->middleware('permission:gestionar productos')->name('fertilizantes.edit');
    Route::put('/dashboard/fertilizantes/{id}', [FertilizanteController::class, 'update'])->middleware('permission:gestionar productos')->name('fertilizantes.update');
    Route::delete('/dashboard/fertilizantes/{id}', [FertilizanteController::class, 'destroy'])->middleware('permission:gestionar productos')->name('fertilizantes.destroy');



    //Rutas para cuidados de cada Planta

    Route::prefix('dashboard')->middleware(['auth'])->group(function () {
        Route::get('/cuidados', [CuidadoController::class, 'index'])->name('dashboard.cuidados');
        Route::get('/cuidados/create', [CuidadoController::class, 'create'])->name('dashboard.cuidados.create');
        Route::post('/cuidados', [CuidadoController::class, 'store'])->name('dashboard.cuidados.store');
        Route::get('/cuidados/{id}/edit', [CuidadoController::class, 'edit'])->name('dashboard.cuidados.edit');
        Route::put('/cuidados/{id}', [CuidadoController::class, 'update'])->name('dashboard.cuidados.update');
        Route::delete('/cuidados/{id}', [CuidadoController::class, 'destroy'])->name('dashboard.cuidados.destroy');
        Route::get('/dashboard/cuidados/{id}/pdf', [CuidadoController::class, 'generarPdf'])->name('dashboard.cuidados.pdf');

        //QR
        Route::get('/cuidados/{id}/qr', [CuidadoController::class, 'mostrarQr'])->name('dashboard.cuidados.qr');
        Route::get('/cuidados/{id}/pdf', [CuidadoController::class, 'generarPdf'])->name('dashboard.cuidados.pdf');

    });



// Rutas para el mantenedor de finanzas
Route::prefix('finanzas')->middleware(['auth'])->group(function () {
    Route::get('/', [FinanzaController::class, 'index'])->name('dashboard.finanzas');
    Route::get('/crear', [FinanzaController::class, 'create'])->name('finanzas.create');
    Route::post('/', [FinanzaController::class, 'store'])->name('finanzas.store');
    Route::get('/{id}/editar', [FinanzaController::class, 'edit'])->name('finanzas.edit');
    Route::put('/{id}', [FinanzaController::class, 'update'])->name('finanzas.update');
    Route::delete('/{id}', [FinanzaController::class, 'destroy'])->name('finanzas.destroy');
    Route::get('/finanzas/pdf', [FinanzaController::class, 'exportarPDF'])->name('finanzas.exportarPDF');
    Route::post('/reportar-ventas', [FinanzaController::class, 'guardarReporteVentas'])->name('finanzas.reportar');
    Route::get('/ventas/pdf', [FinanzaController::class, 'exportarVentasMensualesPDF'])->name('finanzas.ventas.pdf');


    });
    //ruta tareas
    Route::resource('works', WorkController::class);

    //Rutas para el mantenedor de insumos
    Route::middleware(['auth', 'tenant'])->prefix('insumos')->group(function () {
        Route::get('/', [InsumoController::class, 'index'])->name('dashboard.insumos');
        Route::get('/crear', [InsumoController::class, 'create'])->name('insumos.create');
        Route::post('/', [InsumoController::class, 'store'])->name('insumos.store');
        Route::get('/{id}/editar', [InsumoController::class, 'edit'])->name('insumos.edit');
        Route::put('/{id}', [InsumoController::class, 'update'])->name('insumos.update');
        Route::delete('/{id}', [InsumoController::class, 'destroy'])->name('insumos.destroy');
    });

    // Ruta de mis compras
    Route::middleware(['auth'])->get('/mis-compras', [PedidoController::class, 'misCompras'])->name('compras.index');

    // ruta de fertilizacion
    Route::middleware(['auth'])->group(function () {
        Route::get('/fertilizantes/{id}', [FertilizanteController::class, 'show'])->name('fertilizantes.show');

        Route::get('/fertilizations/create', [FertilizationController::class, 'create'])->name('fertilizations.create');
        Route::post('/fertilizations', [FertilizationController::class, 'store'])->name('fertilizations.store');
        Route::get('/fertilizaciones/historial', [FertilizationController::class, 'historial'])->name('fertilizations.historial');
    });
    //ruta para crear usuarios
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('can:gestionar usuarios');
    Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('can:gestionar usuarios');
    //ruta para primer log
    use App\Http\Controllers\PasswordController;

    Route::get('/password/change', [PasswordController::class, 'showChangeForm'])->name('password.change.form')->middleware('auth');
    Route::post('/password/change', [PasswordController::class, 'change'])->name('password.change')->middleware('auth');
    // Listado de usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');

Route::get('/usuarios/frecuentes', [UserController::class, 'frecuentes'])->name('users.frequent');

Route::post('/usuarios/descuento', [UserController::class, 'asignarDescuento'])->name('users.setDiscount');


// Actualización directa del estado de tareas
Route::patch('/works/{work}/status', [WorkController::class, 'updateStatus'])->name('works.updateStatus');
Route::resource('works', WorkController::class);

    Route::middleware(['auth', 'tenant', 'permission:gestionar clientes'])->group(function () {
        Route::get('/clientes', [ClientController::class, 'index'])->name('clients.index');
        Route::get('/clientes/crear', [ClientController::class, 'create'])->name('clients.create');
        Route::post('/clientes', [ClientController::class, 'store'])->name('clients.store');
    });
    Route::patch('/clientes/{cliente}/toggle', [ClientController::class, 'toggleActivo'])->name('clients.toggle');

    // Legal
    Route::view('/politicas-de-privacidad', 'politicas')->name('politicas');
    Route::view('/terminos-y-condiciones', 'terminos')->name('terminos');

//Reportar
Route::get('/finanzas/reportar', function () {
    return view('dashboard.finance.create');
})->middleware('auth')->name('finanzas.reportar');

// web.php
Route::get('/api/ventas/resumen', [PedidoController::class, 'resumenMensual'])
    ->middleware('auth');

// Rutas produccion
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('/produccion', [ProductionController::class, 'index'])->name('produccion.index');
    Route::get('/produccion/create', [ProductionController::class, 'create'])->name('produccion.create');
    Route::post('/produccion', [ProductionController::class, 'producir'])->name('produccion.store');

    Route::get('/produccion/{id}/edit', [ProductionController::class, 'edit'])->name('produccion.edit');
    Route::put('/produccion/{id}', [ProductionController::class, 'update'])->name('produccion.update');
    Route::delete('/produccion/{id}', [ProductionController::class, 'destroy'])->name('produccion.destroy');
    Route::post('/dashboard/produccion/mermas', [ProductionController::class, 'registrarMerma'])
    ->name('produccion.mermas.store');

});


Route::get('/debug-tenant', function () {
    return response()->json([
        'tenant' => tenant()?->id,
        'host' => request()->getHost(),
        'user' => auth()->user()?->email,
        'permissions' => auth()->user()?->getAllPermissions()->pluck('name'),
    ]);
})->middleware(['web', 'auth', 'tenant']);
//rutas soporte

// Ruta especial solo para el dominio principal
Route::domain('plantaseditha.me')->middleware(['web', 'auth', 'permission:ver dashboard'])->group(function () {
    Route::get('/', function () {
        return view('soporte.dashboard');
    })->name('soporte.dashboard');
    // ... otras rutas solo para el dominio principal ...
});

// Ruta /dashboard accesible desde cualquier tenant/subdominio
Route::middleware(['web', 'auth', 'permission:ver dashboard'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    // ... otras rutas protegidas ...
});

require __DIR__ . '/auth.php';

