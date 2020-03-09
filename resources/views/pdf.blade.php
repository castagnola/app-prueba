<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <title>Reporte</title>
</head>

<body>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Placa</th>
        <th>Marca</th>
        <th>Nombre Conductor</th>
        <th>Nombre Propietario</th>
    </tr>
    </thead>
    <tbody>
    @foreach($query as $value)
        <tr >
            <td>{{$value->placa}}</td>
            <td>{{$value->brand}}</td>
            <td>{{$value->driver->first_name. " ". $value->driver->last_name}} </td>
            <td>{{$value->owner->first_name. " ". $value->owner->last_name}}</td>
    </tr>
    @endforeach

    </tbody>
</table>
</body>

</html>
