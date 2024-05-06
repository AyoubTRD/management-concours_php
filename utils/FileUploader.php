<?php
class FileUploader
{
    function uploadFile($file)
    {
        $info = pathinfo($file["name"]);
        $saveFileName = bin2hex(random_bytes(16)) . "." . $info["extension"];

        $dossier = $_SERVER["DOCUMENT_ROOT"] . "/public/files";
        if (!file_exists($dossier)) {
            mkdir($dossier, 0777, true); // Recursive directory creation
        }

        $path = $dossier . "/" . $saveFileName;

        move_uploaded_file($file["tmp_name"], $path);

        return "/public/files/" . $saveFileName;
    }
}
