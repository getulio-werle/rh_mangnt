<div class="card p-5 shadow">
    <h5 class="text-center">{{ $title }}</h5>
    <table>
    @foreach ($collection as $item)
        <tr>
            <td>{{ $item['department'] }}</td>  
            <td class="text-end"><strong>{{ $item['total'] }}</strong></td>  
        </tr>
    @endforeach
    </table>
</div>