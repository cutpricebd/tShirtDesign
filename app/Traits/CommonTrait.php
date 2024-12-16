<?php
namespace App\Traits;
use Illuminate\Support\Facades\DB;

trait CommonTrait{
    /*
     * method for image upload
     * */
    protected function makeSlug($table, $title, $id=null)
    {
        // Remove special characters except Bangla letters and numbers
        $slug = preg_replace('/[^\p{L}\p{N}\s]+/u', '', trim($title));

        // Replace spaces with hyphens
        $slug = preg_replace('/\s+/u', '-', $slug);

        // Prepare the base query to check for existing slugs
        $query = DB::table($table)
            ->where('slug', '!=', null)
            ->where('id', '!=', $id)
            ->where(function ($query) use ($slug) {
                $query->where('slug', $slug)
                    ->orWhere('slug', 'like', $slug . '-%');
            });

        // Get all existing slugs matching the base slug
        $existingSlugs = $query->pluck('slug');

        // If the slug already exists, append a unique number
        if ($existingSlugs->contains($slug)) {
            $counter = 1;
            while ($existingSlugs->contains($slug . '-' . $counter)) {
                $counter++;
            }
            return $slug . '-' . $counter;
        }

        return $slug;
    }
}
