<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TraversalController extends Controller
{

    public function viewTraversal(Request $request)
    {

        $view = $request->get('view');
        if ($view == null) {
            $view = 'home.blade.php';
        }
        return view('traversal.index', ['view' => $view]);
    }
}
