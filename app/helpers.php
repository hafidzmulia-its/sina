<?php

if (!function_exists('vite_assets')) {
    function vite_assets() {
        $manifestPath = public_path('build/.vite/manifest.json');
        
        if (!file_exists($manifestPath)) {
            return '';
        }
        
        $manifest = json_decode(file_get_contents($manifestPath), true);
        
        $html = '';
        
        // Add CSS
        if (isset($manifest['resources/css/app.css'])) {
            $cssFile = $manifest['resources/css/app.css']['file'];
            $html .= '<link rel="stylesheet" href="/build/' . $cssFile . '">' . "\n";
        }
        
        // Add JS
        if (isset($manifest['resources/js/app.js'])) {
            $jsFile = $manifest['resources/js/app.js']['file'];
            $html .= '<script type="module" src="/build/' . $jsFile . '"></script>' . "\n";
        }
        
        return $html;
    }
}