<div>
    <h1>INicio en Big Pig</h1>

    <x-card cardTitle='Card Title' cardTools='Card Tools' cardFooter='Card Footer'>
        <x-slot:cardTools>  
            <a href="#" class="btn btn-primary">Crear</a>
        </x-slot>
        
        <x-table>
            <x-slot:thead>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Acciones</th>
            </x-slot>


                <tr>
                    <td>Juan</td>
                    <td>Perez</td>
                    <td>pepe@elpepe.web</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-info">Editar</a>
                        <a href="#" class="btn btn-sm btn-danger">Eliminar</a>
                    </td>
                </tr>


        </x-table>

    </x-card>

</div>
