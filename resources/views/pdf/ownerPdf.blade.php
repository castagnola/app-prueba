<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
</head>

<body>
<h1 style="text-align: center; border: solid">Reporte de los Propietarios </h1>

<table border="1" style="border-collapse: collapse" bordercolor="#111111" width="100%" class="table table-hover">
    <thead>
    <tr style="text-align: center">
        <th style="border: solid">Identification</th>
        <th style="border: solid">First Name</th>
        <th style="border: solid">Second Name</th>
        <th style="border: solid">Last Name</th>
        <th style="border: solid">Address</th>
        <th style="border: solid">Phone numer</th>
        <th style="border: solid">City</th>
        <th style="border: solid">Cantidad de vehiculos</th>
        <th style="border: solid">Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($query as $value)
        <tr style="text-align: center; background-color: {{!$value->status ?'red':'none'}}">
            <td>{{$value->identification_number}}</td>
            <td>{{$value->first_name}}</td>
            <td>{{$value->second_name}} </td>
            <td>{{$value->last_name}} </td>
            <td>{{$value->address}} </td>
            <td>{{$value->phone_number}} </td>
            <td>{{$value->city->city_name}} </td>
            <td>{{count($value->vehicle)}} </td>
            <td>{{$value->status ?'ACTIVO':'DESACTIVADO'}} </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
