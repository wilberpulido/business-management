<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class SortLangs extends Command
{
    protected $signature = 'lang:sort {locale?}';

    protected $description = 'Ordena alfabéticamente los archivos de traducción sin romper nada';

    public function handle()
    {
        $localeArgument = $this->argument('locale');
        $langPath = base_path('lang');

        // Validamos que la carpeta raíz /lang exista
        if (! File::exists($langPath)) {
            $this->error("La carpeta raíz no existe en: {$langPath}");

            return self::FAILURE;
        }

        // 1. Obtener la lista de carpetas (idiomas)
        if ($localeArgument) {
            $directories = [$langPath.DIRECTORY_SEPARATOR.$localeArgument];
        } else {
            // Esto agarra absolutamente TODAS las subcarpetas de /lang
            $directories = glob($langPath.'/*', GLOB_ONLYDIR);
        }
        Log::debug(var_export($directories, true));

        if (empty($directories)) {
            $this->warn("No se encontraron carpetas de idiomas en {$langPath}");

            return self::SUCCESS;
        }

        foreach ($directories as $directory) {
            $locale = basename($directory);
            $this->warn("\n--- Idioma: [{$locale}] ---");

            // 1. Procesar archivos PHP dentro de la carpeta (ej: lang/es/pricing.php)
            $phpFiles = File::files($directory);
            foreach ($phpFiles as $file) {
                if ($file->getExtension() !== 'php') {
                    continue;
                }
                $this->processPhpFile($file);
            }
        }

        // 2. Procesar archivos JSON en la raíz de /lang (ej: lang/es.json)
        $jsonFiles = File::files($langPath);
        foreach ($jsonFiles as $file) {
            if ($file->getExtension() !== 'json') {
                continue;
            }
            $this->processJsonFile($file);
        }

        $this->newLine();
        $this->info('🚀 ¡Todos los idiomas han sido ordenados!');

        return self::SUCCESS;
    }

    private function processPhpFile($file)
    {
        $translations = require $file->getRealPath();
        if (is_array($translations)) {
            $translations = $this->sortRecursive($translations);
            $content = "<?php\n\nreturn ".$this->renderArray($translations).";\n";
            File::put($file->getRealPath(), $content);
            $this->info("  ✅ PHP: {$file->getFilename()}");
        }
    }

    private function processJsonFile($file)
    {
        $translations = json_decode(File::get($file->getRealPath()), true);
        if (is_array($translations)) {
            $translations = $this->sortRecursive($translations);
            $content = json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            File::put($file->getRealPath(), $content);
            $this->info("  ✅ JSON: {$file->getFilename()}");
        }
    }

    /**
     * Construye el array con formato limpio y moderno
     */
    private function renderArray(array $array, int $indent = 0): string
    {
        $spacer = str_repeat('    ', $indent);
        $innerSpacer = str_repeat('    ', $indent + 1);

        $output = "[\n";

        foreach ($array as $key => $value) {
            $output .= $innerSpacer;

            // Si la clave no es numérica, la escribimos
            if (is_string($key)) {
                $output .= "'{$key}' => ";
            }

            if (is_array($value)) {
                $output .= $this->renderArray($value, $indent + 1).",\n";
            } elseif (is_bool($value)) {
                $output .= ($value ? 'true' : 'false').",\n";
            } elseif (is_numeric($value)) {
                $output .= "{$value},\n";
            } else {
                // Escapamos comillas simples para evitar errores de sintaxis
                $cleanValue = str_replace("'", "\'", $value);
                $output .= "'{$cleanValue}',\n";
            }
        }

        return $output.$spacer.']';
    }

    /**
     * Ordena las claves recursivamente
     */
    private function sortRecursive(array $array): array
    {
        ksort($array);
        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = $this->sortRecursive($value);
            }
        }

        return $array;
    }
}
