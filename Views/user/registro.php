<h1>Registro de usuarios</h1>

<form action="index.php?controller=user&action=save" method="POST">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" required>
    <br>
    <label for="apellidos">Apellidos</label>
    <input type="text" name="apellidos" required>
    <br>
    <label for="email">Email</label>
    <input type="email" name="email" required>
    <br>
    <label for="password">Contraseña</label>
    <input type="password" name="password" required>
    <br>
    <input type="submit" value="Registrarse">

</form>