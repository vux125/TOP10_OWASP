<?php
//SQL, XSS, OS Command, XXE(XML)
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class InjectionController extends Controller
{
    public function index()
    {
        $title = 'Injection';
        return view('injections.index', compact('title'));
    }

    //-------------------------------------------------

    //Operation System Command Injection
    public function viewOsInjection(Request $req)
    {
        return view('injections.osInjection');
    }

    public function osInjection(Request $req)
    {
        $domain = $req->input('os');
        $ban = ['ls', 'cat', 'find', 'grep', 'tail', 'less', 'strings', 'curl', 'wget', 'nl', 'more', 'awk', 'tac', 'od', 'xxd', 'rm', '*', 'rmdir', '&', '|', '>', '<', '`', '&&', '||', '!', '(', ')', '{', '}', '[', ']', '$', '?', ':', '=', '+', '-', '_', '%', '#', '@', '!', '~', '^', '\\', '"', "'", ',', '.', '>', '<', ' ', '  '];
        $check = explode(' ', $domain);
        foreach ($check as $c) {
            if (in_array($c, $ban)) {
                $error = 'Command not allowed';
                return view('injections.osInjection', compact('error'));
            }
        }
        $cmd = 'nslookup ' . $domain;
        $res = shell_exec($cmd);
        return view('injections.osInjection', compact('res'));
    }

    //-------------------------------------------------

    //Sql Injection In-Band(Union Based)
    public function viewSqlInjectionInBand()
    {
        $list = Product::all();
        return view('injections.sql.detailProduct', compact('list'));
    }
    public function sqlInjectionInBand()
    {
        $id = $_GET['id'];
        $sql = "SELECT * FROM products WHERE id = $id";
        $res = Product::query()->fromQuery($sql);
        $product = $res->first();
        return view('injections.sql.detailProduct', compact('product'));
    }

    //Sql Injection Inferential(Boolean Based)
    public function viewSqlInjectionInferentialBoolean()
    {
        $list = Product::all();
        return view('injections.sql.inferentialBoolean', compact('list'));
    }

    public function likePost(Request $req)
    {
        $id = $req->input('id');
        $sql = "UPDATE products SET likes = likes + 1 WHERE id = $id";
        try {
            $res = DB::update($sql);
            $product = Product::find($id);
            if ($res) {
                return response()->json([
                    'success' => true,
                    'likes' => $product->likes,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    //---------------------------------------------

    //Reflected XSS
    public function xssInjectionReflected(Request $req)
    {
        $username = $req->input('username');
        return view('injections.xss.reflected', compact('username'));
    }

    //Stored XSS
    public function xssInjectionStored()
    {
        $product = Product::find(1);
        $comments = Product::find(1)->comments();
        return view('injections.xss.stored', compact('product', 'comments'));
    }

    //Handle comment
    public function handleComment(Request $req)
    {
        $comment = $req->input('content');
        $productId = $req->input('product_id');
        // try {
        //     $cmt = Comment::create([
        //         'product_id' => $product,
        //         'comment' => $comment,
        //     ]);
        //     return response()->json([
        //         'success' => true,
        //         'comment' => $cmt,
        //     ]);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'success' => false,
        //     ]);
        // }
        $cmt = Comment::create([
            'product_id' => $productId,
            'content' => $comment,
        ]);
        $comments = Comment::where('product_id', $productId)->get();
        $product = Product::find($productId);
        return view('injections.xss.stored', compact('product', 'comments'));
    }
}
