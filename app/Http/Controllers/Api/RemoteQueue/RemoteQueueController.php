<?php 

namespace App\Http\Controllers\Api\RemoteQueue;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Section;
use App\Models\Setting;
use App\Models\TokenSetting;
use App\Traits\ApiResponses;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RemoteQueueController extends Controller
{
    use ApiResponses;


    /**
     * device Login
     * 
     */
    public function remoteQueueLogin(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'app_id' =>  ['required', 'exists:department,app_id'],
                'password'  =>  ['required']
            ]);

            if($validator->fails())
            {
                return $this->error($validator->errors()->first(), 400, $request->all());
            }

            $query = Department::where('app_id', $request->app_id);
            $data = $request->only('app_id');

            if($query->exists())
            {
                $raw = $query->first();

                if(Hash::check($request->password, $raw->app_password))
                {
                    $data['last_login_at'] = date("Y-m-d H:i:s");
                    $data['bearer_token'] = $raw->id . '|' .\Illuminate\Support\Str::random(40);
                    $data['location_id'] = $raw->id;

                    $data['company_name'] = Setting::where('company_id', $raw->company_id)->first()->title;
                    $data['services'] = $this->getSections($raw->id);

                    $query->update(
                        [
                            'last_login_at' =>  $data['last_login_at'],
                            'api_token'     =>  $data['bearer_token']
                        ]
                    );

                    return $this->success($data, 'login success');
                }

                return $this->error('Password not matched. Please enter valid information', 400, $request->all()); 
            }
            else
            {
                return $this->error('App Id deos not exists. Please enter valid information', 400, $request->all());
            }
        }
        catch(Exception $e)
        {
            return $this->error($e->getMessage(), 400, $request->all());
        }
    }


    protected function getSections($departmentId)
    {
        $rows = TokenSetting::where('department_id', $departmentId)
                ->latest()
                ->groupBy('section_id')
                ->get();


        if($rows->count() > 0)
        {
            $sections = [];
            foreach($rows as $row)
            {
                $s = Section::find($row->section_id);

                $sections[] = [
                    'service_id'    => $s->id,
                    'service_name'  => $s->name
                ];
            }
        }

        return $sections ?? [];
    }
}