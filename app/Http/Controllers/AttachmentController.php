<?php namespace App\Http\Controllers;
use App\Attachment;
use View;
use App\Http\Controllers\Util;
use File;
use Response;

class AttachmentController extends Controller {

    public static $RESOURCES_PATH = 'resources';
    public static $USE_FOR_USER_AVATAR= 1;
    public static $USE_FOR_EVENT_ACTIVITY= 2;
    public static $USE_FOR_NEWS= 3;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $items = Attachment::orderBy('name', 'ASC')->paginate(50);
//        $items = Attachment::where('mime', '!=', 'text/plain')->orderBy('name', 'ASC')->paginate(50);
        $search = '';
//        $lectures = Attachment::orderBy('name', 'ASC')->paginate(50);
        return View::make('attachment.view_attachment', compact('items', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $attachment = new Attachment;
        $show = false;
        return View::make('attachment.new_edit_attachment', compact('attachment', 'show'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $att = new Attachment;
        $encode = '';
        if (Input::hasFile('file')) {
            $f = Input::file('file');
        }
        if (Request::get('encode')) {
            $encode = Input::get('encode');
        }

        $att->save();

        $insert_on_db = 'NO';

        if (Request::get('insert_on_db')) {
            $insert_on_db = Input::get('insert_on_db');
        }
        $validator = Validator::make(Input::all(), Attachment::$RULES_CREATE);
        if ($validator->fails()) {
            return Redirect::to('admin/attachment')->withErrors($validator);
        } else {
            if ($f) {
                if ($insert_on_db == 'NO') {
                    AttachmentController::uploadAttachment($f, $att);
                    return Redirect::to('admin/attachment');
                } else if ($insert_on_db == 'SI') {
                    AttachmentController::uploadAttachmentIntoDB($f, $att);
                    return Redirect::to('admin/attachment');
                }
            } else {
                return Redirect::to('admin/attachment')->withErrors(array($f->getError(), $f->getErrorMessage()));
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $attachment = Attachment::find($id);
        if (isset($attachment) && !$attachment->upload_path) {
            $attachment->insert_on_db = 'SI';
        }
        $show = true;
        return View::make('attachment.new_edit_attachment', compact('attachment', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $attachment = Attachment::find($id);
        if (isset($attachment) && !$attachment->upload_path) {
            $attachment->insert_on_db = 'SI';
        }
        $show = false;
        return View::make('attachment.new_edit_attachment', compact('attachment', 'show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $att = Attachment::find($id);
        $encode = '';
        if (Input::hasFile('file')) {
            $f = Input::file('file');
        }
        if (Request::get('encode')) {
            $encode = Input::get('encode');
        }
        $att->save();

        $insert_on_db = 'NO';
        if (Request::get('insert_on_db')) {
            $insert_on_db = Input::get('insert_on_db');
        }

        $validator = Validator::make(Input::all(), Attachment::$RULES_CREATE);
        if ($validator->fails()) {
            return Redirect::to('admin/attachment')->withErrors($validator);
        } else {
            if ($f) {
                $r = array();
                $file_path = public_path() . DIRECTORY_SEPARATOR . $att->upload_path . DIRECTORY_SEPARATOR . $att->name;
                if ($insert_on_db == 'NO') {
                    $r = AttachmentController::uploadAttachment($f, $att);
                } else if ($insert_on_db == 'SI') {
                    $r = AttachmentController::uploadAttachmentIntoDB($f, $att);
                }
                if ($r['valid'] && File::exists($file_path)) {
                    File::delete($file_path);
                }
                return Redirect::to('admin/attachment');
            } else {
                return Redirect::to('admin/attachment')->withErrors(array($f->getError(), $f->getErrorMessage()));
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $att = Attachment::find($id);
        AttachmentController::deleteFile($att);
        $att->delete();
        if (Request::ajax()) {
            return Response::json(array('valid' => true)); //, 'id'=>$id, 'file_path'=>$file_path));
        } else {
            return Redirect::to('admin/attachment');
        }
    }

    /**
     * Metodo para eliminar un archivo del sistema
     * @param Attachment $att
     */
    public static function deleteFile($att) {
        if ($att && $att->upload_path) {
            $file_path = public_path() . DIRECTORY_SEPARATOR . $att->upload_path . DIRECTORY_SEPARATOR . $att->name;
            if (File::exists($file_path)) {
                File::delete($file_path);
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    // SECCION DE CODIGO PARA OTROS USOS
    ////////////////////////////////////////////////////////////////////////////

    /**
     * Metodo para hacer la busqueda de un documente
     */
    public static function search() {
        $items = array();
        $search = '';
        if (Input::get('search')) {
            $search = Input::get('search');
            $arrparam = explode(' ', $search);
            $items = Attachment::whereNested(function($q) use ($arrparam) {
                        $p = $arrparam[0];
                        $q->whereNested(function($q) use ($p) {
                            $q->where('name', 'LIKE', '%' . $p . '%');
                            $q->orwhere('name', 'LIKE', '%' . $p . '%');
                        });
                        $c = count($arrparam);
                        if ($c > 1) {
                            //para no repetir el primer elemento
                            //foreach ($arrparam as $p) {
                            for ($i = 1; $i < $c; $i++) {
                                $p = $arrparam[$i];
                                $q->whereNested(function($q) use ($p) {
                                    $q->where('name', 'LIKE', '%' . $p . '%');
                                    $q->orwhere('name', 'LIKE', '%' . $p . '%');
                                }, 'OR');
                            }
                        }
                    })
                    ->whereNull('deleted_at')
                    ->orderBy('name', 'ASC')
                    ->paginate(10);
            return View::make('attachment.view_attachment', compact('items', 'search'));
        }
    }

    /**
     * Elimina todos los archivos de un elemento
     * @param int $field Campo de busqueda
     * @param int $id ID de la lectura
     * @param int $used_for para que se utiliza el archivo
     * 
     */
    public static function destroyAllBy($field, $id) {
        $arr = array();
        $arr = Attachment::where($field, '=', $id)->get(array('id', 'upload_path', 'name'));
        foreach ($arr as $att) {
            $file_path = public_path() . DIRECTORY_SEPARATOR . $att->upload_path . DIRECTORY_SEPARATOR . $att->name;
            if (File::exists($file_path)) {
                File::delete($file_path);
            }
            $att->delete();
        }
    }

    /**
     * Elimina todos los archivos de un usuario
     * @param int $id ID de la lectura
     */
    public static function destroyAllByUserId($id) {
        $arr = Attachment::where('user_id', '=', $id)->get(array('id', 'upload_path', 'name'));
        foreach ($arr as $att) {
            $file_path = public_path() . DIRECTORY_SEPARATOR . $att->upload_path . DIRECTORY_SEPARATOR . $att->name;
            if (File::exists($file_path)) {
                File::delete($file_path);
                $att->delete();
            }
            $att->delete();
        }
    }

    /**
     * Metodo para generar la URL de un archivo
     * @param int $id Id del Attachment
     * @param string $action view|download|base64
     * <p><b>view: </b>presenta el archivo en el navegador</p>
     * <p><b>download: </b>descarga el archivo</p>
     * <p><b>base64: </b>envia el archivo en base64</p>
     * @param int $used_for Indica para que se usara la URL
     * @return file_url URL del archivo solicitado
     */
    public static function getAttachmentURL($id, $action = 'view') {
        $attachment = Attachment::find($id);
        //$attachment = \DB::table('attachment')->where('user_id', $id)->get();
        $file_url = '';
        if ($attachment) {
            $file_url = public_path() . "/attachment/get/" . $action . "/" . $attachment->id . "/" . MD5($attachment->id . MD5('lorapp'));
        }
        return $file_url;
    }

    /**
     * Metodo para capturar las URL de los archivos relacionados con una entidad
     * como Lectura, Seccion, Contenido, Avatar, etc
     * @param int $id Id de la entidad
     * @param string $relation lecture_id|lecturesection_id|user_id
     * <p><b>lecture_id: </b>Obtiene la URL de los archivos relacionados con lecture</p>
     * <p><b>lecturesection_id: </b>Obtiene la URL de los archivos relacionados con secciones</p>
     * <p><b>user_id: </b>Obtiene la URL de los archivos relacionados con usuarios</p>
     * @param string $action view|download|base64
     * <p><b>view: </b>presenta el archivo en el navegador</p>
     * <p><b>download: </b>descarga el archivo</p>
     * <p><b>base64: </b>envia el archivo en base64</p>
     * @param int $used_for Indica para que se usara la URL
     * @return arr_file_url lista de las URL de la entidad relacionada
     */
    public static function getAttachmentURLByRelationId($id, $relation, $action = 'view', $used_for = 1) {
        $arr_url = array();
        if (intval($id) > 0 && strlen($relation)) {
            $arr_att = array();
            $arr_att = Attachment::where($relation, '=', $id)
                    ->where($relation, '=', $id)
                    //->where('used_for', '=', $used_for)
                    ->get(array('id'));
            foreach ($arr_att as $attachment) {
                $arr_url[] = URL::to('/') . "/attachment/get/" . $action . "/" . $attachment->id . "/" . MD5($attachment->id . MD5('lorapp'));
            }
        }
        if (count($arr_url) == 0) {
            switch ($used_for) {
                case AttachmentController::$USE_FOR_EVENT_ACTIVITY:
                    $arr_url[] = URL::to('/') . "/images/default_event.jpg";
                    break;
                case AttachmentController::$USE_FOR_NEWS:
                    $arr_url[] = URL::to('/') . "/images/default_news.png";
                    break;
                case AttachmentController::$USE_FOR_USER_AVATAR:
                    $arr_url[] = URL::to('/') . "/images/default_user.jpg";
                    break;
            }
        }
        return $arr_url;
    }

    /**
     * 
     * @param string $action view|download|base64
     * <p><b>view: </b>presenta el archivo en el navegador</p>
     * <p><b>download: </b>descarga el archivo</p>
     * <p><b>base64: </b>envia el archivo en base64</p>
     * @param int $id
     * @param string $key MD5($id . MD5('lorapp')). Evita que al cambiar $id se muestre otro archivo
     * @return file
     */
    public static function getAttachment($action, $id, $key = null) {
        $data = '';
        if ($key == MD5($id . MD5('lorapp'))) {
            $file = Attachment::find($id);
            $name = $file->name;
            $mime = $file->mime;
            $size = $file->size;
            $encode = $file->encode;
            $data = ($file->file);
            if ($encode == 'base64') {
                $data = base64_decode($file->file);
            }
            $upload_path = $file->upload_path;
            if ($upload_path) {
                $upload_path = $file_path = public_path() . DIRECTORY_SEPARATOR . $file->upload_path . DIRECTORY_SEPARATOR . $file->name;
                $data = file_get_contents($upload_path);
            }
            if ($action == 'view') {
                return Response::make($data, 200, array('Content-type' => $mime, 'Content-length' => $size));
            } else if ($action == 'download') {
                return Response::make($data, 200, array('Content-type' => $mime, 'Content-length' => $size, 'Content-Disposition' => 'attachment; filename=' . $name));
            } else if ($action == 'base64') {
                return 'data:' . $file->mime . ';base64,' . $data;
            }
        } else if ($action == 'name') {
            $file = Attachment::where('name', '=', $id)->first();
            $name = $file->name;
            $mime = $file->mime;
            $size = $file->size;
            $encode = $file->encode;
            $data = ($file->file);
            if ($encode == 'base64') {
                $data = base64_decode($file->file);
            }
            $data = ($file->file);
            return Response::make($data, 200, array('Content-type' => $mime, 'Content-length' => $size));
        } else {
            return Response::make($data, 200, array('Content-type' => '', 'Content-length' => 0));
        }
    }

    /**
     * Metodo para subir un archivo al servidor y guardarlo en el sistema de archivos
     * @param _FILE $file archivo que se esta subiendo
     * @param Attachment $attachment Entidad con toda la informacion de un archivo a guardar
     * @return Array respuesta del proceso de carga de archivo
     */
    public static function uploadAttachmentArray($file, $attachment = null) {
        $arr = array();
        if (is_array($file)) {
            foreach ($file as $f) {
                $arr[] = AttachmentController::uploadAttachment($f, $attachment);
            }
        } else {
            $arr = AttachmentController::uploadAttachment($file, $attachment);
        }
        return $arr;
    }

    /**
     * Metodo para subir un archivo al servidor y guardarlo en el sistema de archivos
     * @param _FILE $file archivo que se esta subiendo
     * @param Attachment $attachment Entidad con toda la informacion de un archivo a guardar
     * @return Array respuesta del proceso de carga de archivo
     */
    public static function uploadAttachment($file, $attachment = null) {
        $att = $attachment;
        if (!$att) {
            $att = new Attachment;
        }
        $arr_response = array();
        if ($file) {
            if ($file->isValid()) {
                //esto es para eliminar el archivo anterior para evitar que exista basura en el server
                AttachmentController::deleteFile($att);
                $upload_path = AttachmentController::$RESOURCES_PATH . DIRECTORY_SEPARATOR . date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . date('d');
                $destination_path = public_path() . DIRECTORY_SEPARATOR . $upload_path;
                $file_name = date("YmdHis") . '_' . Util::cleanString($file->getClientOriginalName());
//                $file_name = date("YmdHis") . '_' . Util::cleanString($file->getFilename()).$file->getExtension();
                $att->upload_path = $upload_path;
                $att->name = $file_name;
                //se comenta porque se presenta error raro en server VPS de S24
                //get this error: LogicException: Unable to guess the mime type as no guessers are available (Did you enable the php_fileinfo extension?)
                //http://stackoverflow.com/questions/23065703/laravel-4-no-guessers-available-issue
                //uncomment this line in php.ini into php folder.
                //extension=php_fileinfo.dll
//                $att->mime = $file->getMimeType();
                $att->size = $file->getSize();
                $file->move($destination_path, $file_name);
                $att->save();
                $arr_response = array('valid' => true, 'file' => $att,
                    'url_view' => AttachmentController::getAttachmentURL($att->id, 'view', $att->used_for),
                    'url_download' => AttachmentController::getAttachmentURL($att->id, 'download', $att->used_for));
            } else {
                $arr_response = array('valid' => false, 'error' => array($file->getError(), '**' . $file->getErrorMessage()));
            }
        } else {
            $arr_response = array('valid' => false, 'error' => array($file->getError(), $file->getErrorMessage()));
        }
        return $arr_response;
    }

    /**
     * Metodo para subir SOLO IMAGENES al servidor y guardarlo en el sistema de archivos
     * @param _FILE $file archivo que se esta subiendo
     * @param Attachment Entidad con toda la informacion de un archivo a guardar
     * @return JSON respuesta del proceso de carga de archivo
     */
    public static function uploadImages($file, $attachment = '') {
        $arr_response = array();
        $file_image = $file;
        $file = array('image' => $file_image);
        $rules = array('image' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000
        // se valida que sea una imagen, esto es doble verificacion
        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
            $arr_response = array('valid' => false, 'error' => array('error' => $validator));
        } else {
            $arr_response = AttachmentController::uploadAttachment($file, $attachment);
        }
        return $arr_response;
    }

    /**
     * Metodo para subir un archivo al servidor y guardarlo en la base de datos
     * @param _FILE $file archivo que se esta subiendo
     * @param Attachment Entidad con toda la informacion de un archivo a guardar
     * @return JSON respuesta del proceso de carga de archivo
     */
    public static function uploadAttachmentIntoDB($file, $attachment = '') {
        $att = $attachment;
        if (!$att) {
            $att = new Attachment;
        }
        $f = $file;
        if ($f) {
            $att->name = $f->getClientOriginalName();
            $att->mime = $f->getMimeType();
            $att->size = $f->getSize();
            $attfile = (file_get_contents($f->getRealPath()));
            if ($att->encode == 'base64') {
                $attfile = base64_encode(file_get_contents($f->getRealPath()));
            }
            $att->file = $attfile;
            $att->save();
            return Response::json(array('valid' => true));
        } else {
            return Response::json(array('valid' => false, 'error' => array($f->getError(), $f->getErrorMessage())));
        }
    }




}