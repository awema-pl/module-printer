<?php

namespace AwemaPL\Printer\Sections\Printers\Scopes;
use AwemaPL\Repository\Scopes\ScopeAbstract;

class SearchPrinter extends ScopeAbstract
{
    /**
     * Scope
     *
     * @param $builder
     * @param $value
     * @param $scope
     * @return mixed
     */
    public function scope($builder, $value, $scope)
    {
        if (!$value){
            return $builder;
        }

        return $builder->whereHas('printable', function($query) use (&$value){
            $query->where('name', 'like', '%'.$value.'%');
        });
    }
}
