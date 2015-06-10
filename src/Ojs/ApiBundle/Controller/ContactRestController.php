<?php
namespace Ojs\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ContactRestController extends FOSRestController
{
    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get Contacts"
     * )
     * @Get("/contacts")
     */
    public function getContactsAction()
    {
        $contacts = $this->getDoctrine()->getRepository('OjsJournalBundle:Contact')->findAll();

        if (!is_array($contacts) && !count($contacts) > 0) {
            throw new HttpException(404, 'Not found. The record is not found or route is not defined.');
        }

        return $contacts;
    }
}
