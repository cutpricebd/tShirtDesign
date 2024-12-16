<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    public function __destruct()
    {
        cache()->forget('general_settings');
    }

    // General
    public function general(){
        return view('back.frontend.general');
    }

    public function generalStore(Request $request){
        $request->validate([
            'title' => 'required|max:255',
            'slogan' => 'required|max:255',
            'mobile_number' => 'required|max:255',
            'email' => 'required|max:255',
            'city' => 'required|max:255',
            'province' => 'required|max:255',
            'postal_code' => 'required|max:255',
            'street' => 'required|max:255',
            // 'tax_type' => 'required|max:255',
            'copyright' => 'required|max:255',
        ]);

        $where = array();
        $where['group'] = 'general';

        $where['name'] = 'title';
        $insert['value'] = $request->title;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'slogan';
        $insert['value'] = $request->slogan;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'headline';
        $insert['value'] = $request->headline;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'mobile_number';
        $insert['value'] = $request->mobile_number;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'email';
        $insert['value'] = $request->email;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'tel';
        $insert['value'] = $request->tel;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'copyright';
        $insert['value'] = $request->copyright;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'city';
        $insert['value'] = $request->city;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'state';
        $insert['value'] = $request->province;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'messenger_link';
        $insert['value'] = $request->messenger_link;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'country';
        $insert['value'] = $request->country;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'zip';
        $insert['value'] = $request->postal_code;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'street';
        $insert['value'] = $request->street;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'tax';
        $insert['value'] = $request->tax;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'tax_type';
        $insert['value'] = $request->tax_type;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'currency_name';
        $insert['value'] = $request->currency_name;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'currency_symbol';
        $insert['value'] = $request->currency_symbol;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'free_shipping_after';
        $insert['value'] = $request->free_shipping_after;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'short_description';
        $insert['value'] = $request->short_description;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'custom_head_code';
        $insert['value'] = $request->custom_head_code;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'custom_body_code';
        $insert['value'] = $request->custom_body_code;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'custom_footer_code';
        $insert['value'] = $request->custom_footer_code;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'primary_color';
        $insert['value'] = $request->primary_color;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'primary_light_color';
        $insert['value'] = $request->primary_light_color;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'secondary_color';
        $insert['value'] = $request->secondary_color;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'secondary_dark_color';
        $insert['value'] = $request->secondary_dark_color;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'footer_color';
        $insert['value'] = $request->footer_color;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'font_color_light';
        $insert['value'] = $request->font_color_light;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'font_color_dark';
        $insert['value'] = $request->font_color_dark;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'footer_color';
        $insert['value'] = $request->footer_color;
        DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'shipping_charge';
        // $insert['value'] = $request->shipping_charge;
        // DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'meta_description';
        $insert['value'] = $request->meta_description;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'keywords';
        $insert['value'] = $request->keywords;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'special_offer_text_1';
        $insert['value'] = $request->special_offer_text_1;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'special_offer_text_2';
        $insert['value'] = $request->special_offer_text_2;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'special_offer_button_text';
        $insert['value'] = $request->special_offer_button_text;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'special_offer_button_url';
        $insert['value'] = $request->special_offer_button_url;
        DB::table('settings')->updateOrInsert($where, $insert);

        // Update Logo
        if($request->logo){
            $this->validate($request, [
                'logo' => 'image|mimes:jpg,png,jpeg,gif'
            ]);

            // Delete Old
            if(\Info::Settings('general', 'logo')){
                $img_del = public_path('/uploads/info/' . \Info::Settings('general', 'logo'));
                if (file_exists($img_del)) {
                    unset($photo);
                    unlink($img_del);
                }
            }

            $file = $request->file('logo');
            $photo = 'logo.' . $file->getClientOriginalExtension();
            $destination = public_path() . '/uploads/info';
            $file->move($destination, $photo);

            // Store logo
            $where['name'] = 'logo';
            $insert['value'] = $photo;
            DB::table('settings')->updateOrInsert($where, $insert);
        }
        // Update Footer Logo
        if($request->footer_logo){
            $this->validate($request, [
                'footer_logo' => 'image|mimes:jpg,png,jpeg,gif'
            ]);

            // Delete Old
            if(\Info::Settings('general', 'footer_logo')){
                $img_del = public_path('/uploads/info/' . \Info::Settings('general', 'footer_logo'));
                if (file_exists($img_del)) {
                    unset($photo);
                    unlink($img_del);
                }
            }

            $file = $request->file('footer_logo');
            $photo = 'footer_logo.' . $file->getClientOriginalExtension();
            $destination = public_path() . '/uploads/info';
            $file->move($destination, $photo);

            // Store footer logo
            $where['name'] = 'footer_logo';
            $insert['value'] = $photo;
            DB::table('settings')->updateOrInsert($where, $insert);
        }

        // Update Favicon
        if($request->favicon){
            $this->validate($request, [
                'favicon' => 'image|mimes:jpg,png,jpeg,gif'
            ]);

            // Delete Old
            if(\Info::Settings('general', 'favicon')){
                $img_del = public_path('/uploads/info/' . \Info::Settings('general', 'favicon'));
                if (file_exists($img_del)) {
                    unset($photo);
                    unlink($img_del);
                }
            }

            $file = $request->file('favicon');
            $photo = 'favicon.' . $file->getClientOriginalExtension();
            $destination = public_path() . '/uploads/info';
            $file->move($destination, $photo);

            // Store Favicon
            $where['name'] = 'favicon';
            $insert['value'] = $photo;
            DB::table('settings')->updateOrInsert($where, $insert);
        }

        // Update OG
        if($request->og_image){
            $this->validate($request, [
                'og_image' => 'image|mimes:jpg,png,jpeg,gif'
            ]);

            // Delete Old
            if(\Info::Settings('general', 'og_image')){
                $img_del = public_path('/uploads/info/' . \Info::Settings('general', 'og_image'));
                if (file_exists($img_del)) {
                    unset($photo);
                    unlink($img_del);
                }
            }

            $file = $request->file('og_image');
            $photo = 'og_image.' . $file->getClientOriginalExtension();
            $destination = public_path() . '/uploads/info';
            $file->move($destination, $photo);

            // Store og_image
            $where['name'] = 'og_image';
            $insert['value'] = $photo;
            DB::table('settings')->updateOrInsert($where, $insert);
        }

        // Update PM
        if($request->homepage_banner_image){
            $this->validate($request, [
                'homepage_banner_image' => 'image|mimes:jpg,png,jpeg,gif'
            ]);

            // Delete Old
            if(\Info::Settings('general', 'homepage_banner_image')){
                $img_del = public_path('/uploads/info/' . \Info::Settings('general', 'homepage_banner_image'));
                if (file_exists($img_del)) {
                    unset($photo);
                    unlink($img_del);
                }
            }

            $file = $request->file('homepage_banner_image');
            $photo = 'homepage_banner_image.' . $file->getClientOriginalExtension();
            $destination = public_path() . '/uploads/info';
            $file->move($destination, $photo);

            // Store og_image
            $where['name'] = 'homepage_banner_image';
            $insert['value'] = $photo;
            DB::table('settings')->updateOrInsert($where, $insert);
        }

        // Home Banner
        $where['group'] = 'home_banner';

        $where['name'] = 'hb_link_1';
        $insert['value'] = $request->hb_link_1;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'hb_link_2';
        $insert['value'] = $request->hb_link_2;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'hb_link_3';
        $insert['value'] = $request->hb_link_3;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'hb_link_4';
        $insert['value'] = $request->hb_link_4;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'hb_link_5';
        $insert['value'] = $request->hb_link_5;
        DB::table('settings')->updateOrInsert($where, $insert);

        if($request->image_1){
            $this->validate($request, [
                'image_1' => 'image|mimes:jpg,png,jpeg,gif'
            ]);

            // Delete Old
            if(\Info::Settings('home_banner', 'image_1')){
                $img_del = public_path('/uploads/info/' . \Info::Settings('home_banner', 'image_1'));
                if (file_exists($img_del)) {
                    unset($photo);
                    unlink($img_del);
                }
            }

            $file = $request->file('image_1');
            $photo = 'hb_image_1.' . $file->getClientOriginalExtension();
            $destination = public_path() . '/uploads/info';
            $file->move($destination, $photo);

            // Store Image
            $where['name'] = 'image_1';
            $insert['value'] = $photo;
            DB::table('settings')->updateOrInsert($where, $insert);
        }

        if($request->image_2){
            $this->validate($request, [
                'image_2' => 'image|mimes:jpg,png,jpeg,gif'
            ]);

            // Delete Old
            if(\Info::Settings('home_banner', 'image_2')){
                $img_del = public_path('/uploads/info/' . \Info::Settings('home_banner', 'image_2'));
                if (file_exists($img_del)) {
                    unset($photo);
                    unlink($img_del);
                }
            }

            $file = $request->file('image_2');
            $photo = 'hb_image_2.' . $file->getClientOriginalExtension();
            $destination = public_path() . '/uploads/info';
            $file->move($destination, $photo);

            // Store Image
            $where['name'] = 'image_2';
            $insert['value'] = $photo;
            DB::table('settings')->updateOrInsert($where, $insert);
        }

        if($request->image_3){
            $this->validate($request, [
                'image_3' => 'image|mimes:jpg,png,jpeg,gif'
            ]);

            // Delete Old
            if(\Info::Settings('home_banner', 'image_3')){
                $img_del = public_path('/uploads/info/' . \Info::Settings('home_banner', 'image_3'));
                if (file_exists($img_del)) {
                    unset($photo);
                    unlink($img_del);
                }
            }

            $file = $request->file('image_3');
            $photo = 'hb_image_3.' . $file->getClientOriginalExtension();
            $destination = public_path() . '/uploads/info';
            $file->move($destination, $photo);

            // Store Image
            $where['name'] = 'image_3';
            $insert['value'] = $photo;
            DB::table('settings')->updateOrInsert($where, $insert);
        }

        if($request->image_4){
            $this->validate($request, [
                'image_4' => 'image|mimes:jpg,png,jpeg,gif'
            ]);

            // Delete Old
            if(\Info::Settings('home_banner', 'image_4')){
                $img_del = public_path('/uploads/info/' . \Info::Settings('home_banner', 'image_4'));
                if (file_exists($img_del)) {
                    unset($photo);
                    unlink($img_del);
                }
            }

            $file = $request->file('image_4');
            $photo = 'hb_image_4.' . $file->getClientOriginalExtension();
            $destination = public_path() . '/uploads/info';
            $file->move($destination, $photo);

            // Store Image
            $where['name'] = 'image_4';
            $insert['value'] = $photo;
            DB::table('settings')->updateOrInsert($where, $insert);
        }

        if($request->image_5){
            $this->validate($request, [
                'image_5' => 'image|mimes:jpg,png,jpeg,gif'
            ]);

            // Delete Old
            if(\Info::Settings('home_banner', 'image_5')){
                $img_del = public_path('/uploads/info/' . \Info::Settings('home_banner', 'image_5'));
                if (file_exists($img_del)) {
                    unset($photo);
                    unlink($img_del);
                }
            }

            $file = $request->file('image_5');
            $photo = 'hb_image_5.' . $file->getClientOriginalExtension();
            $destination = public_path() . '/uploads/info';
            $file->move($destination, $photo);

            // Store Image
            $where['name'] = 'image_5';
            $insert['value'] = $photo;
            DB::table('settings')->updateOrInsert($where, $insert);
        }

        if ($request->hb_background_color){
            $where['name'] = 'background';
            $insert['value'] = $request->hb_background_color;
            DB::table('settings')->updateOrInsert($where, $insert);
        }

        // Social Links
        $where['group'] = 'social';

        $where['name'] = 'facebook';
        $insert['value'] = $request->facebook;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'twitter';
        $insert['value'] = $request->twitter;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'youtube';
        $insert['value'] = $request->youtube;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'instagram';
        $insert['value'] = $request->instagram;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'linkedin';
        $insert['value'] = $request->linkedin;
        DB::table('settings')->updateOrInsert($where, $insert);

        // FB Pixel API
        $where['group'] = 'fb_api';

        $where['name'] = 'track';
        $insert['value'] = $request->fb_track;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'pixel_id';
        $insert['value'] = $request->pixel_id;
        DB::table('settings')->updateOrInsert($where, $insert);

        $where['name'] = 'access_token';
        $insert['value'] = $request->fb_access_token;
        DB::table('settings')->updateOrInsert($where, $insert);

        return redirect()->back()->with('success-alert', 'Information updated successful.');
    }
}
