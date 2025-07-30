<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\CategoriesImport;
use Maatwebsite\Excel\Facades\Excel;

class importCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports categories from excel file123';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Excel::import(new CategoriesImport, storage_path('app/Lynx_Keyword_Enhanced_Services.xlsx'));
    }
}
