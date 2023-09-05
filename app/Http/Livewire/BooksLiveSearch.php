<?php

namespace App\Http\Livewire;

use App\Models\Worksheet;
use Livewire\Component;

class BooksLiveSearch extends Component
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

            $books = Worksheet::where(function ($query) use ($searchTerm) {
                $pattern = explode(' ', $searchTerm);
                foreach ($pattern as $word) {
                    $query = $query->where('I', 'like', '%' . $word . '%');
                }
                return  $query;
            })->get();


            $sortedWorksheets = $books->sortByDesc(function ($query) use ($searchTerm) {
                $similarity = similar_text($query->I, $searchTerm);

                if (str_starts_with($query->I, $searchTerm)) {
                    return 1000 + $similarity;
                } else {
                    return $similarity;
                }
            });

            return $sortedWorksheets;

        } else return Worksheet::select(['D', 'id'])->paginate(15);
    }

    public function render()
    {

        return view('livewire.books-live-search', [
            'books' =>  $this->books()
        ]);
    }
}
