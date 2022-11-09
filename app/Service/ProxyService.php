<?php

namespace App\Service;

use App\DTO\ProxyItemDTO;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Container\Container;

class ProxyService
{

    public const IP_PORT_LOGIN_PASSWORD_FORMAT = 'ip:port@login:password';
    public const IP_PORT_FORMAT = 'ip:port';
    public const IP_FORMAT = 'ip';
    public const IP_LOGIN_PASSWORD_FORMAT = 'ip@login:password';

    public const ALLOWED_FORMATS = [
        self::IP_PORT_LOGIN_PASSWORD_FORMAT,
        self::IP_PORT_FORMAT,
        self::IP_FORMAT,
        self::IP_LOGIN_PASSWORD_FORMAT
    ];

    public function export(
        array $proxies,
        string $format
    ): string
    {
        $proxyListFormated = array_map(function (ProxyItemDTO $itemDTO) use ($format) {
            return [$this->makeProxyByFormat($itemDTO, $format)];
        }, $proxies);

        return $this->toCSV($proxyListFormated);
    }

    /**
     * @throws \Exception
     */
    private function makeProxyByFormat(
        ProxyItemDTO $itemDTO,
        string $format
    ): string
    {

        switch ($format) {
            case self::IP_LOGIN_PASSWORD_FORMAT:
                return sprintf(
                    "%s@%s:%s",
                    $itemDTO->ip,
                    $itemDTO->login,
                    $itemDTO->password
                );
            case self::IP_FORMAT:
                return $itemDTO->ip;
            case self::IP_PORT_FORMAT:
                return sprintf(
                    "%s:%s",
                    $itemDTO->ip,
                    $itemDTO->port
                );
            case self::IP_PORT_LOGIN_PASSWORD_FORMAT:
                return sprintf(
                    "%s:%s@%s:%s",
                    $itemDTO->ip,
                    $itemDTO->port,
                    $itemDTO->login,
                    $itemDTO->password
                );
            default:
                throw new \Exception("Format not found");
        }

    }

    private function toCSV(array $array): string
    {

        $csv = "";
        foreach ($array as $item) {
            $csv .= implode(",", $item);
            $csv .= PHP_EOL;
        }

        return $csv;
    }

}
