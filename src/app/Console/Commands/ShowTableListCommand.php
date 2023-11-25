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
    protected $signature = 'table:show-list {type=default} {--order=asc}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Lệnh hiển thị danh sách table và số bản ghi kèm theo';

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
        if(strtolower(DB::getDefaultConnection() === 'mysql')) {
            // param + option
            $type = $this->argument('type');
            $option = $this->option('order');

            if (empty($type)) {
                $type = 'default';
            } else {
                if (!in_array($type, ['default', 'record', 'record', 'upper', 'const', 'define'])) {
                    $type = $this->choice('Select type ', ['default', 'record', 'upper', 'const', 'define']);
                }
            }
            // check param and option
            if ($type == 'record') {
                $dbname = DB::connection()->getDatabaseName();

                $sqlRaw = "SELECT TABLE_NAME, TABLE_ROWS";
                $sqlRaw .= " FROM `information_schema`.`tables`";
                $sqlRaw .= " WHERE `table_schema` = '" . $dbname . "'";
                if ($option == 'desc') {
                    $sqlRaw .= " ORDER BY TABLE_ROWS DESC, TABLE_NAME ASC;";
                }

                $tables = DB::select(DB::raw($sqlRaw));
            } else {
                $tables = DB::select('SHOW TABLES');
            }
            // process result
            if (is_array($tables) && count($tables) > 0) {
                //echo "\nTotal tables: " . count($tables) . "\n";
                $content = PHP_EOL . date('d/m/Y H:i:s') . PHP_EOL;
                foreach ($tables as $index => $table) {
                    switch ($type) {
                        case 'default':
                            foreach ($table as $key => $value) {
                                //echo ($index + 1) . ". " . $value."\n";
                                $content .= ($index + 1) . ". " . $value . "\n";
                            }
                            break;
                        case 'record':
                            $content .= ($index + 1) . ". " . $table->TABLE_NAME . ' (' . number_format($table->TABLE_ROWS) . ')' . "\n";
                            break;
                        case 'upper':
                            foreach ($table as $key => $value) {
                                //echo ($index + 1) . ". " . strtoupper($value)."\n";
                                $content .= ($index + 1) . ". " . strtoupper($value) . "\n";
                            }
                            break;
                        case 'const':
                            // use const in class
                            foreach ($table as $key => $value) {
                                //echo 'const TABLE_' . strtoupper($value) . " = '" . $value . "';" . "\n";
                                $content .= 'const TABLE_' . strtoupper($value) . " = '" . $value . "';" . "\n";
                            }
                            break;
                        case 'define':
                            // use define in helper
                            foreach ($table as $key => $value) {
                                //echo "define('TABLE_" . strtoupper($value) . "', '" . $value . "');" . "\n";
                                $content .= "define('TABLE_" . strtoupper($value) . "', '" . $value . "');" . "\n";
                            }
                            break;
                        default:
                    }
                }
                echo $content;
                echo "\n See more info at: storage/app/public/tables.txt \n";
                // save result to file
                $tables_file = storage_path('app/public/tables.txt');
                $file = @fopen($tables_file, "a") or die("Unable to open file!");
                @fclose($file);
                @file_put_contents($tables_file, $content . PHP_EOL, FILE_APPEND | LOCK_EX);
            }
        } else {
            echo "\n Package only support MySQL/MariaDB\n";
        }
    }
}
