<?php

namespace Edupham\Fillable\App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class ShowTableFieldCommand extends Command
{
    /**
     * The name and signature of the console command.     *
     * @var string
     */
    protected $signature = 'table:show-field {table_name?}';

    /**
     * The console command description.     *
     * @var string
     */
    protected $description = 'Lệnh hiển thị danh sách field của table';

    /**
     * ShowTableFieldCommand constructor.
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
        $tableName = $this->argument('table_name');

        if(empty($tableName)){
            $tableName = $this->ask('What is table name?');
        }

        echo $tableName.": ";
        $content = PHP_EOL . date('d/m/Y H:i:s') . PHP_EOL;

        /* Lay danh sach field */
        $columns = Schema::getColumnListing($tableName);

        /* In field theo hang ngang */
        echo "\n";
        //echo json_encode(is_array($columns) ? $columns : []);
        $content .= json_encode(is_array($columns) ? $columns : []) . PHP_EOL;

        //echo "\n--------------------------------------------------------------------------------------------------\n";
        if (is_array($columns) && count($columns) > 0) {
            foreach ($columns as $key => $value){
                if ($key + 1 < count($columns)){
                    //echo "'" . $value . "',";
                    $content .= "'" . $value . "',";
                } else {
                    //echo "'" . $value . "'";
                    $content .= "'" . $value . "'";
                }
            }
            $content .= PHP_EOL;
        }

        //echo "\n--------------------------------------------------------------------------------------------------\n";
        //echo implode(",", $columns);
        $content .= implode(",", $columns) . PHP_EOL;

        /* In field theo hang doc */
        if(is_array($columns) && count($columns) > 0){
            //echo "\n--------------------------------------------------------------------------------------------------";
            foreach ($columns as $key => $val) {
                if ($key + 1 < count($columns)){
                    //echo "\n'".$val."',";
                    $content .= "\n'".$val."',";
                } else {
                    //echo "\n'".$val."'";
                    $content .= "\n'".$val."'";
                }
            }
        }

        echo $content;
        echo "\n Kết quả được lưu tại: storage/app/public/fields.txt \n";
        // Lưu ra file
        $fields_file = storage_path('app/public/fields.txt');
        $file = @fopen($fields_file, "a") or die("Unable to open file!");
        @fclose($file);
        @file_put_contents($fields_file, $content.PHP_EOL , FILE_APPEND | LOCK_EX);
    }
}
