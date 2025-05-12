<?php

namespace App\Console\Commands;

use App\Models\Book;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class RefreshBooksTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-books-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop, re-migrate, and reseed only the books table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Identifying books currently on loan...');
        $keepIds = Book::whereHas('currentLoan')->pluck('id')->all();

        $this->info('🗑 Deleting all other books...');
        // disable FK checks so cascade reviews delete cleanly
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Book::whereNotIn('id', $keepIds)->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->info('✔ Done.');

        $this->info('🌱 Reseeding the books table...');
        $exitCode = $this->call('db:seed', [
            '--class' => \Database\Seeders\LMSBookSeeder::class,
            '--force' => true,
        ]);
        if ($exitCode === 0) {
            $this->info('✅ books table reseeded successfully.');
        } else {
            $this->error("❌ Seeder returned exit code {$exitCode}.");
        }
    }
}
