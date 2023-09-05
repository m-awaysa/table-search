<?php

namespace App\Http\Livewire;

use App\Models\Worksheet;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MyVer extends Component
{


    public $search;

    public function clear($searchTerm)
    {
        $from = [
            ['ا', 'أ', 'إ', 'آ'],
            'ة'
        ];
        $to = [
            'ا',
            'ه'
        ];

        for ($i = 0; $i < sizeOf($from); $i++) {
            $searchTerm = str_replace($from[$i], $to[$i], $searchTerm);
        }
        return $searchTerm;
    }

    public function books()
    {


        if (strlen($this->search) >= 3) {
            $searchTerm = $this->clear($this->search);

            // Perform the SQL query with a single search term
            $worksheets = DB::table('worksheet')
                ->selectRaw("CASE 
                    WHEN D LIKE '%$searchTerm%' THEN D 
                    ELSE REPLACE(REPLACE(REPLACE(REPLACE(D, 'أ', 'ا'), 'آ', 'ا'), 'إ', 'ا'), 'ة', 'ه')
                END AS original_name")
                ->select(['id','D'])
                ->orWhere('D', 'LIKE', '%' . $searchTerm . '%')
                ->paginate(30);
            return $worksheets;
        } else {
            return Worksheet::select(['D', 'id'])->paginate(15);
        }
    }


    public function render()
    {
        return view('livewire.my-ver', [
            'books' =>  $this->books()
        ]);
    }
}
