<?php


namespace App\Models;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use \Google_Client;
use \Google_Service;
use \Google_Service_Drive;

class gdrive
{
    //Para la descarga
    var $remoteFileName = NULL;
    var $ch = NULL;
    var $headers = array();
    var $response = NULL;
    var $fp = NULL;
    var $debug = FALSE;
    var $fileSize = 0;
    var $enlace="";

    const DEFAULT_FNAME = 'remote.out';





    //Descargar con CURL
    public function __construct($url=false)
    {
        if($url) {
            $id_archivo = $this->obtener_id_de_url($url);
            $url_nuevo="https://drive.google.com/uc?export=download&id=$id_archivo";
            $this->enlace=$url_nuevo;
            $this->init($url_nuevo);
        }

    }

    public function toggleDebug()
    {
        $this->debug = !$this->debug;
    }

    public function init($url)
    {
        if( !$url ) {
            throw new InvalidArgumentException("Need a URL");
        }


        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_HEADERFUNCTION,
            array($this, 'headerCallback'));
        curl_setopt($this->ch, CURLOPT_WRITEFUNCTION,
            array($this, 'bodyCallback'));
    }

    public function headerCallback($ch, $string)
    {
        $len = strlen($string);
        if( !strstr($string, ':') )
        {
            $this->response = trim($string);
            return $len;
        }
        list($name, $value) = explode(':', $string, 2);
        if( strcasecmp($name, 'Content-Disposition') == 0 )
        {
            $parts = explode(';', $value);
            if( count($parts) > 1 )
            {
                foreach($parts AS $crumb)
                {
                    if( strstr($crumb, '=') )
                    {
                        list($pname, $pval) = explode('=', $crumb);
                        $pname = trim($pname);
                        if( strcasecmp($pname, 'filename') == 0 )
                        {
                            // Using basename to prevent path injection
                            // in malicious headers.
                            $this->remoteFileName = basename(
                                $this->unquote(trim($pval)));
                            $this->fp = fopen($this->remoteFileName, 'wb');
                        }
                    }
                }
            }
        }

        $this->headers[$name] = trim($value);
        return $len;
    }
    public function bodyCallback($ch, $string)
    {
        if( !$this->fp )
        {
            //trigger_error("No remote filename received, trying default", E_USER_WARNING);
            $this->remoteFileName = self::DEFAULT_FNAME;
            $this->fp = fopen($this->remoteFileName, 'wb');
            if( !$this->fp )
                throw new RuntimeException("Can't open default filename");
        }
        $len = fwrite($this->fp, $string);
        $this->fileSize += $len;
        return $len;
    }

    public function download()
    {
        $retval = curl_exec($this->ch);
        if( $this->debug )
            var_dump($this->headers);
        fclose($this->fp);
        curl_close($this->ch);
        return $this->fileSize;
    }

    public function getFileName() { return $this->remoteFileName; }

    private function unquote($string)
    {
        return str_replace(array("'", '"'), '', $string);
    }

    public  function obtener_id_de_url($url="") {
        $pedazos = explode("/",$url);
        $total = count($pedazos);
        return $pedazos[$total-2];

    }

    public  function descargar_archivo($url) {

        $url="https://drive.google.com/uc?export=download&id=$id";

        $archivo=file_get_contents($url);
        //Proceso de carga
        $mes = date("Ym");
        $nuevo_nombre = uniqid() . '.' . $ext;
        //$filename = $archivo->store("public/$mes");
        try {
            //Crear carpeta
            $con_mes =  "public/$mes";
            //File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
            if(!File::exists($con_mes)) {

                Storage::makeDirectory($con_mes, 0777, true, true);
            }



            $filename = $archivo->storeAs(
                "public/$mes", $nuevo_nombre
            );
            $size = $request->file('file')->getSize();
            $url = Storage::url($filename);
            $respuesta->exito = 1;
            $respuesta->mensaje="Archivo cargado con éxito";
            $respuesta->archivo=$filename;
            $respuesta->url = $url;
            $respuesta->tamano=self::convert_filesize($size);
        } catch (\Exception $e) {
            $respuesta->exito = 2;
            $respuesta->mensaje = "Error al cargar el archivo '$nuevo_nombre', favor de reportar este problema.";
        }

    }
    public static function enlaces() {
        //con todos
        $enlace[]="https://drive.google.com/file/d/1MNshdKOqfdCXJHQNi8VeivGf1Ms5e9Z9/view?usp=sharing";
        //Con la comision
        $enlace[]="https://drive.google.com/file/d/1JAr2fETk7s1Q6aHS7mzk_w6C_GuApsDP/view?usp=sharing";
        //Otro
        $enlace[]="https://drive.google.com/file/d/1NkZXtRod2skVfUzVXTlwFxGl7_81FjLz/view?usp=sharing";
        return $enlace;
    }

    public  function prueba($url= "https://drive.google.com/file/d/1NkZXtRod2skVfUzVXTlwFxGl7_81FjLz/view?usp=sharing") {

        //$client = new Google_Client();
        $client = $this->getClient();

        $service = new \Google_Service_Drive($client);
        $file_id = $this->obtener_id_de_url($url);
        $content = $service->files->get($file_id, array("alt" => "media"));
        $outHandle = fopen("/", "w+");
        while (!$content->getBody()->eof()) {
            fwrite($outHandle, $content->getBody()->read(1024));
        }

        // Close output file handle.

        fclose($outHandle);
        echo "Done.\n";


    }

    function getClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Drive API PHP Quickstart');
        $client->setScopes(Google_Service_Drive::DRIVE_METADATA_READONLY);
        $client->setAuthConfig('credentials.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = 'token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }

    function leer_credenciales() {
        return '{"web":{"client_id":"9893594183-4l31hh993d5mtgb0h842shhg37mah3n0.apps.googleusercontent.com","project_id":"entrevistas-de-esclarecimiento","auth_uri":"https://accounts.google.com/o/oauth2/auth","token_uri":"https://oauth2.googleapis.com/token","auth_provider_x509_cert_url":"https://www.googleapis.com/oauth2/v1/certs","client_secret":"xnLcMs-JiIOZJfsciknJYW8A","redirect_uris":["https://expedientes.grupovesica.com/callback","https://capacitacion.comisiondelaverdad.co/callback","https://sim.comisiondelaverdad.co/callback","https://capacitacion.comisiondelaverdad.co/expedientes/public/callback","https://sim.comisiondelaverdad.co/expedientes/public/callback","https://sim2.comisiondelaverdad.co/expedientes/public/callback","https://sim3.comisiondelaverdad.co/expedientes/public/callback","https://capacitacion.comisiondelaverdad.co/cendoc/public/callback","https://capacitacion.comisiondelaverdad.co/lili/public/callback"],"javascript_origins":["https://expedientes.grupovesica.com","https://expedientes.test","https://capacitacion.comisiondelaverdad.co","https://sim.comisiondelaverdad.co","https://sim2.comisiondelaverdad.co","https://sim3.comisiondelaverdad.co"]}}';
    }


}