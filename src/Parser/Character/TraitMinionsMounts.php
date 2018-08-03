<?php

namespace Lodestone\Parser\Character;

use Lodestone\Entity\Character\Minion;
use Lodestone\Entity\Character\Mount;

trait TraitMinionsMounts
{
    /**
     * Parse minions and mounts
     */
    protected function parseMinionAndMounts()
    {
        $box = $this->getSpecial__Collectables();

        // check mounts and minions exist (new characters don't have them)
        if (!$box || !$box->find('.character__mounts', 0) || !$box->find('.character__minion', 0)) {
            return;
        }

        // get mounts
        foreach ($box->find('.character__mounts ul li') as &$node) {
            $this->profile->Mounts[] = $this->parseCommon($node, new Mount());
        }

        // get minions
        foreach ($box->find('.character__minion ul li') as &$node) {
            $this->profile->Minions = $this->parseCommon($node, new Minion());
        }

        // fin
        unset($box);
    }

    /**
     * Common html parser for collectibles based on type
     */
    protected function parseCommon($node, $obj)
    {
        $name = trim($node->find('.character__item_icon', 0)->getAttribute('data-tooltip'));

        $obj->Name   = $name;
        $obj->Server = $this->getImageSource($node->find('img', 0));

        unset($node);
        return $obj;
    }
}
