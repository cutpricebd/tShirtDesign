<?php

namespace App\Http\Controllers\back\Product;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;

class SupplerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('type', 'supplier')->active()->get();
        return view('back.supplier.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('type', 'admin')->active()->get();

        return view('back.supplier.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v_data = [
            'name' => 'required|max:255',
            'company_name' => 'required|max:255',
            'mobile_number' => 'required|max:255|unique:users',
            'email' => 'required|max:255|unique:users',
            'street' => 'required|max:255',
            'zip' => 'required|max:55',
            'city' => 'required|max:55',
            'state' => 'required|max:55',
            'country' => 'required|max:55'
        ];
        if($request->file('profile')){
            $v_data['profile'] = 'mimes:jpg,png,jpeg,gif';
        }

        $request->validate($v_data);

        $user = new User;
        $user->type = 'supplier';
        $user->last_name = $request->name;
        $user->company_name = $request->company_name;
        $user->mobile_number = $request->mobile_number;
        $user->email = $request->email;
        $user->street = $request->street;
        $user->zip = $request->zip;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->country = $request->country;
        $user->password = Hash::make(123456);

        if($request->file('profile')){
            $image = $request->file('profile');
            $filename    = time() . '.' . $image->getClientOriginalExtension();

            // Resize Image 150*150
            $image_resize = Image::make($image->getRealPath());
            $image_resize->fit(150, 150);
            $image_resize->save(public_path('/uploads/user/' . $filename));

            $user->profile = $filename;
        }
        $user->save();

        return redirect()->back()->with('success-alert', 'Supplier created successful.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('back.supplier.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $v_data = [
            'name' => 'required|max:255',
            'company_name' => 'required|max:255',
            'mobile_number' => 'required|max:255|unique:users,mobile_number,' . $id,
            'email' => 'required|max:255|unique:users,email,' . $id,
            'street' => 'required|max:255',
            'zip' => 'required|max:55',
            'city' => 'required|max:55',
            'state' => 'required|max:55',
            'country' => 'required|max:55'
        ];
        if($request->file('profile')){
            $v_data['profile'] = 'mimes:jpg,png,jpeg,gif';
        }
        // if($request->password){
        //     $v_data['password'] = 'min:8|confirmed';
        // }

        $request->validate($v_data);

        $user = User::findOrFail($id);
        $user->last_name = $request->name;
        $user->company_name = $request->company_name;
        $user->mobile_number = $request->mobile_number;
        $user->email = $request->email;
        $user->street = $request->street;
        $user->zip = $request->zip;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->country = $request->country;
        // if($request->password){
        //     $user->password = Hash::make($request->password);
        // }

        if($request->file('profile')){
            $image = $request->file('profile');
            $filename    = time() . '.' . $image->getClientOriginalExtension();

            // Resize Image 150*150
            $image_resize = Image::make($image->getRealPath());
            $image_resize->fit(150, 150);
            $image_resize->save(public_path('/uploads/user/' . $filename));

            // Delete old
            if($user->profile){
                $img = public_path() . '/uploads/user/' . $user->profile;
                if (file_exists($img)) {
                    unlink($img);
                }
            }

            $user->profile = $filename;
        }
        $user->save();

        return redirect()->back()->with('success-alert', 'Supplier updated successful.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if($user->id == auth()->user()->id){
            return redirect()->back()->with('error-alert', 'Sorry! You can not delete your own account!');
        }

        // Delete Image
        if($user->image){
            $img = public_path() . '/uploads/user/' . $user->image;
            if (file_exists($img)) {
                unlink($img);
            }
        }

        $user->delete();

        return redirect()->back()->with('success-alert', 'Supplier deleted successful.');
    }
}
