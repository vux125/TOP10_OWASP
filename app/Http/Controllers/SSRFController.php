<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SSRFController extends Controller
{
    public function index(Request $request)
    {

        $url = $request->get('url');

        // Send a GET request to the URL provided
        try {
            if (isset($url)) {
                $ch = curl_init();
                $fileName = basename($url);
                $savepath = "images/ssrf/" . $fileName;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                $response = curl_exec($ch);
                file_put_contents($savepath, $response);
                curl_close($ch);
                return view('ssrf.index', ['response' => $savepath]);
            } else {
                return view('ssrf.index');
            }
        } catch (\Exception $e) {
            return view('ssrf.index', ['response' => $e->getMessage()]);
        }
    }
}
