<?php

namespace App\Http\Controllers;

use Faker\Core\Number;
use http\Env\Response;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
//搜索
    public function search(Request $request)
    {
        $city = $request->input('city');
        $occupation = $request->input('occupation');
        $id = DB::table('expect')->where('city', 'like','%'. $city . '%')->where('occupation', 'like', '%'.$occupation . '%')->select('id')->get();
        if ($id->count() == 0) {
            $data = '暂无数据';
        } else {
            for ($x = 0; $x <= $id->count(); $x++) {
                $id[0]->id;
                $data = DB::table('information')->where('id', $id[0]->id)->get();
            }
//            $data = DB::table('information')->where('id', $id[0]->id)->get();
//            $id[0]->id
//            for ($x=0; $x<=$id->count(); $x++){
//                $id[$x]->id;
//            }
        }

        return response()->json([
            'msg' => 'ok',
            'status' => 0,
            'code' => 20000,
            'data' => $data,
        ]);
    }

//    城市
    public function city()
    {
        $cityLetter = DB::table('city')->where('p_code', 0)->get();
        $city = DB::select('SELECT * FROM `city` WHERE `p_code` != 0');
        return response()->json([
            'msg' => 'ok',
            'status' => 0,
            'code' => 20000,
            'letter' => $cityLetter,
            'city' => $city
        ]);
    }

//    职业
    public function occupation()
    {
        $occupation = DB::table('occupation_type')->where('type', 0)->get();
        $first = DB::table('occupation_type')->where('pid', 0)->get();
        return response()->json([
            'msg' => 'ok',
            'code' => 20000,
            'status' => 0,
            'first' => $first,
            'occupation' => $occupation
        ]);
    }


//    最热
    public function Hottest()
    {
//        $nmu = DB::table('information')->count();
        $data = DB::select('select * from information order by number desc ;');
//        for ($i = 0; $i < $nmu; $i++) {
//            $id = $data[$i]->id;
//            $education = DB::table('education')->where('inf_id', $id)->get();
//            $educations[] = $education;
//        }
        return response()->json([
            'msg' => 'ok',
            'status' => 0,
            'code' => 20000,
            'data' => $data
//            'education' => $educations
        ], 200);
    }

//最新 newest
    public function newest()
    {
//        select * from MyTable Order By ModifyTime Desc
        $data = DB::select(' select * from information Order By update_time Desc');
        return response()->json([
            'msg' => 'ok',
            'code' => 20000,
            'status' => 0,
            'data' => $data
        ], 200);
    }

//    详情
    public function details(Request $request)
    {
        $id = $request->input('id');
        $information = DB::table('information')->where('id', $id)->get();
        $education = DB::table('education')->where('id', $id)->get();
        $expect = DB::table('expect')->where('id', $id)->get();
        $project = DB::table('project')->where('id', $id)->get();
        $work_experience = DB::table('work_experience')->where('id', $id)->get();
        return response()->json([
            'msg' => 'ok',
            'code' => 20000,
            'status' => 0,
            'information' => $information,
            'education' => $education,
            'expect' => $expect,
            'project' => $project,
            'work_experience' => $work_experience
        ], 200);
    }

//    登录
    public function userLogo(Request $request)
    {
        $phone = $request->input('phone');
        $password = $request->input('password');
        $likes = DB::table('user')->where('phone', $phone)->where('password', $password)->get();
        return response()->json([
            'msg' => 'ok',
            'code' => 20000,
            'status' => 0,
            'data' => $likes
        ], 200);

    }

//    注册
    public function userAdd(Request $request)
    {
        $phone = $request->input('phone');
        $password = $request->input('password');
        $Userdata = DB::table('user')->insert([
            'phone' => $phone,
            'password' => $password
        ]);
        if ($Userdata == true) {
            $likes = DB::table('user')->where('phone', $phone)->where('password', $password)->get();
            return response()->json([
                'msg' => 'ok',
                'status' => 0,
                'code' => 20000,
                'data' => $likes,
                'result' => '添加成功'
            ]);
        }
        if ($Userdata == false) {
            return response()->json([
                'msg' => 'no',
                'status' => '添加失败',
            ], 205);
        }
    }

//    收藏
    public function collection(Request $request)
    {
        $phone = $request->input('phone');
        $password = $request->input('password');
        $id = $request->input('id');
        if (DB::table('information')->where('id', $id)->exists()) {
//            +1
            $occupation = DB::table('information')->find($id);
            $occupation->number = $occupation->number + 1;
////            用户收藏
            DB::table('information')->where('id', $id)->update([
                'number' => $occupation->number,
            ]);

            $Like = DB::table('like')->insert([
                'phone' => $phone,
                'likes' => $id,
                'password' => $password
            ]);
            $Likedata = DB::table('like')->where('phone', $phone)->where('password', $password)->get();
            if ($Like == true) {
                return response()->json([
                    'msg' => 'ok',
                    'status' => 0,
                    'code' => 20000,
                    'data' => $occupation,
                    'likes' => $Likedata
                ], 200);
            } else {
                return response()->json([
                    'msg' => 'no',
                    'status' => '添加失败',
                ], 205);
            }

        }
    }

//    获取收藏
    public function collectionGet(Request $request)
    {
        $phone = $request->input('phone');
        $password = $request->input('password');
        $data = DB::table('like')->where('phone', $phone)->where('password', $password)->get();
        return response()->json([
            'msg' => 'ok',
            'status' => 0,
            'code' => 20000,
            'data' => $data,
        ], 200);
    }
}
