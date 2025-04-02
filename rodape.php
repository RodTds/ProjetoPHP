

</main>
     <!-- Script do SweetAlert2 -->

<!-- Script para SweetAlert -->
<script>
        document.getElementById('btnSair').addEventListener('click', function(event) {
            event.preventDefault(); // Impede o link de ser acionado diretamente

            // Exibe o SweetAlert2 para confirmação de saída
            Swal.fire({
                title: 'Tem certeza que deseja sair?',
                text: "Você será desconectado!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, sair!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Se confirmado, redireciona para a página de logout (sair.php)
                    window.location.href = 'sair.php'; // Redireciona para sair.php onde o logout é feito
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>