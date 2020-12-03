<?php

namespace AwemaPL\Printer;

use AwemaPL\Printer\Sections\Settings\Models\Setting;
use AwemaPL\Printer\Sections\Settings\Repositories\Contracts\SettingRepository;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use AwemaPL\Printer\Contracts\Printer as PrinterContract;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class Printer implements PrinterContract
{
    /** @var Router $router */
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Routes
     */
    public function routes()
    {
        if ($this->isActiveRoutes()) {
            if ($this->isActiveInstallationRoutes() && !$this->isMigrated()) {
                $this->installationRoutes();
            }
            if ($this->isActiveSettingRoutes()) {
                $this->settingRoutes();
            }
            if ($this->isActivePrinterRoutes()) {
                $this->printerRoutes();
            }
            if ($this->isActiveNodeprinterRoutes()) {
                $this->nodeprinterRoutes();
            }
        }
    }

    /**
     * Installation routes
     */
    protected function installationRoutes()
    {
        $prefix = config('printer.routes.installation.prefix');
        $namePrefix = config('printer.routes.installation.name_prefix');
        $this->router->prefix($prefix)->name($namePrefix)->group(function () {
            $this->router
                ->get('/', '\AwemaPL\Printer\Sections\Installations\Http\Controllers\InstallationController@index')
                ->name('index');
            $this->router->post('/', '\AwemaPL\Printer\Sections\Installations\Http\Controllers\InstallationController@store')
                ->name('store');
        });

    }

    /**
     * Setting routes
     */
    protected function settingRoutes()
    {
        $prefix = config('printer.routes.setting.prefix');
        $namePrefix = config('printer.routes.setting.name_prefix');
        $middleware = config('printer.routes.setting.middleware');
        $this->router->prefix($prefix)->name($namePrefix)->middleware($middleware)->group(function () {
            $this->router
                ->get('/', '\AwemaPL\Printer\Sections\Settings\Http\Controllers\SettingController@index')
                ->name('index');
            $this->router
                ->get('/applications', '\AwemaPL\Printer\Sections\Settings\Http\Controllers\SettingController@scope')
                ->name('scope');
            $this->router
                ->patch('{id?}', '\AwemaPL\Printer\Sections\Settings\Http\Controllers\SettingController@update')
                ->name('update');
        });
    }


    /**
     * Printer routes
     */
    protected function printerRoutes()
    {
        $prefix = config('printer.routes.printer.prefix');
        $namePrefix = config('printer.routes.printer.name_prefix');
        $middleware = config('printer.routes.printer.middleware');
        $this->router->prefix($prefix)->name($namePrefix)->middleware($middleware)->group(function () {
            $this->router
                ->get('/', '\AwemaPL\Printer\Sections\Printers\Http\Controllers\PrinterController@index')
                ->name('index');
            $this->router
                ->get('/printers', '\AwemaPL\Printer\Sections\Printers\Http\Controllers\PrinterController@scope')
                ->name('scope');
        });
    }

    /**
     * Nodeprinter routes
     */
    protected function nodeprinterRoutes()
    {
        $prefix = config('printer.routes.nodeprinter.prefix');
        $namePrefix = config('printer.routes.nodeprinter.name_prefix');
        $middleware = config('printer.routes.nodeprinter.middleware');
        $this->router->prefix($prefix)->name($namePrefix)->middleware($middleware)->group(function () {
            $this->router
                ->get('/', '\AwemaPL\Printer\Sections\Nodeprinters\Http\Controllers\NodeprinterController@index')
                ->name('index');
            $this->router
                ->get('/select', '\AwemaPL\Printer\Sections\Nodeprinters\Http\Controllers\NodeprinterController@select')
                ->name('select');
            $this->router
                ->post('/test/{id?}', '\AwemaPL\Printer\Sections\Nodeprinters\Http\Controllers\NodeprinterController@test')
                ->name('test');
            $this->router
                ->post('/', '\AwemaPL\Printer\Sections\Nodeprinters\Http\Controllers\NodeprinterController@store')
                ->name('store');
            $this->router
                ->get('/printers', '\AwemaPL\Printer\Sections\Nodeprinters\Http\Controllers\NodeprinterController@scope')
                ->name('scope');
            $this->router
                ->patch('{id?}', '\AwemaPL\Printer\Sections\Nodeprinters\Http\Controllers\NodeprinterController@update')
                ->name('update');
            $this->router
                ->delete('{id?}', '\AwemaPL\Printer\Sections\Nodeprinters\Http\Controllers\NodeprinterController@destroy')
                ->name('destroy');
        });
    }

    /**
     * Can installation
     *
     * @return bool
     */
    public function canInstallation()
    {
        $canForPermission = $this->canInstallForPermission();
        return $this->isActiveRoutes()
            && $this->isActiveInstallationRoutes()
            && $canForPermission
            && !$this->isMigrated();
    }

    /**
     * Is migrated
     *
     * @return bool
     */
    public function isMigrated()
    {
        $tablesInDb = array_map('reset', \DB::select('SHOW TABLES'));

        $tables = array_values(config('printer.database.tables'));
        foreach ($tables as $table){
            if (!in_array($table, $tablesInDb)){
                return false;
            }
        }
        return true;
    }

    /**
     * Is active routes
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public function isActiveRoutes()
    {
        return config('printer.routes.active');
    }

    /**
     * Is active setting routes
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public function isActiveSettingRoutes()
    {
        return config('printer.routes.setting.active');
    }

    /**
     * Is active installation routes
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private function isActiveInstallationRoutes()
    {
        return config('printer.routes.installation.active');
    }

    /**
     * Is active printer routes
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private function isActivePrinterRoutes()
    {
        return config('printer.routes.printer.active');
    }

    /**
     * Is active nodeprinter routes
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private function isActiveNodeprinterRoutes()
    {
        return config('printer.routes.nodeprinter.active');
    }

    /**
     * Include lang JS
     */
    public function includeLangJs()
    {
        $lang = config('indigo-layout.frontend.lang', []);
        $lang = array_merge_recursive($lang, app(\Illuminate\Contracts\Translation\Translator::class)->get('printer::js')?:[]);
        app('config')->set('indigo-layout.frontend.lang', $lang);
    }

    /**
     * Can install for permission
     *
     * @return bool
     */
    private function canInstallForPermission()
    {
        $userClass = config('auth.providers.users.model');
        if (!method_exists($userClass, 'hasRole')) {
            return true;
        }

        if ($user = request()->user() ?? null){
            return $user->can(config('printer.installation.auto_redirect.permission'));
        }

        return false;
    }

    /**
     * Menu merge in navigation
     */
    public function menuMerge()
    {
        if ($this->canMergeMenu()){
            $printerMenu = config('printer-menu.navs', []);
            $navTemp = config('temp_navigation.navs', []);
            $nav = array_merge_recursive($navTemp, $printerMenu);
            config(['temp_navigation.navs' => $nav]);
        }
    }

    /**
     * Can merge menu
     *
     * @return boolean
     */
    private function canMergeMenu()
    {
        return !!config('printer-menu.merge_to_navigation') && self::isMigrated();
    }

    /**
     * Execute package migrations
     */
    public function migrate()
    {
         Artisan::call('migrate', ['--force' => true, '--path'=>'vendor/awema-pl/module-printer/database/migrations']);
    }

    /**
     * Install package
     *
     * @param array $data
     */
    public function install(array $data)
    {
        $this->migrate();
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
    }

    /**
     * Add permissions for module permission
     */
    public function mergePermissions()
    {
       if ($this->canMergePermissions()){
           $printerPermissions = config('printer.permissions');
           $tempPermissions = config('temp_permission.permissions', []);
           $permissions = array_merge_recursive($tempPermissions, $printerPermissions);
           config(['temp_permission.permissions' => $permissions]);
       }
    }

    /**
     * Can merge permissions
     *
     * @return boolean
     */
    private function canMergePermissions()
    {
        return !!config('printer.merge_permissions');
    }
}
