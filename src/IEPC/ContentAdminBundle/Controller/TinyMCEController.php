<?php  namespace IEPC\ContentAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TinyMCEController extends Controller
{
    public function uploadAction(Request $request)
    {
        $files = $request->files;

        if ($files->count() != 1) {
            throw new \HttpInvalidParamException();
        }
        else {
            $file = $files->get('upload_file');

            $this->getParameter('content')['tmp_dir'];
            $tempUpload = $this->get('kernel')->getRootDir() . '/../web/media/_tmp';

            $guesser = ExtensionGuesser::getInstance();
            $extension = $guesser->guess($file->getMimeType())?: $file->getClientOriginalExtension();

            $filename = uniqid('iepc') . '.' . $extension;
            touch("{$tempUpload}/{$filename}");

          $file->move($tempUpload, $filename);
        }

        /**
         * Saves file to public url
         *   Stores reference in session with token pointing to content
         *   When content got an id move the files to permanent location
         *  /media/section-fullpath/filename
         *
         * -- Create a File object? maybe
         *
         * eg. /media/participacion-ciudadana/democracia-directa/inclusion/001.jpg
         */

        return new JsonResponse([
            'location' => '/media/_tmp/' . $filename . '?iepc_tmp',
            'fileName' => 'filename'
        ]);
    }

    public function cleanTempFiles()
    {
        // Search uploadFiles directory and clear files
    }
}