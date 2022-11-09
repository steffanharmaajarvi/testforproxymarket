<?php

namespace App\Service\Providers;

use App\DTO\ProxyItemDTO;

class AbstractProviderService
{

    /**
     * Get list of proxies
     *
     * @return ProxyItemDTO[]
     * @throws \Exception
     */
    public function getList(): array
    {

        $returnList = [];
        for ($i = 0; $i <= random_int(2, 999); $i++) {
            $proxyItem = new ProxyItemDTO();
            $proxyItem->password = uniqid();
            $proxyItem->ip = $this->generateRandomIP();
            $proxyItem->login = uniqid();
            $proxyItem->port = random_int(1, 65535);
            $returnList[] = $proxyItem;
        }

        return $returnList;
    }

    private function generateRandomIP(): string
    {

        return implode('.', [
            random_int(0, 255),
            random_int(0, 255),
            random_int(0, 255),
            random_int(0, 255),
        ]);

    }

}
