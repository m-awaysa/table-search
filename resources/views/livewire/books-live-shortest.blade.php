<div>
    <div class='maflex'>
        <input wire:model='search' type="text">
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">name</th>
            </tr>
        </thead>
        <tbody>
            @if ($books != null)

            @foreach ($books as $book )
            <tr>
                <th scope="row">{{$book ->id}}</th>
                <td>{{$book->D}}</td>
            </tr>
            @endforeach
            @else
            @endif
        </tbody>
    </table>
</div>