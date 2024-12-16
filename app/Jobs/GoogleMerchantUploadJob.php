<?php

namespace App\Jobs;

use App\Models\GoogleMerchantUpload;
use App\Models\Product\Product;
use App\Repositories\GoogleMerchantRepo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GoogleMerchantUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $upload_id;
    public $timeout = 60 * 60 * 2;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($upload_id)
    {
        $this->upload_id = $upload_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $upload = GoogleMerchantUpload::find($this->upload_id);
        $product = Product::find($upload->product_id);

        $response = GoogleMerchantRepo::insertProduct($product, $upload->google_category_id);
        if($response['status']){
            $upload->status = 'Uploaded';
        }else{
            $upload->status = 'Failed';
            $upload->failed_note = $response['message'] ?? '';
        }
        $upload->save();
    }
}
