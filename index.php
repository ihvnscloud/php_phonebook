<?php
include 'db_connection.php';
include 'contacto.php';
include 'agenda.php';

/*se hace la conexion con la base
de datos y se crea una instancia*/
$conn = OpenCon();
$agenda = new Agenda();

/*se verifica si se enviaron los campos de los 
formularios, se obtienen los valores y se llaman
a los respectivos metodos de la clase agenda*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['phone'])) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $result = $agenda->registrarContacto($name, $phone);
    } elseif (isset($_POST['search-name'])) {
        $searchName = $_POST['search-name'];
        $searchResult = $agenda->buscarContacto($searchName);
    } elseif (isset($_POST['delete-id'])) {
        $deleteId = $_POST['delete-id'];
        $result = $agenda->eliminarContacto($deleteId);
    }
}

/*se llama a listarcontactos de la clase
agenda para tener la lista de contactos.
se cierra la conexion de la base de datos*/
$contactos = $agenda->listarContactos();
CloseCon($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agenda Telefónica</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Agenda Telefónica</h1>
        
        <!--registro del contacto-->
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Nombre" required>
            <input type="text" name="phone" placeholder="Número de teléfono" required>
            <div class="boton-registro">
                <button type="submit">Registrar Contacto</button>
            </div>
        </form>

        <!--se verifica si se ha establecido la
        variable y muestra el resultado-->
        <?php if (isset($result)) { ?>
            <p><?php echo $result; ?></p>
        <?php } ?>
        
        <!--busqueda del contacto-->
        <div class="busqueda">
            <form method="POST" action="">
                <div class="search-container">
                    <input type="text" name="search-name" placeholder="Buscar contacto" required>
                    <button type="submit">Buscar</button>
                </div>
            </form>

            <!--se verifica si se ha establecido la variable y si es un objeto-->
            <?php if (isset($searchResult) && is_object($searchResult)) { ?>
                
                <!--listado de contactos resultante de la busqueda-->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Número</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                <!--muestra el nombre y numero del contacto-->
                                <td><?php echo $searchResult->getNombre(); ?></td>
                                <td><?php echo $searchResult->getNumero(); ?></td>
                                <td>
                                    <form method='POST' action=''>

                                        <!--se envia el id del contacto que se desea eliminar-->
                                        <input type='hidden' name='delete-id' 
                                        value='<?php echo $searchResult->getId(); ?>'>
                                        
                                        <button type='submit' title='Eliminar Contacto'
                                        onclick='return confirm(\"¿Estás seguro que deseas eliminar a este contacto?\")'>Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            <!--si no se encontro el contacto muestra un mensaje-->
            <?php } elseif (isset($searchResult)) { ?>
                <p><?php echo $searchResult; ?></p>
            <?php } ?>
        </div>

        <!--listado de contactos-->
        <h3>Lista de Contactos</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Número</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <!--verifica si la variable contactos es un array.
                    se imprime cada registro y si no hay ninguno se
                    muestra un mensaje-->
                    <?php
                    if (is_array($contactos)) {
                        foreach ($contactos as $contacto) {
                            echo "<tr>";
                            echo "<td>" . $contacto->getNombre() . "</td>";
                            echo "<td>" . $contacto->getNumero() . "</td>";
                            echo "<td>
                                    <form method='POST' action=''>
                                        
                                        <!--se envia el id del contacto que se desea eliminar-->
                                        <input type='hidden' name='delete-id'
                                        value='" . $contacto->getId() . "'>

                                        <button type='submit' title='Eliminar Contacto'
                                        onclick='return confirm(\"¿Estás seguro que deseas eliminar a este contacto?\")'>Eliminar</button>
                                    </form>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>" . $contactos . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>