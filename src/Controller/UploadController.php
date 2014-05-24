<?php

namespace Nkt\ImageBundle\Controller;

use Nkt\ImageBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Gusakov Nikita <dev@nkt.me>
 */
class UploadController extends Controller
{
    public function uploadAction(Request $request, $type)
    {
        $imageManager = $this->getImageManager();
        $om = $this->getDoctrine()->getManager();
        $images = array();
        $errors = array();
        foreach ($request->files as $file) {
            try {
                $images[] = $image = $imageManager->uploadImage($type, $file);
                $om->persist($image);
            } catch (\Exception $e) {
                $errors[$file->getClientOriginalName()] = $e->getMessage();
            }
        }
        $om->flush();

        return new JsonResponse(array(
            'data'   => array_map(function (Image $image) {
                return array(
                    'id'   => $image->getId(),
                    'path' => $image->getPath()
                );
            }, $images),
            'errors' => $errors
        ));
    }

    /**
     * @return \Nkt\ImageBundle\Manager\ImageManager
     */
    protected function getImageManager()
    {
        return $this->container->get('nkt.image_manager');
    }
}
