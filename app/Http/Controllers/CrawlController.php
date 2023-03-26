<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CrawlController extends Controller
{
    public function crawl() {
        try {
            for ($index = 1; $index <= 604; $index += 1) {
                $filename = "pages/page-$index.json";

                // skip if file already exist
                if (Storage::exists($filename)) {
                    continue;
                }

                $data = Http::get("https://api.quran.com/api/v4/verses/by_page/$index?words=true&word_fields=text_indopak");

                // convert to json manually and encode to fix duplicate key
                Storage::put($filename, json_encode($data->json()));

                usleep(100);
            }

            return [
                'message' => 'success'
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e
            ];
        }
    }

    public function merge() {
        $json1 = Storage::disk('local')->get('60.json');
        $json1 = json_decode($json1, true);
//        $json2 = Storage::disk('local')->get('240.json');
//        $json2 = json_decode($json2, true);
//        $json3 = Storage::disk('local')->get('350.json');
//        $json3 = json_decode($json3, true);
//        $json4 = Storage::disk('local')->get('450.json');
//        $json4 = json_decode($json4, true);
//        $json5 = Storage::disk('local')->get('550.json');
//        $json5 = json_decode($json5, true);
//        $json6 = Storage::disk('local')->get('604.json');
//        $json6 = json_decode($json6, true);
//        return $json4;

        $verses = $json1['verses'];
//        $verses = array_merge($verses, $json2['verses']);
//        $verses = array_merge($verses, $json3['verses']);
//        $verses = array_merge($verses, $json4['verses']);
//        $verses = array_merge($verses, $json5['verses']);
//        $verses = array_merge($verses, $json6['verses']);

        $verses = array_map(function ($verse) {
            return [
                'id' => $verse['id'],
                'verse_number' => $verse['page_number'],
                'verse_key' => $verse['page_number'],
                'hizb_number' => $verse['hizb_number'],
            ];
        }, $verses);

        return $verses;
    }
}
