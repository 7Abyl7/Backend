<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "escuela";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// SI SE ENVÍA UN FORMULARIO CON MÉTODO POST (Insertar, Actualizar, Borrar)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $curso = $_POST['curso'];

    switch ($accion) {
        case 'insertar':
            $stmt = $conn->prepare("INSERT INTO alumnos (nombre, edad, curso) VALUES (?, ?, ?)");
            $stmt->bind_param("sis", $nombre, $edad, $curso);
            $stmt->execute();
            echo "Alumno insertado correctamente";
            break;
        case 'actualizar':
            if ($id) {
                $stmt = $conn->prepare("UPDATE alumnos SET nombre = ?, edad = ?, curso = ? WHERE id = ?");
                $stmt->bind_param("sisi", $nombre, $edad, $curso, $id);
                $stmt->execute();
                echo "Alumno actualizado correctamente";
            } else {
                echo "ID requerido para actualizar";
            }
            break;
        case 'borrar':
            if ($id) {
                $stmt = $conn->prepare("DELETE FROM alumnos WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                echo "Alumno borrado correctamente";
            } else {
                echo "ID requerido para borrar";
            }
            break;
    }
    // Añadimos un enlace para volver
    echo '<br><br><a href="pagina.html">Volver al formulario</a>';
    
// SI SE ENVÍA UN FORMULARIO CON MÉTODO GET (Ver Alumnos)
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    echo "<h1>Lista de Alumnos</h1>";
    
    $sql = "SELECT id, nombre, edad, curso FROM alumnos";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        
        while ($row = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<li> Id" . $row["id"] . "</td>";
            echo "<li>NOMBRE" . $row["nombre"] . "</td>";
            echo "<li>EDAD" . $row["edad"] . "</td>";
            echo "<li>CURSO" . $row["curso"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron alumnos en la base de datos.";
    }
    // Añadimos un enlace para volver
    
}

$conn->close();
?>