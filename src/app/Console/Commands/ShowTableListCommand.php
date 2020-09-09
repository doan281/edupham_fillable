<?php

namespace Edupham\Fillable\App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use League\Flysystem\FileNotFoundException;

class ShowTableListCommand extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'table:show-list {type?}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Lệnh hiển thị danh sách table';

    /**
     * ShowTableListCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        // param
        $type = $this->argument('type');

        if (empty($type)) {
            $type = 'default';
        } else {
            if (!in_array($type, ['default', 'upper', 'const', 'define'])) {
                $type = $this->choice('Select type ', ['default', 'upper', 'const', 'define']);
            }
        }

        $tables = DB::select('SHOW TABLES');
        if (is_array($tables) && count($tables) > 0) {
            echo "\nTotal tables: " . count($tables) . "\n";
            foreach($tables as $index => $table)
            {
                switch ($type) {
                    case 'default':
                        foreach ($table as $key => $value) {
                            echo ($index + 1) . ". " . $value."\n";
                        }
                        break;
                    case 'upper':
                        foreach ($table as $key => $value) {
                            echo ($index + 1) . ". " . strtoupper($value)."\n";
                        }
                        break;
                    case 'const':
                        // use const in class
                        foreach ($table as $key => $value) {
                            echo 'const TABLE_' . strtoupper($value) . " = '" . $value . "';" . "\n";
                        }
                        break;
                    case 'define':
                        // use define in helper
                        foreach ($table as $key => $value) {
                            echo "define('TABLE_" . strtoupper($value) . "', '" . $value . "');" . "\n";
                        }
                        break;
                    default:
                }
            }
        }
    }
}
