<?php

namespace App\Http\Controllers;

use App\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Qiniu\Storage\UploadManager;
use Qiniu\Auth;
class Kao extends Controller
{
    public  function  add(){
        $data=DB::table('flights')->get();
        return view('add',compact('data'));
    }

    public function querys()
    {

        require_once "./QueryList/QueryList.php";
        require_once "./QueryList/phpQuery.php";

        // 待采集的页面地址
        $url = 'http://www.techweb.com.cn/newgame/';

// 采集规则
        $rules = [
            // 文章标题
            'ttitle' => ['.news_title>h3>a', 'text'],
            'img' => ['.clearfix>a>img', 'src'],
            'text' => ['.news_text>p', 'html']
        ];

        $data = @\QL\QueryList::Query($url, $rules)->data;

        foreach ($data as $k => $v) {
            $jpg = file_get_contents($v['img']);
            $ko = pathinfo($v['img'], PATHINFO_EXTENSION);
            $img = 'imgs/' . rand(1, 99999) . '.' . $ko;
//            print_r($img);
            file_put_contents($img, $jpg);
//        }
            $kot = DB::table('flights')->insert($data);
            if ($kot) {
                return '抓取成功';
            } else {
                return '抓取失败';
            }
        }
    }
    public function queryss(){
        require_once "./QueryList/QueryList.php";
        require_once "./QueryList/phpQuery.php";

        $id=DB::table('flights')->value('lot');
        // 待采集的页面地址
        $url = $id;
        $rules = [
            // 文章标题
            'ttitle' => ['.news_title>h3>a', 'text'],
        ];

        $data = @\QL\QueryList::Query($url, $rules)->data;
    }
//    添加页面
    public function tian(){
        return view('tian');
    }
//    图片上传
    public function lotimg(Request $request){
        if ($request->hasFile('img')){
            $data=$request->file('img')->store('imgs');
            $img = Image::make(public_path($data));
//            $img->text(('2021/1/28'),'bottom-right',10, 10);
            $img->text('2021/1/28.', 120, 100);
            $im=$img->save();
            $ko=$im->basename;
            $data='/imgs/'.$ko;
//            dump($data);
//            秘钥
            $ak="i823JQs3EZMXhqg3LBlOTwDD5iqVZXZmqLsCUqIs";
            $sk="uSVT59ZIn7hOHJV-UcLo4W-A5pQaREDirR_F7JnF";
            $uploadMgr = new UploadManager();
            $auth = new Auth($ak,$sk);
            $token = $auth->uploadToken('jmin');
            list($ret, $error) = $uploadMgr->putFile($token, time(), '.'.$data);


        }
        return ['msg'=>'ok','code'=>200,'data'=>$data];

    }
//    添加
    public function save(Request $request){
        $data=$request->except('_token');
        $kot=DB::table('flights')->insert($data);
        if ($kot){
            return redirect()->action('Kao@add');
        }else{
            return redirect()->action('Kao@tian');
        }

    }

//    删除
    public function delete(Request $request){
            $data=$request->except('_token');
            $kot=DB::table('flights')->where('id',$data['id'])->delete();
             Log::info('Showing user profile for user');
            return ['code'=>200,'msg'=>'ok','data'=>$kot];
    }


    public function list(){
        $data=DB::table('flights')->get();
        if ($data){
            return ['code'=>200,'msg'=>'ok','data'=>$data];
        }else{
            return ['code'=>500,'msg'=>'no','data'=>$data];
        }
    }

    public function lotca(Request $request){
        $id=$request->all();
        $data=DB::table('flights')->where('id',$id['id'])->get();
        if ($data){
            return ['code'=>200,'msg'=>'ok','data'=>$data];
        }else{
            return ['code'=>500,'msg'=>'NO','data'=>$data];
        }
    }










}
