<?php

namespace App\Providers;

use App\Model\Cart;
use App\Model\Domain;
use App\Model\Module;
use App\Model\ModuleConfig;
use App\Model\Page;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Builder;
use mysql_xdevapi\Collection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //serve per il db locale del wamp può essere eliminato
        Builder::defaultStringLength(191);

        //funzione custom per formattare il prezzo
        \Blade::directive('money', function ($amount)
        {
            return "<?php echo '€' . number_format($amount, 2,',','.'); ?>";
        });

        //i moduli presenti
        view()->share('cms_modules',Module::all());

        //la configurazione del sito web
        $website_config = $this->getWebsiteConfig();
        \Config::set('website_config', $website_config);
        view()->share('website_config',$website_config);

        //le lingue del sito web
        $langs = explode(",",$website_config->get('lingue'));
        //per i controller
        \Config::set('langs', $langs);
        //per le viste
        view()->share('langs',$langs);

        //le pagine statiche del sito web
        $pages = Page::all()->sortBy('order');
        view()->share('pages',$pages);

        //il carrello
        if(\Auth::check())
        {
            $user = \Auth::getUser();
            $carts = Cart::where('user_id',$user->id)->get();
        }
        else
        {
            $session_id = session()->getId();
            $carts = Cart::where('session_id',$session_id)->get();
        }
        view()->share('carts',$carts);

        //i domini/alias del sito web
        $domains = Domain::all();
        view()->share('domains',$domains);
    }

    protected function getWebsiteConfig()
    {
        $websiteModule = Module::where('nome','website')->first();
        $moduleConfigs = ModuleConfig::where('module_id',$websiteModule->id)->get();
        $website_config = [];
        foreach ($moduleConfigs as $config)
        {
            $website_config[$config->nome] = $config->value;
        }
        return collect($website_config);
    }
}
