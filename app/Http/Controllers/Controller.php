<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $response = array('data' => null);

    protected $status = 422;

    protected $statusArr = [
        'success' => 200,
        'not_found' => 404,
        'unauthorised' => 412,
        'already_exist' => 409,
        'validation' => 422,
        'something_wrong' => 405,
        'forbidden' => 403,
    ];

    public function ValidateForm($fields, $rules)
    {
        Validator::make($fields, $rules)->validate();
    }

    public function DTFilters($request)
    {
        $filters = array(
            // 'draw' => $request['draw'],
            'offset' => isset($request['start']) ? $request['start'] : 0,
            'limit' => isset($request['length']) ? $request['length'] : 25,
            'sort_column' => (isset($request['order'][0]['column']) && isset($request['columns'][$request['order'][0]['column']]['data'])) ? $request['columns'][$request['order'][0]['column']]['data'] : 'created_at',
            'sort_order' => isset($request['order'][0]['dir']) ? $request['order'][0]['dir'] : 'DESC',
            'search' => isset($request['search']['value']) ? $request['search']['value'] : '',
        );
        return $filters;
    }

    // public function storeErrorLog($error, $filename = 'laravel', $message = null)
    // {
    //     if (empty($message)) {
    //         $message = trans('api.went_wrong');
    //     }
    //     $this->response['meta']['message'] = $message;

    //     // Add error log
    //     $iqTrackingLog = new Logger($filename);
    //     $iqTrackingLog->pushHandler(new StreamHandler(storage_path('logs/' . $filename . '.log')), Logger::ERROR);
    //     $iqTrackingLog->error($filename, ['error' => $error->getMessage()]);
    // }



    public function apiValidator($fields, $rules, $version = "v.0.0", $message = array())
    {
        $validator = Validator::make($fields, $rules, $message);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $r_message  = '';
            $i = 1;
            foreach ($errors->messages() as $key => $message) {
                if ($i == 1) {
                    $r_message = $message[0];
                } else {
                    break;
                }
                $i++;
            }

            $this->response['meta']['message'] = $r_message;
            // $this->response['meta']['url'] = url()->current();
            // $this->response['meta']['language'] = app()->getLocale();
            // $this->response['meta']['api'] = request()->route()->controller->getVersion();
            return false;
        }
        return true;
    }

    // Send JSON object as response
    public function returnResponse()
    {
        return response()->json($this->response, $this->status);
    }
}
