<?php

declare(strict_types=1);


namespace App\Integration;


class StubDataProvider implements DataProviderInterface
{
    public function get(string $record, ?array $data = null): array
    {
        $data = [
            'lessons' => [
                'category' => [
                    'stub' => 'fakeData',
                    'fakeStub' => 'dataFake'
                ]
            ]
        ];

        return $data;
    }

}