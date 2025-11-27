<?php

namespace App\Http\Controllers;

use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Rawilk\Settings\Facades\Settings;

class SettingsController extends Controller
{
    public function index()
    {
        return view('configurations.settings');
    }

    public function updateWhatsappMessage(Request $request)
    {
        $data = $request->validate([
            'whatsapp_message' => 'required|string|min:10|max:500',
        ]);

        Settings::forget('whatsapp_message');

        Settings::set('whatsapp_message', $data['whatsapp_message']);

        Flasher::addSuccess('Mensaje de WhatsApp actualizado correctamente.');

        return redirect()->back();
    }
}
