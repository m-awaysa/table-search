<?php

namespace App\Http\Livewire;

use App\Models\Worksheet;
use Livewire\Component;

class BooksLiveShortest extends Component
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
            $searchTerm=$this->clear($this->search);
            $books = Worksheet::where(function ($query) use ($searchTerm) {
                $searchTerm = $this->clear($this->search);
                
                $pattern = explode(' ', $searchTerm);

                foreach ($pattern as $word) {
                    $query = $query->where('I', 'like', '%' . $word . '%');
                }
                return  $query;
            })->get();


            $sortedWorksheets = $books->sortBy(function ($worksheet) use ($searchTerm) {

                $similarity = similar_text($worksheet->I, $searchTerm);

                $score = 0;
                if (str_starts_with($worksheet->I, $searchTerm)) {
                    $score -= 10; // Add a high value to prioritize exact matches
                }
                $score -= $similarity;
                $score += strlen($worksheet->I);

                return $score;
            });

            return $sortedWorksheets;
        } else return Worksheet::select(['D', 'id'])->paginate(15);
    }

    public function render()
    {
        return view('livewire.books-live-shortest', [
            'books' =>  $this->books()
        ]);
    }
}
