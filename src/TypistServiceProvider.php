<?php

namespace Awcodes\Typist;

use Awcodes\Typist\Testing\TestsTypist;
use BladeUI\Icons\Factory;
use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Contracts\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TypistServiceProvider extends PackageServiceProvider
{
    public static string $name = 'typist';

    public static string $viewNamespace = 'typist';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasViews()
            ->hasTranslations()
            ->hasConfigFile()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('awcodes/typist');
            });
    }

    public function packageRegistered(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/typist-icons.php', 'typist-icons');

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('typist-icons', []);

            $factory->add('typist', array_merge(['path' => __DIR__ . '/../resources/svg'], $config));
        });

        $this->app->singleton(TypistManager::class, function () {
            return new TypistManager();
        });
    }

    public function packageBooted(): void
    {
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/typist/{$file->getFilename()}"),
                ], 'typist-stubs');
            }
        }

        app(TypistManager::class)
            ->registerActionPath(
                path: __DIR__ . '/Actions',
                namespace: 'Awcodes\\Typist\\Actions'
            );

        Blade::directive('typist', fn ($expression) => "<?php echo typist({$expression})->toHtml(); ?>");

        Testable::mixin(new TestsTypist());
    }

    protected function getAssetPackageName(): ?string
    {
        return 'awcodes/typist';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            AlpineComponent::make('typist', __DIR__ . '/../resources/dist/typist.js'),
            Css::make('typist-styles', __DIR__ . '/../resources/dist/typist.css'),
        ];
    }
}
