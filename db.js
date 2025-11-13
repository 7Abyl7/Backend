import mysql from "mysql2";
const connection = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "escuela"
});

connection.connect((error) => {
    if (error) {
        console.error("Error al conectar", error);
    } else {
        console.log("Conexión exitosa");
    }
});

export default connection;