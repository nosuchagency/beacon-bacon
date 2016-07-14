<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Configure all mail settings.
     */
    public function email()
    {
        $mailProviders = [
            'smtp' => 'SMTP',
            'mail' => 'Mail',
            'sendmail' => 'Sendmail',
            'mailgun' => 'Mailgun',
            'mandrill' => 'mandrill',
            'ses' => 'SES',
            'sparkpost' => 'Sparkpost',
            'log' => 'Log',
        ];

        return view('settings.email', compact('mailProviders'));
    }

    /**
     * Update mail settings.
     *
     * @param Request $request
     */
    public function emailUpdate(Request $request)
    {
        $this->update($request);

        return redirect()->route('settings.email');
    }

    /**
     * Edit email templates.
     */
    public function templates()
    {
        return view('settings.templates');
    }

    /**
     * Update email templates.
     *
     * @param Request $request
     */
    public function templatesUpdate(Request $request)
    {
        $this->update($request);

        return redirect()->route('settings.templates');
    }

    /**
     * Update the settings in the database.
     *
     * @param Request $request
     */
    protected function update(Request $request)
    {
        // remove keys starting with an underscore (like "_method" and "_token")
        $filtered = collect($request->all())->filter(function ($value, $key) {
            return substr($key, 0, 1) != '_';
        });

        foreach ($filtered as $key => $value) {
            // find or create the key, with a dot notation
            $setting = Setting::firstOrCreate(['key' => str_replace('-', '.', $key)]);
            $setting->update(['value' => $value]);
        }
    }
}
