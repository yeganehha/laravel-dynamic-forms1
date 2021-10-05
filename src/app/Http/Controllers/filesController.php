<?php
namespace Yeganehha\DynamicForms\app\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class filesController extends Controller
{
    public function dl(){
        if( substr(Storage::mimeType(request('path')), 0, 5) == 'image') {
            $name = Storage::path(request('path')) ;
            $fp = fopen($name, 'rb');
            header("Content-Type: ". Storage::mimeType(request('path')) );
            header("Content-Length: " . Storage::size(request('path')) );
            fpassthru($fp);
            return null;
        } else
            return Storage::download(request('path'));
    }
}
