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

        /* Lay danh sach field */
        $columns = Schema::getColumnListing($tableName);

        /* In field theo hang ngang */
        echo "\n";
        echo json_encode(is_array($columns) ? $columns : []);

        echo "\n--------------------------------------------------------------------------------------------------\n";
        if (is_array($columns) && count($columns) > 0) {
            foreach ($columns as $key => $value){
                if ($key + 1 < count($columns)){
                    echo "'" . $value . "',";
                } else {
                    echo "'" . $value . "'";
                }
            }
        }

        echo "\n--------------------------------------------------------------------------------------------------\n";
        echo implode(",", $columns);

        /* In field theo hang doc */
        if(is_array($columns) && count($columns) > 0){
            echo "\n--------------------------------------------------------------------------------------------------";
            foreach ($columns as $key => $val) {
                if ($key + 1 < count($columns)){
                    echo "\n'".$val."',";
                } else {
                    echo "\n'".$val."'";
                }
            }
        }
    }
}
