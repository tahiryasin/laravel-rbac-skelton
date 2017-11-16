<?php
/**
 * Override Yajra\Datatables\Engines\CollectionEngine
 * This is to allow filtering permission slugs see line#40
 */
namespace App\Overrides;

use Yajra\Datatables\Engines\CollectionEngine as YajraCollectionEngine;
use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Yajra\Datatables\Request;

class CollectionEngine extends YajraCollectionEngine
{

    /**
     * Perform global search.
     *
     * @return void
     */
    public function filtering()
    {
        $columns = $this->request['columns'];
        $this->collection = $this->collection->filter(
                function ($row) use ($columns) {
            $data = $this->serialize($row);
            $this->isFilterApplied = true;
            $found = [];

            $keyword = $this->request->keyword();
            foreach ($this->request->searchableColumnIndex() as $index) {
                $column = $this->getColumnName($index);
                if (!$value = Arr::get($data, $column)) {
                    continue;
                }
                
                if ($column == 'slug' && is_array($value)) {
                    $value = json_encode($value);
                }

                if ($this->isCaseInsensitive()) {
                    $found[] = Str::contains(Str::lower($value), Str::lower($keyword));
                } else {
                    $found[] = Str::contains($value, $keyword);
                }
            }

            return in_array(true, $found);
        }
        );
    }

}
