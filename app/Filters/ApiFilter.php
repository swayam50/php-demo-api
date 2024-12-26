<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter 
{
    protected $safeParams = [];

    protected $columnMap = [
        'postalCode' => 'postal_code'
    ];

    protected $operatorMap = [];

    public function transform (Request $request) 
    {
        $eloquentQuery = [];

        foreach ($this->safeParams as $param => $operators) {
            $query = $request->query($param);

            if (!isset($query))
                continue;

            $column = $this->columnMap[$param] ?? $param;

            foreach ($operators as $operator) {
                if (isset($query[$operator]))
                    $eloquentQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
            }
        }

        return $eloquentQuery;
    }
}