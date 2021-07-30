<?php

namespace Concrete\Package\ConcreteCmsMarketing\Controller;

use Concrete\Core\Page\Page;
use Concrete\Core\Page\Stack\Stack;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RemoteActivity
{

    private function populateSlotContent(Page $c)
    {
        ob_start();
        foreach($c->getBlocks(STACKS_AREA_NAME) as $b) {
            $b->display();
        }
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }

    public function view()
    {
        $slotA = Stack::getByName('Activity Slot A', 'ACTIVE');
        $slotB = Stack::getByName('Activity Slot B', 'ACTIVE');
        $slotC = Stack::getByName('Activity Slot C', 'ACTIVE');

        $data = [];
        $data['slots'] = [];

        if ($slotA) {
            $data['slots']['A'] = $this->populateSlotContent($slotA);
        }
        if ($slotB) {
            $data['slots']['B'] = $this->populateSlotContent($slotB);
        }
        if ($slotC) {
            $data['slots']['C'] = $this->populateSlotContent($slotC);
        }

        return new JsonResponse($data);
    }

}