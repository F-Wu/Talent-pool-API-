<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Carbon\Carbon;

//管理信息系统
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
//登录
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $userdata = DB::table("admin")->where('username', $username)->where('password', $password)->first();
        if ($userdata != null) {
            return response()->json([
                'msg' => 'ok',
                'code' => 20000,
                'status' => 0,
                'token' => "admin-token",
                'result' => $userdata
            ], 200);
        }
        if ($userdata == null || $userdata == '') {
            return response()->json([
                'msg' => 'no',
                'status' => 'fail',
                'result' => '登录失败，没有该账号消息'
            ], 205);
        }
    }

//验证登录
    public function userInfo(Request $request)
    {
        $token = $request->input('token');
        if ($token == 'admin-token') {
            return response()->json([
                'msg' => 'ok',
                'code' => 20000,
                'status' => 0,
                'token' => "admin-token",
                'name' => "Super Admin",
                'roles' => ['admin'],
                'avatar' => "https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif"
            ], 200);
        }
    }

//    退出登录
    public function logout()
    {
        return response()->json([
            'msg' => 'no',
            'code' => 20000,
            'status' => 'fail',
            'result' => "退出登录"
        ], 200);
    }

//    搜索
    public function search(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $ids = DB::table('information')->where('id', 'like', $id . '%')->where('name', 'like', $name . '%')->get();
//        if ( $ids->count()==0) {
//            $data = '暂无数据';
//        }
//        else{
//            $data = DB::table('information')->where('id', $id[0]->information_id)->get();
//        }

        return response()->json([
            'msg' => 'ok',
            'status' => 0,
            'code' => 20000,
            'data' => $ids,
        ]);
    }

//    ##############  修改


//    个人信息
    public function informationModify(Request $request)
    {
        $id = $request->input('id');
        if (DB::table('information')->where('id', $id)->exists()
        ) {
//            个人信息
            $informationData = DB::table('information')->find($id);
            $informationData->age = is_null($request->age) ? $informationData->age : $request->age;
            $informationData->gender = is_null($request->gender) ? $informationData->gender : $request->gender;
            $informationData->name = is_null($request->name) ? $informationData->name : $request->name;
            $informationData->work = is_null($request->work) ? $informationData->work : $request->work;
            $informationData->img = is_null($request->img) ? $informationData->img : $request->img;
            $informationData->contact = is_null($request->contact) ? $informationData->contact : $request->contact;
            $informationData->expect = is_null($request->expect) ? $informationData->expect : $request->expect;
            $informationData->education_name = is_null($request->education_name) ? $informationData->education_name : $request->education_name;
            $informationData->education = is_null($request->education) ? $informationData->education : $request->education;
            $informationData->number = is_null($request->number) ? $informationData->number : $request->number;
            $informationData->identity = is_null($request->identity) ? $informationData->identity : $request->identity;
            $informationData->marriage = is_null($request->marriage) ? $informationData->marriage : $request->marriage;
            $informationData->deleted = is_null($request->deleted) ? $informationData->disable : $request->deleted;
            $informationData->disable = is_null($request->disable) ? $informationData->disable : $request->disable;
            DB::table('information')->where('id', $id)->update([
                'age' => $informationData->age,
                'gender' => $informationData->gender,
                'name' => $informationData->name,
                'work' => $informationData->work,
                'img' => $informationData->img,
                'contact' => $informationData->contact,
                'expect' => $informationData->expect,
                'education_name' => $informationData->education_name,
                'education' => $informationData->education,
                'number' => $informationData->number,
                'identity' => $informationData->identity,
                'marriage' => $informationData->marriage,
                'deleted' => $informationData->deleted,
                'disable' => $informationData->disable
            ]);
            return response()->json([
                'msg' => 'ok',
                'status' => 0,
                'code' => 20000,
                'information' => $informationData,
            ], 200);
        }
    }

//    教育信息
    public function educationModify(Request $request)
    {
        $id = $request->input('id');
        if (DB::table('education')->where('id', $id)->exists()) {
            $educationData = DB::table('education')->find($id);
            $educationData->project_name = is_null($request->project_name) ? $educationData->project_name : $request->project_name;
            $educationData->role = is_null($request->role) ? $educationData->role : $request->role;
            $educationData->data = is_null($request->data) ? $educationData->data : $request->data;
            $educationData->describe = is_null($request->describe) ? $educationData->describe : $request->describe;
            $educationData->education = is_null($request->education) ? $educationData->education : $request->education;
            $educationData->deleted = is_null($request->deleted) ? $educationData->deleted : $request->deleted;
            DB::table('education')->where('id', $id)->update([
                'project_name' => $educationData->project_name,
                'role' => $educationData->role,
                'data' => $educationData->data,
                'describe' => $educationData->describe,
                'education' => $educationData->education,
                'deleted' => $educationData->deleted,
            ]);
            return response()->json([
                'msg' => 'ok',
                'code' => 20000,
                'status' => 0,
                'data' => $educationData
            ], 200);
        }
    }

//    求职期望
    public function expectModify(Request $request)
    {
        $id = $request->input('id');
        if (DB::table('expect')->where('id', $id)->exists()) {
            $expectData = DB::table('expect')->find($id);
            $expectData->city = is_null($request->city) ? $expectData->city : $request->city;
            $expectData->occupation = is_null($request->occupation) ? $expectData->occupation : $request->occupation;
            $expectData->salary = is_null($request->salary) ? $expectData->salary : $request->salary;
            $expectData->deleted = is_null($request->deleted) ? $expectData->deleted : $request->deleted;
            DB::table('expect')->where('id', $id)->update([
                'city' => $expectData->city,
                'occupation' => $expectData->occupation,
                'salary' => $expectData->salary,
                'deleted' => $expectData->deleted,
            ]);
            return response()->json([
                'msg' => 'ok',
                'status' => 0,
                'code' => 20000,
                'data' => $expectData
            ], 200);
        }
    }

//    项目经历
    public function projectModify(Request $request)
    {
        $id = $request->input('id');
        if (DB::table('project')->where('id', $id)->exists()) {
            $projectData = DB::table('project')->find($id);
            $projectData->project_name = is_null($request->project_name) ? $projectData->project_name : $request->project_name;
            $projectData->role = is_null($request->role) ? $projectData->role : $request->role;
            $projectData->describet = is_null($request->describet) ? $projectData->describet : $request->describet;
            $projectData->data = is_null($request->data) ? $projectData->data : $request->data;
            $projectData->deleted = is_null($request->deleted) ? $projectData->deleted : $request->deleted;
            DB::table('project')->where('id', $id)->update([
                'project_name' => $projectData->project_name,
                'role' => $projectData->role,
                'data' => $projectData->data,
                'describet' => $projectData->describet,
                'deleted' => $projectData->deleted,
            ]);
            return response()->json([
                'msg' => 'ok',
                'code' => 20000,
                'status' => 0,
                'data' => $projectData
            ], 200);
        }
    }

//    工作经历
    public function work_experienceModify(Request $request)
    {
        $id = $request->input('id');
        if (DB::table('work_experience')->where('id', $id)->exists()) {
            $work_experienceData = DB::table('work_experience')->find($id);
            $work_experienceData->company = is_null($request->company) ? $work_experienceData->company : $request->company;
            $work_experienceData->position = is_null($request->position) ? $work_experienceData->position : $request->position;
            $work_experienceData->job_content = is_null($request->job_content) ? $work_experienceData->job_content : $request->job_content;
            $work_experienceData->data = is_null($request->data) ? $work_experienceData->data : $request->data;
            $work_experienceData->work_img = is_null($request->work_img) ? $work_experienceData->work_img : $request->work_img;
            $work_experienceData->video = is_null($request->video) ? $work_experienceData->video : $request->video;
            $work_experienceData->achievement = is_null($request->achievement) ? $work_experienceData->achievement : $request->achievement;
            $work_experienceData->deleted = is_null($request->deleted) ? $work_experienceData->deleted : $request->deleted;
            DB::table('work_experience')->where('id', $id)->update([
                'company' => $work_experienceData->company,
                'position' => $work_experienceData->position,
                'data' => $work_experienceData->data,
                'job_content' => $work_experienceData->job_content,
                'work_img' => $work_experienceData->work_img,
                'video' => $work_experienceData->video,
                'achievement' => $work_experienceData->achievement,
                'deleted' => $work_experienceData->deleted,
            ]);
            return response()->json([
                'msg' => 'ok',
                'status' => 0,
                'code' => 20000,
                'data' => $work_experienceData
            ], 200);
        }
    }

//    管理员
    public function adminModify(Request $request)
    {
        $id = $request->input('id');
        if (DB::table('admin')->where('id', $id)->exists()) {
            $adminData = DB::table('admin')->find($id);
            $adminData->username = is_null($request->username) ? $adminData->username : $request->username;
            $adminData->password = is_null($request->password) ? $adminData->password : $request->password;
            $adminData->disable = is_null($request->disable) ? $adminData->disable : $request->disable;
            $adminData->deleted = is_null($request->deleted) ? $adminData->deleted : $request->deleted;
            DB::table('admin')->where('id', $id)->update([
                'username' => $adminData->username,
                'password' => $adminData->password,
                'disable' => $adminData->disable,
                'deleted' => $adminData->deleted,
            ]);
            return response()->json([
                'msg' => 'ok',
                'code' => 20000,
                'status' => 0,
                'data' => $adminData
            ], 200);
        }
    }

    //    #####################################  添加
//    个人信息
    public function informationAdd(Request $request)
    {
        $id = $request->input('id');
        $age = $request->input('age');
        $gender = $request->input('gender');
        $name = $request->input('name');
        $work = $request->input('work');
        $img = $request->input('img');
        $contact = $request->input('contact');
        $expect = $request->input('expect');
        $education_name = $request->input('education_name');
        $education = $request->input('education');
        $number = $request->input('number');
        $identity = $request->input('identity');
        $marriage = $request->input('marriage');
        $information = DB::table('information')->insert([
            'id' => $id,
            'age' => $age,
            'gender' => $gender,
            'name' => $name,
            'work' => $work,
            'img' => $img,
            'contact' => $contact,
            'expect' => $expect,
            'education_name' => $education_name,
            'education' => $education,
            'number' => $number,
            'identity' => $identity,
            'marriage' => $marriage,
        ]);
        if ($information == true) {
            return response()->json([
                'msg' => 'ok',
                'code' => 20000,
                'status' => 0,
                'result' => '添加成功'
            ]);
        }
        if ($information == false) {
            return response()->json([
                'msg' => 'no',
                'status' => '添加失败',
            ], 205);
        }
    }

//    教育信息
    public function educationAdd(Request $request)
    {
        $id = $request->input('id');
        $project_name = $request->input('project_name');
        $role = $request->input('role');
        $data = $request->input('data');
        $describe = $request->input('describe');
        $education = $request->input('education');
        $educationdata = DB::table('education')->insert([
            'id' => $id,
            'project_name' => $project_name,
            'role' => $role,
            'data' => $data,
            'describe' => $describe,
            'education' => $education
        ]);
        if ($educationdata == true) {
            return response()->json([
                'msg' => 'ok',
                'status' => 0,
                'code' => 20000,
                'result' => '添加成功'
            ]);
        }
        if ($educationdata == false) {
            return response()->json([
                'msg' => 'no',
                'status' => '添加失败',
            ], 205);
        }
    }

//    求职期望
    public function expectAdd(Request $request)
    {
        $id = $request->input('id');
        $city = $request->input('city');
        $occupation = $request->input('occupation');
        $salary = $request->input('salary');
        $expectdata = DB::table('expect')->insert([
            'id' => $id,
            'city' => $city,
            'occupation' => $occupation,
            'salary' => $salary,
        ]);
        if ($expectdata == true) {
            return response()->json([
                'msg' => 'ok',
                'status' => 0,
                'code' => 20000,
                'result' => '添加成功'
            ]);
        }
        if ($expectdata == false) {
            return response()->json([
                'msg' => 'no',
                'status' => '添加失败',
            ], 205);
        }
    }

//    项目经历
    public function projectAdd(Request $request)
    {
        $id = $request->input('id');
        $project_name = $request->input('project_name');
        $role = $request->input('role');
        $describet = $request->input('describet');
        $data = $request->input('data');
        $projectdata = DB::table('project')->insert([
            'id' => $id,
            'project_name' => $project_name,
            'role' => $role,
            'describet' => $describet,
            'data' => $data,
        ]);
        if ($projectdata == true) {
            return response()->json([
                'msg' => 'ok',
                'code' => 20000,
                'status' => 0,
                'result' => '添加成功'
            ]);
        }
        if ($projectdata == false) {
            return response()->json([
                'msg' => 'no',
                'status' => '添加失败',
            ], 205);
        }
    }

//    工作经历 work_experience
    public function work_experienceAdd(Request $request)
    {
        $id = $request->input('id');
        $company = $request->input('company');
        $position = $request->input('position');
        $job_content = $request->input('job_content');
        $data = $request->input('data');
        $work_img = $request->input('work_img');
        $video = $request->input('video');
        $achievement = $request->input('achievement');
        $work_experiencedata = DB::table('work_experience')->insert([
            'id' => $id,
            'company' => $company,
            'position' => $position,
            'job_content' => $job_content,
            'data' => $data,
            'work_img' => $work_img,
            'video'=>$video,
            'achievement' => $achievement
        ]);
        if ($work_experiencedata == true) {
            return response()->json([
                'msg' => 'ok',
                'status' => 0,
                'code' => 20000,
                'result' => '添加成功'
            ]);
        }
        if ($work_experiencedata == false) {
            return response()->json([
                'msg' => 'no',
                'status' => '添加失败',
            ], 205);
        }
    }

//    管理员
    public function adminAdd(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $Admindata = DB::table('admin')->insert([
            'username' => $username,
            'password' => $password
        ]);
        if ($Admindata == true) {
            return response()->json([
                'msg' => 'ok',
                'status' => 0,
                'code' => 20000,
                'result' => '添加成功'
            ]);
        }
        if ($Admindata == false) {
            return response()->json([
                'msg' => 'no',
                'status' => '添加失败',
            ], 205);
        }
    }

//    ##############  删除
//    个人信息
    public function informationRemove(Request $request)
    {
        $id = $request->input('id');
        $information = DB::table('information')->where('id', $id)->delete();
        if ($information != null) {
            return response()->json([
                'msg' => 'ok',
                'status' => 0,
                'code' => 20000,
                'data' => $information,
            ]);
        } else {
            return response()->json([
                'msg' => 'User credential is invalid'
            ]);
        }
    }

//    管理员
    public function adminRemove(Request $request)
    {
        $id = $request->input('id');
        $admin = DB::table('admin')->where('id', $id)->delete();
        if ($admin != null) {
            return response()->json([
                'msg' => 'ok',
                'status' => 0,
                'code' => 20000,
                'data' => $admin,
            ]);
        } else {
            return response()->json([
                'msg' => 'User credential is invalid'
            ]);
        }
    }

//    ##################热门城市
    public function Hotcity()
    {
        $expect = DB::table('expect')
            ->select('city', DB::raw('count(*) as num '))
            ->groupBy('city')
            ->orderBy('num', 'desc')
            ->get();
        return response()->json([
            'msg' => 'ok',
            'status' => 0,
            'code' => 20000,
            'data' => $expect,
        ]);
    }

//    ##################热门职业

    public function Hotoccupation()
    {
        $expect = DB::table('expect')
            ->select('occupation', DB::raw('count(*) as value'))
            ->groupBy('occupation')
            ->orderBy('value', 'desc')
            ->get();
        return response()->json([
            'msg' => 'ok',
            'code' => 20000,
            'status' => 0,
            'data' => $expect,
        ]);
    }

//用户 按创造时间月份分组 （曲线图 ）
    public function users()
    {
        $user = DB::table('information')
            ->whereBetween('create_time', ['2022-01-01', '2022-12-31'])
            ->selectRaw('DATE_FORMAT(create_time,"%Y-%m") as date,COUNT(*) as value')
            ->groupBy('date')
//            ->orderBy('value', 'desc')
            ->get();
        #在进行图表统计的时候直接从数据库取得的数据有的月份可能是没有的,不过月份比较少可直接写死,同样也需要补全
        $year = date('Y', time());
//        $value = json_decode('date', true);
        #一年的月份
        $month = [
            0 => $year . '-01',
            1 => $year . '-02',
            2 => $year . '-03',
            3 => $year . '-04',
            4 => $year . '-05',
            5 => $year . '-06',
            6 => $year . '-07',
            7 => $year . '-08',
            8 => $year . '-09',
            9 => $year . '-10',
            10 => $year . '-11',
            11 => $year . '-12',
        ];
        #循环补全月份0
        foreach ($month as $key => $val) {
            $data[$key] = [
                'date' => $val,
                'value' => 0
            ];
            foreach ($user as $item => $value) {
//                $value = json_decode('date', true);
                if ($val == $value->date) {
                    $data[$key] = $value;
                }
            }
        }
        return response()->json([
            'msg' => 'ok',
            'status' => 0,
            'code' => 20000,
            'data' => $data,
        ]);
    }

//    总人数
    public function totalNumber()
    {
        $totals = DB::table('information')
            ->distinct('id')->count('id');
        return response()->json([
            'msg' => 'ok',
            'status' => 0,
            'code' => 20000,
            'total' => $totals,
        ]);
    }
//   在校
//################获取数据
//教育经历
    public function Geteducation()
    {
        $data = DB::table('education')->get();
        return response()->json([
            'msg' => 'ok',
            'status' => 0,
            'code' => 20000,
            'total' => $data,
        ]);
    }

    //期望
    public function Getexpect()
    {
        $data = DB::table('expect')->get();
        return response()->json([
            'msg' => 'ok',
            'status' => 0,
            'code' => 20000,
            'total' => $data,
        ]);
    }

    //工作经历/在校经历
    public function Getwork_experience()
    {
        $data = DB::table('work_experience')->get();
        return response()->json([
            'msg' => 'ok',
            'status' => 0,
            'code' => 20000,
            'total' => $data,
        ]);
    }

//    经历介绍 project
    public function Getproject()
    {
        $data = DB::table('project')->get();
        return response()->json([
            'msg' => 'ok',
            'status' => 0,
            'code' => 20000,
            'total' => $data,
        ]);
    }
    //    管理员
    public function adminGET( )
    {
        $admin = DB::table('admin')->get();
        if ($admin != null) {
            return response()->json([
                'msg' => 'ok',
                'status' => 0,
                'code' => 20000,
                'data' => $admin,
            ]);
        } else {
            return response()->json([
                'msg' => 'User credential is invalid'
            ]);
        }
    }
//   ################## 职业 树形数据输出 occupation_type

    public function get_all_data()
    {
        //TP 框架查询所有数据：
        //$data = (new UserModel)->select();
        //Laravel 框架查询所有数据：
        $data = DB::table('occupation_type')->get();;
        $new_data = [];
        foreach ($data as $key => $value) {
            $new_data[$key]['id'] = $value->id;
            $new_data[$key]['pid'] = $value->pid;
            $new_data[$key]['name'] = $value->name;
            //... 以此类推
        }

        $res = $this->sort_data($data);
        return response()->json([
            'msg' => 'ok',
            'status' => 0,
            'code' => 20000,
            'data' => $res,
        ]);
    }
    public function sort_data($data, $root = 0)
    {
        // 创建Tree
        $tree = [];
        //创建基于主键的数组引用
        $refer = [];
        foreach ($data as $key => $value_data) {
            $refer[$value_data->id] = &$data[$key];
        }
        foreach ($data as $key => $value_data) {
            // 判断是否存在parent
            $parentId = $value_data->pid;
            if ($root == $parentId) {
                $tree[] = &$data[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent = &$refer[$parentId];
                    $parent->children[] = &$data[$key];
                }
            }
        }

        return $tree;
    }
//    删除职业
    public function occupationRemove(Request $request)
    {
        $id = $request->input('id');
        $admin = DB::table('occupation_type')->where('id', $id)->delete();
        if ($admin != null) {
            return response()->json([
                'msg' => 'ok',
                'status' => 0,
                'code' => 20000,
                'data' => $admin,
            ]);
        } else {
            return response()->json([
                'msg' => 'User credential is invalid'
            ]);
        }
    }
    //    添加
    public function occupationAdd(Request $request)
    {
        $name = $request->input('name');
        $pid=$request->input('pid');
        $expectdata = DB::table('occupation_type')->insert([
            'name' => $name,
            'pid'=>$pid,
        ]);
        if ($expectdata == true) {
            return response()->json([
                'msg' => 'ok',
                'status' => 0,
                'code' => 20000,
                'result' => '添加成功'
            ]);
        }
        if ($expectdata == false) {
            return response()->json([
                'msg' => 'no',
                'status' => '添加失败',
            ], 205);
        }
    }
//    修改
//职业
    public function occupationModify(Request $request)
    {
        $id = $request->input('id');
        if (DB::table('occupation_type')->where('id', $id)->exists()) {
            $occupationData = DB::table('occupation_type')->find($id);
            $occupationData->name = is_null($request->name) ? $occupationData->name : $request->name;
            $occupationData->pid = is_null($request->pid) ? $occupationData->pid : $request->pid;
            $occupationData->type = is_null($request->type) ? $occupationData->type : $request->type;
            $occupationData->remarks = is_null($request->remarks) ? $occupationData->remarks : $request->remarks;
            $occupationData->disable = is_null($request->disable) ? $occupationData->disable : $request->disable;
            DB::table('occupation_type')->where('id', $id)->update([
                'name' => $occupationData->name,
                'pid' => $occupationData->pid,
                'type' => $occupationData->type,
                'remarks' => $occupationData->remarks,
                'disable' => $occupationData->disable
            ]);
            return response()->json([
                'msg' => 'ok',
                'status' => 0,
                'code' => 20000,
                'data' => $occupationData
            ], 200);
        }
    }
//    回显 职业名转到id
public function occupationID(Request $request){
    $name = $request->input('name');
    $id = $request->input('id');
    if ($name==null){
        $occupationData = DB::table('occupation_type')->where('id',$id)->first();
    }
    if ($id==null){
        $occupationData = DB::table('occupation_type')->where('name',$name)->first();
    }
    return response()->json([
        'msg' => 'ok',
        'status' => 0,
        'code' => 20000,
        'data' => $occupationData
    ], 200);
}


}

