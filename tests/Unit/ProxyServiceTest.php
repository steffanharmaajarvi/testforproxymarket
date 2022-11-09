<?php

namespace Tests\Unit;

use App\Service\Providers\AbstractProviderService;
use App\Service\ProxyService;
use PHPUnit\Framework\TestCase;

class ProxyServiceTest extends TestCase
{

    public function testShouldnotGetCSVInDisallowedFormats(): void
    {

        $proxyService = new ProxyService();
        $abstractProviderService = new AbstractProviderService();

        $this->expectException(\Exception::class);

        $list = $abstractProviderService->getList();

        $csv = $proxyService->export(
            $list,
            "werrre"
        );

    }

    public function testGetCSVInAllowedFormats(): void
    {

        $proxyService = new ProxyService();
        $abstractProviderService = new AbstractProviderService();

        $list = $abstractProviderService->getList();

        $csv = $proxyService->export(
            $list,
            ProxyService::IP_PORT_LOGIN_PASSWORD_FORMAT
        );

        $newList = explode(PHP_EOL, $csv);
        $newList = array_filter($newList, function ($item) {
            return strlen($item) > 0;
        });

        $this->assertSameSize($list, $newList);

    }

    public function testGetCSVInIPPortLoginPasswordFormat(): void
    {

        $proxyService = new ProxyService();
        $abstractProviderService = new AbstractProviderService();

        $list = $abstractProviderService->getList();

        $csv = $proxyService->export(
            $list,
            ProxyService::IP_PORT_LOGIN_PASSWORD_FORMAT
        );

        $newList = explode(PHP_EOL, $csv);
        $item = $newList[0];

        $this->assertMatchesRegularExpression("/((25[0-5]|(2[0-4]|1\d|[1-9]|)\d)\.?\b){4}\:[0-9]{1,5}\@[\w]+\:[\w]+/", $item);

    }


    public function testGetCSVInIPFormat(): void
    {

        $proxyService = new ProxyService();
        $abstractProviderService = new AbstractProviderService();

        $list = $abstractProviderService->getList();

        $csv = $proxyService->export(
            $list,
            ProxyService::IP_FORMAT
        );

        $newList = explode(PHP_EOL, $csv);
        $item = $newList[0];

        $this->assertMatchesRegularExpression("/^((25[0-5]|(2[0-4]|1\d|[1-9]|)\d)\.?\b){4}$/", $item);

    }


    public function testGetCSVInIPPortFormat(): void
    {

        $proxyService = new ProxyService();
        $abstractProviderService = new AbstractProviderService();

        $list = $abstractProviderService->getList();

        $csv = $proxyService->export(
            $list,
            ProxyService::IP_PORT_FORMAT
        );

        $newList = explode(PHP_EOL, $csv);
        $item = $newList[0];

        $this->assertMatchesRegularExpression("/((25[0-5]|(2[0-4]|1\d|[1-9]|)\d)\.?\b){4}\:[0-9]{1,5}/", $item);

    }

    public function testGetCSVInIPLoginPasswordFormat(): void
    {
        $proxyService = new ProxyService();
        $abstractProviderService = new AbstractProviderService();

        $list = $abstractProviderService->getList();

        $csv = $proxyService->export(
            $list,
            ProxyService::IP_LOGIN_PASSWORD_FORMAT
        );

        $newList = explode(PHP_EOL, $csv);
        $item = $newList[0];

        $this->assertMatchesRegularExpression("/((25[0-5]|(2[0-4]|1\d|[1-9]|)\d)\.?\b){4}\@[\w]+\:[\w]+/", $item);

    }

}
