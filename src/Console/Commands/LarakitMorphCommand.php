<?php

namespace Larakit\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Larakit\Helpers\HelperText;
use Larakit\LangManager;
use Larakit\Morph\Morph;

class LarakitMorphCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larakit:morph';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Генерация ключей моделей для модуля morph';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $ret = [];
        foreach (get_declared_classes() as $class) {
            if (is_subclass_of($class, Model::class)) {
                Morph::registerModelClass($class);
            }
        }
        foreach (Morph::$model_classes as $model_class) {
            $key       = md5($model_class);
            $ret[$key] = $model_class;
        }
        $file = base_path('config/larakit-morph.php');
        file_put_contents($file, '<?php' . PHP_EOL . 'return ' . var_export($ret, true) . ';');
        $this->info('Сгенерирован morph-конфиг для ' . HelperText::plural_with_number(count($ret), ' модель', ' модели', 'моделей'));
    }

}
