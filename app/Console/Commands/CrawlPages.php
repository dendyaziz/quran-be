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
//    public function handle(): void
//    {
//        try {
//            // 604 is the total page number
//            for ($index = 549; $index <= 604; $index += 1) {
//                $filename = "pages/page-$index.json";
//
//                // skip if file already exist
//                if (Storage::exists($filename)) {
//                    continue;
//                }
//
//                $data = Http::get("https://quran.com/_next/data/jhEVkF249pwIMS0iT1FUn/id/page/$index.json");
//                $data = $data->json();
//
//                $data = $data['pageProps']['pageVerses'];
//
//                $page = [
//                    'pageNumber' => $index,
//                    'verses' => $data['verses'],
//                    'pagination' => $data['pagination'],
//                ];
//
//                // convert to json manually and encode to fix duplicate key
//                Storage::put($filename, json_encode($page));
//                $this->info("$filename generated!");
//
//                usleep(100);
//            }
//
//            $this->info('SUCCESS!');
//        } catch (\Exception $e) {
//            $this->error("error: {$e->getMessage()}");
//        }
//    }

//    /**
//     * Execute the console command.
//     */
//    public function handle(): void
//    {
//        try {
//            // 604 is the total page number
//            for ($index = 1; $index <= 604; $index += 1) {
//                $filename = "pages/page-$index.json";
//
//                // skip if file already exist
//                if (Storage::exists($filename)) {
//                    continue;
//                }
//
//                $data = Http::get("https://api.qurancdn.com/api/qdc/verses/by_page/$index?words=true&per_page=all&fields=text_uthmani,chapter_id,hizb_number,text_imlaei_simple&reciter=7&mushaf=3&word_translation_language=id&word_fields=verse_key,verse_id,page_number,location,text_uthmani,text_indopak,qpc_uthmani_hafs&filter_page_words=true");
//                $data = $data->json();
//
//                $page = [
//                    'page_number' => $index,
//                    'verses' => $data['verses'],
//                    'pagination' => $data['pagination'],
//                ];
//
//                // convert to json manually and encode to fix duplicate key
//                Storage::put($filename, json_encode($page));
//                $this->info("$filename generated!");
//
//                usleep(100);
//            }
//
//            $this->info('SUCCESS!');
//        } catch (\Exception $e) {
//            $this->error("error: {$e->getMessage()}");
//        }
//    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            // 604 is the total page number
            for ($index = 1; $index <= 610; $index += 1) {
                $filename = "pages/page-$index.json";

                // skip if file already exist
                if (Storage::exists($filename)) {
                    continue;
                }
                // \u0646\u064e\u0633\u0652\u062a\u064e\u0639\u0650\u06cc\u0652\u0646\u064f

                $data = Http::get("https://api.qurancdn.com/api/qdc/verses/by_page/$index?words=true&per_page=all&fields=text_uthmani,chapter_id,hizb_number,text_imlaei_simple&reciter=7&word_translation_language=id&word_fields=verse_key,verse_id,page_number,location,text_uthmani,text_indopak,qpc_uthmani_hafs&mushaf=6&filter_page_words=true");
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
