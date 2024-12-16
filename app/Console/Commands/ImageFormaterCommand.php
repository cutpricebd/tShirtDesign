<?php

namespace App\Console\Commands;
use App\Traits\FileUploadTrait;
use Illuminate\Console\Command;

class ImageFormaterCommand extends Command
{
    use FileUploadTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:webp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Image to webp';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->imageConvertToWebp(1,1000);
        //$this->productImage(1001,2465);
        //$this->brandImage(1,5000);
        //$this->categoryImage(1,5000);
        //$this->sliderImage(1,5000);
        $this->info("<br>updated successfully!");
    }
}
