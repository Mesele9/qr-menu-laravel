<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    /**
     * Display the QR code generator page.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        // Get the main URL of the guest-facing menu.
        $url = route('menu.index');
        
        return view('admin.qrcode.show', compact('url'));
    }
}