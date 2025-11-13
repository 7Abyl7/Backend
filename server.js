import express from "express";
import cors from "cors";
import connection from "./db.js";

const app = express();
app.use(cors());
app.use(express.json());

// Crear alumnos (POST)
app.post("/api/alumnos", (req, res) => {
    const { nombre, edad, curso } = req.body;
    const sql = "INSERT INTO alumnos (nombre, edad, curso) VALUES (?, ?, ?)";
    connection.query(sql, [nombre, edad, curso], (error, results) => {
        if (error) return res.status(500).json({ error: error });
        res.json({ message: "Alumno agregado correctamente", id: results.insertId });
    });
});

// Lista (GET)
app.get("/api/alumnos", (req, res) => {
    connection.query("SELECT * FROM alumnos", (error, results) => {
        if (error) return res.status(500).json({ error: error });
        res.json(results);
    });
});

// Agregar /public
app.use(express.static("public"));
// Puerto del servidor
const PORT = 3000;
app.listen(PORT, () => {
    console.log(`Servidor corriendo en http://localhost:${PORT}`);
});