<?php

use App\account;
use App\accountnormal;
use App\ashe;
use App\Http\Resources\AccountResource;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return'www';
});

Route::get('/{User?}/Lock/{ISLock?}/{PopKartID?}',function (Request $request){

    if($request->ISLock == 0) {
        $message = "=>【帳號被鎖了】";
        $message = $message . PHP_EOL . $request->PopKartID;
        if ($request->User == "Ray") {
            $account = account::find($request->PopKartID);
        } else if ($request->User == "Ashe") {
            $account = ashe::find($request->PopKartID);
        }

        if (count($account) > 0) {
            $account->delete();
        }
    }else if($request->ISLock == 1) {
        $message = "=>【帳號沒事】";
        $message = $message . PHP_EOL . $request->PopKartID;
        if ($request->User == "Ray") {
            $account = account::find($request->PopKartID);
        } else if ($request->User == "Ashe") {
            $account = ashe::find($request->PopKartID);
        }

        if (count($account) > 0) {
            if($account->更名卡 > 0){
                $message = $message . PHP_EOL . "有更名卡";
            }
            if($account->黑武神 > 0){
                $message = $message . PHP_EOL . "黑武神：" . $account->黑武神 . "台";
            }
            if($account->積巴 > 0){
                $message = $message . PHP_EOL . "積木巴爾：" . $account->積巴 . "台";
            }
            if($account->魔光 > 0){
                $message = $message . PHP_EOL . "磨光騎士：" . $account->魔光 . "台";
            }
            if($account->富豪 > 0){
                $message = $message . PHP_EOL . "富豪超跑：" . $account->富豪 . "台";
            }
            if($account->犽霸 > 0){
                $message = $message . PHP_EOL . "犽霸：" . $account->犽霸 . "台";
            }
        }
    }

    $client = new Client();
    $url = "https://notify-api.line.me/api/notify";
    if($request->User == "Ray"){
        $response = $client->request("POST", $url, [
            'headers' => [
                'authorization' => 'Bearer Kk92NEUwHQW6zlj4mjqSkiFh1Qxc362EdNLx2oS3cQA'
            ],
            'Content-Type' => 'application/x-www-form-urlencoded',
            'form_params'=> [
                'message' =>  $message,
            ]
        ]);
    }else if($request->User == "Ashe"){
        $response = $client->request("POST", $url, [
            'headers' => [
                'authorization' => 'Bearer TsyUQwZaEJSuIiwNFuVVPfC6IFBSCWb7Ph4vGVd7Mgc'
            ],
            'Content-Type' => 'application/x-www-form-urlencoded',
            'form_params'=> [
                'message' =>  $message,
            ]
        ]);
    }
    return $request->PopKartID;
});

Route::get('/{User?}/NoAccount/{Computer?}',function (Request $request){
	$message = "=>【沒帳號了】";
	for ($i = 0 ; $i <= 10 ; $i++){
		$message = $message . PHP_EOL . $request->Computer ."沒帳號了";
	}
	$client = new Client();
	$url = "https://notify-api.line.me/api/notify";
	if($request->User == "Ray"){
		$response = $client->request("POST", $url, [
			'headers' => [
				'authorization' => 'Bearer Kk92NEUwHQW6zlj4mjqSkiFh1Qxc362EdNLx2oS3cQA'
			],
			'Content-Type' => 'application/x-www-form-urlencoded',
			'form_params'=> [
				'message' =>  $message,
			]
		]);
	}else if($request->User == "Ashe"){
		$response = $client->request("POST", $url, [
			'headers' => [
				'authorization' => 'Bearer TsyUQwZaEJSuIiwNFuVVPfC6IFBSCWb7Ph4vGVd7Mgc'
			],
			'Content-Type' => 'application/x-www-form-urlencoded',
			'form_params'=> [
				'message' =>  $message,
			]
		]);
	}
    return "OK";
});

Route::get('/{User?}/LV102/{Computer?}/{Account?}/{Password?}/{PopKartID?}',function (Request $request){
    if($request->User != "Ray"){
        return "OK";
    }
    $message = "=>【滿等囉】" . PHP_EOL . "【ＩＤ】 =>【" .$request->PopKartID . "】" . PHP_EOL . "【電腦】 =>【" . $request->Computer . "】";
    $account = accountnormal::find($request->Account);
    if($account != null){
        $account->level = 102;
        try{
            $account->save();
        }catch (\Illuminate\Database\QueryException $e){
            return $e->getMessage();
        }
    }else{
        $account = new accountnormal();
        $account->編號 = str_replace("OOXXorz","",$request->PopKartID);
        $account->id = $request->Account;
        $account->name = $request->PopKartID;
        $account->password = $request->Password;
        $account->level = 102;
        try{
            $account->save();
        }catch (\Illuminate\Database\QueryException $e){
            return $e->getMessage();
        }
    }
    /*$client = new Client();
    $url = "https://notify-api.line.me/api/notify";
    if($request->User == "Ray"){
        $response = $client->request("POST", $url, [
            'headers' => [
                'authorization' => 'Bearer Kk92NEUwHQW6zlj4mjqSkiFh1Qxc362EdNLx2oS3cQA'
            ],
            'Content-Type' => 'application/x-www-form-urlencoded',
            'form_params'=> [
                'message' =>  $message,
            ]
        ]);
    }else if($request->User == "Ashe"){
        $response = $client->request("POST", $url, [
            'headers' => [
                'authorization' => 'Bearer TsyUQwZaEJSuIiwNFuVVPfC6IFBSCWb7Ph4vGVd7Mgc'
            ],
            'Content-Type' => 'application/x-www-form-urlencoded',
            'form_params'=> [
                'message' =>  $message,
            ]
        ]);
    }*/
    return "OK";
});

Route::get('/{User?}/GoldPeople/{id?}/{computername?}/{gold?}',function (Request $request){
    $message = "=>【刷金芊】" . PHP_EOL . "【ＩＤ】 =>【" .$request->id . "】" . PHP_EOL . "【電腦】 =>【" . $request->computername . "】";
    $gold = intval(substr($request->gold,0,1));
    $double = intval(substr($request->gold,1,1));
    $hand = intval(substr($request->gold,2,1));
    $error = false;
    if($gold == 0){
        $error = true;
        $message .= (PHP_EOL . "沒金芊。");
    }
    if($double == 0){
        $error = true;
        $message .= (PHP_EOL . "沒金加倍卡。");
    }
    if($hand == 0){
        $error = true;
        $message .= (PHP_EOL . "沒手杖。");
    }

    if(!$error){
        return "OK";
    }
    $client = new Client();
    $url = "https://notify-api.line.me/api/notify";
    if($request->User == "Ray"){
        $response = $client->request("POST", $url, [
            'headers' => [
                'authorization' => 'Bearer Kk92NEUwHQW6zlj4mjqSkiFh1Qxc362EdNLx2oS3cQA'
            ],
            'Content-Type' => 'application/x-www-form-urlencoded',
            'form_params'=> [
                'message' =>  $message,
            ]
        ]);
    }else if($request->User == "Ashe"){
        $response = $client->request("POST", $url, [
            'headers' => [
                'authorization' => 'Bearer TsyUQwZaEJSuIiwNFuVVPfC6IFBSCWb7Ph4vGVd7Mgc'
            ],
            'Content-Type' => 'application/x-www-form-urlencoded',
            'form_params'=> [
                'message' =>  $message,
            ]
        ]);
    }
    return "OK";
});
/*
Route::get('/{User?}/{Computer?}/{Account?}/{Password?}/{PopKartID?}/{Change?}/{Level?}/{Cars?}',function(Request $request){

    $Names = ['黑武神','金遊','積巴', '巴爾','遊俠','魔光','黑騎','音速','富豪', '犽霸'];
	if($request->User == "Ray"){
        $Cars = str_split($request->Cars);
		$account = account::find($request->Account);
		$AllCars = 0;
        for($i = 0 ; $i < sizeof($Cars) ; $i++){
            $AllCars = $AllCars + intval($Cars[$i]);
        }

		if(count($account) > 0){
            $CarList = [$account->黑武神,$account->金遊,$account->積巴,$account->巴爾,$account->遊俠,$account->魔光,$account->黑騎,$account->音速,$account->富豪,$account->犽霸];
		    $New = false;
            $message = "=>【更新帳號】";
            $message = $message . PHP_EOL . "電腦：" . $request->Computer;
            $message = $message . PHP_EOL . "帳號：" . $account->id . PHP_EOL . "ID：" . $account->name;
            if($account->更名卡 != intval($request->Change)){
                $New = true;
                $account->update(['更名卡'=>intval($request->Change)]);
            }

            if(intval($account->level) != intval($request->Level)){
                $New = true;
                $account->update(['level'=>intval($request->Level)]);
                $message = $message . PHP_EOL . "等級：" . $request->Level . "等";
            }

            if(intval($request->Change) > 0){
                        $message = $message . PHP_EOL . "有更名卡";
            }

		    for($i = 0 ; $i < sizeof($Cars) ; $i++){
		        if(intval($CarList[$i]) != intval($Cars[$i])){
		            $New = true;
                    $account->update([$Names[$i]=>intval($Cars[$i])]);
                }
            }

            if($AllCars == 0){
                $account->update(['舒適'=>1]);
            }

            if($New){
                for($i = 0 ; $i < sizeof($Cars) ; $i++){
                    $message = $message . PHP_EOL . $Names[$i] . $Cars[$i] . "台";
                }

                $client = new Client();

                $url = "https://notify-api.line.me/api/notify";
                $response = $client->request("POST", $url, [
                    'headers' => [
                        'authorization' => 'Bearer Kk92NEUwHQW6zlj4mjqSkiFh1Qxc362EdNLx2oS3cQA'
                    ],
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'form_params'=> [
                        'message' =>  $message,
                    ]
                ]);
            }
		}

		return account::find($request->Account);
	}
});*/

Route::get('/機率',function(Request $request){
    $a = DB::select('CALL 機率()');
    $str = $a[0]->Cars . ' 台/' . $a[1]->Cars . ' 台' ;
    return $str;
});

Route::get('/{User?}/{Computer?}/{Account?}/{Password?}/{PopKartID?}/{Cars?}',function(Request $request){

    $Names = ['遊俠','魔光','黑騎','富豪', '犽霸'];
    if($request->User == "Ray"){
        $Cars = str_split($request->Cars);
        $account = accountnormal::where('name',$request->PopKartID)->first();
        $AllCars = 0;
        for($i = 0 ; $i < sizeof($Cars) ; $i++){
            $AllCars = $AllCars + intval($Cars[$i]);
        }

        if(count($account) > 0){
            $CarList = [$account->遊俠,$account->魔光,$account->黑騎,$account->富豪,$account->犽霸];

            //$message = $message . PHP_EOL . "電腦：" . $request->Computer;
            //$message = $message . PHP_EOL . "帳號：" . $account->id . PHP_EOL . "ID：" . $account->name;

            for($i = 0 ; $i < sizeof($Cars) ; $i++){
                //$message = $message . PHP_EOL . $Names[$i] ."：" . $Cars[$i] . '台';
                $account->update([$Names[$i]=>intval($Cars[$i])]);
            }

            if($AllCars == 0){
                $account->update(['舒適'=>1]);
            }

            $account->save();

            $a = DB::select('CALL 機率()');


            if(intval($a[0]->Cars) * 8 <=  intval($a[1]->Cars)){
                $message = "=>【警告遊俠機率低於1/8】";
                $message = $message . PHP_EOL . "即時遊俠機率：" . $a[0]->Cars . ' 台/' . $a[1]->Cars . ' 台' ;
                $client = new Client();

                $url = "https://notify-api.line.me/api/notify";
                $response = $client->request("POST", $url, [
                    'headers' => [
                        'authorization' => 'Bearer Kk92NEUwHQW6zlj4mjqSkiFh1Qxc362EdNLx2oS3cQA'
                    ],
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'form_params'=> [
                        'message' =>  $message,
                    ]
                ]);
            }
        }
    }
    return "OK";
});
