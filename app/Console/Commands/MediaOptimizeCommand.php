<?php

namespace App\Console\Commands;

use Exception;
use App\Api\Models\Media;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use WebPConvert\WebPConvert;

class MediaOptimizeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:optimize {--force : Force optimizations even for already optimized ones}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimizes uploaded images by converting them to Google\'s WebP format.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = $this->select()->get();

        if (($count = count($files)) > 0) {
            $this->info(sprintf('Found %s files for optimizing.', $count));
        } else {
            $this->info('No optimizable files found.');
            return;
        }

        $progress = $this->output->createProgressBar(count($files));

        foreach ($files as $file) {
            $success = $this->optimize($file);

            $progress->clear();

            if ($success) {
                $this->info(sprintf('Optimized file %s', $file->path));
            } else {
                $this->warn(sprintf('Could not optimize file %s', $file->path));
            }

            $progress->display();
            $progress->advance();
        }

        $progress->finish();
        $progress->clear();
    }

    private function select()
    {
        $media = Media::where('optimized', 0);

        if ($this->option('force')) {
            return $media->orWhere('optimized', 1);
        }

        return $media->where(function ($query) {
            $query->where('type', 'image/png')->orWhere('type', 'image/jpeg');
        });
    }

    private function optimize($file)
    {
        $from = sprintf('%s/%s', storage_path('app'), $file->path);
        $pathInfo = pathinfo($from);
        $to = sprintf('%s/%s.webp', $pathInfo['dirname'], $pathInfo['filename']);

        $success = WebPConvert::convert($from, $to, [
            'quality' => 80,
        ]);

        if ($success) {
            $file->optimized = true;
            $file->save();
        }

        return $success;
    }
}
