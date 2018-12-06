<?php 
namespace App\Http\Controllers\city;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\City;

use Cache;

use Mail;

class CityController extends Controller{
	// 展示
	public function cityindex(){
		$data =City::showCity();
		return view('city.cityindex',['data'=>$data]);
	}
	// 城市添加
	public function cityinsert(Request $request){
		if($request->isMethod('post')){
			// 获取表单的全部信息
            $data = $request->all();
            // 模型的静态方法调用
            $info= City::addCity($data);
            // 判断
            if($info){
            	return redirect('cityindex');
            }else{
            	return redirect('cityinsert');
            }
		}else{
			// 展示添加页面
			// return view('city.cityinsert');
			$data = City::showCity();
			return view('city.cityinsert',['data'=>$data]);
		}
	}
	// 删除
	public function citydel(){
		$del = City::del();
		if($del){
			return redirect('cityindex');
		}else{
			return redirect('cityindex');
		}
	}
	// 修改
	public function cityupdate(Request $request){
		if($request->isMethod('post')){
            
		}else{
			$id = $_GET['id'];
			$data = DB::table('jy_city')->get();
			$info = DB::table('jy_city')->where('id',$id)->first();
			return view('city.cityupdate',['data'=>$data,'info'=>$info]);
		}
	}

	// 邮箱发送
	public function email(){
			Mail::raw('郝云平台',function($message){
			$message->from('13521079921@163.com','飞机');
			$message->subject('您好 请验证一下');
			$message->to('1270657697@qq.com');
		});
	}
		//cache1  用来存储chche
	public function cache1(){
		// Cache::put("haoyun123","郝云",10);//设置
		Cache::put('feiji','到底是谁再呼唤',1);
		// add 与  put  使用及流程  注意事项：
		// $demo=Cache::add("lidengke","李登科123",10);
		// 永久缓存
		// Cache::forever("zhengruiqi","你就好好睡吧，累了我给你开假条，回家休息");

	}
	//chche2  用来读取chache
	public function cache2(){
		$rel = Cache::get('feiji');
		var_dump($rel);
		// $cache=Cache::get("haoyun");//读取
		// var_dump($cache);
		// var_dump(Cache::get('lidengke'));
		//has  用来检测缓存是否存在   检测（名）  +  流程控制语句
		// echo Cache::get('haoyun123','这个问题我得想想了');//只有键名   根据键名  读取缓存信息
		//echo Cache::get("zhengruiqis","好的，你给我假条我回家休息去吧");  //键名  值  
		//，如果不存在时才生效
		// $demo=Cache::get("haoyunss",function(){
			// return DB::table("表名")->select("手机号","用户名")->first();
		// });
		// print_r($demo);
		//应用场景：
		//1.顶部导航
		//2.登陆模块
		//3.注册模块
	}
	// 用接口调用数据
	public function cityapi(){
		$result = file_get_contents("http://www.laravel55.com/city");
		// 将json转化成数组
		$rel = json_decode($result,true);
		// 关于如何设置缓存
		Cache::Put('result',$rel,120);
		if(Cache::has('result')){
			$rel = Cache::get('result');
		}
		return view('city.cityapi',['rel'=>$rel]);
		// print_r($rel);
	}
}

 ?>