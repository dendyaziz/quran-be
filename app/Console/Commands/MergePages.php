<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MergePages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'merge:pages';

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
        $sourcePageNumber = 1;
        $sourcePage = Storage::get("pages2/page-$sourcePageNumber.json");
        $sourcePage = json_decode($sourcePage, true);

        for ($pageNumber = 1; $pageNumber <= 2; $pageNumber += 1) {
            $page = Storage::get("pages/page-$pageNumber.json");
            $page = json_decode($page, true);
            $verseCount = count($page['verses']);

            for ($verseIndex = 0; $verseIndex < $verseCount; $verseIndex += 1) {
                $wordCount = count($page['verses'][$verseIndex]['words']);

                for ($wordIndex = 0; $wordIndex < $wordCount; $wordIndex += 1) {
                    $location = $page['verses'][$verseIndex]['words'][$wordIndex]['location'];
                    $sourceVerseCount = count($sourcePage['verses']);

                    // find the correct text
                    for ($sourceVerseIndex = 0; $sourceVerseIndex < $sourceVerseCount; $sourceVerseIndex += 1) {
                        $sourceWordCount = count($sourcePage['verses'][$sourceVerseIndex]['words']);

                        for ($sourceWordIndex = 0; $sourceWordIndex < $sourceWordCount; $sourceWordIndex += 1) {
                            $sourceText = $sourcePage['verses'][$sourceVerseIndex]['words'][$sourceWordIndex]['text'];
                            $sourceLocation = $sourcePage['verses'][$sourceVerseIndex]['words'][$sourceWordIndex]['location'];

                            // check
                            if ($location === $sourceLocation) {
                                $this->info('found');
                            }

//                            $this->info($sourcePage['verses'][$sourceVerseIndex]['words'][$sourceWordIndex]['text']);
                            // TODO: if found replace value, if not found search to the next word
                        }
                        // TODO: if not found search to the next verse
                    }
                    // TODO: if not found search to the next page
                }
            }
        }
    }
}
