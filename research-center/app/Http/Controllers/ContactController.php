<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::where('active', 1)->get();

        // Grouping by key for better structure in view
        $grouped = $contacts->groupBy('key');

        return view('contact', [
            'groupedContacts' => $grouped,
        ]);
    }

    // Helper method (optional) if you want to use from controller in Blade
    public static function getContactIcon($key)
    {
        $key = strtolower($key);

        return match (true) {
            str_contains($key, 'email') => 'icon-email',
            str_contains($key, 'phone'), str_contains($key, 'hp'), str_contains($key, 'wa') => 'icon-telephone-call-1',
            str_contains($key, 'address'), str_contains($key, 'alamat') => 'icon-pin',
            str_contains($key, 'instagram') => 'fab fa-instagram',
            str_contains($key, 'facebook') => 'fab fa-facebook-f',
            str_contains($key, 'twitter') => 'fab fa-twitter',
            str_contains($key, 'youtube') => 'fab fa-youtube',
            str_contains($key, 'pinterest') => 'fab fa-pinterest-p',
            default => 'icon-info',
        };
    }
}
