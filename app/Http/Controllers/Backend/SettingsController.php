<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Settings;
use File, Session, DB, Auth;

class SettingsController  extends Controller
{
    public function index(Request $request)
    {              
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');

        return view('backend.settings.index', compact( 'settingArr'));
    }

    public function update(Request $request){

    	$dataArr = $request->all();

    	$this->validate($request,[            
            'site_name' => 'required',            
            'site_title' => 'required',            
            'site_description' => 'required',            
            'site_keywords' => 'required',                                    
        ],
        [            
            'site_name.required' => 'Bạn chưa nhập tên site',            
            'site_title.required' => 'Bạn chưa nhập meta title',
            'site_description.required' => 'Bạn chưa nhập meta desciption',
            'site_keywords.unique' => 'Bạn chưa nhập meta keywords.'
        ]);  

    	if($dataArr['logo'] && $dataArr['logo_name']){
            
            $tmp = explode('/', $dataArr['logo']);

            if(!is_dir('uploads/'.date('Y/m/d'))){
                mkdir('uploads/'.date('Y/m/d'), 0777, true);
            }

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('icho.upload_path').$dataArr['logo'], config('icho.upload_path').$destionation);
            
            $dataArr['logo'] = $destionation;
        }

        if($dataArr['favicon'] && $dataArr['favicon_name']){
            
            $tmp = explode('/', $dataArr['favicon']);

            if(!is_dir('uploads/'.date('Y/m/d'))){
                mkdir('uploads/'.date('Y/m/d'), 0777, true);
            }

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('icho.upload_path').$dataArr['favicon'], config('icho.upload_path').$destionation);
            
            $dataArr['favicon'] = $destionation;
        }

        if($dataArr['banner'] && $dataArr['banner_name']){
            
            $tmp = explode('/', $dataArr['banner']);

            if(!is_dir('uploads/'.date('Y/m/d'))){
                mkdir('uploads/'.date('Y/m/d'), 0777, true);
            }

            $destionation = date('Y/m/d'). '/'. end($tmp);
            
            File::move(config('icho.upload_path').$dataArr['banner'], config('icho.upload_path').$destionation);
            
            $dataArr['banner'] = $destionation;
        }        

        $dataArr['updated_user'] = Auth::user()->id;

        unset($dataArr['_token']);
        unset($dataArr['logo_name']);
        unset($dataArr['favicon_name']);
        unset($dataArr['banner_name']);

    	foreach( $dataArr as $key => $value ){
    		$data['value'] = $value;
    		Settings::where( 'name' , $key)->update($data);
    	}

    	Session::flash('message', 'Cập nhật thành công.');

    	return redirect()->route('settings.index');
    }
}
