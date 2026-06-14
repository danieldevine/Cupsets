<?php

namespace Coderjerk\Cupsets;

use Tempest\View\Renderers\TempestViewRenderer;
use Tempest\View\ViewCache;
use Tempest\View\ViewConfig;
use function Tempest\View\view;

class Views
{
    public static function config(): ViewConfig
    {
        return new ViewConfig()->addViewComponents(
            dirname(__DIR__, 1) . '/components/x-foot.view.php',
            dirname(__DIR__, 1) . '/components/x-head.view.php',
            dirname(__DIR__, 1) . '/components/x-layout.view.php',
            dirname(__DIR__, 1) . '/components/x-titlebar.view.php',
        );
    }

    public static function renderer(): TempestViewRenderer
    {
        $viewCache = ViewCache::create();
        $viewCache->clear();

        return TempestViewRenderer::make(
            self::config(),
        );
    }

    public static function render(string $view, array $data = []): string
    {
        $view_dir = dirname(__DIR__, 1) . '/views/';
        $view_file = $view_dir . $view . '.view.php';

        return self::renderer()->render(view($view_file, data: $data));
    }
}
