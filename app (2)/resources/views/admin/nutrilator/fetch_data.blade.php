<table class="table table-bordered">
<thead>
    <tr>
        <th>Title</th>
        <th>Description</th>          
    </tr>
</thead>
<tbody>
    @foreach ($items as $item)
    <tr>
        <td>{{ $item->name }}</td>
        <td>{{ $item->name }}</td>
    </tr>
    @endforeach
</tbody>
</table>


{!! $items->render() !!}