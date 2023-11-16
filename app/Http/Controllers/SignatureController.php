<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\MinhaFilaDeTrabalho;
use App\Jobs\ShotEmails;
use App\Jobs\ProcessarMensagemJob;
use App\Models\Signature;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class SignatureController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        Signature::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'expiration' => Carbon::now()->toDateTimeString()
        ]);

        $user = User::where('id', $request->user_id)->first();

        dispatch(new ShotEmails($user, 1));

        return response()->json(['status' => 200, "message" => 'Inscrição adicionada com sucesso']);
    }

    public function index()
    {
        $signatures = Signature::where('user_id', auth()->user()->id)->get();

        return response()->json(['status' => 200, "signatures" => $signatures]);
    }

    public function delete($product_id)
    {
        $signature = Signature::where('user_id', auth()->user()->id)->where('product_id', $product_id)->delete();

        $user = User::where('id', auth()->user()->id)->first();

        dispatch(new ShotEmails($user, 4));

        return response()->json(['status' => 200, "message" => 'Inscrição deletada com sucesso']);
    }
}