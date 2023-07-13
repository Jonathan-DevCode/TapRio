<?php

@session_start();

Class Upload {

    public function __construct() {
        if (!isset($_SESSION["NOTIFY_UPLOAD_CAMPO"])) {
            $_SESSION["NOTIFY_UPLOAD_CAMPO"] = array();
        }
    }

    public function foto() {
        global $paths;
        $ds = DIRECTORY_SEPARATOR;
        $storeFolder = $paths['upload-foto'];
        $dir = Http::base_dir() . $ds;
        if (!empty($_FILES)) {
            $contrato_id = Post::get('contrato_id', 'int');
            $tempFile = $_FILES['file']['tmp_name'];
            $filename = Filter::img_slug("$contrato_id-" . $_FILES['file']['name']);
            $targetPath = $dir . $storeFolder . $ds;
            $targetFile = $targetPath . $filename;
            move_uploaded_file($tempFile, $targetFile);
            $app = new appModel;
            $sql = "INSERT INTO foto (foto_path,foto_contrato) VALUES ('$filename','$contrato_id');";
            $app->db->query("$sql");
            //atualiza dataAlt contrato
            (new contratoModel)->touch($contrato_id);
            echo json_encode(array('id' => $contrato_id, 'url' => Filter::img_slug("$filename")));
        }
    }

    public function downloadZIP() {

        require_once 'helpers/Streamer.php';
        require_once 'helpers/Streamer.php';
        $pathdoc = "media/docs";
        $zip = new ZipArchive();
        $zip_file = "new.zip";
        $zip->open($zip_file, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
        $path_http = Http::base_dir() . "/" . $pathdoc . "/";
        $zip->addFile($path_http, "foo.pdf");
        $zip->addFromString("LEIAME.TXT", "$leiame");
        $zip->close();
        @header("Content-disposition: attachment; filename=$zip_file");
        @header("Content-type: application/zip");
        @readfile($zip_file);

        @unlink($zip_file);
    }

}
