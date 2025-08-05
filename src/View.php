<?php

namespace SWD\Core;

use SWD\Core\App;

class View
{
    public App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function render(string $view, array $data = [], $contents = []): void
    {
        $dir = $this->getFolderByName($view);
        (new ViewEngine($this->app->config['folder']['views'], $this->app->config['folder']['cache_views']))->render($view, $data);
        // $layout = $this->getLayout($content, "@extends");
        // dd($layout);
        // (!empty($layout)) ? $this->render($dir, $values, $contents) : print $this->getViewContent($dir, $values, $contents);
    }

    private function getLayout(string $content, string $key): string
    {
        $start = strpos($content, $key);
        if ($start !== false) {
            $start = strpos($content, "(", $start) + 2;
            $end = strpos($content, ")", $start);
            return substr($content, $start, (($end - $start) - 1));
        }
        return "";
    }




    // private function renderContent($content, $values): void
    // {
    //     $chiavi = array_keys($values);
    //     $chiavi = array_map(fn($chiave) => "{{" . $chiave . "}}", $chiavi);
    //     foreach ($values as $key => $value) {
    //         if ($value instanceof Component) {
    //             $values[$key] = $this->renderComponent($value);
    //         }
    //     }
    //     $valori = array_values($values);
    //     print str_replace($chiavi, $valori, $content);
    // }

    public function renderComponent($componente): string
    {
        $nomeComponente = $componente->getName();
        $componentContent = $this->getViewContent("components", $nomeComponente);
        $content = '';
        foreach ($componente->getItems() as $item) {
            $content .= $this->renderContent($componentContent, $item);
        }
        return $content;
    }

    private function getViewContent(string $dir, array $values): string|false
    {
        extract($values);
        $views = $this->getFolderByName($dir);
        ob_start();
        include $views;
        return ob_get_clean();
    }

    private function getFolderByName(string $view): string
    {
        $dir = $this->app->config['folder']['views'];
        $folderArr = explode(".", $view);
        foreach ($folderArr as $f) {
            $dir .= "/{$f}";
        }
        $dir .= ".php";
        return $dir;
    }
}

class ViewEngine
{

    public string $templateDir;
    public string $cacheDir;

    public bool $autoDeleteCache;
    public int $cacheExpiration;
    public bool $enableCache;
    public bool $permanentCache;

    public $layout;
    public $layoutData;
    public $includedViews = [];
    public $sections = [];



    public function __construct(string $templateDir, string $cacheDir)
    {
        $this->templateDir = $templateDir;
        $this->cacheDir = $cacheDir;

        $this->autoDeleteCache = env('VIEW_AUTO_DELETE_CACHE', 'true');
        $this->cacheExpiration = env('VIEW_CACHE_EXPIRATION', '1440');  // 1440 24 hours
        $this->enableCache = true; // env('VIEW_CACHE', 'false');
        $this->permanentCache = env('VIEW_PERMANENT_CACHE', 'true');
    }



    public function extend(string $layout, array $data = []): void
    {
        $this->layout = $layout;
        $this->layoutData = $data;
        $this->render($layout, $data);
    }

    public function section(string $name, string $default = ''): string
    {
        return $this->sections[$name] ?? $default;
    }

    public function startSection()
    {
        ob_start();
    }

    public function endSection(string $name): void
    {
        $this->sections[$name] = ob_get_clean();
    }

    public function include(string $view, array $data = []): string|false
    {
        $includedViewPath = $this->templateDir . '/' . $view . '.php';
        $this->includedViews[$view] = $includedViewPath;

        ob_start();
        extract($data);
        include $includedViewPath;
        return ob_get_clean();
    }







    public function render(string $view, array $data = []): string
    {
        if ($this->enableCache) {
            $cacheFile = $this->getCacheFileName($view);
            if (!$this->isCacheExpired($cacheFile)) return include $cacheFile;
        }

        extract($data);
        ob_start();

        include $this->getTemplateViewByName($view);

        if ($this->layout) {
            $layoutData = array_merge($this->layoutData, $data);
            extract($layoutData);
            include $this->getTemplateViewByName($this->layout);
        }

        $content = ob_get_clean();

        if ($this->enableCache) file_put_contents($cacheFile, $content);

        return $content;
    }


    public function setCacheExpiration($minutes)
    {
        $this->cacheExpiration = $minutes;
    }

    protected function isCacheExpired($cacheFile)
    {
        if ($this->enableCache && file_exists($cacheFile)) {
            if ($this->permanentCache === true) {
                return false;
            }
            $fileTime = filemtime($cacheFile);
            $expirationTime = $fileTime + ($this->cacheExpiration * 60);
            return time() > $expirationTime;
        }

        $this->deleteExpiredCache($cacheFile);
        return true;
    }

    protected function getCacheFileName($view)
    {
        return $this->cacheDir . '/' . md5($view) . '.php';
    }

    public function enableAutoDeleteCache($enable = true)
    {
        $this->autoDeleteCache = $enable;
    }

    public function enablePermanentCache($enable = true)
    {
        $this->permanentCache = $enable;
    }

    protected function deleteExpiredCache($cacheFile)
    {
        if ($this->enableCache && $this->autoDeleteCache) {
            if (file_exists($cacheFile) && $this->isCacheExpired($cacheFile)) {
                unlink($cacheFile);
            }
        }
    }















    private function getTemplateViewByName(string $view): string
    {
        $dir = $this->templateDir;
        $folderArr = explode(".", $view);
        foreach ($folderArr as $f) {
            $dir .= "/{$f}";
        }
        $dir .= ".php";
        return $dir;
    }


    private function searchElements(): void
    {
        while (!($start = strpos($this->content, "@"))) {
            $end = strpos($this->content, "(", $start);
            $keyword = substr($this->content, $start, (($end - $start)));
            dd($keyword);

            $start = strpos($this->content, "(", $start) + 2;
            $end = strpos($this->content, "@end", $start);
            array_push($this->positions, $end);

            //substr($this->content, $start, (($end - $start) - 1));
        }
    }

    public function run(): array
    {
        return [];
    }

    private function search(): string
    {
        $start = strpos($this->content, $this->key);
        if ($start !== false) {
            $start = strpos($this->content, "(", $start) + 2;
            $end = strpos($this->content, "@end{$this->key}", $start);
            return substr($this->content, $start, (($end - $start) - 1));
        }
        return "";
    }
}
