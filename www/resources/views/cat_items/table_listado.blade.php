<table class="table table-responsive" id="catItems-table">
    <thead>
        <tr>
            <th>#</th>
        <th>Descripción</th>

    </thead>
    <tbody>
    @php
        $fila=1;
    @endphp
    @foreach($catItems as $id=>$txt)
        <tr>
            <td>{!! $fila++ !!}</td>
            <td>{!! $txt !!}</td>

        </tr>
    @endforeach
    </tbody>
</table>