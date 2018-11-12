<?php
namespace App\Traits;

trait Sortable
{
    public function scopeOrderByRequest($query, $request, $col = 'id', $alias = [])
    {
        $direction = "asc";
        if ($request->has('direction') && $request->get('direction')=="up") {
            $direction = "asc";
        } elseif ($request->has('direction') && $request->get('direction')=="down") {
            $direction = "desc";
        }
        if ($request->has('sort') && $request->get('sort')!="id") {
            $sort_col  = $request->get('sort');

            if (isset($alias[$sort_col])) {
                $col = $alias[$sort_col];
            } else {
                $col = $sort_col;
            }
        }
        $query = $this->getSubquery($query, $col, $direction);
        return $query;
    }

    public function getSubquery($query, $col, $direction)
    {

        $isRel = is_array($col);
        $t1_tablename = $query->getModel()->getTable();
        $t2_alias = "t2";

        if ($isRel) {
            if (isset($col['via_table'])) {
                $foreign_table = $col['foreign_table'];
                $via_table = $col['via_table'];
                $via_attr1 = $col['via_attributes'][0];
                $via_attr2 = $col['via_attributes'][1];
                return $query->leftJoin($via_table, "$t1_tablename.id", '=', "$via_table.$via_attr1")
                    ->leftJoin($foreign_table, "$via_table.$via_attr2", '=', "$foreign_table.id")
                    ->groupBy("$t1_tablename.id")
                    ->orderBy($foreign_table . '.' . $col['sorting_col'], $direction)
                    ->select($t1_tablename.".*");
            }

            return $query->leftJoin($col['foreign_table'].' as '.$t2_alias, $t2_alias.'.id', '=', $t1_tablename.'.'.$col['foreign_key'])
                ->orderBy($t2_alias . '.' . $col['sorting_col'], $direction)
                ->select($t1_tablename.".*");
        }

        return $query->orderBy($col, $direction);
    }

    public function getViaSubquery($query, $col, $direction)
    {
    }
}
