<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CrawlPages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:pages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            // 604 is the total page number
            for ($index = 1; $index <= 604; $index += 1) {
                $filename = "pages/page-$index.json";

                // skip if file already exist
                if (Storage::exists($filename)) {
                    continue;
                }

                $data = Http::get("https://api.quran.com/api/v4/verses/by_page/$index?words=true&word_fields=text_indopak,text_uthmani");
                $data = $data->json();

                $page = [
                    'page_number' => $index,
                    'verses' => $data['verses'],
                    'pagination' => $data['pagination'],
                ];

                // convert to json manually and encode to fix duplicate key
                Storage::put($filename, json_encode($page));
                $this->info("$filename generated!");

                usleep(100);
            }

            $this->info('SUCCESS!');
        } catch (\Exception $e) {
            $this->error("error: {$e->getMessage()}");
        }
    }
}
