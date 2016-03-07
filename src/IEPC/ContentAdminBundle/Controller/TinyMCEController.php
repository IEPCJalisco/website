<?php  namespace IEPC\ContentAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TinyMCEController extends Controller
{
    public function uploadAction(Request $request)
    {

        $files = $request->files;

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
            'location' => '/media/foo.jpg'
        ]);
    }

    public function browseAction(Request $request)
    {
        return new JsonResponse([
            'a' => 1
        ]);
    }
}