<?php

namespace AliSalehi\Task\Tests\Feature;

use AliSalehi\Task\Tests\BaseTest;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class TaskTest extends BaseTest
{
//    php artisan migrate
//    php artisan schedule:tasks

    public function test_check_to_create_config_file_with_command(): void
    {
        $this->artisan('vendor:publish', ['--tag' => 'task-config']);
        $configFilePath = config_path('task.php');
        
        $this->assertFileExists($configFilePath);
    }
    
    public function test_check_to_create_migration_file_with_command()
    {
        $this->artisan('vendor:publish', ['--tag' => 'task-migration']);
        $migrationFilePath = database_path('migrations/create_task_table.php');
        
        $this->assertFileExists($migrationFilePath);
    }
    
    public function test_check_to_create_lang_file_with_command()
    {
        $this->artisan('vendor:publish', ['--tag' => 'task-lang']);
        $langFilePath = lang_path('en/task.php');
        
        $this->assertFileExists($langFilePath);
    }
    
    public function test_check_to_run_migration_file()
    {
        $migrationFileName = 'create_task_table.php';
        
        // مسیر فایل مایگریشن
        $migrationPath = database_path('migrations/' . $migrationFileName);
        
        // اجرای دستور آرتیسان migrate
        Artisan::call('migrate');
        
        // بررسی وجود فایل مایگریشن
        $this->assertFileExists($migrationPath);
        
        // بررسی وجود جدول مورد نظر در پایگاه داده
        $this->assertTrue(Schema::hasTable('tasks'));
    }
}
