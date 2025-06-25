<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LocalizationController extends Controller
{
    /**
     * Set the application's locale and store it in the session.
     *
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setLocale($locale)
    {
        // Define the list of supported locales
        $supportedLocales = ['en', 'am', 'so', 'om'];

        // Check if the selected locale is supported
        if (in_array($locale, $supportedLocales)) {
            // Store the selected locale in the session
            session()->put('locale', $locale);
        }

        // Redirect the user back to the previous page
        return Redirect::back();
    }
}