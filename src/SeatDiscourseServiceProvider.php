<?php

namespace Herpaderpaldent\Seat\SeatDiscourse;

use Herpaderpaldent\Seat\SeatDiscourse\Commands\SyncRolesWithDiscourse;
use Herpaderpaldent\Seat\SeatDiscourse\Observers\RefreshTokenObserver;
use Seat\Services\AbstractSeatPlugin;
use Seat\Eveapi\Models\RefreshToken;

class SeatDiscourseServiceProvider extends AbstractSeatPlugin
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->addCommands();
        $this->addRoutes();
        $this->addViews();

        RefreshToken::observe(RefreshTokenObserver::class);

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/seatdiscourse.sidebar.php', 'package.sidebar');
        $this->mergeConfigFrom(__DIR__ . '/config/seatdiscourse.config.php', 'seatdiscourse.config');

    }

    /**
     * Return an URI to a CHANGELOG.md file or an API path which will be providing changelog history.
     *
     * @return string|null
     */
    public function getChangelogUri(): ?string
    {

        return 'https://raw.githubusercontent.com/herpaderpaldent/seat-discourse/master/CHANGELOG.md';
    }

    /**
     * Return the plugin public name as it should be displayed into settings.
     *
     * @example SeAT Web
     *
     * @return string
     */
    public function getName(): string
    {

        return 'seat-discourse';
    }

    /**
     * Return the plugin repository address.
     *
     * @example https://github.com/eveseat/web
     *
     * @return string
     */
    public function getPackageRepositoryUrl(): string
    {

        return 'https://github.com/herpaderpaldent/seat-discourse';
    }

    /**
     * Return the plugin technical name as published on package manager.
     *
     * @example web
     *
     * @return string
     */
    public function getPackagistPackageName(): string
    {

        return 'seat-discourse';
    }

    /**
     * Return the plugin vendor tag as published on package manager.
     *
     * @example eveseat
     *
     * @return string
     */
    public function getPackagistVendorName(): string
    {

        return 'herpaderpaldent';
    }

    /**
     * Return the plugin installed version.
     *
     * @return string
     */
    public function getVersion(): string
    {
        return config('seatdiscourse.config.version');
    }

    private function addCommands()
    {

        $this->commands([
            SyncRolesWithDiscourse::class,
        ]);

    }

    private function addViews()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'seatdiscourse');
    }

    private function addRoutes()
    {
        if (! $this->app->routesAreCached()) {
            include __DIR__ . '/Http/routes.php';
        }
    }
}
