<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\Rules;
use App\Models\User;
use App\Models\Token;
use App\Mail\AuthMail;
use DateTime;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    //アカウント作成画面
    public function index(Request $request)
    {
        return view('auth');
    }

    //アカウント仮登録処理
    public function create(Request $request)
    {
        //ユーザー情報バリデーション
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]
        );

        if ($validator->fails()) {
            // return redirect('/errorpage')
            //     ->withErrors($validator)
            //     ->withInput();
            return redirect("/auth")->withErrors($validator)
                ->withInput();
        } else {
            // return view('sample.index', ['msg' => 'OK']);
        }

        DB::transaction(function () use ($request) {
            //ユーザー情報DB登録
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'email_auth_flag' => 0,
                'password' => Hash::make($request->password),
            ]);

            //2. トークンを発行
            $now = new DateTime();
            $now->format("Y-m-d H:i:s");
            //有効期限を計算(30分とした)
            $expire_at = $now->modify('+30 minutes');

            //3. トークンをDBに保存
            $uniqId = uniqid('', true);
            Token::create([
                'token' => $uniqId,
                'email' => $request->email,
                'auth_flag' => 0,
                'expire_at' => $expire_at
            ]);

            //メールに記載する認証用URlを組み立てている(認証用ページURL+トークン)。
            $url = $request->getSchemeAndHttpHost() . "/auth/create-verify/" . $uniqId;
            //4. メールを送信
            Mail::to($request->email)
                ->send(new AuthMail($url));
        });

        //アカウント仮登録確認画面へリダイレクト
        //return redirect()->route('auth.create.tmp.verify')->with('email', $request->email);
        return view('create_tmp_verify')->with('email', $request->email);
    }

    function createTmpVerify(Request $request)
    {
        return view('create_tmp_verify');
    }

    function createVerify($token, Request $request)
    {
        //6. ユーザから送信されたトークンを検索
        $data = Token::where([
            'token' => $token
        ])->first();

        //8. トークンチェック
        if (is_null($data)) {
            //DBから値が返ってこないのでトークンが間違っている、チェックNG
            return redirect('/')->with('message', 'メールアドレス認証に失敗しました。URLを確認してもう一度やり直してください。');
        } else if ($data->auth_flag) {
            //検索して見つかったトークンデータの認証フラグが既に立っている(=認証済み)、チェックNG
            return redirect('/')->with('message', 'このメールアドレスはすでに認証されています。');
        }

        //9. 認証処理(有効なトークンだった場合はフラグを認証済み(true)に更新)
        $now = new DateTime();
        $expire_date = new DateTime($data->expire_at);
        if ($now < $expire_date) {

            DB::transaction(function () use ($data) {
                $data->auth_flag = true;
                $data->update();

                //9. 認証処理(ユーザテーブルのメールアドレス認証フラグ立てる)
                $user = User::where([
                    'email' => $data->email
                ])->first();

                $user->email_auth_flag = true;
                $user->update();

                //10. ログイン状態にしてユーザトップページへリダイレクト
                // $request->session()->put('logind', 'true');
                // $request->session()->put('id', $user->id);
                //return redirect('/user/'.$user->id);
            });
            return view('mypage');
        } else {
            DB::transaction(function () use ($token,$data) {
                //有効期限が切れている、チェックNG
                //有効期限の切れたトークンデータ、ユーザデータはもう二度と認証できないので削除
                Token::where([
                    'token' => $token
                ])->delete();
                User::where([
                    'email' => $data->email
                ])->delete();
            });
            return redirect('/')->with('message', '認証URLの有効期限が切れています。最初からもう一度やり直してください。');
        }

        return view('mypage');
    }

    function login(Request $request)
    {
        return view('login');
    }

    function signin(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect('/mypage');
        // return redirect()->intended(route('mypage', absolute: false));
    }

    function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
