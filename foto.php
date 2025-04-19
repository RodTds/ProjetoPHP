<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Sistema ONG</a>

    <div class="d-flex align-items-center ms-auto">
      <!-- Imagem do usuário -->
      <img src="img/usuario.png" alt="Usuário" width="32" height="32" class="rounded-circle me-2">

      <!-- Nome do usuário (vindo da sessão, por exemplo) -->
      <span class="text-white fw-bold">
        <?php echo $_SESSION['usuario'] ?? 'Visitante'; ?>
      </span>
    </div>
  </div>
</nav>
