<?php

namespace App\Http\Controllers\Back;

use App\Models\Sitemap;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Spatie\Sitemap\SitemapGenerator;

class SitemapController extends Controller
{
    public function __construct()
    {

    }
    public function index(Request $request)
    {
        $data['sitemaps'] = Sitemap::orderBy('id', 'DESC')->paginate(10);
        return view('back.settings.sitemap.index', $data);
    }

    public function add()
    {
        return view('back.settings.sitemap.add');
    }

    public function download(Request $request) {

        return response()->download(public_path().$request->filename);
    }

    public function store(Request $request)
    {
        set_time_limit(30000);
        ini_set('memory_limit','-1');

        $data = new Sitemap();
        $input = $request->all();

        $filename = 'sitemap' . uniqid() . '.xml';
        $path = public_path() . '/assets/sitemaps/';
        try {
        File::makeDirectory($path, $mode = 0777, true, true);
            SitemapGenerator::create($request->sitemap_url)->writeToFile($path . $filename);
            $input['filename']    = '/assets/sitemaps/'.$filename;
            $input['sitemap_url'] = $request->sitemap_url;
            $data->fill($input)->save();
        }catch (\Exception $e){
            return redirect()->route('admin.sitemap.index')->withErrors(__('Something went wrong'));
        }

        return redirect()->route('admin.sitemap.index')->withSuccess(__('Sitemap Generate Successfully'));

    }

    public function delete($id)
    {

        $sitemap = Sitemap::find($id);
        @unlink(public_path(). $sitemap->filename);
        $sitemap->delete();

        return redirect()->back()->withSuccess(__('Sitemap file deleted successfully!'));

    }

}
