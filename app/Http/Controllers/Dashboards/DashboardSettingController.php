<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = "Pengaturan Website";
        $settings = Setting::all()->pluck("value", "key");
        $previousUrl = $request->headers->get('referer');

        return view("dashboard.settings.index", compact('settings', 'previousUrl', "title"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        $credentials = $request->validate([
            "WEB_TITLE" => ["required", "string", "max:30"],
            "WEB_LOCATION" => ["required", "string"],
            "HERO_TEXT_HEADER" => ["required", "string", "max:125"],
            "HERO_TEXT_DESCRIPTION" => ["required", "string", "max:255"],
            "FOOTER_TEXT_DASHBOARD" => ["required", "string", "max:255"],

            "WEB_LOGO_WHITE" => ["nullable", "file", "image", "mimes:png,jpg", "max:1024"],
            "OLD_WEB_LOGO_WHITE" => ["required", "string"],

            "WEB_LOGO" => ["nullable", "file", "image", "mimes:png,jpg", "max:1024"],
            "OLD_WEB_LOGO" => ["required", "string"],

            "WEB_FAVICON" => ["nullable", "file", "image", "mimes:png,jpg", "max:1024"],
            "OLD_WEB_FAVICON" => ["required", "string"],

            "FOOTER_IMAGE" => ["nullable", "file", "image", "mimes:png,jpg", "max:1024"],
            "OLD_FOOTER_IMAGE" => ["required", "string"],

            "FOOTER_IMAGE_DASHBOARD" => ["nullable", "file", "image", "mimes:png,jpg", "max:1024"],
            "OLD_FOOTER_IMAGE_DASHBOARD" => ["required", "string"],
        ]);

        try {
            foreach ($credentials as $key => $value) {
                if (in_array($key, ['WEB_LOGO', 'WEB_LOGO_WHITE', 'WEB_FAVICON', 'FOOTER_IMAGE', 'FOOTER_IMAGE_DASHBOARD'])) {
                    $value = $request->file($key)->store('website-settings');;

                    $old = "OLD_" . $key;
                    if ($request->$old && strpos($request->$old, "/") !== false) {
                        Storage::delete($request->$old);
                    }
                }

                Setting::where('key', $key)->update(['value' => $value]);
            }

            return redirect('/dashboard/website')->with('success', "Berhasil mengubah pengaturan website!");
        } catch (\Exception $e) {
            return redirect('/dashboard/website')->with('error', "Gagal mengubah pengaturan website :(");
        }
    }
}
