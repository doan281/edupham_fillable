<?php

namespace Edupham\Fillable\App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use League\Flysystem\FileNotFoundException;

class ShowTableStructureCommand extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'table:show-structure';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Lệnh hiển thị cấu trúc từng bảng';

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
        if (strtolower(DB::getDefaultConnection() === 'mysql')) {
            // check param and option
            $dbname = DB::connection()->getDatabaseName();
            $tables = $this->getTableList($dbname, null);
            // process result
            if (is_array($tables) && count($tables) > 0) {
                $content = '';
                foreach ($tables as $index => $table) {
                    $table_info = DB::select(DB::raw("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . $dbname . "' AND TABLE_NAME = '" . $table . "';"));
                    //
                    $content .= ($index + 1) . ". " . $table . "||||||||||" . PHP_EOL;
                    $content .= "S/N|";
                    $content .= "Column name|";
                    $content .= "Data type|";
                    $content .= "Length|";
                    $content .= "Column type|";
                    $content .= "Column default|";
                    $content .= "Column key|";
                    $content .= "Extra|";
                    $content .= "Character set name|";
                    $content .= "Collation name|";
                    $content .= "Comment";
                    $content .= PHP_EOL;

                    foreach ($table_info as $key => $field) {
                        $content .= ($key + 1) . "|";
                        $content .= $field->COLUMN_NAME . "|";
                        $content .= $field->DATA_TYPE . "|";
                        $content .= $field->CHARACTER_MAXIMUM_LENGTH . "|";
                        $content .= $field->COLUMN_TYPE . "|";
                        $content .= $field->COLUMN_DEFAULT . "|";
                        $content .= $field->COLUMN_KEY . "|";
                        $content .= $field->EXTRA . "|";
                        $content .= $field->CHARACTER_SET_NAME . "|";
                        $content .= $field->COLLATION_NAME . "|";
                        $content .= $field->COLUMN_COMMENT;
                        $content .= PHP_EOL;
                    }
                }

                echo $content;
                echo PHP_EOL . "See more info at: storage/app/public/table-structure.txt" . PHP_EOL;
                // save result to file
                $tables_file = storage_path('app/public/table-structure.txt');
                $file = @fopen($tables_file, "a") or die("Unable to open file!");
                @fclose($file);
                @file_put_contents($tables_file, $content . PHP_EOL, FILE_APPEND | LOCK_EX);
            }
        } else {
            echo PHP_EOL . "Package only support MySQL/MariaDB" . PHP_EOL;
        }
    }

    /**
     * Get all table by db name
     *
     * @param $dbname
     * @param $options
     * @return array|null
     */
    private function getTableList($dbname, $options = null)
    {
        if ($dbname) {
            $sqlRaw = "SELECT TABLE_NAME";
            $sqlRaw .= " FROM `information_schema`.`tables`";
            $sqlRaw .= " WHERE `table_schema` = '" . $dbname . "'";

            $tables = DB::select(DB::raw($sqlRaw));
            $tables = collect($tables)->map(function ($item) {
                return $item->TABLE_NAME;
            })->all();

            return $tables;
        }
        return null;
    }
}
