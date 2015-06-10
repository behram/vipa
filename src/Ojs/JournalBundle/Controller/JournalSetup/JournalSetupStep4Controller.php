<?php

namespace Ojs\JournalBundle\Controller\JournalSetup;

use Ojs\Common\Controller\OjsController as Controller;
use Ojs\JournalBundle\Document\JournalSetupProgress;
use Okulbilisim\CmsBundle\Entity\Post;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class JournalSetupStep4Controller extends Controller
{
    /**
     * Journal Setup Wizard Step 4 - Saves Journal 's step 4 data
     * @param  Request      $request
     * @param  null         $setupId
     * @return JsonResponse
     */
    public function updateAction(Request $request, $setupId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $em = $this->getDoctrine()->getManager();
        /** @var JournalSetupProgress $setup */
        $setup = $dm->getRepository('OjsJournalBundle:JournalSetupProgress')->find($setupId);
        $journal = $em->getRepository('OjsJournalBundle:Journal')->find($setup->getJournalId());
        $setup->setCurrentStep(2);
        $data = $request->request->all();
        $pages = $data['page'];
        $twig = $this->get('okulbilisimcmsbundle.twig.post_extension');
        foreach ($pages as $page) {
            if (empty($page['title'])) {
                return new JsonResponse(
                    [
                        'success' => "0",
                    ]
                );
            }
            $page_ = new Post();
            $page_
                ->setStatus(1)
                ->setContent($page['content'])
                ->setObject($twig->encode($journal))
                ->setObjectId($journal->getId())
                ->setPostType('default')
                ->setTitle($page['title']);
            $em->persist($page_);
            $em->flush();
        }
        $dm->flush();

        return new JsonResponse(
            array(
                'success' => '1',
            )
        );
    }

    /**
     * manager current journal setup step 4
     * @param  Request      $request
     * @return JsonResponse
     */
    public function managerUpdateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $currentJournal = $this->get("ojs.journal_service")->getSelectedJournal();
        $data = $request->request->all();
        $pages = $data['page'];
        $twig = $this->get('okulbilisimcmsbundle.twig.post_extension');
        foreach ($pages as $page) {
            if (empty($page['title'])) {
                return new JsonResponse(
                    [
                        'success' => "0",
                    ]
                );
            }
            $page_ = new Post();
            $page_
                ->setStatus(1)
                ->setContent($page['content'])
                ->setObject($twig->encode($currentJournal))
                ->setObjectId($currentJournal->getId())
                ->setPostType('default')
                ->setTitle($page['title']);
            $em->persist($page_);
            $em->flush();
        }

        return new JsonResponse(
            array(
                'success' => '1',
            )
        );
    }
}
