<?php

namespace Tests\Unit;

use App\Service\Providers\AbstractProviderService;
use PHPUnit\Framework\TestCase;

class AbstractProviderServiceTest extends TestCase
{

    public function testGetNotEmptyList(): void
    {

        $abstractProviderService = new AbstractProviderService();
        $list = $abstractProviderService->getList();

        $this->assertIsArray($list);
        $this->assertNotEmpty($list);

    }

    public function testGetValidProxyItem(): void
    {

        $abstractProviderService = new AbstractProviderService();
        $list = $abstractProviderService->getList();

        $item = $list[0];
        $this->assertNotEmpty($item->password);
        $this->assertNotEmpty($item->login);
        $this->assertTrue($item->port > 0);
        $this->assertTrue($item->port <= 65535);
        $this->assertMatchesRegularExpression('/^((25[0-5]|(2[0-4]|1\d|[1-9]|)\d)\.?\b){4}$/', $item->ip);

    }


}
