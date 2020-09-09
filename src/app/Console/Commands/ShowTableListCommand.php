<?php

namespace Edupham\Fillable\App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use League\Flysystem\FileNotFoundException;

class ShowTableListCommand extends Command
{
    /**
     * The name and signature of the console command.     *
     * @var string
     */
    protected $signature = 'table:show-list';

    /**
     * The console command description.     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * ShowTableListCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.     *
     * @return mixed
     */
    public function handle()
    {
        $tables = DB::select('SHOW TABLES');
        if (is_array($tables) && count($tables) > 0) {
            echo "Total tables: " . count($tables) . "\n";
            $i = 0;
            /*try{
                \File::get('.env.example');
            } catch (FileNotFoundException $e){
                //
            }*/
            foreach($tables as $table)
            {
                $i++;

                foreach ($table as $key => $value)
                    echo $i . ". " . $value."\n";
                    /*try {
                        \File::append('.env.example', $i . ". " . $value."\n");
                    } catch (FileNotFoundException $e) {
                        //
                    }*/
            }
        }
    }
}
